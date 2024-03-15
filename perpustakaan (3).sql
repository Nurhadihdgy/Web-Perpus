-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2024 at 12:02 AM
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
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_admin`
--

CREATE TABLE `t_admin` (
  `f_id` int(11) NOT NULL,
  `f_nama` varchar(100) NOT NULL,
  `f_username` varchar(100) NOT NULL,
  `f_password` varchar(100) NOT NULL,
  `f_level` enum('Admin','Pustakawan') NOT NULL,
  `f_status` enum('Aktif','Tidak Aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_admin`
--

INSERT INTO `t_admin` (`f_id`, `f_nama`, `f_username`, `f_password`, `f_level`, `f_status`) VALUES
(1, 'Nurhadi', 'hadi', '202cb962ac59075b964b07152d234b70', 'Admin', 'Aktif'),
(2, 'Naufal Hugo', 'Naufal', '202cb962ac59075b964b07152d234b70', 'Pustakawan', 'Aktif'),
(11, 'Zidan Permata Ramadan', 'zidanlucky', '202cb962ac59075b964b07152d234b70', 'Pustakawan', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `t_anggota`
--

CREATE TABLE `t_anggota` (
  `f_id` int(11) NOT NULL,
  `f_nama` varchar(100) NOT NULL,
  `f_username` varchar(100) NOT NULL,
  `f_password` varchar(100) NOT NULL,
  `f_tempatlahir` varchar(100) NOT NULL,
  `f_tanggallahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_anggota`
--

INSERT INTO `t_anggota` (`f_id`, `f_nama`, `f_username`, `f_password`, `f_tempatlahir`, `f_tanggallahir`) VALUES
(7, 'Andi Saputro', 'Andii', '289dff07669d7a23de0ef88d2f7129e7', 'Jakarta', '2004-07-21'),
(8, 'Faisal Ridwan', 'Faisal', 'dcb76da384ae3028d6aa9b2ebcea01c9', 'Jakarta', '2006-01-11'),
(9, 'Zidan Permata Ramadan', 'Zidan', '202cb962ac59075b964b07152d234b70', 'Jakarta', '2006-10-16'),
(10, 'Hadi', 'Hadi', '289dff07669d7a23de0ef88d2f7129e7', 'Jakarta', '1985-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `t_buku`
--

CREATE TABLE `t_buku` (
  `f_id` int(11) NOT NULL,
  `f_idkategori` int(11) NOT NULL,
  `f_judul` varchar(100) NOT NULL,
  `f_gambar` varchar(100) DEFAULT NULL,
  `f_pengarang` varchar(100) NOT NULL,
  `f_penerbit` varchar(100) NOT NULL,
  `f_deskripsi` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_buku`
--

INSERT INTO `t_buku` (`f_id`, `f_idkategori`, `f_judul`, `f_gambar`, `f_pengarang`, `f_penerbit`, `f_deskripsi`) VALUES
(16, 8, 'Si Juki', 'juki.jpg', 'Juki', 'CV. MediaStar', 'SI Juki Buku Novel Cerita'),
(17, 9, 'Pemrograman Web', '1139911.jpg', 'Yono haryono', 'StarMedia', 'Belajar Pemrograman Web secara lengkap'),
(18, 10, 'Biografi resmi Pierre Andries Tendean', '1191021.jpg', 'Abie Besman ', 'StarMedia 2019', 'Sosok Pierre Andries Tendean kerap disebut setiap harinya ; '),
(19, 9, 'Javascript', '5.jpg', 'Hadi', 'Hadi', 'Buku Coding'),
(21, 16, 'Sejarah Negeri Sakura', '4.jpg', 'Isal', 'Isal', 'Keren');

-- --------------------------------------------------------

--
-- Table structure for table `t_detailbuku`
--

CREATE TABLE `t_detailbuku` (
  `f_id` int(11) NOT NULL,
  `f_idbuku` int(11) NOT NULL,
  `f_status` enum('Tersedia','Tidak Tersedia') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_detailbuku`
--

INSERT INTO `t_detailbuku` (`f_id`, `f_idbuku`, `f_status`) VALUES
(24, 16, 'Tersedia'),
(25, 16, 'Tersedia'),
(26, 16, 'Tersedia'),
(27, 16, 'Tersedia'),
(28, 16, 'Tersedia'),
(29, 16, 'Tidak Tersedia'),
(30, 16, 'Tersedia'),
(31, 16, 'Tersedia'),
(35, 17, 'Tersedia'),
(36, 17, 'Tersedia'),
(37, 17, 'Tersedia'),
(38, 17, 'Tersedia'),
(39, 17, 'Tersedia'),
(40, 17, 'Tersedia'),
(41, 18, 'Tersedia'),
(42, 18, 'Tidak Tersedia'),
(43, 18, 'Tersedia'),
(44, 18, 'Tidak Tersedia'),
(45, 16, 'Tersedia'),
(46, 19, 'Tersedia'),
(47, 21, 'Tidak Tersedia'),
(48, 21, 'Tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `t_detailpeminjaman`
--

CREATE TABLE `t_detailpeminjaman` (
  `f_id` int(11) NOT NULL,
  `f_idpeminjaman` int(11) NOT NULL,
  `f_iddetailbuku` int(11) NOT NULL,
  `f_tanggalkembali` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_detailpeminjaman`
--

INSERT INTO `t_detailpeminjaman` (`f_id`, `f_idpeminjaman`, `f_iddetailbuku`, `f_tanggalkembali`) VALUES
(10, 10, 24, '2023-11-22'),
(11, 11, 27, '2023-11-22'),
(12, 12, 36, '2023-12-02'),
(13, 13, 44, '0000-00-00'),
(14, 14, 42, '0000-00-00'),
(15, 15, 29, '0000-00-00'),
(16, 16, 38, '2023-12-13'),
(17, 17, 37, '2024-02-17'),
(18, 18, 47, '0000-00-00'),
(19, 19, 36, '2024-02-17'),
(20, 20, 40, '2024-02-17'),
(21, 21, 37, '2024-02-17');

-- --------------------------------------------------------

--
-- Table structure for table `t_kategori`
--

CREATE TABLE `t_kategori` (
  `f_id` int(11) NOT NULL,
  `f_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_kategori`
--

INSERT INTO `t_kategori` (`f_id`, `f_kategori`) VALUES
(8, 'Novel'),
(9, 'Teknologi '),
(10, 'Sejarah'),
(12, 'Fiksi'),
(14, 'Legenda'),
(16, 'Non Fiksi');

-- --------------------------------------------------------

--
-- Table structure for table `t_peminjaman`
--

CREATE TABLE `t_peminjaman` (
  `f_id` int(11) NOT NULL,
  `f_idadmin` int(11) NOT NULL,
  `f_idanggota` int(11) NOT NULL,
  `f_tanggalpeminjaman` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_peminjaman`
--

INSERT INTO `t_peminjaman` (`f_id`, `f_idadmin`, `f_idanggota`, `f_tanggalpeminjaman`) VALUES
(10, 1, 7, '2023-11-22'),
(11, 1, 8, '2023-11-22'),
(12, 1, 8, '2023-11-21'),
(13, 2, 9, '2023-11-21'),
(14, 2, 8, '2023-11-22'),
(15, 1, 9, '2023-11-22'),
(16, 1, 8, '2023-12-13'),
(17, 2, 7, '2024-02-01'),
(18, 11, 7, '2024-02-01'),
(19, 1, 7, '2024-02-17'),
(20, 1, 8, '2024-02-17'),
(21, 1, 7, '2024-02-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `t_anggota`
--
ALTER TABLE `t_anggota`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `t_buku`
--
ALTER TABLE `t_buku`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idkategori` (`f_idkategori`);

--
-- Indexes for table `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idbuku` (`f_idbuku`);

--
-- Indexes for table `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idpeminjaman` (`f_idpeminjaman`,`f_iddetailbuku`),
  ADD KEY `f_iddetailbuku` (`f_iddetailbuku`);

--
-- Indexes for table `t_kategori`
--
ALTER TABLE `t_kategori`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idadmin` (`f_idadmin`,`f_idanggota`),
  ADD KEY `f_idanggota` (`f_idanggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_admin`
--
ALTER TABLE `t_admin`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `t_anggota`
--
ALTER TABLE `t_anggota`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `t_buku`
--
ALTER TABLE `t_buku`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `t_kategori`
--
ALTER TABLE `t_kategori`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_buku`
--
ALTER TABLE `t_buku`
  ADD CONSTRAINT `t_buku_ibfk_1` FOREIGN KEY (`f_idkategori`) REFERENCES `t_kategori` (`f_id`);

--
-- Constraints for table `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  ADD CONSTRAINT `t_detailbuku_ibfk_1` FOREIGN KEY (`f_idbuku`) REFERENCES `t_buku` (`f_id`);

--
-- Constraints for table `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  ADD CONSTRAINT `t_detailpeminjaman_ibfk_1` FOREIGN KEY (`f_iddetailbuku`) REFERENCES `t_detailbuku` (`f_id`),
  ADD CONSTRAINT `t_detailpeminjaman_ibfk_2` FOREIGN KEY (`f_idpeminjaman`) REFERENCES `t_peminjaman` (`f_id`);

--
-- Constraints for table `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  ADD CONSTRAINT `t_peminjaman_ibfk_1` FOREIGN KEY (`f_idanggota`) REFERENCES `t_anggota` (`f_id`),
  ADD CONSTRAINT `t_peminjaman_ibfk_2` FOREIGN KEY (`f_idadmin`) REFERENCES `t_admin` (`f_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
