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
                    <h1 class="m-0">Listado de Proveedores
                        <a href="create.php" class="btn btn-primary float-right"> 
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
                            <h3 class="card-title">Proveedores registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive"> 
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Nombre del proveedor</th>
                                            <th>Celular</th>
                                            <th>Teléfono</th>
                                            <th>Empresa</th>
                                            <th>Email</th>
                                            <th>Dirección</th>
                                            <th>Acciones</th>
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
                                                        <a href="tel:+<?php echo $celular; ?>" class="btn btn-success btn-sm m-1" title="Llamar">
                                                            <i class="fas fa-phone-alt"></i>
                                                        </a>
                                                        <a href="https://wa.me/+<?php echo $celular; ?>?text=Hola,%20me%20gustaría%20obtener%20más%20información%20sobre%20sus%20productos" target="_blank" class="btn btn-success btn-sm m-1" title="WhatsApp">
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
                                                        <a href="update.php?id=<?php echo $id_proveedor; ?>" class="btn btn-success btn-sm m-1" title="Editar Proveedor">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>

                                                        <a href="../app/controllers/proveedores/delete.php?id=<?php echo $id_proveedor; ?>" class="btn btn-danger btn-sm m-1" title="Eliminar Proveedor">
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
    // ... (Your existing DataTable JavaScript)
</script>

<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1d36b6; color: white;">
                <h4 class="modal-title">Creación de un nuevo proveedor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../app/controllers/proveedores/create.php" method="post" id="create-form">
                    </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_create">Guardar proveedor</button>
            </div>
        </div>
    </div>
</div>

<script>
$('#btn_create').click(function () {

    var form = $('#create-form'); // Get form data
    var url = form.attr('action'); // Get form action URL

    $.post(url, form.serialize(), function(response) { // Use $.post
        $('#respuesta').html(response);
        form[0].reset(); // Reset the form after successful submission
        // Add any logic you need to update the table with the new record
        location.reload(); // reload page to see changes


    });

});
</script>

<div id="respuesta"></div>