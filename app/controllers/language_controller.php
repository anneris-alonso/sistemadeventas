<?php
include('../../config.php');
session_start();

if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];

    // Validate language
    if (in_array($lang, ['en', 'es'])) {
        $_SESSION['lang'] = $lang;

        // Update database if user is logged in
        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
            $sentencia = $pdo->prepare("UPDATE tb_usuarios SET language = :language WHERE id_usuario = :id_usuario");
            $sentencia->bindParam(':language', $lang);
            $sentencia->bindParam(':id_usuario', $id_usuario);
            $sentencia->execute();
        }
    }
}

// Redirect back
if (isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location: ' . $URL);
}
?>