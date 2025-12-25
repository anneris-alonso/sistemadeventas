<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 17/1/2023
 * Time: 16:19
 */

include('../../config.php');

$email = $_POST['email'];
$password_user = $_POST['password_user'];

try {
    // Consulta para verificar si el usuario existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tb_usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user_exists = $stmt->fetchColumn();

    if ($user_exists) { 
        // Si el usuario existe, obtener su información
        $sql = "SELECT id_usuario, id_negocios, password_user, nombres FROM tb_usuarios WHERE email = :email";
        $query = $pdo->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Iniciar sesión
            session_start();
            $_SESSION['sesion_email'] = $email;
            $_SESSION['sesion_id'] = $usuario['id_usuario'];
            $_SESSION['negocio_id'] = $usuario['id_negocios']; // Corregido: id_negocios
            $_SESSION['nombres'] = $usuario['nombres']; 

            header('Location: '.$URL.'/index.php'); 
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta, vuelva a intentarlo";
            session_start();
            $_SESSION['mensaje'] = "Error contraseña incorrecta";
            header('Location: '.$URL.'/index.php');
        }

    } else {
        // El usuario no existe
        echo "El usuario no existe.";
        session_start();
        $_SESSION['mensaje'] = "Error usuario no existe";
        header('Location: '.$URL.'/index.php');
    }

} catch(PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>