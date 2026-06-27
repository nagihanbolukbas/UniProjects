<?php
$server = "localhost\\MSSQLSERVER04";
$db     = "fluentlift";
$user   = "fluent_user";
$pass   = "GucluBirSifre_123!";

try {
    $pdo = new PDO(
        "sqlsrv:Server=$server;Database=$db;TrustServerCertificate=1",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("DB HATA: " . $e->getMessage());
}