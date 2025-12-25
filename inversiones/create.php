<?php

include ('../app/config.php');
include ('../layout/sesion.php');

?>

<div class="content justify-content-center">
    <div class="content justify-content-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="m-0"></h1>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            
                        </div>

                        <div class="card-body" style="display: box;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/inversiones/create.php" method="post">
                                        <div class="form-group">
                                            <label for="">Motivo de la inversión</label>
                                            <input type="text" name="motivo_inversion" class="form-control" placeholder="Escriba aquí el motivo..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Costo de la inversión</label>
                                            <input type="number" name="costo_inversion" class="form-control" placeholder="Escriba aquí el costo..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Fecha de la Inversión</label>
                                            <input type="date" name="fecha_inversion" class="form-control" placeholder="Escriba aquí el precio..." required>
                                        </div>
                                        <div class="form-group">
                                            <a href="/inversiones/create.php" class="btn btn-secondary">Cancelar</a>
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
