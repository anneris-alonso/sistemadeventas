<?php
include ('../layout/sesion.php');

// ... (código para obtener el ID del negocio si es necesario) ...

include ('../layout/parte1.php'); 

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('role_registration'); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('fill_data_carefully'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/roles/create.php" method="post">
                                        <div class="form-group">
                                            <label for=""><?php echo __('role_name'); ?></label>
                                            <input type="text" name="rol" class="form-control" placeholder="<?php echo __('role_name'); ?>..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('permissions'); ?></label><br>
                                            <input type="checkbox" name="permissions[]" value="clientes"> <?php echo __('clientes'); ?><br>
                                            <input type="checkbox" name="permissions[]" value="compras"> <?php echo __('finances'); ?><br> 
                                            <input type="checkbox" name="permissions[]" value="almacen"> <?php echo __('warehouse'); ?><br>
                                            <input type="checkbox" name="permissions[]" value="proveedores"> <?php echo __('suppliers'); ?><br>
                                            <input type="checkbox" name="permissions[]" value="servicios"> <?php echo __('services'); ?><br>
                                            <input type="checkbox" name="permissions[]" value="sugerencias"> <?php echo __('suggestions'); ?><br>
                                            <input type="checkbox" name="permissions[]" value="usuarios"> <?php echo __('employees'); ?><br>
                                            <input type="checkbox" name="permissions[]" value="roles"> <?php echo __('roles'); ?><br> 
                                            <input type="checkbox" name="permissions[]" value="categorias"> <?php echo __('categories'); ?><br>
                                            <input type="checkbox" name="permissions[]" value="perdidas"> <?php echo __('losses'); ?><br>                                   
                                            <input type="checkbox" name="permissions[]" value="inversiones"> <?php echo __('investments'); ?><br>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
                                            <button type="submit" class="btn btn-primary"><?php echo __('save'); ?></button>
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
include ('../layout/mensajes.php'); 
include ('../layout/parte2.php'); 
?>