<?php
include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Nueva Sugerencia</h1>
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
                            <h3 class="card-title">Ingrese su sugerencia</h3>
                        </div>
                        <div class="card-body">
                            <form action="../app/controllers/sugerencias/create.php" method="post">
                                <div class="form-group">
                                    <label for="sugerencia">Sugerencia:</label>
                                    <textarea name="sugerencia" id="sugerencia" class="form-control" rows="5" required></textarea>
                                </div>

                                <div class="form-group text-center">
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

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>