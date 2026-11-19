<?php
require '../config.php'; wajib_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
cek_csrf();
$id = (int)($_POST['id'] ?? 0);
$s = $pdo->prepare('SELECT gambar FROM proyek WHERE id = ?'); $s->execute([$id]);
$gambar = $s->fetchColumn();
$pdo->prepare('DELETE FROM proyek WHERE id = ?')->execute([$id]);
if ($gambar) @unlink('../uploads/' . basename($gambar));
$_SESSION['flash'] = 'Proyek dihapus.';
header('Location: index.php');
