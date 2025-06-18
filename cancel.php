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

// Database connection
$conn = mysqli_connect("localhost", "root", "", "dbcafe");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $transaction_id = $_GET['id'];
    
    // Prepare and execute update query
    $update_query = "UPDATE transactions SET status = 'cancelled' WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $transaction_id);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('Order has been cancelled successfully!');
                window.location.href='kelolapesanan.php';
              </script>";
    } else {
        echo "<script>
                alert('Error cancelling order!');
                window.location.href='kelolapesanan.php';
              </script>";
    }
} else {
    header("Location: kelolapesanan.php");
}

$conn->close();
?>