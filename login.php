<?php
$username = $_POST['username'] ?? '';
echo "Username yang dikirim: " . htmlspecialchars($username);