<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 19/1/2023
 * Time: 22:11
 */

// Get the user ID.  Use $_GET['id'] because that's what's passed in the URL.
$id_usuario_get = $_GET['id'];

$sql_usuarios = "SELECT us.id_usuario as id_usuario, us.nombres as nombres, us.email as email, rol.rol as rol, us.salario as salario, us.num_permiso_trabajo as num_permiso_trabajo, us.seguro_medico as seguro_medico, us.tipo_empleado as tipo_empleado
                FROM tb_usuarios as us INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol
                WHERE id_usuario = :id_usuario";
$query_usuarios = $pdo->prepare($sql_usuarios);
$query_usuarios->bindParam(':id_usuario', $id_usuario_get, PDO::PARAM_INT);
$query_usuarios->execute();

// Fetch the data. Use fetch() as we expect only one row.
$usuarios_datos = $query_usuarios->fetch(PDO::FETCH_ASSOC);


if ($usuarios_datos) { // Check if a user was found
    $nombres = $usuarios_datos['nombres'];
    $email = $usuarios_datos['email'];
    $rol = $usuarios_datos['rol'];
    $salario = $usuarios_datos['salario'];
    $num_permiso_trabajo = $usuarios_datos['num_permiso_trabajo'];
    $seguro_medico = $usuarios_datos['seguro_medico'];
    $tipo_empleado = $usuarios_datos['tipo_empleado'];
} else {
    // Handle the case where no user was found
    echo "Usuario no encontrado."; // Or redirect, as shown previously
    exit(); // Important: stop execution to prevent further errors
}
?>