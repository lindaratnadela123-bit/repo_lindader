# Acara 29 — Keandalan dan Keamanan Tampilan

Acara29 melanjutkan proyek Acara28. Dashboard memberikan indikator loading,
error/sukses memakai elemen status yang aman, validasi CRUD dan penonaktifan
tombol saat proses, serta escaping output melalui `textContent`/DOM API.

## Menjalankan

1. Pastikan Laragon Apache/MySQL aktif, database dan migrasi Acara26 sudah
   diterapkan, lalu buka
   `http://localhost/bkpm/Acara29/si-akademik/public/views/login.html`.
2. Login `admin` / `admin123`; uji daftar data, operasi CRUD, dan nama yang
   berisi `<b>Coba</b>`. Teks tersebut harus tampil sebagai teks literal, bukan
   tebal/HTML.
3. Untuk menguji retry GET, gunakan browser DevTools Network, atur throttling
   Offline sesaat ketika data dimuat, lalu pulihkan jaringan sebelum retry
   otomatis. Jika kedua percobaan gagal, pesan error tampil.
4. Untuk endpoint, impor `Acara29.postman_collection.json` dan
   `Acara29.postman_environment.json`.

## Praktik Mandiri

- Semua data API ditampilkan lewat `textContent`, `createElement`, atribut DOM
  terkontrol, dan teks status; tidak ada penyusunan HTML dari input pengguna.
- Retry otomatis satu kali hanya untuk GET yang aman diulang. Operasi tulis
  tidak diulang otomatis karena respons jaringan yang hilang dapat terjadi
  setelah server telanjur menyimpan perubahan.

Bukti dan skenario rinci tersedia di `bukti/VERIFIKASI.md`.
Uji retry tanpa dependensi: `node .\si-akademik\tests\api_retry.test.js`.
