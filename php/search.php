<?php
    session_start();
    include_once "config.php";

    $outgoing_id = $_SESSION['unique_id']; // Consider changing to id_usuario
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    $sql = "SELECT * FROM tb_usuarios WHERE NOT id_usuario = {$outgoing_id} AND (nombres LIKE '%{$searchTerm}%' OR email LIKE '%{$searchTerm}%') "; // Changed table and column names.  Used email as a secondary search field since there's no lname.
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
?>
