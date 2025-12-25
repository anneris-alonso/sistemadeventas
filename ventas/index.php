<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');
include('../app/controllers/compras/listado_de_compras.php');

$query_ventas = "SELECT v.*, c.nombre_clt  -- Select all from ventas and client name
                 FROM tb_ventas v
                 LEFT JOIN tb_clients c ON v.id_clients = c.id_clients    -- Join based on id_clients
                 WHERE v.id_negocios = :id_negocios    -- Filter by business ID
                 ORDER BY id_venta DESC"; // Assuming id_venta is your primary key

$query_ventas = $pdo->prepare($query_ventas);
$query_ventas->execute(['id_negocios' => $_SESSION['negocio_id']]); // Use session variable for business ID

$ventas_datos = $query_ventas->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Listado de ventas a clientes</h1>
                    <a href="create.php" class="btn btn-primary mr-1">
                        <i class="fa fa-plus"></i> Agregar Nuevo    
                    </a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ventas registrados</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body" style="display: block;">
                            <div class="table table-responsive">
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>
                                                <center>Nro</center>
                                            </th>
                                            <th>
                                                <center>Nro de la venta</center>
                                            </th>
                                            <th>
                                                <center>Producto</center>
                                            </th>
                                            <th>
                                                <center>Fecha de venta</center>
                                            </th>
                                            <th>
                                                <center>Cliente</center>
                                            </th>
                                            <th>
                                                <center>Comprobante</center>
                                            </th>
                                            <th>
                                                <center>Usuario</center>
                                            </th>
                                            <th>
                                                <center>Precio de venta</center>
                                            </th>
                                            <th>
                                                <center>Cantidad</center>
                                            </th>
                                            <th>
                                                <center>Acciones</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        foreach ($ventas_datos as $ventas_dato) {
                                            $id_venta = $ventas_dato['id_venta']; ?>
                                            <tr>
                                                <td><?php echo $contador = $contador + 1; ?></td>
                                                <td><?php echo $ventas_dato['nro_venta']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#modal-producto<?php echo $id_venta; ?>">
                                                        <?php echo $ventas_dato['nombre_producto']; ?>
                                                    </button>
                                                    <!-- modal para visualizar datos de los productos -->
                                                    <div class="modal fade" id="modal-producto<?php echo $id_venta; ?>">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color: #07b0d6;color: white">
                                                                    <h4 class="modal-title">Datos del producto</h4>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div class="row">
                                                                        <div class="col-md-9">
                                                                            <div class="row">
                                                                                <div class="col-md-2">
                                                                                    <div class="form-group">
                                                                                        <label for="">Código</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['codigo']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="">Nombre del
                                                                                            producto</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['nombre']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="">Descripción del
                                                                                            producto</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['descripcion']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="">Stock</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['stock']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="">Stock mínimo</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['stock_minimo']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="">Stock máximo</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['stock_maximo']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="">Fecha de
                                                                                            Ingreso</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['fecha_ingreso']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="">Precio Compra</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['precio_compra_producto']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="">Precio Venta</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['precio_venta_producto']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="">Categoría</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['nombre_categoria']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="form-group">
                                                                                        <label for="">Usuario</label>
                                                                                        <input type="text"
                                                                                            value="<?php echo $ventas_dato['nombre_usuarios_producto']; ?>"
                                                                                            class="form-control" disabled>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label for="">Imagen del producto</label>
                                                                                <img src="<?php echo $URL . "/almacen/img_productos/" . $ventas_dato['imagen']; ?>"
                                                                                    width="100%" alt="">
                                                                            </div>
                                                                        </div>
                                                                    </div>





                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->
                                                </td>
                                                <td><?php echo $ventas_dato['fecha_venta']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#modal-cliente<?php echo $id_venta; ?>">
                                                        <?php echo $ventas_dato['nombre_cliente']; ?>
                                                    </button>

                                                    <!-- modal para visualizar datos de los proveedor -->
                                                    <div class="modal fade" id="modal-cliente<?php echo $id_venta; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header"
                                                                    style="background-color: #07b0d6;color: white">
                                                                    <h4 class="modal-title">Datos del cliente</h4>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Nombre del cliente</label>
                                                                                <input type="text"
                                                                                    value="<?php echo $ventas_dato['nombre_clt']; ?>"
                                                                                    class="form-control" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Teléfono</label>
                                                                                <input type="text"
                                                                                    value="<?php echo $ventas_dato['telefono_clt']; ?>"
                                                                                    class="form-control" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Foto</label>
                                                                                <input type="text"
                                                                                    value="<?php echo $ventas_dato['empresa']; ?>"
                                                                                    class="form-control" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Email del proveedor</label>
                                                                                <input type="text"
                                                                                    value="<?php echo $compras_dato['email_proveedor']; ?>"
                                                                                    class="form-control" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="">Dirección</label>
                                                                                <input type="text"
                                                                                    value="<?php echo $compras_dato['direccion_proveedor']; ?>"
                                                                                    class="form-control" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    <!-- /.modal -->

                                                </td>
                                                <td><?php echo $compras_dato['comprobante']; ?></td>
                                                <td><?php echo $compras_dato['nombres_usuario']; ?></td>
                                                <td><?php echo $compras_dato['precio_compra']; ?></td>
                                                <td><?php echo $compras_dato['cantidad']; ?></td>
                                                <td>
                                                    <center>
                                                        <div class="btn-group">
                                                            <a href="show.php?id=<?php echo $id_compra; ?>" type="button"
                                                                class="btn btn-info btn-sm"><i class="fa fa-eye"></i>
                                                                Ver</a>
                                                            <a href="update.php?id=<?php echo $id_compra; ?>" type="button"
                                                                class="btn btn-success btn-sm"><i
                                                                    class="fa fa-pencil-alt"></i> Editar</a>
                                                            <a href="delete.php?id=<?php echo $id_compra; ?>" type="button"
                                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>
                                                                Borrar</a>
                                                        </div>
                                                    </center>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php include('../layout/mensajes.php'); ?>
<?php include('../layout/parte2.php'); ?>


<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "<?php echo __('no_data_available'); ?>",
                "info": "<?php echo __('showing'); ?> _START_ <?php echo __('to'); ?> _END_ <?php echo __('of'); ?> _TOTAL_ <?php echo __('purchases'); ?>",
                "infoEmpty": "<?php echo __('showing_0_to_0_of_0'); ?>",
                "infoFiltered": "(<?php echo __('filtered_from'); ?> _MAX_ <?php echo __('purchases'); ?>)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "<?php echo __('show'); ?> _MENU_ <?php echo __('purchases'); ?>",
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

</script>