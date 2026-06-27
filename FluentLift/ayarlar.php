<?php
session_start();

/* ================================
   VERİTABANI BAĞLANTISI
================================ */
$server = "localhost\\MSSQLSERVER04";
$db     = "fluentlift";
$user   = "fluent_user";
$pass   = "GucluBirSifre_123!";

try {
    $pdo = new PDO(
        "sqlsrv:Server=$server;Database=$db;TrustServerCertificate=1",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Bağlantı Hatası: " . $e->getMessage());
}

/* ================================
   OTURUM KONTROLÜ
================================ */
if (!isset($_SESSION["user"]["id"])) {
    header("Location: Kayıt.php");
    exit;
}

$userId  = (int)$_SESSION["user"]["id"];
$message = "";

/* ================================
   PROFİL GÜNCELLEME
================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_settings"])) {
    try {
        $fullName = trim($_POST["full_name"] ?? "");
        $email    = trim($_POST["email"] ?? "");

        $parts = explode(" ", $fullName);
        $fName = $parts[0] ?? "";
        $lName = count($parts) > 1 ? implode(" ", array_slice($parts, 1)) : "";

        $stmt = $pdo->prepare("
            UPDATE dbo.users
            SET first_name = ?, last_name = ?, email = ?
            WHERE id = ?
        ");

        $stmt->execute([$fName, $lName, $email, $userId]);

        // Session güncelle
        $_SESSION["user"]["first_name"] = $fName;
        $_SESSION["user"]["last_name"]  = $lName;
        $_SESSION["user"]["email"]      = $email;

        $message = "
        <div style='color:#10b981;padding:12px;border:1px solid #10b981;border-radius:10px;margin-bottom:20px;'>
            ✅ Bilgiler başarıyla güncellendi!
        </div>";

    } catch (Exception $e) {
        $message = "
        <div style='color:#ef4444;padding:12px;border:1px solid #ef4444;border-radius:10px;margin-bottom:20px;'>
            ❌ Güncelleme sırasında hata oluştu!
        </div>";
    }
}

/* ================================
   HESAP SİLME
================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_account"])) {
    try {
        // İlişkili verileri temizle
        $pdo->prepare("DELETE FROM dbo.user_learned_words WHERE user_id = ?")->execute([$userId]);
        $pdo->prepare("DELETE FROM dbo.user_progress WHERE user_id = ?")->execute([$userId]);

        // Nova mesaj tablon varsa bunu aç:
        // $pdo->prepare("DELETE FROM dbo.nova_messages WHERE user_id = ?")->execute([$userId]);

        // Kullanıcıyı sil
        $pdo->prepare("DELETE FROM dbo.users WHERE id = ?")->execute([$userId]);

        // Session temizle
        $_SESSION = [];
        session_unset();
        session_destroy();

        // Kayıt ekranına yönlendir
        header("Location: Kayıt.php");
        exit;

    } catch (Exception $e) {
        $message = "
        <div style='color:#ef4444;padding:12px;border:1px solid #ef4444;border-radius:10px;margin-bottom:20px;'>
            ❌ Hesap silinirken hata oluştu!
        </div>";
    }
}

/* ================================
   KULLANICI VERİLERİNİ ÇEK
================================ */
$st = $pdo->prepare("
    SELECT first_name, last_name, email
    FROM dbo.users
    WHERE id = ?
");
$st->execute([$userId]);

$u = $st->fetch(PDO::FETCH_ASSOC);

$uName  = trim(($u["first_name"] ?? "") . " " . ($u["last_name"] ?? ""));
$uEmail = $u["email"] ?? "";
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FluentLift - Ayarlar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
     <style>
        :root {
            --primary: #2563eb;
            --accent: #38bdf8;
            --accent-dark: #1d4ed8;
            --bg: #0f172a;               /* Ana arka plan */
            --panel: #1e293b;             /* Ayar kutuları */
            --panel-dark: #0a0f1a;        /* Sidebar rengi */
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: rgba(255,255,255,0.08);
            --danger: #ef4444;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR TASARIMI --- */
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
        /* --- ANA İÇERİK ALANI --- */
        .main-content {
            margin-left: 260px; /* Sidebar genişliği */
            flex: 1;
            padding: 50px;
            display: flex;
            justify-content: center;
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.05), transparent);
        }

        .settings-container {
            width: 100%;
            max-width: 800px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }

        h1 { font-size: 2.2rem; font-weight: 700; margin-bottom: 30px; color: var(--text-primary); }

        .settings-section {
            background: var(--panel);
            border-radius: 28px;
            padding: 35px;
            margin-bottom: 30px;
            border: 1px solid var(--border);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--accent);
        }

        /* --- FORM ELEMANLARI --- */
        .form-group { margin-bottom: 22px; }
        label { display: block; font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 10px; font-weight: 500; }
        
        input[type="text"], input[type="email"], select {
            width: 100%;
            background: #0f172a;
            border: 1px solid var(--border);
            padding: 14px 18px;
            border-radius: 15px;
            color: white;
            font-family: inherit;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }

        input:focus, select:focus { 
            border-color: var(--accent); 
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1); 
        }

        /* --- HEDEF SEÇİM KUTULARI --- */
        .focus-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }

        .focus-item {
            background: #0f172a;
            padding: 15px;
            border-radius: 16px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: 0.2s;
        }

        .focus-item:hover { border-color: var(--accent); background: rgba(56, 189, 248, 0.05); }
        .focus-item input { width: 18px; height: 18px; cursor: pointer; accent-color: var(--accent); }

        /* --- BUTONLAR --- */
        .btn-save {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            padding: 16px 45px;
            border-radius: 18px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            display: block;
            margin-left: auto;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 15px 25px rgba(37, 99, 235, 0.3); }

        .danger-zone { border: 1px solid rgba(239, 68, 68, 0.15); background: rgba(239, 68, 68, 0.02); }
        .btn-danger { 
            color: var(--danger); 
            background: rgba(239, 68, 68, 0.1); 
            border: 1px solid var(--danger); 
            padding: 12px 24px; 
            border-radius: 14px; 
            font-weight: 600;
            cursor: pointer; 
            transition: 0.3s; 
        }
        .btn-danger:hover { background: var(--danger); color: white; }

        /* --- MOBİL UYUMLULUK --- */
        @media (max-width: 850px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; padding: 25px; }
            h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="logo">🌍 FluentLift</div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="anasayfa2.php" class="nav-link"><span>🏠</span> <b>Öğren</b></a></li>
        <li class="nav-item"><a href="profil.php" class="nav-link"><span>👤</span> <b>Profil</b></a></li>
        <li class="nav-item"><a href="seviye_belirle.php" class="nav-link"><span>📺</span> <b>İzle</b></a></li>
        <li class="nav-item"><a href="kelimeler.php" class="nav-link"><span>📚</span> <b>Sözlük</b></a></li>
        <li class="nav-item"><a href="nova/index.php" class="nav-link"><span>✨</span> <b>Nova İle Konuş</b></a></li>
        <li class="nav-item"><a href="mikro.php" class="nav-link"><span>🌟</span> <b>Gerçek Hayat</b></a></li>
        <li class="nav-item"><a href="ayarlar.php" class="nav-link active"><span>⚙️</span> <b>Ayarlar</b></a></li>
    </ul>
