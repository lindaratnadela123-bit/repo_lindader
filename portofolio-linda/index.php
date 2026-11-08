<?php
require __DIR__ . '/config.php';
$proyek = $pdo->query('SELECT * FROM proyek ORDER BY id DESC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Linda Ratnadela Anggraini – Portofolio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&family=Outfit:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css?v=20261108">
</head>
<body>
  <div class="glow" id="glow"></div>
  <div class="progress" id="progress"></div>

  <header class="nav">
    <nav>
      <a href="#tentang">Tentang</a>
      <a href="#proyek">Proyek</a>
      <a href="#pengalaman">Pengalaman</a>
      <a href="#aktivitas">Aktivitas</a>
      <a href="#sertifikat">Sertifikat</a>
      <a href="#kontak">Kontak</a>
    </nav>
  </header>

  <main id="top">
    <section class="hero">
      <div class="blob b1"></div><div class="blob b2"></div><div class="blob b3"></div>
      <div class="hero-inner">
        <p class="wave">Halo, saya <span class="hand">👋</span></p>
        <h1><span class="grad">LINDA RATNADELA ANGGRAINI</span></h1>
        <p class="typing">Saya seorang <span id="typed"></span><span class="caret">|</span></p>
        <p class="hero-sub">Mahasiswa D4 Teknik Informatika di Politeknik Negeri Jember dengan pengalaman mengembangkan aplikasi web dan mobile, merancang basis data, serta membangun REST API dan fitur berbasis AI.</p>
        <div class="actions">
          <a class="btn" href="#proyek">Lihat proyek</a>
          <a class="btn btn-ghost" href="#kontak">Hubungi saya</a>
        </div>
      </div>
      <figure class="photo">
        <div class="photo-in">
          <img src="img/linda-ratnadela.jpg" alt="Foto Linda Ratnadela Anggraini" onerror="this.remove()">
          <span>📷<br>Foto Linda<br>img/linda-ratnadela.jpg</span>
        </div>
        <span class="stk s1" aria-hidden="true">⭐</span><span class="stk s2" aria-hidden="true">💻</span><span class="stk s3" aria-hidden="true">✨</span>
      </figure>
    </section>

    <div class="marquee" aria-hidden="true">
      <div class="track">
        <span>HTML</span><span>CSS</span><span>JavaScript</span><span>PHP</span><span>Laravel</span><span>React</span><span>MySQL</span><span>Flutter</span><span>Java</span>
        <span>HTML</span><span>CSS</span><span>JavaScript</span><span>PHP</span><span>Laravel</span><span>React</span><span>MySQL</span><span>Flutter</span><span>Java</span>
      </div>
    </div>

    <section id="tentang" class="section reveal">
      <div>
        <h2>Tentang <span class="grad">saya</span></h2>
        <p>Saya Linda Ratnadela Anggraini, mahasiswa D4 Teknik Informatika semester 3 di Politeknik Negeri Jember. Saya memiliki pengalaman dalam pengembangan perangkat lunak, aplikasi web dan mobile, perancangan basis data, REST API, serta fitur berbasis kecerdasan buatan (AI).</p>
        <p>Saya aktif dalam organisasi kampus dan kegiatan masyarakat. Pengalaman tersebut mengasah kedisiplinan, tanggung jawab, kepemimpinan, komunikasi, koordinasi, dan kerja sama tim.</p>
        <p><strong>Pendidikan:</strong> D4 Teknik Informatika, Politeknik Negeri Jember (2025–sekarang), IP semester 2: 3,35/4,00. Sebelumnya, SMA Negeri 1 Nganjuk (2022–2025), nilai akhir 89,89/100.</p>
        <p><strong>Mata kuliah relevan:</strong> Teknologi dan Workshop Basis Data, Workshop Sistem Informasi Web Client dan Server, Workshop Mobile Applications Basic dan Advance, Manajemen Proyek, Struktur Data, Logika dan Algoritma, Analisis Desain Terstruktur dan Berorientasi Obyek, Software Quality Assurance, serta Interaksi Manusia dan Komputer.</p>
      </div>
    </section>

    <section class="section skills reveal">
      <h2><span class="grad">Keahlian</span></h2>
      <p><strong>Teknologi pemrograman:</strong> HTML, CSS, JavaScript, PHP, Laravel, React, MySQL, Flutter, dan Java.</p>
      <p><strong>Perangkat dan tools:</strong> Figma, VS Code, AutoCAD, SketchUp, Microsoft Office, Microsoft Project, Google Tools, CapCut, Canva, dan Trello.</p>
      <p><strong>Bahasa:</strong> Bahasa Inggris (Dasar), Bahasa Jepang (Dasar).</p>
      <p><strong>Non-Teknis:</strong> Kepemimpinan, Komunikasi, Berpikir Analitis, Pemecahan Masalah, Kerja Sama dan Koordinasi Tim, Manajemen Proyek, Administrasi dan Dokumentasi, Presentasi, Adaptabilitas, Pembelajaran Mandiri.</p>
    </section>

    <section id="proyek" class="section reveal">
      <h2>Proyek <span class="grad">pilihan</span></h2>
      <div class="filters">
        <button class="chip active" data-filter="all">Semua</button>
        <button class="chip" data-filter="web">Web</button>
        <button class="chip" data-filter="mobile">Mobile</button>
        <button class="chip" data-filter="iot">IoT</button>
      </div>
      <div class="projects">
<?php foreach ($proyek as $p): ?>
        <article class="card" data-cat="<?= e($p['kategori']) ?>" style="--c:var(--<?= e($p['warna']) ?>)"
          data-title="<?= e($p['judul']) ?>" data-meta="<?= e($p['meta']) ?>" data-desc="<?= e($p['deskripsi']) ?>"
          data-role="<?= e($p['peran']) ?>" data-tech="<?= e($p['teknologi']) ?>" data-result="<?= e($p['hasil']) ?>"
          data-img="<?= $p['gambar'] ? 'uploads/' . e($p['gambar']) : '' ?>"
          data-video="<?= $p['kategori'] === 'iot' ? 'uploads/project-si-padi.mp4' : '' ?>"
          data-link="<?= e($p['link'] ?? '') ?>"
          data-link-label="<?= $p['kategori'] === 'web' ? 'Lihat website Mie Sumi' : 'Lihat aplikasi Dechabooth' ?>">
          <div class="project-cover"><?php if ($p['gambar']): ?><img src="uploads/<?= e($p['gambar']) ?>" alt="Sampul <?= e($p['judul']) ?>" loading="lazy"><?php else: ?><span class="emoji"><?= e($p['emoji']) ?></span><?php endif; ?></div>
          <h3><?= e($p['judul']) ?></h3>
          <p><?= e($p['ringkasan']) ?></p>
          <?php if ($p['kategori'] === 'iot'): ?><div class="project-video project-video-card"><video controls playsinline preload="metadata" poster="uploads/<?= e($p['gambar']) ?>"><source src="uploads/project-si-padi.mp4" type="video/mp4">Browser tidak mendukung pemutaran video.</video></div><?php endif; ?>
          <?php if ($p['teknologi']): ?><p class="tech"><?= e($p['teknologi']) ?></p><?php endif; ?>
          <button type="button" class="more">Lihat detail &amp; bukti</button>
          <?php if ($p['link']): ?><a class="project-link" href="<?= e($p['link']) ?>" target="_blank" rel="noopener noreferrer"><?= $p['kategori'] === 'web' ? 'Lihat website Mie Sumi' : 'Lihat aplikasi Dechabooth' ?></a><?php endif; ?>
        </article>
<?php endforeach; ?>
<?php if (!$proyek): ?><p class="lead">Belum ada proyek. Tambahkan lewat halaman admin.</p><?php endif; ?>
      </div>
    </section>

    <section id="pengalaman" class="section reveal">
      <h2><span class="grad">Pengalaman</span></h2>
      <ol class="timeline">
        <li style="--c:var(--coral)"><time>2024 – Sekarang</time><h3>Guru Les Privat | Les TP</h3>
          <p>Memberikan bimbingan belajar secara privat kepada siswa dengan menyesuaikan metode pembelajaran berdasarkan tingkat pemahaman dan kebutuhan siswa. Bertanggung jawab dalam menjelaskan materi pelajaran, membantu penyelesaian tugas sekolah, menyusun latihan soal, serta memantau perkembangan akademik siswa guna meningkatkan pemahaman dan hasil belajar.</p></li>
        <li style="--c:var(--aqua)"><time>2026</time><h3>Software Engineer | Dechabooth (Project Based Learning)</h3>
          <ul><li>Mengembangkan aplikasi Dechabooth sebagai media pendukung pembelajaran.</li>
            <li>Merancang dan mengimplementasikan fitur aplikasi sesuai kebutuhan pengguna.</li>
            <li>Membuat dan mengelola antarmuka aplikasi agar mudah digunakan.</li>
            <li>Melakukan pengujian dan perbaikan fitur untuk meningkatkan fungsionalitas aplikasi.</li></ul></li>
        <li style="--c:var(--amber)"><time>2025</time><h3>Software Engineer | Mie Sumi (Project Based Learning)</h3>
          <ul><li>Mengembangkan sistem informasi untuk mendukung pengelolaan dan pemesanan produk Mie Sumi.</li>
            <li>Merancang fitur pengelolaan data produk dan pesanan.</li>
            <li>Mengimplementasikan fungsi sistem sesuai kebutuhan bisnis.</li>
            <li>Melakukan pengujian serta memperbaiki kesalahan sistem untuk memastikan aplikasi berjalan dengan baik.</li></ul></li>
        <li style="--c:var(--pink)"><time>2025</time><h3>Karyawan | Waiters Bebek Goreng H. Makrus</h3>
          <ul><li>Melayani pelanggan dengan ramah dan memberikan informasi terkait menu makanan dan minuman.</li>
            <li>Mencatat serta meneruskan pesanan pelanggan kepada bagian dapur.</li>
            <li>Memastikan kebersihan dan kerapian area makan sebelum dan sesudah digunakan.</li>
            <li>Berkoordinasi dengan tim dapur dan sesama pramusaji untuk menjaga kelancaran pelayanan.</li></ul></li>
        <li style="--c:var(--violet)"><time>2025</time><h3>Ketua Kelompok | SI-PADI IoT</h3>
          <p>Memimpin pengembangan Sistem Dispenser Pintar Otomatis berbasis Internet of Things di SMA Negeri 1 Nganjuk. Mengoordinasikan tugas tim dan memastikan proyek berjalan hingga menghasilkan produk yang berfungsi.</p></li>
      </ol>
    </section>

    <section id="aktivitas" class="section reveal">
      <h2>Organisasi &amp; <span class="grad">aktivitas</span></h2>
      <div class="activity-grid">
        <div>
          <h3>Organisasi</h3>
          <ul class="activity-list">
            <li><strong>Sekretaris Karang Taruna Setia Bhakti</strong> · Desa Mantub (2026–2027)<br>Mengelola administrasi, surat-menyurat, agenda, notulen, data anggota, laporan, dan dokumentasi.</li>
            <li><strong>Anggota Biro Pengembangan Akademik</strong> · HMJTI (2025–2026)<br>Mendorong pengembangan potensi mahasiswa melalui pelatihan, lomba, dan kegiatan keilmiahan.</li>
            <li><strong>Anggota PSDM Non-Akademik</strong> · Informatics Community (2025–2026)<br>Terlibat dalam penyusunan dan pelaksanaan program kerja kemahasiswaan.</li>
            <li><strong>Humas Ekstrakurikuler Paskibra</strong> · SMA Negeri 1 Nganjuk (2023–2024)<br>Mengelola komunikasi, publikasi kegiatan, dokumentasi foto dan video, serta akun media sosial.</li>
          </ul>
        </div>
        <div>
          <h3>Public speaking</h3>
          <ul class="activity-list">
            <li>Master of Ceremony · Pra-PKKMB, Jurusan Teknologi Informasi PSDKU Nganjuk (2026)</li>
            <li>Master of Ceremony · Makrab Jilid 4, Informatics Community (2026)</li>
            <li>Master of Ceremony · Puncak Malam Perayaan HUT RI, Desa Mantub (2026)</li>
            <li>Master of Ceremony · Java Tech Exhibition 3.0, Jurusan Teknologi Informasi PSDKU Nganjuk (2026)</li>
          </ul>
        </div>
        <div class="full">
          <h3>Kepanitiaan &amp; kontribusi</h3>
          <ul class="activity-list compact">
            <li>Anggota Divisi Acara · AOM Manunggalan 12.0 (Nov 2026)</li>
            <li>Anggota Divisi Keamanan · Makrab Jilid 4 (Okt 2026)</li>
            <li>Anggota Komisi Materi · LKMM Pra-TD (Okt 2026)</li>
            <li>Anggota Divisi Acara · Ospek Program Studi Teknologi Rekayasa Komputer (Sep 2026)</li>
            <li>Anggota Divisi Acara · Speakpreneur HMJTI 2026 (Sep 2026)</li>
            <li>Anggota Divisi Acara · Ospek Jurusan Teknologi Informasi 2026 (Sep 2026)</li>
            <li>Anggota Divisi Acara · Lomba HUT RI, PSDKU Nganjuk (Agu 2026)</li>
            <li>Koordinator Divisi Media Partner · Expo Pekan Ilmiah Mahasiswa (Agu 2026)</li>
            <li>Anggota Divisi Humas · Java Tech Exhibition 4.0 (Agu 2026)</li>
            <li>Master of Ceremony · Pra-PKKMB, PSDKU Nganjuk (Jul 2026)</li>
            <li>Contact Person · Penerimaan Mahasiswa Baru TIF PSDKU Nganjuk (Jun 2026)</li>
            <li>Anggota Divisi Danus · ITC (Mei 2026)</li>
            <li>Anggota Divisi Acara · Halal Bihalal HMJ-TI &amp; IMAPRODI (Apr 2026)</li>
            <li>Anggota Divisi Acara · External Relation 2026 (Apr 2026)</li>
            <li>Anggota Divisi Acara · Harmonisasi (Feb 2026)</li>
            <li>Anggota Divisi Acara · Ramadhan Berkah (RABER) 2026 (Feb 2026)</li>
            <li>Anggota Divisi Humas · Java Tech Exhibition 3.0 (Feb 2026)</li>
            <li>Anggota Divisi Humas · LDK &amp; Pelantikan Pengurus (Jan 2026)</li>
          </ul>
        </div>
      </div>
    </section>

    <section id="sertifikat" class="section reveal">
      <h2>Sertifikat &amp; <span class="grad">penghargaan</span></h2>
      <p class="lead">Pilih kartu untuk membuka dokumen PDF.</p>
      <div class="certs">
        <a class="cert" style="--c:var(--coral)" href="uploads/sertifikat-lkmm-pra-td.pdf" target="_blank" rel="noopener">
          <div class="thumb"><img src="uploads/sampul-sertifikat-lkmm-pra-td.jpg" alt="Sampul sertifikat LKMM Pra-TD" loading="lazy"></div><span class="cap"><b>LKMM Pra-TD</b><small>Peserta · Politeknik Negeri Jember · Okt 2025</small></span></a>
        <a class="cert" style="--c:var(--aqua)" href="uploads/penghargaan-poster-dechabooth.pdf" target="_blank" rel="noopener">
          <div class="thumb"><img src="uploads/sampul-penghargaan-dechabooth.jpg" alt="Sampul Juara 3 Lomba Poster Dechabooth" loading="lazy"></div><span class="cap"><b>Juara 3 Lomba Poster Dechabooth</b><small>Java Tech Exhibition 4.0 · Agu 2026</small></span></a>
        <a class="cert" style="--c:var(--amber)" href="uploads/sertifikat-ept.pdf" target="_blank" rel="noopener">
          <div class="thumb"><img src="uploads/sampul-sertifikat-ept.jpg" alt="Sampul sertifikat English Proficiency Test" loading="lazy"></div><span class="cap"><b>English Proficiency Test (EPT)</b><small>Politeknik Negeri Jember · Jun 2026</small></span></a>
        <a class="cert" style="--c:var(--violet)" href="uploads/sertifikat-lkmm-td-2026.pdf" target="_blank" rel="noopener">
          <div class="thumb"><img src="uploads/sampul-sertifikat-lkmm-td-2026.jpg" alt="Sampul sertifikat LKMM TD 2026" loading="lazy"></div><span class="cap"><b>LKMM Tingkat Dasar (LKMM TD)</b><small>Peserta · Politeknik Negeri Jember · Apr 2026</small></span></a>
      </div>
    </section>

    <section id="kontak" class="section reveal">
      <h2>Ayo <span class="grad">ngobrol</span></h2>
      <p>Punya proyek atau lowongan magang? Hubungi saya melalui email atau WhatsApp.</p>
      <form id="contact-form" class="form">
        <label>Nama <input type="text" name="nama" required></label>
        <label>Email <input type="email" name="email" required></label>
        <label>Pesan <textarea name="pesan" rows="4" required></textarea></label>
        <button class="btn" type="submit">Kirim pesan</button>
        <p id="form-status" role="status"></p>
      </form>
      <p class="links"><a href="mailto:lindaratnadela123@gmail.com">Email</a> · <a href="https://www.linkedin.com/in/linda-anggraini-120ba5446/" target="_blank" rel="noopener noreferrer">LinkedIn</a> · <a href="https://id.jobstreet.com/profiles/8zb827tm87" target="_blank" rel="noopener noreferrer">Jobstreet</a> · <a href="https://wa.me/6283846947918" target="_blank" rel="noopener noreferrer">WhatsApp</a> · <a href="https://www.instagram.com/lindaratnadelaa_/" target="_blank" rel="noopener noreferrer">Instagram</a> · <a href="https://www.tiktok.com/@lindaanggrainii_" target="_blank" rel="noopener noreferrer">TikTok</a></p>
    </section>
  </main>

    <dialog id="dlg" aria-labelledby="dlg-title">
    <button type="button" class="x" id="dlg-x" aria-label="Tutup">✕</button>
    <div class="thumb big"><img id="dlg-img" alt="" hidden><span class="ph">📷 Taruh foto bukti di folder img/</span></div>
    <div class="dbody"><h3 id="dlg-title"></h3><p class="meta" id="dlg-meta"></p><p id="dlg-desc"></p><div id="dlg-video-wrap" class="project-video" hidden><video id="dlg-video" controls playsinline preload="metadata"><source src="" type="video/mp4"></video><p class="meta">Video proyek SI-PADI IoT</p></div><a id="dlg-link" class="btn project-visit" href="" target="_blank" rel="noopener noreferrer" hidden></a><dl id="dlg-dl"></dl></div>
  </dialog>

  <footer class="footer">© <span id="year"></span> Linda Ratnadela Anggraini · <a href="admin/">Admin</a></footer>
  <script src="script.js?v=20261108"></script>
</body>
</html>
