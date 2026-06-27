<?php
session_start();
$userName = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : "Maceracı";
$currentLevel = isset($_GET['level']) ? strtoupper($_GET['level']) : "A1";

// 10 Adet Video Test Verisi
$videoTests = [
    ["id" => 1, "img" => "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500", "tag" => "Diyalog", "link" => "video_seviye.php"],
    ["id" => 2, "img" => "https://images.unsplash.com/photo-1552664730-d307ca884978?w=500", "tag" => "Mutfak", "link" => "video_seviye2.php"],
    ["id" => 3, "img" => "https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?w=500", "tag" => "Seyahat", "link" => "video_seviye3.php"],
    ["id" => 4, "img" => "https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=500", "tag" => "İş", "link" => "video_seviye4.php"],
    ["id" => 5, "img" => "https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=500", "tag" => "Moda", "link" => "video_seviye5.php"],
    ["id" => 6, "img" => "https://images.unsplash.com/photo-1526772662000-3f88f10405ff?w=500", "tag" => "Doğa", "link" => "video_seviye6.php"],
    ["id" => 7, "img" => "https://images.unsplash.com/photo-1666214280557-f1b5022eb634?w=600", "tag" => "Sağlık", "link" => "video_seviye7.php"],
    ["id" => 8, "img" => "https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=500", "tag" => "Kariyer", "link" => "video_seviye8.php"],
    ["id" => 9, "img" => "https://images.unsplash.com/photo-1502444330042-d1a1ddf9bb5b?w=500", "tag" => "Sanat", "link" => "video_seviye9.php"],
    ["id" => 10, "img" => "https://images.unsplash.com/photo-1506784983877-45594efa4cbe?w=500", "tag" => "Zaman", "link" => "video_seviye10.php"],
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FluentLift | Video Test Paneli</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0f172a;
            --primary: #2563eb; 
            --accent: #38bdf8;
            --sidebar-width: 260px;
            --border: rgba(255, 255, 255, 0.08);
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif; }
        body { background: var(--bg-dark); color: white; display: flex; min-height: 100vh; overflow-x: hidden; }

        /* SIDEBAR */
        .sidebar {
    width: 260px;
    height: 100vh;
    background: #0a0f1a; /* Derin elit siyah/lacivert */
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

/* Logo Bölümü */
.logo { 
   font-size: 1.5rem; 
    font-weight: 800; 
    color: var(--accent); /* Parlak mavi/turkuaz tonu */
    margin-bottom: 40px; 
    padding-left: 10px;
    font-family: 'Poppins', sans-serif;
}
/* NAV MENÜ */
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
            width: calc(100% - var(--sidebar-width));
            padding: 50px 5%;
        }

        .page-header { margin-bottom: 40px; }
        .page-header h1 { font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; }
        .page-header span { color: var(--accent); font-weight: 600; font-size: 0.9rem; }

        /* GRID & CARDS */
        .test-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .test-card {
            position: relative;
            border-radius: 30px;
            overflow: hidden;
            aspect-ratio: 4/5;
            border: 1px solid var(--border);
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .test-card img {
            width: 100%; height: 100%; object-fit: cover; transition: 0.5s;
        }

        .overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10, 15, 26, 0.95), transparent);
            display: flex; flex-direction: column; justify-content: flex-end;
            padding: 25px; opacity: 1; transition: 0.3s;
        }

        /* KATEGORİ ETİKETLERİ - SİYAH YAZI AYARI */
        .card-tag {
            position: absolute; top: 20px; right: 20px;
            background: rgba(255, 255, 255, 0.9); /* Yazının okunması için beyazlığı artırdım */
            backdrop-filter: blur(10px);
            padding: 5px 15px; border-radius: 12px; font-size: 0.75rem;
            font-weight: 800; /* Daha kalın ve belirgin */
            color: #000000; /* YAZI SİYAH OLDU */
            border: 1px solid rgba(255,255,255,0.2);
            z-index: 10;
        }

        .test-card:hover { transform: scale(1.03); border-color: var(--accent); }
        .test-card:hover img { transform: scale(1.1); }

        .btn-play {
            background: var(--accent);
            color: #000;
            text-align: center;
            padding: 12px;
            border-radius: 15px;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            transition: 0.3s;
            text-decoration: none;
            display: block;
        }

        .test-card:hover .btn-play { background: white; }

        .test-number { font-size: 0.8rem; color: var(--accent); font-weight: 700; margin-bottom: 5px; }
        .test-title { font-size: 1.2rem; font-weight: 700; margin-bottom: 15px; }

        .glow {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: radial-gradient(circle at 20% 20%, rgba(56, 189, 248, 0.05), transparent 50%);
            z-index: -1;
        }
    </style>
</head>
<body>

<div class="glow"></div>

<nav class="sidebar">
    <div class="logo">🌍 FluentLift</div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="anasayfa2.php" class="nav-link"><span>🏠</span> <b>Öğren</b></a></li>
        <li class="nav-item"><a href="profil.php" class="nav-link"><span>👤</span> <b>Profil</b></a></li>
        <li class="nav-item"><a href="seviye_belirle.php" class="nav-link active"><span>📺</span> <b>İzle</b></a></li>
        <li class="nav-item"><a href="kelimeler.php" class="nav-link"><span>📚</span> <b>Sözlük</b></a></li>
        <li class="nav-item"><a href="nova/index.php" class="nav-link"><span>✨</span> <b>Nova İle Konuş</b></a></li>
        <li class="nav-item"><a href="mikro.php" class="nav-link"> <span>🌟</span> <b>Gerçek Hayat</b></a></li>
        <li class="nav-item"><a href="ayarlar.php" class="nav-link"><span>⚙️</span> <b>Ayarlar</b></a></li>
    </ul>
</nav>

<main class="main-content">
    <div class="page-header">
        <span><?php echo $currentLevel; ?> SEVİYESİ</span>
        <h1>Video Analiz Testleri</h1>
    </div>

    <div class="test-grid">
        <?php foreach ($videoTests as $test): ?>
        <div class="test-card">
            <img src="<?php echo $test['img']; ?>" alt="Test Görseli">
            <div class="card-tag"><?php echo $test['tag']; ?></div>
            <div class="overlay">
                <div class="test-number">TEST #<?php echo $test['id']; ?></div>
                <div class="test-title">Bölüm <?php echo $test['id']; ?></div>
                
                <a href="<?php echo isset($test['link']) ? $test['link'] : 'video_seviye.php'; ?>?id=<?php echo $test['id']; ?>" class="btn-play">
                    Testi Başlat
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

</body>
</html>