# Verifikasi Acara27

| Skenario | Langkah | Hasil yang diharapkan |
|---|---|---|
| Field kosong | Klik Tambah tanpa mengisi field | Browser menahan submit dan menunjuk field wajib |
| NIM tidak valid | Isi NIM selain 9 digit | Pesan validasi view tampil; API tidak dipanggil |
| Tambah | Isi data valid, pilih foto JPG/PNG <= 2MB | Notifikasi sukses, data/foto tampil setelah refresh list |
| Tolak foto | Pilih file non-gambar atau > 2MB | Notifikasi gagal; backend juga mengembalikan 422 |
| Ubah | Ubah salah satu field, simpan | Notifikasi sukses; row diambil ulang |
| Hapus | Klik Hapus lalu konfirmasi | Notifikasi sukses; row hilang |
| Role user | Login sebagai user | Form dan aksi admin tidak ditampilkan; API tetap menolak mutasi dengan 403 |

Verifikasi aktual: halaman login Acara27 mengembalikan HTTP 200, login
non-mutasi mengembalikan HTTP 200 dengan role `admin`, dan seluruh PHP/JS lolos
syntax check. Uji operasi tulis di atas merupakan skenario demo manual dan
sengaja tidak dijalankan terhadap database utama pengguna.
