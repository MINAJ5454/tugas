<?php
include ('../db_connection.php');
session_start();


if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

$isAdmin = isset($_SESSION['username'])
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <title>Informasi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Sistem Desa</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?php if (!$isAdmin): ?>
                <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="information.php">Informasi</a></li>
                <li class="nav-item"><a class="nav-link" href="../surat_pengajuan/surat_pengajuan.php">Surat Pengajuan</a></li>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <li class="nav-item"><a class="nav-link" href="view_data_warga.php">Lihat Data Warga</a></li>
                <?php endif; ?>
            </ul>
            <form method="POST">
            <?php if ($isAdmin): ?>
            <button name="logout" class="btn btn-danger">Logout</a>
            <?php endif; ?>
            <?php if (!$isAdmin): ?>
                <a href="login.php"><button name="" class="btn btn-submit">Login</a></a>
            <?php endif; ?>
        </form>
        </div>
    </nav>

    <div class="container mt-5 bg-light">
    <h1>Informasi</h1>
    <p>Ini adalah halaman informasi. Anda dapat menampilkan informasi yang relevan di sini.</p>

    <h2>Kegiatan Bulan Ramadhan</h2>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tanggal</th>
                <th>Kegiatan</th>
                <th>Tempat</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
        <tr>
                <td>1 April 2023</td>
                <td>Pengajian Umum</td>
                <td>Masjid Al-Muhajirin</td>
                <td>
                    <img src="path/to/your/image1.jpg" alt="Pengajian Umum" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
            <tr>
                <td>5 April 2023</td>
                <td>Buka Puasa Bersama</td>
                <td>Balai Desa</td>
                <td>
                    <img src="path/to/your/image2.jpg" alt="Buka Puasa Bersama" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Kegiatan Lomba 17 Agustus</h2>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tanggal</th>
                <th>Nama Lomba</th>
                <th>Tempat</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
        <tr>
                <td>17 Agustus 2023</td>
                <td>Lomba Panjat Pinang</td>
                <td>Lapangan Desa</td>
                <td>
                    <img src="path/to/your/image3.jpg" alt="Lomba Panjat Pinang" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
            <tr>
                <td>17 Agustus 2023</td>
                <td>Lomba Makan Kerupuk</td>
                <td>Lapangan Desa</td>
                <td>
                    <img src="path/to/your/image4.jpg" alt="Lomba Makan Kerupuk" style="width:  100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Informasi Pergantian RW dan RT, tanggal 20 Febuari 2025</h2>
    <table  class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Nama Calon RW/RT</th>
                <th>Calon RW/RT </th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>RW 20</td>
                <td>Roziham abdul</td>
                <td>
                    <img src="path/to/your/image5.jpg" alt="Foto Calon" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
            <tr>
                <td>RW 20</td>
                <td>Chandro Romosinto</td>
                <td>
                    <img src="path/to/your/image5.jpg" alt="Foto Calon" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
            <tr>
                <td>RT 02</td>
                <td>Adam nikolas</td>
                <td>
                    <img src="path/to/your/image5.jpg" alt="Foto Calon" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
            <tr>
                <td>RT 01</td>
                <td>Herdion wiranggo</td>
                <td>
                    <img src="path/to/your/image5.jpg" alt="Foto Calon" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
            <tr>
                <td>RT 03</td>
                <td>Tio Aljazera</td>
                <td>
                    <img src="path/to/your/image5.jpg" alt="Foto Calon" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Penyuluhan Kesehatan</h2>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tanggal</th>
                <th>Topik</th>
                <th>Tempat</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>20 Juni 2023</td>
                <td>Penyuluhan Gizi Seimbang</td>
                <td>Balai Desa</td>
                <td>
                    <img src="path/to/your/image9.jpg" alt="Penyuluhan Gizi Seimbang" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
            <tr>
                <td>25 Juni 2023</td>
                <td>Penyuluhan Kesehatan Mental</td>
                <td>Balai Desa</td>
                <td>
                    <img src="path/to/your/image10.jpg" alt="Penyuluhan Kesehatan Mental" style="width: 100px; height: auto;">
                </td>
                <td>
                    <button class="btn btn-info">Lihat Informasi Selengkapnya</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>