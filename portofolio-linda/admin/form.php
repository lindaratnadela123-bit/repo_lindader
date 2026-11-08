<?php
require '../config.php'; require 'layout.php'; wajib_login();
$id = (int)($_GET['id'] ?? 0);
$p = ['judul'=>'','ringkasan'=>'','deskripsi'=>'','kategori'=>'web','teknologi'=>'','peran'=>'','hasil'=>'','meta'=>'','emoji'=>'💻','warna'=>'coral','link'=>'','gambar'=>''];
if ($id) {
    $s = $pdo->prepare('SELECT * FROM proyek WHERE id = ?'); $s->execute([$id]);
    $row = $s->fetch();
    if (!$row) { http_response_code(404); exit('Proyek tidak ditemukan.'); }
    $p = $row;
}
$err = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cek_csrf();
    foreach (['judul','ringkasan','deskripsi','teknologi','peran','hasil','meta','emoji','link'] as $k) $p[$k] = trim($_POST[$k] ?? '');
    $p['emoji'] = mb_substr($p['emoji'], 0, 4) ?: '💻';
    $p['kategori'] = in_array($_POST['kategori'] ?? '', ['web','mobile','iot'], true) ? $_POST['kategori'] : 'web';
    $p['warna'] = in_array($_POST['warna'] ?? '', ['coral','aqua','amber','pink','violet'], true) ? $_POST['warna'] : 'coral';
    if ($p['judul'] === '') $err[] = 'Judul wajib diisi.';
    if ($p['ringkasan'] === '') $err[] = 'Ringkasan wajib diisi.';
    if ($p['link'] !== '' && !preg_match('~^https?://~i', $p['link'])) $err[] = 'Link harus diawali http:// atau https://';
    $baru = null;
    if (!empty($_FILES['gambar']['name'])) {
        $f = $_FILES['gambar'];
        $mime = $f['error'] === UPLOAD_ERR_OK ? (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']) : '';
        $ext = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$mime] ?? null;
        if (!$ext) $err[] = 'Gambar harus berformat JPG, PNG, atau WebP.';
        elseif ($f['size'] > 2 * 1024 * 1024) $err[] = 'Ukuran gambar maksimal 2 MB.';
        else $baru = bin2hex(random_bytes(8)) . '.' . $ext;
    }
    if (!$err) {
        if ($baru) {
            if (!is_dir('../uploads')) mkdir('../uploads', 0755, true);
            move_uploaded_file($f['tmp_name'], '../uploads/' . $baru);
            if ($p['gambar']) @unlink('../uploads/' . basename($p['gambar']));
            $p['gambar'] = $baru;
        }
        $kol = ['judul','ringkasan','deskripsi','kategori','teknologi','peran','hasil','meta','emoji','warna','link','gambar'];
        $data = array_intersect_key($p, array_flip($kol));
        if ($id) {
            $sql = 'UPDATE proyek SET ' . implode(',', array_map(fn($k) => "$k = :$k", $kol)) . ' WHERE id = :id';
            $pdo->prepare($sql)->execute($data + ['id' => $id]);
            $_SESSION['flash'] = 'Proyek diperbarui.';
        } else {
            $sql = 'INSERT INTO proyek (' . implode(',', $kol) . ') VALUES (' . implode(',', array_map(fn($k) => ":$k", $kol)) . ')';
            $pdo->prepare($sql)->execute($data);
            $_SESSION['flash'] = 'Proyek ditambahkan.';
        }
        header('Location: index.php'); exit;
    }
}
head($id ? 'Edit proyek' : 'Tambah proyek'); ?>
<div class="top"><h1><?= $id ? 'Edit proyek' : 'Tambah proyek' ?></h1><a class="sm" href="index.php">Kembali</a></div>
<?php if ($err): ?><div class="error"><?php foreach ($err as $m): ?><p><?= e($m) ?></p><?php endforeach; ?></div><?php endif; ?>
<div class="panel">
<form method="post" enctype="multipart/form-data" class="form">
  <input type="hidden" name="csrf" value="<?= csrf() ?>">
  <div class="fgrid">
    <label class="full">Judul proyek <input type="text" name="judul" maxlength="120" required value="<?= e($p['judul']) ?>"></label>
    <label class="full">Ringkasan (tampil di kartu) <input type="text" name="ringkasan" maxlength="255" required value="<?= e($p['ringkasan']) ?>"></label>
    <label class="full">Deskripsi lengkap (tampil di jendela detail) <textarea name="deskripsi" rows="4"><?= e($p['deskripsi']) ?></textarea></label>
    <label>Kategori
      <select name="kategori"><?php foreach (['web'=>'Web','mobile'=>'Mobile','iot'=>'IoT'] as $v => $t): ?>
        <option value="<?= $v ?>" <?= $p['kategori'] === $v ? 'selected' : '' ?>><?= $t ?></option><?php endforeach; ?></select></label>
    <label>Warna kartu
      <select name="warna"><?php foreach (['coral'=>'Koral','aqua'=>'Aqua','amber'=>'Kuning','pink'=>'Pink','violet'=>'Ungu'] as $v => $t): ?>
        <option value="<?= $v ?>" <?= $p['warna'] === $v ? 'selected' : '' ?>><?= $t ?></option><?php endforeach; ?></select></label>
    <label>Teknologi <input type="text" name="teknologi" maxlength="150" value="<?= e($p['teknologi']) ?>"></label>
    <label>Peran kamu <input type="text" name="peran" maxlength="150" value="<?= e($p['peran']) ?>"></label>
    <label>Hasil / pencapaian <input type="text" name="hasil" maxlength="255" value="<?= e($p['hasil']) ?>"></label>
    <label>Keterangan (misal: Proyek kuliah · 2024) <input type="text" name="meta" maxlength="150" value="<?= e($p['meta']) ?>"></label>
    <label>Emoji <input type="text" name="emoji" maxlength="8" value="<?= e($p['emoji']) ?>"></label>
    <label>Link proyek / demo <span class="hint">(opsional, awali https://)</span> <input type="text" name="link" maxlength="255" value="<?= e($p['link']) ?>"></label>
    <label class="full">Gambar / screenshot <span class="hint">(JPG, PNG, WebP, maks. 2 MB)</span> <input type="file" name="gambar" accept="image/jpeg,image/png,image/webp"></label>
    <?php if ($p['gambar']): ?><div class="full"><span class="hint">Gambar saat ini (unggah baru untuk mengganti):</span><br><img class="preview" src="../uploads/<?= e($p['gambar']) ?>" alt=""></div><?php endif; ?>
  </div>
  <button class="btn" type="submit"><?= $id ? 'Simpan perubahan' : 'Simpan proyek' ?></button>
</form>
</div>
<?php foot();
