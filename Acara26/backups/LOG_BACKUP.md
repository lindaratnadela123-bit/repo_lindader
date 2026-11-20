# Log Backup Acara26

| Tanggal / sesi | Nama berkas SQL | Database sumber | Restore diverifikasi |
|---|---|---|---|
| Isi setelah backup sesi praktikum | `db_workshop_YYYYMMDD_HHMM.sql` | Ya / Tidak | `mahasiswa`, `users`, kolom `foto` |

Perintah cadangan melalui phpMyAdmin: pilih `db_workshop` → Export → Quick →
SQL → Go. Simpan backup bertanggal di folder ini dan jangan menaruh kredensial
database di dalamnya. Lakukan restore hanya ke database percobaan.
Backup live lokal diabaikan Git melalui `.gitignore`; tetap simpan di media
cadangan privat sesuai kebijakan praktikum.

`db_workshop_acara26_demo.sql` adalah dump latihan sintetis dengan dua mahasiswa
dummy dan akun demo; target restore-nya sengaja bernama `db_workshop_recovery`.
Dump ini bukan salinan data pribadi atau backup live.
