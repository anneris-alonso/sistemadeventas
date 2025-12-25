<?php
include('../app/config.php'); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de ventas</title>
  <link rel="stylesheet" href="style.css"> 
  <style>
    body {
      display: flex;
      flex-direction: column; 
      align-items: center; 
      justify-content: center; 
      min-height: 100vh; 
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <form action="../app/controllers/login/ingreso.php" method="post"> <div class="input-field">
        <input type="email" name="email" required> <label>Enter your email</label>
      </div> <div class="input-field">
        <input type="password_user" name="password_user" required> <label>Enter your password</label>
      </div> <div class="forget">
        <label for="remember">
          <input type="checkbox" id="remember"> <p>Remember me</p>
        </label> <a href="#">Forgot password?</a>
      </div> <button type="submit">Log In</button> <div class="register">
        <p>Don't have an account? <a href="register_business.php">Register</a></p> </div>
    </form>
  </div>
</body>
</html>