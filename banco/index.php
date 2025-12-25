<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Include the controller to fetch the bank balance and transactions
include('../app/controllers/banco/listado_de_banco.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Banco</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Balance Actual</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h1><?php echo number_format($saldo_actual, 2); ?></h1>
                            <!-- Form to set initial balance -->
                            <form action="../app/controllers/banco/set_balance.php" method="post">
                                <div class="form-group">
                                    <label for="nuevo_saldo">Establecer Nuevo Balance:</label>
                                    <input type="number" class="form-control" id="nuevo_saldo" name="nuevo_saldo" step="0.01" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Establecer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Transacciones</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla-banco" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nro</th>
                                            <th>Tipo</th>
                                            <th>Monto</th>
                                            <th>Descripcion</th>
                                            <th>Fecha/Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($transacciones_datos as $transaccion) {
                                            $contador++;
                                            ?>
                                            <tr>
                                                <td><?php echo $contador; ?></td>
                                                <td><?php echo $transaccion['tipo']; ?></td>
                                                <td><?php echo number_format($transaccion['monto'], 2); ?></td>
                                                <td><?php echo $transaccion['descripcion']; ?></td>
                                                <td><?php echo $transaccion['fecha_hora']; ?></td>
                                            </tr>
                                            <?php
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
    $(function() {
        $("#tabla-banco").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Transacciones",
                "infoEmpty": "Mostrando 0 a 0 de 0 Transacciones",
                "infoFiltered": "(Filtrado de _MAX_ total Transacciones)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Transacciones",
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
        }).buttons().container().appendTo('#tabla-banco_wrapper .col-md-6:eq(0)');
    });
</script>
