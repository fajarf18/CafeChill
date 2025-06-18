    <?php
    session_start();
    if (empty($_SESSION['email'])) {
        echo "<script type='text/javascript'>
                alert('Maaf Anda Harus Login!');
                window.location.assign('login.php');
            </script>";
        exit();
    }

    if ($_SESSION['role'] !== 'staf') {
        echo "<script type='text/javascript'>
                alert('Anda tidak memiliki akses ke halaman ini!');
                window.location.href='index.php';
            </script>";
        exit();
    }

    // Koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "dbcafe");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Menangani update status
    if (isset($_POST['update_status'])) {
        $transaction_id = $_POST['transaction_id'];
        $new_status = $_POST['new_status'];
        
        $update_query = "UPDATE transactions SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $new_status, $transaction_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Status updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating status!');</script>";
        }
    }

    // Mengambil data transaksi
    $query = "SELECT t.*, u.email 
            FROM transactions t 
            JOIN tbl_user u ON t.user_id = u.id 
            ORDER BY t.created_at DESC";
    $result = mysqli_query($conn, $query);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Byte Cafe - Kelola Pesanan</title>
        <meta name="description" content="Resto">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    </head>

    <body data-spy="scroll" data-target="#navbar" class="static-layout">
        <div class="boxed-page">
            <?php include 'navbaradmin.php'; ?>

            <div class="container table-container mt-5 pt-5">
                <h2 class="text-center mb-4">Kelola Pesanan Pelanggan</h2>
                <div class="table-responsive">
                    <table class="table table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Order Date</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td>Rp <?php echo number_format($row['total_price'], 2, ',', '.'); ?></td>
                                <td><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <strong>
                                        <?php
                                        // PERBAIKAN: Cek jika payment_method tidak null sebelum memanggil ucfirst
                                        if (!empty($row['payment_method'])) {
                                            echo htmlspecialchars(ucfirst($row['payment_method']));
                                        } else {
                                            echo '<i>Belum Dipilih</i>';
                                        }
                                        ?>
                                    </strong>
                                </td>
                                <td>
                                    <span class="badge status-<?php echo strtolower($row['status']); ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['status'] === 'pending') : ?>
                                    <a href="confirm.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="cancel.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Anda yakin ingin menghapus pesanan ini?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="vendor/bootstrap/popper.min.js"></script>
        <script src="vendor/bootstrap/bootstrap.min.js"></script>
    </body>
    </html>