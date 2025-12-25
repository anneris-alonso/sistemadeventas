<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Validate and sanitize the ID from $_GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_servicio = intval($_GET['id']);
} else {
    die("ID de servicio no válido.");
}


try {
    $query_servicio = $pdo->prepare("SELECT * FROM tb_servicios WHERE id_servicios = :id_servicio AND id_negocios = :id_negocios");
    $query_servicio->bindValue(':id_servicio', $id_servicio, PDO::PARAM_INT);
    $query_servicio->bindValue(':id_negocios', $_SESSION['negocio_id'], PDO::PARAM_INT);
    $query_servicio->execute();

    if ($servicio_data = $query_servicio->fetch(PDO::FETCH_ASSOC)) {
        $servicio = $servicio_data['servicio'];
        $tipo = $servicio_data['tipo'];
        $precio_serv = $servicio_data['precio_serv'];
        $precio_de_compra = $servicio_data['precio_de_compra'];
        $duracion = $servicio_data['duracion'];
        $impuesto = $servicio_data['impuesto'];
        $precio_final = $servicio_data['precio_final'];
        $ganancias = $servicio_data['ganancias'];

    } else {
        die("Servicio no encontrado para este negocio.");
    }

} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('update_services'); ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('update_data_carefully'); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/servicios/update_servicios.php" method="post">
                                        <input type="hidden" name="id_servicio" value="<?php echo $id_servicio; ?>">
                                        </input>
                                        <input type="hidden" name="id_negocios" value="<?= $_SESSION['negocio_id'] ?>">
                                        </input>

                                        <div class="form-group">
                                            <label for=""><?php echo __('service_name'); ?> <b>*</b></label>
                                            <input type="text" name="servicio" value="<?php echo $servicio; ?>"
                                                class="form-control" required> </input>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('service_type'); ?> <b>*</b></label>
                                            <input type="text" name="tipo" value="<?php echo $tipo; ?>"
                                                class="form-control" required> </input>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('purchase_price'); ?> <b>*</b></label>
                                            <input type="text" name="precio_de_compra"
                                                value="<?php echo $precio_de_compra; ?>" class="form-control" required>
                                            </input>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('service_price'); ?> <b>*</b></label>
                                            <input type="text" name="precio_serv" value="<?php echo $precio_serv; ?>"
                                                class="form-control" required> </input>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('service_duration'); ?> <b>*</b></label>
                                            <input type="text" name="duracion" value="<?php echo $duracion; ?>"
                                                class="form-control"> </input>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('tax'); ?> <b>*</b></label>
                                            <input type="number" step="0.01" name="impuesto"
                                                value="<?php echo $impuesto; ?>" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('final_price'); ?></label>
                                            <input type="text" name="precio_final" value="<?php echo $precio_final; ?>"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for=""><?php echo __('profits'); ?></label>
                                                <input type="text" name="ganancias" value="<?php echo $ganancias; ?>"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="form-group">
                                                <a href="index.php"
                                                    class="btn btn-secondary"><?php echo __('cancel'); ?></a>
                                                <button type="submit"
                                                    class="btn btn-primary"><?php echo __('save'); ?></button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="col-md-12"> </div>
</div>
</div>
</div>
</div>
</div>


<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>