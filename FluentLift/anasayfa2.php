<?php
session_start();
require_once __DIR__ . "/db.php";

// 🛑 GİRİŞ KONTROLÜ: Oturum yoksa direkt login'e fırlat
if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["id"])) {
    header("Location: login.php"); 
    exit;
}

$user_id = (int)$_SESSION["user"]["id"];

try {
    // 1. Kullanıcı Bilgilerini Çek (created_at dahil)
    $st = $pdo->prepare("SELECT first_name, last_name, user_xp, user_level, total_stars, created_at FROM dbo.users WHERE id = ?");
    $st->execute([$user_id]);
    $u = $st->fetch(PDO::FETCH_ASSOC);

    // Eğer veritabanında kullanıcı bulunamazsa (garip bir durum ama) oturumu kapat
    if (!$u) {
        session_destroy();
        header("Location: login.php");
        exit;
    }

    // Değişkenleri Veritabanından Al
    $user_name   = trim($u["first_name"] . " " . $u["last_name"]);
    $user_xp     = (int)$u["user_xp"];
    $user_level  = (int)$u["user_level"];
    $user_stars  = (int)$u["total_stars"];
    $joinDate    = date("d.m.Y", strtotime($u["created_at"]));

    // 2. İlerlemeyi Çek (user_progress tablosu)
    $stProgress = $pdo->prepare("SELECT last_node_index FROM dbo.user_progress WHERE user_id = ?");
    $stProgress->execute([$user_id]);
    $progress = $stProgress->fetch(PDO::FETCH_ASSOC);

    // Veritabanında kayıt yoksa 0'dan başla
    $lastNode = $progress ? (int)$progress['last_node_index'] : 0;

    // Statik Değişkenler (Şimdilik)
    $streakDays = "12";
    $currentLevel = "A1";

} catch (PDOException $e) {
    // Veritabanı hatası varsa sayfayı yükleme, hatayı bas (Geliştirme için)
    die("Veritabanı Hatası: " . $e->getMessage());
}


