
CREATE TABLE IF NOT EXISTS proyek (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(120) NOT NULL,
  ringkasan VARCHAR(255) NOT NULL,
  deskripsi TEXT,
  kategori ENUM('web','mobile','iot') NOT NULL DEFAULT 'web',
  teknologi VARCHAR(150),
  peran VARCHAR(150),
  hasil VARCHAR(255),
  meta VARCHAR(150),
  emoji VARCHAR(8) DEFAULT '💻',
  warna ENUM('coral','aqua','amber','pink','violet') NOT NULL DEFAULT 'coral',
  gambar VARCHAR(255),
  link VARCHAR(255),
  dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4;

UPDATE proyek
SET kategori = 'web'
WHERE kategori NOT IN ('web','mobile','iot');

ALTER TABLE proyek
  MODIFY kategori ENUM('web','mobile','iot') NOT NULL DEFAULT 'web';


INSERT INTO `proyek` (`id`, `judul`, `ringkasan`, `deskripsi`, `kategori`, `teknologi`, `peran`, `hasil`, `meta`, `emoji`, `warna`, `gambar`, `link`, `dibuat`) VALUES
('1', 'Dechabooth', 'Aplikasi Android pendukung pembelajaran.', 'Mengembangkan aplikasi Dechabooth sebagai media pendukung pembelajaran; merancang dan mengimplementasikan fitur sesuai kebutuhan pengguna; mengelola antarmuka; serta menguji dan memperbaiki fungsionalitas aplikasi.', 'mobile', 'Mobile Android', 'Software Engineer', 'Pengujian dan perbaikan fitur', 'Project Based Learning ? 2026', '??', 'coral', 'project-dechabooth.jpg', 'https://pameran-jti.polije.ac.id/product/623/dechabooth-aplication', '2026-11-07 11:45:29'),
('2', 'Sistem Informasi Mie Sumi', 'Website pemesanan online Mie Ayam Bu Suyatmi.', 'Website digitalisasi UMKM Mie Ayam Bu Suyatmi. Pelanggan dapat melihat menu mie ayam, bakso, dan minuman, memilih jumlah dan metode delivery atau pickup, serta mengakses profil usaha, kontak, dan lokasi.', 'web', 'Website ? Basis data', 'Software Engineer', 'Pemesanan menu secara online', 'Project Based Learning ? 2025', '??', 'aqua', 'project-miesumi.jpg', 'https://pameran-jti.polije.ac.id/product/539/miesumi-pemesanan-mie-ayam-bu-suyatmi', '2026-11-07 11:45:29'),
('3', 'SI-PADI IoT', 'Sistem Dispenser Pintar Otomatis berbasis Internet of Things.', 'Memimpin tim dalam pengembangan Sistem Dispenser Pintar Otomatis berbasis IoT di SMA Negeri 1 Nganjuk, mengoordinasikan pembagian tugas, dan memastikan tahapan proyek berjalan hingga menghasilkan produk yang berfungsi.', 'iot', 'Internet of Things (IoT)', 'Ketua kelompok', 'Produk dispenser otomatis berfungsi', 'Project Based Learning ? 2025', '??', 'amber', 'project-si-padi.png', '', '2026-11-07 11:45:29');
