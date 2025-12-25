<?php
// php/chat/load_messages.php
ob_start(); // Add this line
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include_once "../../config.php"; // Correct path

header('Content-Type: application/json');

$chatId = $_GET['id'];

$query = "SELECT m.message , u.id_usuario as sender_id FROM tb_messages m JOIN tb_usuarios u on m.sender_id = u.id_usuario WHERE chat_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $chatId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $role = $row['sender_id'] == $_SESSION['id_usuario'] ? 'user' : 'bot';
    $messages[] = [
      "role" => $role,
      "parts" =>[
        ["text" => $row['message']]
      ]
    ];
}

echo json_encode($messages);
?>
