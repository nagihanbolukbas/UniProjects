<?php
session_start();
require_once __DIR__ . "/db.php";

header('Content-Type: application/json; charset=utf-8');

// Giriş kontrolü
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Giriş yapmalısınız.'
    ]);
    exit;
}

$user_id = (int)$_SESSION['user']['id'];

// JS'den gelen ID (custom kelimelerde id + 100000)
$word_id = (int)($_POST['word_id'] ?? 0);

if ($word_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Geçersiz kelime ID.'
    ]);
    exit;
}

// Gerçek custom word ID'sine çevir
$real_id = $word_id - 100000;

if ($real_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Geçersiz özel kelime ID.'
    ]);
    exit;
}

try {
    // Sadece kullanıcıya ait kelimeyi sil
    $stmt = $pdo->prepare("
        DELETE FROM user_custom_words
        WHERE id = ? AND user_id = ?
    ");

    $stmt->execute([$real_id, $user_id]);

    // Hiç satır silinmediyse
    if ($stmt->rowCount() === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Kelime bulunamadı.'
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Kelime başarıyla silindi.'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Veritabanı hatası: ' . $e->getMessage()
    ]);
}
?>