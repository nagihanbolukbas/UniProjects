<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
$userName = $isLoggedIn ? $_SESSION['user']['name'] : "Maceracı";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FluentLift — Maceranı Seç!</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
<style>
:root {
    --bg-dark: #0f172a;
    --primary: #2563eb; 
    --accent: #38bdf8;
    --sidebar-width: 260px; /* Önceki sayfadaki gibi genişletildi */
    --text-white: #ffffff;
    --border: rgba(255, 255, 255, 0.08);
}

* { margin:0; padding:0; box-sizing:border-box; font-family: 'Poppins', sans-serif; }

body { 
    background: var(--bg-dark);
    color: var(--text-white);
    display: flex;
    overflow-x: hidden;
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
}

.bg-glow {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: radial-gradient(circle at 20% 30%, rgba(37, 99, 235, 0.15), transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(112, 0, 255, 0.1), transparent 40%);
    z-index: -1;
}

/* --- ÖNCEKİ SAYFADAKİ ELİTE SIDEBAR --- */
/* Sidebar Genel Konteynırı */
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
.btn-profile{
  background:#06b6d4;
  color:#0f172a;
  padding:10px 25px;
  border-radius:12px;
  font-weight:800;
  text-decoration:none;
  transition:.25s;
  border:1px solid rgba(255,255,255,0.10);
}
.btn-profile:hover{ opacity:.85; transform: translateY(-1px); }
/* MOBİL AYARI */
@media (max-width: 850px) {
    .sidebar { display: none; }
    .main-content, #main-content { margin-left: 260px !important; margin-right: 0 !important; }
}

/* Mobil Ekranlarda Sidebar'ı Gizle (Opsiyonel) */
@media (max-width: 850px) {
    .sidebar {
        display: none;
    }
}


/* MAIN CONTENT - Sidebar genişliğine göre ayarlandı */
.main-content {
    margin-left: var(--sidebar-width);
    width: calc(100% - var(--sidebar-width));
    padding: 0 5% 50px;
    position: relative;
    z-index: 5;
}

header { padding: 25px 0; display: flex; justify-content: flex-end; align-items: center; gap: 20px; }

.welcome-area { padding: 20px 0 50px; }
.welcome-area h2 { font-size: 1.1rem; color: var(--accent); font-weight: 600; margin-bottom: 5px; }
.welcome-area h1 { font-size: 2.4rem; font-weight: 800; }

/* GRID VE KARTLAR */
.level-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    max-width: 1000px;
    margin: 0 auto;
}

.level-card {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--border);
    border-radius: 35px;
    padding: 20px;
    transition: 0.4s;
    backdrop-filter: blur(10px);
}
.level-card:hover { transform: translateY(-8px); border-color: var(--accent); box-shadow: 0 10px 30px rgba(0,0,0,0.3); }

.img-container { width: 100%; height: 200px; border-radius: 25px; overflow: hidden; margin-bottom: 20px; position: relative; }
.img-container img { width: 100%; height: 100%; object-fit: cover; }

.level-tag { position: absolute; top: 15px; right: 15px; background: var(--primary); padding: 5px 12px; border-radius: 12px; font-weight: 800; font-size: 0.8rem; }

