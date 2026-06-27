<?php
session_start();
require_once __DIR__ . "/db.php";

if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["id"])) {
    header("Location: login.php");
    exit;
}

$user_id = (int)$_SESSION["user"]["id"];

try {
    // Kullanıcı Bilgileri
    $st = $pdo->prepare("
        SELECT 
            first_name,
            last_name,
            email,
            avatar,
            created_at,
            total_stars,
            user_level,
            user_xp
        FROM dbo.users
        WHERE id = ?
    ");

    $st->execute([$user_id]);
    $u = $st->fetch(PDO::FETCH_ASSOC);

    if (!$u) {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    // Kullanıcı Değişkenleri
    $userName    = $u["first_name"] ?? "Maceracı";
    $userSurname = $u["last_name"] ?? "Kullanıcı";
    $userEmail   = $u["email"] ?? "";
    $userAvatar  = $u["avatar"] ?? "b.jpg";

    $totalStars  = isset($u["total_stars"]) ? (int)$u["total_stars"] : 0;
    $user_level  = isset($u["user_level"]) ? (int)$u["user_level"] : 1;
    $user_xp     = isset($u["user_xp"]) ? (int)$u["user_xp"] : 0;

    // Katılım Tarihi
    if (!empty($u["created_at"])) {
        $joinDate = date("d.m.Y", strtotime($u["created_at"]));
    } else {
        $joinDate = date("d.m.Y");
    }

    // Öğrenilen Kelime Sayısı
    $stWords = $pdo->prepare("
        SELECT COUNT(*) AS toplam
        FROM dbo.user_learned_words
        WHERE user_id = ?
    ");
    $stWords->execute([$user_id]);

    $learnedResult = $stWords->fetch(PDO::FETCH_ASSOC);
    $learnedWords  = isset($learnedResult["toplam"]) ? (int)$learnedResult["toplam"] : 0;

} catch (PDOException $e) {
    die("Veritabanı Hatası: " . $e->getMessage());
}
$currentLevel = "A1"; 

?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FluentLift — Elite Profile</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
<style>
:root {
    --bg-dark: #070b14;
    --bg-light: #161e2d;
    --accent: #38bdf8;
    --sidebar-width: 260px;
    --text-white: #ffffff;
    --border: rgba(255, 255, 255, 0.05);
    --glass: rgba(255, 255, 255, 0.03);
    --streak: #fb923c;
}

* { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif; }

body {
    background: radial-gradient(circle at top right, var(--bg-light), var(--bg-dark));
    background-attachment: fixed;
    color: var(--text-white);
    display: flex;
    overflow-x: hidden;
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
}

/* --- DİNAMİK ARKA PLAN --- */
.bg-animation {
    position: fixed;
    top: 0; left: var(--sidebar-width);
    width: calc(100% - var(--sidebar-width));
    height: 100%;
    z-index: 0;
    pointer-events: none;
}

.floating-emoji {
    position: absolute;
    font-size: 2.5rem;
    opacity: 0.3;
    animation: float 22s linear infinite;
    bottom: -100px;
}

@keyframes float {
    0% { transform: translateY(0) rotate(0deg) scale(0.8); opacity: 0; }
    20% { opacity: 0.35; }
    80% { opacity: 0.35; }
    100% { transform: translateY(-120vh) rotate(360deg) scale(1.2); opacity: 0; }
}

/* SIDEBAR - Dokunulmadı */
.sidebar {
    width: 260px;
    height: 100vh;
    background: #0a0f1a;
    border-right: 1px solid rgba(255, 255, 255, 0.08);
    padding: 35px 15px;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
}

.logo {
   font-size: 1.5rem;
    font-weight: 800;
    color: var(--accent);
    margin-bottom: 40px;
    padding-left: 10px;
    font-family: 'Poppins', sans-serif;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex-grow: 1;
}

.nav-link {
    text-decoration: none;
    color: #94a3b8;
    font-size: 0.95rem;
    padding: 12px 18px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-link b { font-weight: 500; }
.nav-link span { font-size: 1.2rem; }

.nav-link.active {
    background: #1e293b;
    color: var(--accent);
    box-shadow: 0 4px 15px rgba(56, 189, 248, 0.15);
}

.nav-link:hover:not(.active) {
    background: rgba(255, 255, 255, 0.05);
    color: white;
    transform: translateX(5px);
}

/* MAIN CONTENT */
.main-content {
    margin-left: var(--sidebar-width);
    width: 100%;
    padding: 60px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 5;
}

/* PROFİL KARTI - ELİTE TASARIM */
.profile-hero {
    width: 100%; max-width: 900px;
    background: linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.01) 100%);
    border: 1px solid var(--border);
    border-radius: 40px;
    padding: 40px;
    display: flex;
    gap: 40px;
    align-items: center;
    backdrop-filter: blur(20px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.4);
    margin-bottom: 30px;
}

.avatar-container { position: relative; }

.avatar-rect-white {
    width: 260px; height: 320px;
    border-radius: 30px; background: #ffffff;
    display: flex; justify-content: center; align-items: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    border: 5px solid var(--accent);
    overflow: hidden;
}
.avatar-rect-white img { height: 90%; width: auto; object-fit: contain; }

/* KULLANICI BİLGİ ALANI */
.user-meta { flex: 1; }
.user-meta h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 10px; color: #fff; }
.level-badge {
    display: inline-block; padding: 6px 16px; background: var(--accent);
    color: var(--bg-dark); border-radius: 50px; font-weight: 800; font-size: 0.8rem; margin-bottom: 20px;
}

/* YENİ İSTATİSTİK YERLEŞİMİ */
.stats-row { display: flex; gap: 15px; margin-top: 20px; }
.stat-item {
    background: rgba(255,255,255,0.04);
    padding: 15px 25px;
    border-radius: 20px;
    border: 1px solid var(--border);
    text-align: center;
    min-width: 120px;
}
.stat-item span { display: block; font-size: 1.4rem; font-weight: 800; }
.stat-item small { color: #94a3b8; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px; }

/* DETAY KARTLARI */
.detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    width: 100%;
    max-width: 900px;
}

.detail-card {
    background: var(--glass);
    border: 1px solid var(--border);
    padding: 25px;
    border-radius: 30px;
    backdrop-filter: blur(10px);
}

.detail-card h3 { font-size: 0.9rem; color: var(--accent); margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px; }
.info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border); }
.info-row:last-child { border: none; }
.info-row label { color: #94a3b8; font-size: 0.9rem; }
.info-row span { font-weight: 600; color: #fff; }

.logout-container { margin-top: 40px; }
.btn-logout {
    color: #ef4444; text-decoration: none; font-weight: 600; font-size: 0.9rem;
    padding: 10px 30px; border-radius: 50px; border: 1px solid rgba(239, 68, 68, 0.2);
    transition: 0.3s;
}
.btn-logout:hover { background: rgba(239, 68, 68, 0.1); box-shadow: 0 0 20px rgba(239, 68, 68, 0.2); }
</style>
</head>
<body>

<div class="bg-animation">
    <div class="floating-emoji" style="left: 10%; animation-delay: -2s;">🇬🇧</div>
    <div class="floating-emoji" style="left: 20%; animation-delay: -15s;">📚</div>
    <div class="floating-emoji" style="left: 35%; animation-delay: -7s;">✨</div>
    <div class="floating-emoji" style="left: 50%; animation-delay: -22s;">💬</div>
    <div class="floating-emoji" style="left: 65%; animation-delay: -5s;">🇺🇸</div>
    <div class="floating-emoji" style="left: 80%; animation-delay: -18s;">📝</div>
    <div class="floating-emoji" style="left: 90%; animation-delay: -10s;">🌍</div>
</div>

<nav class="sidebar">
    <div class="logo">🌍 FluentLift</div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="anasayfa2.php" class="nav-link"><span>🏠</span> <b>Öğren</b></a></li>
        <li class="nav-item"><a href="profil.php" class="nav-link active"><span>👤</span> <b>Profil</b></a></li>
        <li class="nav-item"><a href="seviye_belirle.php" class="nav-link"><span>📺</span> <b>İzle</b></a></li>
        <li class="nav-item"><a href="kelimeler.php" class="nav-link"><span>📚</span> <b>Sözlük</b></a></li>
        <li class="nav-item"><a href="nova/index.php" class="nav-link"><span>✨</span> <b>Nova İle Konuş</b></a></li>
        <li class="nav-item"><a href="mikro.php" class="nav-link"><span>🌟</span> <b>Gerçek Hayat</b></a></li>
        <li class="nav-item"><a href="ayarlar.php" class="nav-link"><span>⚙️</span> <b>Ayarlar</b></a></li>
    </ul>
</nav>

<main class="main-content">

    <section class="profile-hero">
        <div class="avatar-container">
            <div class="avatar-rect-white">
                <img src="<?php echo htmlspecialchars($userAvatar); ?>" alt="Elite Profile Avatar">
            </div>
        </div>

        <div class="user-meta">
                        <span class="level-badge"><?php echo htmlspecialchars($currentLevel); ?> SEVİYE</span>

            <h1><?php echo htmlspecialchars(trim($userName . ' ' . $userSurname)); ?></h1>
            <p style="color: #94a3b8; font-size: 0.95rem;">FluentLift ile dil yolculuğuna devam ediyor.</p>

            <div class="stats-row">
                <div class="stat-item">
                    <span style="color: #fbbf24;">⭐ <?php echo htmlspecialchars($totalStars); ?></span>
                    <small>Yıldız</small>
                </div>
   <div class="stat-item">
    <span style="color:#a78bfa;">⚡ Seviye <?php echo htmlspecialchars($user_level); ?></span>
    <small><?php echo htmlspecialchars($user_xp); ?> XP</small>
</div>
                <div class="stat-item">
                    <span style="color: var(--accent);">📚 <?php echo htmlspecialchars($learnedWords); ?></span>
                    <small>Kelime</small>
                </div>
            </div>
        </div>
    </section>

    <div class="detail-grid">
        <div class="detail-card">
            <h3>Hesap Bilgileri</h3>
            <div class="info-row">
                <label>E-posta</label>
                <span><?php echo htmlspecialchars($userEmail ?: "-"); ?></span>
            </div>
            <div class="info-row">
                <label>Durum</label>
                <span style="color: #22c55e;">Aktif Öğrenci</span>
            </div>
            <div class="info-row">
                <label>Katılım</label>
                <span><?php echo htmlspecialchars($joinDate); ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h3>Dil Gelişimi</h3>
            <div class="info-row">
                <label>Hedef Dil</label>
                <span>İngilizce</span>
            </div>
            <div class="info-row">
                <label>Günlük Hedef</label>
                <span>50 Kelime</span>
            </div>
            <div class="info-row">
                <label>Başarı Oranı</label>
                <span>%88</span>
            </div>
        </div>
    </div>

    <div class="logout-container">
        <a href="anasayfa.php" class="btn-logout">Oturumu Güvenli Kapat</a>
    </div>

</main>

</body>
</html>