<?php
include '../../config.php';
if (session_status() == PHP_SESSION_NONE) {session_start();}

try {
    $motivo_inversion = $_POST['motivo_inversion'];
    $costo_inversion = $_POST['costo_inversion'];
    $fecha_inversion = $_POST['fecha_inversion'];
    $id_usuario = $_SESSION['id_usuario'];  // Get from session. **Make sure this is set after user login!**
    $id_negocios = $_SESSION['negocio_id']; // Make absolutely sure you're getting this!

    $sentencia = $pdo->prepare("INSERT INTO tb_inversiones (motivo_inversion, costo_inversion, fecha_inversion, id_usuario, id_negocios) VALUES (:motivo_inversion, :costo_inversion, :fecha_inversion, :id_usuario, :id_negocios)");
    $sentencia->bindParam(':motivo_inversion', $motivo_inversion);
    $sentencia->bindParam(':costo_inversion', $costo_inversion);
    $sentencia->bindParam(':fecha_inversion', $fecha_inversion);
    $sentencia->bindParam(':id_usuario', $id_usuario);
    $sentencia->bindParam(':id_negocios', $id_negocios);


    if ($sentencia->execute()) {
        echo json_encode(['success' => true, 'message' => 'Inversión registrada correctamente.']);
    } else {
        // Get the error info
        $errorInfo = $sentencia->errorInfo();
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $errorInfo[2]]);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

?>