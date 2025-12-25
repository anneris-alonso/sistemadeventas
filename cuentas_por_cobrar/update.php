<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Include the listado_de_servicios.php file
include('../app/controllers/servicios/listado_de_servicios.php');
include('../app/controllers/usuarios/listado_de_usuarios.php');
include('../app/controllers/cuentas_por_cobrar/cargar_cuenta.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Actualizar Cuenta por Cobrar</h1>
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
                            <h3 class="card-title">Modifique los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="../app/controllers/cuentas_por_cobrar/update.php" method="post">
                                <input type="text" name="id_cuenta" value="<?php echo $id_cuenta_get; ?>" hidden>
                                <div class="form-group">
                                    <label for="id_usuario">Cliente:</label>
                                    <select name="id_usuario" id="id_usuario" class="form-control" required>
                                        <option value="">Seleccione un usuario</option>
                                        <?php foreach ($usuarios_datos as $usuario):?>
                                            <option value="<?= $usuario['id_usuario']?>" <?php if($id_usuario == $usuario['id_usuario']){ echo "selected";} ?>>
                                                <?= $usuario['nombres'] . ' - ' . $usuario['email'] ?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="id_servicios">Servicio:</label>
                                    <select name="id_servicios" id="id_servicios" class="form-control" required>
                                        <option value="">Seleccione un servicio</option>
                                        <?php foreach ($servicios_datos as $servicio):?>
                                            <option value="<?= $servicio['id_servicios']?>" data-precio="<?= $servicio['precio_serv'] ?>" <?php if($id_servicios == $servicio['id_servicios']){ echo "selected";} ?>>
                                                <?= $servicio['servicio']. ' - '. $servicio['tipo'] . ' - $'. $servicio['precio_serv'] ?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="total_a_pagar">Total a pagar</label>
                                    <input type="number" name="total_a_pagar" id="total_a_pagar" class="form-control" placeholder="El total a pagar se calculará automaticamente" value="<?= $total_a_pagar; ?>" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="condicion_especial">Descuento (%)</label>
                                    <input type="number" name="condicion_especial" id="condicion_especial" class="form-control" placeholder="Escriba aquí el porcentaje de descuento" value="<?= $condicion_especial; ?>" min="0" max="100">
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripcion</label>
                                    <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Escriba aquí la descripción" value="<?= $descripcion; ?>">
                                </div>

                                <hr>
                                <div class="form-group">
                                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
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

<script>
    $(document).ready(function() {
        $('#id_servicios').change(function() {
            var precioServicio = parseFloat($(this).find(':selected').data('precio'));
            var descuentoPorcentaje = parseFloat($('#condicion_especial').val());

            if (isNaN(precioServicio)) {
                precioServicio = 0;
            }
             if (isNaN(descuentoPorcentaje)) {
                descuentoPorcentaje = 0;
            }
            
            var descuento = precioServicio * (descuentoPorcentaje / 100);
            var totalAPagar = precioServicio - descuento;

            $('#total_a_pagar').val(totalAPagar.toFixed(2));
        });
        $('#condicion_especial').on('input', function() {
            var precioServicio = parseFloat($('#id_servicios').find(':selected').data('precio'));
            var descuentoPorcentaje = parseFloat($(this).val());

            if (isNaN(precioServicio)) {
                precioServicio = 0;
            }
            if (isNaN(descuentoPorcentaje)) {
                descuentoPorcentaje = 0;
            }

            var descuento = precioServicio * (descuentoPorcentaje / 100);
            var totalAPagar = precioServicio - descuento;

            $('#total_a_pagar').val(totalAPagar.toFixed(2));
        });
    });
</script>
