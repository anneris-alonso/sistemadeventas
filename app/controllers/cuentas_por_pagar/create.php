<?php
// app/controllers/cuentas_por_pagar/create.php

include('../../config.php');

// Get Data from _POST
$id_proveedor = $_POST['id_proveedor'];
$numero_factura = $_POST['numero_factura'];
$fecha_emision = $_POST['fecha_emision'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$monto_total = $_POST['monto_total'];
$saldo_pendiente = $_POST['saldo_pendiente'];
$estado = $_POST['estado'];

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate negocio_id
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    die("Error: ID de negocio no válido.");
}

$id_negocios = $_SESSION["negocio_id"];

//Validate empty values
if(empty($id_proveedor) || empty($numero_factura) || empty($fecha_emision) || empty($fecha_vencimiento) || empty($monto_total) || empty($saldo_pendiente) || empty($estado)){
    session_start();
    $_SESSION['mensaje'] = "Error al cargar, debe completar todos los datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar/create.php"; 
    </script>
    <?php
    die();
}

$pdo->beginTransaction();

$fechaHora = date("Y-m-d H:i:s"); // Get current date and time

// Insert into tb_cuentas_por_pagar
$sentencia = $pdo->prepare("INSERT INTO cuentas_por_pagar (id_negocios, id_proveedor, numero_factura, fecha_emision, fecha_vencimiento, monto_total, saldo_pendiente, estado, fyh_creacion)
                            VALUES (:id_negocios, :id_proveedor, :numero_factura, :fecha_emision, :fecha_vencimiento, :monto_total, :saldo_pendiente, :estado, :fyh_creacion)");

$sentencia->bindParam(':id_negocios', $id_negocios);
$sentencia->bindParam(':id_proveedor', $id_proveedor);
$sentencia->bindParam(':numero_factura', $numero_factura);
$sentencia->bindParam(':fecha_emision', $fecha_emision);
$sentencia->bindParam(':fecha_vencimiento', $fecha_vencimiento);
$sentencia->bindParam(':monto_total', $monto_total);
$sentencia->bindParam(':saldo_pendiente', $saldo_pendiente);
$sentencia->bindParam(':estado', $estado);
$sentencia->bindParam(':fyh_creacion', $fechaHora);

if ($sentencia->execute()) {
    $pdo->commit();

    session_start();
    $_SESSION['mensaje'] = "Se registró la cuenta por pagar de la manera correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
} else {
    $pdo->rollBack();

    session_start();
    $_SESSION['mensaje'] = "Error no se pudo registrar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar/create.php";
    </script>
    <?php
}
?>
