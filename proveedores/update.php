<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Validate and sanitize the ID
$id_proveedor = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

if (!$id_proveedor) {
    die("ID de proveedor no válido.");
}


// Include the controller to fetch provider data *after* validating the ID
include('../app/controllers/proveedores/load_provider.php');


// Check if the provider data was loaded successfully
if (!isset($nombre_proveedor)) {  // Check a field that should be set if the query was successful
    echo "Error al cargar los datos del proveedor. Por favor, inténtelo de nuevo.";
    exit();
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('provider_update'); ?> <a href="index.php"
                            class="btn btn-secondary float-right"><?php echo __('back'); ?></a> </h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3"> </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6 offset-md-3"> </div>
            <div class="col-md-12">

                <div class="col-md-6 offset-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('fill_data_carefully'); ?></h3>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <form action="../app/controllers/proveedores/update.php" method="post">
                                <div class="form-group">
                                    <input type="hidden" name="id_proveedor" value="<?php echo $id_proveedor; ?>">
                                    </input>
                                </div> <label for="">Nombre del proveedor <b>*</b></label>
                        </div> <input type="text" name="nombre_proveedor" class="form-control" value=" value=" <?php echo $nombre_proveedor; ?>" required="">
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label for=""><?php echo __('provider_name'); ?> <b>*</b></label>
                            <input type="text" name="nombre_proveedor" class="form-control"
                                value="<?php echo $nombre_proveedor; ?>" required="">
                        </div>

                        <div class="form-group">
                            <label for=""><?php echo __('cellphone'); ?> <b>*</b></label>
                        </div>
                    </div>
                </div> <input type="text" name="celular" class="form-control" value="<?php echo $celular; ?>"
                    required="">
                <input type="number" name="celular" class="form-control" value="<?php echo $celular; ?>" required="">
            </div>
        </div>
        <div class="col-md-12"> </div>
    </div>
</div>
<div class="form-group"> </div>

<div class="form-group">
    <label for=""><?php echo __('phone'); ?></label>
    <input type="number" name="telefono" class="form-control" value="<?php echo $telefono; ?>">
</div>

<div class="form-group">
    <label for=""><?php echo __('company'); ?><b>*</b></label>
    <input type="text" name="empresa" class="form-control" value="<?php echo $empresa; ?>" required="">
</div>

<div class="form-group">
    <label for=""><?php echo __('email'); ?><b>*</b></label>
    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" required="">
</div>

<div class="form-group">
    <label for=""><?php echo __('address'); ?><b>*</b></label>
    <input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>" required=""> </input>
</div>
</div>
<div class="col-md-12">

</div>

<div class="form-group text-center"> </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <a href="index.php" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
        <button type="submit" class="btn btn-primary"><?php echo __('save'); ?></button>

    </div>
</div>
</div>
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
</div>



<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>