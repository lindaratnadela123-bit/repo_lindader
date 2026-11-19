-- Tugas Mandiri Acara 17
-- Database disamakan dengan app/config/Database.php agar bisa langsung diimpor.
USE `si-akademik`;

-- 1) Tabel buku (resource baru)
CREATE TABLE IF NOT EXISTS buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO buku (judul, penulis, penerbit, tahun_terbit)
SELECT 'Pemrograman Web dengan PHP', 'Andi Wijaya', 'Informatika', 2022
WHERE NOT EXISTS (
    SELECT 1 FROM buku WHERE judul = 'Pemrograman Web dengan PHP'
);

INSERT INTO buku (judul, penulis, penerbit, tahun_terbit)
SELECT 'Basis Data Lanjut', 'Siti Rahma', 'Andi Offset', 2021
WHERE NOT EXISTS (
    SELECT 1 FROM buku WHERE judul = 'Basis Data Lanjut'
);

-- 2) Pengaman tambahan di level database: NIM unik
--    (validasi utama tetap di Model Mahasiswa)
SET @nim_index_exists = (
    SELECT COUNT(*)
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'mahasiswa'
      AND index_name = 'uq_mahasiswa_nim'
);
SET @nim_index_sql = IF(
    @nim_index_exists = 0,
    'ALTER TABLE mahasiswa ADD UNIQUE KEY uq_mahasiswa_nim (nim)',
    'SET @nim_index_exists = @nim_index_exists'
);
PREPARE nim_index_statement FROM @nim_index_sql;
EXECUTE nim_index_statement;
DEALLOCATE PREPARE nim_index_statement;
