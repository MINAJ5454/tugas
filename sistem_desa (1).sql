-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2024 at 04:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_desa`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_login`
--

CREATE TABLE `data_login` (
  `ID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_login`
--

INSERT INTO `data_login` (`ID`, `username`, `password`, `email`, `role`) VALUES
(1, 'susilo123', '12345', 'susilo77@gmail.com', 'warga'),
(2, 'eko123', '12345', 'eko77@gmail.com', 'admin'),
(3, 'rangga69', '$2y$10$JqZ1X9FNmhB1kd0KpxTnk.K80Py0n2SqsrH.5PRy/1O1nMUauugUC', 'rangga69@gmail.com', 'warga'),
(4, 'rangga69', '$2y$10$uemU1Xml8G59pf1PQB8UxerBRiF.lw1zWoIaX0Wo0MMcxWAJGaZdu', 'rangga69@gmail.com', 'warga'),
(5, 'rangga69', '$2y$10$x6z2ZNyCHn8c4eyvgepXR.ZR6bHqtzKCbtIF5Y2FKDLxYg7VO/qoW', 'rangga69@gmail.com', 'warga'),
(6, 'rangga69', '$2y$10$1xX1PZj1LjwghViuEYM.kOiQE.K/30ED0fuZcF9dRHKhGQ9TH7M1m', 'rangga69@gmail.com', 'warga'),
(7, 'rangga69', '$2y$10$993Ol02TjQ3VfAb8NVc5Out.8t0xU048fHQpwJAJB6Rw9Z.Xx1LUy', 'rangga69@gmail.com', 'warga'),
(8, 'rangga69', '$2y$10$pA/vR8khzg6qVtjSlCkSX.Hlu12iFwf6vUvH.DNtk0tTrrI4R/EGy', 'rangga69@gmail.com', 'warga'),
(9, 'najmi44', '$2y$10$fUXyI36WWHp5/ra9jUPEWusg1OdiDVfnuJoFV.C2ypAZ/kDYNyFkS', 'najmi22@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_kegiatan`
--

CREATE TABLE `kategori_kegiatan` (
  `id` int(11) NOT NULL,
  `nama_kategori` enum('Ramadhan','Lomba','RWRT','Penyuluhan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_kegiatan`
--

INSERT INTO `kategori_kegiatan` (`id`, `nama_kategori`) VALUES
(1, 'Ramadhan'),
(2, 'Lomba'),
(3, 'RWRT'),
(4, 'Penyuluhan');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_desa`
--

CREATE TABLE `kegiatan_desa` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kegiatan` varchar(255) DEFAULT NULL,
  `tempat` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan_desa`
--

INSERT INTO `kegiatan_desa` (`id`, `kategori_id`, `tanggal`, `kegiatan`, `tempat`, `foto`) VALUES
(17, 2, '2024-12-27', '', 'lapangan voli rt 4', 'uploads/Screenshot_17-12-2024_171119_localhost.jpeg'),
(18, 2, '2024-12-28', '', 'lapangan trihanggo', 'uploads/Screenshot_17-12-2024_171119_localhost.jpeg'),
(23, 4, '2024-12-27', '', 'balai desa jombor timur', 'uploads/carbon (16).png'),
(25, 2, '2024-12-29', '', 'lapangan dalangan', 'uploads/carbon (17).png'),
(27, 3, '0000-00-00', '', '', 'uploads/322477cf417feed0731e0f4af75aecb5-removebg-preview.png'),
(28, 3, '0000-00-00', '', '', 'uploads/322477cf417feed0731e0f4af75aecb5-removebg-preview.png'),
(29, 3, '0000-00-00', '', '', 'uploads/322477cf417feed0731e0f4af75aecb5-removebg-preview.png'),
(33, 1, '2024-12-30', 'kitab', 'masjid nurul huda', 'uploads/322477cf417feed0731e0f4af75aecb5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lomba`
--

CREATE TABLE `lomba` (
  `id` int(11) NOT NULL,
  `kegiatan_id` int(11) NOT NULL,
  `nama_lomba` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lomba`
--

INSERT INTO `lomba` (`id`, `kegiatan_id`, `nama_lomba`) VALUES
(6, 17, 'voli antar rt'),
(7, 18, 'panjang pinang'),
(8, 25, 'panjat pinang');

-- --------------------------------------------------------

--
-- Table structure for table `penyuluhan`
--

CREATE TABLE `penyuluhan` (
  `id` int(11) NOT NULL,
  `kegiatan_id` int(11) NOT NULL,
  `topik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyuluhan`
--

INSERT INTO `penyuluhan` (`id`, `kegiatan_id`, `topik`) VALUES
(4, 23, 'donor darah a');

-- --------------------------------------------------------

--
-- Table structure for table `rw_rt`
--

CREATE TABLE `rw_rt` (
  `id` int(11) NOT NULL,
  `kegiatan_id` int(11) NOT NULL,
  `rw_rt` varchar(20) NOT NULL,
  `nama_calon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rw_rt`
--

INSERT INTO `rw_rt` (`id`, `kegiatan_id`, `rw_rt`, `nama_calon`) VALUES
(9, 27, '12/32', 'joko laksmono'),
(10, 28, '12/32', 'joko laksmono'),
(11, 29, '12/32', 'joko laksmono');

-- --------------------------------------------------------

--
-- Table structure for table `surat_pengajuan`
--

CREATE TABLE `surat_pengajuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` int(11) NOT NULL,
  `jenis_pengajuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_pengajuan`
--

INSERT INTO `surat_pengajuan` (`id`, `nama`, `alamat`, `no_hp`, `jenis_pengajuan`) VALUES
(2, 'Chandra hosting gacor', 'Sragen kota', 822222, 'KK Baru'),
(5, 'Arianto S', 'Jl. Merdeka No. 12, Jakarta', 2147483647, 'Pengajuan KTP'),
(6, 'Budi Hartono', 'Jl. Raya No. 45, Bandung', 2147483647, 'Pengajuan KK'),
(7, 'Cynthia Lestari', 'Jl. Sudirman No. 10, Surabaya', 2147483647, 'Pengajuan Akta Kelahiran'),
(9, 'Eka Putri', 'Jl. Pahlawan No. 32, Yogyakarta', 2147483647, 'Pengajuan SKCK'),
(10, 'Fajar Setiawan', 'Jl. Angkasa No. 89, Makassar', 2147483647, 'Pengajuan Izin Usaha'),
(11, 'Gita Amelia', 'Jl. Cendrawasih No. 14, Bali', 2147483647, 'Pengajuan Surat Keterangan Penghasilan'),
(13, 'Intan Permatasari', 'Jl. Rajawali No. 56, Malang', 2147483647, 'Pengajuan Surat Keterangan Kerja'),
(14, 'Joko Santoso', 'Jl. Karya No. 66, Semarang', 2147483647, 'Pengajuan Izin Mendirikan Bangunan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_login`
--
ALTER TABLE `data_login`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `kategori_kegiatan`
--
ALTER TABLE `kategori_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan_desa`
--
ALTER TABLE `kegiatan_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `lomba`
--
ALTER TABLE `lomba`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_id` (`kegiatan_id`);

--
-- Indexes for table `penyuluhan`
--
ALTER TABLE `penyuluhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_id` (`kegiatan_id`);

--
-- Indexes for table `rw_rt`
--
ALTER TABLE `rw_rt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_id` (`kegiatan_id`);

--
-- Indexes for table `surat_pengajuan`
--
ALTER TABLE `surat_pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_login`
--
ALTER TABLE `data_login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori_kegiatan`
--
ALTER TABLE `kategori_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kegiatan_desa`
--
ALTER TABLE `kegiatan_desa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `lomba`
--
ALTER TABLE `lomba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penyuluhan`
--
ALTER TABLE `penyuluhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rw_rt`
--
ALTER TABLE `rw_rt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `surat_pengajuan`
--
ALTER TABLE `surat_pengajuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kegiatan_desa`
--
ALTER TABLE `kegiatan_desa`
  ADD CONSTRAINT `kegiatan_desa_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_kegiatan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lomba`
--
ALTER TABLE `lomba`
  ADD CONSTRAINT `lomba_ibfk_1` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan_desa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penyuluhan`
--
ALTER TABLE `penyuluhan`
  ADD CONSTRAINT `penyuluhan_ibfk_1` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan_desa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rw_rt`
--
ALTER TABLE `rw_rt`
  ADD CONSTRAINT `rw_rt_ibfk_1` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan_desa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
