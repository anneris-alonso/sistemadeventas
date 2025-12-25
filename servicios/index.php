<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

// Incluir el controlador para el listado de servicios
include('../app/controllers/servicios/listado_de_servicios.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('services_list'); ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-plus"></i> <?php echo __('add_new'); ?>
                        </button>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('registered_services'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><?php echo __('number'); ?></th>
                                            <th><?php echo __('service_name'); ?></th>
                                            <th><?php echo __('type'); ?></th>
                                            <th><?php echo __('purchase_price'); ?></th>
                                            <th><?php echo __('base_price'); ?></th>
                                            <th><?php echo __('tax'); ?></th>
                                            <th><?php echo __('sale_price'); ?></th>
                                            <th><?php echo __('duration'); ?></th>
                                            <th><?php echo __('profits'); ?></th>
                                            <th><?php echo __('actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($servicios_datos as $servicio_dato) {
                                            $id_servicio = $servicio_dato['id_servicios'];
                                            $nombre_servicio = $servicio_dato['servicio'];
                                            ?>
                                            <tr>
                                                <td><?php echo ++$contador; ?></td>
                                                <td><?php echo $nombre_servicio; ?></td>
                                                <td><?php echo $servicio_dato['tipo']; ?></td>
                                                <td><?php echo $servicio_dato['precio_de_compra']; ?></td>
                                                <td><?php echo $servicio_dato['precio_serv']; ?></td>
                                                <td><?php echo $servicio_dato['impuesto']; ?></td>
                                                <td><?php echo $servicio_dato['precio_final']; ?></td>
                                                <td><?php echo $servicio_dato['duracion']; ?></td>
                                                <td><?php echo $servicio_dato['ganancias']; ?></td>


                                                <td>
                                                    <div class="btn-group">
                                                        <a href="update.php?id=<?php echo $id_servicio; ?>" type="button"
                                                            class="btn btn-success btn-sm m-1"
                                                            title="<?php echo __('edit_service'); ?>">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="delete.php?id=<?php echo $id_servicio; ?>" type="button"
                                                            class="btn btn-danger btn-sm m-1"
                                                            title="<?php echo __('delete_service'); ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
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

<?php
include('../layout/mensajes.php');
include('../layout/parte2.php');
?>

<script>
    // Script para la tabla 
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "<?php echo __('no_data_available'); ?>",
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('services'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('services'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('services'); ?>",
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
            "responsive": true, "lengthChange": true, "autoWidth": false,
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
</script>

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
                        <div class="form-group">
                            <label for=""><?php echo __('service_duration'); ?> <b>*</b></label>
                            <input type="text" id="duracion" name="duracion" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for=""><?php echo __('tax'); ?> <b>*</b></label>
                            <input type="number" step="0.01" id="impuesto" name="impuesto" class="form-control"
                                value="0.00">
                        </div>
                        <div class="form-group">
                            <label for=""><?php echo __('purchase_price'); ?> <b>*</b></label>
                            <input type="text" id="precio_de_compra" name="precio_de_compra" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for=""><?php echo __('sale_price'); ?> <b>*</b></label>
                            <input type="text" id="precio_final" name="precio_final" class="form-control">
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
        var duracion = $('#duracion').val();
        var impuesto = $('#impuesto').val();


        if (servicio == "" || tipo == "") {
            $('#servicio').focus();
            $('#lbl_create').css('display', 'block');
        } else {
            var url = "../app/controllers/servicios/create.php";
            $.ajax({
                url: url,
                type: 'POST',
                data: { servicio: servicio, tipo: tipo, precio_serv: precio_serv, duracion: duracion, impuesto: impuesto },
                success: function (datos) {
                    $('#respuesta').html(datos);
                }
            });
        }
    });
</script>
<div id="respuesta"></div>