</nav>

<main class="main-content">
    <div class="settings-container">
        <h1>Ayarlar</h1>
        
        <?php echo $message; ?>

        <form action="" method="POST">
            <section class="settings-section">
                <div class="section-title"><i class="fas fa-user-circle"></i> Profil Bilgileri</div>
                <div class="form-group">
                    <label>Ad Soyad</label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($uName); ?>" placeholder="Adınızı girin">
                </div>
                <div class="form-group">
                    <label>E-posta Adresi</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($uEmail); ?>" placeholder="E-posta adresiniz">
                </div>
                <div class="form-group">
                    <label>İngilizce Seviyesi</label>
                    <select name="level">
                        <option value="A1">Başlangıç (A1-A2)</option>
                        <option value="B1" selected>Orta (B1-B2)</option>
                        <option value="C1">İleri (C1-C2)</option>
                    </select>
                </div>
            </section>

            <section class="settings-section">
                <div class="section-title"><i class="fas fa-bullseye"></i> Öğrenme Hedeflerim</div>
                <div class="form-group">
                    <label>Günlük Çalışma Süresi</label>
                    <select name="daily_time">
                        <option value="15">Günde 15 Dakika (Hafif)</option>
                        <option value="30" selected>Günde 30 Dakika (Düzenli)</option>
                        <option value="60">Günde 60 Dakika (Ciddi)</option>
                        <option value="120">Günde 120 Dakika (Elit)</option>
                    </select>
                </div>

                <label>Neye Odaklanmak İstiyorsun?</label>
                <div class="focus-grid">
                    <label class="focus-item"><input type="checkbox" checked> <span>Konuşma</span></label>
                    <label class="focus-item"><input type="checkbox" checked> <span>Dinleme</span></label>
                    <label class="focus-item"><input type="checkbox"> <span>Gramer</span></label>
                    <label class="focus-item"><input type="checkbox"> <span>Kelime Ezberi</span></label>
                </div>
            </section>

            <button class="btn-save" type="submit" name="update_settings">Değişiklikleri Kaydet</button>
        </form>

        <div style="margin-bottom: 30px;"></div>

        <form action="" method="POST" onsubmit="return confirm('Hesabınızı sildiğinizde her şey kalıcı olarak silinecektir. Emin misiniz?');">
            <section class="settings-section danger-zone">
                <div class="section-title" style="color: var(--danger);"><i class="fas fa-exclamation-triangle"></i> Tehlikeli Bölge</div>
                <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px;">
                    <div style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.5;">
                        Hesabınızı sildiğinizde tüm kelime listeniz, Nova ile olan konuşma geçmişiniz ve öğrenme ilerlemeniz kalıcı olarak kaybolur.
                    </div>
                    <button type="submit" name="delete_account" class="btn-danger">Hesabı Sil</button>
                </div>
            </section>
        </form>
    </div>
</main>

</body>
</html>