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
                <i class="fa fa-plus"></i> Agregar Nuevo Rol
            </button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Roles registrados</h3>
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
                                        <th>Nro</th>
                                        <th>Nombre del rol</th>
                                        <th>Acciones</th>
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
                                                    <a href="update.php?id=<?php echo $id_rol; ?>" type="button" class="btn btn-success btn-sm" title="Editar Rol" target="_blank">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>

                                                    <a href="delete.php?id=<?php echo $id_rol; ?>" type="button" class="btn btn-danger btn-sm" title="Eliminar Rol" target="_blank">
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
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">Agregar Nuevo Rol</h5>
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
   $(document).ready(function() {
    $('#table_roles').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Roles",
            "infoEmpty": "Mostrando 0 a 0 de 0 Roles",
            "infoFiltered": "(Filtrado de _MAX_ total Roles)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Roles",
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
    });
});
</script>
