# Verifikasi Acara26

| Pemeriksaan | Hasil aktual |
|---|---|
| PHP lint pada seluruh berkas backend | PASS |
| Halaman login Acara26 melalui Apache Laragon | HTTP 200 |
| Login admin pada endpoint Acara26 | HTTP 200; role `admin` |
| Kolom `foto` pada migration | Diuji dua kali pada database sementara; kolom muncul satu kali |
| Script backup | Export database sintetis menghasilkan SQL dan diverifikasi; file sementara dibersihkan |
| Backup/restore Acara26 | Dump contoh berhasil memulihkan dua mahasiswa dan satu user; database utama tidak disentuh |
| Upload end-to-end | Diuji pada salinan final Acara30; file invalid 422, create 201, update 200, file lama terhapus, delete 200 dan foto terhapus |

Uji upload lengkap tersedia pada sistem integrasi Acara30 karena perilaku
backend upload sama pada setiap snapshot. Operasi terhadap data Acara25 tidak
dijalankan otomatis.
