<?php
// php/chat/send_message.php
ob_start(); // Add this line
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include_once "../../config.php"; // Correct path

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $incoming_id = $_POST['incoming_id'];
    $outgoing_id = $_SESSION['id_usuario'];

    $chatQuery = "SELECT id_chat FROM tb_chats WHERE (user_id_1 = ? AND user_id_2 = ?) OR (user_id_1 = ? AND user_id_2 = ?)";
    $stmt = mysqli_prepare($conn, $chatQuery);
    mysqli_stmt_bind_param($stmt, "iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
    mysqli_stmt_execute($stmt);
    $chatResult = mysqli_stmt_get_result($stmt);
    $chatRow = mysqli_fetch_assoc($chatResult);

    if ($chatRow) {
        $chatId = $chatRow['id_chat'];
    } else {
        $insertChatQuery = "INSERT INTO tb_chats (user_id_1, user_id_2) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $insertChatQuery);
        mysqli_stmt_bind_param($stmt, "ii", $outgoing_id, $incoming_id);
        mysqli_stmt_execute($stmt);
        $chatId = mysqli_insert_id($conn);
    }

    $insertMessageQuery = "INSERT INTO tb_messages (chat_id, sender_id, message) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertMessageQuery);
    mysqli_stmt_bind_param($stmt, "iis", $chatId, $outgoing_id, $message);
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => "Message sent"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error sending message"]);
    }
}
?>
