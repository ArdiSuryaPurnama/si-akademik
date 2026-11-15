<div class="container" style="max-width:600px">
    <h1 class="h3 mb-4">Tambah Mahasiswa</h1>
    <form action="<?= url('/mahasiswa') ?>" method="POST">
        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" name="nim" class="form-control" placeholder="Contoh: E41251140" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Program Studi</label>
            <select name="prodi_id" class="form-select" required>
                <?php foreach ($prodiList as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['kode'] . ' - ' . $p['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Angkatan</label>
                <input type="number" name="angkatan" class="form-control" value="<?= date('Y') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif">Aktif</option>
                    <option value="cuti">Cuti</option>
                    <option value="lulus">Lulus</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="<?= url('/mahasiswa') ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>