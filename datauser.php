<?php 
$koneksi = mysqli_connect("localhost", "root", "", "dbcafe");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
$query = "SELECT * FROM tbl_user";
$result = mysqli_query($koneksi, $query);
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
                    <h2 class="text-center">Data User</h2>
                    <table class="table table-bordered mt-4">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Password</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['nama']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>
                <span id='password_".$row['nama']."' style='display: inline-block; width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;'>".str_repeat('*', strlen($row['password']))."</span>
                <i class='fas fa-eye' onclick='togglePasswordVisibility(\"password_".$row['nama']."\", \"".$row['password']."\")' style='cursor: pointer;'></i>
              </td>";
        echo "<td>".$row['role']."</td>";
        echo "<td>
                <a href='edituser.php?id=".$row['nama']."'>Edit</a> | 
                <a href='deleteuser.php?id=".$row['nama']."' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
             </td>";
        echo "</tr>";
    }
        ?>
    </tbody>
</table>
                </div>
            </div>
        </div>
</div>	

<!-- Menu Section -->
<section id="gtco-menu" class="section-padding">
    
</section>
<!-- End of menu Section -->		<!-- Testimonial Section-->
<!-- Menu Section -->
<section id="gtco-menu" class="section-padding">
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
function togglePasswordVisibility(passwordFieldId, actualPassword) {
    var passwordField = document.getElementById(passwordFieldId);
    if (passwordField.innerText === actualPassword) {
        passwordField.innerText = str_repeat('*', actualPassword.length);
    } else {
        passwordField.innerText = actualPassword;
    }
}

function str_repeat(string, num) {
    return new Array(num + 1).join(string);
}
</script>
	<!-- Main JS -->
	<script src="js/app.min.js "></script>
</body>
</html>
