<?php
if (isset($_SESSION["negocio_id"]) && is_numeric($_SESSION["negocio_id"])) {
    $id_negocios = $_SESSION["negocio_id"]; 
} else {
    // Manejar el error si el ID del negocio no es válido
    die("Error: ID de negocio inválido."); 
}

try {
    $sql_productos = "SELECT id_producto, nombre, codigo, id_categoria, imagen, descripcion, stock, stock_minimo, stock_maximo , precio_compra, precio_venta, fecha_ingreso, u.email
                  FROM tb_almacen p
                  INNER JOIN tb_usuarios u ON p.id_usuario = u.id_usuario
                  WHERE p.id_negocios = :id_negocios";


    $query_productos = $pdo->prepare($sql_productos);
    $query_productos->bindParam(':id_negocios', $id_negocios); 
    $query_productos->execute();
    $productos_datos = $query_productos->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se encontraron productos (opcional)
    

} catch (PDOException $e) {
    // Manejar el error de la consulta
    die("Error en la consulta: " . $e->getMessage()); 
}
?>