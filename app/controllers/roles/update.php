<?php

// Validar el ID del rol
if (isset($_POST['id_rol']) && is_numeric($_POST['id_rol'])) {
    $id_rol = $_POST['id_rol'];
} else {
    die("Error: ID de rol inválido."); 
}

// Validar el nombre del rol
if (isset($_POST['rol']) && !empty($_POST['rol'])) {
    $rol = $_POST['rol'];
} else {
    die("Error: El nombre del rol no puede estar vacío."); 
}

// Validar el ID del negocio (Asumiendo que `session_start()` se llama al principio de la aplicación)
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"]; 
} else {
    die("Error: ID de negocio inválido."); 
}

try {
    // Actualizar el nombre del rol
    $sentencia = $pdo->prepare("UPDATE tb_roles
                                SET rol=:rol, fyh_actualizacion=:fyh_actualizacion 
                                WHERE id_rol = :id_rol AND id_negocios = :id_negocios"); 

    $sentencia->bindParam('rol',$rol);
    $sentencia->bindParam('fyh_actualizacion',$fechaHora);
    $sentencia->bindParam('id_rol',$id_rol);
    $sentencia->bindParam('id_negocios', $id_negocios); 
    $sentencia->execute();


    // Actualizar los permisos
    $delete_stmt = $pdo->prepare("DELETE FROM tb_role_permissions WHERE id_rol = :id_rol");
    $delete_stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
    $delete_stmt->execute();

    if(isset($_POST['permissions'])) {
        foreach ($_POST['permissions'] as $permission) {
            $insert_stmt = $pdo->prepare("INSERT INTO tb_role_permissions (id_rol, permission_name) VALUES (:id_rol, :permission_name)");
            $insert_stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $insert_stmt->bindParam(':permission_name', $permission);
            $insert_stmt->execute();
        }
    }

    $_SESSION['mensaje'] = "Rol actualizado correctamente";
    $_SESSION['icono'] = "success";
    //header('Location: '.$URL.'/roles/'); We remove the redirect

} catch (PDOException $e) {
    die("Error al actualizar el rol: " . $e->getMessage()); 
}
?>
