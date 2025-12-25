<?php // clientes/update.php (handles both inline and regular updates)
include('../../config.php');
session_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$id_negocios = $_SESSION['negocio_id'];

// Input validation and sanitization (Improve this - add more checks as needed)
$id_client = isset($_POST['id_client']) && is_numeric($_POST['id_client'])? intval($_POST['id_client']): null;
$id_negocios_form = isset($_POST['id_negocios']) && is_numeric($_POST['id_negocios'])? intval($_POST['id_negocios']): null;


if (!$id_client ||!$id_negocios_form) {
    die("ID de cliente o de negocio inválido.");
}



//Basic validation for other fields (Improve this validation, by filtering and checking against database if needed)
$nombre_clt = isset($_POST['nombre_clt'])? filter_var($_POST['nombre_clt'], FILTER_SANITIZE_STRING): null;
$direccion_clt = isset($_POST['direccion_clt'])? filter_var($_POST['direccion_clt'], FILTER_SANITIZE_STRING): null;
$nacionalidad_clt = isset($_POST['nacionalidad_clt'])? filter_var($_POST['nacionalidad_clt'], FILTER_SANITIZE_STRING): null;
$ciudadania_clt = isset($_POST['ciudadania_clt'])? filter_var($_POST['ciudadania_clt'], FILTER_SANITIZE_STRING): null;
$pasaporte_clt = isset($_POST['pasaporte_clt'])? filter_var($_POST['pasaporte_clt'], FILTER_SANITIZE_STRING): null;
$fecha_venc_pass_clt = isset($_POST['fecha_venc_pass_clt'])? $_POST['fecha_venc_pass_clt']: null; // Assuming date format is validated in the form
$est_civil_clt = isset($_POST['est_civil_clt'])? filter_var($_POST['est_civil_clt'], FILTER_SANITIZE_STRING): null;
$telefono_clt = isset($_POST['telefono_clt'])? filter_var($_POST['telefono_clt'], FILTER_SANITIZE_NUMBER_INT): null;
$mail_clt = isset($_POST['mail_clt'])? filter_var($_POST['mail_clt'], FILTER_SANITIZE_EMAIL): null;
$id_servicios = isset($_POST['id_servicios'])? intval($_POST['id_servicios']): null;
$status_clt = isset($_POST['status_clt'])? intval($_POST['status_clt']): null;
$current_image = isset($_POST['image_text'])? $_POST['image_text']: 'default.jpg'; // Use image_text for the current image


//... (Other data handling if necessary)

// Date Handling
$fecha_ini_tramite = isset($_POST['fecha_ini_tramite'])? $_POST['fecha_ini_tramite']: null;
$fecha_fin_tramite = isset($_POST['fecha_fin_tramite'])? $_POST['fecha_fin_tramite']: null;

if ($fecha_ini_tramite && ($fecha_ini_tramite === '0000-00-00' ||!strtotime($fecha_ini_tramite))) {
    $fecha_ini_tramite = null;
}

if (empty($fecha_fin_tramite) || $fecha_fin_tramite === '0000-00-00' ||!strtotime($fecha_fin_tramite)) {
    $fecha_fin_tramite = null;
}

try {

    if ($id_negocios!== $id_negocios_form) {
        throw new Exception("Unauthorized access.");
    }




    // Handle both regular form updates and inline edits
    if (isset($_POST['updatedData']) && is_array($_POST['updatedData'])) { // Check if it's an inline edit

        $updatedData = $_POST['updatedData'];

        $updateFields = [];
        $params = []; // Initialize $params

        foreach ($updatedData as $column => $value) {
            if (is_array($value)) {
                $value = $value;
            }
            $updateFields = "$column =:$column";
            $params[":$column"] = $value;
        }

        $updateString = implode(', ', $updateFields);
        $sql = "UPDATE tb_clients SET $updateString WHERE id_clients =:id_client AND id_negocios =:id_negocios";


    } else {  // Regular form update

        //Regular update SQL query (all fields except image)
        $sql = "UPDATE tb_clients SET 
                    nombre_clt =:nombre_clt,
                    direccion_clt =:direccion_clt,
                    nacionalidad_clt =:nacionalidad_clt,
                    ciudadania_clt =:ciudadania_clt,
                    pasaporte_clt =:pasaporte_clt,
                    fecha_venc_pass_clt =:fecha_venc_pass_clt,
                    est_civil_clt =:est_civil_clt,
                    telefono_clt =:telefono_clt,
                    mail_clt =:mail_clt,
                    id_servicios =:id_servicios,
                    status_clt =:status_clt,
                    fecha_ini_tramite =:fecha_ini_tramite,
                    fecha_fin_tramite =:fecha_fin_tramite
                    WHERE id_clients =:id_client AND id_negocios =:id_negocios";


        $params = [
            ':nombre_clt' => $nombre_clt,
            ':direccion_clt' => $direccion_clt,
            ':nacionalidad_clt' => $nacionalidad_clt,
            ':ciudadania_clt' => $ciudadania_clt,
            ':pasaporte_clt' => $pasaporte_clt,
            ':fecha_venc_pass_clt' => $fecha_venc_pass_clt,
            ':est_civil_clt' => $est_civil_clt,
            ':telefono_clt' => $telefono_clt,
            ':mail_clt' => $mail_clt,
            ':id_servicios' => $id_servicios,
            ':status_clt' => $status_clt,
            ':fecha_ini_tramite' => $fecha_ini_tramite,
            ':fecha_fin_tramite' => $fecha_fin_tramite,
            ':id_client' => $id_client,
            ':id_negocios' => $id_negocios
        ];





    }



    //Debugging
    // var_dump($sql);
    // var_dump($params);
    // exit();

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);



    //Image Upload Handling
    if (isset($_FILES['image_clt']) && $_FILES['image_clt']['error'] === UPLOAD_ERR_OK) {
        $nombreDelArchivo = date("Y-m-d-h-i-s");
        $filename = $nombreDelArchivo."__".$_FILES['image_clt']['name'];
        $location = "../../../clientes/image_clt/".$filename;

        if (move_uploaded_file($_FILES['image_clt']['tmp_name'], $location)) {
            // Update the image_clt field in the database
            $update_image_sql = "UPDATE tb_clients SET image_clt =:image_clt WHERE id_clients =:id_client";
            $update_image_stmt = $pdo->prepare($update_image_sql);
            $update_image_stmt->execute([':image_clt' => $filename, ':id_client' => $id_client]);
        } else {
            // Handle image upload error
            $_SESSION['mensaje'] = "Error al subir la imagen.";
            $_SESSION['icono'] = "error";
            header('Location: '. $URL. '/clientes/update.php?id='. $id_client);
            exit();
        }
    }


    if (isset($_POST['updatedData'])) { // Check if it's an inline edit
        echo "Cliente actualizado correctamente.";


    } else {
        $_SESSION['mensaje'] = "El cliente se actualizó correctamente.";
        $_SESSION['icono'] = "success";

        header('Location: '. $URL. '/clientes/');
        exit();

    }





} catch (PDOException $e) {


    if (isset($_POST['updatedData'])) {
        echo "Error en la base de datos: ". $e->getMessage();


    } else {
        $_SESSION['mensaje'] = "Error en la base de datos: ". $e->getMessage();
        $_SESSION['icono'] = "error";
        header('Location: '. $URL. '/clientes/update.php?id='. $id_client);
        exit();

    }

}
?>