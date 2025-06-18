<?php
session_start();
if (empty($_SESSION['email'])) { ?>
    <script type="text/javascript">
        alert("Maaf Anda Harus Login!");
        window.location.assign('login.php');
    </script>
<?php }

// Sertakan koneksi.php untuk memastikan koneksi ke database
include('koneksi.php');

// Periksa koneksi database
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
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
<body data-spy="scroll" data-target="#navbar">
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
		<?php include 'navbar.php'; ?>		<!-- Menu Section -->
<div class="header">
<img src= "img/reservation-bg.jpg"  height="400" width="1200"/>
    <div class="header-text">
    Menu
</div>
</div>
<section id="gtco-menu" class="section-padding">
<div class="container">
        <div class="section-content">
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="heading-section text-center">
                        <span class="subheading">
                            -Café-
                        </span>
                        <h2>
                            Explore Our Splendid Menu
                        </h2>
                    </div>  
                </div>
            </div>
        <div class="container">
        <div class="row">
    <?php
    $categories = ['Breakfast', 'Pastries', 'Coffee and Beverages'];
    foreach ($categories as $category) {
        echo "<div class='col-lg-12 mb-5'>";
        echo "<div class='heading-menu'>";
        echo "<h3 class='text-center mb-5'>$category</h3>";
        echo "</div>";

        $sql = "SELECT * FROM tbl_menu WHERE kategori='$category'";
        $result = mysqli_query($koneksi, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $image_path = "img/{$row['image_url']}"; 

                echo "<div class='menus d-flex align-items-center mb-4'>";
                echo "    <div class='menu-img rounded-circle'>";
                echo "        <img class='img-fluid' src='$image_path' alt='{$row['nama_menu']}' style='width: 80px; height: 80px;'>";
                echo "    </div>";
                echo "    <div class='text-wrap'>";
                echo "        <div class='row align-items-start'>";
                echo "            <div class='col-8'>";
                echo "                <h4>{$row['nama_menu']}</h4>";
                echo "            </div>";
                echo "            <div class='col-4'>";
                echo "                <h4 class='text-muted menu-price'>{$row['harga_menu']}K</h4>";
                echo "            </div>";
                echo "        </div>";
                echo "        <p>{$row['deskripsi']}</p>";
                echo "    </div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-muted text-center'>No menu items found in this category.</p>";
        }

        echo "</div>";
    }
    ?>
</div>




        </div>
    </section>
<!-- End of menu Section -->		<footer class="mastfoot pb-5 bg-white section-padding pb-0">
    <div class="inner container">
         <div class="row">
         	</div>

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

	<!-- Main JS -->
	<script src="js/app.min.js "></script>
</body>
</html>
