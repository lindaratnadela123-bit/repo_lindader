# Catatan Kendala Deployment

| Kendala | Dampak | Solusi / status |
|---|---|---|
| Domain dan akun cPanel belum diberikan | Tidak dapat mengunggah aplikasi, mengaktifkan AutoSSL, atau menguji konfigurasi hosting | Menyiapkan checklist dan environment Postman template; lakukan langkah produksi setelah akses resmi tersedia |
| Password database tidak boleh disimpan di source | Koneksi produksi perlu konfigurasi server | `Database.php` membaca `DB_HOST`, `DB_NAME`, `DB_USER`, dan `DB_PASS` dari environment |
| Bootstrap memakai CDN | Tampilan Bootstrap tidak termuat saat offline | HTML tetap dapat dipakai dengan style browser; salin Bootstrap lokal jika deployment harus offline |

Tidak ada bukti deployment eksternal yang diklaim pada laporan.
