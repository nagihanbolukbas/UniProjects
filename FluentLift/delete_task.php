<?php
session_start();
require_once "db.php";

$user_id = $_SESSION["user"]["id"];
$task_id = (int)$_POST["task_id"];

$stmt = $pdo->prepare("
    DELETE FROM daily_tasks
    WHERE id=? AND user_id=?
");
$stmt->execute([$task_id,$user_id]);