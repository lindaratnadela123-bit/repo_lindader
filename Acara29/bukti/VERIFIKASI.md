# Verifikasi Acara29

Pemeriksaan yang benar-benar dijalankan: semua file PHP/JS lolos syntax check,
halaman/login Acara29 mengembalikan HTTP 200, dan ketiga kasus pada uji retry
Node berstatus PASS.

1. Lint JavaScript: `node --check si-akademik/public/views/api.js` dan
   `node --check si-akademik/public/views/dashboard.js`.
2. Jalankan `node si-akademik/tests/api_retry.test.js`; hasil PASS membuktikan
   GET mencoba paling banyak dua kali, POST mutasi tidak diulang, dan error
   tetap diteruskan setelah retry habis.
3. Uji memuat halaman dan dataset: indikator Bootstrap tampil saat GET
   berlangsung lalu hilang ketika selesai.
4. Uji error: matikan koneksi atau hentikan server; setelah GET gagal dua kali,
   status menampilkan pesan gagal dan tidak membuat tabel kosong tampak sukses.
5. Uji escaping dengan nama `<b>Coba</b>`: elemen tabel menampilkan tanda kurung
   dan tag literal. `makeCell()` menaruh konten melalui `textContent`.
6. Uji retry: GET memperoleh paling banyak dua percobaan; POST/PUT/DELETE tidak
   diulang untuk menghindari mutasi ganda.

Test tulis menggunakan database praktikum dilakukan manual dengan persetujuan
pengguna; tidak dijalankan otomatis pada database yang sudah berisi data.
