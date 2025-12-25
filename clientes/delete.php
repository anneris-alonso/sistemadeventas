<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include('../app/controllers/servicios/listado_de_servicios.php');

// Validate and sanitize the ID
$id_cliente = isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']): null;

if (!$id_cliente) {
    echo "ID de cliente inválido.";
    exit();
}

include('../app/controllers/clientes/load_client.php');

if (!isset($nombre_clt)) {
    echo "Error al cargar los datos del cliente.";
    exit();
}?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Eliminar Cliente
                        <a href="index.php" class="btn btn-secondary float-right">Volver</a>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">¿Está seguro de eliminar a este cliente?</h3>
                        </div>
                        <div class="card-body">
                            <form action="../app/controllers/clientes/delete_client.php" method="post">
                                <input type="hidden" name="id_client" value="<?php echo $id_client;?>">
                                <input type="hidden" name="id_negocios" value="<?php echo $_SESSION['negocio_id'];?>">

                                <div class="form-group">
                                    <label for="nombre_clt">Nombre del cliente:</label>
                                    <input type="text" name="nombre_clt" class="form-control" value="<?php echo $nombre_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="direccion_clt">Dirección:</label>
                                    <input type="text" name="direccion_clt" class="form-control" value="<?php echo $direccion_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nacionalidad_clt">Nacionalidad:</label>
                                    <input type="text" name="nacionalidad_clt" class="form-control" value="<?php echo $nacionalidad_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="ciudadania_clt">Ciudadanía:</label>
                                    <input type="text" name="ciudadania_clt" class="form-control" value="<?php echo $ciudadania_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="pasaporte_clt">Pasaporte:</label>
                                    <input type="text" name="pasaporte_clt" class="form-control" value="<?php echo $pasaporte_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_venc_pass_clt">Fecha Vencimiento Pasaporte:</label>
                                    <input type="date" name="fecha_venc_pass_clt" class="form-control" value="<?php echo $fecha_venc_pass_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="est_civil_clt">Estado Civil:</label>
                                    <input type="text" name="est_civil_clt" class="form-control" value="<?php echo $est_civil_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="telefono_clt">Teléfono del cliente:</label>
                                    <input type="number" name="telefono_clt" class="form-control" value="<?php echo $telefono_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="mail_clt">Email del cliente:</label>
                                    <input type="email" name="mail_clt" class="form-control" value="<?php echo $mail_clt;?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Imagen:</label><br>
                                    <img src="<?php echo $URL. "/clientes/image_clt/". $imagen;?>" width="200px" alt="" onerror="this.style.display='none'">
                                </div>

                                <div class="form-group">
                                    <label for="id_servicios">Servicio:</label>
                                    <select name="id_servicios" id="id_servicios" class="form-control" disabled>
                                        <?php foreach ($servicios_datos as $servicio):?>
                                            <option value="<?= $servicio['id_servicios']?>" <?= ($servicio['id_servicios'] == $id_servicios)? 'selected': '';?>><?= $servicio['servicio']?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status_clt">Estado del cliente:</label>
                                    <select name="status_clt" id="status_clt" class="form-control" disabled>
                                        <option value="1" <?php if ($status_clt == 1) echo "selected";?>>Activo</option>
                                        <option value="0" <?php if ($status_clt == 0) echo "selected";?>>Inactivo</option>
                                    </select>
                                </div>


                                <hr>
                                <div class="form-group text-center">
                                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/mensajes.php');?>
<?php include('../layout/parte2.php');?>