# Acara 19 - Postman dan API Authentication

Acara 19 melanjutkan API CRUD dan response envelope dari Acara 18. Proyek ini
menambahkan registrasi pengguna, login, JWT sederhana, dan perlindungan method
POST/PUT/DELETE pada `MahasiswaController`.

## Cara Menjalankan

1. Aktifkan Apache dan MySQL pada Laragon.
2. Jalankan `si-akademik/db_workshop.sql` pada phpMyAdmin atau MySQL.
3. Buka base URL:
   `http://localhost/bkpm/Acara19/si-akademik/public`
4. Import `Acara19.postman_collection.json` ke Postman.
5. Jalankan request Register, Login, lalu gunakan variabel token untuk CRUD.

## Akun Uji

Registrasi akun baru melalui `POST /register`.

```json
{"username":"linda","email":"linda@example.com","password":"rahasia123"}
```

## Endpoint

| Method | Endpoint | Auth | Fungsi |
|---|---|---|---|
| POST | `/register` | Tidak | Registrasi pengguna |
| POST | `/login` | Tidak | Login dan penerbitan JWT |
| GET | `/mahasiswa` | Tidak | Membaca seluruh mahasiswa |
| GET | `/mahasiswa?id=<id>` | Tidak | Membaca satu mahasiswa |
| POST | `/mahasiswa` | Bearer Token | Menambah mahasiswa |
| PUT | `/mahasiswa?id=<id>` | Bearer Token | Mengubah mahasiswa |
| DELETE | `/mahasiswa?id=<id>` | Bearer Token | Menghapus mahasiswa |

## Alur Autentikasi

```text
Client -> POST /login -> AuthController -> User -> password_verify
       -> Auth::generateToken() -> JWT berlaku 5 menit
       -> Authorization: Bearer <token>
       -> Auth::requireAuth() -> MahasiswaController
```

## Tugas Praktik Mandiri

- Validasi format email menggunakan `filter_var()` pada `User::create()`.
- Masa berlaku JWT dipendekkan menjadi 5 menit.
- Collection menyertakan environment Local dan Staging.
- JWT stateless tidak memiliki logout sisi server tanpa blacklist atau mekanisme stateful.
