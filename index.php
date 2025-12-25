<?php
include ('app/config.php');
include ('layout/sesion.php');

include ('layout/parte1.php');
include ('app/controllers/usuarios/listado_de_usuarios.php');//
include ('app/controllers/roles/listado_de_roles.php');//
include ('app/controllers/categorias/listado_de_categoria.php');//
include ('app/controllers/almacen/listado_de_productos.php');//
include ('app/controllers/proveedores/listado_de_proveedores.php');//
include ('app/controllers/clientes/client_list.php');//
include ('app/controllers/servicios/listado_de_servicios.php');//

// Obtener el ID del negocio del usuario (desde la sesión)
$id_negocios = $_SESSION["negocio_id"]; 


// Consulta para obtener el precio de venta y compra de cada producto
$sql_productos = "SELECT precio_venta, precio_compra 
                   FROM tb_almacen 
                   WHERE id_negocios = :id_negocios"; 


$query_productos = $pdo->prepare($sql_productos);
$query_productos->bindParam(':id_negocios', $id_negocios); 
$query_productos->execute();
$productos = $query_productos->fetchAll(PDO::FETCH_ASSOC);

$ganancias_productos = [];
$ganancia_general = 0;

foreach ($productos as $producto) {
  $ganancia = $producto['precio_venta'] - $producto['precio_compra'];
  $ganancias_productos[] = $ganancia;
  $ganancia_general += $ganancia;
}

// Pasar las ganancias a JavaScript (usando json_encode)
$ganancias_json = json_encode($ganancias_productos);
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
      </div>
    </div>
  </div>

  <div class="content">
      <div class="content-header"> 
        <div class="container-fluid"> 
          <div class="row mb-2"> 
            <div class="col-sm-6"> 
              <h1 class="m-0">Panel administrativo</h1> 
            </div> 
          </div> 
        </div> 
      </div>

      <div class="content"> 
        <div class="container-fluid">
          <div class="row">

            <div class="col-lg-6 col-12"> 
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Ganancias</h3>
                </div>
                <div class="card-body">
                  <canvas id="graficaGanancias"></canvas> 
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <?php
                  $contador_de_usuarios = 0;
                  foreach ($usuarios_datos as $usuarios_dato){
                    $contador_de_usuarios++;
                  }
                  ?>
                  <h3><?php echo $contador_de_usuarios;?></h3>
                  <p>Empleados Registrados</p>
                </div>
                <a href="<?php echo $URL;?>/usuarios/create.php">
                  <div class="icon">
                    <i class="fas fa-user-plus"></i>
                  </div>
                </a>
                <a href="<?php echo $URL;?>/usuarios" class="small-box-footer">
                  Más detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <div class="small-box bg-primary">
                <div class="inner">
                  <?php
                  $contador_de_productos = 0;
                  foreach ($productos_datos as $productos_dato){
                    $contador_de_productos++;
                  }
                  ?>
                  <h3><?php echo $contador_de_productos;?></h3>
                  <p>Productos Registrados</p>
                </div>
                <a href="<?php echo $URL;?>/almacen/create.php">
                  <div class="icon">
                    <i class="fas fa-list"></i>
                  </div>
                </a>
                <a href="<?php echo $URL;?>/almacen" class="small-box-footer">
                  Más detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <div class="small-box bg-dark">
                <div class="inner">
                  <?php
                  $contador_de_proveedores = 0;
                  foreach ($proveedores_datos as $proveedores_dato){
                    $contador_de_proveedores++;
                  }
                  ?>
                  <h3><?php echo $contador_de_proveedores;?></h3>
                  <p>Proveedores Registrados</p>
                </div>
                <a href="<?php echo $URL;?>/proveedores">
                  <div class="icon">
                    <i class="fas fa-car"></i>
                  </div>
                </a>
                <a href="<?php echo $URL;?>/proveedores" class="small-box-footer">
                  Más detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <div class="small-box bg-warning">
                <div class="inner">
                  <?php
                  $contador_de_clientes = 0;
                  foreach ($clients_datos as $clients_dato){
                    $contador_de_clientes++;
                  }
                  ?>
                  <h3><?php echo $contador_de_clientes;?></h3>
                  <p>Clientes Registrados</p>
                </div>
                <a href="<?php echo $URL;?>/clientes/create.php">
                  <div class="icon">
                    <i class="fas fa-user"></i>
                  </div>
                </a>
                <a href="<?php echo $URL;?>/clientes" class="small-box-footer">
                  Más detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $contador_de_roles = 0;
                  foreach ($roles_datos as $roles_dato){
                    $contador_de_roles++;
                  }
                  ?>
                  <h3><?php echo $contador_de_roles;?></h3>
                  <p>Roles Registrados</p>
                </div>
                <a href="<?php echo $URL;?>/roles/create.php">
                  <div class="icon">
                    <i class="fas fa-address-card"></i>
                  </div>
                </a>
                <a href="<?php echo $URL;?>/roles" class="small-box-footer">
                  Más detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <div class="small-box bg-success">
                <div class="inner">
                  <?php
                  $contador_de_categorias = 0;
                  foreach ($categorias_datos as $categorias_dato){
                    $contador_de_categorias++;
                  }
                  ?>
                  <h3><?php echo $contador_de_categorias;?></h3>
                  <p>Categorías Registrados</p>
                </div>
                <a href="<?php echo $URL;?>/categorias">
                  <div class="icon">
                    <i class="fas fa-tags"></i>
                  </div>
                </a>
                <a href="<?php echo $URL;?>/categorias" class="small-box-footer">
                  Más detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
              <div class="small-box bg-primary">
                <div class="inner">
                  <?php
                  $contador_de_productos = 0;
                  foreach ($productos_datos as $productos_dato){
                    $contador_de_productos++;
                  }
                  ?>
                  <h3><?php echo $contador_de_productos;?></h3>
                  <p>Servicios Pendientes</p>
                </div>
                <a href="<?php echo $URL;?>/servicios.php">
                  <div class="icon">
                    <i class="fas fa-book"></i>
                  </div>
                </a>
                <a href="<?php echo $URL;?>/almacen" class="small-box-footer">
                  Más detalle <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          </div> 
        </div>
      </div>

    </div>
  </div>
</div>

<?php include ('layout/parte2.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

<script>
  // Obtener los datos de ganancias desde PHP
  var gananciasProductos = JSON.parse('<?php echo $ganancias_json; ?>');

  // Crear la gráfica radial
  var ctx = document.getElementById('graficaGanancias').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'doughnut', // O 'pie' si prefieres una gráfica de pastel
    data: {
      labels: [
        <?php 
        // Generar las etiquetas de los productos dinámicamente
        $labels = [];
        foreach ($productos_datos as $producto) {
          $labels[] = "'" . $producto['nombre'] . "'";
        }
        echo implode(', ', $labels); 
        ?>
      ],
      datasets: [{
        label: 'Ganancias',
        data: gananciasProductos, 
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          // ... más colores si es necesario
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          // ... más colores si es necesario
        ],
        borderWidth: 1
      }]
    },
    options: {
      // ... opciones de visualización (título, leyendas, etc.)
    }
  });
</script>