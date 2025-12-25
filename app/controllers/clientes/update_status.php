<?php
include('../../config.php');
session_start(); // Ensure session_start() is at the beginning


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$id_negocios = $_SESSION['negocio_id'];



if (isset($_POST['id_clients']) && isset($_POST['status_clt']) && isset($_POST['id_negocios'])) {
    $id_clients = $_POST['id_clients'];
    $status_clt = $_POST['status_clt'];
    $id_negocios = $_POST['id_negocios'];

    // 1. Validación de datos (¡Muy importante!)
    if (!is_numeric($id_clients) || !is_numeric($id_negocios) || empty($status_clt)) {
        echo "Error: Datos inválidos."; // Mensaje de error más específico
        exit; // Detener la ejecución para evitar problemas
    }

    try { // 2. Bloque try-catch para manejar errores de la base de datos
        $stmt = $pdo->prepare("UPDATE tb_clients SET status_clt = :status_clt WHERE id_clients = :id_clients AND id_negocios = :id_negocios");
        $stmt->execute([':status_clt' => $status_clt, ':id_clients' => $id_clients, ':id_negocios' => $id_negocios]);

        // 3. Comprobar si se actualizó alguna fila
        if ($stmt->rowCount() > 0) {
            echo "Estado actualizado correctamente.";
        } else {
            echo "No se encontró ningún registro para actualizar."; // Mensaje más informativo
        }

    } catch (PDOException $e) {
        // 4. Manejo de excepciones (¡Crucial!)
        echo "Error al actualizar el estado: " . $e->getMessage(); // Log del error para depuración
        // Considerar mostrar un mensaje genérico al usuario en producción por seguridad.
        // Ejemplo: echo "Ocurrió un error al actualizar. Inténtelo nuevamente más tarde.";
        exit;
    }
} else {
    echo "Faltan datos en la solicitud."; // Mensaje claro si faltan datos
}
?>
