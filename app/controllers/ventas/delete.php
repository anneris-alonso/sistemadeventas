<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 5/3/2023
 * Time: 19:59
 */

include ('../../config.php');

$id_compra = $_GET['id_compra'];
$id_producto = $_GET['id_producto'];
$cantidad_compra = $_GET['cantidad_compra'];
$stock_actual = $_GET['stock_actual'];

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $id_negocios = $_SESSION["negocio_id"]; 
  }

$pdo->beginTransaction();

// Eliminar la compra solo si pertenece al negocio del usuario
$sentencia = $pdo->prepare("DELETE FROM tb_compras 
                            WHERE id_compra=:id_compra 
                            AND id_negocios = :id_negocios"); // Añadir la condición id_negocios

$sentencia->bindParam('id_compra',$id_compra);
$sentencia->bindParam('id_negocios', $id_negocios); // Añadir el id_negocios

if($sentencia->execute()){

    // Actualiza el stock (solo si el producto pertenece al negocio)
    $stock = $stock_actual - $cantidad_compra;
    $sentencia = $pdo->prepare("UPDATE tb_almacen 
                                SET stock=:stock 
                                WHERE id_producto = :id_producto 
                                AND id_negocios = :id_negocios"); // Añadir la condición id_negocios
    $sentencia->bindParam('stock',$stock);
    $sentencia->bindParam('id_producto',$id_producto);
    $sentencia->bindParam('id_negocios', $id_negocios); // Añadir el id_negocios
    $sentencia->execute();

    $pdo->commit();

    session_start();
    $_SESSION['mensaje'] = "Se borro la compra de la manera correcta";
    $_SESSION['icono'] = "success";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/compras";
    </script>
    <?php
}else{

    $pdo->rollBack();

    session_start();
    $_SESSION['mensaje'] = "Error no se pudo actualizar en la base de datos";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL;?>/compras";
    </script>
    <?php
}
?>