<?php
// app/controllers/cuentas_por_cobrar/delete.php

include('../../config.php');

// New variables
$id_cuenta = $_GET['id_cuenta'];

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $id_negocios = $_SESSION["negocio_id"];
}

$pdo->beginTransaction();

// Delete from tb_cuentas_por_cobrar
$sentencia = $pdo->prepare("DELETE FROM tb_cuentas_por_cobrar 
                            WHERE id_cuenta=:id_cuenta 
                            AND id_negocios = :id_negocios"); // Use the new table name and new column names
$sentencia->bindParam('id_cuenta', $id_cuenta);
$sentencia->bindParam('id_negocios', $id_negocios);

if ($sentencia->execute()) {
    $pdo->commit();

    session_start();
    $_SESSION['mensaje'] = "Se borro la cuenta por cobrar de la manera correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_cobrar"; // Corrected URL
    </script>
    <?php
} else {
    $pdo->rollBack();

    session_start();
    $_SESSION['mensaje'] = "Error no se pudo actualizar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_cobrar"; // Corrected URL
    </script>
    <?php
}
?>
