<?php
session_start();
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>
            alert('Maaf Anda Harus Login!');
            window.location.assign('login.php');
          </script>";
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "dbcafe");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Proses form saat metode pembayaran dipilih
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method']) && isset($_POST['transaction_id'])) {
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];

    // Update metode pembayaran di DB, status tetap 'pending'
    $update_query = "UPDATE transactions SET payment_method = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    if ($stmt) {
        $stmt->bind_param("si", $payment_method, $transaction_id);
        $stmt->execute();
        $stmt->close();

        if ($payment_method === 'qris') {
            header("Location: qrispayment.php?id=" . $transaction_id);
            exit();
        } elseif ($payment_method === 'cash') {
            echo "<script>
                    alert('Pesanan Anda akan segera diproses. Silakan tunjukkan ID Pesanan di kasir.');
                    window.location.href='riwayatorder.php';
                  </script>";
            exit();
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
}

// Tampilkan halaman pilihan jika bukan POST request
$transaction_id = isset($_GET['id']) ? $_GET['id'] : null;
$total_amount = isset($_GET['total_amount']) ? $_GET['total_amount'] : 0;

if (!$transaction_id) {
    header("Location: order.php"); // Kembali jika tidak ada ID
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Byte Cafe - Payment Options</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
</head>
<body>
    <div class="boxed-page">
       <?php include 'navbar.php'; ?>
        
        <div class="hero" style="display: flex; justify-content: center; align-items: center; height: 80vh;">
            <div class="container text-center">
                <div class="card shadow-lg" style="padding: 2rem;">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Pilih Metode Pembayaran</h2>
                        <p class="card-text lead">Total Pesanan: <strong>Rp. <?php echo number_format($total_amount, 0, ',', '.'); ?></strong></p>
                        <form method="post" action="processpayment.php" class="mt-4">
                            <input type="hidden" name="transaction_id" value="<?php echo htmlspecialchars($transaction_id); ?>">
                            <button type="submit" name="payment_method" value="cash" class="btn btn-primary btn-lg btn-block mb-3">
                                <i class="fas fa-money-bill-wave"></i> Bayar di Kasir (Cash)
                            </button>
                            <button type="submit" name="payment_method" value="qris" class="btn btn-info btn-lg btn-block mb-3">
                                <i class="fas fa-qrcode"></i> Bayar dengan QRIS
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
</body>
</html>