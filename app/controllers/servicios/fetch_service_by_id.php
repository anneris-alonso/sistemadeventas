<?php
include_once __DIR__ . '/../../../app/config.php'; // Use absolute path

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Validate and sanitize input - id_servicio AND id_negocios
if (!isset($_GET['id'], $_SESSION['negocio_id']) || !is_numeric($_GET['id']) || !is_numeric($_SESSION['negocio_id'])) {  // Correctly check for required $_POST fields

    die("ID de servicio o de negocio inválido."); // Do not continue
}


$id_servicio = intval($_GET['id']);
$id_negocios = $_SESSION['negocio_id'];

try {
    $sentencia = $pdo->prepare("SELECT * FROM tb_servicios WHERE id_servicios = :id_servicio AND id_negocios = :id_negocios");
    $sentencia->bindValue(':id_servicio', $id_servicio, PDO::PARAM_INT);
    $sentencia->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT); // VERY IMPORTANT - Check business ID

    if ($sentencia->execute()) {
        if ($servicio_data = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $servicio = $servicio_data['servicio'];  // Correct variable names
            $tipo = $servicio_data['tipo'];
            $precio_de_compra = $servicio_data['precio_de_compra'];
            $precio_serv = $servicio_data['precio_serv'];
            $duracion = $servicio_data['duracion'];
            $impuesto = $servicio_data['impuesto']; // Added
            $precio_final = $servicio_data['precio_final'];
            $ganancias = $servicio_data['ganancias'];

        // Correct variable names
        } else {
            die("Servicio no encontrado para este negocio.");
        }

    } else {
        // Handle query execution errors
        die("Error en la base de datos" . implode(", ", $sentencia->errorInfo())); // Or log and show a user-friendly message


    }



} catch (PDOException $e) {
    die("Error de base de datos: " . $e->getMessage());
}

?>

