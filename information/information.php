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

// Query untuk mengambil data berdasarkan kategori
$sql = "SELECT * FROM kegiatan_desa k
        LEFT JOIN lomba l ON k.id = l.kegiatan_id
        LEFT JOIN rw_rt r ON k.id = r.kegiatan_id
        LEFT JOIN penyuluhan p ON k.id = p.kegiatan_id
        ORDER BY k.tanggal DESC";
$result = $conn->query($sql);

$ramadhanActivities = [];
$lombaActivities = [];
$rwrtActivities = [];
$penyuluhanActivities = [];

// Memisahkan data ke dalam kategori yang berbeda
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['kategori_id'] == 2) { // Lomba
            $lombaActivities[] = $row;
        } elseif ($row['kategori_id'] == 3) { // RWRT
            $rwrtActivities[] = $row;
        } elseif ($row['kategori_id'] == 4) { // Penyuluhan
            $penyuluhanActivities[] = $row;
        } else { // Ramadhan
            $ramadhanActivities[] = $row;
        }
    }
}

// Close connection
$conn->close();

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
                <?php if ($isAdmin): ?>
                    <li class="nav-item"><a class="nav-link" href="data/view_data_warga.php">Kegiatan</a></li>
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
                            <?php foreach ($ramadhanActivities as $activity): ?>
                                <tr>
                                    <td><?= $activity['tanggal'] ?></td>
                                    <td><?= $activity['kegiatan'] ?></td>
                                    <td><?= $activity['tempat'] ?></td>
                                    <td>
                                        <?php if ($activity['foto']): ?>
                                            <div class="bg-light" style="width: 64px; height: 64px;">
                                                <img class="w-100 h-100" src="../data/<?= $activity['foto'] ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light" style="width: 64px; height: 64px;"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination (if needed) -->
                <nav aria-label="Page navigation example">
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

        <!-- Lomba Activities Section -->
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
                            <?php foreach ($lombaActivities as $activity): ?>
                                <tr>
                                    <td><?= $activity['tanggal'] ?></td>
                                    <td><?= $activity['nama_lomba'] ?></td>
                                    <td><?= $activity['tempat'] ?></td>
                                    <td>
                                        <?php if ($activity['foto']): ?>
                                            <div class="bg-light" style="width: 64px; height: 64px;">
                                                <img class="w-100 h-100" src="../data/<?= $activity['foto'] ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-light" style="width: 64px; height: 64px;"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination (if needed) -->
                <nav aria-label="Page navigation example">
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

        <!-- RWRT Activities Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pergantian RW dan RT</h5>
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
                            <?php foreach ($rwrtActivities as $activity): ?>
                                <tr>
                                    <td><?= $activity['rw_rt'] ?></td>
                                    <td><?= $activity['nama_calon'] ?></td>
                                    <td>
                                        <img src="../data/<?= $activity['foto'] ?>" alt="Foto Calon" style="width: 64px; height: auto;">
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination (if needed) -->
                <nav aria-label="Page navigation example">
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

        <!-- Penyuluhan Activities Section -->
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
                            <?php foreach ($penyuluhanActivities as $activity): ?>
                                <tr>
                                    <td><?= $activity['tanggal'] ?></td>
                                    <td><?= $activity['topik'] ?></td>
                                    <td><?= $activity['tempat'] ?></td>
                                    <td>
                                        <img src="../data/<?= $activity['foto'] ?>" alt="Penyuluhan Foto" style="width: 64px; height: auto;">
                                    </td>
                                    <td>
                                        <button class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination (if needed) -->
                <nav aria-label="Page navigation example">
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

        <script>
            // Menambahkan tahun secara otomatis ke elemen dengan id "currentYear"
            document.addEventListener("DOMContentLoaded", function() {
                const currentYear = new Date().getFullYear(); // Mendapatkan tahun saat ini
                document.getElementById("currentYear").textContent = currentYear; // Menambahkan tahun ke elemen
            });
        </script>
</body>

</html>