<?php
include('../app/config.php'); // Include your database connection

// Receive filter parameters (if any)
$estado = isset($_POST['estado']) ? $_POST['estado'] : 'todos'; // Default to 'todos' if no filter is selected


// Build SQL query with optional filtering
$sql = "SELECT * FROM tb_clients WHERE id_negocios = :id_negocios"; // Base query
if ($estado !== 'todos') {
    $sql .= " AND status_clt = :estado";
}
$sql .= " ORDER BY id_clients DESC";

$query = $pdo->prepare($sql);
$query->bindValue(':id_negocios', $_SESSION['negocio_id'], PDO::PARAM_INT);

if ($estado !== 'todos') {
    $query->bindValue(':estado', $estado, PDO::PARAM_INT);
}

$query->execute();
$clientes = $query->fetchAll(PDO::FETCH_ASSOC);



// Generate HTML for the filtered table rows
$tablaHTML = ""; // Initialize an empty string

foreach ($clientes as $cliente) {
    $tablaHTML .= "<tr>"; //Start building the row
    $tablaHTML .= "<td>" . $cliente['id_clients'] . "</td>";
    // ... Add other table cells with client data ...
    $tablaHTML .= "<td>" . ($cliente['status_clt'] == 1 ? 'Activo' : 'Inactivo') . "</td>";

    $tablaHTML .= "<td>";
        $tablaHTML .= "<select class='cambiar-estado' data-cliente-id='" . $cliente['id_clients'] . "'>";
        $tablaHTML .= "<option value='1' " . ($cliente['status_clt'] == 1 ? 'selected' : '') . ">Activo</option>";
        $tablaHTML .= "<option value='0' " . ($cliente['status_clt'] == 0 ? 'selected' : '') . ">Inactivo</option>";
        $tablaHTML .= "</select>";
        $tablaHTML .= "<button type='button' class='btn btn-primary btn-sm actualizar-estado' data-cliente-id='" . $cliente['id_clients'] . "' style='display:none;'>Actualizar</button>";
    $tablaHTML .= "</td>";


    $tablaHTML .= "</tr>";
}



echo $tablaHTML; // Output the generated HTML

?>
