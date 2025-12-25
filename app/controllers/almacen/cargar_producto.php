<?php
// Inside cargar_producto.php
if (isset($_GET['id']) && is_numeric($_GET['id'])) { // Important validation
    $id_producto_get = $_GET['id'];

    try {
        $query_productos = $pdo->prepare("SELECT * FROM tb_almacen WHERE id_producto = :id_producto AND id_negocios = :id_negocios");
        $query_productos->bindValue(':id_producto', $id_producto_get, PDO::PARAM_INT);

        $id_negocios = $_SESSION['negocio_id']; // VERY IMPORTANT! Add business ID check.
        $query_productos->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT);


        $query_productos->execute();

        // Only fetch if the query was successful:
        if ($productos_datos = $query_productos->fetch(PDO::FETCH_ASSOC)) {
            $codigo = $productos_datos['codigo']; // Access fields only after successful fetch
            $nombre = $productos_datos['nombre'];
            $id_categoria = $productos_datos['id_categoria'];  // Or however you get this
            $descripcion = $productos_datos['descripcion'];
            $stock = $productos_datos['stock'];
            $stock_minimo = $productos_datos['stock_minimo'];
            $stock_maximo = $productos_datos['stock_maximo'];
            $precio_compra = $productos_datos['precio_compra'];
            $precio_venta = $productos_datos['precio_venta'];
            $fecha_ingreso = $productos_datos['fecha_ingreso'];  
            $id_usuario = $productos_datos['id_usuario'];  // Assign the user's email HERE
            $imagen = isset($productos_datos['imagen']) && !is_null($productos_datos['imagen']) ? $productos_datos['imagen'] : 'default.jpg'; // Provide a default image
        } else {
            die("Producto no encontrado o no pertenece a este negocio."); // Important error handling
        }
    } catch (PDOException $e) {
        die("Error en la consulta: " . $e->getMessage());
    }


} else {
    die("ID de producto inválido."); // or redirect
}

?>

