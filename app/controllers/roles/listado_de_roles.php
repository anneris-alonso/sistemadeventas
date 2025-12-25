<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 23/1/2023
 * Time: 19:00
 */

// (Asumo que session_start() se llama al principio de la aplicación)

// Validar el ID del negocio
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"]; 
} else {
    // Manejar el error si el ID del negocio no es válido
    die("Error: ID de negocio inválido."); 
}

try {
    $sql_roles = "SELECT * FROM tb_roles WHERE id_negocios = :id_negocios"; 
    $query_roles = $pdo->prepare($sql_roles);
    $query_roles->bindParam(':id_negocios', $id_negocios); 
    $query_roles->execute();
    $roles_datos = $query_roles->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejar el error de la consulta
    die("Error en la consulta: " . $e->getMessage()); 
}
?>