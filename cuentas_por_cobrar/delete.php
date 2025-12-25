<?php
// cuentas_por_cobrar/delete.php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Check if id_cuenta is received
if(!isset($_GET['id_cuenta'])){
    session_start();
    $_SESSION['mensaje'] = "No se recibio el ID de la cuenta.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_cobrar";
    </script>
    <?php
    die(); // Stop execution
}

// Get the id_cuenta from the URL
$id_cuenta = $_GET['id_cuenta'];

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
        location.href = "<?php echo $URL; ?>/cuentas_por_cobrar";
    </script>
    <?php
    die(); // Stop execution
}
$id_negocios = $_SESSION['negocio_id'];

// Start a database transaction
$pdo->beginTransaction();

try {
    // Delete from tb_cuentas_por_cobrar
    $sentencia = $pdo->prepare("DELETE FROM tb_cuentas_por_cobrar 
                                WHERE id_cuenta = :id_cuenta 
                                AND id_negocios = :id_negocios");

    $sentencia->bindParam(':id_cuenta', $id_cuenta);
    $sentencia->bindParam(':id_negocios', $id_negocios);

    if ($sentencia->execute()) {
        // Commit the transaction
        $pdo->commit();

        // Set success message
        session_start();
        $_SESSION['mensaje'] = "Se eliminó la cuenta por cobrar correctamente.";
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
        $_SESSION['mensaje'] = "Error: No se pudo eliminar la cuenta en la base de datos.";
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
    error_log("Error al eliminar la cuenta por cobrar: " . $e->getMessage());

    // Set error message
    session_start();
    $_SESSION['mensaje'] = "Error: Ocurrió un error al eliminar la cuenta.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_cobrar";
    </script>
    <?php
}

include('../layout/mensajes.php');
include('../layout/parte2.php');
?>
