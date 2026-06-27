<?php
session_start();
$userName = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : "Maceracı";
$currentLevel = "A2"; 

$videoTests = [
    ["id" => 1, "img" => "https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&q=80&w=600", "tag" => "Sosyal Hayat", "link" => "video_seviye11.php"],
    ["id" => 2, "img" => "https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&q=80&w=600", "tag" => "Alışveriş", "link" => "video_seviye12.php"],
    ["id" => 3, "img" => "https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&q=80&w=600", "tag" => "Gezi & Tatil", "link" => "video_seviye13.php"],
    ["id" => 4, "img" => "https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&q=80&w=600", "tag" => "Eğitim", "link" => "video_seviye14.php"],
    ["id" => 5, "img" => "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&q=80&w=600", "tag" => "Restoran", "link" => "video_seviye15.php"],
    ["id" => 6, "img" => "https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?auto=format&fit=crop&q=80&w=600", "tag" => "Sağlık & Spor", "link" => "kalan_seviyeler.php"],
    ["id" => 7, "img" => "https://images.unsplash.com/photo-1493106819501-66d381c466f1?auto=format&fit=crop&q=80&w=600", "tag" => "Ev & Aile", "link" => "kalan_seviyeler.php"],
    ["id" => 8, "img" => "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=600", "tag" => "İş Görüşmesi", "link" => "kalan_seviyeler.php"],
    ["id" => 9, "img" => "https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&q=80&w=600", "tag" => "Şehir Hayatı", "link" => "kalan_seviyeler.php"],
    ["id" => 10, "img" => "https://images.unsplash.com/photo-1510915228340-29c85a43dcfe?auto=format&fit=crop&w=600", "tag" => "Hobiler", "link" => "kalan_seviyeler.php"],
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
        .main-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            padding: 50px 5%;
        }

        .page-header { margin-bottom: 40px; }
        .page-header h1 { font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; }
        .page-header span { color: var(--accent); font-weight: 600; font-size: 0.9rem; }

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

        /* BURAYI DEĞİŞTİRDİM - YAZI ARTIK SİYAH */
        .card-tag {
            position: absolute; top: 20px; right: 20px;
            background: rgba(255, 255, 255, 0.85); /* Arka planı biraz daha belirgin yaptım ki siyah yazı okunsun */
            backdrop-filter: blur(10px);
            padding: 5px 15px; border-radius: 12px; font-size: 0.75rem;
            font-weight: 800; /* Daha kalın yaptım */
            color: #000000; /* İŞTE BURASI SİYAH OLDU */
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