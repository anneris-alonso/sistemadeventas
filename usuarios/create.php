<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

include ('../app/controllers/roles/listado_de_roles.php');?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de un nuevo empleado</h1>
                </div></div></div></div>
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="../app/controllers/usuarios/create.php" method="post">
                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" name="nombres" class="form-control" placeholder="Escriba aquí el nombre del nuevo usuario..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="Escriba aquí el correo del nuevo usuario..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Rol del empleado</label>
                                            <select name="rol" id="" class="form-control">
                                                <?php
                                                foreach ($roles_datos as $roles_dato){?>
                                                    <option value="<?php echo $roles_dato['id_rol'];?>"><?php echo $roles_dato['rol'];?></option>
                                                <?php
                                                }
                                              ?>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="">Contraseña</label>
                                            <input type="text" name="password_user" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Repita la Contraseña</label>
                                            <input type="text" name="password_repeat" class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="salario">Salario:</label>
                                            <input type="number" name="salario" id="salario" step="0.01" required><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="num_permiso_trabajo">Número de permiso de trabajo:</label>
                                            <input type="text" name="num_permiso_trabajo" id="num_permiso_trabajo"><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="seguro_medico">Seguro médico:</label>
                                            <input type="text" name="seguro_medico" id="seguro_medico"><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="tipo_empleado">Tipo de empleado:</label>
                                            <select name="tipo_empleado" id="tipo_empleado">
                                                <option value="Part-Time">Part-Time</option>
                                                <option value="Full-Time">Full-Time</option>
                                                <option value="Freelance">Freelance</option>
                                            </select><br><br>
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

            </div></div>
    </div>
<?php include ('../layout/parte2.php');?>