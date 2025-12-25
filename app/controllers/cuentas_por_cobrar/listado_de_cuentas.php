<?php

if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    // Handle error: redirect or display an error message
    die("Error: ID de negocio inválido.");
}
$id_negocios = $_SESSION["negocio_id"];

// Modify the query for accounts receivable
$sql_cuentas = "SELECT 
                        cxc.id_cuentas_por_cobrar,
                        cl.nombre_clt AS nombres_cliente,
                        se.servicio AS servicio,
                        pr.nombre as producto,
                        cxc.tipo_venta AS tipo,
                        cxc.total_a_pagar AS total_a_pagar,
                        cxc.saldo_pendiente AS saldo_pendiente,
                        cxc.estado AS estado,
                        cxc.id_negocios AS id_negocios
                    FROM tb_cuentas_por_cobrar cxc
                    INNER JOIN tb_clients cl ON cxc.id_clients = cl.id_clients
                    LEFT JOIN tb_servicios se ON cxc.id_servicios = se.id_servicios
                    LEFT JOIN tb_almacen pr ON cxc.id_producto = pr.id_producto
                    WHERE cxc.id_negocios = :id_negocios";

$query_cuentas = $pdo->prepare($sql_cuentas);
$query_cuentas->bindParam(':id_negocios', $id_negocios);
$query_cuentas->execute();
$cuentas_datos = $query_cuentas->fetchAll(PDO::FETCH_ASSOC);

?>
