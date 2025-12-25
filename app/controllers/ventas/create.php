<?php
include ('../../config.php');

// Get the business ID from the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$id_negocios = $_SESSION['negocio_id'];


// Get data from the AJAX request
$id_producto = $_GET['id_producto'];
$nro_venta = $_GET['nro_venta'];
$fecha_venta = $_GET['fecha_venta'];
$id_clients = $_GET['id_clients']; // Assuming this is the client ID
$comprobante = $_GET['comprobante'];
$id_usuario = $_GET['id_usuario']; // Assuming you have a way to get this
$precio_venta_controlador = $_GET['precio_venta_controlador']; // Total sale price
$cantidad_venta = $_GET['cantidad_venta'];

// Calculate stock restante (you should already be doing this in JavaScript, but just to be sure):
$stmt = $pdo->prepare("SELECT stock FROM tb_almacen WHERE id_producto = :id_producto AND id_negocios = :id_negocios"); //Make sure id_negocios in tb_almacen is added
$stmt->execute([':id_producto' => $id_producto, ':id_negocios' => $id_negocios]); // Add business ID to query
$stock_actual = $stmt->fetchColumn();
$stock_restante = $stock_actual - $cantidad_venta;

try {
    $pdo->beginTransaction(); // Start a transaction

    // Insert sale into tb_ventas
    $stmt = $pdo->prepare("INSERT INTO tb_ventas (id_producto, nro_venta, fecha_venta, id_clients, comprobante, id_usuario, precio_venta, cantidad, id_negocios) 
                           VALUES (:id_producto, :nro_venta, :fecha_venta, :id_clients, :comprobante, :id_usuario, :precio_venta, :cantidad, :id_negocios)"); //Added id_negocios to sales table

    $stmt->execute([
        ':id_producto' => $id_producto,
        ':nro_venta' => $nro_venta,
        ':fecha_venta' => $fecha_venta,
        ':id_clients' => $id_clients,
        ':comprobante' => $comprobante,
        ':id_usuario' => $id_usuario,
        ':precio_venta' => $precio_venta_controlador, // Total sale price
        ':cantidad' => $cantidad_venta,
         ':id_negocios' => $id_negocios // Include business ID in insert
    ]);

    // Update product stock in tb_almacen
    $stmt = $pdo->prepare("UPDATE tb_almacen SET stock = :stock_restante WHERE id_producto = :id_producto  AND id_negocios = :id_negocios"); //Add id_negocios to tb_almacen
    $stmt->execute([':stock_restante' => $stock_restante, ':id_producto' => $id_producto, ':id_negocios' => $id_negocios]);//add id_negocios

    $pdo->commit(); // Commit the transaction

    echo "Venta registrada correctamente."; // Send a success message back to the AJAX call

} catch (PDOException $e) {
    $pdo->rollBack(); // Roll back the transaction if there's an error
    echo "Error al registrar la venta: " . $e->getMessage(); // Send an error message
}
?>
