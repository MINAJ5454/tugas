<?php
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
    $conn->close();
}

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

        <!-- Link Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo5eJ3UVFLceScMO6VYjFtelqILg4mCJFDdErqh1T1BY4Wr" crossorigin="anonymous"></script>
        <script>
            function toggleInputFields() {
                const kategori = document.getElementById('kategori_id').value;
                // Menyembunyikan semua input kategori terkait
                document.querySelectorAll('.kategori-input').forEach(el => el.style.display = 'none');

                // Menyembunyikan input kegiatan jika kategori bukan Ramadhan
                const kegiatanInput = document.getElementById('input-general');
                const kegiatan = document.querySelector('.box-kegiatan')
                if (kategori == 1) { // Ramadhan
                    kegiatanInput.style.display = 'block';
                    kegiatan.style.display = 'block'; // Menampilkan input kegiatan untuk Ramadhan
                }

                // Menangani input kategori lainnya
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
        </script>


    </body>

    </html>


</body>

</html>