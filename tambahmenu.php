<?php
session_start();
include('koneksi.php'); // Include database connection

// Check if the user is logged in and has the appropriate role
if (empty($_SESSION['email']) || $_SESSION['role'] !== 'staf') {
    echo "<script type='text/javascript'>
            alert('Anda tidak memiliki akses ke halaman ini atau Anda belum login!');
            window.location.assign('login.php');
          </script>";
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = $_POST['nama_menu'];
    $harga_menu = $_POST['harga_menu'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];

    // Handle image upload
    if ($_FILES['image_url']['error'] == 0) {
        $image_name = $_FILES['image_url']['name'];
        $image_tmp_name = $_FILES['image_url']['tmp_name'];
        $image_folder = "img/"; // Folder to store uploaded images
        $image_path = $image_folder . $image_name;
        
        // Move the uploaded file to the desired folder
        move_uploaded_file($image_tmp_name, $image_path);
    }

    // Insert the new menu item into the database
    $query = "INSERT INTO tbl_menu (nama_menu, harga_menu, jumlah, deskripsi, image_url, kategori) 
              VALUES ('$nama_menu', '$harga_menu', '$jumlah', '$deskripsi', '$image_name', '$kategori')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script type='text/javascript'>
                alert('Menu berhasil ditambahkan!');
                window.location.href='listmenu.php'; // Redirect back to the menu list
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tambah Menu - Byte Cafe</title>
    <meta name="description" content="Tambah menu ke Byte Cafe">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Tambah Menu</h2>
        <form action="tambahmenu.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_menu">Nama Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
            </div>
            <div class="form-group">
                <label for="harga_menu">Harga Menu</label>
                <input type="number" class="form-control" id="harga_menu" name="harga_menu" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image_url">Gambar Menu</label>
                <input type="file" class="form-control-file" id="image_url" name="image_url" required>
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <select class="form-control" id="kategori" name="kategori" required>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Pastries">Pastries</option>
                    <option value="Coffee and Beverages">Coffee and Beverages</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Menu</button>
            <a href="listmenu.php" class="btn btn-secondary ml-2">Kembali ke Daftar Menu</a>
        </form>
    </div>

    <!-- External JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/bootstrap/popper.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
</body>

</html>
