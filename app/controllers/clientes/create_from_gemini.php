<?php
// app/controllers/clientes/create_from_gemini.php
include('../../config.php');
session_start();

// Get the JSON data from the request
$jsonData = json_decode(file_get_contents('php://input'), true);

if (!$jsonData || !isset($jsonData['clientData'])) {
    echo json_encode(['error' => 'Invalid client data.']);
    exit;
}

$clientData = $jsonData['clientData'];

// Data validation and sanitization
$nombre_clt = isset($clientData['nombre_clt']) ? filter_var($clientData['nombre_clt'], FILTER_SANITIZE_STRING) : null;
$mail_clt = isset($clientData['mail_clt']) ? filter_var($clientData['mail_clt'], FILTER_SANITIZE_EMAIL) : null;
$telefono_clt = isset($clientData['telefono_clt']) ? filter_var($clientData['telefono_clt'], FILTER_SANITIZE_STRING) : null;
$direccion_clt = isset($clientData['direccion_clt']) ? filter_var($clientData['direccion_clt'], FILTER_SANITIZE_STRING) : null;
$nacionalidad_clt = isset($clientData['nacionalidad_clt']) ? filter_var($clientData['nacionalidad_clt'], FILTER_SANITIZE_STRING) : null;
$pasaporte_clt = isset($clientData['pasaporte_clt']) ? filter_var($clientData['pasaporte_clt'], FILTER_SANITIZE_STRING) : null;
$fecha_venc_pass_clt = isset($clientData['fecha_venc_pass_clt']) ? filter_var($clientData['fecha_venc_pass_clt'], FILTER_SANITIZE_STRING) : null;
$est_civil_clt = isset($clientData['est_civil_clt']) ? filter_var($clientData['est_civil_clt'], FILTER_SANITIZE_STRING) : null;
$id_servicios = isset($clientData['id_servicios']) ? filter_var($clientData['id_servicios'], FILTER_SANITIZE_NUMBER_INT) : null;
$fecha_ini_tramite = isset($clientData['fecha_ini_tramite']) ? filter_var($clientData['fecha_ini_tramite'], FILTER_SANITIZE_STRING) : null;
$fecha_fin_tramite = isset($clientData['fecha_fin_tramite']) ? filter_var($clientData['fecha_fin_tramite'], FILTER_SANITIZE_STRING) : null;
$id_negocios = isset($clientData['id_negocios']) ? filter_var($clientData['id_negocios'], FILTER_SANITIZE_NUMBER_INT) : null;

// Basic validation
if (empty($nombre_clt) || empty($mail_clt)) {
    echo json_encode(['error' => 'Name and email are required.']);
    exit;
}
if (empty($id_servicios)) {
    echo json_encode(['error' => 'Service is required.']);
    exit;
}
if (empty($id_negocios)) {
    echo json_encode(['error' => 'Business ID is required.']);
    exit;
}

// Set default values for missing fields
$ciudadania_clt = "";
$filename = "default.jpg";

// Database insertion
try {
    $sentencia = $pdo->prepare("INSERT INTO tb_clients (
        id_negocios, nombre_clt, direccion_clt, nacionalidad_clt, ciudadania_clt, pasaporte_clt, 
        fecha_venc_pass_clt, est_civil_clt, telefono_clt, mail_clt, image_clt, id_servicios, fecha_ini_tramite, fecha_fin_tramite, fyh_creacion
    ) VALUES (
        :id_negocios, :nombre_clt, :direccion_clt, :nacionalidad_clt, :ciudadania_clt, :pasaporte_clt, 
        :fecha_venc_pass_clt, :est_civil_clt, :telefono_clt, :mail_clt, :image_clt, :id_servicios, :fecha_ini_tramite, :fecha_fin_tramite, :fyh_creacion
    )");

    $sentencia->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
    $sentencia->bindParam(':nombre_clt', $nombre_clt);
    $sentencia->bindParam(':direccion_clt', $direccion_clt);
    $sentencia->bindParam(':nacionalidad_clt', $nacionalidad_clt);
    $sentencia->bindParam(':ciudadania_clt', $ciudadania_clt);
    $sentencia->bindParam(':pasaporte_clt', $pasaporte_clt);
    $sentencia->bindParam(':fecha_venc_pass_clt', $fecha_venc_pass_clt);
    $sentencia->bindParam(':est_civil_clt', $est_civil_clt);
    $sentencia->bindParam(':telefono_clt', $telefono_clt);
    $sentencia->bindParam(':mail_clt', $mail_clt);
    $sentencia->bindParam(':image_clt', $filename);
    $sentencia->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
    $sentencia->bindParam(':fecha_ini_tramite', $fecha_ini_tramite);
    $sentencia->bindParam(':fecha_fin_tramite', $fecha_fin_tramite);
    $sentencia->bindParam(':fyh_creacion', $fechaHora);

    if ($sentencia->execute()) {
        $id_clients = $pdo->lastInsertId(); // Get the ID of the newly created client

        // Now, fetch the service details
        $stmt_servicio = $pdo->prepare("SELECT servicio, tipo, precio_final FROM tb_servicios WHERE id_servicios = :id_servicios AND id_negocios = :id_negocios");
        $stmt_servicio->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
        $stmt_servicio->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
        $stmt_servicio->execute();
        $servicio_data = $stmt_servicio->fetch(PDO::FETCH_ASSOC);

        // Ensure the service data is fetched correctly
        if ($servicio_data) {
            $id_servicios = $servicio_data['id_servicios'];
            $total_a_pagar = $servicio_data['precio_final'];
            $saldo_pendiente = $total_a_pagar; // Initially, the entire amount is pending

            // Then, insert a new record into tb_cuentas_por_cobrar
            $stmt_cuenta = $pdo->prepare("INSERT INTO tb_cuentas_por_cobrar (
                id_clients, id_negocios, id_servicios, total_a_pagar, saldo_pendiente, estado, fyh_creacion
            ) VALUES (
                :id_clients, :id_negocios, :id_servicios, :total_a_pagar, :saldo_pendiente, :estado, :fyh_creacion
            )");

            $estado = 'Pendiente'; // Default status
            $stmt_cuenta->bindParam(':id_clients', $id_clients, PDO::PARAM_INT);
            $stmt_cuenta->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
            $stmt_cuenta->bindParam(':id_servicios', $id_servicios);
            $stmt_cuenta->bindParam(':total_a_pagar', $total_a_pagar, PDO::PARAM_INT);
            $stmt_cuenta->bindParam(':saldo_pendiente', $saldo_pendiente, PDO::PARAM_INT);
            $stmt_cuenta->bindParam(':estado', $estado);
            $stmt_cuenta->bindParam(':fyh_creacion', $fechaHora);

            if ($stmt_cuenta->execute()) {
                echo json_encode(['success' => 'Client created successfully.']);
                exit();
            } else {
                echo json_encode(['error' => 'Error creating the account receivable.']);
                exit();
            }
        } else {
            echo json_encode(['error' => 'Error: Service data not found.']);
            exit();
        }
    } else {
        echo json_encode(['error' => 'Error creating the client in the database.']);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}
?>
