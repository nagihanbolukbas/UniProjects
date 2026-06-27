<?php
session_start();
require_once __DIR__ . "/db.php";

if (isset($_POST['word_id']) && isset($_SESSION['user']['id'])) {
    $word_id = (int)$_POST['word_id'];
    $user_id = (int)$_SESSION['user']['id'];
    $status  = (int)$_POST['status'];

    try {
        if ($status == 1) {
            // SQL Server için: Varsa ekleme, yoksa ekle
            $sql = "IF NOT EXISTS (SELECT 1 FROM user_learned_words WHERE user_id = ? AND word_id = ?)
                    INSERT INTO user_learned_words (user_id, word_id) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id, $word_id, $user_id, $word_id]);
        } else {
            // Kelimeyi öğrenilenlerden çıkar
            $sql = "DELETE FROM user_learned_words WHERE user_id = ? AND word_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id, $word_id]);
        }
        echo "success";
    } catch (Exception $e) {
        echo "error: " . $e->getMessage();
    }
}