<?php
    session_start();
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id']; // Consider changing to id_usuario
    $sql = "SELECT * FROM tb_usuarios WHERE NOT id_usuario = {$outgoing_id} ORDER BY id_usuario DESC"; // Changed table and column names.
    $query = mysqli_query($conn, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No users are available to chat";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>
