<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FluentLift | Nova AI Coach</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- MEVCUT RENK PALETİ --- */
        :root {
            --primary: #2563eb;
            --accent: #38bdf8;
            --dark-blue: #0f172a;
            --space-black: #050810;
            --panel: rgba(30, 41, 59, 0.7);
            --user-msg: linear-gradient(135deg, #2563eb, #38bdf8);
            --nova-msg: rgba(255, 255, 255, 0.05);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: rgba(255, 255, 255, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f172a 0%, #050810 100%);
            color: var(--text-primary);
            margin: 0;
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        /* --- DEKORASYONLAR --- */
        .decoration { 
            position: absolute; font-size: 2.5rem; opacity: 0.4; 
            user-select: none; pointer-events: none; animation: drift 5s infinite ease-in-out; 
            z-index: 0;
        }
        @keyframes drift { 
            0%, 100% { transform: translateY(0) rotate(0deg); } 
            50% { transform: translateY(-20px) rotate(10deg); } 
        }

        /* --- SIDEBAR --- */
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

        /* --- CHAT ALANI --- */
        #main-content {
            margin-left: 260px; flex: 1; display: flex;
            justify-content: center; align-items: center;
            height: 100vh; position: relative; z-index: 1;
        }

        #chat-container {
            width: 90%; max-width: 800px; height: 85vh;
            background: var(--panel); border-radius: 30px;
            display: flex; flex-direction: column; overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(20px);
        }

        header {
            padding: 20px; text-align: center;
            border-bottom: 1px solid var(--border);
            background: rgba(15, 23, 42, 0.5);
        }

        .avatar-wrapper { position: relative; display: inline-block; margin-bottom: 5px; }
        .avatar {
            width: 60px; height: 60px; border-radius: 50%;
            border: 2px solid var(--accent); padding: 4px;
            background: var(--dark-blue); animation: pulse-border 2s infinite;
        }

        @keyframes pulse-border {
            0% { box-shadow: 0 0 0 0px rgba(56, 189, 248, 0.4); }
            100% { box-shadow: 0 0 0 15px rgba(56, 189, 248, 0); }
        }

        .title { font-family: 'Fredoka', sans-serif; font-size: 1.3rem; font-weight: 700; color: white; }
        .subtitle { font-size: 0.75rem; color: var(--accent); font-weight: 600; text-transform: uppercase; }

        /* --- MESAJ BALONLARI VE ALTYAZI --- */
        #chat-window {
            flex: 1; padding: 25px; overflow-y: auto;
            display: flex; flex-direction: column; gap: 20px;
            scrollbar-width: thin; scrollbar-color: var(--accent) transparent;
        }

        .message {
            max-width: 80%; padding: 14px 20px; border-radius: 20px;
            font-size: 0.95rem; line-height: 1.5; position: relative;
            display: flex; flex-direction: column; /* İçeriği dikey sırala */
            animation: slideUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* ALTYAZI STİLİ: Hafif saydam ve altta */
        .translation {
            display: block;
            font-size: 0.82rem;
            opacity: 0.6; /* Hafif saydamlık */
            margin-top: 8px;
            padding-top: 6px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-style: italic;
        }

        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .nova {
            align-self: flex-start; background: var(--nova-msg);
            color: var(--text-primary); border-bottom-left-radius: 4px;
            border: 1px solid var(--border);
        }

        .user {
            align-self: flex-end; background: var(--user-msg);
            color: white; border-bottom-right-radius: 4px;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }

        /* --- INPUT ALANI --- */
        .input-area {
            padding: 20px; display: flex; gap: 12px;
            background: rgba(15, 23, 42, 0.6); border-top: 1px solid var(--border);
        }

        input {
            flex: 1; background: #0f172a; border: 1px solid var(--border);
            padding: 15px 20px; border-radius: 15px; color: white;
            outline: none; transition: 0.3s; font-size: 0.95rem;
        }

        input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); }

        .btn {
            width: 50px; height: 50px; border-radius: 15px;
            border: none; cursor: pointer; display: flex;
            justify-content: center; align-items: center;
            font-size: 1.1rem; transition: 0.3s;
        }

        .mic-btn { background: #10b981; color: white; }
        .send-btn { background: var(--primary); color: white; }
        .btn:hover { transform: scale(1.05); opacity: 0.9; }

        @media (max-width: 850px) {
            .sidebar { display: none; }
            #main-content { margin-left: 0; }
            #chat-container { width: 100%; height: 100vh; border-radius: 0; }
        }
    </style>
</head>
<body>

<div class="decoration" style="top: 10%; left: 22%;">🚀</div>
<div class="decoration" style="top: 30%; right: 5%; animation-delay: 1s;">🪐</div>
<div class="decoration" style="bottom: 15%; left: 20%; animation-delay: 2s;">👨‍🚀</div>

<nav class="sidebar">
    <div class="logo">🌍 FluentLift</div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="../anasayfa2.php" class="nav-link"><span>🏠</span> <b>Öğren</b></a></li>
        <li class="nav-item"><a href="../profil.php" class="nav-link"><span>👤</span> <b>Profil</b></a></li>
        <li class="nav-item"><a href="../seviye_belirle.php" class="nav-link"><span>📺</span> <b>İzle</b></a></li>
        <li class="nav-item"><a href="../kelimeler.php" class="nav-link"><span>📚</span> <b>Sözlük</b></a></li>
        <li class="nav-item"><a href="nova/index.php" class="nav-link active"><span>✨</span> <b>Nova İle Konuş</b></a></li>
        <li class="nav-item"><a href="../mikro.php" class="nav-link"> <span>🌟</span> <b>Gerçek Hayat</b></a></li>
        <li class="nav-item"><a href="../ayarlar.php" class="nav-link"><span>⚙️</span> <b>Ayarlar</b></a></li>
    </ul>
</nav>

<main id="main-content">
    <div id="chat-container">
        <header>
            <div class="avatar-wrapper">
                <img src="https://cdn-icons-png.flaticon.com/512/4712/4712035.png" alt="Nova AI" class="avatar">
            </div>
            <div class="title">Nova Coach</div>
            <div class="subtitle">Uzay Çağı Dil Asistanı</div>
        </header>
        
        <div id="chat-window">
            <div class="message nova">
                Hello! I'm Nova. I'm here to help you practice your English. How are you feeling today?
                <span class="translation">Merhaba! Ben Nova. İngilizce pratiği yapmana yardım etmek için buradayım. Bugün nasıl hissediyorsun?</span>
            </div>
        </div>
        
        <div class="input-area">
            <button id="mic-btn" class="btn mic-btn" title="Speak"><i class="fas fa-microphone"></i></button>
            <input type="text" id="user-input" placeholder="Nova'ya bir şeyler söyleyin...">
            <button id="send-btn" class="btn send-btn"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
</main>
<script src="nova.js"></script>
</body>
</html>