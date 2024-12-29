<?php
include('../db_connection.php');
session_start();

$isAdmin = isset($_SESSION['username']);

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}



// Tentukan jumlah data per halaman
$resultsPerPage = 5;

// Menangani pagination untuk Ramadhan
$pageRamadhan = isset($_GET['page_ramadhan']) ? (int)$_GET['page_ramadhan'] : 1;
$offsetRamadhan = ($pageRamadhan - 1) * $resultsPerPage;
$sqlRamadhan = "SELECT * FROM kegiatan_desa WHERE kategori_id = 1 ORDER BY tanggal DESC LIMIT $resultsPerPage OFFSET $offsetRamadhan";
$resultRamadhan = $conn->query($sqlRamadhan);
// Menangani pagination untuk Lomba
$pageLomba = isset($_GET['page_lomba']) ? (int)$_GET['page_lomba'] : 1;
$offsetLomba = ($pageLomba - 1) * $resultsPerPage;
$sqlLomba = "SELECT k.id AS kegiatan_id, k.kategori_id, k.tanggal, k.kegiatan, k.tempat, k.foto, l.nama_lomba
             FROM kegiatan_desa k
             LEFT JOIN lomba l ON k.id = l.kegiatan_id
             WHERE k.kategori_id = 2
             ORDER BY k.tanggal DESC LIMIT $resultsPerPage OFFSET $offsetLomba";
$resultLomba = $conn->query($sqlLomba);

// Menangani pagination untuk RWRT
$pageRWRT = isset($_GET['page_rwrt']) ? (int)$_GET['page_rwrt'] : 1;
$offsetRWRT = ($pageRWRT - 1) * $resultsPerPage;
$sqlRWRT = "SELECT k.id AS kegiatan_id, k.kategori_id, k.tanggal, k.kegiatan, k.tempat, k.foto, r.rw_rt, r.nama_calon
            FROM kegiatan_desa k
            LEFT JOIN rw_rt r ON k.id = r.kegiatan_id
            WHERE k.kategori_id = 3
            ORDER BY k.tanggal DESC LIMIT $resultsPerPage OFFSET $offsetRWRT";
$resultRWRT = $conn->query($sqlRWRT);

// Menangani pagination untuk Penyuluhan
$pagePenyuluhan = isset($_GET['page_penyuluhan']) ? (int)$_GET['page_penyuluhan'] : 1;
$offsetPenyuluhan = ($pagePenyuluhan - 1) * $resultsPerPage;
$sqlPenyuluhan = "SELECT k.id AS kegiatan_id, k.kategori_id, k.tanggal, k.kegiatan, k.tempat, k.foto, p.topik
                  FROM kegiatan_desa k
                  LEFT JOIN penyuluhan p ON k.id = p.kegiatan_id
                  WHERE k.kategori_id = 4
                  ORDER BY k.tanggal DESC LIMIT $resultsPerPage OFFSET $offsetPenyuluhan";
$resultPenyuluhan = $conn->query($sqlPenyuluhan);


// Total data untuk pagination
$totalRamadhan = $conn->query("SELECT COUNT(*) AS total FROM kegiatan_desa WHERE kategori_id = 1")->fetch_assoc()['total'];
$totalLomba = $conn->query("SELECT COUNT(*) AS total FROM kegiatan_desa WHERE kategori_id = 2")->fetch_assoc()['total'];
$totalRWRT = $conn->query("SELECT COUNT(*) AS total FROM kegiatan_desa WHERE kategori_id = 3")->fetch_assoc()['total'];
$totalPenyuluhan = $conn->query("SELECT COUNT(*) AS total FROM kegiatan_desa WHERE kategori_id = 4")->fetch_assoc()['total'];

