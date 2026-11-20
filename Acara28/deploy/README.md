# Persiapan deployment Acara28

Deployment eksternal tidak dijalankan: domain, akun hosting, dan kredensial
produksi belum tersedia. File ini menyiapkan checklist dan konfigurasi, bukan
mengaku aplikasi telah diunggah.

1. Pastikan tes lokal selesai; ekspor `db_workshop` melalui phpMyAdmin.
2. Buat database/user khusus di cPanel dan berikan hak minimum yang diperlukan.
3. Jika hosting memungkinkan, tempatkan `app/` di luar document root dan arahkan
   document root domain ke `si-akademik/public/`. Jangan unggah SQL backup ke
   folder yang dapat diakses web.
4. Atur environment server dari `.env.example` (file contoh ini tidak dibaca
   otomatis): `APP_ENV=production`, `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.
   Jangan menaruh password produksi pada repository.
5. Jika frontend dipisah domain, isi `CORS_ALLOWED_ORIGIN` dengan origin tepat;
   untuk frontend satu origin tidak diperlukan konfigurasi CORS.
6. Impor `Production.postman_environment.json`, ganti `base_url` dengan domain
   HTTPS yang benar, lalu jalankan request baca/login yang disetujui pemilik
   sistem. Jangan memakai kredensial praktikum untuk produksi.
7. Aktifkan SSL/AutoSSL, pasang aturan dari `https-redirect.htaccess.example`,
   nonaktifkan `display_errors`, aktifkan `log_errors`, dan uji URL menuju
   `app/` serta file SQL harus menghasilkan 403/404.

Pada Laragon, akses biasa tetap HTTP localhost dan kredensial bawaan tetap
berfungsi. `.htaccess` menolak akses langsung ke `app/`, `migrations/`,
`backups/`, dan SQL.
