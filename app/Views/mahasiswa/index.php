<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0"><?= htmlspecialchars($title ?? 'Daftar Mahasiswa') ?></h1>
    <a href="<?= url('/mahasiswa/create') ?>" class="btn btn-primary">Tambah Mahasiswa</a>
</div>

<form action="<?= url('/mahasiswa') ?>" method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="q" class="form-control" placeholder="Cari NIM atau Nama..."
               value="<?= htmlspecialchars($keyword ?? '') ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary">Cari</button>
        <?php if (!empty($keyword)): ?>
            <a href="<?= url('/mahasiswa') ?>" class="btn btn-outline-secondary">Reset</a>
        <?php endif; ?>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Program Studi</th>
                <th>Angkatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($daftar as $i => $m): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($m['nim']) ?></td>
                    <td><?= htmlspecialchars($m['nama']) ?></td>
                    <td><?= htmlspecialchars($m['email']) ?></td>
                    <td><?= htmlspecialchars($m['prodi_nama']) ?></td>
                    <td><?= htmlspecialchars((string)$m['angkatan']) ?></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($m['status']) ?></span></td>
                    <td>
                        <a href="<?= url('/mahasiswa/' . $m['id'] . '/edit') ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="<?= url('/mahasiswa/' . $m['id'] . '/delete') ?>" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?');">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>