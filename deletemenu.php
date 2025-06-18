<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "dbcafe");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];
    $deleteQuery = "DELETE FROM tbl_menu WHERE id_menu='$id_menu'";  // Adjust column name based on your table structure
    
    if (mysqli_query($koneksi, $deleteQuery)) {
        echo "<script>alert('Menu berhasil dihapus!'); window.location.href='listmenu.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "<script>alert('ID menu tidak ditemukan!'); window.location.href='listmenu.php';</script>";
}
?>
