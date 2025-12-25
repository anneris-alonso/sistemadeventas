<?php
include ('app/config.php'); 

if (isset($_POST['estado'])) {
  $estado = $_POST['estado'];

  // Consulta a la base de datos para filtrar clientes
  if ($estado == 'todos') {
    $sql = "SELECT * FROM tb_clients"; // Mostrar todos los clientes
  } else {
    $sql = "SELECT * FROM tb_clients WHERE status_clt = :estado"; 
  }

  $query = $pdo->prepare($sql);
  if ($estado != 'todos') {
    $query->bindParam(':estado', $estado);
  }
  $query->execute();
  $clientes = $query->fetchAll(PDO::FETCH_ASSOC);

  // Generar el código HTML de la tabla con los clientes filtrados
  $contador = 0;
  $html = ""; 
  foreach ($clientes as $cliente) {
    $contador++;
    $html .= "<tr>";
    $html .= "<td>" . $contador . "</td>";
    $html .= "<td>" . $cliente['nombre_clt'] . "</td>";
    $html .= "<td>" . $cliente['telefono_clt'] . "</td>";
    $html .= "<td>" . $cliente['mail_clt'] . "</td>";
    $html .= "<td>" . $cliente['status_clt'] . "</td>";
    $html .= "<td>";
    $html .= "<div class='btn-group'>";
    $html .= "<a href='" . $URL . "/clientes/update.php?id=" . $cliente['id_clients'] . "' class='btn btn-warning'><i class='fa fa-edit'></i> Editar</a>";
    $html .= "<a href='" . $URL . "/clientes/delete.php?id=" . $cliente['id_clients'] . "' class='btn btn-danger'><i class='fa fa-trash'></i> Borrar</a>";
    $html .= "</div>";
    $html .= "</td>";
    $html .= "</tr>";
  }

  echo $html; 
}
?>