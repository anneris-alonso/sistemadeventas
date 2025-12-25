<?php
include ('../layout/sesion.php');

// ... (código para obtener el ID del negocio si es necesario) ...

include ('../layout/parte1.php');

// Incluir el controlador para actualizar roles
include ('../app/controllers/roles/update_roles.php'); 

// Verificar si $rol está definido antes de usarlo
if (!isset($rol)) {
    $rol = ""; // Asignar un valor por defecto si no está definido
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Edición del Rol</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/roles/update.php" method="post">
                                        <input type="hidden" name="id_rol" value="<?php echo $id_rol_get;?>">
                                        <div class="form-group">
                                            <label for="">Nombre del Rol</label>
                                            <input type="text" name="rol" class="form-control" value="<?php echo $rol;?>" required>
                                        </div>


                                        <div class="form-group">  <!-- New Permissions Section -->
                                            <label>Permissions:</label><br>
                                            <?php foreach ($all_permissions as $permission): ?>
                                                <input type="checkbox" name="permissions[]" value="<?php echo $permission; ?>" <?php if (in_array($permission, $current_permissions)) echo 'checked'; ?>> <?php echo $permission; ?><br>
                                            <?php endforeach; ?>
                                        </div>



                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                            <button type="submit" class="btn btn-success">Actualizar</button>
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