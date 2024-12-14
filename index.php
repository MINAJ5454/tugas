<?php
include ('db_connection.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Sistem Desa</a>
        <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
                <?php if (!$isAdmin): ?>
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="information/information.php">Informasi</a></li>
                <li class="nav-item"><a class="nav-link" href="surat_pengajuan/surat_pengajuan.php">Surat Pengajuan</a></li>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <li class="nav-item"><a class="nav-link" href="data/view_data_warga.php">Lihat Data Warga</a></li>
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

    <div class="container mt-5">
        <h1>Selamat Datang di Situs Desa Jatinegoro</h1>
        <?php if ($isAdmin): ?>
            <p>Anda adalah Admin. Anda dapat mengelola data warga dan pengajuan.</p>
        <?php else: ?>
            <p>Anda adalah Warga. Silakan ajukan surat jika diperlukan atau bisa melihat informasi yang ada.</p>
        <?php endif; ?>

        <h2 class="mt-4">Informasi Penting</h2>
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Kegiatan Bulan Ramadhan
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        Selama bulan Ramadhan, akan ada berbagai kegiatan seperti pengajian umum dan buka puasa bersama. Pastikan untuk mengikuti informasi lebih lanjut di halaman informasi.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Lomba 17 Agustus
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        Dalam rangka memperingati hari kemerdekaan, akan diadakan lomba-lomba menarik seperti panjat pinang dan makan kerupuk. Ayo ikut berpartisipasi!
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Program Vaksinasi
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        Pemerintah desa akan mengadakan program vaksinasi untuk warga. Pastikan untuk mendaftar dan mengikuti jadwal yang telah ditentukan.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>