<?php
// app/controllers/cuentas_por_pagar/registrar_pago.php
include('../../config.php');

session_start();

// Check if required data is submitted
if (!isset($_POST['id_cuentas_por_pagar'], $_POST['monto_pago']) || !is_numeric($_POST['id_cuentas_por_pagar']) || !is_numeric($_POST['monto_pago'])) {
    $_SESSION['mensaje'] = "Datos incompletos o inválidos.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
    die();
}

// Get the data
$id_cuentas_por_pagar = $_POST['id_cuentas_por_pagar'];
$monto_pago = floatval($_POST['monto_pago']);

// Validate the session
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
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

// Get the current balance
$query_saldo = $pdo->prepare("SELECT saldo_pendiente, monto_total FROM cuentas_por_pagar WHERE id_cuentas_por_pagar = :id_cuentas_por_pagar AND id_negocios = :id_negocios");
$query_saldo->bindParam(':id_cuentas_por_pagar', $id_cuentas_por_pagar);
$query_saldo->bindParam(':id_negocios', $id_negocios);
$query_saldo->execute();
$saldo_data = $query_saldo->fetch(PDO::FETCH_ASSOC);

//check for errors
if (!$saldo_data) {
    $_SESSION['mensaje'] = "Error: No se encontró la cuenta.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
    die();
}

$saldo_pendiente_actual = floatval($saldo_data['saldo_pendiente']);
$total_a_pagar = floatval($saldo_data['monto_total']);

// Check if payment amount is valid
if ($monto_pago <= 0 || $monto_pago > $saldo_pendiente_actual) {
    $_SESSION['mensaje'] = "El monto del pago no es válido.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
    die();
}

// Calculate new balance
$nuevo_saldo = $saldo_pendiente_actual - $monto_pago;

// Start a transaction
$pdo->beginTransaction();

try {
    // Update the balance
    $query_update = $pdo->prepare("UPDATE cuentas_por_pagar SET saldo_pendiente = :nuevo_saldo WHERE id_cuentas_por_pagar = :id_cuentas_por_pagar AND id_negocios = :id_negocios");
    $query_update->bindParam(':nuevo_saldo', $nuevo_saldo);
    $query_update->bindParam(':id_cuentas_por_pagar', $id_cuentas_por_pagar);
    $query_update->bindParam(':id_negocios', $id_negocios);
    $query_update->execute();

    // Check if the update was successful
    if ($query_update->rowCount() > 0) {
        
         // Update the state
        $estado = '';
        if ($nuevo_saldo == 0) {
            $estado = 'pagado';
        } else if($nuevo_saldo < $total_a_pagar){
            $estado = 'parcialmente pagado';
        } else {
          $estado = 'pendiente';
        }
        $query_update = $pdo->prepare("UPDATE cuentas_por_pagar SET estado = :estado WHERE id_cuentas_por_pagar = :id_cuentas_por_pagar AND id_negocios = :id_negocios");
        $query_update->bindParam(':estado', $estado);
        $query_update->bindParam(':id_cuentas_por_pagar', $id_cuentas_por_pagar);
        $query_update->bindParam(':id_negocios', $id_negocios);
        $query_update->execute();

        // Insert new payment record in tb_pagos
        $query_insert_pago = $pdo->prepare("INSERT INTO tb_pagos (id_negocios, tipo_cuenta, id_cuenta, monto_pago, fyh_creacion) VALUES (:id_negocios, 'pagar', :id_cuentas_por_pagar, :monto_pago, :fyh_creacion)");
        $query_insert_pago->bindParam(':id_negocios', $id_negocios);
        $query_insert_pago->bindParam(':id_cuentas_por_pagar', $id_cuentas_por_pagar);
        $query_insert_pago->bindParam(':monto_pago', $monto_pago);
        $query_insert_pago->bindValue(':fyh_creacion', date("Y-m-d H:i:s")); // Current date and time
        $query_insert_pago->execute();

        // Commit the transaction
        $pdo->commit();

        $_SESSION['mensaje'] = "Pago registrado correctamente.";
        $_SESSION['icono'] = "success";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
        </script>
        <?php
    } else {
        // Rollback the transaction if the update failed
        $pdo->rollBack();

        $_SESSION['mensaje'] = "Error: No se pudo registrar el pago.";
        $_SESSION['icono'] = "error";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
        </script>
        <?php
    }
} catch (PDOException $e) {
    // Rollback the transaction if an exception occurred
    $pdo->rollBack();

    // Log the error
    error_log("Error al registrar el pago: " . $e->getMessage());

    $_SESSION['mensaje'] = "Error: Ocurrió un error al registrar el pago.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
}
?>
