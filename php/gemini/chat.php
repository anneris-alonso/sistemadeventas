<?php
// app/controllers/gemini/chat.php
ob_start(); // Added at the very top
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../../../vendor/autoload.php'; // Adjust the path if necessary
include('../../config.php'); // Correct path to config.php

use Google\GenerativeAI\GenerativeModel;
use Google\GenerativeAI\Content;
use Google\GenerativeAI\Part;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    error_log("Received message: " . $message);

    $apiKey = "AIzaSyA1Pe5Fg4tVEqYFL9JyL9ROkIVeKSSAxCI"; // Replace with your ACTUAL API key!

    error_log("API Key: " . $apiKey);

    if (empty($apiKey)) {
        error_log("Error: Gemini API key is missing.");
        header('Content-Type: application/json');
        echo json_encode(['response' => "Error: Gemini API key is missing."]);
        exit;
    }

    $response = '';
    try {
        $model = new GenerativeModel($apiKey, "gemini-pro"); // Change to a valid model (e.g., gemini-pro)

        $result = $model->generateContent(new Content([
            new Part(['text' => $message]),
        ]));

        $response = $result->text();
    } catch (Exception $e) {
        $response = "Error: " . $e->getMessage();
        error_log("Gemini API Error: " . $e->getMessage());
    }
    error_log("Response to be sent: " . $response);

    ob_end_clean(); // Clears the output buffer
    header('Content-Type: application/json');
    echo json_encode(['response' => $response]);
}
?>
