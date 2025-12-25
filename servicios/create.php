<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('create_new_service_title'); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('fill_data_carefully'); ?></h3>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/servicios/create_client_serv.php" method="post">
                                        <div class="form-group">
                                            <label for=""><?php echo __('service_name'); ?> <b>*</b></label>
                                            <input type="text" name="servicio" class="form-control"
                                                placeholder="Escriba aquí el servicio..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('service_type'); ?> <b>*</b></label>
                                            <input type="text" name="tipo" class="form-control"
                                                placeholder="Escriba aquí el tipo..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('purchase_price'); ?> <b>*</b></label>
                                            <input type="text" name="precio_de_compra" class="form-control"
                                                placeholder="Escriba aquí el precio..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('service_price'); ?> <b>*</b></label>
                                            <input type="text" name="precio_serv" class="form-control"
                                                placeholder="Escriba aquí el precio..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('service_duration'); ?> <b>*</b></label>
                                            <input type="text" name="duracion" class="form-control"
                                                placeholder="Escriba aquí la duracion..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('tax'); ?></label>
                                            <input type="number" step="0.01" name="impuesto" class="form-control"
                                                value="0.00" required>
                                        </div>
                                        <hr>
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

<?php
include('../layout/mensajes.php');
include('../layout/parte2.php');
?>