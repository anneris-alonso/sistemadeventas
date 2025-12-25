<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 24/1/2023
 * Time: 17:22
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
    $sql_categorias = "SELECT * FROM tb_categorias WHERE id_negocios = :id_negocios"; 
    $query_categorias = $pdo->prepare($sql_categorias);
    $query_categorias->bindParam(':id_negocios', $id_negocios); 
    $query_categorias->execute();
    $categorias_datos = $query_categorias->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se encontraron categorías
    

} catch (PDOException $e) {
    // Manejar el error de la consulta
    die("Error en la consulta: " . $e->getMessage()); 
}
?>