<?php
include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');

// Incluir el controlador para el listado de sugerencias
include ('../app/controllers/sugerencias/listado_de_sugerencias.php'); 
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Listado de Sugerencias
                        <a href="create.php" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Agregar Nueva
                        </a>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12"> 
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sugerencias registradas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table id="example1" class="table table-bordered table-striped table-sm"> 
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Sugerencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($sugerencias_datos as $sugerencia_dato):
                                            $id_sugerencia = $sugerencia_dato['id_sugerencias'];
                                            $sugerencia = $sugerencia_dato['sugerencia'];
                                            ?>
                                            <tr>
                                                <td><?php echo ++$contador; ?></td>
                                                <td><?php echo $sugerencia; ?></td>
                                                
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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

