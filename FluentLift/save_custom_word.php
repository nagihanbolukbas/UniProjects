<?php
session_start();
require_once __DIR__ . "/db.php";

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user']['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Giriş yapmalısınız.'
    ]);
    exit;
}

$user_id = (int)$_SESSION['user']['id'];
$word_en = trim($_POST['word_en'] ?? '');
$word_tr = trim($_POST['word_tr'] ?? '');

if ($word_en === '' || $word_tr === '') {
    echo json_encode([
        'success' => false,
        'message' => 'Boş alan bırakmayın.'
    ]);
    exit;
}

// Ana sözlükte var mı?
$stmt = $pdo->prepare("SELECT COUNT(*) FROM words WHERE LOWER(word_en) = LOWER(?)");
$stmt->execute([$word_en]);
$existsMain = (int)$stmt->fetchColumn();

// Kullanıcının kendi kelimelerinde var mı?
$stmt2 = $pdo->prepare(
    "SELECT COUNT(*)
     FROM user_custom_words
     WHERE user_id = ? AND LOWER(word_en) = LOWER(?)"
);
$stmt2->execute([$user_id, $word_en]);
$existsCustom = (int)$stmt2->fetchColumn();

if ($existsMain > 0 || $existsCustom > 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Bu kelime zaten mevcut.'
    ]);
    exit;
}

$insert = $pdo->prepare(
    "INSERT INTO user_custom_words (user_id, word_en, word_tr)
     VALUES (?, ?, ?)"
);

$insert->execute([$user_id, $word_en, $word_tr]);

echo json_encode([
    'success' => true,
    'message' => 'Kelime eklendi.'
]);