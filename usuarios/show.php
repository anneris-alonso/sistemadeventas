<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/usuarios/show_usuario.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('employee_data'); ?></h1>
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
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <label for=""><?php echo __('names'); ?></label>
                                        <input type="text" name="nombres" class="form-control"
                                            value="<?php echo $nombres; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo __('email'); ?></label>
                                        <input type="email" name="email" class="form-control"
                                            value="<?php echo $email; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo __('user_role'); ?></label>
                                        <input type="text" name="email" class="form-control" value="<?php echo $rol; ?>"
                                            disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for=""><?php echo __('salary'); ?></label>
                                        <input type="number" name="salario" class="form-control"
                                            value="<?php echo $salario; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo __('work_permit'); ?></label>
                                        <input type="text" name="num_permiso_trabajo" class="form-control"
                                            value="<?php echo $num_permiso_trabajo; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo __('health_insurance'); ?></label>
                                        <input type="text" name="seguro_medico" class="form-control"
                                            value="<?php echo $seguro_medico; ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><?php echo __('employee_type'); ?></label>
                                        <input type="text" name="tipo_empleado" class="form-control"
                                            value="<?php echo $tipo_empleado; ?>" disabled>
                                    </div>

                                    <hr>
                                    <div class="form-group">
                                        <a href="index.php" class="btn btn-secondary"><?php echo __('back'); ?></a>

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