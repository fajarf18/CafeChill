<?php
session_start();
if (empty($_SESSION['email'])) {
    echo "<script type='text/javascript'>
            alert('Maaf Anda Harus Login!');
            window.location.assign('login.php');
          </script>";
    exit();
}



// Database connection
$conn = mysqli_connect("localhost", "root", "", "dbcafe");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id']) && isset($_GET['total_amount'])) {
    $transaction_id = $_GET['id'];
    $total_amount = $_GET['total_amount'];
    
    // Display payment options
    echo "<h2>Payment Options</h2>";
    echo "<p>Total Amount: Rp. " . number_format($total_amount, 0, ',', '.') . "</p>";
    
    // Payment options form
    echo "<form method='post'>";
    echo "<input type='hidden' name='transaction_id' value='" . $transaction_id . "'>";
    echo "<input type='hidden' name='total_amount' value='" . $total_amount . "'>";
    
    // Cash payment option
    echo "<button type='submit' name='payment_method' value='cash'>Pay with Cash</button><br><br>";
    
    // QRIS payment option
    echo "<button type='submit' name='payment_method' value='qris'>Pay with QRIS</button><br><br>";
    
    // Transfer payment option
    echo "<button type='submit' name='payment_method' value='transfer'>Pay with Transfer</button><br><br>";
    
    echo "</form>";
    
    // Process payment
    if (isset($_POST['payment_method'])) {
        $payment_method = $_POST['payment_method'];
        
        // Update transaction status to 'paid'
        $update_query = "UPDATE transactions SET status = 'paid', payment_method = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $payment_method, $transaction_id);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Payment successful!');
                    window.location.href='riwayatorder.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating payment status!');
                    window.location.href='riwayatorder.php';
                  </script>";
        }
    }
} else {
    header("Location: riwayatorder.php");
}

$conn->close();
?>
