<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 1/2/2023
 * Time: 18:16
 */

$sql_clients = "SELECT * FROM tb_clients ";
$query_clients = $pdo->prepare($sql_clients);
$query_clients->execute();
$clients_datos = $query_clients->fetchAll(PDO::FETCH_ASSOC);