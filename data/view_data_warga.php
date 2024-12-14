<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: home.php"); // Redirect ke halaman home jika bukan admin
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

include ('../db_connection.php');
$query = "SELECT * FROM surat_pengajuan";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Data Warga</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Sistem Desa</a>
        <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">

                <li class="nav-item"><a class="nav-link" href="data/view_data_warga.php">Lihat Data Warga</a></li>

            </ul>
            <form method="POST">
                <button name="logout" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Lihat Data Warga</h1>
        <!-- Konten untuk menampilkan data warga -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Jenis Pengajuan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data, ganti dengan data dari database -->
                <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_hp']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jenis_pengajuan']) . "</td>";
                    echo "<td><a href='../edit.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                    echo "<a href='../delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>