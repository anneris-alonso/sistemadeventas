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
                    <h1 class="m-0"><?php echo __('provider_registration'); ?> <a href="index.php"
                            class="btn btn-secondary float-right"><?php echo __('back'); ?></a> </h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo __('fill_data_carefully'); ?></h3>
                    </div>
                    <div class="card-body">
                        <form action="../app/controllers/proveedores/create.php" method="post">
                            <div class="form-group">
                                <label for=""><?php echo __('provider_name'); ?> <b>*</b></label>
                                <input type="text" name="nombre_proveedor" class="form-control" required=""> </input>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for=""><?php echo __('cellphone'); ?> <b>*</b></label>
                        <input type="number" name="celular" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label for=""><?php echo __('phone'); ?></label>
                        <input type="number" name="telefono" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for=""><?php echo __('company'); ?><b>*</b></label>
                        <input type="text" name="empresa" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label for=""><?php echo __('email'); ?><b>*</b></label>
                        <input type="email" name="email" class="form-control" required="">
                    </div>

                    <div class="form-group">
                        <label for=""><?php echo __('address'); ?><b>*</b></label>
                        <input type="text" name="direccion" class="form-control" required=""> </input>
                    </div>

                    <div class="form-group text-center">
                        <a href="index.php" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
                        <button type="submit" class="btn btn-primary"><?php echo __('save'); ?></button>
                    </div>
                </div>
                <div class="form-group"> </div>

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

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>