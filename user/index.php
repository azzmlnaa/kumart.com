<?php
include '../includes/config.php';
include '../includes/header.php';

$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KU Mart - Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .marquee {
            white-space: nowrap;
            overflow: hidden;
            display: block;
        }

        .marquee span {
            display: inline-block;
            animation: marquee 12s linear infinite;
        }

        @keyframes marquee {
            from { transform: translateX(100%); }
            to { transform: translateX(-100%); }
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.03);
        }

        .card img {
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .card-title {
            font-size: 1.2rem;
        }

        .btn-custom {
            border-radius: 30px;
            font-weight: 600;
        }

        .btn-whatsapp {
            background: linear-gradient(to right, #25d366, #128c7e);
            color: white;
        }

        .btn-cart {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
        }

        .btn-whatsapp:hover,
        .btn-cart:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>

<div class="container text-center mt-4">
    <h2 class="marquee"><span>🌟 Assalamu'alaikum, Selamat Datang di KU Mart - Belanja Kebutuhan Sekolah dengan Mudah! 🌟</span></h2>
</div>

<div class="container mt-5">
    <div class="row">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="../uploads/<?php echo $row['gambar']; ?>" class="card-img-top" alt="<?= $row['nama_produk']; ?>">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-primary fw-semibold"><?= $row['nama_produk']; ?></h5>
                        <p class="text-muted"><?= $row['deskripsi']; ?></p>
                        <p class="fs-5 fw-bold text-danger">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>

                        <div class="d-grid gap-2 mt-3">
                            <a href="order.php?id=<?= $row['id']; ?>" class="btn btn-whatsapp btn-custom">
                                <i class="bi bi-whatsapp me-1"></i> Pesan via WhatsApp
                            </a>

                            <form method="post" action="../add_to_cart.php">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-cart btn-custom">
                                    <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
