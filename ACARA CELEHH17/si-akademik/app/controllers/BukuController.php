<?php
class BukuController {
    private Buku $model;

    public function __construct() {
        $this->model = new Buku();
    }

    public function index(): void {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? null;

        if ($id) {
            $data = $this->model->find((int) $id);
            if (!$data) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
                exit;
            }
            echo json_encode(['success' => true, 'data' => $data]);
            exit;
        }

        echo json_encode(['success' => true, 'data' => $this->model->getAll()]);
    }

    public function store(): void {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$this->valid($data)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Field judul, penulis, penerbit, dan tahun_terbit wajib diisi']);
            exit;
        }

        $id = $this->model->create($data);
        http_response_code(201);
        echo json_encode(['success' => true, 'message' => 'Data berhasil ditambahkan', 'data' => ['id' => $id]]);
    }

    public function update($id): void {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$id || !$this->model->find((int) $id)) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
            exit;
        }
        if (!$this->valid($data)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Field judul, penulis, penerbit, dan tahun_terbit wajib diisi']);
            exit;
        }

        $this->model->update((int) $id, $data);
        echo json_encode(['success' => true, 'message' => 'Data berhasil diperbarui']);
    }

    public function destroy($id): void {
        header('Content-Type: application/json');

        if (!$id || !$this->model->find((int) $id)) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
            exit;
        }

        $this->model->delete((int) $id);
        echo json_encode(['success' => true, 'message' => 'Data berhasil dihapus']);
    }

    // Validasi sederhana: semua field wajib ada dan tidak kosong
    private function valid($data): bool {
        return is_array($data)
            && !empty($data['judul'])
            && !empty($data['penulis'])
            && !empty($data['penerbit'])
            && !empty($data['tahun_terbit']);
    }
}
