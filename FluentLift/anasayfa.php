<?php 
session_start();
$isLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FluentLift | Galaksiler Arası İngilizce</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* --- DEĞİŞKENLER VE TEMEL --- */
        :root {
            --primary: #2563eb;
            --accent: #38bdf8;
            --dark-blue: #0f172a;
            --space-black: #050810;
            --gray: #94a3b8;
            --white: #ffffff;
            --completed: #ffb400;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background: radial-gradient(circle at top, #0f172a 0%, #050810 100%);
            color: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* --- ANIMASYONLAR --- */
        @keyframes drift {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(56, 189, 248, 0.3); }
            50% { box-shadow: 0 0 40px rgba(56, 189, 248, 0.6); }
        }

        @keyframes bg-flow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* --- DEKORATİF OBJELER --- */
        .decoration {
            position: absolute;
            font-size: 3rem;
            opacity: 0.6;
            z-index: 1;
            pointer-events: none;
            animation: drift 6s infinite ease-in-out;
        }

        /* --- HEADER --- */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background: rgba(5, 8, 16, 0.8);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--accent);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* --- BUTONLAR --- */
        .btn {
            padding: 14px 30px;
            border-radius: 18px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        }

        .btn-primary:hover {
            transform: scale(1.05) translateY(-3px);
            box-shadow: 0 15px 30px rgba(37, 99, 235, 0.6);
        }

        .btn-outline {
            border: 2px solid rgba(255, 255, 255, 0.1);
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-outline:hover {
            background: white;
            color: var(--dark-blue);
        }

        /* --- HERO SECTION --- */
        .hero {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            padding: 0 5%;
        }

        .hero h1 {
            font-size: clamp(2.8rem, 8vw, 5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 25px;
            background: linear-gradient(to bottom, #fff 40%, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--gray);
            max-width: 700px;
            margin-bottom: 40px;
        }

        /* --- PATH PREVIEW (YOL HARİTASI) --- */
        .path-preview {
            padding: 100px 5%;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .node-line {
            width: 4px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            margin: 10px 0;
        }

        .node-circle {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            background: #e2e8f0;
            box-shadow: 0 8px 0 #cbd5e1;
            position: relative;
            transition: 0.3s;
        }

        .node-circle.active {
            background: linear-gradient(145deg, var(--primary), var(--accent));
            box-shadow: 0 8px 0 #1e40af;
            animation: float 3s infinite ease-in-out, pulse-glow 3s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* --- FEATURES (KARTLAR) --- */
        .features {
            padding: 100px 5%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 30px;
            transition: 0.4s;
            backdrop-filter: blur(10px);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--accent);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        /* --- FOOTER --- */
        footer {
            padding: 80px 5% 40px;
            text-align: center;
            background: var(--space-black);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* --- MOBİL UYUM --- */
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .decoration { display: none; }
        }
    </style>
</head>
<body>

    <div class="decoration" style="top: 15%; left: 8%;">🚀</div>
    <div class="decoration" style="top: 25%; right: 10%; animation-delay: 1s;">🪐</div>
    <div class="decoration" style="top: 60%; left: 12%; animation-delay: 2s;">👨‍🚀</div>
    <div class="decoration" style="top: 80%; right: 15%; animation-delay: 1.5s;">🛸</div>
    <div class="decoration" style="top: 45%; left: 5%; font-size: 1.5rem; opacity: 0.3;">✨</div>
    <div class="decoration" style="top: 10%; right: 20%; font-size: 1.5rem; opacity: 0.3;">✨</div>

<header>
    <a href="#" class="logo">🌍 FluentLift</a>

    <!-- Giriş yapmış olsa bile butonlar her zaman görünsün -->
    <div style="display:flex; gap:15px; align-items:center;">
        <a href="Kayıt.php" class="btn btn-outline">
            Giriş Yap
        </a>

        <a href="Kayıt.php" class="btn btn-primary">
            Kayıt Ol
        </a>
    </div>
</header>

    <section class="hero">
        <h1>İngilizceyi <br> Konuşarak Fethet</h1>
        <p>Klasik kursları kara deliğe fırlat. Yapay zeka destekli FluentLift ile galaksiler arası bir maceraya atıl ve akıcı konuşmaya bugün başla.</p>
        <div style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center;">
            <a href="Kayıt.php" class="btn btn-primary">🚀 Hemen Başla - Ücretsiz</a>
            <a href="#how" class="btn btn-outline">Nasıl Çalışır?</a>
        </div>
    </section>

    <section class="path-preview" id="how">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 2.5rem; margin-bottom: 10px;">Öğrenme Yolun</h2>
            <p style="color: var(--gray);">Tıpkı bir oyun gibi seviye atla, yıldızları topla.</p>
        </div>

        <div class="node-circle" style="background: linear-gradient(145deg, #ffb400, #ff8c00); box-shadow: 0 8px 0 #b36200;">⭐</div>
        <div class="node-line"></div>
        
        <div class="node-circle active">⭐</div>
        <div style="margin: 15px 0; color: var(--accent); font-weight: 800;">ŞU AN BURADASIN</div>
        <div class="node-line"></div>
        
        <div class="node-circle">🏆</div>
        
        <div style="margin-top: 40px; text-align: center; max-width: 500px; color: var(--gray);">
            Üniteleri tamamladıkça yeni gezegenlerin (konuların) kilidini açarsın. Her ünite sonunda seni bir ödül bekliyor!
        </div>
    </section>

    <section class="features">
        <div class="feature-card">
            <span class="feature-icon">🤖</span>
            <h3>AI Partner: Nova</h3>
            <p style="color: var(--gray); margin-top: 15px;">Hata yapmaktan korkma! Nova seni dinler, anlar ve sadece senin seviyene göre konuşur.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">⚡</span>
            <h3>Işık Hızında Analiz</h3>
            <p style="color: var(--gray); margin-top: 15px;">Telaffuzunu anında analiz ederiz. Hangi kelimeyi nasıl söylemen gerektiğini hemen öğrenirsin.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">🎮</span>
            <h3>Oyunlaştırılmış Deneyim</h3>
            <p style="color: var(--gray); margin-top: 15px;">XP kazan, seviye atla ve arkadaşlarınla rekabet et. Dil öğrenmek hiç bu kadar eğlenceli olmamıştı.</p>
        </div>
    </section>

    <footer>
        <div class="logo" style="justify-content: center; margin-bottom: 25px;">🌍 FluentLift</div>
        <p style="color: var(--gray); max-width: 600px; margin: 0 auto 30px;">
            Dil öğrenme korkusunu galaksinin dışına itiyoruz. Milyonlarca kelime değil, binlerce cümle kurmanı sağlıyoruz.
        </p>
        <div style="border-top: 1px solid rgba(255,255,255,0.05); padding-top: 30px; color: #4b5563; font-size: 0.9rem;">
            © 2026 FluentLift Space Labs. Tüm hakları saklıdır.
        </div>
    </footer>

    <script>
        // Opsiyonel: Scroll yapıldığında dekorasyonları hareket ettir (Parallax)
        window.addEventListener('scroll', function() {
            const scroll = window.pageYOffset;
            const decorations = document.querySelectorAll('.decoration');
            decorations.forEach((item, index) => {
                const speed = (index + 1) * 0.2;
                item.style.transform = `translateY(${scroll * speed}px) rotate(${scroll * 0.05}deg)`;
            });
        });
    </script>
</body>
</html>