<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

// Incluir el controlador para el listado de usuarios
include('../app/controllers/usuarios/listado_de_usuarios.php'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0"><?php echo __('employees_list'); ?>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#rolesModal">
                            <i class="fa fa-user-tag"></i> <?php echo __('manage_roles'); ?>
                        </button>
                        <a href="create.php" class="btn btn-primary">
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
                            <h3 class="card-title"><?php echo __('registered_employees'); ?></h3>
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
                                            <th><?php echo __('names'); ?></th>
                                            <th><?php echo __('email'); ?></th>
                                            <th><?php echo __('user_role'); ?></th>
                                            <th><?php echo __('salary'); ?></th>
                                            <th><?php echo __('work_permit'); ?></th>
                                            <th><?php echo __('health_insurance'); ?></th>
                                            <th><?php echo __('employee_type'); ?></th>
                                            <th><?php echo __('actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($usuarios_datos as $usuario_dato) {
                                            $id_usuario = $usuario_dato['id_usuario'];
                                            $nombres = $usuario_dato['nombres'];
                                            $email = $usuario_dato['email'];
                                            $rol = $usuario_dato['rol'];
                                            $salario = $usuario_dato['salario'];
                                            $num_permiso_trabajo = $usuario_dato['num_permiso_trabajo'];
                                            $seguro_medico = $usuario_dato['seguro_medico'];
                                            $tipo_empleado = $usuario_dato['tipo_empleado'];
                                            ?>
                                            <tr>
                                                <td><?php echo ++$contador; ?></td>
                                                <td><?php echo $nombres; ?></td>
                                                <td><?php echo $email; ?></td>
                                                <td><?php echo $rol; ?></td>
                                                <td><?php echo $salario; ?></td>
                                                <td><?php echo $num_permiso_trabajo; ?></td>
                                                <td><?php echo $seguro_medico; ?></td>
                                                <td><?php echo $tipo_empleado; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="show.php?id=<?php echo $id_usuario; ?>" type="button"
                                                            class="btn btn-info btn-sm m-1"
                                                            title="<?php echo __('view_user'); ?>">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="update.php?id=<?php echo $id_usuario; ?>" type="button"
                                                            class="btn btn-success btn-sm m-1"
                                                            title="<?php echo __('edit_user'); ?>">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="delete.php?id=<?php echo $id_usuario; ?>" type="button"
                                                            class="btn btn-danger btn-sm m-1"
                                                            title="<?php echo __('delete_user'); ?>">
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

<!-- Roles Modal -->
<div class="modal fade" id="rolesModal" tabindex="-1" role="dialog" aria-labelledby="rolesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rolesModalLabel"><?php echo __('manage_roles'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include the roles list code -->
                <?php include('../roles/index.php'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo __('close'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#rolesModal').on('hidden.bs.modal', function (e) {
            location.reload();
        });
    });
</script>

<?php
include('../layout/mensajes.php');
include('../layout/parte2.php'); ?>

<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "<?php echo __('no_data_available'); ?>",
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('users'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('total_users'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('users'); ?>",
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
</script>