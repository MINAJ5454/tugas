<?php
include ('../db_connection.php');
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

    $sql = $conn ->prepare("INSERT INTO surat_pengajuan (`nama`, `alamat`, `no_hp`, `jenis_pengajuan`) VALUES(?, ?, ?, ?)");
    $sql->bind_param("ssis", $nama, $alamat, $noHp, $pengajuan);
    $query = $sql->execute();
    if($query) {
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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
            <button name="logout" class="btn btn-danger">Logout</a>
            <?php endif; ?>
            <?php if (!$isAdmin): ?>
                <a href="../login.php"><button name="" class="btn btn-submit">Login</a></a>
            <?php endif; ?>
        </form>
    </div>
    </nav>

    <div class="container">
        <h2 class="text-center mt-4">Form Surat Pengajuan</h2>
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
                        <select class="form-control" id="surat" name="surat" required>
                            <option value="">Pilih Jenis Pengajuan</option>
                            <option value="Pengajuan A">Pengajuan A</option>
                            <option value="Pengajuan B">Pengajuan B</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-submit btn-block">Kirim Pengajuan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>