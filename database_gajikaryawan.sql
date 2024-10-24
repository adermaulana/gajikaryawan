-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 11:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `database_gajikaryawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `gaji_detail`
--

CREATE TABLE `gaji_detail` (
  `id` int(11) NOT NULL,
  `id_penggajian` int(11) DEFAULT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `tipe` enum('tunjangan','potongan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `departemen` varchar(100) DEFAULT NULL,
  `gaji_pokok` decimal(15,2) NOT NULL,
  `status` enum('aktif','non-aktif') DEFAULT 'aktif',
  `tanggal_bergabung` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `username`, `password`, `jabatan`, `departemen`, `gaji_pokok`, `status`, `tanggal_bergabung`) VALUES
(5, 'yanikim', 'yanikim', '827ccb0eea8a706c4c34a16891f84e7b', 'Manager', 'Keuangan', 5000000.00, 'aktif', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_gaji`
--

CREATE TABLE `pengaturan_gaji` (
  `id` int(11) NOT NULL,
  `gaji_pokok` decimal(15,2) NOT NULL,
  `tunjangan` decimal(15,2) DEFAULT 0.00,
  `potongan` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penggajian`
--

CREATE TABLE `penggajian` (
  `id` int(11) NOT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `jabatan` varchar(255) NOT NULL,
  `bulan_gaji` varchar(255) NOT NULL,
  `gaji_pokok` decimal(10,0) NOT NULL,
  `total_gaji` decimal(10,0) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tanggal_pembayaran` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penggajian`
--

INSERT INTO `penggajian` (`id`, `id_karyawan`, `jabatan`, `bulan_gaji`, `gaji_pokok`, `total_gaji`, `status`, `tanggal_pembayaran`) VALUES
(3, 5, 'Manager', 'Desember', 5000000, 4500000, 'Sudah Dibayar', '2024-10-25'),
(4, 5, 'Manager', 'Oktober', 5000000, 4500000, 'Belum Dibayar', '2024-10-01');

-- --------------------------------------------------------

--
-- Table structure for table `slip_gaji`
--

CREATE TABLE `slip_gaji` (
  `id` int(11) NOT NULL,
  `id_penggajian` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `slip_pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gaji_detail`
--
ALTER TABLE `gaji_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penggajian` (`id_penggajian`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan_gaji`
--
ALTER TABLE `pengaturan_gaji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indexes for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penggajian` (`id_penggajian`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gaji_detail`
--
ALTER TABLE `gaji_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengaturan_gaji`
--
ALTER TABLE `pengaturan_gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gaji_detail`
--
ALTER TABLE `gaji_detail`
  ADD CONSTRAINT `gaji_detail_ibfk_1` FOREIGN KEY (`id_penggajian`) REFERENCES `penggajian` (`id`);

--
-- Constraints for table `penggajian`
--
ALTER TABLE `penggajian`
  ADD CONSTRAINT `penggajian_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id`);

--
-- Constraints for table `slip_gaji`
--
ALTER TABLE `slip_gaji`
  ADD CONSTRAINT `slip_gaji_ibfk_1` FOREIGN KEY (`id_penggajian`) REFERENCES `penggajian` (`id`),
  ADD CONSTRAINT `slip_gaji_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
