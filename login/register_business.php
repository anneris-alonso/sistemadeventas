<?php
include('../app/config.php');
session_start();

// Input validation and error handling
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_negocio = filter_input(INPUT_POST, 'nombre_negocio', FILTER_SANITIZE_STRING);
    if (empty($nombre_negocio)) { $errors['nombre_negocio'] = "Business name is required"; }


    $tipo_negocio = filter_input(INPUT_POST, 'tipo_negocio', FILTER_SANITIZE_STRING);
    if (empty($tipo_negocio)) { $errors['tipo_negocio'] = "Business type is required"; }
    

  if(empty($errors)){
    try {
        $stmt = $pdo->prepare("INSERT INTO tb_negocios (nombre_negocio, tipo_negocio) VALUES (?, ?)");
        $stmt->execute([$nombre_negocio, $tipo_negocio]);
        $_SESSION['id_negocios'] = $pdo->lastInsertId();
        header("Location: register_user.php");
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage()); // Log this error properly in production
    }
  }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register Business</title>
</head>
<body>
    <h1>Register Business</h1>
    <form action="" method="post">
        <label for="nombre_negocio">Business Name:</label><br>
        <input type="text" id="nombre_negocio" name="nombre_negocio" value="<?php if(isset($nombre_negocio)){ echo $nombre_negocio; }?>" required><br>
        <span class="text-danger"><?php if(isset($errors['nombre_negocio'])){ echo $errors['nombre_negocio'];}?></span><br><br>


        <label for="tipo_negocio">Business Type:</label><br>
        <input type="text" id="tipo_negocio" name="tipo_negocio" value="<?php if(isset($tipo_negocio)){ echo $tipo_negocio; }?>" required><br>
        <span class="text-danger"><?php if(isset($errors['tipo_negocio'])){ echo $errors['tipo_negocio'];}?></span><br><br>

        <input type="submit" value="Next">
    </form>
</body>
</html>

