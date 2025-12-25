<?php
include_once __DIR__ . '/../../../app/config.php';

// Start session ONLY if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate business ID - ESSENTIAL!  (Adapt this if your session variable is different)
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    die("Error: ID de negocio inválido.");
}
$id_negocios = $_SESSION['negocio_id'];

try {
    // Corrected SQL query for tb_perdidas
    $sql_perdida = "SELECT id_perdida, id_producto, id_usuario, motivo_baja, fecha_baja 
                     FROM tb_perdida 
                     WHERE id_negocios = :id_negocios"; // Assuming you have an id_negocios column in tb_perdidas
    $query_perdida = $pdo->prepare($sql_perdida);
    $query_perdida->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT);

    if ($query_perdida->execute()) { 
        $perdida_datos = $query_perdida->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Error en la consulta: " . implode(", ", $query_perdida->errorInfo())); 
    }

} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage()); 
}
?>
