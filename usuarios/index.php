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
                    <h1 class="m-0">Listado de Empleados
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#rolesModal">
                            <i class="fa fa-user-tag"></i> Administrar Roles
                        </button>
                        <a href="create.php" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Agregar Nuevo
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
                            <h3 class="card-title">Empleados registrados</h3>
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
                                            <th>Nro</th>
                                            <th>Nombres</th>
                                            <th>Email</th>
                                            <th>Rol del usuario</th>
                                            <th>Salario</th>
                                            <th>Número de permiso de trabajo</th>
                                            <th>Seguro médico</th>
                                            <th>Tipo de empleado</th>
                                            <th>Acciones</th>
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
                                                        <a href="show.php?id=<?php echo $id_usuario; ?>" type="button" class="btn btn-info btn-sm m-1" title="Ver Usuario">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="update.php?id=<?php echo $id_usuario; ?>" type="button" class="btn btn-success btn-sm m-1" title="Editar Usuario">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="delete.php?id=<?php echo $id_usuario; ?>" type="button" class="btn btn-danger btn-sm m-1" title="Eliminar Usuario">
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
<div class="modal fade" id="rolesModal" tabindex="-1" role="dialog" aria-labelledby="rolesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rolesModalLabel">Manage Roles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Include the roles list code -->
                <?php include('../roles/index.php'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#rolesModal').on('hidden.bs.modal', function(e) {
            location.reload();
        });
    });
</script>

<?php
include('../layout/mensajes.php');
include('../layout/parte2.php'); ?>

<script>
    $(function() {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Usuarios",
                "infoFiltered": "(Filtrado de _MAX_ total Usuarios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Usuarios",
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
        }).buttons().container().appendTo('#example1_wrapper.col-md-6:eq(0)');
    });
</script>
