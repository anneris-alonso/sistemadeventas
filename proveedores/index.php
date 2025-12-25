<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

include('../app/controllers/proveedores/listado_de_proveedores.php'); // Controller for fetching providers
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('providers_list'); ?>
                        <a href="create.php" class="btn btn-primary float-right">
                            <i class="fa fa-plus"></i> <?php echo __('add_new'); ?>
                        </a>
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
                            <h3 class="card-title"><?php echo __('registered_providers'); ?></h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><?php echo __('number'); ?></th>
                                            <th><?php echo __('provider_name'); ?></th>
                                            <th><?php echo __('cellphone'); ?></th>
                                            <th><?php echo __('phone'); ?></th>
                                            <th><?php echo __('company'); ?></th>
                                            <th><?php echo __('email'); ?></th>
                                            <th><?php echo __('address'); ?></th>
                                            <th><?php echo __('actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($proveedores_datos as $proveedores_dato):
                                            $id_proveedor = $proveedores_dato['id_proveedor'];
                                            $nombre_proveedor = $proveedores_dato['nombre_proveedor'];
                                            $celular = $proveedores_dato['celular'];
                                            $telefono = $proveedores_dato['telefono'];
                                            $empresa = $proveedores_dato['empresa'];
                                            $email = $proveedores_dato['email'];
                                            $direccion = $proveedores_dato['direccion'];
                                            ?>
                                            <tr>
                                                <td><?php echo ++$contador; ?></td>
                                                <td><?php echo $nombre_proveedor; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="tel:+<?php echo $celular; ?>"
                                                            class="btn btn-success btn-sm m-1"
                                                            title="<?php echo __('call'); ?>">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </a>
                                                        <a href="https://wa.me/+<?php echo $celular; ?>?text=Hola,%20me%20gustaría%20obtener%20más%20información%20sobre%20sus%20productos"
                                                            target="_blank" class="btn btn-success btn-sm m-1"
                                                            title="WhatsApp">
                                                            <i class="fab fa-whatsapp"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td><?php echo $telefono; ?></td>
                                                <td><?php echo $empresa; ?></td>
                                                <td><?php echo $email; ?></td>
                                                <td><?php echo $direccion; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="update.php?id=<?php echo $id_proveedor; ?>"
                                                            class="btn btn-success btn-sm m-1"
                                                            title="<?php echo __('edit_provider'); ?>">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>

                                                        <a href="../app/controllers/proveedores/delete.php?id=<?php echo $id_proveedor; ?>"
                                                            class="btn btn-danger btn-sm m-1"
                                                            title="<?php echo __('delete_provider'); ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "<?php echo __('no_data_available'); ?>",
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('providers'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('providers'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('providers'); ?>",
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
            <div class="modal-header" style="background-color: #1d36b6; color: white;">
                <h4 class="modal-title"><?php echo __('create_new_provider'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../app/controllers/proveedores/create.php" method="post" id="create-form">
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('cancel'); ?></button>
                <button type="button" class="btn btn-primary"
                    id="btn_create"><?php echo __('save_provider'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn_create').click(function () {

        var form = $('#create-form'); // Get form data
        var url = form.attr('action'); // Get form action URL

        $.post(url, form.serialize(), function (response) { // Use $.post
            $('#respuesta').html(response);
            form[0].reset(); // Reset the form after successful submission
            // Add any logic you need to update the table with the new record
            location.reload(); // reload page to see changes


        });

    });
</script>

<div id="respuesta"></div>