-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2024 at 04:17 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
  `ID` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `surat_pengajuan`
--

CREATE TABLE `surat_pengajuan` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` int NOT NULL,
  `jenis_pengajuan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

--
-- Dumping data for table `surat_pengajuan`
--

INSERT INTO `surat_pengajuan` (`id`, `nama`, `alamat`, `no_hp`, `jenis_pengajuan`) VALUES
(2, 'Chandra', 'Sragen', 822222, 'KK Baru'),
(4, 'Chandra', 'Sragen', 822222, 'Bantuan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_login`
--
ALTER TABLE `data_login`
  ADD PRIMARY KEY (`ID`);

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
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `surat_pengajuan`
--
ALTER TABLE `surat_pengajuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
