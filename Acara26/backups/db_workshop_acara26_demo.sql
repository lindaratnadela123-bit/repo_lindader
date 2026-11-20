CREATE DATABASE IF NOT EXISTS db_workshop_recovery;
USE db_workshop_recovery;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(15) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_mahasiswa_nim (nim)
);

INSERT INTO mahasiswa (nim, nama, prodi)
SELECT '240101001', 'Budi Santoso', 'Teknik Informatika'
WHERE NOT EXISTS (SELECT 1 FROM mahasiswa WHERE nim = '240101001');
INSERT INTO mahasiswa (nim, nama, prodi)
SELECT '240101002', 'Siti Aminah', 'Sistem Informasi'
WHERE NOT EXISTS (SELECT 1 FROM mahasiswa WHERE nim = '240101002');

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', '$2y$10$0FsnpIAa8zJwX5XlwKuGvekjR3Ao2/XAKf8CcqlPimIxUnv3MsYwG', 'admin')
ON DUPLICATE KEY UPDATE
    email = VALUES(email),
    password = VALUES(password),
    role = 'admin';
