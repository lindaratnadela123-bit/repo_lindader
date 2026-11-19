# Acara 18 — JSON Encoding dan HTTP Status Code

BKPM – Workshop SI Web Server (TIF330805) · Minggu 9 / Pertemuan 2
Lanjutan dari Acara 17 (API CRUD + MVC). Lapisan **Model** dan **Router** tidak berubah
fungsinya; yang ditambah/dirapikan adalah lapisan **Core** (`Response`) dan **Controller**.

## Cara menjalankan

1. Salin folder ini ke `htdocs` (contoh: `htdocs/BKPM/Acara18/`). Aktifkan **Apache** + **MySQL**, pastikan `mod_rewrite` aktif.
2. Buka phpMyAdmin → tab **SQL** → jalankan isi `si-akademik/db_workshop.sql`.
3. Postman → **Import** → `Acara18.postman_collection.json`.
   Variabel `base_url` bawaan: `http://localhost/bkpm/Acara18/si-akademik/public` (sesuaikan bila lokasi folder berbeda).
4. Jalankan collection lewat **Runner** (urut: *Sukses* lalu *Error*). Semua test seharusnya hijau.

## Struktur

```
Acara18/
├── Acara18.postman_collection.json   <- 15 request + test otomatis
├── README.md
└── si-akademik/
    ├── db_workshop.sql
    ├── app/
    │   ├── config/
    │   │   ├── app.php               <- BARU: konstanta APP_ENV (Mandiri 2)
    │   │   └── Database.php          <- error koneksi kini lewat Response::json()
    │   ├── core/
    │   │   ├── autoload.php
    │   │   ├── Response.php          <- Langkah 1 + parameter $errors (Mandiri 1)
    │   │   └── Router.php            <- Langkah 4 + penangkap error tak terduga (500)
    │   ├── models/Mahasiswa.php      <- tidak berubah
    │   └── controllers/MahasiswaController.php   <- Langkah 2 & 3 + validasi per field
    └── public/
        ├── .htaccess
        └── index.php                 <- memuat app.php lalu autoload
```

## Alur

```
Client ──HTTP──> public/index.php ──> Router ──> MahasiswaController ──> Mahasiswa (Model) ──> MySQL
   ^                                                    │
   └──────────── JSON (Response::json) <────────────────┘
```

## Format response (envelope seragam)

Semua response — sukses maupun gagal, dari Router maupun Controller — berbentuk:

```json
{
  "success": false,
  "message": "Validasi data gagal.",
  "data": null,
  "errors": { "nim": ["Format NIM tidak valid, harus 9 digit."] },
  "timestamp": "2026-11-18T13:11:00+07:00"
}
```

`errors` selalu berupa objek (`{}` bila kosong) agar tipenya konsisten bagi client.

## Dokumentasi endpoint

Base URL: `http://localhost/BKPM/Acara18/si-akademik/public`

| Method | Endpoint | Body | Status |
|---|---|---|---|
| GET | `/mahasiswa` | – | 200 |
| GET | `/mahasiswa?id=1` | – | 200 · 400 (id bukan bilangan bulat positif) · 404 |
| POST | `/mahasiswa` | `{"nim","nama","prodi"}` | 201 · 400 · 422 |
| PUT | `/mahasiswa?id=1` | `{"nim","nama","prodi"}` | 200 · 400 · 404 · 422 |
| DELETE | `/mahasiswa?id=1` | – | 200 · 400 · 404 |
| lainnya | `/mahasiswa` | – | 405 (header `Allow` disertakan) |
| – | `/resource-lain` | – | 404 |

Kode status mengikuti taksonomi pada modul:

| Kode | Dipakai ketika |
|---|---|
| 200 OK | GET/PUT/DELETE berhasil |
| 201 Created | POST berhasil |
| 400 Bad Request | body bukan JSON valid, field wajib kosong, parameter `id` tidak sah |
| 404 Not Found | data atau endpoint tidak ada |
| 405 Method Not Allowed | method selain GET/POST/PUT/DELETE |
| 422 Unprocessable Entity | field terisi tetapi format salah (NIM ≠ 9 digit, bukan teks, kepanjangan) |
| 500 Internal Server Error | koneksi DB gagal / error tak terduga |

Contoh error validasi (POST `{"nim":"12345","nama":123,"prodi":"TI"}`) → **422**:

```json
{
  "success": false,
  "message": "Validasi data gagal.",
  "data": null,
  "errors": {
    "nim":  ["Format NIM tidak valid, harus 9 digit."],
    "nama": ["Field nama harus berupa teks."]
  },
  "timestamp": "..."
}
```

## Tugas Praktik Mandiri

**1. Field `errors` pada `Response::json()`**
Signature kini `json(int $httpCode, bool $success, string $message, $data = null, array $errors = [])`.
Parameter baru bersifat opsional, sehingga pemanggilan lama tetap valid. `validateData()` di Controller
mengumpulkan **seluruh** kesalahan per field sekaligus (bukan berhenti di kesalahan pertama):
tahap 1 kelengkapan → 400, tahap 2 format/panjang → 422.

**2. `JSON_PRETTY_PRINT` hanya saat development**
`app/config/app.php` mendefinisikan `APP_ENV` (bawaan `development`, dapat ditimpa environment variable).
`Response::json()` menambahkan flag pretty print hanya bila `APP_ENV === 'development'`.
Detail error internal (pesan PDO) juga hanya tampil pada mode ini.

Untuk mencoba mode produksi, ubah baris di `app.php` menjadi `define('APP_ENV', 'production');`
lalu kirim ulang request — JSON akan tampil dalam satu baris dan tanpa detail error internal.

## Perbaikan tambahan di luar modul

- `validateData()` versi sebelumnya menormalisasi `$data['nim']` pada salinan lokal sehingga tidak berpengaruh; kini fungsi **mengembalikan** data yang sudah dinormalisasi (NIM jadi string, `nama`/`prodi` di-`trim`).
- Batas panjang `nama` (100) dan `prodi` (50) divalidasi → 422, mencegah error SQL "Data too long" yang berujung 500.
- Pengecekan wajib-diisi memakai pemeriksaan `null`/string kosong, bukan `empty()` yang salah menganggap `"0"` sebagai kosong.
- `Router::dispatch()` membungkus proses dengan `try/catch` sehingga error tak terduga tetap berupa JSON seragam (500), bukan halaman error PHP.
- `db_workshop.sql`: `CREATE TABLE IF NOT EXISTS`, dan data contoh memakai NIM 9 digit (sebelumnya 7 digit sehingga bertentangan dengan validasi).

## Catatan

Validasi duplikat NIM (409 Conflict) dan resource `Buku` adalah Tugas Mandiri **Acara 17**, tidak dikerjakan di sini.
