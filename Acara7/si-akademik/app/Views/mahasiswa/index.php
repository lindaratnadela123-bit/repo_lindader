<div class="card shadow">
    <div class="card-body">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
            <h2 class="card-title mb-0">Data Mahasiswa</h2>
            <a href="<?= BASE_URL ?>/mahasiswa/create" class="btn btn-success">
                + Tambah Mahasiswa
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($mahasiswa)): ?>
                        <?php foreach ($mahasiswa as $mhs): ?>
                            <tr>
                                <td><?= htmlspecialchars($mhs->getNim()) ?></td>
                                <td><?= htmlspecialchars($mhs->getNama()) ?></td>
                                <td><?= htmlspecialchars($mhs->getProdi()) ?></td>
                                <td><?= htmlspecialchars($mhs->getAngkatan()) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/mahasiswa/edit?nim=<?= urlencode($mhs->getNim()) ?>"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form method="POST" action="<?= BASE_URL ?>/mahasiswa/delete" class="d-inline"
                                        onsubmit="return confirm('Hapus data ini?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="nim" value="<?= htmlspecialchars($mhs->getNim()) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data mahasiswa.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>