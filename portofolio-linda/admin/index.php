<?php
require '../config.php'; require 'layout.php'; wajib_login();
$daftar = $pdo->query('SELECT * FROM proyek ORDER BY id DESC')->fetchAll();
$flash = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']);
head('Kelola proyek'); ?>
<div class="top">
  <h1>Kelola proyek</h1>
  <a class="btn" href="form.php">+ Tambah proyek</a>
</div>
<?php if ($flash): ?><div class="flash"><?= e($flash) ?></div><?php endif; ?>
<div class="panel">
  <table>
    <thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($daftar as $p): ?>
      <tr>
        <td><?php if ($p['gambar']): ?><img class="th" src="../uploads/<?= e($p['gambar']) ?>" alt=""><?php else: ?><span class="th"><?= e($p['emoji']) ?></span><?php endif; ?></td>
        <td><strong><?= e($p['judul']) ?></strong><br><span class="hint"><?= e($p['ringkasan']) ?></span></td>
        <td><?= e($p['kategori']) ?></td>
        <td class="act">
          <a class="sm" href="form.php?id=<?= (int)$p['id'] ?>">Edit</a>
          <form method="post" action="hapus.php" onsubmit="return confirm('Hapus proyek ini? Tindakan ini tidak bisa dibatalkan.')">
            <input type="hidden" name="csrf" value="<?= csrf() ?>">
            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
            <button class="sm danger" type="submit">Hapus</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$daftar): ?><tr><td colspan="4">Belum ada proyek. Klik "Tambah proyek".</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
<?php foot();
