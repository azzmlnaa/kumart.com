<?php
session_start();
include '../includes/config.php';
include '../includes/header.php';


// Hapus produk dari keranjang
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}

// Hapus semua isi keranjang
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - KU Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
<div class="container mt-5">
    <div class="card p-4">
        <h3 class="text-center mb-4"><i class="bi bi-cart-check-fill text-success me-2"></i>Keranjang Belanja</h3>
        <?php if (!empty($_SESSION['cart'])) { ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalHarga = 0;
                        foreach ($_SESSION['cart'] as $id => $jumlah) {
                            $query = $conn->query("SELECT * FROM produk WHERE id = $id");
                            $row = $query->fetch_assoc();
                            $total = $row['harga'] * $jumlah;
                            $totalHarga += $total;
                        ?>
                        <tr>
                            <td><?= $row['nama_produk'] ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td><?= $jumlah ?></td>
                            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
                            <td class="text-center">
                                <a href="cart.php?remove=<?= $id ?>" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-x-circle"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4>Total: <span class="text-primary">Rp <?= number_format($totalHarga, 0, ',', '.') ?></span></h4>
                <div class="d-flex gap-2">
                    <a href="cart.php?clear=true" class="btn btn-warning">
                        <i class="bi bi-trash"></i> Hapus Semua
                    </a>
                    <a href="whatsapp_order.php" class="btn btn-success">
                        <i class="bi bi-whatsapp"></i> Checkout via WhatsApp
                    </a>
                </div>
            </div>
        <?php } else { ?>
            <p class="text-center text-muted">Keranjang belanja kosong. <a href="index.php" class="text-decoration-none">Belanja sekarang</a>.</p>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
