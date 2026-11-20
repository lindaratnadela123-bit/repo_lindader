# Acara 26 — Upload Foto dan Backup Database

Folder ini adalah kelanjutan runnable dari Acara25. Fitur CRUD mahasiswa
menerima foto JPG/PNG (maks. 2 MB), menyimpan nama file acak di
`si-akademik/public/uploads/`, dan membersihkan foto lama saat foto diganti
atau data dihapus. Backend tetap memeriksa role admin; validasi browser bukan
pengganti validasi server.

## Menjalankan di Laragon

1. Salin folder `Acara26` ke `C:\laragon\www\bkpm\Acara26`, aktifkan Apache dan
   MySQL, lalu buat database `db_workshop`.
2. Jika database baru, impor `si-akademik/db_workshop.sql` lewat phpMyAdmin.
   Jika meneruskan database Acara25, jalankan
   `si-akademik/migrations/acara26_add_foto.sql`.
3. Buka `http://localhost/bkpm/Acara26/si-akademik/public/views/login.html`.
   Akun praktikum: `admin` / `admin123`.
4. Login, tambahkan mahasiswa dengan foto JPG/PNG di bawah 2 MB; ubah foto
   untuk memeriksa penghapusan file lama. Uji pula file non-gambar dan file
   terlalu besar; keduanya harus ditolak API.
5. Untuk endpoint, impor `Acara26.postman_collection.json` dan
   `Acara26.postman_environment.json` di Postman.

## Backup / restore

Pada akhir sesi, dari PowerShell jalankan
`.\backups\backup_db.ps1`. Script mencari `mysqldump`, menghasilkan dump
bertanggal, lalu mencatat hasil di `backups/LOG_BACKUP.md`. Bila akun MySQL
memakai password, tambahkan `-PromptForPassword`. Alternatifnya pilih
`db_workshop` di phpMyAdmin → Export → SQL. Untuk latihan, pulihkan dump hanya
ke database percobaan; jangan menghapus tabel pada database utama.

## Isi Praktik Mandiri

- Penghapusan foto lama setelah update berhasil dan setelah data dihapus.
- Backup terjadwal pada penutupan tiap sesi praktikum, dicatat di log backup.
- Migrasi kolom `foto` idempotent untuk database dari Acara25.

Lihat `Laporan_Acara26.docx` untuk tujuan, desain, cuplikan kode, bukti
verifikasi, hasil, serta naskah penjelasan presentasi.
