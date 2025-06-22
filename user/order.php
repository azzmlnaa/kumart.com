<?php
include '../includes/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();

    $nama_produk = $produk['nama_produk'];
    $harga = number_format($produk['harga'], 0, ',', '.');
    $whatsapp = "6285893526744"; // Ganti dengan nomor admin
    $pesan = "Halo, saya ingin memesan produk:\n\nNama: $nama_produk\nHarga: Rp $harga\n\nTerima kasih!";
    //$link_wa = "https://api.whatsapp.com/send?phone=$whatsapp&text=" . rawurlencode($pesan);

    //header("Location: $link_wa");
    $pesan_encoded = rawurlencode($pesan);

        echo "<script>
                window.location.href = 'https://web.whatsapp.com/send?phone=$whatsapp&text=$pesan_encoded';
              </script>";
    //exit();
}
?>
