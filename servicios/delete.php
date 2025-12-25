<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');


// Validate and sanitize the ID.
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_servicio = intval($_GET['id']);
} else {
    die("ID de servicio no válido.");
}

// Now include the *correct* controller for a *single* service
include('../app/controllers/servicios/fetch_service_by_id.php');  // Include AFTER validating id


?>

<div class="content-wrapper">

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('confirm_delete_service'); ?></h3>
                        </div>

                        <div class="card-body">
                            <form action="../app/controllers/servicios/delete_servicios.php" method="post">
                                <input type="hidden" name="id_servicio" value="<?php echo $id_servicio; ?>">
                                <input type="hidden" name="id_negocios" value="<?php echo $_SESSION['negocio_id']; ?>">

                                <div class="form-group">
                                    <label><?php echo __('service_name'); ?>:</label>
                                    <input type="text" class="form-control" value="<?php echo $servicio; ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <label><?php echo __('service_type'); ?>:</label>
                                    <input type="text" class="form-control" value="<?php echo $tipo; ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <label><?php echo __('base_price'); ?>:</label>
                                    <input type="text" class="form-control" value="<?php echo $precio_serv; ?>"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label><?php echo __('tax'); ?>:</label>
                                    <input type="text" class="form-control" value="<?php echo $impuesto; ?>" disabled>
                                </div>

                                <div class="form-group">
                                    <label><?php echo __('final_price'); ?>:</label>
                                    <input type="text" class="form-control" value="<?php echo $precio_final; ?>"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <label><?php echo __('service_duration'); ?>:</label>
                                    <input type="text" class="form-control" value="<?php echo $duracion; ?>" disabled>
                                </div>

                                <hr>
                                <div class="form-group text-center">
                                    <a href="index.php" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>
                                        <?php echo __('delete'); ?></button>
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