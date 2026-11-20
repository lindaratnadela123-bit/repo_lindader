# Bukti Verifikasi Acara30

## Pemeriksaan yang dijalankan

| Uji | Hasil aktual |
|---|---|
| Syntax check PHP backend Acara26–30 | PASS semua |
| Syntax check JavaScript Acara26–30 | PASS semua |
| Smoke test lima folder: halaman login | HTTP 200 |
| Smoke test lima folder: login akun praktikum | HTTP 200, role `admin` |
| Foto non-gambar | HTTP 422 |
| Tambah data+PNG di database disposable | HTTP 201; foto tersimpan |
| Ubah data+foto melalui POST `_method=PUT` | HTTP 200; foto lama sudah tidak ada |
| Hapus data dengan Bearer admin | HTTP 200; file foto terhapus |
| Migrasi Acara26 dijalankan dua kali pada database disposable | PASS; satu kolom `foto` |
| Disaster recovery dari backup demo Acara26 | PASS; 2 mahasiswa dan 1 user kembali |
| Akses file `app/config/Database.php` | HTTP 403 |
| Akses `db_workshop.sql` | HTTP 403 |
| CORS production | Origin di allowlist mendapat header; origin lain tidak |
| Konfigurasi DB production kosong | HTTP 500 dengan pesan aman tentang konfigurasi database |
| Retry fetch Acara29 dan Acara30 | 3 test PASS pada masing-masing folder |

Database `db_workshop_acara30_test`, database migration-test, dan database
`db_workshop_recovery` dibuat hanya untuk pengujian dan dihapus setelah selesai.
Tidak ada operasi tulis atau penghapusan tabel pada database utama `db_workshop`.

## Demo manual untuk kelas

Login → tambah data dan foto → ubah data/foto → hapus → uji role user → masukkan
teks `<b>Coba</b>` → jelaskan status loading, notifikasi dan retry. Detail
penjelasan ada di `PANDUAN_PRESENTASI.md`.
