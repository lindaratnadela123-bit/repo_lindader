# Acara 27 — Integrasi Backend dan Frontend

Acara27 melanjutkan Acara26 dalam salinan proyek mandiri. Dashboard memakai
Bootstrap 5, menampilkan data/foto, dan menghubungkan form tunggal untuk
create serta edit ke API yang sama. Tombol hapus meminta konfirmasi.

## Menjalankan

1. Pastikan Laragon Apache/MySQL aktif dan database sudah memiliki tabel
   Acara26. Untuk database Acara25, jalankan
   `si-akademik/migrations/acara26_add_foto.sql` sekali.
2. Buka `http://localhost/bkpm/Acara27/si-akademik/public/views/login.html`.
3. Login `admin` / `admin123`, kemudian uji tambah, ubah, dan hapus pada
   dashboard. CDN Bootstrap memerlukan koneksi internet; fungsi form tetap
   memakai HTML native bila CDN tidak tersedia.
4. Untuk endpoint, impor `Acara27.postman_collection.json` dan
   `Acara27.postman_environment.json`.

## Praktik Mandiri

- Notifikasi visual berbeda untuk berhasil dan gagal pada operasi CRUD.
- Atribut `required`, validasi browser, validasi NIM 9 digit, dan pemeriksaan
  tipe/ukuran foto di sisi view; backend Acara26 tetap menjadi pengaman utama.
- Form tambah dan edit disatukan supaya validasi dan payload tidak terduplikasi.

## Bukti yang dicatat

Jalankan pengujian pada `bukti/VERIFIKASI.md`; tidak ada data mahasiswa
ditambahkan otomatis agar database praktikum pengguna tidak berubah.
Laporan Word menjelaskan skenario demo dan respons API yang diharapkan.
