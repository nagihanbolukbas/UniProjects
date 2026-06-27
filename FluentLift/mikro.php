<?php
session_start();
require_once __DIR__ . "/db.php";

if (!isset($_SESSION["user"])) {
    header("Location: profil.php");
    exit;
}
$isLoggedIn = isset($_SESSION['user']);
$userName = $isLoggedIn && isset($_SESSION['user']['name'])
    ? $_SESSION['user']['name']
    : "Kullanıcı";

$user_id = (int)$_SESSION["user"]["id"];
$st = $pdo->prepare("SELECT avatar FROM dbo.users WHERE id = ?");
$st->execute([$user_id]);
$u = $st->fetch(PDO::FETCH_ASSOC);

// Veritabanındaki tam yolu alıyoruz (Örn: avatars/avatar-erkek.png)
$dbAvatarPath = $u['avatar'] ?? '';

// strpos ile metnin içinde "erkek" kelimesi geçiyor mu diye bakıyoruz
if (strpos(strtolower($dbAvatarPath), 'erkek') !== false) {
    $avatarFile = 'avatar-erkek.png';
    $userEmoji = '👨';
} else {
    // İçinde erkek geçmiyorsa veya boşsa kız avatarını varsayılan yapıyoruz
    $avatarFile = 'avatar-kız.png';
    $userEmoji = '👩';
}

