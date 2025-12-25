<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 20/1/2023
 * Time: 10:19
 */

include ('../../config.php');
print_r($_POST);
// (Asumo que session_start() se llama al principio de la aplicación)

// Validar el ID del usuario
if (isset($_POST['id_usuario']) && is_numeric($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
} else {
    die("Error: ID de usuario inválido.");
    
}

// Validar el ID del negocio (recibido del formulario)
if (isset($_POST['id_negocios']) && is_numeric($_POST['id_negocios'])) {
    $id_negocios = $_POST['id_negocios'];
} else {
    die("Error: ID de negocio inválido."); 
}

try {
    $sentencia = $pdo->prepare("DELETE FROM tb_usuarios 
                                WHERE id_usuario=:id_usuario 
                                AND id_negocios = :id_negocios"); 

    $sentencia->bindParam('id_usuario', $id_usuario);
    $sentencia->bindParam('id_negocios', $id_negocios); 
    $sentencia->execute();

    // Verificar si se eliminó el usuario
    if ($sentencia->rowCount() > 0) {
        $_SESSION['mensaje'] = "Se eliminó al usuario de la manera correcta";
        $_SESSION['icono'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error: No se pudo eliminar el usuario.";
        $_SESSION['icono'] = "error";
    }

    header('Location: '.$URL.'/usuarios/');

} catch (PDOException $e) {
    // Manejar el error de la consulta
    die("Error en la consulta: " . $e->getMessage()); 
}
?>