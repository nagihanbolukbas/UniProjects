<?php
session_start();
require_once __DIR__ . "/db.php"; 

/* ✅ Giriş kontrolü */
if (!isset($_SESSION["user"])) {
    header("Location: anasayfa2.php"); 
    exit;
}
$isLoggedIn = isset($_SESSION['user']);
$userName = $isLoggedIn && isset($_SESSION['user']['name'])
    ? $_SESSION['user']['name']
    : "Kullanıcı";

$user_id = (int)$_SESSION["user"]["id"];

try {
    // 1. KULLANICININ ÖĞRENDİĞİ KELİME SAYISINI ÇEK (Pay kısmı)
    $sqlOgrenilen = "SELECT COUNT(*) AS toplam FROM [dbo].[user_learned_words] WHERE user_id = ?";
    $queryOgrenilen = $pdo->prepare($sqlOgrenilen);
    $queryOgrenilen->execute([$user_id]);
    $resultOgrenilen = $queryOgrenilen->fetch(PDO::FETCH_ASSOC);
    
    $tamamlananSayisi = $resultOgrenilen['toplam'] ?? 0;

    // 2. TOPLAM KELİME SAYISINI SABİTLE (Payda kısmı)
    $toplamKelime = 2015; 

    // 3. KELİME LİSTESİNİ ÇEK
    $sql = "
SELECT
    w.id,
    w.word_en,
    w.word_tr,
    TRIM(w.level) as level,
    CASE WHEN ulw.word_id IS NOT NULL THEN 1 ELSE 0 END as is_learned,
    0 as is_custom
FROM [dbo].[words] w
LEFT JOIN [dbo].[user_learned_words] ulw
    ON w.id = ulw.word_id AND ulw.user_id = ?

UNION ALL

SELECT
    cw.id + 100000 as id,
    cw.word_en,
    cw.word_tr,
    'CUSTOM' as level,
    0 as is_learned,
    1 as is_custom
FROM [dbo].[user_custom_words] cw
WHERE cw.user_id = ?

ORDER BY word_en ASC
";

$query = $pdo->prepare($sql);
$query->execute([$user_id, $user_id]);
$words = $query->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Sorgu hatası: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FluentLift | Kelime Hazinesi</title>
    
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
            height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 5;
        }

        header {
            height: 100px;
            padding: 0 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
        }

        .search-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 350px;
        }

        .lvl-btn { 
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 8px 16px;
            color: #94a3b8;
            font-weight: 700;
            font-size: 0.8rem;
            transition: 0.3s;
            cursor: pointer;
        }
        .lvl-btn.active { background: var(--accent); color: #000; border-color: var(--accent); }
        
        /* Filtre Butonu Aktif Hali */
        #filterLearnedBtn.active {
            background: rgba(16, 185, 129, 0.02);
            color: white;
            border-color: #06b6d4;
        }

        .word-card { 
            background: rgba(255, 255, 255, 0.02); 
            border-radius: 28px; 
            padding: 24px; 
            border: 1px solid var(--border);
            transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        .word-card:hover { transform: translateY(-5px); border-color: var(--accent); background: rgba(255, 255, 255, 0.05); }
        
        /* Öğrenilmiş Kart Tasarımı */
        .word-card.learned { 
            border-color: #06b6d4;
            background: rgba(16, 185, 129, 0.02);
        }
        .word-card.learned h4 { opacity: 0.5; }

        .btn-profile {
            background: #06b6d4; color: black; padding: 10px 25px; border-radius: 12px; font-weight: 700;
            text-decoration: none; transition: 0.3s;
        }

        .custom-scroll::-webkit-scrollbar { width: 6px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

        @media (max-width: 900px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="bg-glow"></div>

<aside class="sidebar">
    <div class="logo">🌍 FluentLift</div>
    
    <ul class="nav-menu">
        <li class="nav-item"><a href="anasayfa2.php" class="nav-link"><span>🏠</span> <b>Öğren</b></a></li>
        <li class="nav-item"><a href="profil.php" class="nav-link"><span>👤</span> <b>Profil</b></a></li>
        <li class="nav-item"><a href="seviye_belirle.php" class="nav-link"><span>📺</span> <b>İzle</b></a></li>
        <li class="nav-item"><a href="kelimeler.php" class="nav-link active"><span>📚</span> <b>Sözlük</b></a></li>
        <li class="nav-item"><a href="nova/index.php" class="nav-link"><span>✨</span> <b>Nova İle Konuş</b></a></li>
        <li class="nav-item"><a href="mikro.php" class="nav-link"><span>🌟</span> <b>Gerçek Hayat</b></a></li>
        <li class="nav-item"><a href="ayarlar.php" class="nav-link"><span>⚙️</span> <b>Ayarlar</b></a></li>
    </ul>

    <div class="mt-auto pt-4 border-t border-white/5">
        <div class="grid grid-cols-2 gap-2 mb-2">
            <button onclick="changeLevel('A1')" id="navA1" class="lvl-btn active">A1</button>
            <button onclick="changeLevel('A2')" id="navA2" class="lvl-btn">A2</button>
            <button onclick="changeLevel('B1')" id="navB1" class="lvl-btn">B1</button>
            <button onclick="changeLevel('B2')" id="navB2" class="lvl-btn">B2</button>
        </div>
       
    </div>
</aside>

<main class="main-content">
    <header>
        <div class="flex flex-col">
            <h2 id="lvlTitle" class="text-xl font-extrabold tracking-tight">A1 Kelimeleri</h2>
            <span id="progText" class="text-[10px] text-sky-400 font-bold uppercase tracking-widest italic">Yükleniyor...</span>
        </div>

        <div class="flex items-center gap-4">
            <button onclick="toggleLearnedFilter()" id="filterLearnedBtn" class="lvl-btn whitespace-nowrap">
                <i class="fas fa-check-circle mr-2"></i>Öğrendiklerim
            </button>
 <button onclick="openAddWordModal()"
        class="lvl-btn whitespace-nowrap flex items-center justify-center w-10 h-10 p-0">
    <i class="fas fa-plus text-sm"></i>
</button>

<button onclick="showCustomWords()" id="customWordsBtn" class="lvl-btn whitespace-nowrap">
    <i class="fas fa-bookmark mr-2"></i>Eklediklerim
</button>
            <div class="search-box">
                <i class="fas fa-search text-slate-500 text-sm"></i>
                <input oninput="searchWords(this.value)" type="text" placeholder="Kelime ara..." class="bg-transparent border-none outline-none text-sm w-full text-white placeholder:text-slate-600">
            </div>
<a href="profil.php" class="btn-profile">
    <?php echo htmlspecialchars($_SESSION['user']['name'] ?? $userName); ?>
</a>    </header>

    <div id="wordGrid" class="flex-1 overflow-y-auto p-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 content-start custom-scroll">
    </div>
<div id="addWordModal"
     style="display:none;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.75);
            z-index:9999;
            align-items:center;
            justify-content:center;">

    <div style="background:#0f172a;
                padding:30px;
                border-radius:20px;
                width:400px;
                max-width:90%;
                border:1px solid rgba(255,255,255,0.1);">

        <h3 style="font-size:22px;
                   font-weight:700;
                   margin-bottom:20px;
                   color:white;">
            Yeni Kelime Ekle
        </h3>

        <input
            id="wordEn"
            type="text"
            placeholder="English Word"
            style="width:100%;
                   padding:12px;
                   margin-bottom:12px;
                   border-radius:10px;
                   background:#1e293b;
                   color:white;
                   border:none;
                   outline:none;">

        <input
            id="wordTr"
            type="text"
            placeholder="Türkçe Anlamı"
            style="width:100%;
                   padding:12px;
                   margin-bottom:20px;
                   border-radius:10px;
                   background:#1e293b;
                   color:white;
                   border:none;
                   outline:none;">

        <div style="display:flex; gap:10px;">
            <button
                onclick="saveCustomWord()"
                style="flex:1;
                       background:#06b6d4;
                       color:black;
                       padding:12px;
                       border:none;
                       border-radius:10px;
                       font-weight:700;
                       cursor:pointer;">
                Kaydet
            </button>

            <button
                onclick="closeAddWordModal()"
                style="flex:1;
                       background:#334155;
                       color:white;
                       padding:12px;
                       border:none;
                       border-radius:10px;
                       cursor:pointer;">
                İptal
            </button>
        </div>
    </div>
</div>
</main>

<script>
const allWords = <?php echo json_encode($words); ?>.map(w => ({
    id: parseInt(w.id),
    eng: w.word_en,
    tr: w.word_tr,
    level: w.level ? w.level.trim().toUpperCase() : 'A1',
    learned: parseInt(w.is_learned) === 1,
    is_custom: parseInt(w.is_custom) === 1
}));

    let activeLevel = 'A1';
    let showOnlyLearned = false;

    window.onload = function() {
        render();
    };

    function render(filteredList = null) {
        const grid = document.getElementById('wordGrid');
        const progText = document.getElementById('progText');
        const lvlTitle = document.getElementById('lvlTitle');
        let data;

        // Filtreleme Mantığı
        if (filteredList) {
            data = filteredList;
        } else if (showOnlyLearned) {
            data = allWords.filter(w => w.learned);
            lvlTitle.innerText = "Öğrendiğin Kelimeler";
        } else if (activeLevel === 'ALL') {
            data = allWords;
            lvlTitle.innerText = "Tüm Kelimeler";
        } else {
            data = allWords.filter(w => w.level === activeLevel);
            lvlTitle.innerText = activeLevel + ' Kelimeleri';
        }
        
        // Grid Çizimi
        if (data.length === 0) {
            grid.innerHTML = `<div class="col-span-full text-center py-20 text-slate-500 italic">Kelime bulunamadı.</div>`;
        } else {
            grid.innerHTML = data.map(w => `
                <div class="word-card ${w.learned ? 'learned' : ''}">
                    <div class="flex justify-between items-start mb-6">
                        <div onclick="speak('${w.eng}')" class="w-10 h-10 bg-sky-500/10 rounded-xl flex items-center justify-center cursor-pointer text-sky-400 hover:bg-sky-400 hover:text-black transition">
                            <i class="fas fa-volume-up"></i>
                        </div>
                        <span class="text-[9px] font-black text-slate-500 uppercase">${w.level}</span>
                    </div>
                    <div class="mb-6">
                        <h4 class="text-xl font-extrabold text-white">${w.eng}</h4>
                        <p class="text-sm text-slate-400 font-medium">${w.tr}</p>
                    </div>
                    <button onclick="toggleWord(${w.id})" class="w-full py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition ${w.learned ? 'bg-[#06b6d4]/20 text-[#06b6d4]' : 'bg-white/5 text-sky-400 hover:bg-sky-500/10'}">
                        ${w.learned ? 'TAMAMLANDI ✓' : 'ÖĞRENİLDİ ?'}
                    </button>
${w.is_custom ? `
    <button onclick="deleteCustomWord(${w.id})"
        class="w-full mt-2 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest
               bg-red-500/10 text-red-400 hover:bg-red-500/20 transition">
        SİL 🗑️
    </button>

` : ''}
                </div>
            `).join('');
        }

        // İlerleme Metni Güncelleme (2015 Sabit Ayarı)
        const totalLearnedOverall = allWords.filter(w => w.learned).length;
        
        if (showOnlyLearned || activeLevel === 'ALL') {
            // "Tüm Kelimeler" veya "Öğrendiklerim" seçiliyse sabit 2015 üzerinden göster
            progText.innerText = `Tamamlanan: ${totalLearnedOverall} / 2.015`;
        } else {
            // Belirli bir seviye (A1, B2 vb.) seçiliyse o seviyenin kendi ilerlemesini göster
            const levelWords = allWords.filter(w => w.level === activeLevel);
            const learnedInLevel = levelWords.filter(w => w.learned).length;
            progText.innerText = `Tamamlanan: ${learnedInLevel} / ${levelWords.length}`;
        }
    }

    function changeLevel(lvl) {
        showOnlyLearned = false;
        activeLevel = lvl.toUpperCase();
        document.querySelectorAll('.lvl-btn').forEach(b => b.classList.remove('active'));
        const activeBtn = document.getElementById('nav' + lvl);
        if(activeBtn) activeBtn.classList.add('active');
        render();
    }

    async function toggleWord(id) {
        const word = allWords.find(w => w.id == id);
        if (!word) return;
        word.learned = !word.learned;
        render();
        try {
            await fetch('save_word_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `word_id=${id}&status=${word.learned ? 1 : 0}`
            });
        } catch (err) { console.error("Kayıt hatası:", err); }
    }

    function toggleLearnedFilter() {
        showOnlyLearned = !showOnlyLearned;
        const btn = document.getElementById('filterLearnedBtn');
        btn.classList.toggle('active', showOnlyLearned);
        btn.innerHTML = showOnlyLearned ? `<i class="fas fa-eye mr-2"></i>Hepsini Göster` : `<i class="fas fa-check-circle mr-2"></i>Öğrendiklerim`;
        render();
    }

    function searchWords(query) {
        const q = query.toLowerCase().trim();
        if(q === "") { render(); return; }
        const filtered = allWords.filter(w => (w.eng.toLowerCase().includes(q) || w.tr.toLowerCase().includes(q)));
        render(filtered);
    }

    function speak(text) {
        window.speechSynthesis.cancel();
        const msg = new SpeechSynthesisUtterance(text);
        msg.lang = 'en-US';
        window.speechSynthesis.speak(msg);
    }
    let showOnlyCustom = false;

function openAddWordModal() {
    document.getElementById('addWordModal').style.display = 'flex';
}

function closeAddWordModal() {
    document.getElementById('addWordModal').style.display = 'none';
    document.getElementById('wordEn').value = '';
    document.getElementById('wordTr').value = '';
}

async function saveCustomWord() {
    const wordEn = document.getElementById('wordEn').value.trim();
    const wordTr = document.getElementById('wordTr').value.trim();

    if (!wordEn || !wordTr) {
        alert('Lütfen tüm alanları doldurun.');
        return;
    }

    const formData = new URLSearchParams();
    formData.append('word_en', wordEn);
    formData.append('word_tr', wordTr);

    try {
        const response = await fetch('save_custom_word.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert('Kelime başarıyla eklendi!');
            location.reload();
        } else {
            alert(result.message);
        }
    } catch (error) {
        alert('Bir hata oluştu.');
        console.error(error);
    }
}

function showCustomWords() {
    showOnlyCustom = !showOnlyCustom;

    const btn = document.getElementById('customWordsBtn');
    btn.classList.toggle('active', showOnlyCustom);

    if (showOnlyCustom) {
        const customWords = allWords.filter(w => w.level === 'CUSTOM');
        document.getElementById('lvlTitle').innerText = 'Eklediğim Kelimeler';
        document.getElementById('progText').innerText = `Toplam: ${customWords.length}`;
        render(customWords);
    } else {
        render();
    }
}
async function deleteCustomWord(id) {
    if (!confirm('Bu kelimeyi silmek istediğine emin misin?')) {
        return;
    }

    try {
        const response = await fetch('delete_custom_word.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'word_id=' + encodeURIComponent(id)
        });

        const result = await response.json();

        if (result.success) {
            // allWords dizisinden sil
            const index = allWords.findIndex(w => w.id == id);
            if (index !== -1) {
                allWords.splice(index, 1);
            }

            // Eğer "Eklediklerim" açıksa yeniden filtrele
            if (showOnlyCustom) {
                const customWords = allWords.filter(w => w.level === 'CUSTOM');
                render(customWords);
            } else {
                render();
            }

            alert('Kelime başarıyla silindi.');
        } else {
            alert(result.message || 'Kelime silinemedi.');
        }

    } catch (error) {
        console.error('Silme hatası:', error);
        alert('Bir hata oluştu.');
    }
}
</script>
</body>
</html>