try {
    // Sorguyu en güvenli ve temiz haliyle güncelledik
$sql = "SELECT 
            s.[id], 
            s.[title_tr], 
            s.[title_eng], 
            s.[type], 
            s.[bg_url], 
            st.[role], 
            st.[text_eng], 
            st.[text_tr], 
            st.[step_order]
        FROM dbo.scenarios s
        INNER JOIN dbo.scenario_steps st ON s.id = st.scenario_id
        ORDER BY s.id, st.step_order";
            
    $query = $pdo->query($sql);
    
    if (!$query) {
        $error = $pdo->errorInfo();
        die("SQL Hatası: " . $error[2]);
    }

    $rawData = $query->fetchAll(PDO::FETCH_ASSOC);

    $scenarios = [];
    foreach ($rawData as $row) {
        $sId = $row['id'];
        
        if (!isset($scenarios[$sId])) {
            $scenarios[$sId] = [
                'id'       => $sId,
                'title'    => $row['title_tr'] ?? 'Başlıksız',
                'titleEng' => $row['title_eng'] ?? 'Untitled',
                'type'     => $row['type'] ?? 0,
                'bg'       => $row['bg_url'] ?? '', // Burası SQL'deki resmi JS'ye aktarır
                'steps'    => []
            ];
        }
        
        if ($row['role'] !== null) {
            $scenarios[$sId]['steps'][] = [
                'type' => trim($row['role']),
                'q'    => $row['text_eng'] ?? '', 
                'tr'   => $row['text_tr'] ?? '',
                'exp'  => $row['text_eng'] ?? ''
            ];
        }
    }
    
   // Adımı olmayanları temizle ve indisleri (0,1,2...) diye yeniden diz
$finalScenariosJS = array_values(array_filter($scenarios, function($s) {
    return count($s['steps']) > 0; 
}));

} catch (Exception $e) {
    die("Sistem Hatası: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FluentLift | Roleplay</title>
<script src="https://cdn.tailwindcss.com"></script>
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

    /* MAIN */
    .main-content{
      margin-left:var(--sidebar-width);
      width:calc(100% - var(--sidebar-width));
      height:100vh;
      display:flex;
      flex-direction:column;
      overflow-y:auto;  /* ✅ scroll burada */
      min-height:0;     /* ✅ kritik */
    }

    header{
      height:80px;
      padding:0 40px;
      display:flex;
      justify-content:space-between;
      align-items:center;
      border-bottom:1px solid var(--border);
      background:rgba(15,23,42,0.8);
      backdrop-filter:blur(12px);
      position:sticky;top:0;z-index:40;
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
    /* SCENE CONTAINER */
    .scene-container{
      max-width:600px;margin:0 auto;flex:1;
      display:flex;flex-direction:column;width:100%;
      padding:20px;
      min-height:0; /* ✅ kritik */
    }
/* --- CHAT TASARIMI --- */
.scene-container{
    max-width:600px;
    margin:0 auto;
    flex:1;
    display:flex;
    flex-direction:column;
    width:100%;
    padding:20px;
    min-height:0;
    position:relative;
}
.chat-area {
    flex: 1;
    min-height: 0;
    overflow-y: auto;
    padding: 30px;
    display: flex;
    flex-direction: column;
    gap: 18px; /* Balonlar arası ideal boşluk */
    
    background: rgba(15, 23, 42, 0.5); 
    border: 1px solid rgba(255, 255, 255, 0.08); /* Çok ince cam kenarlığı */
    border-radius: 40px; /* Modern oval köşeler */
    
    /* Kutuyu merkeze alan ölçüler */
    width: 95%; 
    max-width: 750px;
    margin: 20px auto; 
    position: relative;
    z-index: 10;
    
    /* Scroll çubuğunu gizle ama kaydırmayı koru */
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.chat-area::-webkit-scrollbar {
    display: none;
}
/* Konuşma Balonlarının Genel Yapısı */
.bubble {
    max-width: 75%; /* Ekranın %75'ini kaplasın, daha fazlası boğar */
    padding: 14px 20px;
    border-radius: 25px; /* Daha modern ve oval köşeler */
    font-size: 0.95rem;
    line-height: 1.5;
    position: relative;
    animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Hafif gölge derinlik katar */
}

/* Türkçe Çeviri Alt Metni */
.bubble .tr {
    display: block;
    font-size: 0.8rem;
    opacity: 0.6;
    margin-top: 5px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding-top: 4px;
    font-style: italic;
}

/* BOT (Sol Taraf) - Beyaz/Temiz Görünüm */
.bot {
    align-self: flex-start;
    background: #ffffff;
    color: #1e293b;
    border-bottom-left-radius: 5px; /* Kuyruk efekti */
}

/* KULLANICI (Sağ Taraf) - İndigo/Gradyan Görünüm */
.me {
    align-self: flex-end;
    background: #06b6d4;
    color: black;
    border-bottom-right-radius: 5px; /* Kuyruk efekti */
}

/* --- ESKİ YERİNDE AMA DEVASA AVATARLAR --- */
.avatar-wrapper {
    position: fixed;
    bottom: 80px; /* Biraz daha aşağı çektik dev boyut için */
    z-index: 5;
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    justify-content: center;
    align-items: center;
}

.avatar-img {
    height: 400px; /* Devasa boyut */
    width: auto;
    transition: 0.4s;
    filter: brightness(0.6) grayscale(0.3);
    object-fit: contain;
}

/* Glow Efekti */
.avatar-wrapper::after {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    z-index: -1;
    transition: 0.4s;
    opacity: 0;
    filter: blur(50px);
}

/* Yerleşimler (Eskisi Gibi) */
#botWrapper { left: 300px; }
#userWrapper { right: -2%; }

/* Aktif Durumlar */
.wrapper-active { 
    transform: scale(1.1) translateY(-10px);
 }
.wrapper-active .avatar-img { 
    filter: brightness(1.1) grayscale(0); 
}

#botWrapper.wrapper-active::after { 
    opacity: 1; background: #06b6d4;
 }
#userWrapper.wrapper-active::after { 
    opacity: 1; background: #06b6d4; 
}

.avatar-error {
     animation: shake-avatar 0.3s ease-in-out; }


/* TÜM ETKİLEŞİM BUTONLARI İÇİN TEK RENK SİSTEMİ */

/* 1. Üst Oklar (Normalde Şeffaf) */
.nav-btn {
    background: transparent !important;
    color: white !important;
    border: none !important;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease !important;
}

/* Ok Hover: Görseldeki gibi yuvarlak ve #06b6d4 */
.nav-btn:hover {
    background: #06b6d4 !important;
    color: #0f172a !important; /* Ok rengi koyulaşır */
    box-shadow: 0 0 20px rgba(6, 182, 212, 0.5) !important;
}

/* 2. Gönder Butonu (Hep #06b6d4) */
#sendBtn {
    background: #06b6d4 !important;
    color: #0f172a !important;
    border: none !important;
    width: 60px;
    height: 56px;
    border-radius: 16px;
    transition: all 0.25s ease !important;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(6, 182, 212, 0.2) !important;
}

#sendBtn:hover {
    opacity: 0.9;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(6, 182, 212, 0.4) !important;
}

