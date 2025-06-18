<?php 
session_start();
include('koneksi.php'); // Include the database connection file

// Check if the user is logged in
if (empty($_SESSION['email'])) { 
    echo "<script type='text/javascript'>
            alert('Maaf Anda Harus Login!');
            window.location.assign('login.php');
          </script>";
    exit();
}

// Check if the role is 'staf'
if ($_SESSION['role'] !== 'staf') {
    echo "<script type='text/javascript'>
            alert('Anda tidak memiliki akses ke halaman ini!'); 
            window.location.href='index.php';
          </script>";
    exit();
}

// Check if ID is provided
if (isset($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];

    // Fetch the current data for the menu item
    $query = "SELECT * FROM tbl_menu WHERE id_menu = '$id_menu'";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($koneksi));
    }

    $menu = mysqli_fetch_assoc($result);
    if (!$menu) {
        echo "Menu not found!";
        exit();
    }
} else {
    echo "ID menu tidak ditemukan!";
    exit();
}

// Update menu data after form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = $_POST['nama_menu'];
    $harga_menu = $_POST['harga_menu'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];

    // Handle image upload
    $image_url = $menu['image_url']; // Default image URL
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $target_dir = "img/";
        $image_url = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_url;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // Update the menu item in the database
    $update_query = "UPDATE tbl_menu SET 
                        nama_menu = '$nama_menu', 
                        harga_menu = '$harga_menu', 
                        jumlah = '$jumlah', 
                        deskripsi = '$deskripsi', 
                        kategori = '$kategori', 
                        image_url = '$image_url'
                     WHERE id_menu = '$id_menu'";

    if (mysqli_query($koneksi, $update_query)) {
        echo "<script type='text/javascript'>
                alert('Menu updated successfully!');
                window.location.href='listmenu.php';
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
    <title>Byte Cafe</title>
    <meta name="description" content="Resto">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css">
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
	
	
</div>	<div id="side-search" class="sidenav">
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
	
 	
</div>	<div id="canvas-overlay"></div>
	<div class="boxed-page">
		<?php include 'navbaradmin.php'; ?>	
<div class="hero">
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-sm-12 py-5">
                        <h2 class="text-center">Edit Menu</h2>
                        <form action="editmenu.php?id_menu=<?php echo $id_menu; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_menu">Nama Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="<?php echo $menu['nama_menu']; ?>" required>
            </div>

            <div class="form-group">
                <label for="harga_menu">Harga Menu</label>
                <input type="number" class="form-control" id="harga_menu" name="harga_menu" value="<?php echo $menu['harga_menu']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo $menu['jumlah']; ?>" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo $menu['deskripsi']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" class="form-control" id="kategori" name="kategori" value="<?php echo $menu['kategori']; ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Gambar Menu</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="img/<?php echo $menu['image_url']; ?>" alt="Current Image" width="100" class="mt-2">
            </div>

            <button type="submit" class="btn btn-primary">Update Menu</button>
        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Menu Section -->
<section id="gtco-menu" class="section-padding">
    
</section>
<!-- End of menu Section -->		<!-- Testimonial Section-->

<!-- End of Testimonial Section-->

<footer class="mastfoot pb-5 bg-white section-padding pb-0">
    <div class="inner container">
         <div class="row">
         	<div class="col-md-12 d-flex align-items-center">
         		
         	</div>
            
        </div>
    </div>
</footer>	</div>
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
    <script>
</body>
</html>
