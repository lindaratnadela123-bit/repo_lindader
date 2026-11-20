# Naskah Presentasi Acara26–30

## Alur demo (5–7 menit)

1. **Konteks (30 detik):** proyek meneruskan MVC dan JWT Acara25; Controller
   memakai Model `Mahasiswa`, Router memilih aksi, dan View dashboard memanggil
   REST API.
2. **Upload (1 menit):** login admin, pilih JPG/PNG, jelaskan batas 2 MB,
   validasi MIME/konten, nama acak, dan penyimpanan di `public/uploads`.
3. **CRUD (1 menit):** tambah, ubah dan hapus data; tunjukkan notifikasi, field
   wajib, token Bearer, serta role user menerima 403.
4. **Kualitas View (1 menit):** tunjukkan status loading/error; input
   `<b>Coba</b>` dirender sebagai teks memakai `textContent`; GET retry satu
   kali, tetapi request tulis tidak diulang untuk menghindari mutasi ganda.
5. **Deployment (1 menit):** terangkan environment database, document root ke
   `public/`, larangan menyimpan password di repository, HTTPS, dan proteksi
   direktori `app/`. Tegaskan hosting eksternal belum diuji karena domain belum
   tersedia.
6. **Pemulihan (1 menit):** gunakan database `db_workshop_recovery` untuk
   menghapus tabel dummy lalu pulihkan dari dump Acara26; jangan menyentuh
   database utama.

## Diagram arsitektur

```text
Browser (login/dashboard, Bootstrap)
  -> public/index.php (CORS + Front Controller)
  -> app/core/Router.php -> AuthController / MahasiswaController
  -> app/models/User.php / Mahasiswa.php -> PDO MySQL
  -> JSON response envelope -> DOM aman (textContent)

Upload foto -> validasi MIME + ukuran -> public/uploads/nama-acak
Deployment -> document root public/; app/ dan database di luar web root
```

## Tanya jawab singkat

- **Mengapa validasi ada di browser dan server?** Browser memberi UX cepat,
  tetapi request dapat dibuat tanpa UI; server tetap otoritatif.
- **Mengapa file memakai nama acak?** Nama asli tidak dipercaya dan tidak
  dipakai sebagai path, mengurangi risiko traversal/overwrite.
- **Mengapa mutasi tidak di-retry otomatis?** Koneksi dapat putus setelah
  server menyimpan data; pengulangan berpotensi membuat perubahan ganda.
- **Apa batas hasil deployment?** Hanya paket dan konfigurasi disiapkan;
  deployment publik perlu domain, kredensial, dan persetujuan pemilik.
