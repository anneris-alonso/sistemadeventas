<?php
include('../../config.php');
session_start();

// Validar el ID del negocio (opcional, si necesitas asociar la sugerencia a un negocio)
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"]; 
} else {
    // Manejar el error si el ID del negocio no es válido
    die("Error: ID de negocio inválido."); 
}

// Obtener la sugerencia del formulario
$sugerencia = isset($_POST['sugerencia']) ? $_POST['sugerencia'] : "";

// Validar que la sugerencia no esté vacía
if (empty($sugerencia)) {
    echo "<script>
            alert('Error: Debe proporcionar una sugerencia.');
            window.location.href = '".$URL."/sugerencias/create.php'; 
          </script>";
    exit();
}

try {
    // Insertar la sugerencia en la base de datos
    $sentencia = $pdo->prepare("INSERT INTO tb_sugerencias (sugerencia) VALUES (:sugerencia)");
    $sentencia->bindParam(':sugerencia', $sugerencia);

    if ($sentencia->execute()) {
        $_SESSION['mensaje'] = "La sugerencia se ha registrado exitosamente";
        $_SESSION['icono'] = "success";
        header('Location: ' . $URL . '/sugerencias/');
        exit(); 
    } else {
        $_SESSION['mensaje'] = "Error al registrar la sugerencia: " . implode(", ", $sentencia->errorInfo());
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/sugerencias/create.php'); 
        exit();
    }

} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error en la base de datos: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/sugerencias/create.php');
    exit();
}
?>