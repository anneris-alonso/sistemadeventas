<?php
include_once __DIR__ . '/../../../app/config.php';  // Absolute path

// Start session ONLY if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate business ID - ESSENTIAL!
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    die("Error: ID de negocio inválido.");
}
$id_negocios = $_SESSION['negocio_id'];

try {
    $sql_inversiones = "SELECT motivo_inversion, costo_inversion, fecha_inversion, id_negocios, id_usuario FROM tb_inversiones WHERE id_negocios = :id_negocios"; // Make sure 'id_servicios' is the correct field name
    $query_inversiones = $pdo->prepare($sql_inversiones);
    $query_inversiones->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT);


    if ($query_inversiones->execute()) {  // Always check if execute() was successful
        $inversiones_datos = $query_inversiones->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Error en la consulta: " . implode(", ", $query_inversiones->errorInfo())); // Provide detailed database error info
    }

} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
