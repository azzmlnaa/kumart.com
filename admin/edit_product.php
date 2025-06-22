<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../includes/config.php';

// Pastikan ID produk tersedia
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();

    if (!$produk) {
        echo "<script>alert('Produk tidak ditemukan!'); window.location.href='products.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID produk tidak valid!'); window.location.href='products.php';</script>";
    exit();
}

// Proses update produk
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $gambar = $produk['gambar']; // Default gambar lama

    // Jika ada file yang diunggah
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "../uploads/";
        $gambar = basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $gambar;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi jenis file gambar
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Format gambar tidak valid! Gunakan JPG, JPEG, PNG, atau GIF.');</script>";
        } else {
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        }
    }

    $sql = "UPDATE produk SET nama_produk = ?, deskripsi = ?, harga = ?, gambar = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $nama_produk, $deskripsi, $harga, $gambar, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Produk berhasil diperbarui!'); window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui produk.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="mt-4">Edit Produk</h2>
    <form action="edit_product.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $produk['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="<?php echo htmlspecialchars($produk['nama_produk']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="<?php echo $produk['harga']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Produk (Opsional)</label>
            <input type="file" name="gambar" class="form-control">
            <?php if (!empty($produk['gambar'])): ?>
                <p>Gambar saat ini:</p>
                <img src="../uploads/<?php echo $produk['gambar']; ?>" width="100">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="products.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
