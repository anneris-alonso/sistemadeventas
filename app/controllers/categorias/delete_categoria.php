<?php
include ('../../config.php');

if (isset($_POST['id_categoria']) && is_numeric($_POST['id_categoria']) && isset($_POST['id_negocios']) && is_numeric($_POST['id_negocios'])) {
    $id_categoria = $_POST['id_categoria'];
    $id_negocios = $_POST['id_negocios'];

    try {
        $sentencia = $pdo->prepare("DELETE FROM tb_categorias WHERE id_categoria=:id_categoria AND id_negocios=:id_negocios");
        $sentencia->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
        $sentencia->execute();

          session_start();
        $_SESSION['mensaje'] = "La categoría se eliminó correctamente.";
        $_SESSION['icono'] = "success";
        header('Location: '.$URL.'/categorias/'); // Redirect after successful deletion
        exit(); // Important to prevent further execution


    } catch (PDOException $e) {
        die("Error al eliminar la categoría: " . $e->getMessage());
    }
} else {
    die("Error: ID de categoría o negocio inválido.");
}
?>
