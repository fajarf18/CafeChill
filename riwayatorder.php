<?php
session_start();
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>
            alert('Maaf Anda Harus Login!');
            window.location.assign('login.php');
          </script>";
    exit();
}

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "dbcafe");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil transaksi pengguna
$user_id = $_SESSION['id']; // Pastikan ini diatur dengan benar saat login
if (empty($user_id)) {
    echo "<script type='text/javascript'>
            alert('User ID tidak ditemukan. Silakan login kembali.');
            window.location.assign('login.php');
          </script>";
    exit();
}

$query = "SELECT t.*, u.email 
          FROM transactions t 
          LEFT JOIN tbl_user u ON t.user_id = u.id
          WHERE t.user_id = ? 
          ORDER BY t.created_at DESC";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("MySQL prepare error: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Byte Cafe - Riwayat Pesanan</title>
    <meta name="description" content="Resto">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    
    <link rel="stylesheet" href="css/style.min.css">
    
    <style>
        .order-history-container {
            padding: 50px 15px;
            min-height: 100vh;
            background-color: #f4ede5;
        }
        .order-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            padding: 25px;
            transition: transform 0.2s ease-in-out;
        }
        .order-card:hover {
            transform: translateY(-5px);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: bold;
            color: #fff;
        }
        .status-pending { background-color: #ffc107; }
        .status-confirmed { background-color: #28a745; }
        .status-cancelled { background-color: #dc3545; }
        .status-paid { background-color: #17a2b8; }
        .price-info {
            color: #28a745;
            font-weight: bold;
            font-size: 1.2em;
        }
        .date-info { color: #6c757d; font-size: 0.9em; }
        .no-orders {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 10px;
            color: #6c757d;
        }
        .order-actions {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body data-spy="scroll" data-target="#navbar" class="static-layout">
    <div class="boxed-page">
        <?php include 'navbar.php'; ?>

        <div class="order-history-container">
            <div class="container">
                <h2 class="text-center mb-5">Riwayat Pesanan Anda</h2>
                
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <div class="order-card">
                            <div class="order-header">
                                <div>
                                    <strong>Order #<?php echo $row['id']; ?></strong>
                                    <p class="date-info mb-0">Dipesan pada: <?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></p>
                                </div>
                                <span class="status-badge status-<?php echo strtolower($row['status']); ?>">
                                    <?php echo ucfirst($row['status']); ?>
                                </span>
                            </div>
                            <div class="order-body">
                                <h5>Detail Pesanan:</h5>
                                <p><?php echo htmlspecialchars($row['product_name']); ?></p>
                                <p class="price-info">Total: Rp <?php echo number_format($row['total_price'], 0, ',', '.'); ?></p>
                            </div>
                            <div class="order-actions">
                                <?php if ($row['status'] === 'confirmed') : ?>
                                    <a href="processpayment.php?id=<?php echo $row['id']; ?>&total_amount=<?php echo $row['total_price']; ?>" class="btn btn-primary">Pay Now</a>
                                <?php elseif ($row['status'] === 'pending') : ?>
                                    <p class="text-muted mb-0"><i>Menunggu konfirmasi dari staf</i></p>
                                <?php elseif ($row['status'] === 'paid') : ?>
                                    <p class="text-success mb-0"><strong>Sudah dibayar</strong></p>
                                <?php elseif ($row['status'] === 'cancelled') : ?>
                                    <p class="text-danger mb-0"><i>Pesanan dibatalkan</i></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="no-orders">
                        <h4>Anda belum melakukan pemesanan.</h4>
                        <p>Lihat menu kami dan lakukan pesanan pertama Anda!</p>
                        <a href="menu.php" class="btn btn-primary mt-3">Lihat Menu</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/bootstrap/popper.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
    <script src="js/app.min.js"></script>
</body>
</html>