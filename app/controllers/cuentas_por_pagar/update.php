<?php
// app/controllers/cuentas_por_pagar/update.php
include('../../config.php');
session_start();
$fechaHora = date("Y-m-d H:i:s"); // Get current date and time

// Check for required parameters
if (!isset($_POST['id_cuentas_pagar'], $_POST['id_proveedor'], $_POST['numero_factura'], $_POST['fecha_emision'], $_POST['fecha_vencimiento'], $_POST['monto_total'], $_POST['saldo_pendiente'], $_POST['estado']) || !is_numeric($_POST['id_cuentas_pagar'])) {
    session_start();
    $_SESSION['mensaje'] = "Datos de formulario incompletos o ID de cuenta no válido.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
    die();
}

// Get the data from the form
$id_cuentas_pagar = $_POST['id_cuentas_pagar'];
$id_proveedor = $_POST['id_proveedor'];
$numero_factura = $_POST['numero_factura'];
$fecha_emision = $_POST['fecha_emision'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$monto_total = $_POST['monto_total'];
$saldo_pendiente = $_POST['saldo_pendiente'];
$estado = $_POST['estado'];

// Get negocio_id from session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if negocio_id is set and is numeric
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    session_start();
    $_SESSION['mensaje'] = "Error: ID de negocio inválido.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
    die();
}
$id_negocios = $_SESSION['negocio_id'];

// Start a database transaction
$pdo->beginTransaction();

try {
    // Update tb_cuentas_por_pagar
    $sentencia = $pdo->prepare("UPDATE tb_cuentas_por_pagar 
                                SET id_proveedor = :id_proveedor,
                                    numero_factura = :numero_factura,
                                    fecha_emision = :fecha_emision,
                                    fecha_vencimiento = :fecha_vencimiento,
                                    monto_total = :monto_total,
                                    saldo_pendiente = :saldo_pendiente,
                                    estado = :estado
                                WHERE id_cuentas_pagar = :id_cuentas_pagar AND id_negocios = :id_negocios");

    $sentencia->bindParam(':id_proveedor', $id_proveedor);
    $sentencia->bindParam(':numero_factura', $numero_factura);
    $sentencia->bindParam(':fecha_emision', $fecha_emision);
    $sentencia->bindParam(':fecha_vencimiento', $fecha_vencimiento);
    $sentencia->bindParam(':monto_total', $monto_total);
    $sentencia->bindParam(':saldo_pendiente', $saldo_pendiente);
    $sentencia->bindParam(':estado', $estado);
    $sentencia->bindParam(':id_cuentas_pagar', $id_cuentas_pagar);
    $sentencia->bindParam(':id_negocios', $id_negocios);

    if ($sentencia->execute()) {
        // Commit the transaction
        $pdo->commit();

        // Set success message
        session_start();
        $_SESSION['mensaje'] = "Se actualizó la cuenta por pagar correctamente.";
        $_SESSION['icono'] = "success";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
        </script>
        <?php
    } else {
        // Rollback the transaction
        $pdo->rollBack();

        // Set error message
        session_start();
        $_SESSION['mensaje'] = "Error: No se pudo actualizar la cuenta en la base de datos.";
        $_SESSION['icono'] = "error";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
        </script>
        <?php
    }
} catch (PDOException $e) {
    // Rollback the transaction in case of exception
    $pdo->rollBack();

    // Log the error
    error_log("Error al actualizar la cuenta por pagar: " . $e->getMessage());

    // Set error message
    session_start();
    $_SESSION['mensaje'] = "Error: Ocurrió un error al actualizar la cuenta.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
}
?>
