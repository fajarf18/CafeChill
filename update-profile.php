<?php
$koneksi = mysqli_connect("localhost", "root", "", "dbcafe") or die("Gagal Koneksi Database");

// Memeriksa apakah parameter 'id' ada di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $email = mysqli_real_escape_string($koneksi, $_GET['id']);
    $query = "SELECT * FROM tbl_user WHERE email='$email'";
    $data = mysqli_query($koneksi, $query);

    if ($data) {
        if (mysqli_num_rows($data) > 0) {
            $user = mysqli_fetch_assoc($data);
        } else {
            die("Data Account tidak ditemukan.");
        }
    } else {
        die("Query gagal: " . mysqli_error($koneksi));
    }
} else {
    die("Data Account tidak ditemukan.");
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
		<?php include 'navbar.php'; ?>

        <!-- Profile Section -->
        <section id="gtco-welcome" class="bg-white section-padding">
            <div class="container">
                <div class="section-content">
                    <div class="row">
                        <div class="col-sm-12 py-5">
                            <h2 class="text-center">Profile</h2>
                            <section class="service_section">
                                <div class="container">
                                    <div class="table-responsive">
                                        <div class="col-lg-7 mx-auto">
                                        <form action="aksi_update_user.php" method="POST" enctype="multipart/form-data">
                                                <table style="border-collapse: collapse; width: 100%; max-width: 600px; margin: auto;">
                                                    <tr>
                                                        <td style="padding: 10px; text-align: right;"><label for="nama">Nama:</label></td>
                                                        <td style="padding: 10px;"><input type="text" id="nama" name="nama" value="<?php echo $user['nama']; ?>" style="width: 100%;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px; text-align: right;"><label for="email">Email:</label></td>
                                                        <td style="padding: 10px;"><input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" style="width: 100%;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px; text-align: right;"><label for="password">Password:</label></td>
                                                        <td style="padding: 10px;"><input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" style="width: 100%;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px; text-align: right;"><label for="foto_profil">Foto Profil:</label></td>
                                                        <td style="padding: 10px;"><input type="file" id="foto_profil" name="foto_profil"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="padding: 10px; text-align: center;">
                                                            <button type="submit" style="padding: 10px 20px;">Update</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of Profile Section -->

        <footer class="mastfoot pb-5 bg-white section-padding pb-0">
            <div class="inner container">
                <div class="row">
                </div>
                <div class="col-md-12 d-flex align-items-center">
                </div>
            </div>
        </footer>
    </div>

    <!-- External JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="vendor/bootstrap/popper.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js"></script>
    <script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/app.min.js"></script>
</body>
</html>
