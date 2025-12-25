<?php
include('../../config.php'); // Or the absolute path

session_start();

// Validate id_proveedor and id_negocios from POST data - ESSENTIAL!
if (!isset($_POST['id_proveedor'], $_POST['id_negocios']) || !is_numeric($_POST['id_proveedor']) || !is_numeric($_POST['id_negocios'])) {
    die("ID de proveedor o de negocio inválido."); // Or handle more appropriately
}

$id_proveedor = intval($_POST['id_proveedor']);
$id_negocios = intval($_POST['id_negocios']);

// Get other POST data, validating and sanitizing for each field as needed
$nombre_proveedor = isset($_POST['nombre_proveedor']) ? $_POST['nombre_proveedor'] : null;
$celular = isset($_POST['celular']) ? $_POST['celular'] : null;
// ... other fields

try {

    $sentencia = $pdo->prepare("UPDATE tb_proveedores SET
        nombre_proveedor = :nombre_proveedor,
        celular = :celular,
        telefono = :telefono,
        empresa = :empresa,
        email = :email,
        direccion = :direccion,
        fyh_actualizacion = :fyh_actualizacion
        WHERE id_proveedor = :id_proveedor
        AND id_negocios = :id_negocios");  // Filter by business ID - ESSENTIAL!


    // Bind ALL parameters.  Correct parameter type for id_proveedor.
    $sentencia->bindParam(':nombre_proveedor', $nombre_proveedor);
    $sentencia->bindParam(':celular', $celular);
    // ... (Bind other parameters)
    $sentencia->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);  // Correct type
    $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);   // Correct type and VERY IMPORTANT

    if ($sentencia->execute()) {
        //Check if rows were updated
        if ($sentencia->rowCount() > 0) {
            $_SESSION['mensaje'] = "Proveedor actualizado correctamente.";
            $_SESSION['icono'] = "success";
        } else {
            $_SESSION['mensaje'] = "No se actualizó ningún proveedor. Verifique el ID y el negocio.";
            $_SESSION['icono'] = "warning"; // Or "info"
        }



    } else {
        $_SESSION['mensaje'] = "Error al actualizar el proveedor: " . implode(', ', $sentencia->errorInfo()); // Detailed error message
        $_SESSION['icono'] = "error";


    }

    header('Location: ' . $URL . '/proveedores/');
    exit();  // VERY IMPORTANT: Always exit after a redirect


} catch (PDOException $e) {  // Handle any exceptions
  // ... add error handling, for instance using sessions and redirects ...
}

?>