$units = [
    [
        "id" => 1,
        "tag" => "Bölüm 1, Ünite 1",
        "title" => "Hello World",
        "guide_text" => "ÜNİTE 1 REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "active", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
    [
        "id" => 2,
        "tag" => "Bölüm 1, Ünite 2",
        "title" => "Alphabet & Names",
        "guide_text" => "ÜNİTE 2 REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
        [
        "id" => 3,
        "tag" => "Bölüm 1, Ünite 3",
        "title" => "Numbers & Age",
        "guide_text" => "ÜNİTE 3 REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
        [
        "id" => 4,
        "tag" => "Bölüm 1, Ünite 4",
        "title" => "Countries & Nationalities",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
           [
        "id" => 5,
        "tag" => "Bölüm 1, Ünite 5",
        "title" => "Daily Words & Objects",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
       [
        "id" => 6,
        "tag" => "Bölüm 1, Ünite 6",
        "title" => "Family & People",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
  [
        "id" => 7,
        "tag" => "Bölüm 1, Ünite 7",
        "title" => "Daily Routines",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
     [
        "id" => 8,
        "tag" => "Bölüm 1, Ünite 8",
        "title" => "Time & Days",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
 [
        "id" => 9,
        "tag" => "Bölüm 1, Ünite 9",
        "title" => "Food & Drinks",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
 [
        "id" => 10,
        "tag" => "Bölüm 1, Ünite 10",
        "title" => "Places & Directions",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
 [
        "id" => 11,
        "tag" => "Bölüm 1, Ünite 11",
        "title" => "Shopping & Prices",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
 [
        "id" => 12,
        "tag" => "Bölüm 1, Ünite 12",
        "title" => "Review & Speaking Boost",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "star", "status" => "locked", "pos" => "left"],
            ["type" => "star", "status" => "locked", "pos" => "right"],
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
[
        "id" =>13,
        "tag" => "Bölüm Sonu Sınav",
        "title" => "",
        "guide_text" => "ÜNİTE  REHBERİ",
        "nodes" => [
            ["type" => "trophy", "status" => "locked", "pos" => "center"]
        ]
    ],
];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FluentLift | Modern Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --accent: #38bdf8;
            --dark-blue: #0f172a;
            --gray: #64748b;
            --light-bg: #f8fafc;
            --border: rgba(255, 255, 255, 0.1);
            --white: #ffffff;
            --completed: #ffb400;
            --step-color: rgba(37, 99, 235, 0.2);
        }

        body {
            background: linear-gradient(to bottom,#0f172a 0%, #ffffff 100%);
            color: var(--dark-blue);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
        }


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
        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px; /* Sidebar genişliği */
            margin-right: 340px;
            flex: 1;
            max-width: 800px; 
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            background: linear-gradient(to bottom, #0f172a 0%, #ffffff 100%);
            min-height: 100vh;
            position: relative;
        }

        .sticky-unit-header {
            position: sticky;
            top: 0;
            width: 100%;
            background-color: #001951f8;
            color: white;
            padding: 20px 30px;
            z-index: 50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .sticky-unit-header h2 { 
            margin: 0;
            font-size: 1.3rem; 
            font-weight: 700;
        }
        .sticky-unit-header p { 
            margin: 0; 
            font-size: 0.85rem; 
            opacity: 0.9; 
            font-weight: 600; 
            text-transform: uppercase; 
        }

        .guide-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: 0.3s;
            border: 2px solid transparent;
        }
        .guide-btn:hover { 
            background: white; 
            color: var(--primary); 
        }

        /* PATH & NODES */
        .unit-container { 
            width: 100%; 
            max-width: 550px; 
            padding: 40px 20px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            position: relative; 
        }

        .path { 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            margin-top: 20px; 
            width: 100%; 
        }
        
        .unit-divider {
            width: 100%;
            text-align: center;
            margin: 50px 0 30px;
            border-top: 2px dashed var(--step-color);
            padding-top: 20px;
            font-weight: 700;
            color: var(--gray);
            letter-spacing: 2px;
        }

        .node {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            cursor: pointer;
            z-index: 2;
            transition: 0.4s;
            position: relative;
        }
/* GÜNLÜK GÖREVLER BAŞLIK SATIRI */
.task-modal{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.60);
    backdrop-filter:blur(8px);

    display:none; /* BAŞLANGIÇTA GİZLİ */
    align-items:center;
    justify-content:center;

    z-index:99999;
}

.task-modal.show{
    display:flex;
}

.task-modal-content{
    width:90%;
    max-width:500px;
    background:#1e293b;
    border-radius:28px;
    padding:35px;
    position:relative;
    box-shadow:0 25px 60px rgba(0,0,0,.45);
    border:1px solid rgba(255,255,255,.08);
}

.close-modal{
    position:absolute;
    top:18px;
    right:18px;
    border:none;
    background:none;
    color:#94a3b8;
    font-size:1.3rem;
    cursor:pointer;
}
.tasks-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:15px;
    gap:12px;
}

.tasks-header h4{
    margin:0;
    color:#94a3b8;
    font-size:1rem;
    font-weight:700;
}

/* ARTI BUTONU */
.add-task-btn{
    width:34px;
    height:34px;
    border:none;
    border-radius:50%;
    background:var(--accent);
    color:var(--dark-blue);
    font-size:1.2rem;
    font-weight:700;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
    transition:.25s ease;
}

.add-task-btn:hover{
    transform:scale(1.08);
    box-shadow:0 0 15px rgba(56,189,248,.35);
}
/* TASK MODAL INPUT */
#taskInput{
    width:100%;
    padding:14px 18px;
    border-radius:14px;
    border:1px solid rgba(255,255,255,.08);
    background:#0f172a;
    color:white;
    font-size:1rem;
    outline:none;
    margin:20px 0;
    box-sizing:border-box;
}

#taskInput::placeholder{
    color:#64748b;
}

/* SAVE BUTTON */
.save-task-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#06b6d4,#38bdf8);
    color:#0f172a;
    font-weight:700;
    font-size:1rem;
    cursor:pointer;
    transition:.25s;
}

.save-task-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(56,189,248,.25);
} 
.task-check{
    min-width:24px;
    width:24px;
    height:24px;
    border-radius:8px;
    border:2px solid #38bdf8;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:.9rem;
    transition:.25s;
}

.task-item.completed .task-check{
    background:#38bdf8;
    color:#0f172a;
}

.task-item.completed .task-check::before{
    content:"✓";
}

.task-item.completed span{
    text-decoration:line-through;
    opacity:.65;
}
.delete-task{
    margin-left:auto;
    width:34px;
    height:34px;
    border:none;
    border-radius:12px;
    background:rgba(239,68,68,0.08);
    color:#ef4444;
    font-size:1rem;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.25s ease;
}

.delete-task:hover{
    background:#ef4444;
    color:white;
    transform:scale(1.08) rotate(8deg);
    box-shadow:0 8px 18px rgba(239,68,68,.25);
}

.delete-task:active{
    transform:scale(.92);
}

/* Unit wrapper'ın genişliğini ayarla ve node'ları ortala */
.unit-wrapper {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center; /* Tüm içeriği yatayda ortalar */
}

/* Eğer node'ların pos (left, right) sınıfları bozulduysa bunu ekle */
.node.left { align-self: flex-start; margin-left: 20%; }
.node.right { align-self: flex-end; margin-right: 20%; }
.node.center { align-self: center; }

        .node.completed { 
            background: linear-gradient(145deg, var(--completed), #ff8c00); 
            box-shadow: 0 8px 0 #b36200; 
        }
        .node.active { background: linear-gradient(145deg, var(--primary), var(--accent)); 
        box-shadow: 0 8px 0 #1e40af; 
        animation: float 2.5s infinite ease-in-out;
        }
        .node.locked { 
            background: #e2e8f0; 
            color: #94a3b8; 
            box-shadow: 0 8px 0 #cbd5e1; 
            cursor: not-allowed; 
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(var(--tx)); }
            50% { transform: translateY(-12px) translateX(var(--tx)); }
        }

        .steps { 
            display: flex; 
            flex-direction: column; 
            gap: 8px; 
            margin: 8px 0; 
        }
        .dot { 
            width: 8px; 
            height: 8px; 
            background: var(--step-color); 
            border-radius: 50%; 
        }
        .steps.to-right { transform: rotate(15deg) translateX(15px); }
        .steps.to-left { transform: rotate(-15deg) translateX(-15px); }

        /* DECORATIONS */
        .decoration { 
            position: absolute; 
            font-size: 2rem; 
            opacity: 0.50; 
            user-select: none; 
            pointer-events: none; 
            animation: drift 5s infinite ease-in-out; 
        }
        @keyframes drift { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-10px) rotate(10deg); } }

        /* RIGHT PANEL */
        .right-panel {
            width: 340px;
            background-color: var(--dark-blue);
            color: white;
            padding: 40px 25px;
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            border-left: 1px solid var(--border);
            z-index: 100;
            box-sizing: border-box;
        }

        .stat-card { 
            background: rgba(255, 255, 255, 0.05); 
            border-radius: 25px; 
            padding: 20px; 
            margin: 20px 0; 
            border: 1px solid var(--border); 
        }
        .stat-value { 
            font-size: 1.8rem;
            font-weight: 700; 
            color: white; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            margin-top: 5px;
         }
        .xp-bar-bg { 
            width: 100%; 
            height: 12px; 
            background: rgba(255, 255, 255, 0.1); 
            border-radius: 10px; 
            margin-top: 10px; 
            overflow: hidden; 
        }
        .xp-bar-fill { 
            height: 100%; 
            background: linear-gradient(90deg, var(--primary), var(--accent)); 
            transition: 1s; 
        }
        .task-item {
            background: rgba(255, 255, 255, 0.03);
            padding: 15px; 
            border-radius: 18px; 
            margin-bottom: 10px; 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            border: 1px solid var(--border); 
        }

        #toast-msg {
            position: fixed; 
            top: 100px; 
            left: 50%; 
            transform: translateX(-50%);
            background: var(--dark-blue); 
            color: white;
            padding: 15px 30px;
            border-radius: 50px; 
            font-weight: 700; 
            display: none; 
            z-index: 1000;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3); 
            border: 2px solid var(--accent);
        }

        @media (max-width: 1100px) {
            
            .right-panel { 
                transform: translateX(340px); 
            }
            .main-content { 
                margin: 0; 
                width: 100%; 
            }
        }
    </style>
</head>
<body>

<div id="toast-msg">🚀 Müthişsin <?php echo $user_name; ?>! +25 XP Kazandın</div>

<nav class="sidebar">
    <div class="logo">🌍 FluentLift</div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="anasayfa2.php" class="nav-link active"><span>🏠</span> <b>Öğren</b></a></li>
        <li class="nav-item"><a href="profil.php" class="nav-link"><span>👤</span> <b>Profil</b></a></li>
        <li class="nav-item"><a href="seviye_belirle.php" class="nav-link"><span>📺</span> <b>İzle</b></a></li>
        <li class="nav-item"><a href="kelimeler.php" class="nav-link"><span>📚</span> <b>Sözlük</b></a></li>
        <li class="nav-item"><a href="nova/index.php" class="nav-link"><span>✨</span> <b>Nova İle Konuş</b></a></li>
        <li class="nav-item"><a href="mikro.php" class="nav-link"> <span>🌟</span> <b>Gerçek Hayat</b></a></li>
        <li class="nav-item"><a href="ayarlar.php" class="nav-link"><span>⚙️</span> <b>Ayarlar</b></a></li>
    </ul>
</nav>

<main class="main-content">
    <div class="sticky-unit-header">
        <div>
            <p id="unit-tag"><?php echo $units[0]['tag']; ?></p>
            <h2 id="unit-title"><?php echo $units[0]['title']; ?></h2>
        </div>
        <a href="#" class="guide-btn" id="guide-btn"><?php echo $units[0]['guide_text']; ?></a>
    </div>

 <div class="unit-container">
<div class="decoration" style="top: 3%; left: -22%;">🚀</div>
    <div class="decoration" style="top: 14%; left: -28%; animation-delay: 0.6s;">🪐</div>
    <div class="decoration" style="top: 26%; left: -20%; animation-delay: 1.2s;">🌠</div>
    <div class="decoration" style="top: 38%; left: -24%; animation-delay: 1.8s;">☄️</div>
    <div class="decoration" style="top: 50%; left: -30%; animation-delay: 2.4s;">👨‍🚀</div>
    <div class="decoration" style="top: 62%; left: -26%; animation-delay: 3s;">🔭</div>
    <div class="decoration" style="top: 74%; left: -22%; animation-delay: 3.6s;">🛸</div>
    <div class="decoration" style="top: 86%; left: -28%; animation-delay: 4.2s;">🌌</div>

    <div class="decoration" style="top: 8%; right: -18%; animation-delay: 0.3s;">🛰️</div>
    <div class="decoration" style="top: 20%; right: -24%; animation-delay: 0.9s;">🌑</div>
    <div class="decoration" style="top: 32%; right: -26%; animation-delay: 1.5s;">🌟</div>
    <div class="decoration" style="top: 44%; right: -22%; animation-delay: 2.1s;">🌍</div>
    <div class="decoration" style="top: 56%; right: -18%; animation-delay: 2.7s;">👽</div>
    <div class="decoration" style="top: 68%; right: -24%; animation-delay: 3.3s;">☀️</div>
    <div class="decoration" style="top: 80%; right: -20%; animation-delay: 3.9s;">✨</div>
    <div class="decoration" style="top: 92%; right: -16%; animation-delay: 4.5s;">👾</div>


<main>
<div class="path">
    <?php $nodeCounter = 0; ?>
    <?php foreach ($units as $unit): ?>
        <div class="unit-wrapper" 
             data-tag="<?php echo htmlspecialchars($unit['tag']); ?>" 
             data-title="<?php echo htmlspecialchars($unit['title']); ?>" 
             data-guide="<?php echo htmlspecialchars($unit['guide_text']); ?>">

           <div class="unit-divider">
    ÜNİTE <?php echo htmlspecialchars($unit['id']); ?>: <?php echo htmlspecialchars($unit['title']); ?>
</div>

            <?php foreach ($unit['nodes'] as $nKey => $node): ?>
                <?php 
                    $status = 'locked';
                    if ($nodeCounter < $lastNode) $status = 'completed';
                    elseif ($nodeCounter == $lastNode) $status = 'active';
                    
                    $pos = $node['pos'] ?? 'center';
                    $type = $node['type'] ?? 'star';
                ?>
                <div class="node <?php echo $status; ?> <?php echo $pos; ?>" 
                     data-unit-id="<?php echo (int)$unit['id']; ?>"
                     data-node-idx="<?php echo $nodeCounter; ?>"  
                     onclick="startLesson(this)">
                    <?php echo ($type === 'star') ? '⭐' : '🏆'; ?>
                </div>

                <?php if ($nKey < count($unit['nodes']) - 1): ?>
                    <div class="steps <?php echo ($pos == 'left') ? 'to-right' : (($pos == 'right') ? 'to-left' : 'center'); ?>">
                        <div class="dot"></div><div class="dot"></div>
                    </div>
                <?php endif; ?>
                
                <?php $nodeCounter++; ?>
            <?php endforeach; ?>
        </div> <?php endforeach; ?> </div>
</main>

<aside class="right-panel">
    <div class="user-welcome">
        <h3>Merhaba, <?php echo htmlspecialchars($user_name ?? 'Öğrenci'); ?>! 👋</h3>
        <div style="color: #06b6d4; font-style: italic;">"Her gün bir adım daha ileri!"</div>
    </div>
    <div class="stat-card">
       <div style="display:flex; justify-content:space-between; color:#94a3b8; font-weight:600;">
    <span>Seviye <span id="levelText"><?php echo $user_level ?? 1; ?></span></span>
    <span id="xpPercent"><?php echo $user_xp ?? 0; ?>%</span>
</div>
        <div class="xp-bar-bg"><div class="xp-bar-fill" id="xpFill" style="width: <?php echo $user_xp ?? 0; ?>%; background: #06b6d4;"></div></div>
    </div>
    <div class="stat-card">
        <div style="color:#94a3b8; font-weight:700; font-size:0.8rem;">TOPLAM PUANIN</div>
        <div class="stat-value">⭐ <span id="starCount"><?php echo $user_stars ?? 0; ?></span></div>
    </div>
    
<div class="daily-tasks">
    <div class="tasks-header">
        <h4>Günlük Görevler</h4>
        <button type="button" class="add-task-btn" onclick="openTaskModal()">+</button>
    </div>

    <div id="taskList"></div>
</div>

<!-- TASK MODAL -->
<div id="taskModal" class="task-modal">
    <div class="task-modal-content">
        <button type="button" class="close-modal" onclick="closeTaskModal()">✕</button>

        <h3>Yeni Görev Ekle</h3>

        <input type="text" id="taskInput" placeholder="Görevini yaz...">

        <button type="button" class="save-task-btn" onclick="saveTask()">Görevi Ekle</button>
    </div>
</div>

<div id="quiz-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.92); z-index: 2000; align-items: center; justify-content: center; backdrop-filter: blur(10px);">
    <div style="background: #1e293b; width: 90%; max-width: 450px; padding: 40px; border-radius: 24px; position: relative; text-align: center; border: 1px solid #334155; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);">
        
        <span onclick="closeQuiz()" style="position: absolute; right: 25px; top: 20px; cursor: pointer; font-size: 20px; color: #64748b; transition: color 0.2s;" onmouseover="this.style.color='#94a3b8'" onmouseout="this.style.color='#64748b'">✕</span>
        
        <div id="quiz-content">
            <div id="quiz-header" style="color: #22d3ee; font-weight: 600; margin-bottom: 12px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">BÖLÜM 1 TAMAMLA</div>
            
            <h2 id="quiz-question" style="color: #e2e8f0; margin-bottom: 25px; font-size: 1.25rem; font-weight: 500; line-height: 1.5;">...</h2>
            
            <div id="quiz-options" style="display: flex; flex-direction: column; gap: 12px;">
                </div>
        </div>

        <div id="quiz-success" style="display: none;">
            <div style="font-size: 50px; margin-bottom: 15px; filter: drop-shadow(0 0 10px rgba(34, 197, 94, 0.3));">🏆</div>
            <h2 style="color: #4ade80; font-size: 1.6rem; margin-bottom: 8px;">Harika İş!</h2>
            <p style="color: #94a3b8; font-size: 1rem; margin-bottom: 20px;">Tüm soruları doğru bildin.</p>
            
            <div style="background: rgba(30, 41, 59, 0.5); padding: 15px; border-radius: 16px; margin-bottom: 25px; border: 1px solid #334155;">
                <p style="color: #f1f5f9; font-weight: 600; margin: 0;">
                    <span style="color: #fbbf24;">★</span> +25 XP ve 15 Yıldız
                </p>
            </div>
            
            <button onclick="finishQuiz()" style="background: #06b6d4; color: #ffffff; border: none; width: 100%; padding: 14px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">DEVAM ET</button>
        </div>
    </div>
</div>
<script>
let mevcutSorular = [];
let aktifIndeks = 0;
let activeNode = null; // Tıklanan yıldızı burada tutuyoruz

// 1. DERSİ BAŞLATMA
async function startLesson(element) {
    if (element.classList.contains("locked")) {
        alert("Bu bölüm henüz kilitli! 🔒");
        return;
    }

    activeNode = element; // Tıklanan yıldızı hafızaya al
    const unitId = element.getAttribute('data-unit-id');
    aktifIndeks = 0; 

    document.getElementById("quiz-content").style.display = "block";
    document.getElementById("quiz-success").style.display = "none";

    try {
        const response = await fetch(`get_questions.php?unit_id=${unitId}&nocache=${Date.now()}`);
        const data = await response.json();

        if (data.error || data.length === 0) {
            alert("Soru bulunamadı.");
            return;
        }

        mevcutSorular = data; 
        soruyuYukle(); 
        document.getElementById("quiz-modal").style.display = "flex";

    } catch (error) {
        console.error("Sistem Hatası:", error);
    }
}

// 2. SORUYU EKRANA BASMA
function soruyuYukle() {
    if (!mevcutSorular[aktifIndeks]) return;

    const data = mevcutSorular[aktifIndeks];
    document.getElementById("quiz-header").innerText = `ADIM ${aktifIndeks + 1} / 5`;
    document.getElementById("quiz-question").innerText = data.q;
    
    const optionsDiv = document.getElementById("quiz-options");
    optionsDiv.innerHTML = "";

    data.options.forEach((opt, idx) => {
        const btn = document.createElement("button");
        btn.innerText = opt;
        btn.style.cssText = "padding:15px; margin:5px; border-radius:12px; border:2px solid #e2e8f0; cursor:pointer; background:white; font-weight:bold; width:100%;";
        
        btn.onclick = () => {
            if (parseInt(idx) === parseInt(data.correct)) {
                aktifIndeks++;
                if (aktifIndeks < 5) {
                    soruyuYukle();
                } else {
                    showFinalSuccess();
                }
            } else {
                btn.style.borderColor = "#ef4444";
                btn.style.backgroundColor = "#fee2e2";
                alert("Yanlış cevap! 💡");
            }
        };
        optionsDiv.appendChild(btn);
    });
}

function showFinalSuccess() {
    document.getElementById("quiz-content").style.display = "none";
    document.getElementById("quiz-success").style.display = "block";
}

// 3. TESTİ BİTİRME VE SQL GÜNCELLEME
async function finishQuiz() {
    if (!activeNode) return;

    // Elementleri al
    const xpText = document.getElementById("xpPercent");
    const levelText = document.getElementById("levelText");
    const starsElement = document.getElementById("starCount");

    // Mevcut değerler (ParseInt ile sayıya çeviriyoruz)
    let currentXp = parseInt(xpText.innerText.replace('%','')) || 0;
    let currentLevel = parseInt(levelText.innerText) || 1;
    let currentStars = parseInt(starsElement.innerText) || 0;

    // Yeni değerler
    let newXp = currentXp + 25;
    let newStars = currentStars + 15;
    let newLevel = currentLevel;

    if (newXp >= 100) { newLevel++; newXp = 0; }

    // Sıradaki yıldızın numarasını al (HTML'den okuyor)
    const nodeIdx = parseInt(activeNode.getAttribute('data-node-idx'));
    const nextNodeIdx = nodeIdx + 1;

    try {
        // İstatistikleri ve ilerlemeyi kaydet
        await Promise.all([
            fetch('update_progress.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `node_idx=${nextNodeIdx}`
            }),
            fetch('update_user_stats.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `level=${newLevel}&xp=${newXp}&stars=${newStars}`
            })
        ]);

        // Sayfayı yenile (Kilitlerin açılması için PHP tekrar çalışmalı)
        window.location.reload();

    } catch (e) {
        console.error("Kayıt hatası:", e);
        alert("Bağlantı koptu!");
    }
}