/* 3. "Harika İş" Bitiş Butonu */
.finish-overlay button {
    background: #06b6d4 !important;
    color: #0f172a !important;
}
.finish-overlay {
    position: absolute; /* chat-area'nın içinde sabitlenir */
    inset: 0;
    background: rgba(15, 23, 42, 0.95); /* Arkadaki yazıları hafif kapatır */
    z-index: 50;
    border-radius: 40px; /* Orta kutuyla aynı oval köşeler */
    display: none; /* Başlangıçta gizli */
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    backdrop-filter: blur(8px); /* Arkadaki chat'i bulanıklaştırır, çok elit durur */
}

.finish-overlay.show {
    display: flex;
    animation: fadeIn 0.4s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
.finish-overlay {
    position: absolute; /* chat-area'nın içinde sabitlenir */
    inset: 0;
    background: rgba(15, 23, 42, 0.95); /* Arkadaki yazıları hafif kapatır */
    z-index: 50;
    border-radius: 40px; /* Orta kutuyla aynı oval köşeler */
    display: none; /* Başlangıçta gizli */
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    backdrop-filter: blur(8px); /* Arkadaki chat'i bulanıklaştırır, çok elit durur */
}

.finish-overlay.show {
    display: flex;
    animation: fadeIn 0.4s ease forwards;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
/* Kalp Efekti */
@keyframes heart-burst { 
    0% { transform: translateY(0) scale(0) rotate(0deg); opacity: 0; } 
    50% { opacity: 1; } 
    100% { transform: translateY(-150px) scale(1.8) rotate(20deg); opacity: 0; } 
}

.heart-pop { 
    position: absolute; 
    top: 0; 
    left: 40%; 
    color: #ff4d4d; /* Canlı kırmızı */
    font-size: 2.5rem; 
    pointer-events: none; 
    animation: heart-burst 1s ease-out forwards; 
    z-index: 20; 
    text-shadow: 0 0 15px rgba(255, 77, 77, 0.6); 
}
#userInput {
     background: #1e293b; 
     border: 1px solid rgba(255, 255, 255, 0.1); 
     color: white; cursor: default; 
    }
.word-btn { 
    transition: all 0.2s ease; 
    cursor:pointer; 
    background: #0f172a; 
    border: 1px solid rgba(255, 255, 255, 0.1); 
    color: white; 
    padding: 10px 16px;
    border-radius: 14px; 
    font-weight: 600; 
    font-size: 0.9rem; 
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); 
}
.word-btn:hover { 
    background: #21335c; 
    transform: translateY(-2px); 
    box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);

}

