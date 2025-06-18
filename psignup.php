<?php
include 'koneksi.php';

$nama = mysqli_real_escape_string($koneksi, $_POST["nama"]);
$email = mysqli_real_escape_string($koneksi, $_POST["email"]);
$password = mysqli_real_escape_string($koneksi, $_POST["password"]);
$role = 'user';

// Cek apakah nama sudah ada
$cek_nama = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE nama = '$nama'");
if (mysqli_num_rows($cek_nama) > 0) {
    echo "<script>
        alert('Nama sudah digunakan. Silakan gunakan nama lain.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

// Cek apakah email sudah ada
$cek_email = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE email = '$email'");
if (mysqli_num_rows($cek_email) > 0) {
    echo "<script>
        alert('Email sudah terdaftar. Silakan gunakan email lain atau login.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Simpan data
$query_sql = "INSERT INTO tbl_user (nama, email, password, role, foto_profil) 
              VALUES ('$nama', '$email', '$password', '$role', 'default.jpg')";
$signup = mysqli_query($koneksi, $query_sql);

if ($signup) { 
    header("Location: login.php");
} else {
    echo "Sign Up Gagal: " . mysqli_error($koneksi);
}
?>
