<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include('../app/controllers/servicios/listado_de_servicios.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('client_registration'); ?></h1>
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
                            <h3 class="card-title"><?php echo __('fill_data_carefully'); ?></h3>
                        </div>
                        <div class="card-body">
                            <form id="clienteForm" action="../app/controllers/clientes/create.php" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="id_negocios" value="<?= $_SESSION['negocio_id'] ?>">

                                <div class="form-group">
                                    <label for="nombre_clt"><?php echo __('client_name'); ?>:</label>
                                    <input type="text" name="nombre_clt" id="nombre_clt" class="form-control"
                                        required="">
                                </div>

                                <div class="form-group">
                                    <label for="direccion_clt"><?php echo __('address'); ?>:</label>
                                    <input type="text" name="direccion_clt" id="direccion_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="nacionalidad_clt"><?php echo __('nationality'); ?>:</label>
                                    <input type="text" name="nacionalidad_clt" id="nacionalidad_clt"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="ciudadania_clt"><?php echo __('citizenship'); ?>:</label>
                                    <input type="text" name="ciudadania_clt" id="ciudadania_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="pasaporte_clt"><?php echo __('passport'); ?>:</label>
                                    <input type="text" name="pasaporte_clt" id="pasaporte_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="fecha_venc_pass_clt"><?php echo __('passport_expiry_date'); ?>:</label>
                                    <input type="date" name="fecha_venc_pass_clt" id="fecha_venc_pass_clt"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="est_civil_clt"><?php echo __('civil_status'); ?>:</label>
                                    <input type="text" name="est_civil_clt" id="est_civil_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for=""><?php echo __('client_phone'); ?>:</label>
                                    <input type="number" name="telefono_clt" id="telefono_clt" class="form-control"
                                        required="">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo __('client_email'); ?>:</label>
                                    <input type="email" name="mail_clt" id="mail_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for=""><?php echo __('client_image'); ?></label>
                                    <input type="file" name="image_clt" class="form-control" id="file">
                                    <br>
                                    <output id="list" style=""></output>
                                    <script>
                                        function archivo(evt) {
                                            var files = evt.target.files;
                                            for (var i = 0, f; f = files[i]; i++) {
                                                if (!f.type.match('image.*')) {
                                                    continue;
                                                }
                                                var reader = new FileReader();
                                                reader.onload = (function (theFile) {
                                                    return function (e) {
                                                        document.getElementById("list").innerHTML = ['<img class="thumb thumbnail" src="', e.target.result, '" width="100%" title="', escape(theFile.name), '"/>'].join('');
                                                    };
                                                })(f);
                                                reader.readAsDataURL(f);
                                            }
                                        }

                                        document.getElementById('file').addEventListener('change', archivo, false);
                                    </script>
                                </div>


                                <div class="form-group">
                                    <label for="id_servicios"><?php echo __('service'); ?>:</label>
                                    <select name="id_servicios" id="id_servicios" class="form-control" required>
                                        <option value=""><?php echo __('select_service'); ?></option>
                                        <?php foreach ($servicios_datos as $servicio): ?>
                                            <option value="<?= $servicio['id_servicios'] ?>">
                                                <?= $servicio['servicio'] . ' - ' . $servicio['tipo'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-create"> <?php echo __('add_new_service'); ?> </button>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_ini_tramite"><?php echo __('start_date_procedure'); ?>:</label>
                                    <input type="date" name="fecha_ini_tramite" class="form-control"
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="fecha_fin_tramite"><?php echo __('end_date_procedure'); ?>:</label>
                                    <input type="date" name="fecha_fin_tramite" class="form-control">
                                </div>

                                <div class="form-group text-center">
                                    <a href="index.php" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
                                    <button type="submit" class="btn btn-primary"><?php echo __('save'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title"><?php echo __('create_new_service'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for=""><?php echo __('service_name'); ?> <b>*</b></label>
                            <input type="text" id="servicio" name="servicio" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for=""><?php echo __('service_type'); ?> <b>*</b></label>
                            <input type="text" id="tipo" name="tipo" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for=""><?php echo __('service_price'); ?> <b>*</b></label>
                            <input type="text" id="precio_serv" name="precio_serv" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('cancel'); ?></button>
                <button type="button" class="btn btn-primary" id="btn_create"><?php echo __('save_service'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn_create').click(function () {
        var servicio = $('#servicio').val();
        var tipo = $('#tipo').val();
        var precio_serv = $('#precio_serv').val();

        if (servicio == "" || tipo == "" || precio_serv == "") {
            $('#servicio').focus();
            $('#lbl_create').css('display', 'block');
        } else {
            var url = "../app/controllers/servicios/create_client_serv.php";
            $.ajax({
                url: url,
                type: 'POST',
                data: { servicio: servicio, tipo: tipo, precio_serv: precio_serv },
                success: function (datos) {
                    // Actualizar el select con la nueva opción
                    $('#id_servicios').append(datos);

                    // Cerrar el modal
                    $('#modal-create').modal('hide');

                    // Mostrar un mensaje de éxito (opcional)
                    alert('Servicio creado correctamente.');
                }
            });
        }
    });
</script>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>