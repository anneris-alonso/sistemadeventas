<?php
include_once __DIR__ . '/../../../app/config.php';
session_start();

if (!isset($_SESSION["negocio_id"]) || !is_numeric($_SESSION["negocio_id"])) {
    die("Error: ID de negocio inválido.");
}

if (isset($_GET['id'])) {
    $id_cuentas_pagar = $_GET['id'];

    try {
        $sql_select = "SELECT cp.*, pr.nombre_proveedor as nombre_proveedor, us.nombres as nombres_usuario
                       FROM tb_cuentas_por_pagar as cp
                       INNER JOIN tb_proveedores as pr ON cp.id_proveedor = pr.id_proveedor
                       INNER JOIN tb_usuarios as us ON cp.id_usuario = us.id_usuario
                       WHERE cp.id_cuentas_pagar = :id_cuentas_pagar";

        $query_select = $pdo->prepare($sql_select);
        $query_select->bindParam(':id_cuentas_pagar', $id_cuentas_pagar);
        $query_select->execute();
        $cuenta = $query_select->fetch(PDO::FETCH_ASSOC);

        if ($cuenta) {
            // Display account details
?>

<?php
        } else {
            echo "Cuenta no encontrada.";
        }
    } catch (PDOException $e) {
        echo "Error de base de datos: " . $e->getMessage();
    }
} else {
    echo "ID de cuenta no proporcionado.";
}
?>