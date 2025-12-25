<?php
// app/controllers/banco/listado_de_banco.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Validate the business ID
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"];
} else {
    // Handle the error if the business ID is invalid
    die("Error: ID de negocio inválido.");
}

// Fetch the current bank balance
$query_balance = $pdo->prepare("SELECT saldo_actual FROM tb_banco WHERE id_negocios = :id_negocios ORDER BY fecha_hora DESC LIMIT 1");
$query_balance->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
$query_balance->execute();
$balance_data = $query_balance->fetch(PDO::FETCH_ASSOC);
$saldo_actual = $balance_data ? $balance_data['saldo_actual'] : 0.00; // Default to 0 if no balance found

// Fetch the last transactions
$query_transactions = $pdo->prepare("SELECT tipo, descripcion, monto, fecha_hora FROM tb_banco WHERE id_negocios = :id_negocios ORDER BY fecha_hora DESC LIMIT 10");
$query_transactions->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
$query_transactions->execute();
$transacciones_datos = $query_transactions->fetchAll(PDO::FETCH_ASSOC);
?>
