<?php
session_start();
include_once('db_connection.php');
$id = $_GET['id'];

$result = mysqli_query($conn, "DELETE FROM surat_pengajuan WHERE id = $id");
if ($result) {
    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Data berhasil dihapus.';
    header('Location: data/view_data_warga.php');
    exit;
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Gagal menghapus data.';
    header('Location: data/view_data_warga.php');
    exit;
}
