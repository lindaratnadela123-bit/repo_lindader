CREATE DATABASE IF NOT EXISTS db_workshop;
USE db_workshop;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(15) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data contoh (opsional, untuk pengujian). NIM 9 digit sesuai validasi API.
-- Jalankan sekali saja; menjalankan ulang akan menambah baris duplikat.
INSERT INTO mahasiswa (nim, nama, prodi) VALUES
('240101001', 'Budi Santoso', 'Teknik Informatika'),
('240101002', 'Siti Aminah', 'Sistem Informasi');
