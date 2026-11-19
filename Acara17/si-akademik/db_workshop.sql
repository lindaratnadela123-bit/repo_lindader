CREATE DATABASE IF NOT EXISTS `si-akademik`;
USE `si-akademik`;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(15) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Data contoh (opsional, untuk pengujian)
INSERT INTO mahasiswa (nim, nama, prodi)
SELECT '2024001', 'Budi Santoso', 'Teknik Informatika'
WHERE NOT EXISTS (SELECT 1 FROM mahasiswa WHERE nim = '2024001');

INSERT INTO mahasiswa (nim, nama, prodi)
SELECT '2024002', 'Siti Aminah', 'Sistem Informasi'
WHERE NOT EXISTS (SELECT 1 FROM mahasiswa WHERE nim = '2024002');
