<?php

include_once __DIR__ . '/../../../app/config.php';  // Absolute path

$sugerencias_datos = array();

try {
    $sql = "SELECT * FROM tb_sugerencias";
    $sentencia = $pdo->prepare($sql);

    if ($sentencia->execute()) {
        $sugerencias_datos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Manejar el error de la consulta (puedes registrar el error en un archivo)
        error_log("Error en la consulta: " . implode(", ", $sentencia->errorInfo())); 
        die("Error al obtener las sugerencias."); 
    }
} catch (PDOException $e) {
    // Manejar el error de la base de datos (puedes registrar el error en un archivo)
    error_log("Error en la base de datos: " . $e->getMessage()); 
    die("Error al conectar a la base de datos."); 
}
?>