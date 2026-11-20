# Dokumentasi API — Sistem Informasi Akademik (Acara 30)

Base URL lokal: `http://localhost/bkpm/Acara30/si-akademik/public`

Base URL produksi: ganti `YOUR-DOMAIN.example` pada environment Postman
Production setelah domain HTTPS resmi tersedia. Tidak ada domain produksi yang
disediakan atau diklaim telah diuji.

## Peta Endpoint dan Controller

| Resource | Method | Controller/Aksi | Auth | Fungsi |
|---|---|---|---|---|
| `/register` | POST | `AuthController::register()` | Publik | Registrasi akun |
| `/login` | POST | `AuthController::login()` | Publik | Login dan penerbitan JWT |
| `/mahasiswa` | GET | `MahasiswaController::index()` | Publik | Membaca semua data |
| `/mahasiswa?id={id}` | GET | `MahasiswaController::index()` | Publik | Membaca satu data |
| `/mahasiswa` | POST | `MahasiswaController::store()` | Admin JWT | Menambah data |
| `/mahasiswa?id={id}` | PUT | `MahasiswaController::update()` | Admin JWT | Memperbarui data |
| `/mahasiswa?id={id}` | DELETE | `MahasiswaController::destroy()` | Admin JWT | Menghapus data |

Semua response API memakai envelope `success`, `message`, `data`, `errors`,
dan `timestamp`. Sertakan `Content-Type: application/json` untuk request JSON.
Create juga mendukung `multipart/form-data` dengan field `foto` opsional (JPG/PNG,
maksimal 2 MB). Dashboard mengirim edit sebagai POST dengan `_method=PUT`,
`id` di query, dan Bearer token agar PHP dapat membaca file multipart; klien
API dapat memakai PUT dengan JSON seperti biasa.

## Autentikasi

### POST `/register`

Request:

```json
{"username":"linda","email":"linda@example.com","password":"rahasia123"}
```

`201` berisi ID pengguna. Email tidak valid menghasilkan `422`; username/email
terpakai menghasilkan `409`.

### POST `/login`

Request: `{"username":"linda","password":"rahasia123"}`

Sukses `200` mengembalikan `data.token`, `data.expires_in` (300 detik), dan
`data.role`. Kredensial salah menghasilkan `401`.

## Mahasiswa

### GET `/mahasiswa[?id={id}]`

Publik. Tanpa ID mengembalikan array; dengan ID mengembalikan satu objek.
Format ID tidak valid menghasilkan `400`; ID yang tidak ditemukan `404`.

### POST `/mahasiswa`

Bearer JWT dengan role admin diperlukan. Body:
`{"nim":"240101019","nama":"Mahasiswa API","prodi":"Teknik Informatika"}`.
Foto multipart bersifat opsional; server memverifikasi MIME dan konten gambar,
membuat nama acak, dan tidak mempercayai nama file dari pengguna.
Sukses `201`; body/field tidak lengkap `400`; format atau panjang salah `422`;
token hilang/tidak valid `401`; token role user ditolak `403`; NIM duplikat
`422` dengan detail di `errors.nim`.

### PUT `/mahasiswa?id={id}`

Bearer JWT dengan role admin diperlukan. Menggunakan body yang sama dengan POST.
Sukses `200`; token role user ditolak `403`; ID tidak valid `400`; data tidak
ditemukan `404`; validasi mengikuti POST.

### DELETE `/mahasiswa?id={id}`

Bearer JWT dengan role admin diperlukan. Sukses `200`; token role user ditolak
`403`; ID tidak valid `400`; data tidak ditemukan `404`; token hilang/tidak
valid `401`.

## Role-Based Access Control

`GET /mahasiswa` tetap publik. `POST`, `PUT`, dan `DELETE` memanggil
`Auth::requireAdmin()`; role `user` menerima `403 Forbidden`, sekalipun
tombol pengelolaan telah disembunyikan oleh frontend.

## Contoh Envelope Error

```json
{
  "success": false,
  "message": "Validasi data gagal.",
  "data": null,
  "errors": {"nim":["Format NIM tidak valid, harus 9 digit."]},
  "timestamp": "2026-11-18T12:00:00+00:00"
}
```

Postman collection berisi contoh request dan test status otomatis, sehingga
dapat dipakai untuk membuat/meninjau dokumentasi Collection Postman.
