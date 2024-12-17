<?php
include('../db_connection.php');
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
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                    <a name="logout" class="btn btn-danger">Logout</a>
                <?php endif; ?>
                <?php if (!$isAdmin): ?>
                    <a href="login.php" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </form>
        </div>
    </nav>

    <div class="container mt-5 bg-light p-5">
        <!-- Main Content -->
        <div class="mb-4">
            <h2 class="h5 mb-2">Informasi kegiatan</h2>
            <p class="text-muted">Ini adalah halaman informasi. Anda dapat menampilkan informasi yang relevan di sini.</p>
        </div>

        <!-- Ramadhan Activities Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Kegiatan Bulan Ramadhan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Tempat</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1 April 2023</td>
                                <td>Pengajian Umum</td>
                                <td>Masjid Al-Muhajirin</td>
                                <td>
                                    <div class="bg-light" style="width: 64px; height: 64px;">
                                        <img class="w-100 h-100" src="https://sidomulyo-bantul.desa.id/assets/files/artikel/kecil_1576557904WhatsApp%20Image%202019-12-14%20at%2021.11.26.jpeg" alt="">
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example ">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Independence Day Competition Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Kegiatan Lomba 17 Agustus</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Lomba</th>
                                <th>Tempat</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>17 Agustus 2023</td>
                                <td>Lomba Panjat Pinang</td>
                                <td>Lapangan Desa</td>
                                <td>
                                    <div class="bg-light" style="width: 64px; height: 64px;"></div>
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example ">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Informasi Pergantian RW dan RT -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pergantian RW dan RT</h5>
                <p class="text-muted">Tanggal: 20 Februari 2025</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>RW/RT</th>
                                <th>Nama Calon</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>RW 20</td>
                                <td>Roziham Abdul</td>
                                <td>
                                    <img src="path/to/your/image5.jpg" alt="Foto Calon Roziham Abdul" style="width: 64px; height: auto;" class="rounded">
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                            <tr>
                                <td>RW 20</td>
                                <td>Chandro Romosinto</td>
                                <td>
                                    <img src="path/to/your/image5.jpg" alt="Foto Calon Chandro Romosinto" style="width: 64px; height: auto;" class="rounded">
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                            <tr>
                                <td>RT 02</td>
                                <td>Adam Nikolas</td>
                                <td>
                                    <img src="path/to/your/image5.jpg" alt="Foto Calon Adam Nikolas" style="width: 64px; height: auto;" class="rounded">
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                            <tr>
                                <td>RT 01</td>
                                <td>Herdion Wiranggo</td>
                                <td>
                                    <img src="path/to/your/image5.jpg" alt="Foto Calon Herdion Wiranggo" style="width: 64px; height: auto;" class="rounded">
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                            <tr>
                                <td>RT 03</td>
                                <td>Tio Aljazera</td>
                                <td>
                                    <img src="path/to/your/image5.jpg" alt="Foto Calon Tio Aljazera" style="width: 64px; height: auto;" class="rounded">
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example ">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Penyuluhan Kesehatan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Topik</th>
                                <th>Tempat</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>20 Juni 2023</td>
                                <td>Penyuluhan Gizi Seimbang</td>
                                <td>Balai Desa</td>
                                <td>
                                    <img src="path/to/your/image9.jpg" alt="Penyuluhan Gizi Seimbang" style="width: 64px; height: auto;">
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                            <tr>
                                <td>25 Juni 2023</td>
                                <td>Penyuluhan Kesehatan Mental</td>
                                <td>Balai Desa</td>
                                <td>
                                    <img src="path/to/your/image10.jpg" alt="Penyuluhan Kesehatan Mental" style="width: 64px; height: auto;">
                                </td>
                                <td>
                                    <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example ">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
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

    <script>
        // Menambahkan tahun secara otomatis ke elemen dengan id "currentYear"
        document.addEventListener("DOMContentLoaded", function() {
            const currentYear = new Date().getFullYear(); // Mendapatkan tahun saat ini
            document.getElementById("currentYear").textContent = currentYear; // Menambahkan tahun ke elemen
        });
    </script>
</body>

</html>