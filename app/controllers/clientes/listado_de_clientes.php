<?php

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate the business ID
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"];
} else {
    // Handle the error if the business ID is invalid
    die("Error: ID de negocio inválido.");
}

try {
    $sql_clients = "SELECT 
                        id_clients, 
                        nombre_clt
                    FROM 
                        tb_clients
                    WHERE 
                        id_negocios = :id_negocios";

    $query_clients = $pdo->prepare($sql_clients);
    $query_clients->bindParam(':id_negocios', $id_negocios);
    $query_clients->execute();
    $clientes_datos = $query_clients->fetchAll(PDO::FETCH_ASSOC);

    // Check if any clients were found
    if (empty($clientes_datos)) {
        echo "No se encontraron clientes para este negocio.";
    }

} catch (PDOException $e) {
    // Handle the query error
    die("Error en la consulta: " . $e->getMessage());
}
?>
