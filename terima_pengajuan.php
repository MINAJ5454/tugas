<?php
session_start();
include_once "db_connection.php"; // Pastikan ini berfungsi

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php"); // Redirect ke halaman login jika bukan admin
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Logika untuk memperbarui status pengajuan di database
    $query = "UPDATE pengajuan SET status = 'diterima' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Pengajuan berhasil diterima.";
    } else {
        echo "Gagal menerima pengajuan.";
    }
} else {
    echo "ID pengajuan tidak ditemukan.";
}
?>