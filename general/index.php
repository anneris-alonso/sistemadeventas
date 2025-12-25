<?php
include('../app/config.php');
include('../layout/sesion.php');
include('../layout/parte1.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Function to calculate earnings based on fully paid accounts receivable (Services).
function calcularGananciasServicios($pdo, $id_negocios) {
    try {
        $sql = "SELECT SUM(total_a_pagar) AS total_ganancias_servicios
                FROM tb_cuentas_por_cobrar
                WHERE id_negocios = :id_negocios AND estado = 'pagado' and tipo_venta='servicio'";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT);
        $query->execute();
        $ganancias_cobrar = $query->fetch(PDO::FETCH_ASSOC)['total_ganancias_servicios'];
        return $ganancias_cobrar !== null ? (float)$ganancias_cobrar : 0;
    } catch (PDOException $e) {
        error_log("Error al calcular ganancias de cuentas por cobrar: " . $e->getMessage());
        return 0;
    }
}

// Function to calculate earnings based on fully paid accounts receivable (Products).
function calcularGananciasProductos($pdo, $id_negocios) {
    try {
        $sql = "SELECT SUM(total_a_pagar) AS total_ganancias_productos
                FROM tb_cuentas_por_cobrar
                WHERE id_negocios = :id_negocios AND estado = 'pagado' and tipo_venta='producto'";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT);
        $query->execute();
        $ganancias_productos = $query->fetch(PDO::FETCH_ASSOC)['total_ganancias_productos'];
        return $ganancias_productos !== null ? (float)$ganancias_productos : 0;
    } catch (PDOException $e) {
        error_log("Error al calcular ganancias de cuentas por cobrar: " . $e->getMessage());
        return 0;
    }
}
// Function to calculate total earnings from both tables.
function calcularGananciasTotales($pdo, $id_negocios) {
    try {
        $sql = "SELECT SUM(total_a_pagar) AS ganancias_totales
                FROM tb_cuentas_por_cobrar
                WHERE id_negocios = :id_negocios and estado='pagado'";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT);
        $query->execute();

        $ganancias_totales = 0;
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $row) {
            $ganancias_totales += (float)$row['ganancias_totales'];
        }
        return $ganancias_totales !== null ? (float)$ganancias_totales : 0;

    } catch (PDOException $e) {
        error_log("Error al obtener ganancias totales: " . $e->getMessage());
        return 0;
    }
}

// Function to calculate total accounts payable
function calcularCuentasPorPagar($pdo, $id_negocios) {
    try {
        $sql = "SELECT SUM(saldo_pendiente) AS total_a_pagar
                FROM tb_cuentas_por_pagar
                WHERE id_negocios = :id_negocios AND estado != 'pagado'";
        $query = $pdo->prepare($sql);
        $query->bindValue(':id_negocios', $id_negocios, PDO::PARAM_INT);
        $query->execute();
        $cuentas_por_pagar = $query->fetch(PDO::FETCH_ASSOC)['total_a_pagar'];
        return $cuentas_por_pagar !== null ? (float)$cuentas_por_pagar : 0;
    } catch (PDOException $e) {
        error_log("Error al calcular cuentas por pagar: " . $e->getMessage());
        return 0;
    }
}

// Obtener el ID del negocio
$id_negocios = $_SESSION['negocio_id'];

// Calculate total earnings from accounts receivable.
$ganancias_servicios = calcularGananciasServicios($pdo, $id_negocios);
$ganancias_productos = calcularGananciasProductos($pdo, $id_negocios);
$total_ganancias = calcularGananciasTotales($pdo, $id_negocios);
$total_a_pagar = calcularCuentasPorPagar($pdo, $id_negocios);

// Data for the chart (now only one type of earning)
$data_for_chart = [
    ['Tipo', 'Ganancias'],
    ['Total', (float)$total_ganancias],
];

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Resumen de Ganancias del Negocio</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Ganancias de Servicios</h3>
                        </div>
                        <div class="card-body">
                            <h1><?php echo number_format($ganancias_servicios, 2); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Ganancias de Productos</h3>
                        </div>
                        <div class="card-body">
                            <h1><?php echo number_format($ganancias_productos, 2); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Ganancias Totales</h3>
                        </div>
                        <div class="card-body">
                            <h1><?php echo number_format($total_ganancias, 2); ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Total a Pagar (Cuentas por Pagar)</h3>
                        </div>
                        <div class="card-body">
                            <h1><?php echo number_format($total_a_pagar, 2); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Gráfica de Ganancias Totales</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chart_ganancias" style="width: 100%; height: 400px;"></div>
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

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://www.google.com/jsapi"></script>
<script>
    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(
            <?php echo json_encode($data_for_chart); ?>
        );

        var options = {
            title: 'Ganancias Totales',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_ganancias'));
        chart.draw(data, options);
    }
</script>
