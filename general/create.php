<?php
// Enable error reporting (FOR DEVELOPMENT ONLY - REMOVE IN PRODUCTION!)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../../../app/config.php'; // Adjust path - BEST: __DIR__ . '/../../../app/config.php'

// Start session (if not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- INTENTIONALLY REMOVED: SESSION VALIDATION ---
// This is INSECURE.  Anyone can register losses.

// Get id_usuario and id_negocios from SESSION (they might be NULL).
$id_negocios = $_SESSION['negocio_id'] ?? null;  // Allows for null
$id_usuario = $_SESSION['id_usuario'] ?? null;    // Allows for null

// --- DEBUGGING: Check Session (Uncomment to use) ---
// echo "Session Variables:<br>";
// var_dump($_SESSION);
// echo "id_negocios: " . var_export($id_negocios, true) . "<br>";
// echo "id_usuario: " . var_export($id_usuario, true) . "<br>";
// die();


$errors = [];

// CSRF Protection (Essential! Keep this!)
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $errors[] = "Invalid request.  Please try again.";
    error_log("CSRF token mismatch in create.php"); // Log this!
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)) {
    // Input validation and sanitization.  Even without login, we STILL
    // validate and sanitize data from the FORM.
    $id_producto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
    if ($id_producto === false || $id_producto === null) {
        $errors[] = "Invalid product ID.";
        error_log("Invalid product ID: " . var_export($_POST['id_producto'], true));
    }

    $motivo_baja = filter_input(INPUT_POST, 'motivo_baja', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (empty($motivo_baja)) {
        $errors[] = "Reason for loss is required.";
        error_log("Missing motivo_baja");
    }

    $fecha_baja = filter_input(INPUT_POST, 'fecha_baja', FILTER_SANITIZE_STRING); //Keep as string
    try {
        $fecha_baja_obj = new DateTime($fecha_baja);
        $fecha_baja_formatted = $fecha_baja_obj->format('Y-m-d');
    } catch (Exception $e) {
        $errors[] = "Invalid loss date.";
        error_log("Invalid date format: " . var_export($fecha_baja, true));
        $fecha_baja_formatted = null;
    }

    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
    if ($cantidad === false || $cantidad === null || $cantidad < 1) {
        $errors[] = "Invalid quantity.";
        error_log("Invalid quantity: " . var_export($_POST['cantidad'], true));
    }

    if (empty($errors)) {
        try {
            $pdo->beginTransaction(); // Start transaction

              // --- Check Available Stock ---
            $stock_stmt = $pdo->prepare("SELECT stock FROM tb_almacen WHERE id_producto = :id_producto AND id_negocios = :id_negocios");
            $stock_stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
            //Bind param id_negocios: If id_negocios is null, this query will return 0 results.
            if ($id_negocios !== null) {
                $stock_stmt->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
            } else {
                // CRITICAL: Handle the null case! Throwing exception.
                error_log("id_negocios is NULL in stock check.  Preventing query execution.");
                throw new Exception('id_negocios is not set.  Cannot check stock.');
            }
            $stock_stmt->execute();
            $stock_result = $stock_stmt->fetch(PDO::FETCH_ASSOC);

            if ($stock_result && $stock_result['stock'] >= $cantidad) {
                // Enough stock
                // --- INSERT into tb_perdidas ---
                // Corrected column order!  Matches your database table.
                $stmt = $pdo->prepare("INSERT INTO tb_perdidas (id_producto, id_usuario, motivo_baja, fecha_baja, id_negocios, cantidad)
                                    VALUES (:id_producto, :id_usuario, :motivo_baja, :fecha_baja, :id_negocios, :cantidad)");

                // Bind parameters (allowing for NULL id_usuario and id_negocios)
                $stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
                $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);   // Can be NULL
                $stmt->bindParam(':motivo_baja', $motivo_baja);
                $stmt->bindParam(':fecha_baja', $fecha_baja_formatted);
                $stmt->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT); // Can be NULL
                $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);


                if (!$stmt->execute()) {
                    $errorInfo = $stmt->errorInfo();
                    error_log("Database error (INSERT): " . $errorInfo[2]);
                    throw new Exception("Failed to insert into tb_perdidas");
                }

                // --- UPDATE tb_almacen ---
                $update_stmt = $pdo->prepare("UPDATE tb_almacen SET stock = stock - :cantidad WHERE id_producto = :id_producto AND id_negocios = :id_negocios");
                $update_stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $update_stmt->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);

                // *** Handle Potentially NULL id_negocios ***
                if ($id_negocios !== null) {
                    $update_stmt->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
                } else {
                     // CRITICAL: Decide how to handle this. Throwing exception.
                    error_log("id_negocios is NULL in stock update. Preventing query execution.");
                    throw new Exception('id_negocios is not set.  Cannot update stock.');
                }

                if (!$update_stmt->execute()) {
                    $errorInfo = $update_stmt->errorInfo();
                    error_log("Database error (UPDATE): " . $errorInfo[2]);
                    throw new Exception("Failed to update tb_almacen");
                }

                $pdo->commit(); // Commit transaction

                $_SESSION['success_message'] = "Loss registered successfully.";
                header("Location: $URL/almacen/");
                exit;
            } else {
               //Not enough stock
               $errors[] = "Not enough stock available. Current stock: " . ($stock_result ? $stock_result['stock'] : '0');
               $_SESSION['errors'] = $errors;
               $_SESSION['form_data'] = $_POST;
               header("Location: $URL/almacen/");
               exit;

            }
        } catch (Exception $e) {
            $pdo->rollBack();  // Rollback transaction
            error_log("General Error in create.php: " . $e->getMessage()); // Log detailed error
            $_SESSION['error_message'] = "An error occurred. Please try again later.";
            header("Location: $URL/almacen/");
            exit;
        }
    } else {
        // Validation errors
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST; // Repopulate form
        header("Location: $URL/almacen/");  // Use $URL!
        exit;
    }
} else {
    // Not a POST request or CSRF error
    header("Location: $URL/almacen/");  // Use $URL!
    exit;
}
?>