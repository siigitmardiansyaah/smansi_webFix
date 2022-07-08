-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2022 at 11:40 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smansi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbabsen`
--

CREATE TABLE `tbabsen` (
  `id_absen` int(80) NOT NULL,
  `id_jadwal` int(20) NOT NULL,
  `id_qr` int(80) NOT NULL,
  `id_siswa` int(20) NOT NULL,
  `waktu_absen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `keterangan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbabsen`
--

INSERT INTO `tbabsen` (`id_absen`, `id_jadwal`, `id_qr`, `id_siswa`, `waktu_absen`, `keterangan`) VALUES
(35, 5, 72, 1, '2022-07-08 07:30:08', 'Hadir');

-- --------------------------------------------------------

--
-- Table structure for table `tbguru`
--

CREATE TABLE `tbguru` (
  `nip` int(20) NOT NULL,
  `nama_guru` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbguru`
--

INSERT INTO `tbguru` (`nip`, `nama_guru`, `password`) VALUES
(6969, 'Sigit', '098f6bcd4621d373cade4e832627b4f6'),
(15120001, 'elga asfa', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120002, 'M tri anwarudin', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120003, 'leon prastya', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120004, 'indra lady', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120005, 'angel paramita', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120006, 'iqbal haqiqi', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120007, 'reza darmawan', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120008, 'hari purnomo', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120009, 'helmy ayu', 'b11d5ece6353d17f85c5ad30e0a02360'),
(15120010, 'indah andira', 'b11d5ece6353d17f85c5ad30e0a02360');

-- --------------------------------------------------------

--
-- Table structure for table `tbjadwal`
--

CREATE TABLE `tbjadwal` (
  `id_jadwal` int(20) NOT NULL,
  `id_mapel` int(20) NOT NULL,
  `id_kelas` int(20) NOT NULL,
  `nip` int(20) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbjadwal`
--

INSERT INTO `tbjadwal` (`id_jadwal`, `id_mapel`, `id_kelas`, `nip`, `waktu`) VALUES
(5, 1, 1, 6969, '2019-06-20 12:00:00'),
(7, 2, 2, 6969, '2019-06-29 09:30:00'),
(8, 6, 3, 15120003, '2019-06-22 02:00:00'),
(9, 11, 5, 15120006, '2019-06-22 09:00:00'),
(10, 13, 3, 15120005, '2019-06-22 04:00:00'),
(11, 5, 2, 15120002, '2019-06-22 02:00:00'),
(12, 4, 4, 15120004, '2019-06-22 10:00:00'),
(13, 9, 5, 15120007, '2019-06-22 04:00:00'),
(14, 7, 2, 15120004, '2019-06-22 05:00:00'),
(15, 1, 7, 15120001, '2019-06-22 03:00:00'),
(16, 4, 7, 15120001, '2019-06-19 00:00:00'),
(17, 12, 5, 15120002, '2019-06-26 00:00:00'),
(18, 14, 3, 15120003, '2019-06-28 00:00:00'),
(19, 10, 3, 15120003, '2019-06-28 00:00:00'),
(20, 13, 5, 15120004, '2019-06-12 00:00:00'),
(21, 4, 3, 15120003, '2019-06-27 00:00:00'),
(22, 2, 1, 15120008, '2019-06-19 12:00:00'),
(23, 3, 1, 15120009, '2019-06-30 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbjadwal_siswa`
--

CREATE TABLE `tbjadwal_siswa` (
  `id_jadwalsiswa` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbjadwal_siswa`
--

INSERT INTO `tbjadwal_siswa` (`id_jadwalsiswa`, `id_siswa`, `id_kelas`, `id_mapel`, `waktu`) VALUES
(1, 1, 1, 1, '2022-07-05 03:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `tbkelas`
--

CREATE TABLE `tbkelas` (
  `id_kelas` int(20) NOT NULL,
  `nama_kelas` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbkelas`
--

INSERT INTO `tbkelas` (`id_kelas`, `nama_kelas`) VALUES
(1, '3A'),
(2, '3B'),
(3, '1A'),
(4, '1B'),
(5, '1C'),
(6, '2A'),
(7, '2B');

-- --------------------------------------------------------

--
-- Table structure for table `tbmapel`
--

CREATE TABLE `tbmapel` (
  `id_mapel` int(20) NOT NULL,
  `nama_mapel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbmapel`
--

INSERT INTO `tbmapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Algoritma Pemrograman I'),
(2, 'Jaringan Komputer II'),
(3, 'B. indonesia'),
(4, 'B.inggris'),
(5, 'IPS'),
(6, 'IPA'),
(7, 'Agama'),
(8, 'B.jawa'),
(9, 'B.sunda'),
(10, 'WEB'),
(11, 'Database'),
(12, 'Sistem terdistribusi'),
(13, 'PKN'),
(14, 'Pancasila');

-- --------------------------------------------------------

--
-- Table structure for table `tbqr`
--

CREATE TABLE `tbqr` (
  `id_qr` int(80) NOT NULL,
  `nip` int(20) NOT NULL,
  `qr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbqr`
--

INSERT INTO `tbqr` (`id_qr`, `nip`, `qr`) VALUES
(71, 6969, '7-2-3B-6969-1650289011'),
(72, 6969, '5-1-3A-6969-1656946371'),
(73, 6969, '5-1-3A-6969-1656946474');

-- --------------------------------------------------------

--
-- Table structure for table `tbsiswa`
--

CREATE TABLE `tbsiswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` int(20) NOT NULL,
  `nama` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kelas` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbsiswa`
--

INSERT INTO `tbsiswa` (`id_siswa`, `nis`, `nama`, `password`, `device_id`, `id_kelas`) VALUES
(1, 1, 'hahaha', '098f6bcd4621d373cade4e832627b4f6', 'd9c84cb1d7681ebb', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbabsen`
--
ALTER TABLE `tbabsen`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `id_qr` (`id_qr`),
  ADD KEY `nim` (`id_siswa`);

--
-- Indexes for table `tbguru`
--
ALTER TABLE `tbguru`
  ADD PRIMARY KEY (`nip`);

--
-- Indexes for table `tbjadwal`
--
ALTER TABLE `tbjadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_matkul` (`id_mapel`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `tbjadwal_siswa`
--
ALTER TABLE `tbjadwal_siswa`
  ADD PRIMARY KEY (`id_jadwalsiswa`),
  ADD KEY `fk_siswa` (`id_siswa`),
  ADD KEY `fk_kelas` (`id_kelas`),
  ADD KEY `fk_mapel` (`id_mapel`);

--
-- Indexes for table `tbkelas`
--
ALTER TABLE `tbkelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tbmapel`
--
ALTER TABLE `tbmapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `tbqr`
--
ALTER TABLE `tbqr`
  ADD PRIMARY KEY (`id_qr`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `tbsiswa`
--
ALTER TABLE `tbsiswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `tbmahasiswa_ibfk_1` (`id_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbabsen`
--
ALTER TABLE `tbabsen`
  MODIFY `id_absen` int(80) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbjadwal`
--
ALTER TABLE `tbjadwal`
  MODIFY `id_jadwal` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbjadwal_siswa`
--
ALTER TABLE `tbjadwal_siswa`
  MODIFY `id_jadwalsiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbkelas`
--
ALTER TABLE `tbkelas`
  MODIFY `id_kelas` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbmapel`
--
ALTER TABLE `tbmapel`
  MODIFY `id_mapel` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbqr`
--
ALTER TABLE `tbqr`
  MODIFY `id_qr` int(80) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tbsiswa`
--
ALTER TABLE `tbsiswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbabsen`
--
ALTER TABLE `tbabsen`
  ADD CONSTRAINT `tbabsen_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `tbjadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbabsen_ibfk_2` FOREIGN KEY (`id_qr`) REFERENCES `tbqr` (`id_qr`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbabsen_ibfk_3` FOREIGN KEY (`id_siswa`) REFERENCES `tbsiswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbjadwal`
--
ALTER TABLE `tbjadwal`
  ADD CONSTRAINT `tbjadwal_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `tbmapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbjadwal_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tbkelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbjadwal_ibfk_3` FOREIGN KEY (`nip`) REFERENCES `tbguru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbjadwal_siswa`
--
ALTER TABLE `tbjadwal_siswa`
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tbkelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `tbmapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `tbsiswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbqr`
--
ALTER TABLE `tbqr`
  ADD CONSTRAINT `tbqr_ibfk_1` FOREIGN KEY (`nip`) REFERENCES `tbguru` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbsiswa`
--
ALTER TABLE `tbsiswa`
  ADD CONSTRAINT `tbsiswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tbkelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
