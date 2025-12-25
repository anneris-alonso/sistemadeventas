<?php

$nombre_categoria = $_GET['nombre_categoria'];
$id_categoria = $_GET['id'];

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $id_negocios = $_SESSION["negocio_id"];
}

$sentencia = $pdo->prepare("UPDATE tb_categorias
     SET nombre_categoria=:nombre_categoria,
         fyh_actualizacion=:fyh_actualizacion 
     WHERE id_categoria = :id_categoria
     AND id_negocios = :id_negocios"); // Añadir la condición id_negocios

$sentencia->bindParam('nombre_categoria', $nombre_categoria);
$sentencia->bindParam('fyh_actualizacion', $fechaHora);
$sentencia->bindParam('id_categoria', $id_categoria);
$sentencia->bindParam('id_negocios', $id_negocios); // Añadir el id_negocios

if ($sentencia->execute()) {
    echo '<div class="alert alert-success" role="alert">
    Se actualizo la categoria de la manera correcta
  </div>';
} else {
    echo '<div class="alert alert-danger" role="alert">
    Error no se pudo actualizar en la base de datos
  </div>';
}
?>
