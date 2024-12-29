<?php
include('../db_connection.php');

if (!isset($_GET['id'])) {
    echo "ID kegiatan tidak ditemukan.";
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT 
            k.*, 
            r.rw_rt, 
            r.nama_calon, 
            kategory.nama_kategori
        FROM kegiatan_desa k 
        LEFT JOIN rw_rt r ON k.id = r.kegiatan_id
        LEFT JOIN kategori_kegiatan kategory ON k.kategori_id = kategory.id
        WHERE k.id = ? AND k.kategori_id = 3";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Detail kegiatan tidak ditemukan.";
    exit();
}

$activity = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pergantian RW/RT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3><?= htmlspecialchars($activity['nama_kategori']) ?></h3>
            </div>
            <div class="card-body">
                <p><strong>Nama Calon:</strong> <?= htmlspecialchars($activity['nama_calon']) ?></p>
                <p><strong>RW/RT:</strong> <?= nl2br(htmlspecialchars($activity['rw_rt'])) ?></p>
                <a href="information.php" class="btn btn-secondary my-3">Kembali</a>
                <?php if (!empty($activity['foto'])): ?>
                    <img src="../data/<?= htmlspecialchars($activity['foto']) ?>" class="img-fluid border w-100" alt="Foto RW/RT">
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>