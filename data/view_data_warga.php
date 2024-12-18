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

// Pagination settings
$limit = 5; // Jumlah data per halaman
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
$offset = ($page - 1) * $limit; // Menentukan offset

// Query data dengan pagination
$query = "SELECT * FROM surat_pengajuan LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

// Menghitung jumlah total data
$totalQuery = "SELECT COUNT(*) AS total FROM surat_pengajuan";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalData = $totalRow['total'];
$totalPages = ceil($totalData / $limit); // Menghitung total halaman
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Data Warga</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
        <div class="alert alert-success" role="alert">
            <strong>Selamat Datang!</strong> <?php echo $_SESSION['username']; ?>
        </div>
        <?php
        if (isset($_SESSION['status']) && isset($_SESSION['message'])) {
            $status = $_SESSION['status'];
            $message = $_SESSION['message'];

            echo "<div class='alert alert-" . ($status == 'success' ? 'success' : 'danger') . "'>$message</div>";

            // Hapus session setelah ditampilkan
            unset($_SESSION['status']);
            unset($_SESSION['message']);
        }
        ?>
        <h3 class="text-center mb-4">Lihat Data Warga</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Jenis Pengajuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1 + $offset;
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= htmlspecialchars($row['alamat']); ?></td>
                                <td><?= htmlspecialchars($row['no_hp']); ?></td>
                                <td><?= htmlspecialchars($row['jenis_pengajuan']); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">Edit</button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id']; ?>">Delete</button>
                                </td>
                            </tr>
                            <!-- Modal Konfirmasi Hapus -->
                            <div class="modal fade" id="deleteModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus data nama : <strong><?= $row['nama']; ?></strong> </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <a href="../delete.php?id=<?= $row['id']; ?>" id="confirmDeleteButton" class="btn btn-danger">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $row['id']; ?>">Edit Data</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="../edit.php" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="nama<?= $row['id']; ?>" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="nama<?= $row['id']; ?>" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat<?= $row['id']; ?>" class="form-label">Alamat</label>
                                                    <textarea class="form-control" id="alamat<?= $row['id']; ?>" name="alamat" rows="3" required><?= htmlspecialchars($row['alamat']); ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="no_hp<?= $row['id']; ?>" class="form-label">Telepon</label>
                                                    <input type="text" class="form-control" id="no_hp<?= $row['id']; ?>" name="no_hp" value="<?= htmlspecialchars($row['no_hp']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis_pengajuan<?= $row['id']; ?>" class="form-label">Jenis Pengajuan</label>
                                                    <input type="text" class="form-control" id="jenis_pengajuan<?= $row['id']; ?>" name="jenis_pengajuan" value="<?= htmlspecialchars($row['jenis_pengajuan']); ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!-- Previous Button -->
                <li class="page-item <?= ($page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php } ?>

                <!-- Next Button -->
                <li class="page-item <?= ($page == $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>