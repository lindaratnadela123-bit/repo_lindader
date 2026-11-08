<?php
function head($judul) { ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($judul) ?> – Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&family=Outfit:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="admin.css">
</head>
<body class="admin">
  <header class="nav">
    <a class="logo" href="index.php">Admin</a>
    <nav>
      <a href="../index.php" target="_blank">Lihat situs</a>
      <?php if (!empty($_SESSION['admin'])): ?><a href="logout.php">Keluar</a><?php endif; ?>
    </nav>
  </header>
  <main class="wrap">
<?php }
function foot() { ?>
  </main>
</body>
</html>
<?php }
