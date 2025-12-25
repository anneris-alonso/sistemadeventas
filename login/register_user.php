<?php
include('../app/config.php');
session_start();

if (!isset($_SESSION['id_negocios'])) {
    die("Error: No business ID. Register a business first.");  // Or redirect
}
$id_negocios = $_SESSION['id_negocios'];

// Error handling and validation
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Input validation 
    $nombres = filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_STRING);
    if (empty($nombres)) { $errors['nombres'] = "Username can't be blank"; }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (empty($email)) { $errors['email'] = "Email can't be blank"; }
    if (!$email) { $errors['email'] = "Invalid email format"; }

    $password_user = $_POST['password_user'];
    if (empty($password_user)) { $errors['password_user'] = "Password can't be blank"; }
    if (strlen($password_user) < 6) { $errors['password_user'] = "Password is too short"; }

    if (empty($errors)) {
        try {
            // 1. Get the 'super_admin' role ID or any other default role if super admin does not exist.
            $stmt_role = $pdo->prepare("SELECT id_rol FROM tb_roles WHERE rol = 'super_admin' LIMIT 1");
            $stmt_role->execute();
            $role_data = $stmt_role->fetch(PDO::FETCH_ASSOC);

            if ($role_data) {
                $id_rol = $role_data['id_rol'];
            } else {
              // If 'super_admin' doesn't exist, get another default role, or handle the error as needed. For example:
              $stmt_role = $pdo->prepare("SELECT id_rol FROM tb_roles WHERE rol = 'user' LIMIT 1"); // Replace 'user' with your desired default role.
              $stmt_role->execute();
              $role_data = $stmt_role->fetch(PDO::FETCH_ASSOC);

              if($role_data){
                $id_rol = $role_data['id_rol'];
              }
              else {
                 die("Default role not found. Please create a default role first."); // Or handle it differently (e.g., set $id_rol to NULL if your database allows it).
              }


            }


            // 2. Insert the new user.
            $stmt = $pdo->prepare("INSERT INTO tb_usuarios (id_negocios, nombres, password_user, email, id_rol) 
                                  VALUES (:id_negocios, :nombres, :password_user, :email, :id_rol)");

            $hashed_password = password_hash($password_user, PASSWORD_DEFAULT);

            $stmt->bindParam(':id_negocios', $id_negocios, PDO::PARAM_INT);
            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':password_user', $hashed_password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->execute();

            unset($_SESSION['id_negocios']);
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage()); // Handle/log errors properly in a production application.
        }
    }
}
?>
<!-- ... (your HTML code) ... -->


?>
<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>
</head>
<body>
    <h1>Register User</h1>
    <form action="" method="post">
        <label for="nombres">Username:</label><br>
        <input type="text" id="nombres" name="nombres" value="<?php if (isset($nombres)) { echo $nombres; } ?>" required><br>
        <span class="text-danger"><?php if (isset($errors['nombres'])) { echo $errors['nombres']; } ?></span><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php if (isset($email)) { echo $email; } ?>" required><br>
        <span class="text-danger"><?php if (isset($errors['email'])) { echo $errors['email']; } ?></span><br><br>

        <label for="password_user">Password:</label><br>
        <input type="password" id="password_user" name="password_user" required><br>  <!-- Corrected input type -->
        <span class="text-danger"><?php if (isset($errors['password_user'])) { echo $errors['password_user']; } ?></span><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
