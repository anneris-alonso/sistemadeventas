<?php
include('app/config.php');
try {
    $sql = "ALTER TABLE tb_usuarios ADD language VARCHAR(5) DEFAULT 'en';";
    $pdo->exec($sql);
    echo "Database updated successfully.";
} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage();
}
?>