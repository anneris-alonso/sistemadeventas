<?php
// app/controllers/servicios/update_servicios.php
include('../../config.php');
session_start();

// Sanitize and validate the inputs - ESSENTIAL!
$id_servicio = isset($_POST['id_servicio']) && is_numeric($_POST['id_servicio']) ? intval($_POST['id_servicio']) : null;
$id_negocios = isset($_SESSION['negocio_id']) && is_numeric($_SESSION['negocio_id']) ? intval($_SESSION['negocio_id']) : null;
$servicio = isset($_POST['servicio']) ? trim($_POST['servicio']) : '';
$tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';
$precio_de_compra = isset($_POST['precio_de_compra']) && is_numeric($_POST['precio_de_compra']) ? floatval($_POST['precio_de_compra']) : null;
$precio_serv = isset($_POST['precio_serv']) && is_numeric($_POST['precio_serv']) ? floatval($_POST['precio_serv']) : null;
$duracion = isset($_POST['duracion']) ? trim($_POST['duracion']) : '';
$impuesto = isset($_POST['impuesto']) && is_numeric($_POST['impuesto']) ? floatval($_POST['impuesto']) : 0.00;
$duracion = isset($_POST['ganancias']) ? trim($_POST['ganancias']) : '';

// Perform validations
if ($id_servicio === null || $id_negocios === null || empty($servicio) || empty($tipo) || $precio_serv === null) {
    $_SESSION['mensaje'] = "Error: Datos del servicio inválidos.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/servicios/');
    exit();
}
if($precio_serv < 0 || $impuesto < 0){
    $_SESSION['mensaje'] = "Error: El precio y el impuesto no pueden ser negativos.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/servicios/');
    exit();
}

// Calculate precio_final
$precio_final = $precio_serv + ($precio_serv * ($impuesto / 100));

try {
    // Prepare the statement - add the business ID condition to prevent unauthorized updates!
    $sentencia = $pdo->prepare("UPDATE tb_servicios SET servicio = :servicio, tipo = :tipo, precio_de_compra = :precio_de_compra, precio_serv = :precio_serv, duracion = :duracion, impuesto = :impuesto, precio_final = :precio_final, ganancias = :ganancias WHERE id_servicios = :id_servicio AND id_negocios = :id_negocios");

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


    if ($sentencia->execute()) {
        $_SESSION['mensaje'] = "El servicio se actualizó correctamente.";
        $_SESSION['icono'] = "success";
    } else {
        // If no rows were affected, it means the ID or id_negocios was incorrect
        $_SESSION['mensaje'] = "No se pudo actualizar el servicio: " . implode(", ", $sentencia->errorInfo());
        $_SESSION['icono'] = "warning";
    }

    header('Location: ' . $URL . '/servicios/'); // Redirect to the services list
    exit();
} catch (PDOException $e) {
    // Log the error
    error_log("Error updating service: " . $e->getMessage());

    $_SESSION['mensaje'] = "Error al actualizar el servicio.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/servicios/'); // Redirect with error message
    exit();
}
?>
