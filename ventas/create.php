<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

include ('../app/controllers/almacen/listado_de_productos.php');
include ('../app/controllers/clientes/client_list.php'); // Incluir la lista de clientes
include ('../app/controllers/ventas/listado_de_ventas.php'); // Asegúrate de que este archivo exista y esté adaptado a tb_ventas

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Registro de una nueva venta</h1>
                </div></div></div></div>
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Llene los datos con cuidado</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body" style="display: block;">
                                    <div style="display: flex">
                                        <h5>Datos del producto </h5>
                                        <div style="width: 20px"></div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modal-buscar_producto">
                                            <i class="fa fa-search"></i>
                                            Buscar producto
                                        </button>
                                        <div class="modal fade" id="modal-buscar_producto">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: #1d36b6;color: white">
                                                        <h4 class="modal-title">Busqueda del producto</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table table-responsive">
                                                            <table id="example1" class="table table-bordered table-striped table-sm">
                                                                <thead>
                                                                <tr>
                                                                    <th><center>Nro</center></th>
                                                                    <th><center>Seleccionar</center></th>
                                                                    <th><center>Código</center></th>
                                                                    <th><center>Categoría</center></th>
                                                                    <th><center>Imagen</center></th>
                                                                    <th><center>Nombre</center></th>
                                                                    <th><center>Descripción</center></th>
                                                                    <th><center>Stock</center></th>
                                                                    <th><center>Precio compra</center></th>
                                                                    <th><center>Precio venta</center></th>
                                                                    <th><center>Fecha compra</center></th>
                                                                    <th><center>Usuario</center></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $contador = 0;
                                                                foreach ($productos_datos as $productos_dato){
                                                                    $id_producto = $productos_dato['id_producto']; ?>
                                                                    <tr>
                                                                        <td><?php echo $contador = $contador + 1; ?></td>
                                                                        <td>
                                                                            <button class="btn btn-info btn_selecionar_producto">Seleccionar</button>
                                                                            <script>
                                                                                $('#btn_seleccionar<?php echo $id_producto;?>').click(function () {

                                                                                    var id_producto = "<?php echo $productos_dato['id_producto'];?>";
                                                                                    $('#id_producto').val(id_producto);

                                                                                    var codigo = "<?php echo $productos_dato['codigo'];?>";
                                                                                    $('#codigo').val(codigo);

                                                                                    var categoria = "<?php echo $productos_dato['categoria'];?>";
                                                                                    $('#categoria').val(categoria);

                                                                                    var nombre = "<?php echo $productos_dato['nombre'];?>";
                                                                                    $('#nombre_producto').val(nombre);

                                                                                    var email = "<?php echo $productos_dato['email'];?>";
                                                                                    $('#usuario_producto').val(email);

                                                                                    var descripcion = "<?php echo $productos_dato['descripcion'];?>";
                                                                                    $('#descripcio_producto').val(descripcion);

                                                                                    var stock = "<?php echo $productos_dato['stock'];?>";
                                                                                    $('#stock').val(stock);
                                                                                    $('#stock_actual').val(stock);

                                                                                    var stock_minimo = "<?php echo $productos_dato['stock_minimo'];?>";
                                                                                    $('#stock_minimo').val(stock_minimo);

                                                                                    var stock_maximo = "<?php echo $productos_dato['stock_maximo'];?>";
                                                                                    $('#stock_maximo').val(stock_maximo);

                                                                                    var precio_compra = "<?php echo $productos_dato['precio_compra'];?>";
                                                                                    $('#precio_compra').val(precio_compra);

                                                                                    var precio_venta = "<?php echo $productos_dato['precio_venta'];?>";
                                                                                    $('#precio_venta').val(precio_venta);

                                                                                    var fecha_ingreso = "<?php echo $productos_dato['fecha_ingreso'];?>";
                                                                                    $('#fecha_ingreso').val(fecha_ingreso);

                                                                                    var ruta_img = "<?php echo $URL.'/almacen/img_productos/'.$productos_dato['imagen'];?>";
                                                                                    $('#img_producto').attr({src: ruta_img });

                                                                                    $('#modal-buscar_producto').modal('toggle');

                                                                                });
                                                                            </script>
                                                                        </td>
                                                                        <td><?php echo $productos_dato['codigo'];?></td>
                                                                        <td><?php echo $productos_dato['id_categoria'];?></td>
                                                                        <td>
                                                                            <img src="<?php echo $URL."/almacen/img_productos/".$productos_dato['imagen'];?>" width="50px" alt="asdf">
                                                                        </td>
                                                                        <td><?php echo $productos_dato['nombre'];?></td>
                                                                        <td><?php echo $productos_dato['descripcion'];?></td>
                                                                        <td><?php echo $productos_dato['stock'];?></td>
                                                                        <td><?php echo $productos_dato['precio_compra'];?></td>
                                                                        <td><?php echo $productos_dato['precio_venta'];?></td>
                                                                        <td><?php echo $productos_dato['fecha_ingreso'];?></td>
                                                                        <td><?php echo $productos_dato['email'];?></td>
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

                                    <hr>
                                    <div class="row" style="font-size: 12px">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" id="id_producto" hidden>
                                                        <label for="">Código:</label>
                                                        <input type="text" class="form-control" id="codigo" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Categoría:</label>
                                                        <div style="display: flex">
                                                            <input type="text" class="form-control" id="categoria" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Nombre del producto:</label>
                                                        <input type="text" name="nombre" id="nombre_producto" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Usuario</label>
                                                        <input type="text" class="form-control" id="usuario_producto" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="">Descripción del producto:</label>
                                                        <textarea name="descripcion" id="descripcio_producto" cols="30" rows="2" class="form-control" disabled></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock:</label>
                                                        <input type="number" name="stock" id="stock" class="form-control" style="background-color: #fff819" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock mínimo:</label>
                                                        <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Stock máximo:</label>
                                                        <input type="number" name="stock_maximo" id="stock_maximo" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Precio compra:</label>
                                                        <input type="number" name="precio_compra" id="precio_compra" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Precio venta:</label>
                                                        <input type="number" name="precio_venta" id="precio_venta" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Fecha de ingreso:</label>
                                                        <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Imagen del producto</label>
                                                <center>
                                                    <img src="<?php echo $URL."/almacen/img_productos/".$imagen;?>" id="img_producto" width="50%" alt="">
                                                </center>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div style="display: flex">
                                        <h5>Datos del cliente </h5>
                                        <div style="width: 20px"></div>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#modal-buscar_cliente">
                                            <i class="fa fa-search"></i>
                                            Buscar cliente
                                        </button>
                                        <div class="modal fade" id="modal-buscar_cliente">
                                           <div class="modal-dialog modal-lg">
                                               <div class="modal-content">
                                                   <div class="modal-header" style="background-color: #1d36b6;color: white">
                                                       <h4 class="modal-title">Busqueda de cliente</h4>
                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                           <span aria-hidden="true">&times;</span>
                                                       </button>
                                                   </div>
                                                   <div class="modal-body">
                                                       <div class="table table-responsive">
                                                           <table id="example2" class="table table-bordered table-striped table-sm">
                                                               <thead>
                                                               <tr>
                                                                   <th><center>Nro</center></th>
                                                                   <th><center>Selecionar</center></th>
                                                                   <th><center>Nombre del cliente</center></th>
                                                                   <th><center>Teléfono</center></th>
                                                                   <th><center>Foto</center></th>
                                                                   <th><center>Email</center></th>
                                                               </tr>
                                                               </thead>
                                                               <tbody>
                                                               <?php
                                                               $contador = 0;
                                                               foreach ($clients_datos as $clients_dato){
                                                                   $id_clients = $clients_dato['id_clients'];
                                                                   $nombre_clt = $clients_dato['nombre_clt']; ?>
                                                                   <tr>
                                                                       <td><center><?php echo $contador = $contador + 1;?></center></td>
                                                                       <td>
                                                                           <button class="btn btn-info btn_selecionar_cliente">Seleccionar</button>
                                                                           <script>
                                                                               $('#btn_selecionar_cliente<?php echo $id_clients;?>').click(function () {

                                                                                   var id_clients = '<?php echo $id_clients; ?>';
                                                                                   $('#id_clients').val(id_clients);

                                                                                   var nombre_clt = '<?php echo $nombre_clt; ?>';
                                                                                   $('#nombre_clt').val(nombre_clt);

                                                                                   var telefono_clt = '<?php echo $clients_dato['telefono_clt']; ?>';
                                                                                   $('#telefono').val(telefono_clt);

                                                                                   var image_clt = '<?php echo $clients_dato['image_clt']; ?>';
                                                                                   $('#foto').val(foto);

                                                                                   var mail_clt = '<?php echo $clients_dato['mail_clt']; ?>';
                                                                                   $('#email').val(mail_clt);

                                                                                   var fecha_ini_tramite = '<?php echo $clients_dato['fecha_ini_tramite']; ?>';
                                                                                   $('#fecha_ini_tramite').val(fecha_ini_tramite);

                                                                                   var fecha_fin_tramite = '<?php echo $clients_dato['fecha_fin_tramite']; ?>';
                                                                                   $('#fecha_fin_tramite').val(fecha_fin_tramite);

                                                                                   $('#modal-buscar_cliente').modal('toggle');

                                                                               });
                                                                           </script>
                                                                       </td>
                                                                       <td><?php echo $nombre_clt;?></td>
                                                                       <td><?php echo $clients_dato['telefono_clt'];?></td>
                                                                       <td>
                                                                            <img src="<?php echo $URL."/clientes/image_clt/".$clients_dato['image_clt'];?>" width="50px" alt="asdf">
                                                                        </td>
                                                                       <td><?php echo $clients_dato['mail_clt'];?></td>
                                                                   </tr>
                                                                   <?php
                                                               }
                                                               ?>
                                                               </tbody>
                                                           </table>
                                                       </div>
                                                   </div>
                                               </div>
                                               <!-- /.modal-content -->
                                           </div>
                                           <!-- /.modal-dialog -->
                                       </div>
                                       <!-- /.modal -->

                                    <hr>

                                    <div class="container-fluid" style="font-size: 12px">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" id="id_clients" hidden>
                                                    <label for="">Nombre </label>
                                                    <input type="text" id="nombre_clt" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Telefono</label>
                                                    <input type="telefono_clt" id="telefono_clt" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="email" id="mail_clt" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Detalle de la venta</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Número de la venta</label>
                                                        <input type="text" value="<?php echo $contador_de_ventas; ?>" style="text-align: center" class="form-control" disabled>
                                                        <input type="text" value="<?php echo $contador_de_ventas; ?>" id="nro_venta" hidden>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Fecha de la venta</label>
                                                        <input type="date" class="form-control" id="fecha_venta">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Comprobante de la venta</label>
                                                        <input type="text" class="form-control" id="comprobante">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Precio de la venta</label>
                                                        <input type="text" class="form-control" id="precio_venta_controlador">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Stock actual</label>
                                                        <input type="text" style="background-color: #fff819;text-align: center" id="stock_actual" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Stock Restante</label>
                                                        <input type="text" style="text-align: center" id="stock_restante" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Cantidad de la venta</label>
                                                        <input type="number" id="cantidad_venta" style="text-align: center" class="form-control">
                                                    </div>
                                                    <script>
                                               $('#cantidad_venta').keyup(function () {
                                                   //alert('estamos presionando el input');
                                                   var stock_actual = $('#stock_actual').val();
                                                   var stock_venta = $('#cantidad_venta').val();

                                                   var total = parseInt(stock_actual)- parseInt(stock_venta);
                                                   $('#stock_restante').val(total);

                                               });
                                           </script>
                                       </div>


                                       <div class="col-md-12">
                                           <div class="form-group">
                                               <label for="">Usuario</label>
                                               <input type="text" class="form-control" value="<?php echo $email_sesion; ?>" disabled>
                                           </div>
                                       </div>
                                   </div>
                                   <hr>

                                   <div class="col-md-12">
                                       <div class="form-group">
                                           <button class="btn btn-primary btn-block" id="btn_guardar_venta">Guardar venta</button>
                                       </div>
                                   </div>
                                   <script>
                                       $('#btn_guardar_venta').click(function () {

                                           var id_producto = $('#id_producto').val();
                                           var nro_venta = $('#nro_venta').val();
                                           var fecha_venta = $('#fecha_venta').val();  // Use fecha_venta (the sale date)
                                           var id_clients = $('#id_clients').val();
                                           var comprobante = $('#comprobante').val();
                                           var id_usuario = "<?php echo $id_usuario_sesion; ?>"; // Use PHP to get the user ID
                                           var precio_venta_controlador = $('#precio_venta_controlador').val();
                                           var cantidad = $('#cantidad_venta').val();

                                           



                                            $.get("../app/controllers/ventas/create.php", {  // Correct path for ventas/create.php
                                                id_producto: id_producto,
                                                nro_venta: nro_venta,
                                                fecha_venta: fecha_venta, // Sending the correct sale date
                                                id_clients: id_clients,
                                                comprobante: comprobante,
                                                id_usuario: id_usuario,     // Now properly getting the user ID from the PHP session
                                                precio_venta_controlador: precio_venta_controlador,
                                                cantidad_venta: cantidad
                                            }, function (response) {
                                                $("#respuesta_create").html(response);
                                            });


                                            

                                       });
                                   </script>
                               </div>

                           </div>

                       </div>

                       <div id="respuesta_create"></div>

                   </div>


               </div>
           </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include ('../layout/mensajes.php'); ?>
<?php include ('../layout/parte2.php'); ?>



<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Productos",
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

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });


    $(function () {
        $("#example2").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
                "infoEmpty": "Mostrando 0 a 0 de 0 Proveedores",
                "infoFiltered": "(Filtrado de _MAX_ total Proveedores)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Proveedores",
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

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    
</script>

// JavaScript for Product Selection (place inside #modal-buscar_producto .modal-body, AFTER the </tbody> tag)
<script>
  $(document).ready(function() {
    $('#example1 tbody').on('click', '.btn_selecionar_producto', function() { // Fixed typo: btn_selecionar_producto
      var row = $(this).closest('tr');

      var id_producto = row.find('td:eq(0)').text();
      $('#id_producto').val(id_producto);

      var codigo = row.find('td:eq(2)').text();
      $('#codigo').val(codigo);

      var categoria = row.find('td:eq(3)').text();
      $('#categoria').val(categoria);

      var nombre = row.find('td:eq(5)').text();
      $('#nombre_producto').val(nombre);

      var usuario_producto = row.find('td:eq(11)').text(); // usuario
      $('#usuario_producto').val(usuario_producto);


      var descripcion = row.find('td:eq(6)').text();
      $('#descripcio_producto').val(descripcion);

      var stock = row.find('td:eq(7)').text();
      $('#stock').val(stock);
      $('#stock_actual').val(stock);

      var stock_minimo = row.find('td:eq(8)').text(); // Stock minimo is not in the table. Assuming it exists in the 8th column
      $('#stock_minimo').val(stock_minimo); // Assuming precio compra

      var stock_maximo = row.find('td:eq(9)').text(); //Stock maximo is not in the table. Assuming precio venta
      $('#stock_maximo').val(stock_maximo); // Assuming precio venta


      var precio_compra = row.find('td:eq(8)').text(); // precio compra
      $('#precio_compra').val(precio_compra);

      var precio_venta = row.find('td:eq(9)').text(); // precio venta
      $('#precio_venta').val(precio_venta);


      var fecha_ingreso = row.find('td:eq(10)').text();
      $('#fecha_ingreso').val(fecha_ingreso);

      var ruta_img = row.find('td:eq(4) img').attr('src'); // Get image src directly
      $('#img_producto').attr('src', ruta_img);


      $('#modal-buscar_producto').modal('toggle');
    });
  });
</script>




// JavaScript for Client Selection (place inside #modal-buscar_cliente .modal-body, AFTER the </tbody> tag)
<script>
    $(document).ready(function() {
        $('#example2 tbody').on('click', '.btn_selecionar_cliente', function() {  // Fixed typo: btn_selecionar_cliente
            var row = $(this).closest('tr');

            var id_clients = row.find('td:eq(0)').text(); // Get id_clients (make sure the index is correct!)
            $('#id_clients').val(id_clients);

            var nombre_clt = row.find('td:eq(2)').text();
            $('#nombre_clt').val(nombre_clt);

            var telefono_clt = row.find('td:eq(3)').text();
            $('#telefono_clt').val(telefono_clt); // Fixed ID: telefono_clt

            var image_clt = row.find('td:eq(4) img').attr('src'); // Get src from img tag
           //No input for image. Creating a hidden one. Uncomment when you add the input.
            //$('#image_clt').val(image_clt);



            var mail_clt = row.find('td:eq(5)').text();
            $('#mail_clt').val(mail_clt);  // Fixed ID: mail_clt



            $('#modal-buscar_cliente').modal('toggle');
        });
    });
</script>

// Add this script within the <head> or at the end of the <body> of your create.php file, after jQuery is loaded.

<script>
$(document).ready(function() {
    const cantidadVentaInput = $("#cantidad_venta");
    const precioVentaInput = $("#precio_venta");     // <--- This is the correct input for the product's sale price
    const precioTotalVentaInput = $("#precio_venta_controlador")

  // Function to calculate and update the total price
  function calcularPrecioTotal() {
        const cantidad = parseFloat(cantidadVentaInput.val()) || 0;
        const precioVenta = parseFloat(precioVentaInput.val()) || 0; // <-- Use precio_venta here
        const precioTotal = cantidad * precioVenta;

        precioTotalVentaInput.val(precioTotal.toFixed(2));
    }


    cantidadVentaInput.on("keyup change", calcularPrecioTotal);
    precioVentaInput.on("keyup change", calcularPrecioTotal);



 // ---Stock Restante---
// Listen for input changes on the cantidad_venta field
  $("#cantidad_venta").on("input", function() {
    var stockActual = parseInt($("#stock_actual").val());
    var cantidadVenta = parseInt($(this).val());

    // Check for NaN values
    if (isNaN(stockActual)) {
        stockActual = 0;
    }

    if (isNaN(cantidadVenta)) {
        cantidadVenta = 0;
    }


    var stockRestante = stockActual - cantidadVenta;

    // Update the stock_restante field
    $("#stock_restante").val(stockRestante);

    // Check for total less than stock and display alerts if necessary
    if (cantidadVenta > stockActual) {
      // Clear previous alerts (if any)
      $(".alert").remove();

      // Add an alert before the #btn_guardar_venta button if total is less than stock
      $('<div class="alert alert-danger alert-dismissible">' +
          '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
          '<h5><i class="icon fas fa-ban"></i> Alerta!</h5>' +
          'La cantidad a vender no puede ser mayor al Stock actual.' +
          '</div>').insertBefore("#btn_guardar_venta");


    }else if(stockRestante <= parseInt($("#stock_minimo").val())){
               // Clear previous alerts (if any)
               $(".alert").remove();

               // Add an alert before the #btn_guardar_venta button if total is less than stock
               $('<div class="alert alert-warning alert-dismissible">' +
                   '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                   '<h5><i class="icon fas fa-ban"></i> Alerta!</h5>' +
                   'Stock llegará al mínimo!' +
                   '</div>').insertBefore("#btn_guardar_venta");



    }
    else{
      $(".alert").remove(); // Clear the alert if the condition is no longer met
    }



  });


});

                                        