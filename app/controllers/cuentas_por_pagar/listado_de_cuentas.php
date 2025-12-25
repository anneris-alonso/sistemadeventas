<?php


// Validate the business ID
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"];
} else {
    // Handle the error if the business ID is invalid
    die("Error: ID de negocio inválido.");
}

// Modified query for cuentas_por_pagar - Now it use tb_cuentas_por_pagar table
$sql_cuentas = "SELECT cp.*,
                        pr.nombre_proveedor as nombre_proveedor
                        FROM cuentas_por_pagar as cp 
                        INNER JOIN tb_proveedores as pr ON cp.id_proveedor = pr.id_proveedor
                        WHERE cp.id_negocios = :id_negocios";

$query_cuentas = $pdo->prepare($sql_cuentas);
$query_cuentas->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
$query_cuentas->execute();
$cuentas_datos = $query_cuentas->fetchAll(PDO::FETCH_ASSOC);
?>