.card-body h3 { font-size: 1.4rem; margin-bottom: 10px; }
.card-body p { color: #94a3b8; font-size: 0.9rem; margin-bottom: 25px; line-height: 1.6; height: 50px; overflow: hidden; }

.btn-launch {
    display: block;
    background: linear-gradient(90deg, #1e40af, #0e7490); 
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    padding: 14px;
    border-radius: 18px;
    text-align: center;
    font-weight: 700;
    transition: 0.3s;
    border: 1px solid rgba(255,255,255,0.05);
}
.btn-launch:hover {
    background: linear-gradient(90deg, #1d4ed8, #0891b2);
    color: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.extra-section { padding-top: 80px; max-width: 1000px; margin: 0 auto; }
.content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
.skills-card, .topic-card { background: rgba(255, 255, 255, 0.02); border-radius: 30px; padding: 30px; border: 1px solid var(--border); backdrop-filter: blur(5px); }

.skill-item { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
.skill-icon { width: 45px; height: 45px; border-radius: 12px; background: rgba(37, 99, 235, 0.1); display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: 1.2rem; }
.skill-info h4 { font-size: 0.95rem; color: white; }
.skill-info p { font-size: 0.75rem; color: #94a3b8; }

.topic-item { padding: 15px; background: rgba(255,255,255,0.02); border-radius: 20px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; }
.count-badge { font-size: 0.7rem; background: rgba(6, 182, 212, 0.1); color: var(--accent); padding: 4px 12px; border-radius: 20px; font-weight: 700; }

@media(max-width: 900px) {
    .level-grid, .content-grid { grid-template-columns: 1fr; }
    .main-content { margin-left: 0; width: 100%; }
}
</style>
</head>
<body>

<div class="bg-glow"></div>

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
    <header>
<a href="profil.php" class="btn-profile"><?php echo $userName; ?></a>     </header>

    <section class="welcome-area">
        <h2>Merhaba, <?php echo $userName; ?>! 👋</h2>
        <h1>Bugün hangi maceraya atılıyoruz?</h1>
    </section>

    <div class="level-grid">
        <div class="level-card">
            <div class="img-container">
                <div class="level-tag">A1</div>
                <img src="https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?auto=format&fit=crop&w=800&q=80">
            </div>
            <div class="card-body">
                <h3>📖 Başlangıç</h3>
                <p>En temel kalıplar ve günlük selamlaşmalarla İngilizce dünyasına harika bir giriş yap.</p>
                <a href="video_secme.php" class="btn-launch">Hemen Başla</a>
            </div>
        </div>

        <div class="level-card">
            <div class="img-container">
                <div class="level-tag">A2</div>
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=80">
            </div>
            <div class="card-body">
                <h3>⚔️ Temel Seviye</h3>
                <p>Kendini ifade etmeye başla, basit cümlelerle hayatını anlatma becerisi kazan.</p>
                <a href="video_secme2.php" class="btn-launch">Maceraya Katıl</a>
            </div>
        </div>

        <div class="level-card">
            <div class="img-container">
                <div class="level-tag">B1</div>
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80">
            </div>
            <div class="card-body">
                <h3>💎 Orta Seviye</h3>
                <p>Olayları birbirine bağla, hayallerinden bahset ve akıcılığı yakala.</p>
                <a href="video_secme3.php" class="btn-launch">Pratik Yap</a>
            </div>
        </div>

        <div class="level-card">
            <div class="img-container">
                <div class="level-tag" style="background: #4c1d95;">B2</div>
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=800&q=80">
            </div>
            <div class="card-body">
                <h3>🔥 Üst Orta</h3>
                <p>Karmaşık tartışmalara katıl ve teknik konuları bile rahatça anla.</p>
                <a href="video_secme4.php" class="btn-launch" style="background: linear-gradient(90deg, #4c1d95, #0e7490);">Sınırları Zorla</a>
            </div>
        </div>
    </div>

    <section class="extra-section">
        <div class="content-grid">
            <div class="skills-card">
                <h2 style="font-size: 1.2rem; margin-bottom: 25px; color: var(--accent);">🎯 Yetkinlikler</h2>
                <div class="skill-item">
                    <div class="skill-icon">💬</div>
                    <div class="skill-info">
                        <h4>Doğal Konuşma Refleksi</h4>
                        <p>Düşünmeden, akıcı bir şekilde yanıt verme yetisi.</p>
                    </div>
                </div>
                <div class="skill-item">
                    <div class="skill-icon">🧠</div>
                    <div class="skill-info">
                        <h4>Kelime Haznesi</h4>
                        <p>Günlük hayatta en çok kullanılan modern ifadeler.</p>
                    </div>
                </div>
            </div>

            <div class="topic-card">
                <h2 style="font-size: 1.2rem; margin-bottom: 25px;">Bugünkü Trendler</h2>
                <div class="topic-item">
                    <div class="topic-info">
                        <h4>🚀 Business English</h4>
                        <small>Sunum Teknikleri</small>
                    </div>
                    <div class="count-badge">850 Aktif</div>
                </div>
                <div class="topic-item">
                    <div class="topic-info">
                        <h4>🤖 Future of AI</h4>
                        <small>Yapay Zeka Tartışmaları</small>
                    </div>
                    <div class="count-badge">210 Aktif</div>
                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>