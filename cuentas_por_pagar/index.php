<?php
// cuentas_por_pagar/index.php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Include the controller to fetch the list of accounts payable
include('../app/controllers/cuentas_por_pagar/listado_de_cuentas.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de cuentas por pagar</h1>
                    <a href="create.php" class="btn btn-primary mr-1">
                        <i class="fa fa-plus"></i> Agregar Nuevo
                    </a>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalRegistrarPago">
                        <i class="fa fa-money-bill"></i> Registrar Pago
                    </button>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cuentas por pagar registradas</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><center>Nro</center></th>
                                            <th><center>Proveedor</center></th>
                                            <th><center>Factura</center></th>
                                            <th><center>Vencimiento</center></th>
                                            <th><center>Monto Total</center></th>
                                            <th><center>Saldo Pendiente</center></th>
                                            <th><center>Estado</center></th>
                                            <th><center>Acciones</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        if (count($cuentas_datos) > 0) {
                                            foreach ($cuentas_datos as $cuenta_dato) {
                                                $id_cuentas_por_pagar = $cuenta_dato['id_cuentas_por_pagar'];
                                                $nombre_proveedor = $cuenta_dato['nombre_proveedor'];
                                                $numero_factura = $cuenta_dato['numero_factura'];
                                                $fecha_vencimiento = $cuenta_dato['fecha_vencimiento'];
                                                $monto_total = $cuenta_dato['monto_total'];
                                                $saldo_pendiente = $cuenta_dato['saldo_pendiente'];
                                                $estado = $cuenta_dato['estado'];
                                                ?>
                                                <tr>
                                                    <td><center><?php echo ++$contador; ?></center></td>
                                                    <td><center><?php echo $nombre_proveedor; ?></center></td>
                                                    <td><center><?php echo $numero_factura; ?></center></td>
                                                    <td><center><?php echo $fecha_vencimiento; ?></center></td>
                                                    <td><center><?php echo $monto_total; ?></center></td>
                                                    <td><center><?php echo $saldo_pendiente; ?></center></td>
                                                    <td><center><?php echo $estado; ?></center></td>
                                                    <td>
                                                        <center>
                                                            <div class="btn-group">
                                                                <a href="show.php?id=<?php echo $id_cuentas_pagar; ?>" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                                <a href="update.php?id=<?php echo $id_cuentas_pagar; ?>" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i></a>
                                                                <a href="delete.php?id=<?php echo $id_cuentas_pagar; ?>" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal for Registrar Pago -->
<div class="modal fade" id="modalRegistrarPago" tabindex="-1" role="dialog" aria-labelledby="modalRegistrarPagoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarPagoLabel">Registrar Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarPago" action="../app/controllers/cuentas_por_pagar/registrar_pago.php" method="post">
                    <div class="form-group">
                        <label for="id_cuentas_por_pagar">Cuenta por Pagar:</label>
                        <select class="form-control" id="id_cuentas_por_pagar" name="id_cuentas_por_pagar" required>
                            <option value="">Seleccione una cuenta</option>
                            <?php foreach ($cuentas_datos as $cuenta_dato): ?>
                                <option value="<?php echo $cuenta_dato['id_cuentas_por_pagar']; ?>" data-saldo="<?php echo $cuenta_dato['saldo_pendiente']; ?>">
                                    <?php echo "Factura: " . $cuenta_dato['numero_factura'] . " - Proveedor: " . $cuenta_dato['nombre_proveedor'] . " - Saldo: ". $cuenta_dato['saldo_pendiente']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="monto_pago">Monto del Pago:</label>
                        <input type="number" class="form-control" id="monto_pago" name="monto_pago" min="0.01" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="saldo_pendiente_actual">Saldo Pendiente Actual:</label>
                        <input type="number" class="form-control" id="saldo_pendiente_actual" name="saldo_pendiente_actual" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Pago</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Cuentas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Cuentas",
                "infoFiltered": "(Filtrado de _MAX_ total Cuentas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Cuentas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            buttons: [{
                    extend: 'collection',
                    text: 'Reportes',
                    orientation: 'landscape',
                    buttons: [{
                        text: 'Copiar',
                        extend: 'copy',
                    }, {
                        extend: 'pdf'
                    }, {
                        extend: 'csv'
                    }, {
                        extend: 'excel'
                    }, {
                        text: 'Imprimir',
                        extend: 'print'
                    }]
                },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
// Update the current balance when selecting an account.
    $('#id_cuenta_pagar').change(function() {
        var saldoPendiente = $(this).find(':selected').data('saldo');
        $('#saldo_pendiente_actual').val(saldoPendiente);
    });
</script>
