<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

// Include the correct controller for listing payments
include('../app/controllers/pagos/listado_de_pagos.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Pagos</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pagos Registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table table-responsive">
                                <table id="tabla-pagos" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><center>Nro</center></th>
                                            <th><center>Tipo</center></th>
                                            <th><center>Cuenta</center></th>
                                            <th><center>Monto</center></th>
                                            <th><center>Fecha/Hora</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        if (count($pagos_datos) > 0) {
                                            foreach ($pagos_datos as $pago_dato) {
                                                $id_pagos = $pago_dato['id_pagos'];
                                                $tipo_cuenta = $pago_dato['tipo_cuenta'];
                                                $cuenta = $pago_dato['cuenta'];
                                                $monto_pago = $pago_dato['monto_pago'];
                                                $fyh_creacion = $pago_dato['fyh_creacion'];
                                                ?>
                                                <tr>
                                                    <td><center><?php echo ++$contador; ?></center></td>
                                                    <td><center><?php echo $tipo_cuenta; ?></center></td>
                                                    <td><center><?php echo $cuenta; ?></center></td>
                                                    <td><center><?php echo $monto_pago; ?></center></td>
                                                    <td><center><?php echo $fyh_creacion; ?></center></td>
                                                </tr>
                                                <?php
                                            }
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
        $("#tabla-pagos").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Pagos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Pagos",
                "infoFiltered": "(Filtrado de _MAX_ total Pagos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Pagos",
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
        }).buttons().container().appendTo('#tabla-pagos_wrapper .col-md-6:eq(0)');
    });
</script>
