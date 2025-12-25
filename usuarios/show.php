<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

include ('../app/controllers/usuarios/show_usuario.php');?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Datos del empleado</h1>
                </div></div></div></div>
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label for="">Nombres</label>
                                        <input type="text" name="nombres" class="form-control" value="<?php echo $nombres;?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo $email;?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Rol del usuario</label>
                                        <input type="text" name="email" class="form-control" value="<?php echo $rol;?>" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Salario</label>
                                        <input type="number" name="salario" class="form-control" value="<?php echo $salario;?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Número de permiso de trabajo</label>
                                        <input type="text" name="num_permiso_trabajo" class="form-control" value="<?php echo $num_permiso_trabajo;?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Seguro médico</label>
                                        <input type="text" name="seguro_medico" class="form-control" value="<?php echo $seguro_medico;?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tipo de empleado</label>
                                        <input type="text" name="tipo_empleado" class="form-control" value="<?php echo $tipo_empleado;?>" disabled>
                                    </div>

                                    <hr>
                                    <div class="form-group">
                                        <a href="index.php" class="btn btn-secondary">Volver</a>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            </div></div>
    </div>
<?php include ('../layout/mensajes.php');?>
<?php include ('../layout/parte2.php');?>