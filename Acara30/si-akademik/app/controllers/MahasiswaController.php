<?php
class MahasiswaController {
    private Mahasiswa $model;

    public function __construct() {
        $this->model = new Mahasiswa();
    }

    /** GET /mahasiswa  atau  GET /mahasiswa?id=1 */
    public function index(): void {
        $id = $_GET['id'] ?? null;
        if ($id !== null && $id !== '') {
            if (!$this->validId($id)) {
                Response::json(400, false, 'Parameter id harus berupa bilangan bulat positif.');
            }
            $data = $this->model->find((int) $id);
            if (!$data) {
                Response::json(404, false, 'Data mahasiswa tidak ditemukan.');
            }
            Response::json(200, true, 'Data berhasil diambil.', $data);
        }
        Response::json(200, true, 'Data berhasil diambil.', $this->model->getAll());
    }

    /** POST /mahasiswa */
    public function store(): void {
        Auth::requireAdmin();
        $data = $this->validateData($this->readRequestData());
        if ($this->model->findByNim($data['nim'])) {
            Response::json(422, false, 'Validasi data gagal.', null, [
                'nim' => ['NIM sudah terdaftar.'],
            ]);
        }
        $data['foto'] = $this->storePhoto($_FILES['foto'] ?? null);
        $id   = $this->model->create($data);
        Response::json(201, true, 'Data berhasil ditambahkan.', ['id' => $id]);
    }

    /** PUT /mahasiswa?id=1 */
    public function update($id): void {
        Auth::requireAdmin();
        if ($id === null || $id === '') {
            Response::json(400, false, 'Parameter id wajib diisi untuk memperbarui data.');
        }
        if (!$this->validId($id)) {
            Response::json(400, false, 'Parameter id harus berupa bilangan bulat positif.');
        }
        $id = (int) $id;
        $existing = $this->model->find($id);
        if (!$existing) {
            Response::json(404, false, 'Data mahasiswa tidak ditemukan.');
        }
        $data = $this->validateData($this->readRequestData());
        if ($this->model->findByNim($data['nim'], $id)) {
            Response::json(422, false, 'Validasi data gagal.', null, [
                'nim' => ['NIM sudah terdaftar.'],
            ]);
        }
        $oldPhoto = $existing['foto'] ?? null;
        $newPhoto = $this->storePhoto($_FILES['foto'] ?? null);
        $data['foto'] = $newPhoto ?? $oldPhoto;
        $this->model->update($id, $data);
        if ($newPhoto !== null) {
            $this->removePhoto($oldPhoto);
        }
        Response::json(200, true, 'Data berhasil diperbarui.', ['id' => $id]);
    }

    /** DELETE /mahasiswa?id=1 */
    public function destroy($id): void {
        Auth::requireAdmin();
        if ($id === null || $id === '') {
            Response::json(400, false, 'Parameter id wajib diisi untuk menghapus data.');
        }
        if (!$this->validId($id)) {
            Response::json(400, false, 'Parameter id harus berupa bilangan bulat positif.');
        }
        $id = (int) $id;
        $mahasiswa = $this->model->find($id);
        if (!$mahasiswa) {
            Response::json(404, false, 'Data mahasiswa tidak ditemukan.');
        }
        $this->model->delete($id);
        $this->removePhoto($mahasiswa['foto'] ?? null);
        Response::json(200, true, 'Data berhasil dihapus.', ['id' => $id]);
    }

    /** Membaca JSON atau field multipart/form-data untuk upload berkas. */
    private function readRequestData(): array {
        if ($_POST !== []) {
            return $_POST;
        }
        $raw  = file_get_contents('php://input');
        $data = json_decode($raw, true);
        if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
            Response::json(400, false, 'Body harus berisi JSON atau form data yang valid.');
        }
        return $data;
    }

    /** Menyimpan gambar yang tervalidasi dengan nama acak, bukan nama dari client. */
    private function storePhoto(?array $file): ?string {
        if ($file === null || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'] ?? '')) {
            Response::json(422, false, 'Upload foto gagal atau berkas tidak valid.');
        }
        if (($file['size'] ?? 0) <= 0 || $file['size'] > 2 * 1024 * 1024) {
            Response::json(422, false, 'Ukuran foto harus lebih dari 0 dan maksimal 2MB.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
        $image = @getimagesize($file['tmp_name']);
        if (!isset($extensions[$mime]) || $image === false || $image['mime'] !== $mime) {
            Response::json(422, false, 'Foto harus berupa gambar JPG atau PNG yang valid.');
        }

        $directory = __DIR__ . '/../../public/uploads';
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            Response::json(500, false, 'Folder penyimpanan foto tidak dapat dibuat.');
        }
        try {
            $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        } catch (Throwable $e) {
            Response::json(500, false, 'Nama berkas foto tidak dapat dibuat.');
        }
        if (!move_uploaded_file($file['tmp_name'], $directory . '/' . $filename)) {
            Response::json(500, false, 'Foto gagal disimpan.');
        }
        return $filename;
    }

    private function removePhoto(?string $filename): void {
        if ($filename === null || !preg_match('/^[a-f0-9]{32}\.(jpg|png)$/', $filename)) {
            return;
        }
        $path = __DIR__ . '/../../public/uploads/' . $filename;
        if (is_file($path) && !unlink($path)) {
            error_log('Gagal menghapus foto mahasiswa: ' . $filename);
        }
    }

    /**
     * Validasi dua tahap, seluruh kesalahan dikumpulkan per field (Tugas Mandiri 1):
     *   1) Field wajib kosong/tidak ada          -> 400 Bad Request
     *   2) Field ada tetapi formatnya tidak sah  -> 422 Unprocessable Entity
     *
     * @return array data yang sudah dinormalisasi (nim string, teks di-trim)
     */
    private function validateData(array $data): array {
        $required = ['nim', 'nama', 'prodi'];

        // Tahap 1: kelengkapan field
        $errors = [];
        foreach ($required as $field) {
            $value = $data[$field] ?? null;
            if ($value === null || (is_string($value) && trim($value) === '')) {
                $errors[$field][] = "Field $field wajib diisi.";
            }
        }
        if ($errors) {
            Response::json(400, false, 'Field nim, nama, dan prodi wajib diisi.', null, $errors);
        }

        // Tahap 2: format & batas panjang (sesuai ukuran kolom tabel)
        $nim = $data['nim'];
        if ((!is_string($nim) && !is_int($nim)) || !preg_match('/^[0-9]{9}$/', (string) $nim)) {
            $errors['nim'][] = 'Format NIM tidak valid, harus 9 digit.';
        }

        $limits = ['nama' => 100, 'prodi' => 50];
        foreach ($limits as $field => $max) {
            $value = $data[$field];
            if (!is_string($value)) {
                $errors[$field][] = "Field $field harus berupa teks.";
            } elseif ($this->textLength(trim($value)) > $max) {
                $errors[$field][] = "Field $field maksimal $max karakter.";
            }
        }
        if ($errors) {
            Response::json(422, false, 'Validasi data gagal.', null, $errors);
        }

        return [
            'nim'   => (string) $nim,
            'nama'  => trim($data['nama']),
            'prodi' => trim($data['prodi']),
        ];
    }

    /** Panjang teks dalam karakter (bukan byte); aman bila ekstensi mbstring nonaktif. */
    private function textLength(string $text): int {
        return function_exists('mb_strlen') ? mb_strlen($text, 'UTF-8') : strlen($text);
    }

    private function validId($id): bool {
        return (is_int($id) || is_string($id)) && preg_match('/^[1-9][0-9]*$/', (string) $id) === 1;
    }
}
