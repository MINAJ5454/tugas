<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil nilai dari form
    $kategori_id = $_POST['kategori_id'];
    $tanggal = $_POST['tanggal'] ?? null;
    $tempat = $_POST['tempat'] ?? null;
    $kegiatan = $_POST['kegiatan'];
    $foto = null;
    $rw_rt = null;
    $nama_calon = null;
    $nama_lomba = null;
    $topik = null;

    // Verifikasi kategori_id valid
    $kategoriValid = false;
    $sqlCheckKategori = "SELECT id FROM kategori_kegiatan WHERE id = ?";
    $stmtCheckKategori = $conn->prepare($sqlCheckKategori);
    $stmtCheckKategori->bind_param('i', $kategori_id);
    $stmtCheckKategori->execute();
    $stmtCheckKategori->store_result();

    if ($stmtCheckKategori->num_rows > 0) {
        $kategoriValid = true;
    } else {
        echo "<div class='alert alert-danger' role='alert'>Kategori tidak valid!</div>";
        exit();
    }

    // Tentukan nilai kegiatan berdasarkan kategori
    if ($kategori_id == 2) { // Lomba
        $nama_lomba = $_POST['nama_lomba'] ?? null;
        if (empty($nama_lomba)) {
            echo "<div class='alert alert-danger' role='alert'>Nama Lomba tidak boleh kosong untuk kategori Lomba!</div>";
            exit();
        }
    } elseif ($kategori_id == 3) { // RWRT
        $rw_rt = $_POST['rw_rt'] ?? null;
        $nama_calon = $_POST['nama_calon'] ?? null;
        if (empty($rw_rt) || empty($nama_calon)) {
            echo "<div class='alert alert-danger' role='alert'>RW/RT dan Nama Calon tidak boleh kosong untuk kategori RWRT!</div>";
            exit();
        }
    } elseif ($kategori_id == 4) { // Penyuluhan
        $topik = $_POST['topik'] ?? null;
        if (empty($topik)) {
            echo "<div class='alert alert-danger' role='alert'>Topik tidak boleh kosong untuk kategori Penyuluhan!</div>";
            exit();
        }
    }

    // Proses upload foto jika ada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['foto']['name']);
        $targetFilePath = $targetDir . $fileName;

        // Pastikan foto berhasil diupload
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
            $foto = $targetFilePath;
        } else {
            echo "<div class='alert alert-danger' role='alert'>Gagal meng-upload foto!</div>";
            exit();
        }
    }

    // Masukkan data ke tabel kegiatan_desa
    $sql = "INSERT INTO kegiatan_desa (kategori_id, tanggal, kegiatan, tempat, foto) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issss', $kategori_id, $tanggal, $kegiatan, $tempat, $foto);

    if ($stmt->execute()) {
        $kegiatan_id = $stmt->insert_id;

        // Masukkan detail berdasarkan kategori
        if ($kategori_id == 2) { // Lomba
            $sqlLomba = "INSERT INTO lomba (kegiatan_id, nama_lomba) VALUES (?, ?)";
            $stmtLomba = $conn->prepare($sqlLomba);
            $stmtLomba->bind_param('is', $kegiatan_id, $nama_lomba);
            $stmtLomba->execute();
        } elseif ($kategori_id == 3) { // RWRT
            $sqlRWRT = "INSERT INTO rw_rt (kegiatan_id, rw_rt, nama_calon) VALUES (?, ?, ?)";
            $stmtRWRT = $conn->prepare($sqlRWRT);
            $stmtRWRT->bind_param('iss', $kegiatan_id, $rw_rt, $nama_calon);
            $stmtRWRT->execute();
        } elseif ($kategori_id == 4) { // Penyuluhan
            $sqlPenyuluhan = "INSERT INTO penyuluhan (kegiatan_id, topik) VALUES (?, ?)";
            $stmtPenyuluhan = $conn->prepare($sqlPenyuluhan);
            $stmtPenyuluhan->bind_param('is', $kegiatan_id, $topik);
            $stmtPenyuluhan->execute();
        }

        echo "<div class='alert alert-success' role='alert'>Data berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Gagal menambahkan data: " . $conn->error . "</div>";
    }
    $stmt->close();
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

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tambah Kegiatan</title>

        <!-- Link Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-6gVd9GSBpOLhkKlsMx5RAi2dEXBo8MlRxT+N5HJ2wsP+0i1P2ayMf5iQPIEbR8FG" crossorigin="anonymous">

        <!-- Optional: Link untuk ikon Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            .kategori-input {
                margin-top: 1em;
            }

            .form-container {
                max-width: 600px;
                margin: 2em auto;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
            <div>
                <a class="navbar-brand" href="#">Sistem Desa</a>
            </div>
            <div class="collapse navbar-collapse ">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="view_data_warga.php">Lihat Data Warga</a></li>
                </ul>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="view_data_kegiatan.php">Kegiatan</a></li>
                </ul>
                <form method="POST">
                    <button name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </nav>
        <div class="container mt-5">
            <h2 class="mb-4">Tambah Kegiatan</h2>
            <form action="view_data_kegiatan.php" method="POST" enctype="multipart/form-data" id="form-kegiatan" onsubmit="resetForm()">
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select" required onchange="toggleInputFields()">
                        <option value="">Pilih Kategori</option>
                        <option value="1">Ramadhan</option>
                        <option value="2">Lomba</option>
                        <option value="3">RWRT</option>
                        <option value="4">Penyuluhan</option>
                    </select>
                </div>

                <div id="input-general" class="mb-3" style="display: none;">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control">

                    <label for="tempat" class="form-label">Tempat</label>
                    <input type="text" name="tempat" id="tempat" class="form-control">
                    <div class="box-kegiatan">
                        <label for="kegiatan" class="form-label">Kegiatan</label>
                        <input type="text" name="kegiatan" id="kegiatan" class="form-control">
                    </div>
                </div>

                <div id="input-lomba" class="kategori-input" style="display: none;">
                    <label for="nama_lomba" class="form-label">Nama Lomba</label>
                    <input type="text" name="nama_lomba" id="nama_lomba" class="form-control">
                </div>

                <div id="input-rwrt" class="kategori-input" style="display: none;">
                    <label for="rw_rt" class="form-label">RW/RT</label>
                    <input type="text" name="rw_rt" id="rw_rt" class="form-control">
                    <label for="nama_calon" class="form-label">Nama Calon</label>
                    <input type="text" name="nama_calon" id="nama_calon" class="form-control">
                </div>

                <div id="input-penyuluhan" class="kategori-input" style="display: none;">
                    <label for="topik" class="form-label">Topik</label>
                    <input type="text" name="topik" id="topik" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Upload Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
        <div class="container mt-5">
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
                                                    <button class="btn btn-warning btn-edit"
                                                        data-kegiatan='<?= htmlspecialchars(json_encode($activity), ENT_QUOTES, 'UTF-8') ?>'>
                                                        Edit
                                                    </button>
                                                    <a href="delete_kegiatan.php?id=<?= $activity['id'] ?>&kategori_id=<?= $activity['kategori_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
                                                    <button class="btn btn-warning btn-edit"
                                                        data-kegiatan='<?= htmlspecialchars(json_encode($activity), ENT_QUOTES, 'UTF-8') ?>'>
                                                        Edit
                                                    </button>
                                                    <a href="delete_kegiatan.php?id=<?= $activity['kegiatan_id'] ?>&kategori_id=<?= $activity['kategori_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
                                                    <button class="btn btn-warning btn-edit"
                                                        data-kegiatan='<?= htmlspecialchars(json_encode($activity), ENT_QUOTES, 'UTF-8') ?>'>
                                                        Edit
                                                    </button>
                                                    <a href="delete_kegiatan.php?id=<?= $activity['kegiatan_id'] ?>&kategori_id=<?= $activity['kategori_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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
                                                    <button class="btn btn-warning btn-edit"
                                                        data-kegiatan='<?= htmlspecialchars(json_encode($activity), ENT_QUOTES, 'UTF-8') ?>'>
                                                        Edit
                                                    </button>
                                                    <a href="delete_kegiatan.php?id=<?= $activity['kegiatan_id'] ?>&kategori_id=<?= $activity['kategori_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
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


        <!-- Modal Update -->
        <div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="modalUpdateLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="update_kegiatan.php" method="POST" enctype="multipart/form-data" id="form-update-kegiatan">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalUpdateLabel">Update Kegiatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="update_id">

                            <div class="mb-3">
                                <label for="update_kategori_id" class="form-label">Kategori</label>
                                <select name="kategori_id" id="update_kategori_id" class="form-select" required onchange="toggleUpdateInputFields()">
                                    <option value="">Pilih Kategori</option>
                                    <option value="1">Ramadhan</option>
                                    <option value="2">Lomba</option>
                                    <option value="3">RWRT</option>
                                    <option value="4">Penyuluhan</option>
                                </select>
                            </div>

                            <div id="update-input-general" class="mb-3" style="display: none;">
                                <label for="update_tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="update_tanggal" class="form-control">

                                <label for="update_tempat" class="form-label">Tempat</label>
                                <input type="text" name="tempat" id="update_tempat" class="form-control">
                                <div class="box-update-kegiatan">
                                    <label for="update_kegiatan" class="form-label">Kegiatan</label>
                                    <input type="text" name="kegiatan" id="update_kegiatan" class="form-control">
                                </div>
                            </div>

                            <div id="update-input-lomba" class="kategori-update-input" style="display: none;">
                                <label for="update_nama_lomba" class="form-label">Nama Lomba</label>
                                <input type="text" name="nama_lomba" id="update_nama_lomba" class="form-control">
                            </div>

                            <div id="update-input-rwrt" class="kategori-update-input" style="display: none;">
                                <label for="update_rw_rt" class="form-label">RW/RT</label>
                                <input type="text" name="rw_rt" id="update_rw_rt" class="form-control">
                                <label for="update_nama_calon" class="form-label">Nama Calon</label>
                                <input type="text" name="nama_calon" id="update_nama_calon" class="form-control">
                            </div>

                            <div id="update-input-penyuluhan" class="kategori-update-input" style="display: none;">
                                <label for="update_topik" class="form-label">Topik</label>
                                <input type="text" name="topik" id="update_topik" class="form-control">
                            </div>

                            <div class="mb-3">
                                <img src="" alt="foto" id="update_foto_preview" style="max-width: 400px; height: 200px;">
                                <br>
                                <label for="update_foto" class="form-label">Upload Foto (Opsional)</label>
                                <input type="file" name="foto" id="update_foto" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap JS and Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>



        <script>
            function toggleInputFields() {
                const kategori = document.getElementById('kategori_id').value;
                document.querySelectorAll('.kategori-input').forEach(el => el.style.display = 'none');

                const kegiatanInput = document.getElementById('input-general');
                const kegiatan = document.querySelector('.box-kegiatan')
                if (kategori == 1) { // Ramadhan
                    kegiatanInput.style.display = 'block';
                    kegiatan.style.display = 'block';
                }

                if (kategori == 2) {
                    document.getElementById('input-lomba').style.display = 'block';
                    kegiatan.style.display = 'none'
                    kegiatanInput.style.display = 'block';
                } else if (kategori == 3) {
                    document.getElementById('input-rwrt').style.display = 'block';
                    kegiatanInput.style.display = 'none';
                } else if (kategori == 4) {
                    document.getElementById('input-penyuluhan').style.display = 'block';
                    kegiatan.style.display = 'none'
                    kegiatanInput.style.display = 'block';
                }
            }




            // Menyesuaikan input yang tampil berdasarkan kategori
            function toggleUpdateInputFields(kegiatan = null) {
                var kategoriId = kegiatan ? kegiatan.kategori_id : document.getElementById('update_kategori_id').value;

                // Menyembunyikan semua input kategori
                document.querySelectorAll('.kategori-update-input').forEach(input => {
                    input.style.display = 'none';
                });

                // Menampilkan input berdasarkan kategori yang dipilih
                if (kategoriId == 1) {
                    document.getElementById('update-input-general').style.display = 'block';
                } else if (kategoriId == 2) {
                    document.getElementById('update-input-lomba').style.display = 'block';
                    document.querySelector('.box-update-kegiatan').style.display = 'none';
                    document.getElementById('update-input-general').style.display = 'block';
                } else if (kategoriId == 3) {
                    document.getElementById('update-input-rwrt').style.display = 'block';
                    document.getElementById('update-input-general').style.display = 'none';
                } else if (kategoriId == 4) {
                    document.getElementById('update-input-penyuluhan').style.display = 'block';
                    document.querySelector('.box-update-kegiatan').style.display = 'none';
                    document.getElementById('update-input-general').style.display = 'block';
                }
            }


            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function() {
                    var kegiatan = JSON.parse(button.getAttribute('data-kegiatan'));

                    console.log(kegiatan); // Debugging: Lihat data kegiatan yang diterima

                    // Menampilkan kategori berdasarkan data yang diterima
                    document.getElementById('update_kategori_id').value = kegiatan.kategori_id || kegiatan.kegiatan_id; // Jika kategori_id ada, pakai itu, jika tidak gunakan kegiatan_id

                    // Menyesuaikan input yang tampil di modal berdasarkan kategori
                    toggleUpdateInputFields(kegiatan);

                    // Isi data form dengan nilai dari kegiatan
                    if (kegiatan.kategori_id == 1) { // Ramadhan
                        document.getElementById('update_id').value = kegiatan.id; // ID Ramadhan
                        document.getElementById('update_kegiatan').value = kegiatan.kegiatan;
                        document.getElementById('update_tanggal').value = kegiatan.tanggal;
                        document.getElementById('update_tempat').value = kegiatan.tempat;
                        document.getElementById('update_foto_preview').src = kegiatan.foto;
                    } else { // Untuk Lomba, RWRT, Penyuluhan menggunakan kegiatan_id
                        document.getElementById('update_id').value = kegiatan.kegiatan_id;
                        if (kegiatan.kategori_id == 2) { // Lomba
                            document.getElementById('update_nama_lomba').value = kegiatan.nama_lomba;
                            document.getElementById('update_tanggal').value = kegiatan.tanggal;
                            document.getElementById('update_tempat').value = kegiatan.tempat;
                            document.getElementById('update_foto_preview').src = kegiatan.foto;
                        } else if (kegiatan.kategori_id == 3) { // RWRT
                            document.getElementById('update_rw_rt').value = kegiatan.rw_rt;
                            document.getElementById('update_nama_calon').value = kegiatan.nama_calon;
                            document.getElementById('update_foto_preview').src = kegiatan.foto;
                        } else if (kegiatan.kategori_id == 4) { // Penyuluhan
                            document.getElementById('update_topik').value = kegiatan.topik;
                            document.getElementById('update_tanggal').value = kegiatan.tanggal;
                            document.getElementById('update_tempat').value = kegiatan.tempat;
                            document.getElementById('update_foto_preview').src = kegiatan.foto;

                        }
                    }

                    // Menampilkan modal
                    new bootstrap.Modal(document.getElementById('modalUpdate')).show();
                });
            });



            document.querySelectorAll('.btn-delete').forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');

                    // Set the ID to the delete form
                    document.getElementById('delete_id').value = id;

                    // Show the delete confirmation modal
                    new bootstrap.Modal(document.getElementById('modalDelete')).show();
                });
            });
        </script>


    </body>

    </html>


</body>

</html>