<?php
include('../../config.php');

// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get negocio_id from session
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    $_SESSION['mensaje'] = "Error: ID de negocio inválido.";
    $_SESSION['icono'] = "error";
    ?>
    <script>
        location.href = "<?php echo $URL; ?>/cuentas_por_cobrar";
    </script>
    <?php
    die(); // Stop execution
}
$id_negocios = $_SESSION['negocio_id'];

// Check if data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_clients = $_POST['id_clients'];
    $tipo_venta = $_POST['tipo_venta'];
    $condicion_especial = $_POST['condicion_especial'];
    $descripcion = $_POST['descripcion'];
    $total_a_pagar = $_POST['total_a_pagar'];

    if($tipo_venta == 'servicio'){
      $id_servicios = $_POST['id_servicios'];
      $id_producto = null;
    } else {
      $id_producto = $_POST['id_producto']; 
      $id_servicios = null;
    }

    if ($id_clients == "" || $total_a_pagar == "" || $descripcion == "" || $tipo_venta == "") {
        $_SESSION['mensaje'] = "Error: Todos los campos son obligatorios.";
        $_SESSION['icono'] = "error";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/cuentas_por_cobrar/create.php";
        </script>
        <?php
        die();
    }

    $pdo->beginTransaction();
    try {
        // Insert into tb_cuentas_por_cobrar
        $sql_insert_cuenta = "INSERT INTO tb_cuentas_por_cobrar (id_negocios, id_clients, id_servicios, id_producto, condicion_especial, descripcion, total_a_pagar, saldo_pendiente, estado, fyh_creacion, tipo_venta)
                             VALUES (:id_negocios, :id_clients, :id_servicios, :id_producto, :condicion_especial, :descripcion, :total_a_pagar, :total_a_pagar, 'pendiente', :fyh_creacion, :tipo_venta)"; 
        $query_insert_cuenta = $pdo->prepare($sql_insert_cuenta);
        $query_insert_cuenta->bindParam(':id_negocios', $id_negocios);
        $query_insert_cuenta->bindParam(':id_clients', $id_clients);
        $query_insert_cuenta->bindParam(':id_servicios', $id_servicios);
        $query_insert_cuenta->bindParam(':id_producto', $id_producto); 
        $query_insert_cuenta->bindParam(':condicion_especial', $condicion_especial);
        $query_insert_cuenta->bindParam(':descripcion', $descripcion);
        $query_insert_cuenta->bindParam(':total_a_pagar', $total_a_pagar);
        $query_insert_cuenta->bindValue(':fyh_creacion', date("Y-m-d H:i:s"));
        $query_insert_cuenta->bindParam(':tipo_venta', $tipo_venta);

        $query_insert_cuenta->execute();

        $pdo->commit();

        $_SESSION['mensaje'] = "Se creó la cuenta por cobrar correctamente.";
        $_SESSION['icono'] = "success";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/cuentas_por_cobrar";
        </script>
        <?php
    } catch (PDOException $e) {
        $pdo->rollBack();

        error_log("Error al crear la cuenta por cobrar: " . $e->getMessage());
        $_SESSION['mensaje'] = "Error: Ocurrió un error al crear la cuenta.";
        $_SESSION['icono'] = "error";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/cuentas_por_cobrar/create.php";
        </script>
        <?php
    }
}
?>
