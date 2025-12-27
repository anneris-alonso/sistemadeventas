<?php
/**
 * Created by PhpStorm.
 * User: HILARIWEB
 * Date: 17/1/2023
 * Time: 13:00
 */
define('SERVIDOR', 'localhost');
define('USUARIO', 'root');
define('PASSWORD', '');
define('BD', 'sistemadeventas');

// AI Configuration
//define('AI_API_KEY', 'YOUR_API_KEY_HERE'); // User to replace this
//define('AI_API_URL', 'https://api.openai.com/v1/chat/completions'); // Default to OpenAI, can be changed
//define('AI_MODEL', 'gpt-3.5-turbo'); // Cost-effective model for SQL generation

define('AI_API_KEY', 'QkVRcThLeYCmrTuMPGxQWgSHmspUrxGE');
define('AI_API_URL', 'https://api.mistral.ai/v1/chat/completions');
define('AI_API_MODEL', 'open-mistral-7b');

$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR;

try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    //echo "La conexión a la base de datos fue con exito";
} catch (PDOException $e) {
    //print_r($e);
    echo "Error al conectar a la base de datos";
}

$URL = "http://localhost/www.sistemadeventas.com";

date_default_timezone_set("America/Caracas");
$fechaHora = date('Y-m-d H:i:s');

function __($key)
{
    static $translations = null;
    if ($translations === null) {
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
        $file = __DIR__ . '/../lang/' . $lang . '.json';
        if (file_exists($file)) {
            $json = file_get_contents($file);
            $translations = json_decode($json, true);
        } else {
            $translations = [];
        }
    }
    return isset($translations[$key]) ? $translations[$key] : $key;
}



