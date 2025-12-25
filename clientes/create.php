<?php
include ('../app/config.php');
include ('../layout/sesion.php');
include ('../layout/parte1.php');
include ('../app/controllers/servicios/listado_de_servicios.php');?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de un Nuevo Cliente</h1>
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
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                        </div>
                        <div class="card-body">
                            <form id="clienteForm" action="../app/controllers/clientes/create.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id_negocios" value="<?= $_SESSION['negocio_id']?>">

                                <div class="form-group">
                                    <label for="nombre_clt">Nombre del cliente:</label>
                                    <input type="text" name="nombre_clt" id="nombre_clt" class="form-control" required="">
                                </div>

                                <div class="form-group">
                                    <label for="direccion_clt">Dirección:</label>
                                    <input type="text" name="direccion_clt" id="direccion_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="nacionalidad_clt">Nacionalidad:</label>
                                    <input type="text" name="nacionalidad_clt" id="nacionalidad_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="ciudadania_clt">Ciudadanía:</label>
                                    <input type="text" name="ciudadania_clt" id="ciudadania_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="pasaporte_clt">Pasaporte:</label>
                                    <input type="text" name="pasaporte_clt" id="pasaporte_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="fecha_venc_pass_clt">Fecha Vencimiento Pasaporte:</label>
                                    <input type="date" name="fecha_venc_pass_clt" id="fecha_venc_pass_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="est_civil_clt">Estado Civil:</label>
                                    <input type="text" name="est_civil_clt" id="est_civil_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Teléfono del cliente:</label>
                                    <input type="number" name="telefono_clt" id="telefono_clt" class="form-control" required="">
                                </div>
                                <div class="form-group">
                                    <label for="">Email del cliente:</label>
                                    <input type="email" name="mail_clt" id="mail_clt" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Imagen del cliente</label>
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
                                    <label for="id_servicios">Servicio:</label>
                                    <select name="id_servicios" id="id_servicios" class="form-control" required>
                                        <option value="">Seleccione un servicio</option>
                                        <?php foreach ($servicios_datos as $servicio):?>
                                            <option value="<?= $servicio['id_servicios']?>">
                                                <?= $servicio['servicio']. ' - '. $servicio['tipo']?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create"> Agregar Nuevo Servicio </button>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_ini_tramite">Fecha de inicio del trámite:</label>
                                    <input type="date" name="fecha_ini_tramite" class="form-control" value="<?php echo date('Y-m-d');?>">
                                </div>

                                <div class="form-group">
                                    <label for="fecha_fin_tramite">Fecha de fin del trámite:</label>
                                    <input type="date" name="fecha_fin_tramite" class="form-control">
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

<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6;color: white">
                <h4 class="modal-title">Creación de un nuevo servicio</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nombre del servicio <b>*</b></label>
                            <input type="text" id="servicio" name="servicio" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for="">Tipo de servicio <b>*</b></label>
                            <input type="text" id="tipo" name="tipo" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for="">Precio del servicio <b>*</b></label>
                            <input type="text" id="precio_serv" name="precio_serv" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_create">Guardar servicio</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn_create').click(function () {
        var servicio = $('#servicio').val();
        var tipo = $('#tipo').val();
        var precio_serv = $('#precio_serv').val();

        if(servicio == "" || tipo == "" || precio_serv == ""){
            $('#servicio').focus();
            $('#lbl_create').css('display','block');
        } else {
            var url = "../app/controllers/servicios/create_client_serv.php";
            $.ajax({
                url: url,
                type: 'POST',
                data: {servicio:servicio, tipo:tipo, precio_serv:precio_serv},
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

<?php include('../layout/mensajes.php');?>
<?php include('../layout/parte2.php');?>