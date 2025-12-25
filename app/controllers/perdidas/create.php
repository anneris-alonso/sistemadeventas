<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 18/1/2023
 * Time: 15:39
 */

include ('../../config.php');

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validar el ID del negocio
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"]; 
} else {
    // Manejar el error si el ID del negocio no es válido
    die("Error: ID de negocio inválido."); 
}

// Validar y obtener los datos del formulario
$id_producto = isset($_POST['id_producto']) ? $_POST['id_producto'] : "";
$id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : "";
$motivo_baja = isset($_POST['motivo_baja']) ? $_POST['motivo_baja'] : "";
$fecha_baja = isset($_POST['fecha_baja']) ? $_POST['fecha_baja'] : "";
$id_negocios = isset($_POST['id_negocios']) ? $_POST['id_negocios'] : "";
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : "";
  

// Validar que los campos no estén vacíos
if (empty($id_producto) || empty($motivo_baja) || empty($fecha_baja) || empty($cantidad)) {
    echo "<script>
            alert('Error: Debe llenar los campos obligatorios.');
            window.location.href = '".$URL."/perdidas/create.php'; 
          </script>";
    exit(); // Detener la ejecución del script si hay un error
}

try {
    $sentencia = $pdo->prepare("INSERT INTO tb_perdida (id_producto, id_usuario, motivo_baja, fecha_baja, id_negocios, cantidad) 
                                VALUES (:id_producto, :id_usuario, :motivo_baja, :fecha_baja, :id_negocios, :cantidad)");

    $sentencia->bindParam('id_producto', $id_producto);
    $sentencia->bindParam('id_usuario', $id_usuario);
    $sentencia->bindParam('motivo_baja', $motivo_baja);
    $sentencia->bindParam('fecha_baja', $fecha_baja); 
    $sentencia->bindParam('id_negocios', $id_negocios); 
    $sentencia->bindParam('cantidad', $cantidad); 




    if ($sentencia->execute()) {
        echo "<script>
                alert('Se registró el reporte de la manera correcta.');
                window.location.href = '".$URL."/almacen/'; 
              </script>";
    } else {
        echo "<script>
                alert('Error no se pudo registrar en la base de datos.');
                window.location.href = '".$URL."/almacen/create.php'; 
              </script>";
    }
} catch (PDOException $e) {
    // Manejar el error de la consulta (puedes registrar el error en un archivo)
    error_log("Error en la consulta: " . $e->getMessage()); 
    die("Error al crear el reporte."); 
}
?>