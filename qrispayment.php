<?php
session_start();
// Memeriksa apakah pengguna sudah login
if (empty($_SESSION['email'])) {
    echo "<script>alert('Maaf Anda Harus Login!'); window.location.assign('login.php');</script>";
    exit();
}
// Memastikan ID transaksi ada di URL
if (!isset($_GET['id'])) {
    header("Location: order.php");
    exit();
}
$transaction_id = htmlspecialchars($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Byte Cafe - Pembayaran QRIS</title>
    <meta name="description" content="Halaman Pembayaran QRIS untuk Byte Cafe">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/brands.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.min.css">
</head>
<body class="static-layout">
<div class="boxed-page">
    <?php include 'navbar.php'; ?>

    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-lg" style="border-radius: 15px; padding: 2rem;">
                        <div class="card-body text-center">
                            <i class="fas fa-qrcode fa-4x mb-4" style="color: #a26f60;"></i>
                            <h2 class="card-title mb-3">Pembayaran dengan QRIS</h2>
                            <p class="lead">Silakan pindai Kode QR di bawah ini menggunakan aplikasi perbankan atau e-wallet Anda.</p>
                            <hr class="my-4">
                            <p>ID Pesanan Anda adalah: <strong class="text-primary" style="font-size: 1.2em;">#<?php echo $transaction_id; ?></strong></p>
                            
                            <img src="img/qris_example.png" alt="QRIS Code" class="img-fluid rounded my-4" style="max-width: 280px; border: 2px solid #ddd; padding: 5px;">
                            
                            <p class="text-muted">Setelah pembayaran berhasil, pesanan Anda akan segera diproses oleh staf kami. Anda dapat memeriksa statusnya di halaman Riwayat Pesanan.</p>
                            
                            <a href="riwayatorder.php" class="btn btn-success btn-lg mt-3" style="padding: 12px 30px; font-size: 1.1em;">
                                <i class="fas fa-check-circle"></i> Saya Sudah Bayar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="mastfoot pb-5 bg-white section-padding pb-0">
        <div class="inner container">
            <div class="row">
                <div class="col-md-12 d-flex align-items-center">
                    <p class="mx-auto text-center mb-0">© <?php echo date("Y"); ?> Byte Cafe. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="vendor/bootstrap/popper.min.js"></script>
<script src="vendor/bootstrap/bootstrap.min.js"></script>
<script src="