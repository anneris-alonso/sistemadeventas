<?php
// app/controllers/clientes/create.php
include('../../config.php');

// Retrieve form data
$id_negocios = $_POST['id_negocios'];
$nombre_clt = $_POST['nombre_clt'];
$direccion_clt = $_POST['direccion_clt'];
$nacionalidad_clt = $_POST['nacionalidad_clt'];
$ciudadania_clt = $_POST['ciudadania_clt'];
$pasaporte_clt = $_POST['pasaporte_clt'];
$fecha_venc_pass_clt = $_POST['fecha_venc_pass_clt'];
$est_civil_clt = $_POST['est_civil_clt'];
$telefono_clt = $_POST['telefono_clt'];
$mail_clt = $_POST['mail_clt'];
$id_servicios = $_POST['id_servicios'];
$fecha_ini_tramite = $_POST['fecha_ini_tramite'];
$fecha_fin_tramite = $_POST['fecha_fin_tramite'];

//Image upload
$nombreDelArchivo = date("Y-m-d-h-i-s");
$filename = $nombreDelArchivo.'__'.$_FILES['image_clt']['name'];

$location = "../../../clientes/image_clt/".$filename;

move_uploaded_file($_FILES['image_clt']['tmp_name'], $location);

// First, insert the client data into tb_clients
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
        $stmt_servicio = $pdo->prepare("SELECT servicio, tipo, precio_final FROM tb_servicios WHERE id_servicios = :id_servicios");
        $stmt_servicio->bindParam(':id_servicios', $id_servicios, PDO::PARAM_INT);
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
                session_start();
                $_SESSION['mensaje'] = "El cliente se ha registrado correctamente.";
                $_SESSION['icono'] = "success";
                header('Location: '.$URL.'/clientes');
                exit();
            } else {
                 session_start();
                $_SESSION['mensaje'] = "Error al crear la cuenta por cobrar.";
                $_SESSION['icono'] = "error";
                header('Location: '.$URL.'/clientes/create.php');
                exit();
            }
        } else {
            session_start();
            $_SESSION['mensaje'] = "Error: Datos del servicio no encontrados.";
            $_SESSION['icono'] = "error";
            header('Location: '.$URL.'/clientes/create.php');
            exit();
        }
    } else {
        session_start();
        $_SESSION['mensaje'] = "Error al registrar el cliente en la base de datos.";
        $_SESSION['icono'] = "error";
        header('Location: '.$URL.'/clientes/create.php');
        exit();
    }
} catch (PDOException $e) {
     session_start();
    $_SESSION['mensaje'] = "Error en la base de datos: " . $e->getMessage();
    $_SESSION['icono'] = "error";
    header('Location: '.$URL.'/clientes/create.php');
    exit();
}
?>
