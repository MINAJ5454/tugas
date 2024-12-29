<?php
// Pastikan Anda sudah menghubungkan ke database
include('../db_connection.php');

if (isset($_GET['id']) && isset($_GET['kategori_id'])) {
    $kegiatan_id = (int)$_GET['id'];
    $kategori_id = (int)$_GET['kategori_id'];
    var_dump($kegiatan_id, $kategori_id);

    // Mulai transaksi
    $conn->begin_transaction();

    try {
        // Hapus data berdasarkan kategori
        if ($kategori_id == 2) { // Lomba
            $sqlLomba = "DELETE FROM lomba WHERE kegiatan_id = ?";
            $stmtLomba = $conn->prepare($sqlLomba);
            $stmtLomba->bind_param('i', $kegiatan_id);
            $stmtLomba->execute();
        } elseif ($kategori_id == 3) { // RWRT
            $sqlRWRT = "DELETE FROM rw_rt WHERE kegiatan_id = ?";
            $stmtRWRT = $conn->prepare($sqlRWRT);
            $stmtRWRT->bind_param('i', $kegiatan_id);
            $stmtRWRT->execute();
        } elseif ($kategori_id == 4) { // Penyuluhan
            $sqlPenyuluhan = "DELETE FROM penyuluhan WHERE kegiatan_id = ?";
            $stmtPenyuluhan = $conn->prepare($sqlPenyuluhan);
            $stmtPenyuluhan->bind_param('i', $kegiatan_id);
            $stmtPenyuluhan->execute();
        }

        // Hapus data utama dari tabel kegiatan_desa
        $sqlKegiatan = "DELETE FROM kegiatan_desa WHERE id = ?";
        $stmtKegiatan = $conn->prepare($sqlKegiatan);
        $stmtKegiatan->bind_param('i', $kegiatan_id);
        $stmtKegiatan->execute();

        // Commit transaksi
        $conn->commit();

        // Redirect ke halaman yang menampilkan data setelah penghapusan
        header("Location: ../data/view_data_kegiatan.php?category=$kategori_id");
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika ada error
        $conn->rollback();
        echo "<div class='alert alert-danger' role='alert'>Gagal menghapus data: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>ID dan kategori tidak ditemukan!</div>";
}
