<?php
session_start();
require_once __DIR__ . "/db.php";

header('Content-Type: application/json');

if (!isset($_SESSION["user"]["id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Session yok"
    ]);
    exit;
}

$user_id = (int)$_SESSION["user"]["id"];
$text = trim($_POST["task"] ?? '');

if ($text === '') {
    echo json_encode([
        "success" => false,
        "message" => "Boş görev"
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO dbo.daily_tasks (user_id, task_text, completed)
        VALUES (?, ?, 0)
    ");

    $stmt->execute([$user_id, $text]);

    echo json_encode([
        "success" => true
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}