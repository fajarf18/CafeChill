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

if (isset($_GET['id'])) {
    $transaction_id = $_GET['id'];
    
    // Siapkan dan jalankan query update
    $update_query = "UPDATE transactions SET status = 'paid' WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $transaction_id);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('Order confirmed successfully!');
                window.location.href='kelolapesanan.php';
              </script>";
    } else {
        echo "<script>
                alert('Error confirming order!');
                window.location.href='kelolapesanan.php';
              </script>";
    }
} else {
    header("Location: kelolapesanan.php");
}

$conn->close();
?>