<?php
// cuentas_por_pagar/delete.php
include('../../config.php');

// Check if id_cuenta is received
if(!isset($_GET['id'])){
    session_start();
    $_SESSION['mensaje'] = "No se recibio el ID de la cuenta.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
    die(); // Stop execution
}

// Get the id_cuenta from the URL
$id_cuenta = $_GET['id'];

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
    die(); // Stop execution
}
$id_negocios = $_SESSION['negocio_id'];

// Start a database transaction
$pdo->beginTransaction();

try {
    // Delete from tb_cuentas_por_pagar
    $sentencia = $pdo->prepare("DELETE FROM tb_cuentas_por_pagar 
                                WHERE id_cuentas_pagar = :id_cuenta 
                                AND id_negocios = :id_negocios");

    $sentencia->bindParam(':id_cuenta', $id_cuenta);
    $sentencia->bindParam(':id_negocios', $id_negocios);

    if ($sentencia->execute()) {
        // Commit the transaction
        $pdo->commit();

        // Set success message
        session_start();
        $_SESSION['mensaje'] = "Se eliminó la cuenta por pagar correctamente.";
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
        $_SESSION['mensaje'] = "Error: No se pudo eliminar la cuenta en la base de datos.";
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
    error_log("Error al eliminar la cuenta por pagar: " . $e->getMessage());

    // Set error message
    session_start();
    $_SESSION['mensaje'] = "Error: Ocurrió un error al eliminar la cuenta.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_pagar";
    </script>
    <?php
}
?>
