<?php

$rol = $_POST['rol'];

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $id_negocios = $_SESSION["negocio_id"];
}

$sentencia = $pdo->prepare("INSERT INTO tb_roles
             ( rol, fyh_creacion, id_negocios) 
VALUES (:rol,:fyh_creacion, :id_negocios)");

$sentencia->bindParam('rol', $rol);
$sentencia->bindParam('fyh_creacion', $fechaHora);
$sentencia->bindParam('id_negocios', $id_negocios); // Añadir el id_negocios

if ($sentencia->execute()) {
    $last_id = $pdo->lastInsertId();  // Get the ID of the inserted role
    $permissions = $_POST['permissions']; // Retrieve selected permissions

    if (isset($permissions)) {
        foreach ($permissions as $permission) {

            $sentencia = $pdo->prepare("INSERT INTO tb_role_permissions (id_rol, permission_name) VALUES (:id_rol, :permission_name)");

            $sentencia->bindParam(':id_rol', $last_id, PDO::PARAM_INT);

            $sentencia->bindParam(':permission_name', $permission);

            if (!$sentencia->execute()) {
                echo '<div class="alert alert-danger" role="alert">
                Error al registrar los permisos
                </div>';
            }
        }
    }
    echo '<div class="alert alert-success" role="alert">
    Se registro el rol de la manera correcta
  </div>';

} else {
    echo '<div class="alert alert-danger" role="alert">
    Error no se pudo registrar en la base de datos
  </div>';

}
?>
