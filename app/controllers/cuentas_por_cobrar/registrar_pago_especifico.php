<?php
// app/controllers/cuentas_por_cobrar/registrar_pago_especifico.php
include('../../config.php');

// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    // Check if required fields are set and not empty
    if (isset($_POST['id_cuenta_especifico'], $_POST['monto_pago_especifico'], $_POST['id_negocio_especifico']) &&
        !empty($_POST['id_cuenta_especifico']) && !empty($_POST['monto_pago_especifico']) && !empty($_POST['id_negocio_especifico'])) {

        $id_cuenta = $_POST['id_cuenta_especifico'];
        $monto_pago = $_POST['monto_pago_especifico'];
        $id_negocios = $_POST['id_negocio_especifico'];

        // Get the current account details, including the current saldo_pendiente
        $stmt_cuenta = $pdo->prepare("SELECT saldo_pendiente, total_a_pagar, id_clients FROM tb_cuentas_por_cobrar WHERE id_cuentas_por_cobrar = :id_cuenta AND id_negocios = :id_negocios");
        $stmt_cuenta->bindParam(':id_cuenta', $id_cuenta, PDO::PARAM_INT);
        $stmt_cuenta->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
        $stmt_cuenta->execute();
        $cuenta_data = $stmt_cuenta->fetch(PDO::FETCH_ASSOC);

        if ($cuenta_data) {
            $saldo_pendiente_actual = $cuenta_data['saldo_pendiente'];
            $total_a_pagar = $cuenta_data['total_a_pagar'];
            $id_clients = $cuenta_data['id_clients'];

            // Check if the payment amount is valid
            if ($monto_pago <= 0 || $monto_pago > $saldo_pendiente_actual) {
                echo "Error: El monto del pago debe ser mayor a 0 y menor o igual al saldo pendiente.";
            } else {
                // Calculate the new saldo_pendiente
                $nuevo_saldo_pendiente = $saldo_pendiente_actual - $monto_pago;

                // Update the tb_cuentas_por_cobrar table with the new saldo_pendiente
                $stmt_update = $pdo->prepare("UPDATE tb_cuentas_por_cobrar SET saldo_pendiente = :nuevo_saldo WHERE id_cuentas_por_cobrar = :id_cuenta AND id_negocios = :id_negocios");
                $stmt_update->bindParam(':nuevo_saldo', $nuevo_saldo_pendiente, PDO::PARAM_INT);
                $stmt_update->bindParam(':id_cuenta', $id_cuenta, PDO::PARAM_INT);
                $stmt_update->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);

                if ($stmt_update->execute()) {
                    // Check if id_usuario is set in the session
                    
                    // Insert the payment record into tb_pagos
                    $stmt_pagos = $pdo->prepare("INSERT INTO tb_pagos (id_negocios, id_cuentas_por_cobrar, monto_pago, fyh_creacion)
                    VALUES (:id_negocios, :id_cuenta, :monto_pago, :fyh_creacion)");
                    $stmt_pagos->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
                    $stmt_pagos->bindParam(':id_cuenta', $id_cuenta, PDO::PARAM_INT);
                    $stmt_pagos->bindParam(':monto_pago', $monto_pago, PDO::PARAM_INT);
                    $stmt_pagos->bindParam(':fyh_creacion', $fechaHora);

                    if($stmt_pagos->execute()){
                        echo "Pago registrado correctamente.";
                    } else {
                        echo "Error al registrar pago";
                    }

                    // Check if the account is fully paid
                    if ($nuevo_saldo_pendiente == 0) {
                        $estado = 'Pagado';
                        $stmt_estado = $pdo->prepare("UPDATE tb_cuentas_por_cobrar SET estado = :estado WHERE id_cuentas_por_cobrar = :id_cuenta AND id_negocios = :id_negocios");
                        $stmt_estado->bindParam(':estado', $estado);
                        $stmt_estado->bindParam(':id_cuenta', $id_cuenta, PDO::PARAM_INT);
                        $stmt_estado->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
                        $stmt_estado->execute();
                    }

                } else {
                    echo "Error al actualizar el saldo pendiente.";
                }
            }
        } else {
            echo "Error: No se encontró la cuenta o no se tiene acceso a la misma.";
        }
    } else {
        echo "Error: Datos insuficientes para registrar el pago.";
    }
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?>
