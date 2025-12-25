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
                    <h1 class="m-0">Registro de Proveedores <a href="index.php" class="btn btn-secondary float-right">Volver</a> </h1> </div>
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
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                        </div>
                        <div class="card-body">
                            <form action="../app/controllers/proveedores/create.php" method="post">
                                <div class="form-group">
                                    <label for="">Nombre del proveedor <b>*</b></label>
                                    <input type="text" name="nombre_proveedor" class="form-control" required=""> </input> </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Nro de celular <b>*</b></label>
                                    <input type="number" name="celular" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label for="">Nro de teléfono</label>
                                    <input type="number" name="telefono" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Empresa<b>*</b></label>
                                    <input type="text" name="empresa" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label for="">Correo electrónico<b>*</b></label>
                                    <input type="email" name="email" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label for="">Dirección<b>*</b></label>
                                    <input type="text" name="direccion" class="form-control" required=""> </input>
                                </div>

                                <div class="form-group text-center">
                                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div> </div> <div class="form-group"> </div>

                            </form> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> </div> </div>
</div>

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>


