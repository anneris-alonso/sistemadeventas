<?php
// Correct path to config.php - adjust if needed
include_once __DIR__. '/../../../app/config.php'; //  Use absolute path for reliability

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Validate BOTH id_client AND id_negocios *before* the query
if (!isset($_GET['id']) ||!is_numeric($_GET['id']) ||!isset($_SESSION['negocio_id']) ||!is_numeric($_SESSION['negocio_id'])) {
    die("ID de cliente o de negocio inválido."); // Or handle the error more gracefully (redirect, etc.)
}

$id_client = $_GET['id'];
$id_negocios = $_SESSION['negocio_id'];  // Assuming this is how you store it


try {
    // Use prepared statement and named parameters - essential for security
    $query_client = $pdo->prepare("SELECT * FROM tb_clients WHERE id_clients =:id_client AND id_negocios =:id_negocios");
    $query_client->bindValue(':id_client', $id_client, PDO::PARAM_INT);
    $query_client->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT); // Crucial business ID check

    $query_client->execute();

    if ($client_data = $query_client->fetch(PDO::FETCH_ASSOC)) {
        // Client data found.  Extract ONLY the fields you need in update.php.

        $nombre_clt = $client_data['nombre_clt'];
        $direccion_clt = $client_data['direccion_clt'];
        $nacionalidad_clt = $client_data['nacionalidad_clt'];
        $ciudadania_clt = $client_data['ciudadania_clt'];
        $pasaporte_clt = $client_data['pasaporte_clt'];
        $fecha_venc_pass_clt = $client_data['fecha_venc_pass_clt'];
        $est_civil_clt = $client_data['est_civil_clt'];
        $telefono_clt = $client_data['telefono_clt'];
        $mail_clt = $client_data['mail_clt'];
        $id_servicios = $client_data['id_servicios'];
        $imagen = isset($client_data['image_clt']) &&!is_null($client_data['image_clt'])? $client_data['image_clt']: 'default.jpg'; // Added image field
        $fecha_ini_tramite = $client_data['fecha_ini_tramite'];
        $fecha_fin_tramite = $client_data['fecha_fin_tramite'];
        $status_clt = $client_data['status_clt'];


        //... extract other client data used in update.php...
    } else {

        die("Cliente no encontrado para este negocio."); // Or redirect, show a user-friendly message

    }
} catch (PDOException $e) {
    die("Error en la consulta: ". $e->getMessage()); // Or log the error and display a generic message
}?>