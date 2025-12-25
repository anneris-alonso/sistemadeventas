<?php
include('../../config.php'); // Or the correct absolute path if you moved it
session_start();


// Input validation (using $_POST, not $_GET)
if (!isset($_POST['id_servicio'],$_POST['precio_de_compra'], $_POST['servicio'], $_POST['tipo'], $_POST['precio_serv'], $_POST['duracion'], $_POST['impuesto'], $_POST['ganancias']) || !is_numeric($_POST['id_servicio'])) {  // Correctly check for required $_POST fields

    die("Datos de formulario incompletos o ID de servicio inválido."); // Do not continue
}


// Get data from $_POST
$id_servicio = $_POST['id_servicio'];
$servicio = $_POST['servicio'];
$tipo = $_POST['tipo'];
$precio_de_compra = $_POST['precio_de_compra'];
$precio_serv = $_POST['precio_serv'];
$duracion = $_POST['duracion'];
$impuesto = isset($_POST['impuesto']) ? $_POST['impuesto'] : "0.00"; // Get the impuesto or default to 0%
$ganancias = $_POST['ganancias'];

// Calculate precio_final
$precio_serv = floatval($precio_serv);
$impuesto = floatval($impuesto);
$precio_final = $precio_serv + ($precio_serv * ($impuesto / 100));
$ganancias = $precio_serv - $precio_de_compra;

// Validate the business ID - ESSENTIAL SECURITY CHECK
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    die("Error: ID de negocio no válido.");
}
$id_negocios = $_SESSION['negocio_id'];



try {
    // Prepare the statement - add the business ID condition to prevent unauthorized updates!
    $sentencia = $pdo->prepare("UPDATE tb_servicios SET servicio = :servicio, tipo = :tipo,precio_de_compra = :precio_de_compra, precio_serv = :precio_serv, duracion = :duracion, impuesto = :impuesto, precio_final = :precio_final, ganancias = :ganancias WHERE id_servicios = :id_servicio AND id_negocios = :id_negocios");

    // Bind parameters using named placeholders
    $sentencia->bindParam(':servicio', $servicio);
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':precio_serv', $precio_serv);
    $sentencia->bindParam(':precio_de_compra', $precio_de_compra);
    $sentencia->bindParam(':duracion', $duracion);
    $sentencia->bindParam(':impuesto', $impuesto);
    $sentencia->bindParam(':precio_final', $precio_final);
    $sentencia->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT);
    $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
    $sentencia->bindParam(':ganancias', $ganancias);



    if ($sentencia->execute()) {
        // Provide feedback
        if ($sentencia->rowCount() > 0) {
            // Rows were updated
            $_SESSION['mensaje'] = "El servicio se actualizó correctamente.";
            $_SESSION['icono'] = "success";
        } else {
            // No rows updated, likely due to wrong id or no changes made
            $_SESSION['mensaje'] = "No se actualizó el servicio. ID incorrecto o no se hicieron cambios.";
            $_SESSION['icono'] = "warning"; // Or "info"
        }

    } else {
        $_SESSION['mensaje'] = "Error al actualizar: " . implode(', ', $sentencia->errorInfo()); // Detailed error message
        $_SESSION['icono'] = "error"; // Correct icon

    }

    header('Location: ' . $URL . '/servicios/'); // Redirect to the service listing page
    exit();  // VERY IMPORTANT: Stop further execution after redirect

} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error en la base de datos: " . $e->getMessage(); // Or a more user-friendly message
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/servicios/'); // Redirect on error
    exit(); // Important


}


?>

