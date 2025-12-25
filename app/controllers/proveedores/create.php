<?php
include('../../config.php');

session_start();  // Start the session *once* at the beginning

// Check if the required POST data is available and not empty.
if (!isset($_POST['nombre_proveedor'], $_POST['celular'], $_POST['empresa'], $_POST['email'], $_POST['direccion']) ||
    empty($_POST['nombre_proveedor']) || empty($_POST['celular']) || empty($_POST['empresa']) || empty($_POST['email']) || empty($_POST['direccion'])) {
    // Handle missing or empty required fields
    $_SESSION['mensaje'] = "Error al crear proveedor: Faltan campos obligatorios.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/proveedores/create.php');
    exit();
}


// Validate and sanitize data - adjust as needed for your data types
$nombre_proveedor = $_POST['nombre_proveedor'];
$celular = $_POST['celular'];
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;  // Optional field
$empresa = $_POST['empresa'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];

// Get and validate the business ID from the session
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    die("Error: ID de negocio no válido.");
}
$id_negocios = $_SESSION['negocio_id'];



try {
    $sentencia = $pdo->prepare("INSERT INTO tb_proveedores (nombre_proveedor, celular, telefono, empresa, email, direccion, fyh_creacion, id_negocios) 
                                VALUES (:nombre_proveedor, :celular, :telefono, :empresa, :email, :direccion, :fyh_creacion, :id_negocios)"); // Include id_negocios

    // Bind parameters using $_POST values, not $_GET
    $sentencia->bindParam(':nombre_proveedor', $nombre_proveedor);
    $sentencia->bindParam(':celular', $celular);
    $sentencia->bindParam(':telefono', $telefono);
    $sentencia->bindParam(':empresa', $empresa);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':direccion', $direccion);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);
    $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);  // *Essential* to include id_negocios!

    if ($sentencia->execute()) {
        $_SESSION['mensaje'] = "Se registró al proveedor de la manera correcta";
        $_SESSION['icono'] = "success";
        header('Location: ' . $URL . '/proveedores/'); // Redirect to provider listing page
        exit();  // Important
    } else {

        $_SESSION['mensaje'] = "Error al registrar al proveedor: " . implode(", ", $sentencia->errorInfo()); // Detailed error message
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/proveedores/create.php');  // Correct path. Redirect back to form to fix errors
        exit(); // Important: terminate after redirect
    }

} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error en la base de datos: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/proveedores/create.php');
    exit(); // Important
}

?>
