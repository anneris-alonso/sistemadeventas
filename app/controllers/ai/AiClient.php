<?php

class AiClient
{
    private $apiKey;
    private $apiUrl;
    private $model;

    public function __construct()
    {
        $this->apiKey = AI_API_KEY;
        $this->apiUrl = AI_API_URL;
        // Fix: Use correct constant name defined in config.php
        $this->model = defined('AI_API_MODEL') ? AI_API_MODEL : 'gpt-3.5-turbo';
    }

    public function query($systemPrompt, $userMessage)
    {
        $data = [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userMessage]
            ],
            'temperature' => 0 // Deterministic for SQL
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ]);

        // Fix: Disable SSL verification for development/local environments
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('Curl Connection Error: ' . curl_error($ch));
        }

        curl_close($ch);

        $decoded = json_decode($response, true);

        // Fix: Handle non-JSON responses (like 404 HTML, 500 errors)
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Return a snippet of the raw response for debugging
            throw new Exception('Invalid API Response (Not JSON). Raw: ' . substr($response, 0, 200));
        }

        if (isset($decoded['error'])) {
            $msg = is_array($decoded['error']) ? json_encode($decoded['error']) : $decoded['error'];
            throw new Exception('AI API returned error: ' . $msg);
        }

        return $decoded['choices'][0]['message']['content'] ?? '';
    }
}
