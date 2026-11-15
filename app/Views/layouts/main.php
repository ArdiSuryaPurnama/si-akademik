<!DOCTYPE html>
<html lang="id">
<?php include __DIR__ . '/../partials/header.php'; ?>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<main class="container mt-4">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert alert-<?= htmlspecialchars($_SESSION['flash']['type']) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['flash']['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php require $content; ?>
</main>
<?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>