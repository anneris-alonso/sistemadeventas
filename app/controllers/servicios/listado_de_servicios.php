<?php // servicios/listado_de_servicios.php (Corrected Controller)
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
    // Correct SQL query - Use correct field name ('id_servicios', not 'id_servicio')
    $sql_servicios = "SELECT id_servicios, servicio, tipo,precio_de_compra , precio_serv, duracion, impuesto, precio_final, ganancias FROM tb_servicios WHERE id_negocios = :id_negocios"; // Make sure 'id_servicios' is the correct field name
    $query_servicios = $pdo->prepare($sql_servicios);
    $query_servicios->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT);


    if ($query_servicios->execute()) {  // Always check if execute() was successful
        $servicios_datos = $query_servicios->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Error en la consulta: " . implode(", ", $query_servicios->errorInfo())); // Provide detailed database error info
    }

} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
}
?>
