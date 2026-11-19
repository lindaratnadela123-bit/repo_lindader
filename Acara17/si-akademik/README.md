# Acara 17 - REST API MVC

Proyek ini menyediakan REST API sederhana untuk resource `mahasiswa` dan `buku` menggunakan PHP, PDO, MySQL, dan pola MVC.

## Menjalankan aplikasi dengan Laragon

1. Pastikan PHP 8 atau lebih baru dan MySQL aktif di Laragon.
2. Buka phpMyAdmin, lalu impor file SQL dengan urutan berikut:
   - `db_workshop.sql` untuk membuat database `si-akademik` dan tabel mahasiswa.
   - `db_acara17_tugas_mandiri.sql` untuk membuat tabel buku, data contoh, dan unique index NIM.
3. Periksa kredensial database di `app/config/Database.php`. Nilai awal proyek ini adalah host `localhost`, database `si-akademik`, user `root`, dan password kosong.
4. Pastikan Apache dan MySQL berjalan. Buka:
   - `http://localhost/bkpm/Acara17/si-akademik/public/mahasiswa`
   - `http://localhost/bkpm/Acara17/si-akademik/public/buku`
5. Untuk menguji seluruh skenario, impor `../Acara17.postman_collection.json` ke Postman. Jika lokasi proyek berbeda, ubah variabel `base_url` di collection agar menunjuk ke folder `public`.

Kedua file SQL dapat dijalankan ulang tanpa menggandakan data contoh atau menambahkan unique index yang sama berulang kali.

### Alternatif: PHP development server

Dari folder `si-akademik`, jalankan:

```powershell
php -S 127.0.0.1:8000 -t public public/index.php
```

Kemudian gunakan `http://127.0.0.1:8000` sebagai `base_url` Postman, misalnya `http://127.0.0.1:8000/buku`.

## Alur aplikasi

```text
Client/Postman
      |
      v
public/index.php  (front controller; memuat autoloader)
      |
      v
Router             (memilih resource dan method HTTP)
      |
      v
BukuController / MahasiswaController  (validasi dan bentuk response JSON)
      |
      v
Buku / Mahasiswa   (query PDO prepared statement)
      |
      v
MySQL              (database si-akademik)
      |
      +---- hasil kembali sebagai JSON ke client
```

Contoh: `POST /buku` diterima oleh front controller, lalu Router memilih `BukuController::store()`. Controller memeriksa isi JSON, Model `Buku` menyimpan data dengan prepared statement, dan Controller mengirim response JSON dengan status `201 Created`.

## Endpoint

Semua endpoint berada di bawah `base_url` dan menerima/mengembalikan JSON.

| Method | Path | Fungsi | Request body |
|---|---|---|---|
| GET | `/mahasiswa` | Mengambil semua mahasiswa | - |
| GET | `/mahasiswa?id=1` | Mengambil mahasiswa berdasarkan ID | - |
| POST | `/mahasiswa` | Menambah mahasiswa | `{"nim":"2024003","nama":"Dewi Lestari","prodi":"Sistem Informasi"}` |
| PUT | `/mahasiswa?id=1` | Memperbarui mahasiswa | `{"nim":"2024001","nama":"Budi Santoso","prodi":"Teknik Informatika"}` |
| DELETE | `/mahasiswa?id=1` | Menghapus mahasiswa | - |
| GET | `/buku` | Mengambil semua buku | - |
| GET | `/buku?id=1` | Mengambil buku berdasarkan ID | - |
| POST | `/buku` | Menambah buku | `{"judul":"Jaringan Komputer","penulis":"Budi","penerbit":"Erlangga","tahun_terbit":2023}` |
| PUT | `/buku?id=1` | Memperbarui buku | `{"judul":"Jaringan Komputer Edisi 2","penulis":"Budi","penerbit":"Erlangga","tahun_terbit":2023}` |
| DELETE | `/buku?id=1` | Menghapus buku | - |

Status yang umum diuji: `200` berhasil membaca/mengubah/menghapus, `201` berhasil menambah, `400` body tidak valid/lengkap, `404` ID atau endpoint tidak ditemukan, dan `409` NIM mahasiswa sudah digunakan.

Response sukses tambah data, misalnya:

```json
{
  "success": true,
  "message": "Data berhasil ditambahkan",
  "data": {
    "id": "3"
  }
}
```

Response ketika NIM duplikat:

```json
{
  "success": false,
  "message": "NIM sudah terdaftar"
}
```

## Penjelasan untuk presentasi

- **Router** tidak mengakses database; tugasnya memetakan URL dan method HTTP ke Controller.
- **Controller** menangani request, memvalidasi input, memanggil Model, lalu menentukan status HTTP dan response JSON.
- **Model** berisi query database. Parameter SQL dikirim melalui PDO prepared statement, sehingga nilai input tidak digabung langsung ke query.
- NIM diperiksa di Model untuk memberi pesan yang mudah dipahami, dan unique index `uq_mahasiswa_nim` di MySQL menjadi perlindungan tambahan agar nilai yang sama tetap ditolak.
- Pemisahan tersebut membuat penambahan resource `buku` mengikuti pola yang sama tanpa mencampur routing, validasi, dan query SQL ke satu file.
