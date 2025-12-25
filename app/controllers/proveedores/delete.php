<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 12/2/2023
 * Time: 14:59
 */
include ('../../config.php');

$id_proveedor = $_GET['id_proveedor'];

// Obtener el ID del negocio del usuario (desde la sesión)
session_start();
$id_negocios = $_SESSION["negocio_id"]; 

$sentencia = $pdo->prepare("DELETE FROM tb_proveedores 
                            WHERE id_proveedor=:id_proveedor 
                            AND id_negocios = :id_negocios"); // Añadir la condición id_negocios

$sentencia->bindParam('id_proveedor',$id_proveedor);
$sentencia->bindParam('id_negocios', $id_negocios); // Añadir el id_negocios

if($sentencia->execute()){
    session_start();
    $_SESSION['mensaje'] = "Se elimino al proveedor de la manera correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/proveedores";
    </script>
    <?php
}else{
    session_start();
    $_SESSION['mensaje'] = "Error no se pudo eliminar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/proveedores";
    </script>
    <?php
}
?>