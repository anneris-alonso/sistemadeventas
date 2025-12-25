<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 18/1/2023
 * Time: 15:39
 */

include ('../../config.php');

$nombres = $_POST['nombres'];
$email = $_POST['email'];
$rol = $_POST['rol'];
$password_user = $_POST['password_user'];
$password_repeat = $_POST['password_repeat'];
$salario = $_POST['salario'];
$num_permiso_trabajo = $_POST['num_permiso_trabajo'];
$seguro_medico = $_POST['seguro_medico'];
$tipo_empleado = $_POST['tipo_empleado'];


if($password_user == $password_repeat){
    $password_user = password_hash($password_user, PASSWORD_DEFAULT);

    // Obtener el ID del negocio del administrador (desde la sesión)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $id_negocios = $_SESSION["negocio_id"];
    }

    $sentencia = $pdo->prepare("INSERT INTO tb_usuarios
        ( nombres, email, id_rol, password_user, fyh_creacion, id_negocios, salario, num_permiso_trabajo, seguro_medico, tipo_empleado) 
    VALUES (:nombres,:email,:id_rol,:password_user,:fyh_creacion, :id_negocios, :salario, :num_permiso_trabajo, :seguro_medico, :tipo_empleado)");

    $sentencia->bindParam('nombres',$nombres);
    $sentencia->bindParam('email',$email);
    $sentencia->bindParam('id_rol',$rol);
    $sentencia->bindParam('password_user',$password_user);
    $sentencia->bindParam('fyh_creacion',$fechaHora);
    $sentencia->bindParam('id_negocios', $id_negocios);
    $sentencia->bindParam('salario', $salario);
    $sentencia->bindParam('num_permiso_trabajo', $num_permiso_trabajo);
    $sentencia->bindParam('seguro_medico', $seguro_medico);
    $sentencia->bindParam('tipo_empleado', $tipo_empleado);
    $sentencia->execute();

    session_start();
    $_SESSION['mensaje'] = "Se registro al usuario de la manera correcta";
    header('Location: '.$URL.'/usuarios/');

}else{
    session_start();
    $_SESSION['mensaje'] = "Error las contraseñas no son iguales";
    header('Location: '.$URL.'/usuarios/create.php');
}
?>