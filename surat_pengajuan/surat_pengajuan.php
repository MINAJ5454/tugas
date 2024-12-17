<?php
include('../db_connection.php');
session_start();


if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
$isAdmin = isset($_SESSION['username']);

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $noHp = $_POST['no_hp'];
    $pengajuan = $_POST['surat'];

    $sql = $conn->prepare("INSERT INTO surat_pengajuan (`nama`, `alamat`, `no_hp`, `jenis_pengajuan`) VALUES(?, ?, ?, ?)");
    $sql->bind_param("ssis", $nama, $alamat, $noHp, $pengajuan);
    $query = $sql->execute();
    if ($query) {
        header('Location: berhasil.php');
    } else {
        header('location: surat_pengajuan.php?status=Error');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengajuan</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light position-fixed w-100">
        <a class="navbar-brand" href="#">Sistem Desa</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../information/information.php">Informasi</a></li>
                <li class="nav-item"><a class="nav-link" href="surat_pengajuan.php">Surat Pengajuan</a></li>
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

    <div class="container form-pengajuan">
        <h2 class="text-center mt-4">Form Surat Pengajuan</h2>
        <p class="text-center">Anda adalah Warga. Silakan ajukan surat jika diperlukan atau bisa melihat informasi yang ada.</p>
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                    <div class="form-group">
                        <label for="surat">Jenis Pengajuan</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Kirim Pengajuan</button>
                </form>

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