@keyframes pop{from{opacity:0;transform:translateY(10px) scale(0.9)}to{opacity:1;transform:translateY(0) scale(1)}}
.finish-overlay{position:absolute;inset:0;background:rgba(30,41,59,0.98);z-index:20;border-radius:28px;display:none;flex-direction:column;align-items:center;justify-content:center;}
.finish-overlay.show{display:flex;animation:fadeIn 0.3s ease}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
</style>
</head>
<body>
<nav class="sidebar">
    <div class="logo">🌍 FluentLift</div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="anasayfa2.php" class="nav-link "><span>🏠</span> <b>Öğren</b></a></li>
        <li class="nav-item"><a href="profil.php" class="nav-link"><span>👤</span> <b>Profil</b></a></li>
        <li class="nav-item"><a href="seviye_belirle.php" class="nav-link"><span>📺</span> <b>İzle</b></a></li>
        <li class="nav-item"><a href="kelimeler.php" class="nav-link"><span>📚</span> <b>Sözlük</b></a></li>
        <li class="nav-item"><a href="nova/index.php" class="nav-link"><span>✨</span> <b>Nova İle Konuş</b></a></li>
        <li class="nav-item"><a href="mikro.php" class="nav-link active"> <span>🌟</span> <b>Gerçek Hayat</b></a></li>
        <li class="nav-item"><a href="ayarlar.php" class="nav-link"><span>⚙️</span> <b>Ayarlar</b></a></li>
    </ul>
</nav>

<div id="botWrapper" class="avatar-wrapper">
    <img src="avatars/mikro-adam.png" class="avatar-img" alt="Bot">
</div>
<div id="userWrapper" class="avatar-wrapper">
    <img src="avatars/<?php echo $avatarFile; ?>" class="avatar-img" alt="User">
</div>

<div class="main-content">
<header class="h-28 px-10 flex justify-between items-center border-b border-white/10 bg-slate-900/80 backdrop-blur-md sticky top-0 z-40">
    
    <div class="flex-1">
        <h1 class="text-white text-base font-bold uppercase tracking-widest opacity-80">
</h1>
    </div>
    

    <div class="flex-[2] flex flex-col items-center gap-2">
        <div class="flex items-center gap-6">
          <button onclick="prevScenario()" class="nav-btn">
             <i class="fas fa-chevron-left"></i>
            </button>
            <div class="flex flex-col items-center min-w-[180px]">
                <div id="sTitleEng" class="font-black text-xl text-white tracking-tight leading-none uppercase">
                    LOADING...
                </div>
                <div id="sTitleTr" class="font-medium text-xs text-slate-500 italic mt-1 uppercase tracking-wide">
                    Yükleniyor...
                </div>
            </div>
            
            <button onclick="nextScenario()" class="nav-btn">
                 <i class="fas fa-chevron-right"></i>
                    </button>
        </div>
    </div>

    <div class="flex-1 flex items-center justify-end gap-6">
        <div class="hidden md:flex flex-col items-end">
            <span class="text-[9px] font-bold text-slate-500 uppercase">Progress</span>
           <div class="bg-[#06b6d4]/10 px-3 py-0.5 rounded-md border border-[#06b6d4]/20 text-[#06b6d4] font-black text-xs" id="prog">
    1/50
</div>
        </div>
<a href="profil.php" class="btn-profile"><?php echo $userName; ?></a>    </div>
</header>

<main class="scene-container">
<div id="chatWrap" class="chat-area no-scrollbar"></div>
<div class="input-wrapper">
<div id="finishOverlay" class="finish-overlay">
    <div class="mb-4 text-indigo-400">
        <i class="fas fa-check-circle text-5xl"></i>
    </div>
    <h2 class="text-2xl font-black text-white mb-2 tracking-tight">HARİKA İŞ!</h2>
    <p class="text-slate-400 text-sm mb-6">Bu senaryoyu başarıyla tamamladın.</p>
    
 <button onclick="nextS()" class="bg-[#06b6d4] hover:bg-[#0891b2] text-white font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center mx-auto mt-4">
    SIRADAKİ SENARYO <i class="fas fa-arrow-right ml-2"></i>
