<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_producto_get = $_GET['id'];
    include('../app/controllers/almacen/cargar_producto.php');
    if (!isset($codigo)) {
        echo "Error al cargar los datos del producto.";
        exit();
    }
} else {
    echo "ID de producto inválido.";
    exit();
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('delete_product_title'); ?>: <?php echo $nombre; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="col-md-12">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('confirm_delete_product'); ?></h3>
                            </div>
                            <div class="card-body">
                                <form action="../app/controllers/almacen/delete.php" method="post">
                                    <input type="hidden" name="id_producto" value="<?php echo $id_producto_get; ?>">
                                    <input type="hidden" name="id_negocios"
                                        value="<?php echo $_SESSION['negocio_id']; ?>">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><?php echo __('code'); ?>:</label>
                                                <input type="text" class="form-control" value="<?php echo $codigo; ?>"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label><?php echo __('name'); ?>:</label>
                                                <input type="text" name="nombre" value="<?php echo $nombre; ?>"
                                                    class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo __('product_description'); ?>:</label>
                                        <textarea name="descripcion" cols="30" rows="2" class="form-control"
                                            disabled><?php echo $descripcion; ?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo __('category'); ?>:</label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo $nombre_categoria; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo __('stock'); ?>:</label>
                                                <input type="number" name="stock" value="<?php echo $stock; ?>"
                                                    class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo __('image'); ?>:</label><br>
                                        <img src="<?php echo $URL . "/almacen/img_productos/" . $imagen; ?>"
                                            width="200px" alt="" onerror="this.style.display='none'">
                                    </div>

                                    <hr>
                                    <div class="form-group text-center">
                                        <a href="index.php" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>
                                            <?php echo __('delete_product'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('../layout/mensajes.php'); ?>
    <?php include('../layout/parte2.php'); ?>