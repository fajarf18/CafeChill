<?php
require_once 'koneksi.php'; // File koneksi database

// Periksa apakah form telah di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil email dari form
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        echo "Email pengguna tidak ditemukan.";
        exit;
    }

    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Ambil data dari form
    $nama = htmlspecialchars($_POST['nama']);
    $password = htmlspecialchars($_POST['password']);
    $foto_profil = null; // Default jika tidak ada file yang diunggah

// Proses file upload (jika ada)
if (!empty($_FILES['foto_profil']['name'])) {
    $target_dir = "uploads/";  // Set the target directory
    $file_name = basename($_FILES['foto_profil']['name']);  // Get just the filename
    $foto_profil = $file_name;  // Store just the filename, not the full path
    $imageFileType = strtolower(pathinfo($foto_profil, PATHINFO_EXTENSION));

    // Validasi jenis file
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Format file tidak valid. Hanya JPG, JPEG, PNG, dan GIF yang diizinkan.";
        exit;
    }

    // Pindahkan file ke folder target
    if (!move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_dir . $foto_profil)) {
        echo "Terjadi kesalahan saat mengunggah file.";
        exit;
    }
}

    // Update password hanya jika ada perubahan
    $update_password = "";
    if (!empty($password)) {
        $update_password = ", password='$password'";
    }

    // Update foto profil hanya jika ada file baru
    $update_foto = "";
    if ($foto_profil) {
        $update_foto = ", foto_profil='$foto_profil'";
    }

    // Query untuk update data berdasarkan email
    $query = "
        UPDATE tbl_user 
        SET 
            nama = '$nama' 
            $update_password 
            $update_foto
        WHERE email = '$email'
    ";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo "Profil berhasil diperbarui.";
        header("Location: profile.php"); // Redirect ke halaman profil
        exit;
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }
} else {
    echo "Metode tidak valid.";
}
