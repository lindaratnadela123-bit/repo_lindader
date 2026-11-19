# Dokumentasi REST API - Acara 19

## Ringkasan Router

| Resource | Controller | Method/aksi | Autentikasi |
|---|---|---|---|
| `/register` | `AuthController` | `register()` | Publik |
| `/login` | `AuthController` | `login()` | Publik |
| `/mahasiswa` | `MahasiswaController` | `index()` | Publik |
| `/mahasiswa` | `MahasiswaController` | `store()` | Bearer Token |
| `/mahasiswa?id=<id>` | `MahasiswaController` | `update()` | Bearer Token |
| `/mahasiswa?id=<id>` | `MahasiswaController` | `destroy()` | Bearer Token |

Base URL: `http://localhost/bkpm/Acara19/si-akademik/public`

## POST /register

Controller: `AuthController::register()`

Headers: `Content-Type: application/json`

```json
{"username":"linda","email":"linda@example.com","password":"rahasia123"}
```

Sukses `201 Created`; email salah menghasilkan `422`; data duplikat menghasilkan `409`.

## POST /login

Controller: `AuthController::login()`

```json
{"username":"linda","password":"rahasia123"}
```

Sukses `200 OK` dengan data token JWT, `expires_in: 300`, dan role.
Kredensial salah menghasilkan `401`.

## GET /mahasiswa

Controller: `MahasiswaController::index()`

Endpoint ini publik dan menghasilkan `200 OK`.

## POST /mahasiswa

Controller: `MahasiswaController::store()`

Memerlukan:

```text
Authorization: Bearer <jwt>
Content-Type: application/json
```

```json
{"nim":"240101019","nama":"Mahasiswa Acara 19","prodi":"Teknik Informatika"}
```

Tanpa token atau token palsu menghasilkan `401`; data valid menghasilkan `201`.

## PUT /mahasiswa?id=<id>

Controller: `MahasiswaController::update()`

Memerlukan Bearer Token. Data valid menghasilkan `200`; data tidak ditemukan menghasilkan `404`.

## DELETE /mahasiswa?id=<id>

Controller: `MahasiswaController::destroy()`

Memerlukan Bearer Token. Berhasil menghasilkan `200`; data tidak ditemukan menghasilkan `404`.

## Skenario Error

| Skenario | Status |
|---|---|
| Body JSON tidak valid atau field kosong | 400 |
| Username/password salah | 401 |
| Token tidak ada, palsu, atau kedaluwarsa | 401 |
| Email tidak valid | 422 |
| Username/email sudah digunakan | 409 |
| Data atau endpoint tidak ditemukan | 404 |
