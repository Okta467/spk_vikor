-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2024 at 12:42 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_vikor`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_alternatif`
--

CREATE TABLE `tbl_alternatif` (
  `id` int(10) UNSIGNED NOT NULL,
  `dusun_id` int(10) UNSIGNED DEFAULT NULL,
  `rt_id` int(10) UNSIGNED DEFAULT NULL,
  `kode` varchar(255) NOT NULL,
  `kk_kepala_keluarga` varchar(32) NOT NULL,
  `nik_kepala_keluarga` varchar(32) NOT NULL,
  `nama_kepala_keluarga` varchar(255) NOT NULL,
  `alamat` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_alternatif`
--

INSERT INTO `tbl_alternatif` (`id`, `dusun_id`, `rt_id`, `kode`, `kk_kepala_keluarga`, `nik_kepala_keluarga`, `nama_kepala_keluarga`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'A01', '1671020101950011', '1671023020497858', 'Syafrida', 'Alamatnya Syafrida', '2023-12-25 19:35:43', '2024-01-03 13:47:32'),
(2, 1, 1, 'A02', '1671027623728121', '1671887236273721', 'Mulyana', 'Tempatnya Mulyana', '2023-12-25 19:35:43', '2024-01-03 13:47:35'),
(4, 2, 4, 'A03', '2367281929837232', '1726367291292392', 'Bima Satria', 'Tempat bima', '2023-12-25 19:39:35', '2024-01-03 13:47:37'),
(5, 2, 3, 'A04', '9673829192327172', '9237293726456281', 'Putri Anindi', '7 Ulu, Gg. Jambu, Kertapati, Palembang', '2023-12-29 17:33:42', '2024-01-03 13:48:07'),
(7, 3, 7, 'A05', '1203981290381203', '0469890238493493', 'Arief Winata', 'Alamat Arief Winata di mana, gan', '2024-01-02 18:54:55', '2024-01-03 13:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dusun`
--

CREATE TABLE `tbl_dusun` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_dusun`
--

INSERT INTO `tbl_dusun` (`id`, `nama`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'Dusun A', 'Alamat dusun a', '2023-12-25 19:29:07', '2023-12-25 19:40:18'),
(2, 'Dusun B', 'Alamat dusun b', '2023-12-25 19:30:15', NULL),
(3, 'Dusun C', 'Alamatnya dusun C, gan', '2023-12-29 21:51:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kriteria`
--

CREATE TABLE `tbl_kriteria` (
  `id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `atribut` enum('benefit','cost') NOT NULL,
  `bobot` decimal(11,10) NOT NULL,
  `status_aktif` enum('1','0') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kriteria`
--

INSERT INTO `tbl_kriteria` (`id`, `kode`, `nama`, `atribut`, `bobot`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'C01', 'Status Tempat Tinggal', 'cost', '0.1190476190', '0', '2023-12-21 16:34:57', NULL),
(2, 'C02', 'Dinding Rumah', 'cost', '0.0952380950', '0', '2023-12-31 11:00:49', NULL),
(3, 'C03', 'Lantai', 'cost', '0.0952380950', '0', '2023-12-31 11:18:48', NULL),
(4, 'C04', 'Atap', 'cost', '0.0952380950', '0', '2023-12-31 11:19:02', NULL),
(5, 'C05', 'Fasilitas Buang Air Besar', 'cost', '0.0952380950', '0', '2023-12-31 11:19:33', NULL),
(6, 'C06', 'Sumber Air', 'cost', '0.0714285710', '0', '2023-12-31 11:19:58', NULL),
(7, 'C07', 'Sumber Listrik', 'cost', '0.0714285710', '0', '2023-12-31 11:20:14', NULL),
(8, 'C08', 'Bahan Bakar Memasak', 'cost', '0.0714285710', '0', '2023-12-31 11:20:48', NULL),
(9, 'C09', 'Penghasilan Per Bulan', 'cost', '0.1190476190', '0', '2023-12-31 11:21:29', NULL),
(10, 'C10', 'Pendidikan Terakhir Kepala Keluarga', 'cost', '0.0476190480', '0', '2023-12-31 11:21:52', NULL),
(11, 'C11', 'Banyak Tanggungan', 'benefit', '0.1190476190', '0', '2023-12-31 11:22:07', NULL),
(14, 'C99', 'Test Kriteria', 'benefit', '0.5000000000', '0', '2024-01-07 19:22:24', NULL),
(15, 'C98', 'Test Sub Kriteria 98', 'benefit', '0.2500000000', '1', '2024-01-08 08:48:20', NULL),
(16, 'C97', 'Test Kriteria 3', 'cost', '0.2500000000', '1', '2024-01-08 08:48:36', NULL),
(17, 'C100', 'Test Kriteria C100', 'benefit', '0.5000000000', '1', '2024-01-08 09:16:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penilaian_alternatif`
--

CREATE TABLE `tbl_penilaian_alternatif` (
  `id` int(10) UNSIGNED NOT NULL,
  `alternatif_id` int(10) UNSIGNED NOT NULL,
  `kriteria_id` int(10) UNSIGNED NOT NULL,
  `sub_kriteria_id` int(10) UNSIGNED NOT NULL,
  `tahun_penilaian` year(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_penilaian_alternatif`
--

INSERT INTO `tbl_penilaian_alternatif` (`id`, `alternatif_id`, `kriteria_id`, `sub_kriteria_id`, `tahun_penilaian`, `created_at`, `updated_at`) VALUES
(12, 4, 1, 8, 2024, '2024-01-02 18:22:49', NULL),
(13, 4, 2, 13, 2024, '2024-01-02 18:22:49', NULL),
(14, 4, 3, 17, 2024, '2024-01-02 18:22:49', NULL),
(15, 4, 4, 22, 2024, '2024-01-02 18:22:49', NULL),
(16, 4, 5, 27, 2024, '2024-01-02 18:22:49', NULL),
(17, 4, 6, 31, 2024, '2024-01-02 18:22:49', NULL),
(18, 4, 7, 38, 2024, '2024-01-02 18:22:49', NULL),
(19, 4, 8, 43, 2024, '2024-01-02 18:22:49', NULL),
(20, 4, 9, 48, 2024, '2024-01-02 18:22:49', NULL),
(21, 4, 10, 52, 2024, '2024-01-02 18:22:49', NULL),
(22, 4, 11, 60, 2024, '2024-01-02 18:22:49', NULL),
(34, 7, 1, 9, 2024, '2024-01-02 18:55:30', NULL),
(35, 7, 2, 13, 2024, '2024-01-02 18:55:31', NULL),
(36, 7, 3, 18, 2024, '2024-01-02 18:55:31', NULL),
(37, 7, 4, 23, 2024, '2024-01-02 18:55:31', NULL),
(38, 7, 5, 28, 2024, '2024-01-02 18:55:31', NULL),
(39, 7, 6, 32, 2024, '2024-01-02 18:55:31', NULL),
(40, 7, 7, 38, 2024, '2024-01-02 18:55:31', NULL),
(41, 7, 8, 44, 2024, '2024-01-02 18:55:31', NULL),
(42, 7, 9, 47, 2024, '2024-01-02 18:55:31', NULL),
(43, 7, 10, 53, 2024, '2024-01-02 18:55:31', NULL),
(44, 7, 11, 58, 2024, '2024-01-02 18:55:31', NULL),
(56, 5, 1, 8, 2024, '2024-01-02 19:05:13', NULL),
(57, 5, 2, 12, 2024, '2024-01-02 19:05:13', NULL),
(58, 5, 3, 16, 2024, '2024-01-02 19:05:13', NULL),
(59, 5, 4, 24, 2024, '2024-01-02 19:05:13', NULL),
(60, 5, 5, 27, 2024, '2024-01-02 19:05:13', NULL),
(61, 5, 6, 31, 2024, '2024-01-02 19:05:13', NULL),
(62, 5, 7, 38, 2024, '2024-01-02 19:05:13', NULL),
(63, 5, 8, 43, 2024, '2024-01-02 19:05:13', NULL),
(64, 5, 9, 48, 2024, '2024-01-02 19:05:13', NULL),
(65, 5, 10, 52, 2024, '2024-01-02 19:05:13', NULL),
(66, 5, 11, 60, 2024, '2024-01-02 19:05:13', NULL),
(67, 2, 1, 9, 2024, '2024-01-02 19:05:30', NULL),
(68, 2, 2, 13, 2024, '2024-01-02 19:05:30', NULL),
(69, 2, 3, 17, 2024, '2024-01-02 19:05:30', NULL),
(70, 2, 4, 22, 2024, '2024-01-02 19:05:30', NULL),
(71, 2, 5, 28, 2024, '2024-01-02 19:05:30', NULL),
(72, 2, 6, 33, 2024, '2024-01-02 19:05:30', NULL),
(73, 2, 7, 37, 2024, '2024-01-02 19:05:30', NULL),
(74, 2, 8, 43, 2024, '2024-01-02 19:05:30', NULL),
(75, 2, 9, 47, 2024, '2024-01-02 19:05:30', NULL),
(76, 2, 10, 53, 2024, '2024-01-02 19:05:30', NULL),
(77, 2, 11, 58, 2024, '2024-01-02 19:05:30', NULL),
(89, 7, 14, 62, 2023, '2024-01-08 09:09:23', NULL),
(90, 7, 15, 66, 2023, '2024-01-08 09:09:25', NULL),
(91, 7, 16, 68, 2023, '2024-01-08 09:09:25', NULL),
(92, 5, 14, 62, 2023, '2024-01-08 09:19:04', NULL),
(93, 5, 15, 66, 2023, '2024-01-08 09:19:04', NULL),
(94, 5, 16, 69, 2023, '2024-01-08 09:19:04', NULL),
(95, 4, 14, 64, 2023, '2024-01-08 09:19:14', NULL),
(96, 4, 15, 67, 2023, '2024-01-08 09:19:14', NULL),
(97, 4, 16, 68, 2023, '2024-01-08 09:19:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rt`
--

CREATE TABLE `tbl_rt` (
  `id` int(10) UNSIGNED NOT NULL,
  `dusun_id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(32) NOT NULL,
  `alamat` varchar(1024) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_rt`
--

INSERT INTO `tbl_rt` (`id`, `dusun_id`, `nama`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 1, '20', 'alamat dusun a rt 20', '2023-12-25 19:30:57', NULL),
(2, 1, '5', 'dusun a rt 5', '2023-12-25 19:31:41', NULL),
(3, 2, '1', 'dusun b rt 1', '2023-12-25 19:32:54', NULL),
(4, 2, '10', 'dusun b rt 10', '2023-12-25 19:33:07', NULL),
(6, 2, '3', 'alamat Dusun B RT 3', '2023-12-31 09:51:11', '2023-12-31 10:21:27'),
(7, 3, '1', 'Alamatnya Dusun C RT 1', '2024-01-02 18:53:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_kriteria`
--

CREATE TABLE `tbl_sub_kriteria` (
  `id` int(10) UNSIGNED NOT NULL,
  `kriteria_id` int(10) UNSIGNED NOT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `skor` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sub_kriteria`
--

INSERT INTO `tbl_sub_kriteria` (`id`, `kriteria_id`, `kode`, `nama`, `skor`, `created_at`, `updated_at`) VALUES
(8, 1, 'C01SC01', 'Milik Sendiri', 1, '2023-12-31 15:18:34', NULL),
(9, 1, 'C01SC02', 'Sewa', 3, '2023-12-31 15:18:34', NULL),
(10, 1, 'C01SC03', 'Menumpang', 5, '2023-12-31 15:18:34', NULL),
(11, 2, 'C02SC01', 'Tembok dengan Plester dan Cat', 1, '2023-12-31 15:18:34', NULL),
(12, 2, 'C02SC02', 'Tembok dengan Plester tanpa Cat', 2, '2023-12-31 15:18:34', NULL),
(13, 2, 'C02SC03', 'Kayu Kualitas Tinggi', 3, '2023-12-31 15:18:34', NULL),
(14, 2, 'C02SC04', 'Tembok tanpa Plester', 4, '2023-12-31 15:18:34', NULL),
(15, 2, 'C02SC05', 'Kayu Murahan/Bambu/Rumbia/Terpal', 5, '2023-12-31 15:18:34', NULL),
(16, 3, 'C03SC01', 'Keramik', 1, '2023-12-31 15:18:34', NULL),
(17, 3, 'C03SC02', 'Kayu Kualitas Tinggi', 2, '2023-12-31 15:18:34', NULL),
(18, 3, 'C03SC03', 'Semen Halus', 3, '2023-12-31 15:18:34', NULL),
(19, 3, 'C03SC04', 'Kayu Kualitas Rendah', 4, '2023-12-31 15:18:34', NULL),
(20, 3, 'C03SC05', 'Tanah', 5, '2023-12-31 15:18:34', NULL),
(21, 4, 'C04SC01', 'Semen Beton', 1, '2023-12-31 15:18:34', NULL),
(22, 4, 'C04SC02', 'Genteng Tembikar', 2, '2023-12-31 15:18:34', NULL),
(23, 4, 'C04SC03', 'Seng/Asbes Kualitas Tinggi', 3, '2023-12-31 15:18:34', NULL),
(24, 4, 'C04SC04', 'Seng/Asbes Kualitas Rendah', 4, '2023-12-31 15:18:34', NULL),
(25, 4, 'C04SC05', 'Ijuk/Rumbia', 5, '2023-12-31 15:18:34', NULL),
(26, 5, 'C05SC01', 'Kloset Duduk', 1, '2023-12-31 15:18:34', NULL),
(27, 5, 'C05SC02', 'Kloset Jongkok', 2, '2023-12-31 15:18:34', NULL),
(28, 5, 'C05SC03', 'Kloset Cubluk', 3, '2023-12-31 15:18:34', NULL),
(29, 5, 'C05SC04', 'Kloset Empang', 4, '2023-12-31 15:18:34', NULL),
(30, 5, 'C05SC05', 'Tidak Memiliki Kloset', 5, '2023-12-31 15:18:34', NULL),
(31, 6, 'C06SC01', 'Ledeng/PDAM', 1, '2023-12-31 15:18:34', NULL),
(32, 6, 'C06SC02', 'Sumur Pompa', 2, '2023-12-31 15:18:34', NULL),
(33, 6, 'C06SC03', 'Sumur Timba', 3, '2023-12-31 15:18:34', NULL),
(34, 6, 'C06SC04', 'Air Sungai', 4, '2023-12-31 15:18:34', NULL),
(35, 6, 'C06SC05', 'Air Hujan', 5, '2023-12-31 15:18:34', NULL),
(36, 7, 'C07SC01', '6 Ampere dan diatasnya', 1, '2023-12-31 15:18:34', NULL),
(37, 7, 'C07SC02', '4 Ampere', 2, '2023-12-31 15:18:34', NULL),
(38, 7, 'C07SC03', '2 Ampere', 3, '2023-12-31 15:18:34', NULL),
(39, 7, 'C07SC04', 'Dibawah 1 Ampere', 4, '2023-12-31 15:18:34', NULL),
(40, 7, 'C07SC05', 'Tidak Memiliki Aliran Listrik Sama Sekali', 5, '2023-12-31 15:18:34', NULL),
(41, 8, 'C08SC01', 'Kompor Listrik', 1, '2023-12-31 15:18:34', NULL),
(42, 8, 'C08SC02', 'Kompor Gas Non-Subsidi', 2, '2023-12-31 15:18:34', NULL),
(43, 8, 'C08SC03', 'Kompor Gas Bersubsidi', 3, '2023-12-31 15:18:34', NULL),
(44, 8, 'C08SC04', 'Kompor Minyak', 4, '2023-12-31 15:18:34', NULL),
(45, 8, 'C08SC05', 'Kayu Bakar/Arang', 5, '2023-12-31 15:18:34', NULL),
(46, 9, 'C09SC01', 'Lebih dari Rp. 6.000.000,00.', 1, '2023-12-31 16:18:46', NULL),
(47, 9, 'C09SC02', 'Rp. 3.000.000,00 - Rp. 5.999.999,99.', 2, '2023-12-31 16:18:47', NULL),
(48, 9, 'C09SC03', 'Rp. 1.000.000,00 - Rp.2.999.999,99.', 3, '2023-12-31 16:18:47', NULL),
(49, 9, 'C09SC04', 'Rp. 500.000,00 - Rp.999.999,99.', 4, '2023-12-31 16:18:47', NULL),
(50, 9, 'C09SC05', 'Kurang dari Rp. 500.000,00.', 5, '2023-12-31 16:18:47', NULL),
(51, 10, 'C10SC01', 'Diploma/Sarjana/Magister/Doktoral', 1, '2023-12-31 16:18:47', NULL),
(52, 10, 'C10SC02', 'SMA/SMK/Sederajat', 2, '2023-12-31 16:18:47', NULL),
(53, 10, 'C10SC03', 'SMP/Sederajat', 3, '2023-12-31 16:18:47', NULL),
(54, 10, 'C10SC04', 'TK dan SD/Sederajat', 4, '2023-12-31 16:18:47', NULL),
(55, 10, 'C10SC05', 'Tidak Bersekolah', 5, '2023-12-31 16:18:47', NULL),
(56, 11, 'C11SC01', '1 Orang', 1, '2023-12-31 16:18:47', NULL),
(57, 11, 'C11SC02', '2 Orang', 2, '2023-12-31 16:18:47', NULL),
(58, 11, 'C11SC03', '3 Orang', 3, '2023-12-31 16:18:47', NULL),
(59, 11, 'C11SC04', '4 Orang', 4, '2023-12-31 16:18:47', NULL),
(60, 11, 'C11SC05', '5 Orang atau lebih', 5, '2023-12-31 16:18:47', NULL),
(61, 14, 'C99SC01', 'Test Sub Kriteria 1', 1, '2024-01-08 08:44:43', NULL),
(62, 14, 'C99SC02', 'Test Sub kriteria 2', 2, '2024-01-08 08:45:02', NULL),
(63, 14, 'C99SC03', 'Test Sub Kriteria 3', 3, '2024-01-08 08:46:05', NULL),
(64, 14, 'C99SC04', 'Test Sub kriteria 4', 4, '2024-01-08 08:46:49', NULL),
(65, 14, 'C99SC05', 'Test Sub Kriteria 5', 5, '2024-01-08 08:47:20', NULL),
(66, 15, 'C98SC01', 'Test Sub Kriteria 1', 1, '2024-01-08 08:49:08', NULL),
(67, 15, 'C98SC02', 'Test Sub kriteria 2', 2, '2024-01-08 08:49:20', NULL),
(68, 16, 'C97SC01', 'Test Sub Kriteria 1', 1, '2024-01-08 08:49:52', NULL),
(69, 16, 'C97SC02', 'Test Sub kriteria 2', 2, '2024-01-08 08:50:04', NULL),
(70, 17, 'C100SC01', 'Test Sub Kriteria 1', 1, '2024-01-08 09:16:39', NULL),
(71, 17, 'C100SC02', 'Test Sub kriteria 2', 2, '2024-01-08 09:16:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `dusun_id` int(10) UNSIGNED DEFAULT NULL,
  `rt_id` int(10) UNSIGNED DEFAULT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `hak_akses` enum('admin','kepala_desa','sekretaris_desa','bendahara_desa','kasi_kesejahteraan_sosial','kepala_dusun','ketua_rt') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `dusun_id`, `rt_id`, `nama_pemilik`, `username`, `password`, `hak_akses`, `created_at`, `last_login`) VALUES
(1, NULL, NULL, 'Admin Tercinta Emuach', 'admin', '$2y$10$FXkbYVre9J5zoahACnVt1e.pi3enDpchTedCbo1R.kmTYtXCN9UHG', 'admin', '2023-12-25 19:41:15', '2024-01-08 16:28:23'),
(2, NULL, NULL, 'Sumanto', 'sumantokeren', '$2y$10$sYk8snRLa4FALvgwJPIx2.2Pg8M7fb6z0Dxy3r5fv4ShxWWaR0xdO', 'kepala_desa', '2023-12-28 21:04:21', '2024-01-08 15:57:24'),
(3, NULL, NULL, 'Sumarni Cantiq', 'sumarnicantiq', '$2y$10$fRX1SKgajbtwPKdCL7lxfO35xQwJU7jIDCp4SKxeQMyng6CbtbeiS', 'sekretaris_desa', '2023-12-28 21:07:30', '2024-01-08 15:38:04'),
(4, 1, 2, 'Dadang Asyique', 'dadadang', '$2y$10$y3tmd4uR9KRmMeTEtfYMKuatEpaMOmRezREOVl74JYMF2oEsq6Ytq', 'kepala_dusun', '2023-12-28 21:10:01', NULL),
(5, 1, 1, 'Manap Ajah', 'manapajah', '$2y$10$uAegdlGSy58BOKzNnfDOoeESPQJmAkqMdrGT7IUMVYMRV6wHmntIS', 'kepala_dusun', '2023-12-28 21:33:47', NULL),
(6, 1, 2, 'Dudung Anak Dadang', 'dudung', '$2y$10$s5oNPnfzAzhgf0HRT/MZxeTpnWpvizMEoQPqtf03vuc00pB/.2UaK', 'ketua_rt', '2023-12-28 21:34:32', NULL),
(7, 1, 1, 'Mahap Bae', 'mahapbae', '$2y$10$Dfb12WkcL5y1DMGeG8thFuzBd1rgz5xs2JMl6P35nVZaTVYyVLL1q', 'ketua_rt', '2023-12-28 21:34:59', NULL),
(8, 2, 3, 'Santi', 'santi', '$2y$10$yP6qOpGprMrFb5sqDY6bkOvSE04pkX4mcS9G0Egv/YsOmTNOM13CW', 'kepala_dusun', '2023-12-28 21:35:44', '2024-01-08 16:41:13'),
(9, 2, 3, 'Tisan', 'tisan', '$2y$10$8WVD5mP0rHAd3HPOvLlHYeB9ivQBdC7jxUr1ZqOuT9zAUTPxzGIOG', 'ketua_rt', '2023-12-28 21:36:01', '2024-01-08 16:03:24'),
(10, NULL, NULL, 'test', 'test', '$2y$10$1gtShfAFuvfteAnJ1WQrKei7P7XXTR2pgOHCMRKkjV/NkL8KdNDjC', 'admin', '2023-12-28 21:51:29', NULL),
(11, 1, 2, 'testaab', 'testaab', '$2y$10$632wmjTcgnx4AP4I/09WrORmv7qAoqwoBpHUmTcULgRilVvvRVuhG', 'kepala_dusun', '2023-12-28 22:13:00', '2023-12-28 16:25:00'),
(13, NULL, NULL, 'Uwaaa', 'uwaa', '$2y$10$biFc9llkufZ2gKKG0OgpTuNA2rDQUvXHJYrPDSb8owDA9vuEggZ82', 'bendahara_desa', '2024-01-08 20:56:56', '2024-01-08 15:37:37'),
(14, NULL, NULL, 'Kasi Kekasihqu', 'kasikekasihqu', '$2y$10$AtMRxoCw12VrDqJwcJfn1uaIhuy366L950Dk7.GkfKW2tI5WOGxcm', 'kasi_kesejahteraan_sosial', '2024-01-08 21:06:59', '2024-01-08 15:51:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dusun_id` (`dusun_id`),
  ADD KEY `rt_id` (`rt_id`);

--
-- Indexes for table `tbl_dusun`
--
ALTER TABLE `tbl_dusun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_penilaian_alternatif`
--
ALTER TABLE `tbl_penilaian_alternatif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alternatif_id` (`alternatif_id`),
  ADD KEY `kriteria_id` (`kriteria_id`),
  ADD KEY `sub_kriteria_id` (`sub_kriteria_id`);

--
-- Indexes for table `tbl_rt`
--
ALTER TABLE `tbl_rt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dusun_id` (`dusun_id`);

--
-- Indexes for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_dusun`
--
ALTER TABLE `tbl_dusun`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_penilaian_alternatif`
--
ALTER TABLE `tbl_penilaian_alternatif`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `tbl_rt`
--
ALTER TABLE `tbl_rt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_alternatif`
--
ALTER TABLE `tbl_alternatif`
  ADD CONSTRAINT `tbl_alternatif_ibfk_2` FOREIGN KEY (`dusun_id`) REFERENCES `tbl_dusun` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_alternatif_ibfk_3` FOREIGN KEY (`rt_id`) REFERENCES `tbl_rt` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_penilaian_alternatif`
--
ALTER TABLE `tbl_penilaian_alternatif`
  ADD CONSTRAINT `tbl_penilaian_alternatif_ibfk_1` FOREIGN KEY (`alternatif_id`) REFERENCES `tbl_alternatif` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penilaian_alternatif_ibfk_2` FOREIGN KEY (`kriteria_id`) REFERENCES `tbl_kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_penilaian_alternatif_ibfk_3` FOREIGN KEY (`sub_kriteria_id`) REFERENCES `tbl_sub_kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_rt`
--
ALTER TABLE `tbl_rt`
  ADD CONSTRAINT `tbl_rt_ibfk_1` FOREIGN KEY (`dusun_id`) REFERENCES `tbl_dusun` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  ADD CONSTRAINT `tbl_sub_kriteria_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `tbl_kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
