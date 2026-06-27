<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMsg = $_POST['message'] ?? '';
    
    // OpenAI API Anahtarını Buraya Yapıştır
    $apiKey = AIzaSyCLxdPEA_ATVQFkfRfpCml2F3F5cUXF6TA; 

    $data = [
        "model" => "gpt-4o",
        "messages" => [
            [
                "role" => "system", 
                "content" => "You are Nova, an AI English teacher.
                1. Chat naturally with the user.
                2. Check user's grammar.
                3. Structure your response exactly like this:
                Response: [Your conversational reply]
                Correction: [Corrected user sentence or 'None']
                Translation: [Turkish translation of your reply]"
            ],
            ["role" => "user", "content" => $userMsg]
        ]
    ];

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ]);

    $response = curl_exec($ch);
    $result = json_decode($response, true);
    $aiText = $result['choices'][0]['message']['content'] ?? "";

    // Metni parçalara ayırma (Regex)
    preg_match('/Response: (.*?)Correction:/s', $aiText, $res);
    preg_match('/Correction: (.*?)Translation:/s', $aiText, $cor);
    preg_match('/Translation: (.*)/s', $aiText, $tr);

    echo json_encode([
        'english' => trim($res[1] ?? "I am listening."),
        'correction' => trim($cor[1] ?? 'None'),
        'turkish' => trim($tr[1] ?? '')
    ]);
    exit;
}