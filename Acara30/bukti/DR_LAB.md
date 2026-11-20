# Simulasi Disaster Recovery yang aman

Gunakan database **`db_workshop_recovery`** saja. Jangan jalankan `DROP TABLE`
pada `db_workshop` atau database hosting. Backup contoh berasal dari Acara26,
berisi data dummy, dan menargetkan database recovery.

## Langkah phpMyAdmin

1. Pastikan database `db_workshop_recovery` belum dipakai untuk data lain. Buat
   database tersebut jika belum ada.
2. Pilih database recovery, impor
   `Acara26/backups/db_workshop_acara26_demo.sql`, lalu pastikan tabel
   `mahasiswa` dan `users` tersedia.
3. Sebelum menghapus, pilih database recovery dan jalankan
   `SELECT DATABASE();`. Pastikan hasil persis `db_workshop_recovery`.
4. Hapus hanya tabel latihan `mahasiswa` pada database recovery. Verifikasi
   bahwa `users` tetap ada dan `mahasiswa` tidak ada.
5. Impor ulang file SQL demo Acara26 yang sama. Script membuat ulang tabel
   `mahasiswa` dan menjaga seed contoh tetap idempotent.
6. Jalankan `SHOW TABLES;` dan `SELECT nim, nama, foto FROM mahasiswa;`.
   Tabel/data contoh harus kembali. Catat waktu dan hasil pada
   `DR_LAB_HASIL.md`.

## Via Laragon terminal

```powershell
mysql -u root < C:\laragon\www\bkpm\Acara26\backups\db_workshop_acara26_demo.sql
mysql -u root db_workshop_recovery -e "SELECT DATABASE(); SHOW TABLES;"
mysql -u root db_workshop_recovery -e "DROP TABLE mahasiswa;"
mysql -u root < C:\laragon\www\bkpm\Acara26\backups\db_workshop_acara26_demo.sql
mysql -u root db_workshop_recovery -e "SHOW TABLES; SELECT nim,nama,foto FROM mahasiswa;"
```

Jika root MySQL Laragon memiliki password, tambahkan opsi autentikasi sesuai
konfigurasi lokal. Periksa nama database sebelum setiap perintah yang mengubah
data. Backup contoh ini bukan backup live; untuk pemulihan data sebenarnya,
pilih export bertanggal dari `Acara26/backups/`.
