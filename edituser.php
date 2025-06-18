<?php 
$koneksi = mysqli_connect("localhost", "root", "", "dbcafe");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
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
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Ambil data pengguna dari database
    $query = "SELECT * FROM tbl_user WHERE nama = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('Pengguna tidak ditemukan!'); window.location.href='datauser.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID pengguna tidak ditentukan!'); window.location.href='datauser.php';</script>";
    exit();
}

// Proses pengeditan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Anda bisa menambahkan logika untuk meng-hash password jika diperlukan

    if (empty($password)) {
        // Jika password kosong, update tanpa mengubah password
        $updateQuery = "UPDATE tbl_user SET nama = ?, email = ? WHERE nama = ?";
        $updateStmt = $koneksi->prepare($updateQuery);
        $updateStmt->bind_param("sss", $name, $email, $userId);
    } else {
        // Jika password diisi, update dengan password baru
        $updateQuery = "UPDATE tbl_user SET nama = ?, email = ?, password = ? WHERE nama = ?";
        $updateStmt = $koneksi->prepare($updateQuery);
        $updateStmt->bind_param("ssss", $name, $email, $password, $userId);
    }
    if ($updateStmt->execute()) {
        echo "<script>alert('Data pengguna berhasil diperbarui!'); window.location.href='datauser.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data pengguna!');</script>";
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
                    <h2 class="text-center">Data User</h2>
                    <form method="POST" action="">
                    <table class="table table-bordered mt-4">
                        <tr>
                            <th>Nama</th>
                            <td><input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['nama']); ?>" required></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>  <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td><input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)"></td>
                        </tr>
                    </table>
                    <button class="btn btn-primary btn-shadow btn-lg" type="submit" >Submit</button>
                    <a href="datauser.php" class="btn btn-primary btn-shadow btn-lg">Batal</a>
                </div>
            </div>
        </div>
</div>	

<!-- Menu Section -->
<section id="gtco-menu" class="section-padding">
    
</section>
<!-- End of menu Section -->		<!-- Testimonial Section-->
<section id="gtco-testimonial" class="overlay bg-fixed section-padding" style="background-image: url(img/testi.jpg);">
    <div class="container">
        <div class="section-content">
            <div class="heading-section text-center">
                <span class="subheading">
                    Testimony
                </span>
                <h2>
                    Happy Customer
                </h2>
            </div>
            <div class="row">
                <!-- Testimonial -->
                <div class="testi-content testi-carousel owl-carousel">
                    <div class="testi-item">
                        <i class="testi-icon fa fa-3x fa-quote-left"></i>
                        <p class="testi-text">Kafe ini benar-benar tempat yang nyaman untuk belajar atau sekedar bersantai. Kopinya enak, dan suasananya tenang. Saya sering datang ke sini untuk mengerjakan tugas, karena suasana yang cozy dan pelayanan yang ramah.</p>
                        <p class="testi-author">Mark Lee</p>
                        <p class="testi-desc">Mahasiswa</span></p>
                    </div>
                    <div class="testi-item">
                        <i class="testi-icon fa fa-3x fa-quote-left"></i>
                        <p class="testi-text">Saya sangat suka datang ke kafe ini! Tidak hanya kopi yang lezat, tapi juga menu makanan ringan yang selalu menggugah selera. Stafnya selalu ramah dan membantu, membuat saya merasa betah berlama-lama di sini. Tempat yang sempurna untuk bekerja atau berkumpul dengan teman.</p>
                        <p class="testi-author">Jung Jaehyun</p>
                        <p class="testi-desc">Mahasiswa</span></p>
                    </div>
                </div>
                <!-- End of Testimonial -->
            </div>
        </div>
    </div>
</section>
<!-- End of Testimonial Section-->

<footer class="mastfoot pb-5 bg-white section-padding pb-0">
    <div class="inner container">
         <div class="row">
         	<div class="col-lg-4">
         		<div class="footer-widget pr-lg-5 pr-0">
         			<img src="img/logo.png" class="img-fluid footer-logo mb-3" alt="">
	         		<p><b>Experience Love at First Taste</b>
                    <br>Where Every Sip is a Story, and Every Cup is a Memory Waiting to Happen</p>
	         		<nav class="nav nav-mastfoot justify-content-start">
		                <a class="nav-link" href="#">
		                	<i class="fab fa-facebook-f"></i>
		                </a>
		                <a class="nav-link" href="#">
		                	<i class="fab fa-twitter"></i>
		                </a>
		                <a class="nav-link" href="#">
		                	<i class="fab fa-instagram"></i>
		                </a>
		            </nav>
         		</div>
         		
         	</div>
         	<div class="col-lg-4">
         		<div class="footer-widget px-lg-5 px-0">
         			<h4>Open Hours</h4>
	         		<ul class="list-unstyled open-hours">
		                <li class="d-flex justify-content-between"><span>Monday</span><span>9:00 - 24:00</span></li>
		                <li class="d-flex justify-content-between"><span>Tuesday</span><span>9:00 - 24:00</span></li>
		                <li class="d-flex justify-content-between"><span>Wednesday</span><span>9:00 - 24:00</span></li>
		                <li class="d-flex justify-content-between"><span>Thursday</span><span>9:00 - 24:00</span></li>
		                <li class="d-flex justify-content-between"><span>Friday</span><span>9:00 - 02:00</span></li>
		                <li class="d-flex justify-content-between"><span>Saturday</span><span>9:00 - 02:00</span></li>
		                <li class="d-flex justify-content-between"><span>Sunday</span><span> Closed</span></li>
		              </ul>
         		</div>
         		
         	</div>

         	<div class="col-lg-4">
         		<div class="footer-widget pl-lg-5 pl-0">
         			<h4>Online Delivery</h4>
	         		<p>Craving your favorite pastries and coffee? Skip the line and order online for quick, easy pickup or delivery. Available at:
                        <br><b>GrabFood, ShopeeFood & GoFood</b>
                    </p>
         		</div>
         		
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
