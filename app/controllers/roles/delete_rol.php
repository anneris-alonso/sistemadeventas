<?php
include ('../../config.php');

if (isset($_POST['id_rol']) && is_numeric($_POST['id_rol']) && isset($_POST['id_negocios']) && is_numeric($_POST['id_negocios'])) {
    $id_rol = $_POST['id_rol'];
    $id_negocios = $_POST['id_negocios'];

    try {
        $sentencia = $pdo->prepare("DELETE FROM tb_roles WHERE id_rol=:id_rol AND id_negocios=:id_negocios");
        $sentencia->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
        $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
        $sentencia->execute();

        session_start();
        $_SESSION['mensaje'] = "El rol se eliminó correctamente.";
        $_SESSION['icono'] = "success";
        header('Location: '.$URL.'/roles/'); // Redirect after successful deletion
        exit(); // Important to prevent further execution

    } catch (PDOException $e) {
        // Handle errors (e.g., log the error, display a user-friendly message)
        die("Error al eliminar el rol: " . $e->getMessage()); // Or use a custom error page
    }
} else {
    die("Error: ID de rol o negocio inválido.");
}
?>
