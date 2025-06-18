<?php 
    // Ambil data dari form login
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Termasuk file koneksi
    include 'koneksi.php';

    // Query untuk mencari data berdasarkan email dan password
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$password'");

    // Cek apakah data ditemukan
    if (mysqli_num_rows($query) == 0) { ?>
        <script> 
            alert("Email dan Password tidak ditemukan.");
            window.location.assign("login.php");
        </script>
    <?php
    } else {
        // Ambil data hasil query
        $data = mysqli_fetch_assoc($query);

        // Mulai session
        session_start();

        // Simpan data ke session
        $_SESSION["id"] = $data["id"];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['password'] = $data['password'];
        $_SESSION['role'] = $data['role']; // Pastikan role dimasukkan ke session

        // Cek role dan arahkan ke halaman yang sesuai
        if ($_SESSION['role'] == 'user') {
            header("location:index.php");
        } elseif ($_SESSION['role'] == 'staf') {
            header("location:admin.php");
        } else {
            echo "Role tidak dikenali.";
        }
    }
?>
