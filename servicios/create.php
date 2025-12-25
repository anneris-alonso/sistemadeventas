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
                    <h1 class="m-0">Crear un Nuevo Servicio</h1>
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
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/servicios/create_client_serv.php" method="post">
                                        <div class="form-group">
                                            <label for="">Nombre del servicio <b>*</b></label>
                                            <input type="text" name="servicio" class="form-control" placeholder="Escriba aquí el servicio..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tipo de servicio <b>*</b></label>
                                            <input type="text" name="tipo" class="form-control" placeholder="Escriba aquí el tipo..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Precio de compra <b>*</b></label>
                                            <input type="text" name="precio_de_compra" class="form-control" placeholder="Escriba aquí el precio..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Precio del servicio <b>*</b></label>
                                            <input type="text" name="precio_serv" class="form-control" placeholder="Escriba aquí el precio..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Duracion del servicio <b>*</b></label>
                                            <input type="text" name="duracion" class="form-control" placeholder="Escriba aquí la duracion..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Impuesto (%)</label>
                                            <input type="number" step="0.01" name="impuesto" class="form-control" value="0.00" required>
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
include('../layout/mensajes.php');
include('../layout/parte2.php');
?>
