<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 18/1/2023
 * Time: 15:17
 */

// (Asumo que session_start() se llama al principio de la aplicación)

// Validar el ID del negocio
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"];
} else {
    // Manejar el error si el ID del negocio no es válido
    die("Error: ID de negocio inválido.");
}

try {
    $sql_usuarios = "SELECT us.id_usuario as id_usuario, us.nombres as nombres, us.email as email, rol.rol as rol, us.salario as salario, us.num_permiso_trabajo as num_permiso_trabajo, us.seguro_medico as seguro_medico, us.tipo_empleado as tipo_empleado
                    FROM tb_usuarios as us
                    INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol
                    WHERE us.id_negocios = :id_negocios";

    $query_usuarios = $pdo->prepare($sql_usuarios);
    $query_usuarios->bindParam(':id_negocios', $id_negocios);
    $query_usuarios->execute();
    $usuarios_datos = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se encontraron usuarios
    if (empty($usuarios_datos)) {
        echo "No se encontraron usuarios para este negocio.";
    }

} catch (PDOException $e) {
    // Manejar el error de la consulta
    die("Error en la consulta: " . $e->getMessage());
}
?>