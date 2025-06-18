<?php
session_start();
if (empty($_SESSION['email'])) {
    // Mengirim respons JSON jika pengguna tidak login
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Pengaturan koneksi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbcafe";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Mengambil user_id dari sesi
$email = $_SESSION['email'];
$user_id = $_SESSION['id']; // Pastikan 'id' disimpan dalam sesi saat login

// Memeriksa apakah user_id ada
if (empty($user_id)) {
    echo json_encode(['status' => 'error', 'message' => 'User ID not found in session. Please log in again.']);
    exit;
}


// Mendapatkan data mentah dari permintaan POST
$rawData = file_get_contents('php://input');
$decodedData = json_decode($rawData, true);

// Memeriksa apakah ada produk dalam pesanan
if (!isset($decodedData['products']) || empty($decodedData['products'])) {
    echo json_encode(['status' => 'error', 'message' => 'No products found in the order.']);
    exit;
}

$products = $decodedData['products'];
// Menghilangkan format titik dari total_amount untuk penyimpanan database
$total_amount = str_replace('.', '', $decodedData['total_amount']);

$product_names = [];
$total_quantity = 0;

// Menggabungkan nama produk dan menghitung jumlah total
foreach ($products as $product) {
    $product_names[] = $product['name'] . ' (Qty: ' . $product['quantity'] . ')';
    $total_quantity += (int)$product['quantity'];
}

// Membuat ringkasan produk untuk disimpan di database
$product_summary = implode(', ', $product_names);

// Memulai transaksi database
$conn->begin_transaction();

try {
    // Menyisipkan satu transaksi tunggal untuk seluruh pesanan
    $stmt = $conn->prepare(
        "INSERT INTO transactions (user_id, email, product_name, quantity, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')"
    );
    // Mengikat parameter ke pernyataan SQL
    $stmt->bind_param("issid", $user_id, $email, $product_summary, $total_quantity, $total_amount);

    // Menjalankan pernyataan dan memeriksa kesalahan
    if (!$stmt->execute()) {
        throw new Exception('Error processing order: ' . $stmt->error);
    }

    // Mendapatkan ID dari transaksi yang baru saja dimasukkan
    $transaction_id = $conn->insert_id;

    // Melakukan commit pada transaksi
    $conn->commit();
    
    // Mengirim respons sukses dengan transaction_id
    echo json_encode([
        'status' => 'success',
        'message' => 'Order processed successfully',
        'transaction_id' => $transaction_id // Mengembalikan ID untuk langkah selanjutnya
    ]);

} catch (Exception $e) {
    // Membatalkan transaksi jika terjadi kesalahan
    $conn->rollback();
    // Mengirim pesan kesalahan
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Menutup pernyataan dan koneksi
$stmt->close();
$conn->close();
?>