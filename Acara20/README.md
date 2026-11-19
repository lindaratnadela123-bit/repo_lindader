# Acara 20 — API Authentication dan Error Handling

Proyek mandiri ini meneruskan Acara19: CRUD mahasiswa, envelope JSON, registrasi,
login, dan Bearer JWT. Masa berlaku token adalah **5 menit**. Error API tetap
menggunakan envelope dan HTTP status yang konsisten.

## Menjalankan di Laragon

1. Aktifkan Apache dan MySQL.
2. Jalankan `si-akademik/db_workshop.sql` melalui phpMyAdmin.
3. Buka `http://localhost/bkpm/Acara20/si-akademik/public`.
4. Import `Acara20.postman_collection.json` serta environment Local di Postman.
5. Jalankan request berurutan: register, login, GET, lalu CRUD dengan token.

Database memakai `db_workshop` (MySQL Laragon: `root`, tanpa password secara
bawaan). Sesuaikan `app/config/Database.php` jika konfigurasi lokal berbeda.

## Endpoint

| Method | Endpoint | Auth | Hasil utama |
|---|---|---|---|
| POST | `/register` | Publik | `201`; email salah `422`; duplikat `409` |
| POST | `/login` | Publik | `200` dan JWT; kredensial salah `401` |
| GET | `/mahasiswa[?id=<id>]` | Publik | `200`; ID tidak ada `404` |
| POST | `/mahasiswa` | Bearer | `201`; tanpa token `401` |
| PUT | `/mahasiswa?id=<id>` | Bearer | `200`; input tidak valid `400/422` |
| DELETE | `/mahasiswa?id=<id>` | Bearer | `200`; data tidak ada `404` |

## Praktik Mandiri

- Token di `Auth::generateToken()` disetel 5 menit (`exp = time() + 300`) dan
  Postman menyimpan token hasil login untuk request berikutnya.
- JWT stateless tidak dapat dicabut server saat logout karena server tidak
  menyimpan sesi/token. Logout lokal hanya menghapus token client; pencabutan
  sebelum kedaluwarsa memerlukan blacklist atau mekanisme stateful.
- `Router` mengubah error tak terduga menjadi JSON HTTP 500; detail teknis
  hanya ditampilkan pada mode development.

Database tidak menyimpan token. Registrasi dan login tetap dapat diuji dengan
collection; jalankan ulang register setelah mengubah username/email.