</button>
</div>

  <div id="hints" class="flex flex-wrap gap-2 mb-3 p-1 no-scrollbar justify-center"></div>
  <div class="flex gap-3">
    <input type="text" id="userInput" readonly onclick="undoLastWord()" placeholder="Kelimelere tıklayarak cümleyi kurun..." class="w-full p-4 rounded-2xl outline-none text-white text-sm cursor-pointer hover:bg-slate-800/50 transition-all">
    <button id="clearBtn" onclick="clearInput()" class="w-14 bg-slate-700 hover:bg-slate-600 text-white rounded-2xl transition-colors flex items-center justify-center"><i class="fas fa-undo"></i></button>
    <button id="sendBtn" onclick="processInput()" class="w-14 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl transition-colors shadow-lg active:scale-95 flex items-center justify-center"><i class="fas fa-paper-plane"></i></button>
  </div>
</div>
</main>
</div>
<script>
// 1. DEĞİŞKENLER VE VERİ AKTARIMI
var finalScenarios = <?php echo json_encode($finalScenariosJS, JSON_UNESCAPED_UNICODE); ?> || [];

let sIndex = 0;      
let stepIndex = 0;   
let isTyping = false; 

// 2. YARDIMCI FONKSİYONLAR
function updateBackground(url) {
    const defaultImg = "https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80";
    const finalUrl = (url && url.length > 5) ? url : defaultImg;
    document.body.style.backgroundImage = `linear-gradient(rgba(15,23,42,0.9), rgba(15,23,42,0.9)), url('${finalUrl}')`;
    document.body.style.backgroundSize = "cover";
    document.body.style.backgroundPosition = "center";
}

function setTurn(turn) {
    const botWrapper = document.getElementById("botWrapper");
    const userWrapper = document.getElementById("userWrapper");
    if (!botWrapper || !userWrapper) return;

    botWrapper.classList.remove("wrapper-active");
    userWrapper.classList.remove("wrapper-active");

    if (turn === "bot") botWrapper.classList.add("wrapper-active");
    else if(turn === "user") userWrapper.classList.add("wrapper-active");
}

function pushChat(role, text, tr = "") {
    const wrap = document.getElementById("chatWrap");
    if (!wrap) return;
    const div = document.createElement("div");
    div.className = `bubble ${role === "bot" ? "bot" : "me"}`;
    div.innerHTML = `<div>${text}</div>${tr ? `<div class="tr">${tr}</div>` : ""}`;
    wrap.appendChild(div);
    wrap.scrollTo({ top: wrap.scrollHeight, behavior: 'smooth' });
}

function shuffle(array) { return array.sort(() => Math.random() - 0.5); }

// 3. ANA AKIŞ (STARTFLOW)
function startFlow() {
    if (finalScenarios.length === 0) return;
    
    const sc = finalScenarios[sIndex];
    if (!sc) return;

    // KRİTİK: Eğer senaryodaki tüm adımlar bittiyse bitiş ekranını aç
    if (stepIndex >= sc.steps.length) {
        finishConversation();
        return;
    }

    const step = sc.steps[stepIndex];

    // Arayüzü Güncelle
    document.getElementById("sTitleEng").innerText = sc.titleEng || "UNTITLED";
    document.getElementById("sTitleTr").innerText = sc.title || "BAŞLIKSIZ";
    document.getElementById("prog").innerText = `${sIndex + 1} / ${finalScenarios.length}`;

    if (stepIndex === 0) updateBackground(sc.bg);

    if (step.type === "bot") {
        if (isTyping) return;
        setTurn("bot");
        isTyping = true;
        setTimeout(() => {
            pushChat("bot", step.q, step.tr); 
            stepIndex++;
            isTyping = false;
            startFlow(); // Bir sonraki adıma (muhtemelen kullanıcıya) geç
        }, 1200);
    } else {
        setTurn("user");
        renderHints(step.exp || "");
    }
}

function renderHints(sentence) {
    const hintsDiv = document.getElementById("hints");
    if(!hintsDiv) return;
    const words = sentence.split(' ');
    const shuffled = shuffle([...words]);
    hintsDiv.innerHTML = "";
    shuffled.forEach(w => {
        const btn = document.createElement("button");
        btn.className = "word-btn";
        btn.innerText = w;
        btn.onclick = () => addWord(w, btn);
        hintsDiv.appendChild(btn);
    });
}

