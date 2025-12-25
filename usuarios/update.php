<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

include ('../app/controllers/usuarios/update_usuario.php');
include ('../app/controllers/roles/listado_de_roles.php');
?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualizar empleado</h1>
                </div></div></div></div>
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-success">
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

                                    <form action="../app/controllers/usuarios/update.php" method="post">
                                        <input type="text" name="id_usuario" value="<?php echo $id_usuario_get;?>" hidden>
                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" name="nombres" class="form-control" value="<?php echo $nombres;?>" placeholder="Escriba aquí el nombre del nuevo usuario..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $email;?>" placeholder="Escriba aquí el correo del nuevo usuario..." required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Rol del usuario</label>
                                            <select name="rol" id="" class="form-control">
                                                <?php
                                                foreach ($roles_datos as $roles_dato){
                                                    $rol_tabla = $roles_dato['rol'];
                                                    $id_rol = $roles_dato['id_rol'];?>
                                                    <option value="<?php echo $id_rol;?>"<?php if($rol_tabla == $rol){?> selected="selected" <?php }?> >
                                                        <?php echo $rol_tabla;?>
                                                    </option>
                                                <?php
                                                }
                                              ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Contraseña</label>
                                            <input type="text" name="password_user" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Repita la Contraseña</label>
                                            <input type="text" name="password_repeat" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="salario">Salario:</label>
                                            <input type="number" name="salario" id="salario" step="0.01" value="<?php echo $salario;?>" required><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="num_permiso_trabajo">Número de permiso de trabajo:</label>
                                            <input type="text" name="num_permiso_trabajo" id="num_permiso_trabajo" value="<?php echo $num_permiso_trabajo;?>"><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="seguro_medico">Seguro médico:</label>
                                            <input type="text" name="seguro_medico" id="seguro_medico" value="<?php echo $seguro_medico;?>"><br><br>
                                        </div>

                                        <div class="form-group">
                                            <label for="tipo_empleado">Tipo de empleado:</label>
                                            <select name="tipo_empleado" id="tipo_empleado">
                                                <option value="Part-Time" <?php if ($tipo_empleado == 'Part-Time') echo 'selected';?>>Part-Time</option>
                                                <option value="Full-Time" <?php if ($tipo_empleado == 'Full-Time') echo 'selected';?>>Full-Time</option>
                                                <option value="Freelance" <?php if ($tipo_empleado == 'Freelance') echo 'selected';?>>Freelance</option>
                                            </select><br><br>
                                        </div>

                                        <hr>
                                        <div class="form-group">
                                            <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                            <button type="submit" class="btn btn-success">Actualizar</button>
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
<?php include ('../layout/mensajes.php');?>
<?php include ('../layout/parte2.php');?>