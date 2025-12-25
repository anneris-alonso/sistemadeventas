<?php
include('../app/config.php');
include('../layout/sesion.php');

include('../layout/parte1.php');

include('../app/controllers/inversiones/listado_de_inversiones.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Inversiones
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">
                            <i class="fa fa-plus"></i> Agregar Nuevo
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
                            <h3 class="card-title">Inversiones registradas</h3>
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
                                            <th>Motivo de la inversion</th>
                                            <th>Costo de la inversion</th>
                                            <th>Fecha de la inversion</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($inversiones_datos as $inversion_dato) {
                                            $id_inversiones = $inversion_dato['id_inversiones'];
                                            $motivo_inversion = $inversion_dato['motivo_inversion'];
                                            ?>
                                            <tr>
                                                <td><?php echo ++$contador; ?></td>
                                                <td><?php echo $motivo_inversion; ?></td>
                                                <td><?php echo $inversion_dato['costo_inversion']; ?></td>
                                                <td><?php echo $inversion_dato['fecha_inversion']; ?></td>
                                                <td><?php echo $inversion_dato['id_usuario']; ?></td>


                                                <td>
                                                    <div class="btn-group">
                                                        <a href="update.php?id=<?php echo $id_inversiones; ?>" type="button"
                                                            class="btn btn-success btn-sm m-1" title="Editar">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="delete.php?id=<?php echo $id_inversiones; ?>" type="button"
                                                            class="btn btn-danger btn-sm m-1" title="Eliminar">
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
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('investments'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('investments'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('investments'); ?>",
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
                <h4 class="modal-title">Creación de un nueva inversion</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Motivo de la Inversion <b>*</b></label>
                            <input type="text" id="motivo_inversion" name="motivo_inversion" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for="">Costo de la Inversion <b>*</b></label>
                            <input type="number" id="costo_inversion" name="costo_inversion" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for="">Fecha de la Inversion <b>*</b></label>
                            <input type="date" id="fecha_inversion" name="fecha_inversion" class="form-control">
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_create">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // ... (rest of your JavaScript)

    $('#btn_create').click(function () {
        var motivo_inversion = $('#motivo_inversion').val();
        var costo_inversion = $('#costo_inversion').val();
        var fecha_inversion = $('#fecha_inversion').val();

        // Get CSRF token (MUST ADD THIS TO YOUR FORM)
        var csrf_token = $('meta[name="csrf-token"]').attr('content');  // Assuming you add a meta tag

        if (motivo_inversion == "" || costo_inversion == "" || fecha_inversion == "") {
            // Improved validation feedback
            alert("Please fill in all required fields.");
            if (motivo_inversion == "") { $('#motivo_inversion').focus(); }
            else if (costo_inversion == "") { $('#costo_inversion').focus(); }
            else { $('#fecha_inversion').focus(); }

            return; // Stop execution if there are errors
        }

        var url = "../app/controllers/inversiones/create.php";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                motivo_inversion: motivo_inversion,
                costo_inversion: costo_inversion,
                fecha_inversion: fecha_inversion,
                csrf_token: csrf_token,          // Include CSRF token
                id_usuario: <?= $_SESSION['id_usuario'] ?? 0 ?> // Send user ID (Handle potential missing ID gracefully)
            },
            success: function (response) { // Use response instead of datos (more descriptive)
                try {
                    // Parse JSON response
                    var result = JSON.parse(response);

                    if (result.success) { // Check for success message
                        alert(result.message);
                        $('#modal-create').modal('hide');
                        location.reload();
                    } else {
                        alert("Error: " + result.message); // Display error message
                    }
                } catch (error) { // Handle invalid JSON (likely a PHP error)
                    console.error("Invalid JSON response:", error);
                    alert("An error occurred. Please check the console.");
                }

            },
            error: function (xhr, status, error) { // Add error handling
                console.error("AJAX Error:", xhr, status, error);
                alert("An AJAX error occurred.");
            }
        });
    });

</script>

<div id="respuesta"></div>