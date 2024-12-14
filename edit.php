<?php 
include_once('db_connection.php');
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM surat_pengajuan WHERE id = '$id'");

if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $noHp = $_POST['no_hp'];
    $pengajuan = $_POST['jenis_pengajuan'];

    $result = mysqli_query($conn, "UPDATE surat_pengajuan SET nama = '$name', alamat = '$alamat', no_hp = '$noHp', jenis_pengajuan = '$pengajuan' WHERE id = $id");
    if($result){
        header('Location: data/view_data_warga.php');
    } else {
        echo "Gagal mengedit data";
    }
}
?>