<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

header('Content-Type: application/json');

// Error handling to prevent HTML leaking into JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

try {
    // 1. Load Dependencies
    include('../../app/config.php');
    include('../../app/controllers/ai/AiClient.php');
    include('../../app/controllers/ai/QueryEngine.php');
    include('../../app/controllers/ai/SchemaMap.php');

    // 2. Auth Check (Basic Session Check)
    session_start();
    if (!isset($_SESSION['usuario_id']) && !isset($_SESSION['email'])) {
        // Allow if just testing, but in production strictly block
        // throw new Exception("Unauthorized");
    }

    // Get Business Context
    $id_negocios = isset($_SESSION['negocio_id']) ? $_SESSION['negocio_id'] : null;

    // 3. Get Input
    $input = json_decode(file_get_contents('php://input'), true);
    $userQuestion = $input['message'] ?? '';

    if (empty($userQuestion)) {
        throw new Exception("Message is required.");
    }

    // 4. Initialize AI
    $ai = new AiClient();
    $db = new QueryEngine($pdo); // $pdo comes from config.php

    // 5. Step A: Generate SQL
    $schema = SchemaMap::getSchema();
    $context = "Context: id_negocios = " . ($id_negocios ? $id_negocios : 'ALL');

    $systemPrompt = $schema . "\n" . $context . "\n\nGiven the user question, generate a SQL query.";

    $sql = $ai->query($systemPrompt, $userQuestion);

    if (empty($sql)) {
        throw new Exception("AI failed to generate SQL.");
    }

    // 6. Step B: Execute SQL
    $results = $db->executeSafeSql($sql);

    // 7. Step C: Explain Results
    // If results are empty
    if (empty($results)) {
        echo json_encode(['answer' => "I found no data matching that request."]);
        exit;
    }

    // Truncate results for context window if too large
    $dataStr = json_encode(array_slice($results, 0, 20));

    $explainPrompt = "
    You are a Business Intelligence Analyst. 
    User Question: '$userQuestion'
    Data Results: $dataStr
    
    Analyze the data and provide a concise, professional answer in HTML format (use <b>, <ul>, <li>, <br> only).
    Do not mention 'SQL' or 'Database' or 'Query'. Just focus on the business answer.
    If the data is a list, format it nicely.
    ";

    $finalAnswer = $ai->query("You are a helpful BI assistant.", $explainPrompt);

    echo json_encode(['answer' => $finalAnswer]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
