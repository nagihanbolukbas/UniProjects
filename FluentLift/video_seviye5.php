<?php
session_start();
$isLoggedIn = isset($_SESSION['user']);
$userName = $isLoggedIn ? $_SESSION['user']['name'] : "Maceracı";

$videoSource = "https://www.youtube.com/embed/svBiTnb6-QM?start=124&autoplay=1&mute=0";
$currentLevel = "A1"; 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FluentLift — Video Pratik</title>
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
/* MAIN CONTENT */
.main-content { 
    margin-left: var(--sidebar-width); 
    width: calc(100% - var(--sidebar-width)); 
    padding: 0 4% 50px; 
    position: relative;
    z-index: 5;
}

header { padding: 25px 0; display: flex; justify-content: space-between; align-items: center; }
.user-stats-wrapper { display: flex; align-items: center; gap: 20px; }
.user-stats {
    display: flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.03);
    padding: 8px 20px; border-radius: 15px; border: 1px solid var(--border);
}
.btn-profile { background: var(--accent); color: var(--bg-dark); padding: 10px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; font-size: 0.9rem; transition: 0.3s; }
.btn-profile:hover { opacity: 0.8; transform: translateY(-2px); }

/* LAYOUT */
.content-layout { display: grid; grid-template-columns: 1.6fr 1fr; gap: 30px; margin-top: 20px; }

/* VİDEO BÖLÜMÜ */
.video-area { display: flex; flex-direction: column; gap: 20px; }
.video-container {
    background: #000; border-radius: 30px; overflow: hidden; aspect-ratio: 16 / 9;
    border: 1px solid var(--border); box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}
.video-container iframe { width: 100%; height: 100%; border: none; }

