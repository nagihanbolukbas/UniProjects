<?php
session_start();
require_once "db.php";

header('Content-Type: application/json');

if (!isset($_SESSION["user"]["id"])) {
    echo json_encode([]);
    exit;
}

$user_id = (int)$_SESSION["user"]["id"];

try {
    $stmt = $pdo->prepare("
        SELECT id, task_text, completed
        FROM dbo.daily_tasks
        WHERE user_id = ?
        ORDER BY id DESC
    ");

    $stmt->execute([$user_id]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch(PDOException $e){
    echo json_encode([
        "error" => $e->getMessage()
    ]);
}