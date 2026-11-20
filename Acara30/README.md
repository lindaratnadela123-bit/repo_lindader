# Acara 30 — Finalisasi dan Serah Terima Proyek

Acara30 melanjutkan Acara29 dan menyatukan hasil acara 26–30 di folder ini:
upload/manajemen foto, CRUD terintegrasi, deployment-ready configuration,
feedback dan validasi view, loading/error handling, output aman, serta
disaster-recovery lab yang tidak menyentuh database utama.

## Menjalankan lokal

1. Salin folder acara ke `C:\laragon\www\bkpm\Acara30`.
2. Jalankan Apache dan MySQL di Laragon.
3. Buat database `db_workshop`; impor `si-akademik/db_workshop.sql` untuk
   instalasi baru. Untuk database Acara25 yang sudah ada, jalankan
   `si-akademik/migrations/acara26_add_foto.sql`.
4. Buka `http://localhost/bkpm/Acara30/si-akademik/public/views/login.html`.
   Akun praktikum lokal: `admin` / `admin123`.
5. Impor `Acara30.postman_collection.json` dan
   `Acara30.postman_environment.json` untuk uji lokal; Production env hanya
   boleh diarahkan ke domain resmi.
6. Jalankan syntax check:

   ```powershell
   Get-ChildItem .\si-akademik\app -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
   node --check .\si-akademik\public\views\api.js
   node --check .\si-akademik\public\views\dashboard.js
   node --check .\si-akademik\public\views\login.js
   node .\si-akademik\tests\api_retry.test.js
   ```

Untuk menjalankan simulasi restore di database dummy yang dibuat lalu
dihapus otomatis, jalankan `php .\tools\verify_recovery.php`. Script berhenti
tanpa perubahan jika `db_workshop_recovery` sudah ada.

Lihat `docs/` untuk endpoint/OpenAPI, `bukti/` untuk test, disaster-recovery
lab, dan panduan presentasi, serta `deploy/` untuk checklist hosting.
Deployment internet tidak dijalankan karena domain/kredensial belum diberikan.

## Praktikum mandiri Acara30

- Proteksi `app/`, `migrations/`, `backups/`, dan SQL dari akses browser.
- Template pengalihan HTTPS dan PHP production settings.
- Disaster recovery terhadap **database uji terpisah**, memakai demo backup
  Acara26.
- Naskah presentasi yang merangkum MVC, auth, testing dan deployment.
