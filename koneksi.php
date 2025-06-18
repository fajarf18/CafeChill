<?php
$koneksi = mysqli_connect("localhost", "root", "", "dbcafe");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
