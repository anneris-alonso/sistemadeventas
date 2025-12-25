<?php

$nombre_categoria = $_POST['nombre_categoria'];

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $id_negocios = $_SESSION["negocio_id"];
}

$sentencia = $pdo->prepare("INSERT INTO tb_categorias
             ( nombre_categoria, fyh_creacion, id_negocios) 
VALUES (:nombre_categoria,:fyh_creacion, :id_negocios)");

$sentencia->bindParam('nombre_categoria', $nombre_categoria);
$sentencia->bindParam('fyh_creacion', $fechaHora);
$sentencia->bindParam('id_negocios', $id_negocios); // Añadir el id_negocios

if ($sentencia->execute()) {
    echo '<div class="alert alert-success" role="alert">
    Se registro la categoría de la manera correcta
  </div>';
} else {
    echo '<div class="alert alert-danger" role="alert">
    Error no se pudo registrar en la base de datos
  </div>';
}
?>
