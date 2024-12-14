<?php 
session_start();
include_once('db_connection.php');
$id = $_GET['id'];

$result = mysqli_query($conn, "DELETE FROM surat_pengajuan WHERE id = $id");
header('location: data/view_data_warga.php')
?>