<?php
include('db_connection.php');
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
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar w-100 navbar-expand-lg navbar-light bg-light position-fixed">
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
                    <a name="logout" class="btn btn-danger">Logout</a>
                <?php endif; ?>
                <?php if (!$isAdmin): ?>
                    <a href="login.php" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </form>
        </div>
    </nav>

    <div class="jumbotron text-center d-flex justify-content-center align-items-center">
        <div class="box-jumbotron z-index position-relative text-white">
            <h1 class="fw-bold">Selamat Datang di Situs Desa Jatinegoro</h1>
            <p class="lead">Ayo, jelajahi dan temukan pesona Desa Jatinegoro!</p>
            <hr class="my-4 bg-white">
            <a class="btn btn-warning text-white btn-lg" href="#" role="button">Mulai sekarang</a>
        </div>
    </div>

    <div class="container mt-5">
        <?php if ($isAdmin): ?>
            <p>Anda adalah Admin. Anda dapat mengelola data warga dan pengajuan.</p>
        <?php else: ?>
            <p>
            <p>Desa Jatinegoro adalah tempat yang kaya akan budaya, tradisi, dan keindahan alam. Di sini, Anda akan merasakan keramahan warga desa serta suasana yang asri dan nyaman. Kami berkomitmen untuk membangun desa yang mandiri, maju, dan sejahtera, dengan mengedepankan kebersamaan dan kearifan lokal. Mari bersama-sama menjaga dan melestarikan potensi yang dimiliki Desa Jatinegoro untuk generasi mendatang.</p>
            </p>
        <?php endif; ?>
    </div>

    <!-- bagian informasi accordion -->
    <div class="container">
        <div class="page-content page-container" id="page-content">
            <div class="padding">
                <div class="row d-flex justify-content-center">
                    <div class="col grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <h2>Informasi Penting</h2>
                                <p class="card-descrition">Lihat informasi penting dari desa jatinegoro</p>
                                <div class="mt-4">
                                    <div class="accordion" id="accordion" role="tablist">
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-1">
                                                <h6 class="mb-0">
                                                    <a data-toggle="collapse" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1" data-abc="true" class="collapsed">
                                                        Kegiatan Bulan Ramadhan
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="collapse-1" class="collapse" role="tabpanel" aria-labelledby="heading-1" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <p class="mb-0"> Selama bulan Ramadhan, akan ada berbagai kegiatan seperti pengajian umum dan buka puasa bersama. Pastikan untuk mengikuti informasi lebih lanjut di halaman informasi.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-2">
                                                <h6 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2" data-abc="true">
                                                        Lomba 17 Agustus
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="collapse-2" class="collapse" role="tabpanel" aria-labelledby="heading-2" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p>Dalam rangka memperingati hari kemerdekaan, akan diadakan lomba-lomba menarik seperti panjat pinang dan makan kerupuk. Ayo ikut berpartisipasi!</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="heading-3">
                                                <h6 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3" data-abc="true">
                                                        Program Vaksinasi
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="collapse-3" class="collapse" role="tabpanel" aria-labelledby="heading-3" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p class="mb-0">Pemerintah desa akan mengadakan program vaksinasi untuk warga. Pastikan untuk mendaftar dan mengikuti jadwal yang telah ditentukan.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- bagian footer -->
    <!-- bagian footer -->
    <div class="container mt-5">
        <footer class="py-5">
            <div class="row">
                <div class="col-6 col-md-2 mb-3">
                    <h5>Laman</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Informasi</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Surat pengajuan</a></li>
                    </ul>
                </div>

                <div class="col-4 col-md-4 mb-3">
                    <h5>Tentang</h5>
                    <p>Sistem Desa Jatinegoro hadir dengan layanan pengajuan surat secara online untuk memudahkan kebutuhan administrasi warga.</p>
                </div>

                <div class="col-md-5 offset-md-1 mb-3">
                    <div class="social-media">
                        <h5>Ikuti Kami di Media Sosial</h5>
                        <div class="d-flex">
                            <div>
                                <a href="https://facebook.com" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-facebook" style="font-size: 1.5rem;"></i>
                                </a>
                            </div>
                            <div class="mx-4">
                                <a href="https://twitter.com" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-twitter" style="font-size: 1.5rem;"></i>
                                </a>
                            </div>
                            <div>
                                <a href="https://instagram.com" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-instagram" style="font-size: 1.5rem;"></i>
                                </a>
                            </div>
                            <div class="mx-4">
                                <a href="https://youtube.com" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-youtube" style="font-size: 1.5rem;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
                <p>&copy; <span id="currentYear"></span> desa jatinegoro, Inc. All rights reserved.</p>
                <ul class="list-unstyled d-flex">
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#twitter" />
                            </svg></a></li>
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#instagram" />
                            </svg></a></li>
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#facebook" />
                            </svg></a></li>
                </ul>
            </div>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Menambahkan tahun secara otomatis ke elemen dengan id "currentYear"
        document.addEventListener("DOMContentLoaded", function() {
            const currentYear = new Date().getFullYear(); // Mendapatkan tahun saat ini
            document.getElementById("currentYear").textContent = currentYear; // Menambahkan tahun ke elemen
        });
    </script>
</body>

</html>