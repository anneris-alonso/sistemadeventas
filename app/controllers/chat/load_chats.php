<?php
// app/controllers/chat/load_chats.php
session_start();
include_once "../../../php/config.php";

header('Content-Type: application/json');

$userId = $_SESSION['id_usuario'];

$query = "SELECT c.id_chat, u.nombres as nombre_usuario
          FROM tb_chats c
          JOIN tb_usuarios u ON (c.user_id_1 = u.id_usuario OR c.user_id_2 = u.id_usuario)
          WHERE (c.user_id_1 = ? OR c.user_id_2 = ?) AND u.id_usuario != ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "iii", $userId, $userId, $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$chats = [];
while ($row = mysqli_fetch_assoc($result)) {
  $chats[] = $row;
}

echo json_encode($chats);
?>
