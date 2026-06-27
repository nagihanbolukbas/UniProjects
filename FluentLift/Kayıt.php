<?php
session_start();
require_once __DIR__ . "/db.php";

$flash = ["type" => "", "msg" => "", "open" => "login"];

function setFlash(&$flash, $type, $msg, $open = "login"){
    $flash["type"] = $type;
    $flash["msg"]  = $msg;
    $flash["open"] = $open;
}

function passwordMeetsPolicy($pass){
    return (
        strlen($pass) >= 8 &&
        preg_match('/[a-z]/', $pass) &&
        preg_match('/[A-Z]/', $pass) &&
        preg_match('/\d/', $pass) &&
        preg_match('/[^a-zA-Z0-9]/', $pass)
    );
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    // --- GİRİŞ ---
if ($action === "login") {
        $email = trim($_POST["loginEmail"] ?? "");
        $pass  = (string)($_POST["loginPass"] ?? "");

        if (!empty($email) && !empty($pass)) {
            $st = $pdo->prepare("SELECT * FROM dbo.users WHERE email = ?");
            $st->execute([$email]);
            $user = $st->fetch();

            // 1. KONTROL: Kullanıcı var mı?
            if (!$user) {
                setFlash($flash, "error", "Böyle bir kullanıcı bulunamadı.", "login");
            } 
            // 2. KONTROL: Şifre doğru mu?
            elseif (password_verify($pass, $user["password_hash"])) {
                $_SESSION["user"] = [
                    "id"     => $user["id"],
                    "name"   => $user["first_name"] . " " . $user["last_name"],
                    "email"  => $user["email"],
                    "avatar" => $user["avatar"],
                ];
                header("Location: anasayfa2.php");
                exit;
            } 
            // 3. DURUM: Kullanıcı var ama şifre yanlış
            else {
                setFlash($flash, "error", "Şifre hatalı.", "login");
            }
        } else {
            setFlash($flash, "error", "E-posta ve şifre girin.", "login");
        }
    }

    // --- KAYIT ---
    if ($action === "register") {
        $first  = trim($_POST["firstName"] ?? "");
        $last   = trim($_POST["lastName"] ?? "");
        $email  = trim($_POST["regEmail"] ?? "");
        $pass   = (string)($_POST["regPass"] ?? "");
        $avatar = trim($_POST["avatar"] ?? "");

        if (empty($avatar)) {
            setFlash($flash, "error", "Lütfen bir avatar seç.", "register");
        } elseif (!empty($first) && !empty($email) && !empty($pass)) {

            if (!passwordMeetsPolicy($pass)) {
                setFlash($flash, "error",
                    "Şifre en az 8 karakter olmalı ve büyük harf, küçük harf, sayı, özel karakter içermeli.",
                    "register"
                );
            } else {
                $chk = $pdo->prepare("SELECT id FROM dbo.users WHERE email = ?");
                $chk->execute([$email]);
                if ($chk->fetch()) {
                    setFlash($flash, "error", "Bu e-posta zaten kayıtlı.", "register");
                } else {
                    $hash = password_hash($pass, PASSWORD_BCRYPT);
                    $ins = $pdo->prepare("INSERT INTO dbo.users (first_name, last_name, email, password_hash, avatar) VALUES (?,?,?,?,?)");
                    if($ins->execute([$first, $last, $email, $hash, $avatar])) {
                        setFlash($flash, "success", "Kayıt başarılı! Şimdi giriş yapabilirsin.", "login");
                    } else {
                        setFlash($flash, "error", "Kayıt başarısız. Tekrar dene.", "register");
                    }
                }
            }
        } else {
            setFlash($flash, "error", "Lütfen tüm alanları doldurun.", "register");
        }
    }

    // --- ŞİFREMİ UNUTTUM ---
    if ($action === "forgot_set") {
        $email = trim($_POST["forgotEmail"] ?? "");
        $p1    = (string)($_POST["newPass"] ?? "");
        $p2    = (string)($_POST["newPass2"] ?? "");

        if (empty($email) || empty($p1) || empty($p2)) {
            setFlash($flash, "error", "Lütfen tüm alanları doldurun.", "forgot");
        } elseif ($p1 !== $p2) {
            setFlash($flash, "error", "Şifreler eşleşmiyor.", "forgot");
        } elseif (!passwordMeetsPolicy($p1)) {
            setFlash($flash, "error",
                "Şifre en az 8 karakter olmalı ve büyük harf, küçük harf, sayı, özel karakter içermeli.",
                "forgot"
            );
        } else {
            $st = $pdo->prepare("SELECT id FROM dbo.users WHERE email = ?");
            $st->execute([$email]);
            $u = $st->fetch();

            if (!$u) {
                setFlash($flash, "error", "Bu e-posta ile kayıtlı kullanıcı bulunamadı.", "forgot");
            } else {
                $hash = password_hash($p1, PASSWORD_BCRYPT);
                $up = $pdo->prepare("UPDATE dbo.users SET password_hash = ? WHERE id = ?");
                if ($up->execute([$hash, $u["id"]])) {
                    setFlash($flash, "success", "Şifren güncellendi! Şimdi giriş yapabilirsin.", "login");
                } else {
                    setFlash($flash, "error", "Şifre güncellenemedi. Tekrar dene.", "forgot");
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FluentLift | Giriş Yap</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --accent: #38bdf8;
            --dark-blue: #0f172a;
            --gray: #64748b;
            --white: #ffffff;
            --completed: #48b63c;
            --border: rgba(255, 255, 255, 0.1);
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; width: 100%; margin: 0; padding: 0; background: var(--dark-blue); overflow: hidden; }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex; justify-content: center; align-items: center;
            background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
        }

        .floating-icons { position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 1; pointer-events: none; }
        .bg-icon {
            position: absolute; color: var(--accent); opacity: 0.15;
            filter: drop-shadow(0 0 10px var(--accent));
            animation: floatAnim var(--d) linear infinite;
        }
        @keyframes floatAnim {
            0% { transform: translate(0, 0) rotate(0deg); opacity: 0; }
            20% { opacity: 0.2; }
            80% { opacity: 0.2; }
            100% { transform: translate(var(--x), var(--y)) rotate(360deg); opacity: 0; }
        }

        .auth-card {
            width: 100%; max-width: 440px;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(30px); border: 1px solid var(--border);
            padding: 40px; border-radius: 40px;
            box-shadow: 0 0 100px rgba(37, 99, 235, 0.15);
            z-index: 10; position: relative;
        }

        .auth-logo {
            font-size: 2.5rem; font-weight: 800; text-align: center; margin-bottom: 30px;
            background: linear-gradient(135deg, #fff 30%, var(--accent) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .auth-nav { display: flex; gap: 8px; background: rgba(0,0,0,0.3); padding: 6px; border-radius: 20px; margin-bottom: 30px; }
        .auth-nav button {
            flex: 1; padding: 12px; border: none; background: transparent;
            color: var(--gray); font-weight: 600; cursor: pointer; border-radius: 15px; transition: 0.4s;
        }
        .auth-nav button.active { background: var(--primary); color: white; box-shadow: 0 4px 20px rgba(37, 99, 235, 0.4); }

        /* Şifre Göz İkonu İçin Yeni Stiller */
        .pass-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }
        .pass-wrapper i {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            cursor: pointer;
            z-index: 5;
            transition: 0.3s;
        }
        .pass-wrapper i:hover { color: var(--accent); }
        .pass-wrapper input { margin-bottom: 0; }

        input {
            width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--border);
            padding: 16px 20px; border-radius: 18px; color: white; margin-bottom: 15px; outline: none;
            transition: 0.3s;
        }
        input:focus { border-color: var(--accent); background: rgba(255,255,255,0.08); }

        .main-btn {
            width: 100%; padding: 18px; border: none; border-radius: 20px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: 0.3s;
        }
        .main-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3); }

        .flash { padding: 10px; border-radius: 10px; text-align: center; margin-bottom: 15px; font-size: 0.9rem; }
        .flash.error { background: rgba(239, 68, 68, 0.2); color: #fca5a5; }
        .flash.success { background: rgba(34, 197, 94, 0.2); color: #86efac; }

        .footer-links { display: flex; justify-content: center; margin-top: 20px; }
        .footer-links button, .footer-links a {
            color: var(--accent); text-decoration: none; font-size: 0.85rem;
            background: transparent; border: none; cursor: pointer; font-family: inherit;
        }

        .avatar-group { display: flex; gap: 15px; justify-content: center; margin: 15px 0; }
        .avatar-item { padding: 10px; border-radius: 20px; border: 2px solid transparent; cursor: pointer; transition: 0.3s; }
        .avatar-item.active { border-color: var(--completed); background: rgba(255, 180, 0, 0.1); }
        .avatar-item img { width: 60px; height: 60px; }

        .hidden { display: none; }

        .pw-meter {
            display:flex; align-items:center; justify-content:space-between;
            margin: -6px 0 14px 0; font-size:.85rem; color: rgba(255,255,255,0.75);
        }
        .pw-pill{
            padding:6px 10px; border-radius:999px; border:1px solid var(--border);
            background: rgba(255,255,255,0.05); font-weight:700; letter-spacing:.2px;
        }
        .pw-pill.weak { color:#fca5a5; border-color: rgba(239,68,68,0.35); }
        .pw-pill.mid  { color:#fde68a; border-color: rgba(250,204,21,0.35); }
        .pw-pill.strong { color:#86efac; border-color: rgba(34,197,94,0.35); }

        .pw-hint{
            margin-top:-8px; margin-bottom:14px; font-size:.78rem;
            color: rgba(255,255,255,0.6); line-height:1.25rem;
        }
    </style>
</head>
<body>

<div class="floating-icons" id="iconContainer"></div>

<div class="auth-card">
    <div class="auth-logo">FluentLift</div>

    <div class="auth-nav">
        <button id="tabL" class="active" onclick="switchTab('l')">Giriş</button>
        <button id="tabR" onclick="switchTab('r')">Kayıt Ol</button>
    </div>

    <?php if($flash['msg']): ?>
        <div class="flash <?= htmlspecialchars($flash['type']) ?>"><?= htmlspecialchars($flash['msg']) ?></div>
    <?php endif; ?>

    <div id="boxL">
        <form method="POST">
            <input type="hidden" name="action" value="login">
            <input type="email" name="loginEmail" placeholder="E-posta Adresi" required>
            
            <div class="pass-wrapper">
                <input type="password" name="loginPass" id="loginPass" placeholder="Şifre" required>
                <i class="fas fa-eye" onclick="togglePass('loginPass', this)"></i>
            </div>

            <button type="submit" class="main-btn">Başlayalım</button>
        </form>
        <div class="footer-links">
            <button type="button" onclick="openForgot()">Şifremi Unuttum?</button>
        </div>
    </div>

    <div id="boxR" class="hidden">
        <form method="POST" id="regForm" novalidate>
            <input type="hidden" name="action" value="register">
            <div style="display:flex; gap:10px;">
                <input type="text" name="firstName" placeholder="Ad" required>
                <input type="text" name="lastName" placeholder="Soyad">
            </div>
            <input type="email" name="regEmail" placeholder="E-posta" required>

            <div class="pass-wrapper">
                <input type="password" name="regPass" id="regPass" placeholder="Şifre" required>
                <i class="fas fa-eye" onclick="togglePass('regPass', this)"></i>
            </div>

            <div class="pw-meter">
                <span>Şifre Gücü</span>
                <span class="pw-pill weak" id="pwLabelReg">Şifre Giriniz</span>
            </div>
            <div class="pw-hint">
                Şifrenizde en az 1 adet büyük harf, küçük harf, özel karakter ve rakam bulunmalıdır.
            </div>

            <div class="avatar-group">
                <div class="avatar-item" onclick="selAv(this, 'avatars/avatar-erkek.png')"><img src="avatars/avatar-erkek.png"></div>
                <div class="avatar-item" onclick="selAv(this, 'avatars/avatar-kız.png')"><img src="avatars/avatar-kız.png"></div>
            </div>
            <input type="hidden" name="avatar" id="avInput">
            <button type="submit" class="main-btn">Kayıt Ol</button>
        </form>
    </div>

    <div id="boxF" class="hidden">
        <form method="POST" id="forgotForm" novalidate>
            <input type="hidden" name="action" value="forgot_set">

            <input type="email" name="forgotEmail" placeholder="E-posta" required>

            <div class="pass-wrapper">
                <input type="password" name="newPass" id="newPass" placeholder="Yeni Şifre" required>
                <i class="fas fa-eye" onclick="togglePass('newPass', this)"></i>
            </div>

            <div class="pass-wrapper">
                <input type="password" name="newPass2" id="newPass2" placeholder="Yeni Şifre (Tekrar!)" required>
                <i class="fas fa-eye" onclick="togglePass('newPass2', this)"></i>
            </div>

            <div class="pw-meter">
                <span>Şifre Gücü</span>
                <span class="pw-pill weak" id="pwLabelForgot">Zayıf</span>
            </div>

            <button type="submit" class="main-btn">Şifreyi Güncelle</button>
        </form>

        <div class="footer-links">
            <button type="button" onclick="closeForgot()">Girişe Dön</button>
        </div>
    </div>

</div>

<script>
    // Şifre Göster/Gizle Fonksiyonu
    function togglePass(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    // Hareketli ikonlar
    const icons = ['fa-language', 'fa-globe', 'fa-book', 'fa-brain', 'fa-comments'];
    const container = document.getElementById('iconContainer');
    for(let i=0; i<20; i++) {
        const ico = document.createElement('i');
        ico.className = `fas ${icons[Math.floor(Math.random()*icons.length)]} bg-icon`;
        ico.style.left = Math.random() * 100 + "%";
        ico.style.top = Math.random() * 100 + "%";
        ico.style.setProperty('--x', (Math.random() * 400 - 200) + "px");
        ico.style.setProperty('--y', (Math.random() * -500) + "px");
        ico.style.setProperty('--d', (Math.random() * 10 + 10) + "s");
        ico.style.fontSize = (Math.random() * 20 + 20) + "px";
        container.appendChild(ico);
    }

    function switchTab(t) {
        document.getElementById('boxF').classList.add('hidden');
        document.getElementById('boxL').classList.toggle('hidden', t==='r');
        document.getElementById('boxR').classList.toggle('hidden', t==='l');
        document.getElementById('tabL').classList.toggle('active', t==='l');
        document.getElementById('tabR').classList.toggle('active', t==='r');
    }

    function openForgot(){
        document.getElementById('boxL').classList.add('hidden');
        document.getElementById('boxR').classList.add('hidden');
        document.getElementById('boxF').classList.remove('hidden');
        document.getElementById('tabL').classList.add('active');
        document.getElementById('tabR').classList.remove('active');
    }

    function closeForgot(){
        document.getElementById('boxF').classList.add('hidden');
        switchTab('l');
    }

    function selAv(el, path) {
        document.querySelectorAll('.avatar-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('avInput').value = path;
    }

    // Şifre gücü hesaplama
    function calcStrength(p){
        let score = 0;
        if(p.length >= 6) score++;
        if(p.length >= 8) score++;
        if(/[a-z]/.test(p)) score++;
        if(/[A-Z]/.test(p)) score++;
        if(/\d/.test(p)) score++;
        if(/[^a-zA-Z0-9]/.test(p)) score++;
        if(score <= 3) return {t:'Zayıf', c:'weak'};
        if(score <= 5) return {t:'Orta', c:'mid'};
        return {t:'Güçlü', c:'strong'};
    }

    function bindStrength(inputId, labelId){
        const inp = document.getElementById(inputId);
        const lab = document.getElementById(labelId);
        if(!inp || !lab) return;
        inp.addEventListener('input', () => {
            const s = calcStrength(inp.value);
            lab.textContent = s.t;
            lab.classList.remove('weak','mid','strong');
            lab.classList.add(s.c);
        });
    }

    bindStrength('regPass', 'pwLabelReg');
    bindStrength('newPass', 'pwLabelForgot');

    // Forgot client-side kontrol
    const forgotForm = document.getElementById('forgotForm');
    if(forgotForm){
        forgotForm.addEventListener('submit', (e) => {
            const p1 = document.getElementById('newPass').value;
            const p2 = document.getElementById('newPass2').value;

            const ok = p1.length >= 8 && /[a-z]/.test(p1) && /[A-Z]/.test(p1) && /\d/.test(p1) && /[^a-zA-Z0-9]/.test(p1);

            if(!ok){
                e.preventDefault();
                alert("Şifre en az 8 karakter olmalı ve büyük harf, küçük harf, sayı, özel karakter içermeli.");
                return;
            }
            if(p1 !== p2){
                e.preventDefault();
                alert("Şifreler eşleşmiyor.");
                return;
            }
        });
    }

    const open = "<?= $flash['open'] ?>";
    if(open === "register") switchTab('r');
    if(open === "forgot") openForgot();
</script>

</body>
</html>