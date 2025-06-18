<?php 
session_start();
include('koneksi.php'); // Menyertakan file koneksi ke database

// Cek jika user belum login
if (empty($_SESSION['email'])) { 
    echo "<script type='text/javascript'>
            alert('Maaf Anda Harus Login!');
            window.location.assign('login.php');
          </script>";
    exit();
}

// Cek jika role user bukan staf
if ($_SESSION['role'] !== 'staf') {
    echo "<script type='text/javascript'>
            alert('Anda tidak memiliki akses ke halaman ini!'); 
            window.location.href='index.php';
          </script>";
    exit();
}

// Query untuk mengambil data menu dari database
$query = "SELECT * FROM tbl_menu";
$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Byte Cafe</title>
    <meta name="description" content="Resto">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/brands.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
</head>

<body data-spy="scroll" data-target="#navbar" class="static-layout">
    <div id="side-nav" class="sidenav">
        <a href="javascript:void(0)" id="side-nav-close">&times;</a>
    </div>

    <div id="side-search" class="sidenav">
        <a href="javascript:void(0)" id="side-search-close">&times;</a>
        <div class="sidenav-content">
            <form action="">
                <div class="input-group md-form form-sm form-2 pl-0">
                    <input class="form-control my-0 py-1 red-border" type="text" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="input-group-text red lighten-3" id="basic-text1">
                            <i class="fas fa-search text-grey" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div id="canvas-overlay"></div>
    <div class="boxed-page">
        <?php include 'navbaradmin.php'; ?>

        <!-- <div class="hero"> -->
            <div class="container">

                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Harga Menu</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $image_path = "img/{$row['image_url']}"; 
                            echo "<tr>";
                            echo "<td>" . $row['nama_menu'] . "</td>";
                            echo "<td>" . number_format($row['harga_menu'], 2) . "</td>";
                            echo "<td>" . $row['jumlah'] . "</td>";
                            echo "<td>" . $row['deskripsi'] . "</td>";
                            echo "<td><img class='img-fluid' src='$image_path' alt='{$row['nama_menu']}' style='width: 80px; height: 80px;'>";
                            echo "<td>" . $row['kategori'] . "</td>";
                            echo "<td>
                            <a href='editmenu.php?id_menu=" . $row['id_menu'] . "'>Edit</a> | 
                            <a href='deletemenu.php?id_menu=" . $row['id_menu'] . "' onclick='return confirm(\"Yakin ingin menghapus menu?\")'>Hapus</a>
                          </td>";
                    echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div class="text-center mt-4">
                    <a href="tambahmenu.php" class="btn btn-primary">Tambah Menu</a>
                </div>
            </div>
        </div>

        <!-- External JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
        <script src="vendor/bootstrap/popper.min.js"></script>
        <script src="vendor/bootstrap/bootstrap.min.js"></script>
        <script src="vendor/select2/select2.min.js "></script>
        <script src="vendor/owlcarousel/owl.carousel.min.js"></script>
        <script src="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js"></script>
        <script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Main JS -->
        <script src="js/app.min.js "></script>
    </body>
</html>
