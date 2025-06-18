<?php
session_start();
if (empty($_SESSION['email'])) {
    echo "<script>alert('Maaf Anda Harus Login!'); window.location.assign('login.php');</script>";
    exit();
}
if ($_SESSION['role'] !== 'staf' && $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Anda tidak memiliki akses ke halaman ini!'); window.location.href='index.php';</script>";
    exit();
}

$koneksi = mysqli_connect("localhost", "root", "", "dbcafe");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "SELECT id, nama, email, password, role FROM tbl_user"; // Ambil ID untuk link
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Byte Cafe - Manajemen User</title>
    <meta name="description" content="Resto">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
</head>
<body data-spy="scroll" data-target="#navbar" class="static-layout">
    <div class="boxed-page">
        <?php include 'navbaradmin.php'; ?>

        <div class="container table-container mt-5 pt-5">
            <h2 class="text-center mb-4">Data User</h2>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                            <?php while($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td>
                                    <span id="password_<?php echo $row['id']; ?>" data-password="<?php echo htmlspecialchars($row['password']); ?>">
                                        <?php echo str_repeat('•', 8); ?>
                                    </span>
                                    <i class="fas fa-eye password-toggle" onclick="togglePasswordVisibility('password_<?php echo $row['id']; ?>')" style="cursor:pointer; margin-left:8px; color:#6c757d;"></i>
                                </td>
                                <td>
                                    <span class="badge badge-pill role-<?php echo strtolower(htmlspecialchars($row['role'])); ?>">
                                        <?php echo ucfirst(htmlspecialchars($row['role'])); ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted p-4">Tidak ada data user.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/bootstrap/popper.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>

    <script>
    function togglePasswordVisibility(fieldId) {
        var passwordField = document.getElementById(fieldId);
        var actualPassword = passwordField.getAttribute('data-password');
        
        if (passwordField.textContent === actualPassword) {
            passwordField.textContent = '•'.repeat(8);
        } else {
            passwordField.textContent = actualPassword;
        }
    }
    </script>
</body>
</html>
