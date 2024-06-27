-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2024 at 06:18 PM
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
(1, 1, 12, 'A01', '1607032407083811', '1607030107600027', 'M. Lukman', 'Desa Pulau Harapan', '2024-06-27 16:18:11', NULL),
(2, 1, 13, 'A02', '1607171905140003', '1607055208680004', 'Yuhana', 'Desa Pulau Harapan', '2024-06-27 16:18:11', NULL),
(3, 1, 12, 'A03', '1607032407083795', '1607031012570002', 'Maidi', 'Desa Pulau Harapan', '2024-06-27 16:18:11', NULL),
(4, 4, 27, 'A04', '1607170306160022', '1607134107750091', 'Artini', 'Desa Pulau Harapan', '2024-06-27 16:18:11', NULL),
(5, 1, 12, 'A05', '1607030407110001', '1607031508580006', 'A. Rohman', 'Desa Pulau Harapan', '2024-06-27 16:18:11', NULL),
(6, 1, 12, 'A06', '1607172510170003', '1607172209830001', 'Sariman', 'Desa Pulau Harapan', '2024-06-27 16:18:11', NULL),
(7, 4, 27, 'A07', '1607171202140001', '1607034310750001', 'Mulyana', 'Desa Pulau Harapan', '2024-06-27 16:18:11', NULL),
(8, 4, 27, 'A08', '1607032511100007', '1607036011650003', 'Syafrida', 'Desa Pulau Harapan', '2024-06-27 16:18:11', NULL);

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
(1, 'Pulau Harapan 1', 'Aek Gerdu Hilir', '2024-02-03 00:28:37', '2024-06-27 15:51:42'),
(2, 'Pulau Harapan 2', 'Sangaji', '2024-02-03 00:29:09', '2024-06-27 15:51:44'),
(3, 'Pulau Harapan 3', 'Punjung Jaya', '2024-02-03 00:29:30', '2024-06-27 15:51:46'),
(4, 'Pulau Harapan 4', 'Air Gardu Hulu', '2024-02-03 00:30:16', '2024-06-27 15:51:48'),
(5, 'Pulau Harapan 5', 'Air Petelor', '2024-02-03 00:30:52', '2024-06-27 15:51:50'),
(6, 'Pulau Harapan 6', 'Kios Pulau', '2024-02-03 00:31:34', '2024-06-27 15:51:52');

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
(1, 'C01', 'Status Tempat Tinggal', 'cost', '0.1190476190', '1', '2024-02-03 01:27:20', NULL),
(2, 'C02', 'Penghasilan Perbulan', 'cost', '0.1190476190', '1', '2024-02-03 01:30:50', NULL),
(3, 'C03', 'Banyak Tanggungan', 'benefit', '0.1190476190', '1', '2024-02-03 01:42:49', NULL),
(4, 'C04', 'Dinding Rumah', 'cost', '0.0952380952', '1', '2024-02-03 10:27:39', NULL),
(5, 'C05', 'Lantai', 'cost', '0.0952380952', '1', '2024-02-03 10:28:37', NULL),
(6, 'C06', 'Atap', 'cost', '0.0952380952', '1', '2024-06-27 15:18:24', NULL),
(7, 'C07', 'Fasilitas Buang Air Besar', 'cost', '0.0952380952', '1', '2024-06-27 15:23:44', NULL),
(8, 'C08', 'Sumber Air', 'cost', '0.0714285714', '1', '2024-06-27 15:23:44', NULL),
(9, 'C09', 'Sumber Listrik', 'cost', '0.0714285714', '1', '2024-06-27 15:23:44', NULL),
(10, 'C10', 'Bahan Bakar Memasak', 'cost', '0.0714285714', '1', '2024-06-27 15:23:44', NULL),
(11, 'C11', 'Pendidikan Terakhir Kepala Keluarga', 'cost', '0.0476190476', '1', '2024-06-27 15:23:44', NULL);

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
(118, 1, 1, 3, 2024, '2024-06-27 16:15:06', NULL),
(119, 1, 2, 7, 2024, '2024-06-27 16:15:06', NULL),
(120, 1, 3, 11, 2024, '2024-06-27 16:15:06', NULL),
(121, 1, 4, 15, 2024, '2024-06-27 16:15:06', NULL),
(122, 1, 5, 21, 2024, '2024-06-27 16:15:06', NULL),
(123, 1, 6, 26, 2024, '2024-06-27 16:15:06', NULL),
(124, 1, 7, 32, 2024, '2024-06-27 16:15:06', NULL),
(125, 1, 8, 37, 2024, '2024-06-27 16:15:06', NULL),
(126, 1, 9, 41, 2024, '2024-06-27 16:15:06', NULL),
(127, 1, 10, 46, 2024, '2024-06-27 16:15:06', NULL),
(128, 1, 11, 50, 2024, '2024-06-27 16:15:06', NULL);

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
(12, 1, '004', 'RT 004 Dusun 1', '2024-02-03 00:33:10', NULL),
(13, 1, '005', 'RT 005 Dusun 1', '2024-02-03 00:33:36', NULL),
(14, 1, '006', 'Rt 006 Dusun 1', '2024-02-03 00:33:59', NULL),
(15, 1, '007', 'RT 007 Dusun 1', '2024-02-03 00:34:22', NULL),
(16, 1, '008', 'RT 008 Dusun 1', '2024-02-03 00:34:47', NULL),
(17, 2, '005', 'RT 005 Dusun 2', '2024-02-03 00:36:22', NULL),
(18, 2, '009', 'RT 009 Dusun 2', '2024-02-03 00:37:35', NULL),
(19, 2, '010', 'RT 010 Dusun 2', '2024-02-03 00:37:54', NULL),
(20, 3, '001', 'RT 001 Dusun 3', '2024-02-03 00:38:54', NULL),
(21, 3, '002', 'RT 002 Dusun 3', '2024-02-03 00:39:24', NULL),
(22, 3, '003', 'RT 003 Dusun 3', '2024-02-03 00:39:58', NULL),
(23, 3, '004', 'RT 004 Dusun 3', '2024-02-03 00:40:25', NULL),
(24, 3, '005', 'RT 005 Dusun 3', '2024-02-03 00:40:50', NULL),
(25, 3, '006', 'RT 004 Dusun 3', '2024-02-03 00:41:33', '2024-02-03 00:41:43'),
(26, 4, '001', 'RT 001 Dusun 4 (Bekas Dusun 1)', '2024-02-03 00:42:32', NULL),
(27, 4, '002', 'RT 002 Dusun 4 (Bekas Dusun 1)', '2024-02-03 00:43:14', '2024-06-27 16:05:17'),
(28, 4, '003', 'RT 003 Dusun 4 (Bekas Dusun 1)', '2024-02-03 00:43:47', NULL),
(29, 5, '001', 'RT 001 Dusun 5 (Bekas Dusun 2)', '2024-02-03 00:45:19', NULL),
(30, 5, '002', 'RT 002 Dusun 5 (Bekas Dusun 2)', '2024-02-03 00:45:44', '2024-02-03 00:46:00'),
(31, 5, '003', 'RT 003 Dusun 5 (Bekas Dusun 2)', '2024-02-03 00:46:39', NULL),
(32, 6, '004', 'RT 004 Dusun 6 (Bekas Dusun 2)', '2024-02-03 00:47:15', NULL),
(33, 6, '006', 'RT 006 Dusun 6 (Bekas Dusun 2)', '2024-02-03 00:49:17', NULL),
(34, 6, '007', 'RT 007 Dusun 6 (Bekas Dusun 2)', '2024-02-03 00:49:59', NULL),
(35, 6, '008', 'RT 008 Dusun 6 (Bekas Dusun 2)', '2024-02-03 00:51:05', NULL);

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
(1, 1, 'C01SC01', 'Menumpang', 1, '2024-06-27 15:44:04', NULL),
(2, 1, 'C01SC02', 'Sewa', 2, '2024-06-27 15:44:04', NULL),
(3, 1, 'C01SC03', 'Milik sendiri', 3, '2024-06-27 15:44:04', NULL),
(4, 2, 'C02SC01', 'Kurang dari Rp. 500.000,00', 1, '2024-06-27 15:44:04', NULL),
(5, 2, 'C02SC02', 'Rp. 500.000,00 - Rp. 999.999,99', 2, '2024-06-27 15:44:04', NULL),
(6, 2, 'C02SC03', 'Rp. 1.000.000,00 - Rp. 2.999.999,99', 3, '2024-06-27 15:44:04', NULL),
(7, 2, 'C02SC04', 'Rp. 3.000.000,00 - Rp. 5.999.999,99', 4, '2024-06-27 15:44:04', NULL),
(8, 2, 'C02SC05', 'Lebih dari Rp. 6.000.000,00', 5, '2024-06-27 15:44:04', NULL),
(9, 3, 'C03SC01', '1 Orang', 1, '2024-06-27 15:44:04', NULL),
(10, 3, 'C03SC02', '2 Orang', 2, '2024-06-27 15:44:04', NULL),
(11, 3, 'C03SC03', '3 Orang', 3, '2024-06-27 15:44:04', NULL),
(12, 3, 'C03SC04', '4 Orang', 4, '2024-06-27 15:44:04', NULL),
(13, 3, 'C03SC05', '5 Orang atau lebih', 5, '2024-06-27 15:44:04', NULL),
(14, 4, 'C04SC01', 'Kayu murahan/bambu/rumbia/terpal', 1, '2024-06-27 15:44:04', NULL),
(15, 4, 'C04SC02', 'Tembok tanpa plester', 2, '2024-06-27 15:44:04', NULL),
(16, 4, 'C04SC03', 'Kayu kualitas tinggi', 3, '2024-06-27 15:44:04', NULL),
(17, 4, 'C04SC04', 'Tembok dengan plester tanpa cat', 4, '2024-06-27 15:44:04', NULL),
(18, 4, 'C04SC05', 'Tembok dengan plester dan cat', 5, '2024-06-27 15:44:04', NULL),
(19, 5, 'C05SC01', 'Tanah', 1, '2024-06-27 15:44:04', NULL),
(20, 5, 'C05SC02', 'Kayu kualitas rendah', 2, '2024-06-27 15:44:04', NULL),
(21, 5, 'C05SC03', 'Semen halus', 3, '2024-06-27 15:44:04', NULL),
(22, 5, 'C05SC04', 'Kayu kualitas tinggi', 4, '2024-06-27 15:44:04', NULL),
(23, 5, 'C05SC05', 'Keramik', 5, '2024-06-27 15:44:04', NULL),
(24, 6, 'C06SC01', 'Ijuk/rumbia', 1, '2024-06-27 15:44:04', NULL),
(25, 6, 'C06SC02', 'Seng/asbes kualitas rendah', 2, '2024-06-27 15:44:04', NULL),
(26, 6, 'C06SC03', 'Seng/asbes kualitas tinggi', 3, '2024-06-27 15:44:04', NULL),
(27, 6, 'C06SC04', 'Genteng tembikar', 4, '2024-06-27 15:44:04', NULL),
(28, 6, 'C06SC05', 'Semen beton', 5, '2024-06-27 15:44:04', NULL),
(29, 7, 'C07SC01', 'Tidak memiliki kloset', 1, '2024-06-27 15:44:04', NULL),
(30, 7, 'C07SC02', 'Kloset empang', 2, '2024-06-27 15:44:04', NULL),
(31, 7, 'C07SC03', 'Kloset cubluk', 3, '2024-06-27 15:44:04', NULL),
(32, 7, 'C07SC04', 'Kloset jongkok', 4, '2024-06-27 15:44:04', NULL),
(33, 7, 'C07SC05', 'Kloset duduk', 5, '2024-06-27 15:44:04', NULL),
(34, 8, 'C08SC01', 'Air hujan', 1, '2024-06-27 15:44:04', NULL),
(35, 8, 'C08SC02', 'Air sungai', 2, '2024-06-27 15:44:04', NULL),
(36, 8, 'C08SC03', 'Sumur timba', 3, '2024-06-27 15:44:04', NULL),
(37, 8, 'C08SC04', 'Sumur pompa', 4, '2024-06-27 15:44:04', NULL),
(38, 8, 'C08SC05', 'Ledeng/PDAM', 5, '2024-06-27 15:44:04', NULL),
(39, 9, 'C09SC01', 'Tidak memiliki aliran listrik sama sekali', 1, '2024-06-27 15:44:04', NULL),
(40, 9, 'C09SC02', 'Kurang dari sama dengan 1A', 2, '2024-06-27 15:44:04', NULL),
(41, 9, 'C09SC03', 'Kurang dari sama dengan 2A', 3, '2024-06-27 15:44:04', NULL),
(42, 9, 'C09SC04', 'Kurang dari sama dengan 3A', 4, '2024-06-27 15:44:04', NULL),
(43, 9, 'C09SC05', 'Lebih dari sama dengan 4A', 5, '2024-06-27 15:44:04', NULL),
(44, 10, 'C10SC01', 'Kayu bakar/arang', 1, '2024-06-27 15:44:04', NULL),
(45, 10, 'C10SC02', 'Kompor minyak', 2, '2024-06-27 15:44:04', NULL),
(46, 10, 'C10SC03', 'Kompor gas bersubsidi', 3, '2024-06-27 15:44:04', NULL),
(47, 10, 'C10SC04', 'Kompor gas non-bersubsidi', 4, '2024-06-27 15:44:04', NULL),
(48, 10, 'C10SC05', 'Kompor listrik', 5, '2024-06-27 15:44:04', NULL),
(49, 11, 'C11SC01', 'Tidak sekolah', 1, '2024-06-27 15:44:04', NULL),
(50, 11, 'C11SC02', 'Tamat TK/SD/Sederajat', 2, '2024-06-27 15:44:04', NULL),
(51, 11, 'C11SC03', 'Tamat SMP/Sederajat', 3, '2024-06-27 15:44:04', NULL),
(52, 11, 'C11SC04', 'Tamat SMA/Sederajat', 4, '2024-06-27 15:44:04', NULL),
(53, 11, 'C11SC05', 'Tamat PT/Sederajat', 5, '2024-06-27 15:44:04', NULL);

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
(1, NULL, NULL, 'Administrator A', 'admin1', '$2y$10$yl7JPWfvhbzk/rjbDTLB..EZw84nAEd1s8TFYBxeYjMkO0XVmhbaq', 'admin', '2023-12-25 19:41:15', '2024-05-31 08:42:34'),
(20, NULL, NULL, 'Administrator B', 'admin2', '$2y$10$HbdOrevoi0G87maOdab2Uuwk6NFEl3I/Xf06pIl8rVBBGlmsrw2vi', 'admin', '2024-02-03 00:25:18', '2024-05-31 08:43:32'),
(21, NULL, NULL, 'Kailani', 'kailaniismail', '$2y$10$Q1j./NiE4EPai88MyfP7F./1moN1mssbeewG.qMZHck5wEEratIBi', 'kepala_desa', '2024-02-03 00:25:55', '2024-02-07 13:15:19'),
(22, NULL, NULL, 'Bambang Sastrawani', 'mangwani', '$2y$10$v1Y4DzoAFB1UQoO1kgVc6OnDaw23abcQrxywvrBnSSQavrD3P1Pze', 'sekretaris_desa', '2024-02-03 00:26:47', '2024-02-03 15:00:20'),
(23, NULL, NULL, 'Ayu Mustika Sari', 'ayumustika', '$2y$10$iHtCL9RDTG2Ibk4haKJvROfX3e8TScvn7t5cuYB4j5dIDhT7sN9Vy', 'bendahara_desa', '2024-02-03 00:27:08', NULL),
(24, NULL, NULL, 'Atika Agustini', 'tinisobirin', '$2y$10$al8ByNYf8m4aCMuz8KIFHe1ulHmVbivkqXZS2pX7.LYPQMx3mOdXK', 'kasi_kesejahteraan_sosial', '2024-02-03 00:27:52', NULL),
(25, 11, 13, 'Irwanto', 'irwantoiwan', '$2y$10$XTO8psRmFlGupY.6JIOaHOcCXvZKEr8UlNfEqVZJFgSrhS1UmsEZS', 'kepala_dusun', '2024-02-03 00:52:02', '2024-02-03 15:01:15'),
(26, 12, 17, 'Rusdiyanto', 'rusdiyantorusdi', '$2y$10$d5BvHHjd3h/441ldthwXie1Cwh12pwANnSzr8.tlmhMLdBEwEGVQC', 'kepala_dusun', '2024-02-03 00:54:26', NULL),
(27, 13, 22, 'Irman Junika', 'ustadzirman', '$2y$10$McKDa8lKhg6Y6gG2N7SDM.VcRg5wRFnzrIRTbwXlVKzRW3KSn7RIm', 'kepala_dusun', '2024-02-03 00:55:12', NULL),
(28, 14, 27, 'Iwan Setiawan', 'iwanjogli', '$2y$10$N8LgOFfJUyeC9hmwPkU.teIjXq8tMVPZ0Gecui8bUP1Tbn5PCjtSC', 'kepala_dusun', '2024-02-03 00:56:23', NULL),
(29, 15, 30, 'Nuharli', 'nuharli', '$2y$10$lo4mbUgnjWLVhZ8kmH/FYeP4JOHOI1JtbiB7K7WWqbY.nJ.VFgJvy', 'kepala_dusun', '2024-02-03 00:57:15', NULL),
(30, 16, 33, 'Eka Rama Wita', 'ekarama', '$2y$10$Y3FqDlbwIgAaEvhNR/i85.YUgxcTYpItKzpIbMCmJBfhkQXTmVRd.', 'kepala_dusun', '2024-02-03 00:58:20', NULL),
(31, 11, 12, 'Dedi Yadiansyah', 'dediduniafana', '$2y$10$mehKywuGAKOUo1FbaEWq1uFUtilgWNFAe2Cm1ee6fFpS3pOb4qpEO', 'ketua_rt', '2024-02-03 00:59:33', NULL),
(32, 11, 13, 'Edi Tarmizi', 'editarmizi', '$2y$10$V3wXT9V/dcufBbf.H.rWDegmsEM5uc7OJWlCIHApnjVzcg4gYOtRq', 'ketua_rt', '2024-02-03 01:00:32', NULL),
(33, 11, 14, 'Relly', 'rellyujok', '$2y$10$kSEvZhqbExUMIXDWRWc.puu4N432JGAd3vnqOsrhEV685ycg2xatO', 'ketua_rt', '2024-02-03 01:01:56', NULL),
(34, 11, 15, 'Aziz Hamudin Hatta', 'azizhamudin', '$2y$10$2avMyaWdbTIE9cRRG/X4VO8C3uqHUpn7JYz3fz2h2Yr5khDsq.zlG', 'ketua_rt', '2024-02-03 01:03:22', NULL),
(35, 11, 16, 'Neli Wati', 'neliwati', '$2y$10$Ib.mzy3HfXyuyO6WFc6EQunM1o9YCYZW1ZI5a0EHff2EhxqNGqaSe', 'ketua_rt', '2024-02-03 01:04:09', NULL),
(36, 12, 17, 'Siti Zubaidah', 'sitizubaidah', '$2y$10$szG2HNHWN3S9btKRjWMDX.4crHpLg7HywHCpP6PwKy2G/EoI9Vxba', 'ketua_rt', '2024-02-03 01:05:21', NULL),
(37, 12, 18, 'Syamsudin', 'syamsudin', '$2y$10$p5KHWJQ4M7O9N2Knyw1Kx.n97Nk5j7P7ent3l/kRpu3VVU3.gPo/C', 'ketua_rt', '2024-02-03 01:06:29', NULL),
(38, 12, 19, 'Darmin', 'darmin', '$2y$10$XuidlVsMnWUys6SS2VXHte2yhta/v7FPnD09txEtGPeF.cor41iOu', 'ketua_rt', '2024-02-03 01:07:00', NULL),
(39, 13, 20, 'Holison', 'holison', '$2y$10$PFPm06g1i2wqK6aE8jzsaOdn53s8jh2V0npGnDp/EXwsk13BlBmqu', 'ketua_rt', '2024-02-03 01:08:27', NULL),
(40, 13, 21, 'Alwi', 'alwi', '$2y$10$lYqdzs2DKJ4dJdVnyCNI5.pco08NVd6CKdExmgKeL0SZ4y0sMV/FO', 'ketua_rt', '2024-02-03 01:09:53', NULL),
(41, 13, 22, 'Dendi', 'dendi', '$2y$10$6oCue6v4GFSF.usLZeyUBe2J5qKfZUd5hU3kB.3jIg1q8wF60iRyu', 'ketua_rt', '2024-02-03 01:10:30', NULL),
(42, 13, 23, 'Zainal Abidin', 'zainalabidin', '$2y$10$a29zoe.wZKEhegfPpD6WFeb31WM/wYRK6BFmvyd6Y5VoXCm0CnCwy', 'ketua_rt', '2024-02-03 01:11:13', NULL),
(43, 13, 24, 'Redi Saputra', 'redisaputra', '$2y$10$rZErZY5guqwpo3MiyDFiS.jJW7aLAoX2uAkoBTB0HIJvKcFE8daim', 'ketua_rt', '2024-02-03 01:12:22', NULL),
(44, 13, 25, 'Pustaria', 'pustaria', '$2y$10$DLu4hILNH4K4T/0McytrD.XOWgEpgEwqdoxzQzAHIVc0W8H3TcjnW', 'ketua_rt', '2024-02-03 01:13:17', NULL),
(45, 14, 26, 'Azwar', 'azwar', '$2y$10$fCYjvQj5u8HSZaTJOfmYUOZLzfKCLdCjUsL0kfhgl/raNXs9J8iMG', 'ketua_rt', '2024-02-03 01:14:34', NULL),
(46, 14, 27, 'Darmawan Mahjib', 'darmawan', '$2y$10$Wv8s0wk32nGYzkKDUpulc.u7HzIRixlu65pqx9nKBxw3F3xtK0dxW', 'ketua_rt', '2024-02-03 01:15:42', NULL),
(47, 13, 22, 'Yadim Sudirman', 'yadim', '$2y$10$mq0o28KSlP.MgGQ7IolLEepcursBUbUpUjS1t/AJPRkrxDbVjy8QG', 'ketua_rt', '2024-02-03 01:16:13', NULL),
(48, 15, 29, 'Apriadi', 'apriadi', '$2y$10$MoIptZd7L5BaGqB3jceG2./WLlNKQRAeBuhEOtWBrHQdd6bEmn/Gu', 'ketua_rt', '2024-02-03 01:17:27', NULL),
(49, 15, 30, 'Muslim', 'muslim', '$2y$10$1jY/v6JT9re.cYkpNiOcruLJW2N38h4Y480I7o5/GM4D6c358FEZa', 'ketua_rt', '2024-02-03 01:18:59', NULL),
(50, 15, 31, 'Nusardi', 'nusardi', '$2y$10$8lsLn/kz1ugwvY2qxqw3MeRwpyAqmyuRkjt4Em/vabsBQ9RTkZr5.', 'ketua_rt', '2024-02-03 01:19:55', NULL),
(51, 16, 32, 'Abdul Aziz', 'abdulaziz', '$2y$10$d1gygV9Dt3AIpmuJEM/0GuuDTey1wny5sQD8McWOijLNl9fpwV8YW', 'ketua_rt', '2024-02-03 01:21:00', NULL),
(52, 16, 33, 'Irhan Jaya', 'irhanjaya', '$2y$10$r5xCOaa0seYGwTgyQrvvBucbNiCsIWEBDO/adIx6luZbUlU9ulNQ6', 'ketua_rt', '2024-02-03 01:21:43', NULL),
(53, 16, 34, 'Wahyudi', 'wahyudi', '$2y$10$fJKSrKxhb5b0hZ8x5tu1ieBGERIyqptsYL5famnzwtkk8k45rEJVS', 'ketua_rt', '2024-02-03 01:22:24', NULL),
(54, 16, 35, 'Heru Susanto', 'herususanto', '$2y$10$dpX8YTOw6dc.G5GhgJSwxub/r0t./NLL8lOHqZxM3nkDUDeOuIxiS', 'ketua_rt', '2024-02-03 01:23:06', NULL),
(55, NULL, NULL, 'Okta467', 'okta467', '$2y$10$FXkbYVre9J5zoahACnVt1e.pi3enDpchTedCbo1R.kmTYtXCN9UHG', 'admin', '2024-02-07 06:39:39', '2024-02-07 06:39:52'),
(56, NULL, NULL, 'okta467', 'adminOkta467', '$2y$10$VSwsaud3aHkzE3VzMfuGCO9YizH7A7wVnx7Xfi9kUDiJdhDY53Msy', 'admin', '2024-06-27 15:13:35', '2024-06-27 15:13:46');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_dusun`
--
ALTER TABLE `tbl_dusun`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_kriteria`
--
ALTER TABLE `tbl_kriteria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_penilaian_alternatif`
--
ALTER TABLE `tbl_penilaian_alternatif`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `tbl_rt`
--
ALTER TABLE `tbl_rt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_sub_kriteria`
--
ALTER TABLE `tbl_sub_kriteria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

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
