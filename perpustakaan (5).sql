-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Feb 2024 pada 02.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `t_admin`
--

CREATE TABLE `t_admin` (
  `f_id` int(11) NOT NULL,
  `f_nama` varchar(100) NOT NULL,
  `f_username` varchar(100) NOT NULL,
  `f_password` varchar(100) NOT NULL,
  `f_level` enum('Admin','Pustakawan') NOT NULL,
  `f_status` enum('Aktif','Tidak Aktif') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_admin`
--

INSERT INTO `t_admin` (`f_id`, `f_nama`, `f_username`, `f_password`, `f_level`, `f_status`, `created_at`, `updated_at`) VALUES
(1, 'Nurhadi', 'hadi', '202cb962ac59075b964b07152d234b70', 'Admin', 'Aktif', '2024-02-22 15:31:51', '2024-02-22 15:31:51'),
(2, 'Naufal Hugo', 'Naufal', '202cb962ac59075b964b07152d234b70', 'Pustakawan', 'Aktif', '2024-02-22 15:31:51', '2024-02-22 15:31:51'),
(11, 'Zidan Permata Ramadan', 'zidan', '202cb962ac59075b964b07152d234b70', 'Pustakawan', 'Tidak Aktif', '2024-02-22 15:31:51', '2024-02-22 15:31:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_anggota`
--

CREATE TABLE `t_anggota` (
  `f_id` int(11) NOT NULL,
  `f_nama` varchar(100) NOT NULL,
  `f_username` varchar(100) NOT NULL,
  `f_password` varchar(100) NOT NULL,
  `f_tempatlahir` varchar(100) NOT NULL,
  `f_tanggallahir` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_anggota`
--

INSERT INTO `t_anggota` (`f_id`, `f_nama`, `f_username`, `f_password`, `f_tempatlahir`, `f_tanggallahir`, `created_at`, `updated_at`) VALUES
(8, 'Faisal Ridwan', 'Faisal', 'dcb76da384ae3028d6aa9b2ebcea01c9', 'Jakarta', '2006-01-11', '2024-02-22 15:40:35', '2024-02-22 15:40:35'),
(13, 'Tri Nur', 'triii', '202cb962ac59075b964b07152d234b70', 'Jakarta', '2005-02-09', '2024-02-23 07:26:43', '2024-02-23 09:54:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_buku`
--

CREATE TABLE `t_buku` (
  `f_id` int(11) NOT NULL,
  `f_idkategori` int(11) NOT NULL,
  `f_judul` varchar(100) NOT NULL,
  `f_gambar` varchar(100) DEFAULT NULL,
  `f_pengarang` varchar(100) NOT NULL,
  `f_penerbit` varchar(100) NOT NULL,
  `f_deskripsi` varchar(512) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_buku`
--

INSERT INTO `t_buku` (`f_id`, `f_idkategori`, `f_judul`, `f_gambar`, `f_pengarang`, `f_penerbit`, `f_deskripsi`, `created_at`, `updated_at`) VALUES
(16, 8, 'Si Juki', 'juki.jpg', 'Juki', 'CV. MediaStar Jaya Hahha', 'SI Juki Buku Novel Cerita', '2024-02-22 14:33:54', '2024-02-23 13:52:21'),
(17, 9, 'Pemrograman Web', '1139911.jpg', 'Yono haryono', 'StarMedia', 'Belajar Pemrograman Web secara lengkap', '2024-02-22 14:33:54', '2024-02-22 14:33:54'),
(18, 10, 'Biografi resmi Pierre Andries Tendean', '1191021.jpg', 'Abie Besman ', 'StarMedia 2019', 'Sosok Pierre Andries Tendean kerap disebut setiap harinya ; ', '2024-02-22 14:33:54', '2024-02-22 14:33:54'),
(25, 9, 'JSjajs', '1.jpg', 'hahsjajs', 'kszkdkskd', 'mzmdzcm', '2024-02-22 14:33:54', '2024-02-23 07:17:10'),
(29, 8, '10 Dosa Besar Soharto', 'j.jpg', 'jjsajsj', 'mszmd', 'ratsta', '2024-02-22 14:46:40', '2024-02-22 14:53:14'),
(30, 14, 'Sejarah Timun Mas', '2.jpg', 'Joko Darmono', 'Starmedia', 'hahhahsd', '2024-02-23 07:52:18', '2024-02-23 07:52:18'),
(31, 10, 'Gus dur', '2.jpg', 'Andi Putrot', 'Bintan Jaya', 'Keren', '2024-02-23 07:54:49', '2024-02-23 07:54:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_detailbuku`
--

CREATE TABLE `t_detailbuku` (
  `f_id` int(11) NOT NULL,
  `f_idbuku` int(11) NOT NULL,
  `f_status` enum('Tersedia','Tidak Tersedia') DEFAULT NULL,
  `created_at` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_detailbuku`
--

INSERT INTO `t_detailbuku` (`f_id`, `f_idbuku`, `f_status`, `created_at`) VALUES
(24, 16, 'Tersedia', '2024-02-22'),
(25, 16, 'Tersedia', '2024-02-22'),
(26, 16, 'Tersedia', '2024-02-22'),
(27, 16, 'Tersedia', '2024-02-22'),
(28, 16, 'Tersedia', '2024-02-22'),
(29, 16, 'Tersedia', '2024-02-22'),
(30, 16, 'Tersedia', '2024-02-22'),
(31, 16, 'Tersedia', '2024-02-22'),
(35, 17, 'Tersedia', '2024-02-22'),
(36, 17, 'Tersedia', '2024-02-22'),
(37, 17, 'Tersedia', '2024-02-22'),
(38, 17, 'Tersedia', '2024-02-22'),
(39, 17, 'Tersedia', '2024-02-22'),
(40, 17, 'Tidak Tersedia', '2024-02-22'),
(41, 18, 'Tersedia', '2024-02-22'),
(42, 18, 'Tersedia', '2024-02-22'),
(43, 18, 'Tersedia', '2024-02-22'),
(44, 18, 'Tersedia', '2024-02-22'),
(45, 16, 'Tersedia', '2024-02-22'),
(55, 25, 'Tersedia', '2024-02-22'),
(56, 25, 'Tersedia', '2024-02-22'),
(61, 16, 'Tersedia', '2024-02-21'),
(62, 16, 'Tersedia', '2024-02-22'),
(63, 16, 'Tidak Tersedia', '2024-02-22'),
(65, 16, 'Tersedia', '2024-02-22'),
(66, 29, 'Tersedia', '2024-02-22'),
(67, 29, 'Tersedia', '2024-02-22'),
(68, 25, 'Tersedia', '2024-02-23'),
(69, 25, 'Tersedia', '2024-02-23'),
(70, 25, 'Tersedia', '2024-02-23'),
(71, 16, 'Tersedia', '2024-02-23'),
(72, 30, 'Tersedia', '2024-02-23'),
(73, 31, 'Tersedia', '2024-02-23'),
(74, 16, 'Tersedia', '2024-02-23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_detailpeminjaman`
--

CREATE TABLE `t_detailpeminjaman` (
  `f_id` int(11) NOT NULL,
  `f_idpeminjaman` int(11) NOT NULL,
  `f_iddetailbuku` int(11) NOT NULL,
  `f_tanggalkembali` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_detailpeminjaman`
--

INSERT INTO `t_detailpeminjaman` (`f_id`, `f_idpeminjaman`, `f_iddetailbuku`, `f_tanggalkembali`) VALUES
(23, 25, 65, '2024-02-23'),
(24, 26, 38, '2024-02-23'),
(25, 27, 37, '0000-00-00'),
(26, 28, 41, '0000-00-00'),
(27, 29, 66, '2024-02-23'),
(28, 30, 40, '0000-00-00'),
(29, 31, 63, '0000-00-00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_kategori`
--

CREATE TABLE `t_kategori` (
  `f_id` int(11) NOT NULL,
  `f_kategori` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_kategori`
--

INSERT INTO `t_kategori` (`f_id`, `f_kategori`, `created_at`, `updated_at`) VALUES
(8, 'Novel', '2024-02-22 14:56:04', '2024-02-23 07:11:24'),
(9, 'Teknologi', '2024-02-22 14:56:04', '2024-02-22 14:56:04'),
(10, 'Sejarah', '2024-02-22 14:56:04', '2024-02-22 14:56:04'),
(12, 'Fiksi', '2024-02-22 14:56:04', '2024-02-22 14:56:04'),
(14, 'Legenda', '2024-02-22 14:56:04', '2024-02-22 14:56:04'),
(16, 'Non Fiksi', '2024-02-22 14:56:04', '2024-02-22 14:56:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_peminjaman`
--

CREATE TABLE `t_peminjaman` (
  `f_id` int(11) NOT NULL,
  `f_idadmin` int(11) NOT NULL,
  `f_idanggota` int(11) NOT NULL,
  `f_tanggalpeminjaman` date NOT NULL,
  `f_expireddate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_peminjaman`
--

INSERT INTO `t_peminjaman` (`f_id`, `f_idadmin`, `f_idanggota`, `f_tanggalpeminjaman`, `f_expireddate`) VALUES
(25, 1, 8, '2024-02-20', '2024-02-22'),
(26, 1, 13, '2024-02-23', '2024-02-26'),
(27, 1, 8, '2024-02-21', '2024-02-23'),
(28, 1, 8, '2024-02-19', '2024-02-22'),
(29, 1, 8, '2024-02-23', '2024-02-26'),
(30, 1, 13, '2024-02-23', '2024-02-23'),
(31, 1, 13, '2024-02-23', '2024-02-26');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`f_id`);

--
-- Indeks untuk tabel `t_anggota`
--
ALTER TABLE `t_anggota`
  ADD PRIMARY KEY (`f_id`);

--
-- Indeks untuk tabel `t_buku`
--
ALTER TABLE `t_buku`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idkategori` (`f_idkategori`);

--
-- Indeks untuk tabel `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idbuku` (`f_idbuku`);

--
-- Indeks untuk tabel `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idpeminjaman` (`f_idpeminjaman`,`f_iddetailbuku`),
  ADD KEY `f_iddetailbuku` (`f_iddetailbuku`);

--
-- Indeks untuk tabel `t_kategori`
--
ALTER TABLE `t_kategori`
  ADD PRIMARY KEY (`f_id`);

--
-- Indeks untuk tabel `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `f_idadmin` (`f_idadmin`,`f_idanggota`),
  ADD KEY `f_idanggota` (`f_idanggota`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `t_anggota`
--
ALTER TABLE `t_anggota`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `t_buku`
--
ALTER TABLE `t_buku`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `t_kategori`
--
ALTER TABLE `t_kategori`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_buku`
--
ALTER TABLE `t_buku`
  ADD CONSTRAINT `t_buku_ibfk_1` FOREIGN KEY (`f_idkategori`) REFERENCES `t_kategori` (`f_id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_detailbuku`
--
ALTER TABLE `t_detailbuku`
  ADD CONSTRAINT `t_detailbuku_ibfk_1` FOREIGN KEY (`f_idbuku`) REFERENCES `t_buku` (`f_id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_detailpeminjaman`
--
ALTER TABLE `t_detailpeminjaman`
  ADD CONSTRAINT `t_detailpeminjaman_ibfk_1` FOREIGN KEY (`f_iddetailbuku`) REFERENCES `t_detailbuku` (`f_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_detailpeminjaman_ibfk_2` FOREIGN KEY (`f_idpeminjaman`) REFERENCES `t_peminjaman` (`f_id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_peminjaman`
--
ALTER TABLE `t_peminjaman`
  ADD CONSTRAINT `t_peminjaman_ibfk_1` FOREIGN KEY (`f_idanggota`) REFERENCES `t_anggota` (`f_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_peminjaman_ibfk_2` FOREIGN KEY (`f_idadmin`) REFERENCES `t_admin` (`f_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
