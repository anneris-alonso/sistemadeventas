<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Include the controller to fetch the bank balance and transactions
include('../app/controllers/banco/listado_de_banco.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('bank'); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('current_balance'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1><?php echo number_format($saldo_actual, 2); ?></h1>
                            <!-- Form to set initial balance -->
                            <form action="../app/controllers/banco/set_balance.php" method="post">
                                <div class="form-group">
                                    <label for="nuevo_saldo"><?php echo __('set_new_balance'); ?></label>
                                    <input type="number" class="form-control" id="nuevo_saldo" name="nuevo_saldo"
                                        step="0.01" required>
                                </div>
                                <button type="submit" class="btn btn-primary"><?php echo __('set'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('transactions'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla-banco" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo __('number'); ?></th>
                                            <th><?php echo __('type'); ?></th>
                                            <th><?php echo __('amount'); ?></th>
                                            <th><?php echo __('description'); ?></th>
                                            <th><?php echo __('date_time'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($transacciones_datos as $transaccion) {
                                            $contador++;
                                            ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $transaccion['tipo']; ?></td>
                                                <td><?php echo number_format($transaccion['monto'], 2); ?></td>
                                                <td><?php echo $transaccion['descripcion']; ?></td>
                                                <td><?php echo $transaccion['fecha_hora']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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
    $(function () {
        $("#tabla-banco").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "<?php echo __('no_data_available'); ?>",
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('transactions'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('transactions'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('transactions'); ?>",
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
        }).buttons().container().appendTo('#tabla-banco_wrapper .col-md-6:eq(0)');
    });
</script>