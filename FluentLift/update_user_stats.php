<?php
// update_user_stats.php
session_start();
require_once __DIR__ . "/db.php";

if (isset($_SESSION["user"]) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int)$_SESSION["user"]["id"];
    $level   = (int)$_POST['level'];
    $xp      = (int)$_POST['xp'];
    $stars   = (int)$_POST['stars'];

    try {
        $st = $pdo->prepare("UPDATE dbo.users SET user_level = ?, user_xp = ?, total_stars = ? WHERE id = ?");
        $st->execute([$level, $xp, $stars, $user_id]);
        echo json_encode(["status" => "success"]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
?>