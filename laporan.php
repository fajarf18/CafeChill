<?php
session_start();
if (empty($_SESSION['email'])) { ?>
    <script type="text/javascript">
        alert("Maaf Anda Harus Login!")
        window.location.assign('login.php');
    </script>
<?php } 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbcafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if date filter is applied
$date_filter = "";
$filter_params = [];
$types = "";

if (isset($_GET['start']) && isset($_GET['end'])) {
    $date_filter = "WHERE DATE(created_at) BETWEEN ? AND ?";
    $filter_params = [$_GET['start'], $_GET['end']];
    $types = "ss";
}

$sql = "SELECT id, user_id, email, product_name, quantity, total_price, created_at 
        FROM transactions " . $date_filter . 
        " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);

if (!empty($filter_params)) {
    $stmt->bind_param($types, ...$filter_params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>All Transaction Reports</title>
    <meta name="description" content="Transaction Report">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css">
    <link rel="stylesheet" href="css/laporan.css">
    <link rel="stylesheet" href="css/print.css">

</head>
<body>
    
    <div class="report-container">
        <a href="admin.php" class="back-btn no-print">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="report-header">
            <h2>All Transaction Reports</h2>
        </div>

        <div class="filter-section no-print">
            <input type="date" id="start-date" placeholder="Start Date" 
                   value="<?php echo isset($_GET['start']) ? $_GET['start'] : ''; ?>">
            <input type="date" id="end-date" placeholder="End Date"
                   value="<?php echo isset($_GET['end']) ? $_GET['end'] : ''; ?>">
            <button onclick="filterTransactions()">Filter</button>
            <button class="print-btn" onclick="printReport()">
                <i class="fas fa-print"></i> Print Report
            </button>
        </div>

        <div class="print-header" style="display: none;">
            <p>Transaction Report</p>
            <?php if (isset($_GET['start']) && isset($_GET['end'])) { ?>
                <p>Period: <?php echo $_GET['start']; ?> to <?php echo $_GET['end']; ?></p>
            <?php } ?>
            <p class="print-date">Print Date: <?php echo date('d M Y H:i'); ?></p>
        </div>

        <?php if ($result->num_rows > 0) { ?>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    while($row = $result->fetch_assoc()) {
                        $grand_total += $row['total_price'];
                    ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td class="email-column"><?php echo htmlspecialchars($row['email']); ?></td>
                            <td class="transaction-date">
                                <?php echo date('d M Y H:i', strtotime($row['created_at'])); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td class="quantity"><?php echo $row['quantity']; ?></td>
                            <td class="price">Rp. <?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="total-row">
                        <td colspan="5">Grand Total</td>
                        <td class="price">Rp. <?php echo number_format($grand_total, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="no-transactions">
                No transactions found.
            </div>
        <?php } ?>
    </div>

    <script>
        function filterTransactions() {
            const startDate = document.getElementById('start-date').value;
            const endDate = document.getElementById('end-date').value;
            
            if (!startDate || !endDate) {
                alert('Please select both start and end dates');
                return;
            }

            window.location.href = `laporan.php?start=${startDate}&end=${endDate}`;
        }

        function printReport() {
            // Show print header before printing
            const printHeader = document.querySelector('.print-header');
            printHeader.style.display = 'block';
            
            window.print();
            
            // Hide print header after printing
            setTimeout(() => {
                printHeader.style.display = 'none';
            }, 100);
        }
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>