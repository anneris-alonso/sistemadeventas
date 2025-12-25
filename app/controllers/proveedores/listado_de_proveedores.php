<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 1/2/2023
 * Time: 18:16
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
    $sql_proveedores = "SELECT * FROM tb_proveedores WHERE id_negocios = :id_negocios"; 
    $query_proveedores = $pdo->prepare($sql_proveedores);
    $query_proveedores->bindParam(':id_negocios', $id_negocios); 
    $query_proveedores->execute();
    $proveedores_datos = $query_proveedores->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Manejar el error de la consulta
    die("Error en la consulta: " . $e->getMessage()); 
}
?>