<?php
// app/controllers/banco/set_balance.php
include('../../config.php');

session_start();

// Validate negocio_id
if (!isset($_SESSION['negocio_id']) || !is_numeric($_SESSION['negocio_id'])) {
    die("Error: ID de negocio no válido.");
}

$id_negocios = $_SESSION["negocio_id"];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the new balance from the form
    $nuevo_saldo = $_POST['nuevo_saldo'];
    $descripcion = "Se establecio el saldo";

    if ($nuevo_saldo == "") {
        session_start();
        $_SESSION['mensaje'] = "Error al establecer el saldo, debe completar todos los datos";
        $_SESSION['icono'] = "error";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/banco"; 
        </script>
        <?php
        die();
    }

    $fechaHora = date("Y-m-d H:i:s");

    $pdo->beginTransaction();
    try{
        $sentencia = $pdo->prepare("INSERT INTO tb_banco (id_negocios, tipo, descripcion, monto, fecha_hora, saldo_actual) VALUES (:id_negocios, 'balance', :descripcion, :monto, :fecha_hora, :saldo_actual)");
        $sentencia->bindParam(':id_negocios', $id_negocios);
        $sentencia->bindParam(':descripcion', $descripcion);
        $sentencia->bindParam(':monto', $nuevo_saldo);
        $sentencia->bindParam(':fecha_hora', $fechaHora);
        $sentencia->bindParam(':saldo_actual', $nuevo_saldo);

        $sentencia->execute();
        $pdo->commit();

        session_start();
        $_SESSION['mensaje'] = "Se estableció el balance de manera correcta";
        $_SESSION['icono'] = "success";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/banco"; 
        </script>
        <?php
    } catch(PDOException $e){
        $pdo->rollBack();
        session_start();
        $_SESSION['mensaje'] = "Error al establecer el balance";
        $_SESSION['icono'] = "error";
        ?>
        <script>
            location.href = "<?php echo $URL; ?>/banco"; 
        </script>
        <?php
    }
}
?>
