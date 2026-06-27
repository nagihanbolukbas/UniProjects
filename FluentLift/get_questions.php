<?php
header('Content-Type: application/json; charset=utf-8');
// Tarayıcıya bu dosyanın önbelleğe alınmamasını söyleyelim
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once __DIR__ . "/db.php"; 

try {
    $unit_id = isset($_GET['unit_id']) ? (int)$_GET['unit_id'] : 1;

    // NEWID() yerine CHECKSUM(NEWID()) kullanmak bazen rastgeleliği tetikler
 $sql = "SELECT TOP 5 question_text, option_a, option_b, option_c, correct_option 
        FROM [dbo].[questions] 
        WHERE unit_id = :uid 
        ORDER BY NEWID()";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['uid' => $unit_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $questions = [];
    foreach ($rows as $row) {
        $questions[] = [
            "q" => $row['question_text'],
            "options" => [$row['option_a'], $row['option_b'], $row['option_c']],
            "correct" => (int)$row['correct_option']
        ];
    }

    echo json_encode($questions, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>