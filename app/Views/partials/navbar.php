<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= url('/') ?>">SI Akademik</a>
        <div class="ms-auto d-flex align-items-center gap-2">
            <?php if (!empty($_SESSION['logged_in'])): ?>
                <span class="text-light small me-2">Halo, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Admin') ?></span>
                <a href="<?= url('/mahasiswa') ?>" class="btn btn-sm btn-outline-light">Mahasiswa</a>
                <form action="<?= url('/logout') ?>" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                </form>
            <?php else: ?>
                <a href="<?= url('/login') ?>" class="btn btn-sm btn-outline-light">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>