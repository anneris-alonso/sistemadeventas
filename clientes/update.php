<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include('../app/controllers/servicios/listado_de_servicios.php');

// Validate and sanitize the ID
$id_cliente = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : null;

if (!$id_cliente) {
    echo "ID de cliente inválido.";
    exit();
}

include('../app/controllers/clientes/load_client.php');  // AFTER validating $id_cliente

if (!isset($nombre_clt)) {
    echo "Error al cargar los datos del cliente.";
    exit();
} ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('client_update'); ?>
                    </h1>
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
                            <form action="../app/controllers/clientes/update.php" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" name="id_client" value="<?php echo $id_cliente; ?>">
                                <input type="hidden" name="id_negocios" value="<?= $_SESSION['negocio_id'] ?>">

                                <div class="form-group">
                                    <label for="nombre_clt"><?php echo __('client_name'); ?>:</label>
                                    <input type="text" name="nombre_clt" class="form-control"
                                        value="<?php echo $nombre_clt; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="direccion_clt"><?php echo __('address'); ?>:</label>
                                    <input type="text" name="direccion_clt" class="form-control"
                                        value="<?php echo $direccion_clt; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="nacionalidad_clt"><?php echo __('nationality'); ?>:</label>
                                    <input type="text" name="nacionalidad_clt" class="form-control"
                                        value="<?php echo $nacionalidad_clt; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="ciudadania_clt"><?php echo __('citizenship'); ?>:</label>
                                    <input type="text" name="ciudadania_clt" class="form-control"
                                        value="<?php echo $ciudadania_clt; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="pasaporte_clt"><?php echo __('passport'); ?>:</label>
                                    <input type="text" name="pasaporte_clt" class="form-control"
                                        value="<?php echo $pasaporte_clt; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_venc_pass_clt"><?php echo __('passport_expiry_date'); ?>:</label>
                                    <input type="date" name="fecha_venc_pass_clt" class="form-control"
                                        value="<?php echo $fecha_venc_pass_clt; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="est_civil_clt"><?php echo __('civil_status'); ?>:</label>
                                    <input type="text" name="est_civil_clt" class="form-control"
                                        value="<?php echo $est_civil_clt; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="telefono_clt"><?php echo __('client_phone'); ?>:</label>
                                    <input type="number" name="telefono_clt" class="form-control"
                                        value="<?php echo $telefono_clt; ?>" required="">
                                </div>
                                <div class="form-group">
                                    <label for="mail_clt"><?php echo __('client_email'); ?>:</label>
                                    <input type="email" name="mail_clt" class="form-control"
                                        value="<?php echo $mail_clt; ?>">
                                </div>
                                <div class="form-group">
                                    <label for=""><?php echo __('client_image'); ?></label>
                                    <input type="file" name="image_clt" class="form-control" id="file">
                                    <input type="text" name="image_text" value="<?php echo $imagen; ?>" hidden>
                                    <br>
                                    <output id="list" style="">
                                        <img src="<?php echo $URL . "/clientes/image_clt/" . $imagen; ?>" width="100%"
                                            alt="">
                                    </output>
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
                                            <option value="<?= $servicio['id_servicios'] ?>"
                                                <?= ($servicio['id_servicios'] == $id_servicios) ? 'selected' : ''; ?>>
                                                <?= $servicio['servicio'] . ' - ' . $servicio['tipo'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_ini_tramite"><?php echo __('start_date_procedure'); ?>:</label>
                                    <input type="date" name="fecha_ini_tramite" class="form-control"
                                        value="<?php echo $fecha_ini_tramite; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="fecha_fin_tramite"><?php echo __('end_date_procedure'); ?>:</label>
                                    <input type="date" name="fecha_fin_tramite" class="form-control"
                                        value="<?php echo $fecha_fin_tramite; ?>">
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

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>