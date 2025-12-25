<?php
// categorias/index.php
include('../app/controllers/categorias/listado_de_categoria.php');
?>

<div class="content">
    <div class="row mb-2">
        <div class="col-sm-12">
            <!-- Button to Open the Add New Category Modal -->
            <button type="button" class="btn btn-primary mr-1" data-toggle="modal" data-target="#addCategoryModal">
                <i class="fa fa-plus"></i> Agregar Nueva Categoría
            </button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Categorías Registradas</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table id="table_categorias" class="table table-hover text-nowrap table-sm">
                            <thead>
                                <tr>
                                    <th>Nro</th>
                                    <th>Nombre de la categoría</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contador = 0;
                                foreach ($categorias_datos as $categoria_dato) {
                                    $id_categoria = $categoria_dato['id_categoria'];
                                    $nombre_categoria = $categoria_dato['nombre_categoria'];
                                ?>
                                    <tr>
                                        <td><?php echo ++$contador; ?></td>
                                        <td><?php echo $nombre_categoria; ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="update.php?id=<?php echo $id_categoria; ?>" class="btn btn-success btn-sm" title="Editar Categoría" target="_blank">
                                                <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a href="delete.php?id=<?php echo $id_categoria; ?>" class="btn btn-danger btn-sm" title="Eliminar Categoría" target="_blank">
                                                    <i class="fas fa-trash"></i>
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

<!-- Add New Category Modal (Nested) -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Agregar Nueva Categoría</h5>
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
    $('#table_categorias').DataTable({
        "pageLength": 5,
        "language": {
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Categorías",
            "infoEmpty": "Mostrando 0 a 0 de 0 Categorías",
            "infoFiltered": "(Filtrado de _MAX_ total Categorías)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Categorías",
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
