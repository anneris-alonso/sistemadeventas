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
                    <h1 class="m-0">Registro de un Rol</h1>
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
                                    <form action="../app/controllers/roles/create.php" method="post">
                                        <div class="form-group">
                                            <label for="">Nombre del Rol</label>
                                            <input type="text" name="rol" class="form-control" placeholder="Escriba aquí el rol..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Permisos</label><br>
                                            <input type="checkbox" name="permissions[]" value="clientes"> Clientes<br>
                                            <input type="checkbox" name="permissions[]" value="compras"> Finanzas<br> 
                                            <input type="checkbox" name="permissions[]" value="almacen"> Almacen<br>
                                            <input type="checkbox" name="permissions[]" value="proveedores"> Proveedores<br>
                                            <input type="checkbox" name="permissions[]" value="servicios"> Servicios<br>
                                            <input type="checkbox" name="permissions[]" value="sugerencias"> Sugerencias<br>
                                            <input type="checkbox" name="permissions[]" value="usuarios"> Usuarios<br>
                                            <input type="checkbox" name="permissions[]" value="roles"> Roles<br> 
                                            <input type="checkbox" name="permissions[]" value="categorias"> Categorías<br>
                                            <input type="checkbox" name="permissions[]" value="perdidas"> Pérdidas<br> <!--...No se muestran...-->                                   
                                            <input type="checkbox" name="permissions[]" value="inversiones"> Inversiones<br> <!--...No se muestran...-->
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
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