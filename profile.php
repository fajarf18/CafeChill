<?php
session_start();
include "koneksi.php";

// Get the logged-in user's email
$email = $_SESSION['email'];


// Query to fetch user data from the database
$query = "SELECT * FROM tbl_user WHERE email='$email'";
$result = mysqli_query($koneksi, $query);

// Check if the user exists
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fileName = $row['foto_profil']; // Get the file name of the profile picture
    $imagePath = 'uploads/' . $fileName; // Construct the image path
} else {
    echo "User not found!";
    exit;
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
        <section id="gtco-welcome" class="bg-white section-padding">
    <div class="container">
        <div class="section-content">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center">
                    <h2 class="mb-4 font-weight-bold">Profil Pengguna</h2>
                    <div class="card shadow-lg rounded-lg border-0">
                        <div class="card-body text-center">
                            
                            
                            <?php 
                            if (!empty($fileName)) {
                                $imagePath = 'uploads/' . $fileName; // Construct the image path
                                if (file_exists($imagePath)) {
                            ?>
                                <img src="<?php echo $imagePath; ?>" alt="Profile Picture" class="rounded-circle mb-3" width="120" height="120">
                            <?php 
                                } else {
                            ?>
                                <div class="mb-3">
                                    <span class="badge badge-secondary p-3">Tidak ada foto</span>
                                </div>
                            <?php 
                                }
                            } else {
                            ?>
                                <div class="mb-3">
                                    <span class="badge badge-secondary p-3">Tidak ada foto</span>
                                </div>
                            <?php 
                            }
                            ?>

                            <table class="table table-borderless mt-3 mb-4">
                                <tr>
                                    <th class="text-right pr-4">Nama:</th>
                                    <td class="text-left font-weight-bold"><?php echo htmlspecialchars($row['nama']); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-right pr-4">Email:</th>
                                    <td class="text-left font-weight-bold"><?php echo htmlspecialchars($row['email']); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-right pr-4">Password:</th>
                                    <td class="text-left text-muted">********</td>
                                </tr>
                            </table>

                            <a href="update-profile.php?id=<?php echo htmlspecialchars($row['email']); ?>" class="btn btn-outline-primary btn-sm px-4">Update Profil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <footer class="mastfoot pb-5 bg-white section-padding pb-0">
            <div class="inner container">
                <div class="row"></div>
                <div class="col-md-12 d-flex align-items-center"></div>
            </div>
        </footer>
    </div>
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