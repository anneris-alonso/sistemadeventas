<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 23/1/2023
 * Time: 20:04
 */

$id_rol_get = $_GET['id'];

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$id_negocios = $_SESSION["negocio_id"];


// Fetch the role name 
$sql_rol = "SELECT rol FROM tb_roles WHERE id_rol = :id_rol AND id_negocios = :id_negocios";
$query_rol = $pdo->prepare($sql_rol);
$query_rol->bindParam(':id_rol', $id_rol_get, PDO::PARAM_INT);
$query_rol->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
if (!$query_rol->execute()) {  // Check for query execution errors
    print_r($query_rol->errorInfo()); // Print error info for debugging
    die("Error fetching role name.");
}

$rol_data = $query_rol->fetch(PDO::FETCH_ASSOC);

if ($rol_data) {
    $rol = $rol_data['rol'];
} else {
    die("Rol no encontrado.");
}




// Fetch existing permissions
$sql_permissions = "SELECT permission_name 
                   FROM tb_role_permissions 
                   WHERE id_rol = :id_rol";
$query_permissions = $pdo->prepare($sql_permissions);
$query_permissions->bindParam(':id_rol', $id_rol_get, PDO::PARAM_INT);

if (!$query_permissions->execute()) {
    print_r($query_permissions->errorInfo());
    die("Error fetching existing permissions.");
}

$current_permissions = $query_permissions->fetchAll(PDO::FETCH_COLUMN); 


// Fetch all available permissions 
$sql_all_permissions = "SELECT permission_name FROM tb_role_permissions"; // This should be your table of ALL possible permissions.
$query_all_permissions = $pdo->prepare($sql_all_permissions);
if (!$query_all_permissions->execute()) {
    print_r($query_all_permissions->errorInfo());
    die("Error fetching all permissions.");
}

$all_permissions = $query_all_permissions->fetchAll(PDO::FETCH_COLUMN);

?>
