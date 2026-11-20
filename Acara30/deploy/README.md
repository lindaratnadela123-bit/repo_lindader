# Checklist serah terima Acara30

Deployment produksi belum dilakukan karena domain dan akses hosting tidak
tersedia. Jangan menyalin placeholder sebagai kredensial nyata.

1. Pastikan PHP 8+, PDO MySQL, Fileinfo, dan GD/Exif yang diperlukan tersedia;
   gunakan Apache dengan `mod_rewrite`/`AllowOverride` atau sesuaikan routing.
2. Ekspor database lokal melalui phpMyAdmin. Simpan file SQL di lokasi privat,
   bukan di `public_html`.
3. Tempatkan `app/`, `migrations/`, dan backup di luar document root. Arahkan
   document root ke `si-akademik/public/`. `app/.htaccess` adalah lapisan
   tambahan, bukan pengganti document root yang benar.
4. Atur kredensial database melalui environment hosting. `Database.php`
   menolak konfigurasi tanpa `DB_USER` pada `APP_ENV=production`; password
   produksi tidak disimpan di repository.
5. Aktifkan AutoSSL/HTTPS terlebih dahulu. Terapkan aturan dari
   `https-redirect.htaccess.example`; uji URL HTTP dan HTTPS agar tidak terjadi
   redirect loop.
6. Nonaktifkan `display_errors`, aktifkan `log_errors`, dan arahkan log ke
   lokasi privat menggunakan pengaturan seperti `php-production.ini.example`.
7. Impor `Production.postman_environment.json` dari folder Acara30, ganti base URL dengan
   domain HTTPS resmi, kemudian jalankan test yang diizinkan.
8. Uji akses langsung ke `/app/config/Database.php`, `/migrations/`, dan
   `db_workshop.sql`; ketiganya tidak boleh dapat diunduh.
9. Jadwalkan backup harian, uji restore ke database terpisah, dan catat waktu,
   versi backup, serta hasil verifikasi tabel.

## Disaster recovery lokal

Lihat `../bukti/DR_LAB.md`. Berkas
`../../Acara26/backups/db_workshop_acara26_demo.sql` hanya berisi data contoh
untuk lab yang terisolasi; file itu tidak berisi database pribadi pengguna.
