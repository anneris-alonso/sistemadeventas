<?php
// roles/index.php
// Incluir el controlador para el listado de roles
include('../app/controllers/roles/listado_de_roles.php');
?>

<div class="content">
    <div class="row mb-2">
        <div class="col-sm-12">
            <!-- Button to Open the Add New Role Modal -->
            <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-target="#addRoleModal">
                <i class="fa fa-plus"></i> <?php echo __('add_new_role'); ?>
            </button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo __('registered_roles'); ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">
                        <div class="table-responsive">
                            <table id="table_roles" class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th><?php echo __('number'); ?></th>
                                        <th><?php echo __('role_name'); ?></th>
                                        <th><?php echo __('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;
                                    foreach ($roles_datos as $roles_dato) {
                                        $id_rol = $roles_dato['id_rol'];
                                        ?>
                                        <tr>
                                            <td><?php echo ++$contador; ?></td>
                                            <td><?php echo $roles_dato['rol']; ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="update.php?id=<?php echo $id_rol; ?>" type="button"
                                                        class="btn btn-success btn-sm"
                                                        title="<?php echo __('edit_role'); ?>" target="_blank">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>

                                                    <a href="delete.php?id=<?php echo $id_rol; ?>" type="button"
                                                        class="btn btn-danger btn-sm"
                                                        title="<?php echo __('delete_role'); ?>" target="_blank">
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

<!-- Add New Role Modal (Nested) -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel"><?php echo __('add_new_role'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php include('create_modal_content.php'); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#table_roles').DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "<?php echo __('no_data_available'); ?>",
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('roles'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('roles'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('roles'); ?>",
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
        });
    });
</script>