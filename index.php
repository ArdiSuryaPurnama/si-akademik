<?php echo "<h1>Selamat datang di SI Akademik</h1>"; ?>
<hr>
<h3>Form Pencarian</h3>
<form action="proses.php" method="GET">
  <label>Cari Mahasiswa:</label>
  <input type="text" name="keyword">
  <button type="submit">Cari</button>
</form>
<h3>Form Login</h3>
<form action="login.php" method="POST">
  <label>Username:</label> <input type="text" name="username"><br>
  <label>Password:</label> <input type="password" name="password"><br>
  <button type="submit">Login</button>
</form>