/* KELİME KARTLARI */
.vocab-section { display: flex; gap: 15px; margin-top: 10px; }
.vocab-card {
    background: rgba(255,255,255,0.02); border: 1px solid var(--border);
    padding: 15px; border-radius: 20px; flex: 1; transition: 0.3s;
}
.vocab-card:hover { background: rgba(255,255,255,0.05); border-color: var(--accent); }
.vocab-card b { color: var(--accent); display: block; font-size: 0.9rem; }
.vocab-card span { font-size: 0.75rem; color: #94a3b8; }

/* SORU KARTI */
.quiz-card {
    background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px);
    border-radius: 30px; padding: 30px; border: 1px solid var(--border); height: fit-content;
}
.option-btn {
    background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); width: 100%;
    padding: 16px 20px; border-radius: 18px; color: #f1f5f9; text-align: left;
    cursor: pointer; transition: 0.3s; margin-bottom: 12px;
}
.option-btn:hover { background: rgba(6, 182, 212, 0.08); border-color: var(--accent); transform: translateX(5px); }
.option-btn.wrong { border-color: #ff6b6b; background: rgba(255, 107, 107, 0.1); }
.option-btn.correct { border-color: #22c55e; background: rgba(34, 197, 94, 0.15); box-shadow: 0 0 15px rgba(34, 197, 94, 0.2); }

/* İPUCU KUTUSU */
#hint-box {
    margin-top: 20px; background: rgba(255, 100, 100, 0.05); padding: 20px;
    border-radius: 25px; border: 1px solid rgba(255, 100, 100, 0.2);
    display: none; animation: slideUp 0.4s ease;
}

/* NAVİGASYON BUTONLARI */
.action-footer {
    display: flex; justify-content: space-between; margin-top: 40px; 
    padding-top: 20px; border-top: 1px solid var(--border);
}
.btn-nav {
    background: rgba(255, 255, 255, 0.03); color: #cbd5e1; padding: 12px 30px;
    border-radius: 18px; text-decoration: none; font-weight: 600; transition: 0.3s;
    border: 1px solid var(--border); display: flex; align-items: center; gap: 10px;
}
.btn-nav:hover { background: rgba(6, 182, 212, 0.1); border-color: var(--accent); color: var(--accent); transform: translateY(-2px); }

@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

@media(max-width: 1100px) { .content-layout { grid-template-columns: 1fr; } .sidebar { display: none; } .main-content { margin-left: 0; width: 100%; } }
</style>
</head>
<body>

<div class="bg-glow"></div>

<aside class="sidebar">
    <div class="logo">🌍 FluentLift</div>
    
    <ul class="nav-menu">
        <li class="nav-item"><a href="anasayfa2.php" class="nav-link"><span>🏠</span> <b>Öğren</b></a></li>
        <li class="nav-item"><a href="profil.php" class="nav-link"><span>👤</span> <b>Profil</b></a></li>
        <li class="nav-item"><a href="seviye_belirle.php" class="nav-link active"><span>📺</span> <b>İzle</b></a></li>
        <li class="nav-item"><a href="kelimeler.php" class="nav-link "><span>📚</span> <b>Sözlük</b></a></li>
        <li class="nav-item"><a href="nova/index.php" class="nav-link"><span>✨</span> <b>Nova</b></a></li>
        <li class="nav-item"><a href="mikro.php" class="nav-link"><span>🌟</span> <b>Gerçek Hayat</b></a></li>
        <li class="nav-item"><a href="ayarlar.php" class="nav-link"><span>⚙️</span> <b>Ayarlar</b></a></li>
    </ul>
</aside>

<main class="main-content">
    <header>
        <div style="color: #94a3b8; font-size: 0.9rem;">Pratik Yap / <span style="color: var(--accent);">Diyaloglar</span></div>
        <div class="user-stats-wrapper">
            <div class="user-stats">
                <span style="color: #94a3b8; font-size: 0.85rem;">Seviye: <b style="color:var(--accent)"><?php echo $currentLevel; ?></b></span>
            </div>
<a href="profil.php" class="btn-profile"><?php echo $userName; ?></a>        </div>
    </header>
   <section class="content-layout">
    <div class="video-area">
        <div class="video-container">
            <iframe
                src="<?php echo $videoSource; ?>"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>
        </div>

        <div class="vocab-section">
            <div class="vocab-card">
                <b>Think</b>
                <span>Sanırım</span>
            </div>
            <div class="vocab-card">
                <b>Size</b>
                <span>Beden</span>
            </div>
            <div class="vocab-card">
                <b>Need</b>
                <span>İhtiyaç</span>
            </div>
        </div>
    </div>

    <div class="quiz-card">
        <h3 style="color:var(--accent); margin-bottom:10px;">🎯 Soru</h3>

        <p style="font-size: 0.95rem; margin-bottom: 20px; line-height: 1.6;">
            Anna kendisine hangi bedenin olacağını düşünüyor?
        </p>

        <div class="options-group">
            <button class="option-btn" onclick="handleChoice(this, false)">
                A) XSmall
            </button>

            <button class="option-btn" onclick="handleChoice(this, false)">
                B) Large
            </button>

            <button class="option-btn" onclick="handleChoice(this, true)">
                C) Medium
            </button>

            <button class="option-btn" onclick="handleChoice(this, false)">
                D) XXLarge
            </button>
        </div>

        <div id="hint-box">
            <h4 style="color: #ff6b6b; margin-bottom: 5px; font-size: 0.9rem;">
                💡 İpucu
            </h4>
            <p style="font-size: 0.85rem; color: #cbd5e1;">
                Videoda <b>I need a medium</b> kelimesine dikkat et.
            </p>
        </div>
    </div>
</section>

<footer class="action-footer">
    <a href="video_seviye4.php" class="btn-nav">⬅️ Önceki</a>
    <a href="video_seviye6.php" class="btn-nav">Sonraki ➡️</a>
</footer>

<script>
function handleChoice(btn, isCorrect) {
    const hintBox = document.getElementById('hint-box');
    const allBtns = document.querySelectorAll('.option-btn');
    const nextButton = document.querySelector('.action-footer .btn-nav:last-child');

    // Tüm butonlardan renkleri temizle
    allBtns.forEach(b => {
        b.classList.remove('wrong', 'correct');
    });

    if (isCorrect) {
        // Doğru cevap
        btn.classList.add('correct');
        hintBox.style.display = 'none';

        // Tüm seçenekleri devre dışı bırak
        allBtns.forEach(b => b.disabled = true);

        // Sonraki butonunu aktif et
        if (nextButton) {
            nextButton.style.pointerEvents = 'auto';
            nextButton.style.opacity = '1';
        }
    } else {
        // Yanlış cevap
        btn.classList.add('wrong');
        hintBox.style.display = 'block';

        // 1.5 saniye sonra kırmızı rengi kaldır
        setTimeout(() => {
            btn.classList.remove('wrong');
        }, 1500);

        // Doğru cevabı gösterme, diğer butonlar aktif kalır
    }
}

// Sayfa açıldığında Sonraki butonunu pasif yap
window.onload = function () {
    const nextButton = document.querySelector('.action-footer .btn-nav:last-child');

    if (nextButton) {
        nextButton.style.pointerEvents = 'none';
        nextButton.style.opacity = '0.5';
    }
};
</script>
