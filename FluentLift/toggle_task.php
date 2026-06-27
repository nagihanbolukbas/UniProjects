<?php
session_start();
require_once "db.php";

$user_id = $_SESSION["user"]["id"];
$task_id = (int)$_POST["task_id"];

$stmt = $pdo->prepare("
    UPDATE daily_tasks
    SET completed = CASE WHEN completed=1 THEN 0 ELSE 1 END
    WHERE id=? AND user_id=?
");
$stmt->execute([$task_id,$user_id]);