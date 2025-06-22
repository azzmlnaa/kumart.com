<?php
/**include 'includes/config.php';

/**if (isset($_GET['id'])) {
    $id = $_GET['id'];**/
    /**$sql = "SELECT * FROM produk WHERE id = ? ";
    $stmt = $conn->prepare($sql);
    /**$stmt->bind_param("i", $id);**/
    /**$stmt->execute();
    $result = $stmt->get_result();
    while($produk = $result->fetch_assoc()){

    $nama_produk = $produk['nama_produk'];
    $harga = number_format($produk['harga'], 0, ',', '.');
    $whatsapp = "6285772675468"; // Ganti dengan nomor admin
    $pesan = "Halo, saya ingin memesan produk:\n\nNama: $nama_produk\nHarga: Rp $harga\n\nTerima kasih!";
    //$link_wa = "https://api.whatsapp.com/send?phone=$whatsapp&text=" . rawurlencode($pesan);

    //header("Location: $link_wa");
    $pesan_encoded = rawurlencode($pesan);

        echo "<script>
                window.location.href = 'https://web.whatsapp.com/send?phone=$whatsapp&text=$pesan_encoded';
              </script>";
    //exit();
    }**/
/*}**/
include 'includes/config.php';
session_start();

if (!empty($_SESSION['cart'])) {
    $whatsapp = "6285893526744"; // Ganti dengan nomor admin
    $pesan = "Assalamu'alaikum, saya ingin memesan produk:\n\n";

    $totalHarga = 0;

    foreach ($_SESSION['cart'] as $id => $jumlah) {
        $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $produk = $result->fetch_assoc();

        $nama_produk = $produk['nama_produk'];
        $harga_satuan = $produk['harga'];
        $harga_format = number_format($harga_satuan, 0, ',', '.');
        $subtotal = $harga_satuan * $jumlah;
        $subtotal_format = number_format($subtotal, 0, ',', '.');

        $pesan .= "Nama: $nama_produk\nHarga: Rp $harga_format x $jumlah = Rp $subtotal_format\n\n";

        $totalHarga += $subtotal;
    }

    $pesan .= "Total: Rp " . number_format($totalHarga, 0, ',', '.') . "\n\nTerima kasih!";

    $pesan_encoded = rawurlencode($pesan);

    echo "<script>
            window.location.href = 'https://web.whatsapp.com/send?phone=$whatsapp&text=$pesan_encoded';
          </script>";
} else {
    echo "<script>alert('Keranjang belanja kosong.'); window.location.href='cart.php';</script>";
}

?>
