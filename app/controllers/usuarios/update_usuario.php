<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 19/1/2023
 * Time: 22:40
 */

// Asumo que `session_start()` se llama al principio de la aplicación
// y que `$pdo` está definido en tu archivo `config.php`

// Validar el ID del negocio
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"];
} else {
    die("Error: ID de negocio inválido.");
}

// Obtener el ID del usuario de la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = $_GET['id'];
} else {
    die("Error: ID de usuario inválido.");
}

try {
    $sql_usuarios = "SELECT us.id_usuario as id_usuario, us.nombres as nombres, us.email as email, rol.rol as rol, us.salario as salario, us.num_permiso_trabajo as num_permiso_trabajo, us.seguro_medico as seguro_medico, us.tipo_empleado as tipo_empleado
                    FROM tb_usuarios as us
                    INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol
                    WHERE id_usuario = :id_usuario
                    AND us.id_negocios = :id_negocios";

    $query_usuarios = $pdo->prepare($sql_usuarios);
    $query_usuarios->bindParam(':id_usuario', $id_usuario);
    $query_usuarios->bindParam(':id_negocios', $id_negocios);
    $query_usuarios->execute();
    $usuarios_datos = $query_usuarios->fetch(PDO::FETCH_ASSOC);

    if ($usuarios_datos) {
        // Asignar las variables con los datos del usuario
        $nombres = $usuarios_datos['nombres'];
        $email = $usuarios_datos['email'];
        $rol = $usuarios_datos['rol']; // Obtener el nombre del rol directamente
        $salario = $usuarios_datos['salario'];
        $num_permiso_trabajo = $usuarios_datos['num_permiso_trabajo'];
        $seguro_medico = $usuarios_datos['seguro_medico'];
        $tipo_empleado = $usuarios_datos['tipo_empleado'];
    } else {
        // Manejar el caso en que no se encuentren resultados
        echo "No se encontró ningún usuario con ese ID.";
        // O puedes redirigir al usuario a otra página
        // header('Location: ' . $URL . '/usuarios/');
        exit(); // Detener la ejecución del script
    }

} catch (PDOException $e) {
    // Manejar el error de la consulta
    die("Error en la consulta: " . $e->getMessage());
}
?>