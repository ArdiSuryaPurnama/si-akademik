<?php
$method = $_SERVER['REQUEST_METHOD'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cek Method Request</title>
</head>
<body>
  <h1>Deteksi Method Request</h1>

  <?php if ($method === 'POST'): ?>
    <p style="color:green"><b>Halaman ini diakses dengan method POST.</b></p>
    <p>Data yang dikirim: <?= htmlspecialchars($_POST['pesan'] ?? '(kosong)') ?></p>
  <?php else: ?>
    <p style="color:blue"><b>Halaman ini diakses dengan method GET.</b></p>
    <p>Data di URL: <?= htmlspecialchars($_GET['pesan'] ?? '(kosong)') ?></p>
  <?php endif; ?>

  <hr>
  <h3>Kirim dengan GET</h3>
  <form action="check_method.php" method="GET">
    <input type="text" name="pesan" placeholder="Tulis pesan">
    <button type="submit">Kirim GET</button>
  </form>

  <h3>Kirim dengan POST</h3>
  <form action="check_method.php" method="POST">
    <input type="text" name="pesan" placeholder="Tulis pesan">
    <button type="submit">Kirim POST</button>
  </form>
</body>
</html>