// Total pages untuk setiap kategori
$totalPages['ramadhan'] = ceil($totalRamadhan / $resultsPerPage);
$totalPages['lomba'] = ceil($totalLomba / $resultsPerPage);
$totalPages['rwrt'] = ceil($totalRWRT / $resultsPerPage);
$totalPages['penyuluhan'] = ceil($totalPenyuluhan / $resultsPerPage);


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
                    <a href="../login.php" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Main Content -->
        <div class="mb-4">
            <h2 class="h5 mb-2">Informasi kegiatan</h2>
            <p class="text-muted">Ini adalah halaman informasi. Anda dapat menampilkan informasi yang relevan di sini.</p>
        </div>
        <?php foreach (['ramadhan', 'lomba', 'rwrt', 'penyuluhan'] as $category): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Kegiatan <?= ucfirst($category) ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <?php if ($category == 'ramadhan'): ?>
                                        <th>Tanggal</th>
                                        <th>Kegiatan</th>
                                        <th>Tempat</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    <?php elseif ($category == 'lomba'): ?>
                                        <th>Tanggal</th>
                                        <th>Nama Lomba</th>
                                        <th>Tempat</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    <?php elseif ($category == 'rwrt'): ?>
                                        <th>RW/RT</th>
                                        <th>Nama Calon</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    <?php elseif ($category == 'penyuluhan'): ?>
                                        <th>Tanggal</th>
                                        <th>Topik</th>
                                        <th>Tempat</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Menampilkan data kategori sesuai dengan kategori yang aktif
                                if ($category == 'ramadhan' && $resultRamadhan->num_rows > 0):
                                    while ($activity = $resultRamadhan->fetch_assoc()):
                                ?>
                                        <tr>
                                            <td><?= $activity['tanggal'] ?></td>
                                            <td><?= $activity['kegiatan'] ?></td>
                                            <td><?= $activity['tempat'] ?></td>
                                            <td>
                                                <?php if ($activity['foto']): ?>
                                                    <img src="../data/<?= $activity['foto'] ?>" alt="Foto" style="max-width: 64px;">
                                                <?php else: ?>
                                                    <span>No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="detail_ramadhan.php?id=<?= $activity['id'] ?>" class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php elseif ($category == 'lomba' && $resultLomba->num_rows > 0): ?>
                                    <!-- Tampilkan data untuk Lomba -->
                                    <?php while ($activity = $resultLomba->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $activity['tanggal'] ?></td>
                                            <td><?= $activity['nama_lomba'] ?></td>
                                            <td><?= $activity['tempat'] ?></td>
                                            <td>
                                                <?php if ($activity['foto']): ?>
                                                    <img src="../data/<?= $activity['foto'] ?>" alt="Foto" style="max-width: 64px;">
                                                <?php else: ?>
                                                    <span>No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="detail_kegiatan_lomba.php?id=<?= $activity['kegiatan_id'] ?>" class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php elseif ($category == 'rwrt' && $resultRWRT->num_rows > 0): ?>
                                    <!-- Tampilkan data untuk RWRT -->
                                    <?php while ($activity = $resultRWRT->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $activity['rw_rt'] ?></td>
                                            <td><?= $activity['nama_calon'] ?></td>
                                            <td>
                                                <?php if ($activity['foto']): ?>
                                                    <img src="../data/<?= $activity['foto'] ?>" alt="Foto" style="max-width: 64px;">
                                                <?php else: ?>
                                                    <span>No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="detail_rwrt.php?id=<?= $activity['kegiatan_id'] ?>" class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php elseif ($category == 'penyuluhan' && $resultPenyuluhan->num_rows > 0): ?>
                                    <!-- Tampilkan data untuk Penyuluhan -->
                                    <?php while ($activity = $resultPenyuluhan->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $activity['tanggal'] ?></td>
                                            <td><?= $activity['topik'] ?></td>
                                            <td><?= $activity['tempat'] ?></td>
                                            <td>
                                                <?php if ($activity['foto']): ?>
                                                    <img src="../data/<?= $activity['foto'] ?>" alt="Foto" style="max-width: 64px;">
                                                <?php else: ?>
                                                    <span>No Image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="detail_penyuluhan.php?id=<?= $activity['kegiatan_id'] ?>" class="btn btn-secondary btn-sm">Lihat Informasi Selengkapnya</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($category == 'ramadhan'): ?>
                        <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPages['ramadhan']; $i++): ?>
                                    <li class="page-item <?= ($i == $pageRamadhan) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page_ramadhan=<?= $i ?>&page_lomba=<?= $pageLomba ?>&page_rwrt=<?= $pageRWRT ?>&page_penyuluhan=<?= $pagePenyuluhan ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php elseif ($category == 'lomba'): ?>
                        <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPages['lomba']; $i++): ?>
                                    <li class="page-item <?= ($i == $pageLomba) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page_ramadhan=<?= $pageRamadhan ?>&page_lomba=<?= $i ?>&page_rwrt=<?= $pageRWRT ?>&page_penyuluhan=<?= $pagePenyuluhan ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php elseif ($category == 'rwrt'): ?>
                        <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPages['rwrt']; $i++): ?>
                                    <li class="page-item <?= ($i == $pageRWRT) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page_ramadhan=<?= $pageRamadhan ?>&page_lomba=<?= $pageLomba ?>&page_rwrt=<?= $i ?>&page_penyuluhan=<?= $pagePenyuluhan ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php elseif ($category == 'penyuluhan'): ?>
                        <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPages['penyuluhan']; $i++): ?>
                                    <li class="page-item <?= ($i == $pagePenyuluhan) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page_ramadhan=<?= $pageRamadhan ?>&page_lomba=<?= $pageLomba ?>&page_rwrt=<?= $pageRWRT ?>&page_penyuluhan=<?= $i ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

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