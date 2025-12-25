<?php
// app/controllers/cuentas_por_cobrar/update.php
include('../../config.php');
session_start();
$fechaHora = date("Y-m-d H:i:s"); // Get current date and time

// Check for required parameters
if (!isset($_POST['id_cuenta'], $_POST['id_clients'], $_POST['id_servicios']) || !is_numeric($_POST['id_cuenta'])) {
    session_start();
    $_SESSION['mensaje'] = "Datos de formulario incompletos o ID de cuenta inválido.";
    $_SESSION['icono'] = "error";
    ?>
        <script>location.href = "<?php echo $URL; ?>/cuentas_por_cobrar/";</script>
    <?php
    die();
}

// Get data from $_POST
$id_cuenta = $_POST['id_cuenta'];
$id_clients = $_POST['id_clients'];
$id_servicios = $_POST['id_servicios'];
$condicion_especial = isset($_POST['condicion_especial']) ? $_POST['condicion_especial'] : ""; // Use isset
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : ""; // Use isset

// Validate the business ID - ESSENTIAL SECURITY CHECK
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    session_start();
    $_SESSION['mensaje'] = "Error: ID de negocio no válido.";
    $_SESSION['icono'] = "error";
    ?>
        <script>location.href = "<?php echo $URL; ?>/cuentas_por_cobrar/";</script>
    <?php
    die();
}

// Get the business id.
$id_negocios = $_SESSION['negocio_id'];

// Get the service price
$query_servicio = $pdo->prepare("SELECT precio_serv FROM tb_servicios WHERE id_servicios = :id_servicios");
$query_servicio->bindParam(':id_servicios', $id_servicios);
$query_servicio->execute();
$servicio_data = $query_servicio->fetch(PDO::FETCH_ASSOC);

// Get the service price
$precio_serv = 0;
if ($servicio_data) {
    $precio_serv = floatval($servicio_data['precio_serv']);
}
// Calculate total a pagar
$condicion_especial = floatval($condicion_especial);
$descuento = $precio_serv * ($condicion_especial / 100);
$total_a_pagar = $precio_serv - $descuento;

//get the old state and saldo
$query_old_data = $pdo->prepare("SELECT estado, saldo_pendiente FROM tb_cuentas_por_cobrar WHERE id_cuenta = :id_cuenta AND id_negocios = :id_negocios");
$query_old_data->bindParam(':id_cuenta', $id_cuenta);
$query_old_data->bindParam(':id_negocios', $id_negocios);
$query_old_data->execute();
$old_data = $query_old_data->fetch(PDO::FETCH_ASSOC);
$old_saldo = $old_data['saldo_pendiente'];
$old_estado = $old_data['estado'];

//Set the new saldo
$saldo_pendiente = $total_a_pagar;

//Set the new state
$estado = '';
if ($old_saldo == $saldo_pendiente){
    $estado = $old_estado;
} else if ($saldo_pendiente == 0) {
    $estado = 'pagado';
} else if ($saldo_pendiente < $total_a_pagar) {
    $estado = 'parcialmente pagado';
} else {
    $estado = 'pendiente';
}


// Start a database transaction
$pdo->beginTransaction();

try {
    // Update tb_cuentas_por_cobrar
    $sentencia = $pdo->prepare("UPDATE tb_cuentas_por_cobrar 
                                SET id_clients = :id_clients,
                                    id_servicios = :id_servicios,
                                    total_a_pagar = :total_a_pagar,
                                    saldo_pendiente = :saldo_pendiente,
                                    estado = :estado,
                                    condicion_especial = :condicion_especial,
                                    descripcion = :descripcion
                                WHERE id_cuenta = :id_cuenta AND id_negocios = :id_negocios");

    $sentencia->bindParam(':id_clients', $id_clients);
    $sentencia->bindParam(':id_servicios', $id_servicios);
    $sentencia->bindParam(':total_a_pagar', $total_a_pagar);
    $sentencia->bindParam(':saldo_pendiente', $saldo_pendiente);
    $sentencia->bindParam(':estado', $estado);
    $sentencia->bindParam(':condicion_especial', $condicion_especial);
    $sentencia->bindParam(':descripcion', $descripcion);
    $sentencia->bindParam(':id_cuenta', $id_cuenta);
    $sentencia->bindParam(':id_negocios', $id_negocios);

    if ($sentencia->execute()) {
        // Commit the transaction
        $pdo->commit();

        // Set success message
        session_start();
        $_SESSION['mensaje'] = "Se actualizó la cuenta por cobrar correctamente.";
        $_SESSION['icono'] = "success";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/cuentas_por_cobrar";
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
            location.href = "<?php echo $URL; ?>/cuentas_por_cobrar";
        </script>
        <?php
    }
} catch (PDOException $e) {
    // Rollback the transaction in case of exception
    $pdo->rollBack();

    // Log the error
    error_log("Error al actualizar la cuenta por cobrar: " . $e->getMessage());

    // Set error message
    session_start();
    $_SESSION['mensaje'] = "Error: Ocurrió un error al actualizar la cuenta.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_cobrar";
    </script>
    <?php
}
?>
