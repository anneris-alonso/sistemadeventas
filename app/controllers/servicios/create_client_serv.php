<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 18/1/2023
 * Time: 15:39
 */

include ('../../config.php');

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validar el ID del negocio
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"]; 
} else {
    // Manejar el error si el ID del negocio no es válido
    die("Error: ID de negocio inválido."); 
}

// Validar y obtener los datos del formulario
$servicio = isset($_POST['servicio']) ? $_POST['servicio'] : "";
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : "";
$precio_de_compra = isset($_POST['precio_de_compra']) ? $_POST['precio_de_compra'] : "";
$precio_serv = isset($_POST['precio_serv']) ? $_POST['precio_serv'] : "";
$duracion = isset($_POST['duracion']) ? $_POST['duracion'] : "";
$impuesto = isset($_POST['impuesto']) ? $_POST['impuesto'] : "0.00"; // Default to 0% if not provided
$ganancias = isset($_POST['ganancias']) ? $_POST['ganancias'] : "";


// Validar que los campos no estén vacíos
if (empty($servicio) || empty($tipo) || empty($precio_serv)) {
   echo "<script>
            alert('Error: Debe proporcionar un nombre de servicio, un tipo y el precio.');
            window.location.href = '".$URL."/servicios/create.php'; 
          </script>";
    exit(); // Detener la ejecución del script si hay un error
}
// Calculate precio_final
$precio_serv = floatval($precio_serv);
$impuesto = floatval($impuesto);
$precio_final = $precio_serv + ($precio_serv * ($impuesto / 100));

try {
    $sentencia = $pdo->prepare("INSERT INTO tb_servicios (servicio, tipo,precio_de_compra , precio_serv, id_negocios, duracion, impuesto, precio_final, ganancias) 
                                    VALUES (:servicio, :tipo, :precio_de_compra, :precio_serv, :id_negocios, :duracion, :impuesto, :precio_final, :ganancias)");

    $sentencia->bindParam(':servicio', $servicio);
    $sentencia->bindParam(':tipo', $tipo);
    $sentencia->bindParam(':precio_serv', $precio_serv);
    $sentencia->bindParam(':precio_de_compra', $precio_de_compra);
    $sentencia->bindParam(':id_negocios', $id_negocios);
    $sentencia->bindParam(':duracion', $duracion);
    $sentencia->bindParam(':impuesto', $impuesto);
    $sentencia->bindParam(':precio_final', $precio_final);
    $sentencia->bindParam(':ganancias', $ganancias);


    if ($sentencia->execute()) {
        // Obtener el ID del nuevo servicio insertado
        $id_nuevo_servicio = $pdo->lastInsertId();

        // Devolver el código HTML de la nueva opción para el select con el atributo selected
        echo "<option value='" . $id_nuevo_servicio . "' selected>" . $servicio . " - " . $tipo . "</option>";
    } else {
        echo "<script>
                alert('Error no se pudo registrar en la base de datos.');
                window.location.href = '".$URL."/clientes/create.php'; 
              </script>";
    }
} catch (PDOException $e) {
    // Manejar el error de la consulta (puedes registrar el error en un archivo)
    error_log("Error en la consulta: " . $e->getMessage());
    die("Error al crear el servicio.");
}
?>
