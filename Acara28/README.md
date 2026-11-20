# Acara 28 — Deployment

Versi ini melanjutkan dashboard Acara27 dengan konfigurasi database berbasis
environment, batas akses CORS produksi, berkas contoh Postman Production, dan
perlindungan direktori sumber. Deployment sungguhan harus dilakukan oleh
pemilik hosting; kredensial/domain belum diberikan, jadi hanya persiapan lokal
yang dibuat.

## Jalankan lokal

1. Aktifkan Laragon Apache/MySQL.
2. Impor SQL/migrasi Acara26 jika database belum siap.
3. Buka `http://localhost/bkpm/Acara28/si-akademik/public/views/login.html`.
4. Untuk simulasi mode production, set environment PHP/Apache berdasarkan
   `si-akademik/.env.example` sebelum memuat aplikasi. `.env.example` adalah
   template, bukan file konfigurasi otomatis.
5. Untuk API lokal, impor collection dan environment Acara28; untuk template
   hosting, gunakan `Production.postman_environment.json`.

Langkah cPanel, checklist file dan database, pengalihan HTTPS, serta
Postman Production ada di folder `deploy/`.

## Praktik Mandiri

- Postman environment bernama Production dengan `base_url` domain HTTPS sebagai
  placeholder yang harus diisi setelah domain tersedia.
- Catat kendala deployment dan solusi pada `bukti/KENDALA_DEPLOYMENT.md`.
- Tidak ada proses upload atau tes tulis terhadap server produksi tanpa
  otorisasi dan kredensial dari pemilik.
