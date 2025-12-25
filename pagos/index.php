<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Include the correct controller for listing payments
include('../app/controllers/pagos/listado_de_pagos.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('payments_list'); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('registered_payments'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table table-responsive">
                                <table id="tabla-pagos" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center><?php echo __('number'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('type'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('account'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('amount'); ?></center>
                                            </th>
                                            <th>
                                                <center><?php echo __('date_time'); ?></center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        if (count($pagos_datos) > 0) {
                                            foreach ($pagos_datos as $pago_dato) {
                                                $id_pagos = $pago_dato['id_pagos'];
                                                $tipo_cuenta = $pago_dato['tipo_cuenta'];
                                                $cuenta = $pago_dato['cuenta'];
                                                $monto_pago = $pago_dato['monto_pago'];
                                                $fyh_creacion = $pago_dato['fyh_creacion'];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <center><?php echo ++$contador; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $tipo_cuenta; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $cuenta; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $monto_pago; ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?php echo $fyh_creacion; ?></center>
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
        </div>
    </div>
</div>

<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>

<script>
    $(function () {
        $("#tabla-pagos").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "<?php echo __('no_data_available'); ?>",
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('payments'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('payments'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('payments'); ?>",
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
        }).buttons().container().appendTo('#tabla-pagos_wrapper .col-md-6:eq(0)');
    });
</script>