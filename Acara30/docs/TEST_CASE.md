# Matriks Pengujian — Sistem Informasi Akademik Acara30

Gunakan Postman environment Acara30 Local atau buka halaman login. Untuk
operasi tulis, pastikan database merupakan database percobaan atau telah
dicadangkan.

| Skenario | Hasil yang diharapkan |
|---|---|
| Login admin / akun user | HTTP 200; JWT dan role sesuai akun |
| User membaca `GET /mahasiswa` | HTTP 200 |
| User mencoba POST/PUT/DELETE | HTTP 403; data tidak berubah |
| Upload JPG/PNG valid <= 2 MB | HTTP 201; foto disimpan dengan nama acak |
| File selain JPG/PNG atau > 2 MB | HTTP 422; file ditolak |
| Ganti foto mahasiswa | HTTP 200; foto lama dihapus setelah update |
| NIM tidak valid/duplikat | HTTP 422 dengan error field |
| Logout / token tidak ada | Token lokal dihapus; login ditampilkan |
| Nama berisi `<b>Coba</b>` | Ditampilkan sebagai teks literal, tidak dieksekusi |
| GET mengalami gangguan jaringan | Satu retry, lalu status error yang terlihat |
| Akses `/app/config/Database.php` | HTTP 403/404 setelah `.htaccess` diterapkan |
| Disaster recovery | Tabel kembali hanya di database percobaan |

## Bukti yang sudah diverifikasi

Hasil aktual tersedia di `../bukti/VERIFIKASI.md`: autentikasi dan halaman lima
folder acara, sintaks, upload/update/delete gambar, migration idempotent,
CORS production, proteksi akses file, serta restore backup demo. Operasi
database menggunakan schema disposable dan tidak mengubah database utama.

