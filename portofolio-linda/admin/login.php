<?php
require '../config.php'; require 'layout.php';
if (!empty($_SESSION['admin'])) { header('Location: index.php'); exit; }
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cek_csrf();
    if (ADMIN_USER !== '' && ADMIN_PASS !== '' && hash_equals(ADMIN_USER, (string)($_POST['user'] ?? '')) && hash_equals(ADMIN_PASS, (string)($_POST['pass'] ?? ''))) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        header('Location: index.php'); exit;
    }
    $err = 'Username atau password salah.';
}
head('Masuk'); ?>
<div class="panel login">
  <h1>Masuk admin</h1>
  <?php if ($err): ?><div class="error"><p><?= e($err) ?></p></div><?php endif; ?>
  <form method="post" class="form">
    <input type="hidden" name="csrf" value="<?= csrf() ?>">
    <label>Username <input type="text" name="user" required autofocus></label>
    <label>Password <input type="password" name="pass" required></label>
    <button class="btn" type="submit">Masuk</button>
  </form>
</div>
<?php foot();
