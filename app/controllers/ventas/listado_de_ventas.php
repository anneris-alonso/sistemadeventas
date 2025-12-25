<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 12/2/2023
 * Time: 18:45
 */

// Obtener el ID del negocio del usuario (desde la sesión)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $id_negocios = $_SESSION["negocio_id"]; 
  }

$sql_compras = "SELECT *,
                    pro.codigo as codigo, pro.nombre as nombre_producto, pro.descripcion as descripcion, pro.stock as stock, 
                    pro.stock_minimo as stock_minimo, pro.stock_maximo as stock_maximo,pro.precio_compra as precio_compra_producto,
                    pro.precio_venta as precio_venta_producto, pro.fecha_ingreso as fecha_ingreso,pro.imagen as imagen,
                    cat.nombre_categoria as nombre_categoria, us.nombres as nombre_usuarios_producto,
                    prov.nombre_proveedor as nombre_proveedor,prov.celular as celular_proveedor, prov.telefono as telefono_proveedor,
                    prov.empresa as empresa,prov.email as email_proveedor,prov.direccion as direccion_proveedor, us.nombres as nombres_usuario 
                    FROM tb_compras as co 
                    INNER JOIN tb_almacen as pro ON co.id_producto = pro.id_producto 
                    INNER JOIN tb_categorias as cat ON cat.id_categoria = pro.id_categoria
                    INNER JOIN tb_usuarios as us ON co.id_usuario = us.id_usuario 
                    INNER JOIN tb_proveedores as prov ON co.id_proveedor = prov.id_proveedor
                    WHERE co.id_negocios = :id_negocios"; // Añadir la condición id_negocios

$query_compras = $pdo->prepare($sql_compras);
$query_compras->bindParam(':id_negocios', $id_negocios); // Añadir el id_negocios
$query_compras->execute();
$compras_datos = $query_compras->fetchAll(PDO::FETCH_ASSOC);
$query_ventas = "SELECT MAX(nro_venta) AS ultima_venta FROM tb_ventas WHERE id_negocios = :id_negocios"; // Get the highest current sale number
$query_ventas = $pdo->prepare($query_ventas); // Prepare the query with PDO
$query_ventas->bindParam(':id_negocios', $_SESSION['negocio_id'], PDO::PARAM_INT); // Bind the parameter
$query_ventas->execute(); // Execute the query


$row_venta = $query_ventas->fetch(PDO::FETCH_ASSOC);


$ultima_venta = $row_venta['ultima_venta'];

if ($ultima_venta == null || $ultima_venta == "") { // Handle cases where no previous sales exist
    $contador_de_ventas = 1;
} else {
    $contador_de_ventas = $ultima_venta + 1;
}
?>