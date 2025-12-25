<?php
// app/controllers/cuentas_por_cobrar/cargar_cuenta.php

// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check for negocio_id in session
if (!isset($_SESSION["negocio_id"]) || !is_numeric($_SESSION["negocio_id"])) {
    // Handle error: redirect or display an error message
    die("Error: ID de negocio inválido.");
}

$id_negocios = $_SESSION["negocio_id"];

// Get the account id.
if(!isset($_GET['id_cuenta'])){
    die('No se recibio id_cuenta');
}

$id_cuenta = $_GET['id_cuenta'];

// Modified query for cuentas_por_cobrar
$sql_cuentas = "SELECT cxc.*,
                    us.nombres as nombres_usuario,
                    ser.servicio as nombre_servicio, 
                    ser.tipo as tipo_servicio,
                    ser.precio_serv as precio_servicio
                    FROM tb_cuentas_por_cobrar as cxc 
                    INNER JOIN tb_usuarios as us ON cxc.id_usuario = us.id_usuario
                    INNER JOIN tb_servicios as ser ON cxc.id_servicios = ser.id_servicios
                    WHERE cxc.id_negocios = :id_negocios AND cxc.id_cuenta = :id_cuenta"; // Use the new table name
$query_cuentas = $pdo->prepare($sql_cuentas);
$query_cuentas->bindParam(':id_negocios', $id_negocios);
$query_cuentas->bindParam(':id_cuenta', $id_cuenta);
$query_cuentas->execute();

$cuentas_datos = $query_cuentas->fetchAll(PDO::FETCH_ASSOC);

// Check if a record was found
if (count($cuentas_datos) > 0) {
    $cuentas_dato = $cuentas_datos[0]; // Get the first record

    // Populate variables
    $id_cuenta_get = $cuentas_dato['id_cuenta'];
    $id_usuario = $cuentas_dato['id_usuario'];
    $id_servicios = $cuentas_dato['id_servicios'];
    $nombres_usuario = $cuentas_dato['nombres_usuario'];
    $nombre_servicio = $cuentas_dato['nombre_servicio'];
    $tipo_servicio = $cuentas_dato['tipo_servicio'];
    $precio_servicio = $cuentas_dato['precio_servicio'];
    $total_a_pagar = $cuentas_dato['total_a_pagar'];
    $condicion_especial = $cuentas_dato['condicion_especial'];
    $descripcion = $cuentas_dato['descripcion'];
} else {
    // Handle the case where no record is found
    die("No se encontró la cuenta por cobrar.");
}
?>
