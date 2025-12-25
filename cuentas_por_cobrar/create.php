<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Include controllers to fetch data
include('../app/controllers/clientes/listado_de_clientes.php');
include('../app/controllers/servicios/listado_de_servicios.php');
include('../app/controllers/almacen/listado_de_productos.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Crear nueva cuenta por cobrar</h1>
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
                            <h3 class="card-title">Llene los datos con cuidado</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="../app/controllers/cuentas_por_cobrar/create.php" method="post">
                                <div class="form-group">
                                    <label for="id_clients">Cliente:</label>
                                    <select name="id_clients" id="id_clients" class="form-control" required>
                                        <option value="">Seleccione un cliente</option>
                                        <?php foreach ($clientes_datos as $cliente):?>
                                            <option value="<?= $cliente['id_clients']?>">
                                                <?= $cliente['nombre_clt']?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tipo_venta">Tipo de Venta:</label>
                                    <select name="tipo_venta" id="tipo_venta" class="form-control" required>
                                        <option value="">Seleccione un tipo</option>
                                        <option value="servicio">Servicio</option>
                                        <option value="producto">Producto</option>
                                    </select>
                                </div>
                                <div class="form-group" id="select_servicio" style="display: none;">
                                    <label for="id_servicios">Servicio:</label>
                                    <select name="id_servicios" id="id_servicios" class="form-control">
                                        <option value="">Seleccione un servicio</option>
                                        <?php foreach ($servicios_datos as $servicio):?>
                                            <option value="<?= $servicio['id_servicios']?>" data-precio="<?= $servicio['precio_serv']?>">
                                                <?= $servicio['servicio']?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group" id="select_producto" style="display: none;">
                                    <label for="id_productos">Producto:</label>
                                    <select name="id_productos" id="id_productos" class="form-control">
                                        <option value="">Seleccione un producto</option>
                                        <?php foreach ($productos_datos as $producto):?>
                                            <option value="<?= $producto['id_producto']?>" data-precio="<?= $producto['precio_venta']?>">
                                                <?= $producto['nombre']?>
                                            </option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="precio_venta">Precio:</label>
                                    <input type="number" id="precio_venta" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="condicion_especial">Descuento %:</label>
                                    <input type="number" name="condicion_especial" id="condicion_especial" step="0.01" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="total_a_pagar">Total a pagar:</label>
                                    <input type="number" name="total_a_pagar" id="total_a_pagar" step="0.01" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripcion:</label>
                                    <input type="text" name="descripcion" id="descripcion" class="form-control" required>
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
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(document).ready(function() {
        // Show/hide product/service select
        $('#tipo_venta').change(function() {
            if($(this).val() === 'servicio'){
                $('#select_servicio').show();
                $('#select_producto').hide();
                $('#id_productos').val('');
                $('#id_servicios').prop('required', true);
                $('#id_productos').prop('required', false);
            } else if($(this).val() === 'producto'){
                $('#select_producto').show();
                $('#select_servicio').hide();
                $('#id_servicios').val('');
                $('#id_productos').prop('required', true);
                $('#id_servicios').prop('required', false);
            } else {
                $('#select_servicio').hide();
                $('#select_producto').hide();
                $('#id_productos').val('');
                $('#id_servicios').val('');
                $('#id_productos').prop('required', false);
                $('#id_servicios').prop('required', false);
            }
            $('#precio_venta').val('');
            $('#condicion_especial').val('');
            $('#total_a_pagar').val('');
        });

        // Update price when service is selected
        $('#id_servicios').change(function() {
            var precioServicio = $(this).find(':selected').data('precio');
            $('#precio_venta').val(precioServicio);
            calcularTotal();
        });

        // Update price when product is selected
        $('#id_productos').change(function() {
            var precioProducto = $(this).find(':selected').data('precio');
            $('#precio_venta').val(precioProducto);
            calcularTotal();
        });
        // Update total when discount changes
        $('#condicion_especial').keyup(function() {
            calcularTotal();
        });

        function calcularTotal() {
            var precioVenta = parseFloat($('#precio_venta').val()) || 0;
            var condicionEspecial = parseFloat($('#condicion_especial').val()) || 0;
            var descuento = precioVenta * (condicionEspecial / 100);
            var totalAPagar = precioVenta - descuento;

            $('#total_a_pagar').val(totalAPagar.toFixed(2));
        }
    });
</script>