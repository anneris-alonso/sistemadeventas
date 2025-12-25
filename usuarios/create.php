<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/roles/listado_de_roles.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('new_employee_registration'); ?></h1>
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
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/usuarios/create.php" method="post">
                                        <div class="form-group">
                                            <label for=""><?php echo __('names'); ?></label>
                                            <input type="text" name="nombres" class="form-control"
                                                placeholder="<?php echo __('names'); ?>..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('email'); ?></label>
                                            <input type="email" name="email" class="form-control"
                                                placeholder="<?php echo __('email'); ?>..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('user_role'); ?></label>
                                            <select name="rol" id="" class="form-control">
                                                <?php
                                                foreach ($roles_datos as $roles_dato) { ?>
                                                    <option value="<?php echo $roles_dato['id_rol']; ?>">
                                                        <?php echo $roles_dato['rol']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('password'); ?></label>
                                            <input type="text" name="password_user" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for=""><?php echo __('repeat_password'); ?></label>
                                            <input type="text" name="password_repeat" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="salario"><?php echo __('salary'); ?>:</label>
                                            <input type="number" name="salario" id="salario" step="0.01"
                                                required><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="num_permiso_trabajo"><?php echo __('work_permit'); ?>:</label>
                                            <input type="text" name="num_permiso_trabajo"
                                                id="num_permiso_trabajo"><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="seguro_medico"><?php echo __('health_insurance'); ?>:</label>
                                            <input type="text" name="seguro_medico" id="seguro_medico"><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="tipo_empleado"><?php echo __('employee_type'); ?>:</label>
                                            <select name="tipo_empleado" id="tipo_empleado">
                                                <option value="Part-Time">Part-Time</option>
                                                <option value="Full-Time">Full-Time</option>
                                                <option value="Freelance">Freelance</option>
                                            </select><br><br>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php"
                                                class="btn btn-secondary"><?php echo __('cancel'); ?></a>
                                            <button type="submit"
                                                class="btn btn-primary"><?php echo __('save'); ?></button>
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
<?php include('../layout/parte2.php'); ?>