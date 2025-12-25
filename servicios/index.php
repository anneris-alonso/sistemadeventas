<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

// Incluir el controlador para el listado de servicios
include ('../app/controllers/servicios/listado_de_servicios.php'); 
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de Servicios
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
                            <h3 class="card-title">Servicios registrados</h3>
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
                                            <th>Nombre del servicio</th>
                                            <th>Tipo</th>
                                            <th>Precio de compra</th>
                                            <th>Precio Base</th>
                                            <th>Impuesto (%)</th>
                                            <th>Precio de Venta</th>
                                            <th>Duracion</th>
                                            <th>Ganancias</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($servicios_datos as $servicio_dato) {
                                            $id_servicio = $servicio_dato['id_servicios'];
                                            $nombre_servicio = $servicio_dato['servicio'];
                                            ?>
                                            <tr>
                                                <td><?php echo ++$contador; ?></td>
                                                <td><?php echo $nombre_servicio; ?></td>
                                                <td><?php echo $servicio_dato['tipo']; ?></td>
                                                <td><?php echo $servicio_dato['precio_de_compra']; ?></td>
                                                <td><?php echo $servicio_dato['precio_serv']; ?></td>
                                                <td><?php echo $servicio_dato['impuesto']; ?></td>
                                                <td><?php echo $servicio_dato['precio_final']; ?></td>
                                                <td><?php echo $servicio_dato['duracion']; ?></td>
                                                <td><?php echo $servicio_dato['ganancias']; ?></td>
                                                

                                                <td>
                                                    <div class="btn-group">
                                                        <a href="update.php?id=<?php echo $id_servicio; ?>" type="button" class="btn btn-success btn-sm m-1" title="Editar Servicio">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="delete.php?id=<?php echo $id_servicio; ?>" type="button" class="btn btn-danger btn-sm m-1" title="Eliminar Servicio">
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
include ('../layout/mensajes.php'); 
include ('../layout/parte2.php'); 
?>

<script>
    // Script para la tabla 
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Servicios",
                "infoEmpty": "Mostrando 0 a 0 de 0 Servicios",
                "infoFiltered": "(Filtrado de _MAX_ total Servicios)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Servicios",
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
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                },{
                    extend: 'csv'
                },{
                    extend: 'excel'
                },{
                    text: 'Imprimir',
                    extend: 'print'
                }
                ]
            },
            {
                extend: 'colvis',
                text: 'Visor de columnas',
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
                <h4 class="modal-title">Creación de un nuevo servicio</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nombre del servicio <b>*</b></label>
                            <input type="text" id="servicio" name="servicio" class="form-control"> 
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for="">Tipo de servicio <b>*</b></label>
                            <input type="text" id="tipo" name="tipo" class="form-control"> 
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for="">Precio del servicio <b>*</b></label>
                            <input type="text" id="precio_serv" name="precio_serv" class="form-control"> 
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for="">Duracion del servicio <b>*</b></label>
                            <input type="text" id="duracion" name="duracion" class="form-control"> 
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                         <div class="form-group">
                            <label for="">Impuesto (%) <b>*</b></label>
                            <input type="number" step="0.01" id="impuesto" name="impuesto" class="form-control" value="0.00">
                        </div>
                        <div class="form-group">
                            <label for="">Precio de compra <b>*</b></label>
                            <input type="text" id="precio_de_compra" name="precio_de_compra" class="form-control"> 
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                        <div class="form-group">
                            <label for="">Precio de venta <b>*</b></label>
                            <input type="text" id="precio_final" name="precio_final" class="form-control"> 
                            <small style="color: red;display: none" id="lbl_create">* Este campo es requerido</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn_create">Guardar servicio</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn_create').click(function () {
        var servicio = $('#servicio').val();
        var tipo = $('#tipo').val();
        var precio_serv = $('#precio_serv').val();
        var duracion = $('#duracion').val();
        var impuesto = $('#impuesto').val();


        if(servicio == "" || tipo == ""){ 
            $('#servicio').focus();
            $('#lbl_create').css('display','block');
        } else {
            var url = "../app/controllers/servicios/create.php";
            $.ajax({
                url: url,
                type: 'POST', 
                data: {servicio:servicio, tipo:tipo, precio_serv:precio_serv, duracion:duracion, impuesto:impuesto}, 
                success: function (datos) {
                    $('#respuesta').html(datos);
                }
            });
        }
    });
</script>
<div id="respuesta"></div>
