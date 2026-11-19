-- Tugas Mandiri Acara 17
-- Jalankan pada database yang dipakai aplikasi (sesuai app/config/Database.php)

-- 1) Tabel buku (resource baru)
CREATE TABLE IF NOT EXISTS buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO buku (judul, penulis, penerbit, tahun_terbit) VALUES
('Pemrograman Web dengan PHP', 'Andi Wijaya', 'Informatika', 2022),
('Basis Data Lanjut', 'Siti Rahma', 'Andi Offset', 2021);

-- 2) Pengaman tambahan di level database: NIM unik
--    (validasi utama tetap di Model Mahasiswa)
ALTER TABLE mahasiswa ADD UNIQUE KEY uq_mahasiswa_nim (nim);
