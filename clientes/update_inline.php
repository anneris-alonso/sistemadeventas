<?php // clientes/update_inline.php
include('../../config.php');

session_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$id_negocios = $_SESSION['negocio_id'];


try {

    if (isset($_POST['id_clients']) && isset($_POST['updatedData']) && isset($_POST['id_negocios'])) { //Check business ID


        $id_clients = $_POST['id_clients'];
        $updatedData = $_POST['updatedData'];



        // Add business ID check to prevent unauthorized updates
        if ($_POST['id_negocios'] !== $id_negocios) {
            throw new Exception("Unauthorized access.");
        }




        $updateFields = [];
        foreach ($updatedData as $column => $value) {
            $updateFields[] = "$column = :$column";
        }
        $updateString = implode(', ', $updateFields);


        $stmt = $pdo->prepare("UPDATE tb_clients SET $updateString WHERE id_clients = :id_clients AND id_negocios = :id_negocios");



        $params = $updatedData;
        $params['id_clients'] = $id_clients;
        $params['id_negocios'] = $id_negocios;


        $stmt->execute($params);

        echo "Cliente actualizado correctamente.";

    } else {

        echo "Error: Invalid data received.";
    }
} catch (PDOException $e) {

    echo "Error al actualizar el cliente: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error al actualizar el cliente: " . $e->getMessage();

}

?>