function addWord(word, btnElement) {
    const input = document.getElementById("userInput");
    input.value += (input.value ? " " : "") + word;
    btnElement.style.opacity = "0";
    btnElement.style.pointerEvents = "none";
    btnElement.style.transform = "scale(0.8)";
}

function processInput() {
    if (isTyping) return;
    const input = document.getElementById("userInput");
    const val = input.value.trim();
    const sc = finalScenarios[sIndex];
    const step = sc.steps[stepIndex];

    if (val.toLowerCase() === step.exp.toLowerCase()) { 
        spawnHeart(); // Senin o meşhur efektin
        pushChat("me", val);
        input.value = "";
        stepIndex++;
        setTimeout(startFlow, 800);
    } else {
        const userAvatar = document.getElementById("userWrapper");
        userAvatar.classList.add('avatar-error');
        setTimeout(() => userAvatar.classList.remove('avatar-error'), 300);
        clearInput(); // Hatalıysa kelimeleri geri yükle
    }
}

// 4. BİTİŞ VE NAVİGASYON
function finishConversation() {
    setTurn("none");
    const overlay = document.getElementById("finishOverlay");
    
    if (overlay) {
        // Butonun görünmesi için gerekli CSS sınıflarını ve stili zorla
        overlay.style.setProperty("display", "flex", "important"); 
        
        // Eğer Tailwind kullanıyorsan opacity için:
        setTimeout(() => {
            overlay.classList.add("show");
            overlay.style.opacity = "1";
        }, 50);
    }
}

function nextS() {
    sIndex = (sIndex + 1) % finalScenarios.length;
    resetScene();
}

function resetScene() {
    stepIndex = 0;
    isTyping = false;
    document.getElementById("chatWrap").innerHTML = "";
    document.getElementById("hints").innerHTML = "";
    document.getElementById("userInput").value = "";
    const overlay = document.getElementById("finishOverlay");
    if(overlay) {
        overlay.classList.remove("show");
        overlay.style.display = "none";
    }
    startFlow();
}

function clearInput() {
    document.getElementById("userInput").value = "";
    const sc = finalScenarios[sIndex];
    if (sc && sc.steps[stepIndex]) renderHints(sc.steps[stepIndex].exp);
}

// Input içindeki son kelimeyi siler ve butonunu geri getirir
function undoLastWord() {
    const input = document.getElementById("userInput");
    let words = input.value.trim().split(" ");
    
    if (words.length > 0 && words[0] !== "") {
        const lastWord = words.pop(); // Son kelimeyi al
        input.value = words.join(" "); // Kalanları geri yaz
        
        // Gizlenen butonu bul ve geri getir
        const hints = document.querySelectorAll(".word-btn");
        hints.forEach(btn => {
            if (btn.innerText === lastWord && btn.style.opacity === "0") {
                btn.style.opacity = "1";
                btn.style.pointerEvents = "auto";
                btn.style.transform = "scale(1)";
            }
        });
    }
}

function nextScenario() { sIndex = (sIndex + 1) % finalScenarios.length; resetScene(); }
function prevScenario() { sIndex = (sIndex - 1 + finalScenarios.length) % finalScenarios.length; resetScene(); }

// BAŞLATICI
window.addEventListener('DOMContentLoaded', () => {
    if (finalScenarios.length > 0) startFlow();
});

// Senin o güzel efektin için spawnHeart eksik kalmasın:
function spawnHeart() {
    const chatWrap = document.getElementById("chatWrap");
    const heart = document.createElement("div");
    heart.className = "heart-pop";
    heart.innerHTML = "❤️";
    chatWrap.appendChild(heart);
    setTimeout(() => heart.remove(), 1000);
}
</script>
