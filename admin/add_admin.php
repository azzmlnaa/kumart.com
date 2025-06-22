<?php
$username = 'admin';
$password = password_hash('123456', PASSWORD_DEFAULT); // Ganti dengan password yang lebih aman

$sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "Akun admin berhasil dibuat!";
} else {
    echo "Gagal membuat akun admin.";
}
?>