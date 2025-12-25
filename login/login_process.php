<?php
include('../app/config.php');
session_start();

$login_error_message = ""; // Initialize error message variable.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password_user = $_POST['password_user'];



    try {
        $stmt = $pdo->prepare("SELECT * FROM tb_usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $nombres = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($nombres && password_verify($password_user, $nombres['password_user'])) {
            $_SESSION['sesion_email'] = $nombres['email']; 
            $_SESSION['negocio_id'] = $nombres['id_negocios'];
            header("Location: index.php"); // Redirect to the application's main page
            exit();
        } else {
            $login_error_message = "Invalid email or password.";  // Set the error message.
        }
    } catch (PDOException $e) {
        // Handle database errors appropriately (e.g., log the error)
         die("Database Error: ".$e->getMessage()); // In a real app, don't show the raw error
    }
}



//If an error has occurred from Login, render login.php page to display it.
if(!empty($login_error_message)){
    include("ingreso.php");
    echo "<p style='color: red;'>$login_error_message</p>"; // Display the error message
    exit(); // Stop further execution
}
?>
