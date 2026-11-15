<div class="container" style="max-width:600px">
    <h1 class="h3 mb-4">Edit Mahasiswa</h1>
    <form action="<?= url('/mahasiswa/' . $mhs['id'] . '/update') ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" name="nim" class="form-control" value="<?= htmlspecialchars($mhs['nim']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($mhs['nama']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($mhs['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Program Studi</label>
            <select name="prodi_id" class="form-select" required>
                <?php foreach ($prodiList as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $mhs['prodi_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['kode'] . ' - ' . $p['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Angkatan</label>
                <input type="number" name="angkatan" class="form-control" value="<?= htmlspecialchars((string)$mhs['angkatan']) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <?php foreach (['aktif', 'cuti', 'lulus'] as $st): ?>
                        <option value="<?= $st ?>" <?= $mhs['status'] === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= url('/mahasiswa') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>