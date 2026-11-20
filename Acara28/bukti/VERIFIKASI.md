# Verifikasi Acara28

- Halaman dan endpoint login lokal Laragon: HTTP 200.
- Environment Postman Production valid JSON dengan base URL HTTPS placeholder.
- Mode `APP_ENV=production`: origin yang sama dengan `CORS_ALLOWED_ORIGIN`
  memperoleh header allow-origin yang tepat; origin lain tidak memperoleh
  header tersebut.
- Request API dengan konfigurasi database production yang tidak lengkap
  menghasilkan HTTP 500 dengan pesan konfigurasi yang jelas dan aman.
- Akses langsung ke `app/config/Database.php` dan `db_workshop.sql` dari web
  menghasilkan HTTP 403 pada Laragon.
- Syntax check PHP/JavaScript Acara28: PASS.

Hosting publik, AutoSSL, dan environment cPanel belum diuji karena akses
produksi/domain belum diberikan.
