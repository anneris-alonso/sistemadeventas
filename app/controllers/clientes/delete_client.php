<?php
// app/controllers/clientes/delete_client.php (Corrected Controller)
include('../../config.php');

session_start(); // Start the session

// Validate id_client AND id_negocios from $_POST
if (!isset($_POST['id_client'], $_POST['id_negocios']) || !is_numeric($_POST['id_client']) || !is_numeric($_POST['id_negocios'])) {
    die("ID de cliente o de negocio inválido.");  // Handle the error appropriately
}

$id_client = $_POST['id_client'];
$id_negocios = $_POST['id_negocios'];  // Essential security check

try {
    $sentencia = $pdo->prepare("DELETE FROM tb_clients WHERE id_clients = :id_client AND id_negocios = :id_negocios"); // Correct table and condition
    $sentencia->bindParam(':id_client', $id_client, PDO::PARAM_INT);
    $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT); // VERY IMPORTANT!

    if ($sentencia->execute()) {
        if ($sentencia->rowCount() > 0) {
            $_SESSION['mensaje'] = "El cliente se eliminó correctamente.";
            $_SESSION['icono'] = "success";
        } else {
            $_SESSION['mensaje'] = "No se encontró ningún cliente con ese ID para eliminar o no pertenece a este negocio.";  // More specific message
            $_SESSION['icono'] = "warning"; // Or "info"
        }
    } else {
        // Query execution failed
        $_SESSION['mensaje'] = "Error al eliminar el cliente: " . implode(", ", $sentencia->errorInfo());  // *Detailed* database error!
        $_SESSION['icono'] = "error"; // Set the correct icon
    }


    header('Location: ' . $URL . '/clientes/');
    exit();  // VERY IMPORTANT: Stop execution after redirect


} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error en la base de datos: " . $e->getMessage(); // Generic database error message
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/clientes/');  // Correct redirect on error
    exit(); // Important
}
?>
