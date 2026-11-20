# Hasil Simulasi Disaster Recovery

| Tahap | Bukti |
|---|---|
| Database recovery terisolasi dibuat | `db_workshop_recovery` (hanya data dummy) |
| Kondisi awal | Tabel `mahasiswa` dan `users` |
| Gangguan simulasi | Tabel `mahasiswa` dihapus dari database recovery |
| Pemulihan | SQL contoh Acara26 diimpor ulang |
| Kondisi akhir | Kedua tabel tersedia dan data mahasiswa dummy kembali |
| Database utama | Tidak diubah |
| Waktu uji | 2026-11-20; script menyelesaikan seluruh tahap tanpa error |

Pengujian ini menggunakan schema sementara yang dihapus otomatis setelah
verifikasi. Jangan menyatakan restore live telah dilakukan; yang diuji adalah
dump sintetis untuk praktikum.
