<?php
include('../../config.php');

// Start the session at the beginning
session_start();

// Check if required POST data exists and is valid
if (!isset($_POST['id_producto'], $_POST['id_negocios'], $_POST['id_usuario'], $_POST['id_categoria'], $_POST['codigo'], $_POST['nombre'], $_POST['descripcion'], $_POST['stock'], $_POST['stock_minimo'], $_POST['stock_maximo'], $_POST['precio_compra'], $_POST['precio_venta'], $_POST['fecha_ingreso'], $_POST['image_text']) 
    || !is_numeric($_POST['id_producto']) 
    || !is_numeric($_POST['id_negocios'])
    || !is_numeric($_POST['id_usuario'])
    || !is_numeric($_POST['id_categoria'])) {


    $_SESSION['mensaje'] = "Error: Datos de formulario incompletos o inválidos.";
    $_SESSION['icono'] = "error";
    header('Location: ' . $URL . '/almacen/update.php?id=' . $_POST['id_producto']); // Redirect back to the form
    exit();  // Stop execution to prevent further errors
}



// Retrieve POST data
$id_producto = $_POST['id_producto'];
$id_negocios = $_POST['id_negocios'];
$id_usuario = $_POST['id_usuario'];
$id_categoria = $_POST['id_categoria'];
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$stock = $_POST['stock'];
$stock_minimo = $_POST['stock_minimo'];
$stock_maximo = $_POST['stock_maximo'];
$precio_compra = $_POST['precio_compra'];
$precio_venta = $_POST['precio_venta'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$image_text = $_POST['image_text'];



// Handle image upload
$imagen = $image_text;  // Default: Keep the original image
if (!empty($_FILES['image']['name'])) { // Check if a new image is uploaded

    $nombreDelArchivo = date("Y-m-d-h-i-s");
    $filename = $nombreDelArchivo . "__" . $_FILES['image']['name'];
    $location = "../../../almacen/img_productos/" . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $location)) {
        if ($image_text != 'default.jpg' && file_exists("../../../almacen/img_productos/" . $image_text)) {
            unlink("../../../almacen/img_productos/" . $image_text);  // Delete old image
        }
        $imagen = $filename;  // Update with the new image name
    } else {
        // Handle image upload error
        $_SESSION['mensaje'] = "Error al subir la imagen.  El producto se actualizó sin la nueva imagen.";
        $_SESSION['icono'] = "warning";

    }
}


try {
    $sentencia = $pdo->prepare("UPDATE tb_almacen SET
        codigo = :codigo,
        nombre = :nombre,
        descripcion = :descripcion,
        stock = :stock,
        stock_minimo = :stock_minimo,
        stock_maximo = :stock_maximo,
        precio_compra = :precio_compra,
        precio_venta = :precio_venta,
        fecha_ingreso = :fecha_ingreso,
        imagen = :imagen, 
        id_usuario = :id_usuario,
        id_categoria = :id_categoria,
        fyh_actualizacion = :fyh_actualizacion
        WHERE id_producto = :id_producto 
        AND id_negocios = :id_negocios");  // VERY IMPORTANT: Add business ID check

    // Bind parameters using named placeholders
    $sentencia->bindParam(':codigo', $codigo);
    $sentencia->bindParam(':nombre', $nombre);
    // ... bind other parameters
        $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT); // Bind id_negocios



    if ($sentencia->execute()) {
        // Success - redirect with success message
        $_SESSION['mensaje'] = "Se actualizó el producto correctamente.";
        $_SESSION['icono'] = "success";
    } else {
        // Error handling
        $_SESSION['mensaje'] = "Error al actualizar el producto: " . implode(", ", $sentencia->errorInfo()); // Detailed error message
        $_SESSION['icono'] = "error"; // Corrected icon
        header('Location: ' . $URL . '/almacen/update.php?id=' . $id_producto); // Redirect back to form with error
        exit(); // Terminate the script to avoid sending headers after output


    }


    header('Location: ' . $URL . '/almacen/');
    exit();  // Stop execution after redirect


} catch (PDOException $e) {
    // Exception handling
        $_SESSION['mensaje'] = "Error al actualizar el producto: " . $e->getMessage();
        $_SESSION['icono'] = "error";
        header('Location: ' . $URL . '/almacen/update.php?id=' . $id_producto);
        exit();
}

?>
