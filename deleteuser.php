<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "dbcafe");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM tbl_user WHERE nama='$id'";
    
    if (mysqli_query($koneksi, $deleteQuery)) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='datauser.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='datauser.php';</script>";
}
?>