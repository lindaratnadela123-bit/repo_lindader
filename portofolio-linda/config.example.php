<?php
const DB_HOST = 'ISI_HOST_MYSQL_INFINITYFREE';
const DB_NAME = 'ISI_NAMA_DATABASE';
const DB_USER = 'ISI_USERNAME_DATABASE';
const DB_PASS = 'ISI_PASSWORD_DATABASE';
const ADMIN_USER = '';
const ADMIN_PASS = '';

session_start();
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $ex) {
    http_response_code(500);
    exit('Koneksi database gagal. Periksa host, nama database, username, dan password hosting.');
}
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function csrf() { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16)); return $_SESSION['csrf']; }
function cek_csrf() { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(400); exit('Token tidak valid. Kembali dan coba lagi.'); } }
function wajib_login() { if (empty($_SESSION['admin'])) { header('Location: login.php'); exit; } }