function closeQuiz() {
    document.getElementById("quiz-modal").style.display = "none";
}
document.addEventListener("DOMContentLoaded", function() {
    const unitTag = document.getElementById('unit-tag');
    const unitTitle = document.getElementById('unit-title');
    const guideBtn = document.getElementById('guide-btn');
    const wrappers = document.querySelectorAll('.unit-wrapper');

    const observerOptions = {
        root: null,
        // Ekranın üst kısmından %20'lik bir alan "aktif bölge" sayılır
        rootMargin: '-10% 0px -85% 0px', 
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Wrapper üzerindeki data bilgilerini oku
                const tag = entry.target.getAttribute('data-tag');
                const title = entry.target.getAttribute('data-title');
                const guide = entry.target.getAttribute('data-guide');

                // Header elementlerini güncelle
                if(unitTag) unitTag.textContent = tag;
                if(unitTitle) unitTitle.textContent = title;
                if(guideBtn) guideBtn.textContent = guide;
            }
        });
    }, observerOptions);

    wrappers.forEach(wrapper => observer.observe(wrapper));
});

function openTaskModal(){
    document.getElementById("taskModal").classList.add("show");
}

function closeTaskModal(){
    document.getElementById("taskModal").classList.remove("show");
}

/* SAYFA AÇILINCA */
document.addEventListener("DOMContentLoaded", loadTasks);
async function saveTask(){
    const input = document.getElementById("taskInput");
    const value = input.value.trim();

    if(!value) return;

    const res = await fetch("save_task.php",{
        method:"POST",
        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:`task=${encodeURIComponent(value)}`
    });

    const data = await res.json();

    if(!data.success){
        alert(data.message);
        return;
    }

    input.value="";
    closeTaskModal();
    loadTasks();
}
async function loadTasks(){
    const res = await fetch("get_tasks.php");
    const tasks = await res.json();

    renderTasks(tasks);
}

function renderTasks(tasks){
    const taskList = document.getElementById("taskList");
    taskList.innerHTML="";

    tasks.forEach(task=>{
        const div=document.createElement("div");
        div.className="task-item";
if(Number(task.completed) === 1){
    div.classList.add("completed");

}

        div.innerHTML=`
            <div class="task-check"></div>
            <span>${task.task_text}</span>
            <button class="delete-task" onclick="event.stopPropagation(); deleteTask(${task.id})">🗑️</button>
        `;

        div.onclick=()=>toggleTask(task.id);

        taskList.appendChild(div);
    });
}

async function toggleTask(id){
    await fetch("toggle_task.php",{
        method:"POST",
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`task_id=${id}`
    });

    loadTasks();
}

async function deleteTask(id){
    await fetch("delete_task.php",{
        method:"POST",
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`task_id=${id}`
    });

    loadTasks();
}
</script>