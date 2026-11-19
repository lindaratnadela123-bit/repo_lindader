<div class="card shadow">
    <div class="card-body">

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
            <h2 class="card-title mb-0">Data Mahasiswa</h2>
           <a href="<?= $base ?>/?halaman=create">
           Tambah Mahasiswa
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
                                   <a href="<?= $base ?>/mahasiswa/edit?nim=<?= urlencode($mhs->getNim()) ?>">
                                    Edit
                                    </a>
                                   <a href="<?= $base ?>/mahasiswa/delete?nim=<?= urlencode($mhs->getNim()) ?>">
                                   Hapus
                                  </a>
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
