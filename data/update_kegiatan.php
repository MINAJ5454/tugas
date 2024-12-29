<?php
include('../db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // ID kegiatan utama
    $kategori_id = $_POST['kategori_id'];
    $tanggal = $_POST['tanggal'] ?? null;
    $tempat = $_POST['tempat'] ?? null;
    $kegiatan = $_POST['kegiatan'];
    $foto = null;

    // Proses upload foto baru jika ada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES['foto']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFilePath)) {
            $foto = $targetFilePath;
        } else {
            echo "Gagal meng-upload foto.";
        }
    }

    // Debug POST data
    var_dump($_POST);
    var_dump($_FILES);

    // Update data utama kegiatan
    $sql = "UPDATE kegiatan_desa SET kategori_id = ?, tanggal = ?, kegiatan = ?, tempat = ?" . ($foto ? ", foto = ?" : "") . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    if ($foto) {
        $stmt->bind_param('issssi', $kategori_id, $tanggal, $kegiatan, $tempat, $foto, $id);
    } else {
        $stmt->bind_param('isssi', $kategori_id, $tanggal, $kegiatan, $tempat, $id);
    }

    if ($stmt->execute()) {
        // Update detail berdasarkan kategori
        if ($kategori_id == 2) { // Lomba
            $nama_lomba = $_POST['nama_lomba'];
            $sqlLomba = "UPDATE lomba SET nama_lomba = ? WHERE kegiatan_id = ?";
            $stmtLomba = $conn->prepare($sqlLomba);
            $stmtLomba->bind_param('si', $nama_lomba, $id);
            $stmtLomba->execute();
        } elseif ($kategori_id == 3) { // RWRT
            $rw_rt = $_POST['rw_rt'];
            $nama_calon = $_POST['nama_calon'];
            $sqlRWRT = "UPDATE rw_rt SET rw_rt = ?, nama_calon = ? WHERE kegiatan_id = ?";
            $stmtRWRT = $conn->prepare($sqlRWRT);
            $stmtRWRT->bind_param('ssi', $rw_rt, $nama_calon, $id);
            $stmtRWRT->execute();
        } elseif ($kategori_id == 4) { // Penyuluhan
            $topik = $_POST['topik'];
            $sqlPenyuluhan = "UPDATE penyuluhan SET topik = ? WHERE kegiatan_id = ?";
            $stmtPenyuluhan = $conn->prepare($sqlPenyuluhan);
            $stmtPenyuluhan->bind_param('si', $topik, $id);
            $stmtPenyuluhan->execute();
        }

        // Redirect ke halaman view_data_kegiatan setelah sukses update
        header('Location: ../data/view_data_kegiatan.php');
        exit;
    } else {
        echo "Gagal memperbarui data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
