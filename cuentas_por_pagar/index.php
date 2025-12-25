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
                    <h1 class="m-0"><?php echo __('accounts_payable_list'); ?></h1>
                    <a href="create.php" class="btn btn-primary mr-1">
                        <i class="fa fa-plus"></i> <?php echo __('add_new'); ?>
                    </a>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalRegistrarPago">
                        <i class="fa fa-money-bill"></i> <?php echo __('register_payment'); ?>
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
                            <h3 class="card-title"><?php echo __('registered_accounts_payable'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center><?php echo __('number'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('provider'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('invoice'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('due_date'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('total_amount'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('pending_balance'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('status'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('actions'); ?></center>
                                            </th>
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
                                                    <td>
                                                        <center><?php echo ++$contador; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $nombre_proveedor; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $numero_factura; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $fecha_vencimiento; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $monto_total; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $saldo_pendiente; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $estado; ?></center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <div class="btn-group">
                                                                <a href="show.php?id=<?php echo $id_cuentas_pagar; ?>"
                                                                    type="button" class="btn btn-info btn-sm"><i
                                                                        class="fa fa-eye"></i></a>
                                                                <a href="update.php?id=<?php echo $id_cuentas_pagar; ?>"
                                                                    type="button" class="btn btn-success btn-sm"><i
                                                                        class="fa fa-pencil-alt"></i></a>
                                                                <a href="delete.php?id=<?php echo $id_cuentas_pagar; ?>"
                                                                    type="button" class="btn btn-danger btn-sm"><i
                                                                        class="fa fa-trash"></i></a>
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
<div class="modal fade" id="modalRegistrarPago" tabindex="-1" role="dialog" aria-labelledby="modalRegistrarPagoLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarPagoLabel"><?php echo __('register_payment'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formRegistrarPago" action="../app/controllers/cuentas_por_pagar/registrar_pago.php"
                    method="post">
                    <div class="form-group">
                        <label for="id_cuentas_por_pagar"><?php echo __('account_payable'); ?>:</label>
                        <select class="form-control" id="id_cuentas_por_pagar" name="id_cuentas_por_pagar" required>
                            <option value=""><?php echo __('select_account'); ?></option>
                            <?php foreach ($cuentas_datos as $cuenta_dato): ?>
                                <option value="<?php echo $cuenta_dato['id_cuentas_por_pagar']; ?>"
                                    data-saldo="<?php echo $cuenta_dato['saldo_pendiente']; ?>">
                                    <?php echo "Factura: " . $cuenta_dato['numero_factura'] . " - Proveedor: " . $cuenta_dato['nombre_proveedor'] . " - Saldo: " . $cuenta_dato['saldo_pendiente']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="monto_pago"><?php echo __('payment_amount'); ?>:</label>
                        <input type="number" class="form-control" id="monto_pago" name="monto_pago" min="0.01"
                            step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="saldo_pendiente_actual"><?php echo __('current_pending_balance'); ?>:</label>
                        <input type="number" class="form-control" id="saldo_pendiente_actual"
                            name="saldo_pendiente_actual" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo __('register_payment'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal -->

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "<?php echo __('no_data_available'); ?>",
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('accounts_payable'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('accounts_payable'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('accounts_payable'); ?>",
                "loadingRecords": "<?php echo __('loading'); ?>...",
                "processing": "<?php echo __('processing'); ?>...",
                "search": "<?php echo __('search'); ?>:",
                "zeroRecords": "<?php echo __('no_results_found'); ?>",
                "paginate": {
                    "first": "<?php echo __('first'); ?>",
                    "last": "<?php echo __('last'); ?>",
                    "next": "<?php echo __('next'); ?>",
                    "previous": "<?php echo __('previous'); ?>"
                }
            },
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: '<?php echo __('reports'); ?>',
                orientation: 'landscape',
                buttons: [{
                    text: '<?php echo __('copy'); ?>',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                }, {
                    extend: 'csv'
                }, {
                    extend: 'excel'
                }, {
                    text: '<?php echo __('print'); ?>',
                    extend: 'print'
                }]
            },
            {
                extend: 'colvis',
                text: '<?php echo __('column_visibility'); ?>',
                collectionLayout: 'fixed three-column'
            }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    // Update the current balance when selecting an account.
    $('#id_cuenta_pagar').change(function () {
        var saldoPendiente = $(this).find(':selected').data('saldo');
        $('#saldo_pendiente_actual').val(saldoPendiente);
    });
</script>