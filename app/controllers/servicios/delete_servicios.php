<?php
// app/controllers/servicios/delete_service.php (Corrected Controller)
include('../../config.php'); // Or correct absolute path if needed
session_start();


// Validate id_servicio AND id_negocios from $_POST
if (!isset($_POST['id_servicio'], $_POST['id_negocios']) || !is_numeric($_POST['id_servicio']) || !is_numeric($_POST['id_negocios'])) {
    die("ID de servicio o de negocio inválido."); // Handle invalid input
}


$id_servicio = $_POST['id_servicio'];
$id_negocios = $_SESSION['negocio_id'];



try {
    $sentencia = $pdo->prepare("DELETE FROM tb_servicios WHERE id_servicios = :id_servicio AND id_negocios = :id_negocios");
    $sentencia->bindParam(':id_servicio', $id_servicio, PDO::PARAM_INT); // Ensure integer type
    $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT); // Very important to prevent unauthorized deletion


    if ($sentencia->execute()) {  // Check if the query executed successfully

      if ($sentencia->rowCount() > 0) { // Check if any rows were affected
        $_SESSION['mensaje'] = "El servicio se eliminó correctamente.";
        $_SESSION['icono'] = "success";

      } else {
          // If no rows were affected, it means the ID or id_negocios was incorrect
          $_SESSION['mensaje'] = "No se encontró ningún servicio con ese ID para este negocio.";
          $_SESSION['icono'] = "warning"; // Set an appropriate icon
      }
    } else {
            $_SESSION['mensaje'] = "Error al eliminar: " . implode(', ', $sentencia->errorInfo());  // Specific DB error details
            $_SESSION['icono'] = "error"; // Set the correct icon

    }

    header('Location: ' . $URL . '/servicios/');  // Redirect after delete attempt (successful or not)

    exit();  // Very important to stop execution here

} catch (PDOException $e) {
    $_SESSION['mensaje'] = "Error en la base de datos: " . $e->getMessage();
    $_SESSION['icono'] = "error"; // Set the error icon
    header('Location: ' . $URL . '/servicios/'); // Redirect back to the service listing page
    exit();  // Ensure that no code is executed after the redirect.

}



?>
