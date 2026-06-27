<?php
session_start();
require_once __DIR__ . "/db.php";

if (isset($_SESSION["user"]) && isset($_POST['node_idx'])) {
    $user_id = (int)$_SESSION["user"]["id"];
    $node_idx = (int)$_POST['node_idx'];

    try {
        // Önce güncellemeye çalış
        $st = $pdo->prepare("UPDATE dbo.user_progress SET last_node_index = ?, updated_at = GETDATE() WHERE user_id = ?");
        $st->execute([$node_idx, $user_id]);

        // Eğer hiçbir satır güncellenmediyse (yani kayıt yoksa), yeni ekle
        if ($st->rowCount() == 0) {
            $ins = $pdo->prepare("INSERT INTO dbo.user_progress (user_id, last_node_index) VALUES (?, ?)");
            $ins->execute([$user_id, $node_idx]);
        }
        
        echo "Basarili. Yeni Index: " . $node_idx;
    } catch (PDOException $e) {
        echo "SQL Hatası: " . $e->getMessage();
    }
} else {
    echo "Gecersiz İstek. Session veya Veri eksik.";
}