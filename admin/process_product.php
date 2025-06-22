<?php
include '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $deskripsi   = $_POST['deskripsi'];
    $harga       = $_POST['harga'];
    
    // Upload Gambar
    $target_dir = "../uploads/";
    $gambar_name = basename($_FILES["gambar"]["name"]);
    $target_file = $target_dir . $gambar_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file gambar valid
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        echo "File bukan gambar!";
        $uploadOk = 0;
    }

    // Cek ukuran file (maks 2MB)
    if ($_FILES["gambar"]["size"] > 2000000) {
        echo "Ukuran gambar terlalu besar!";
        $uploadOk = 0;
    }

    // Izinkan format gambar tertentu
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Hanya file JPG, JPEG, & PNG yang diperbolehkan!";
        $uploadOk = 0;
    }

    // Jika tidak ada error, upload gambar
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // Simpan data ke database
            $stmt = $conn->prepare("INSERT INTO produk (nama_produk, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $nama_produk, $deskripsi, $harga, $gambar_name);

            if ($stmt->execute()) {
                echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='add_product.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Terjadi kesalahan saat mengupload gambar!";
        }
    }

    $conn->close();
}
?>
