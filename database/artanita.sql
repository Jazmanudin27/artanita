-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 17, 2026 at 05:51 AM
-- Server version: 11.8.9-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u847236663_artanita`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi_mapel`
--

CREATE TABLE IF NOT EXISTS `absensi_mapel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `kode_kelas` int(15) DEFAULT NULL,
  `kode_guru` int(15) DEFAULT NULL,
  `kode_mapel` int(15) DEFAULT NULL,
  `kode_siswa` int(15) DEFAULT NULL,
  `status` char(15) DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `absensi_siswa`
--

CREATE TABLE IF NOT EXISTS `absensi_siswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `kode_kelas` int(15) DEFAULT NULL,
  `kode_siswa` int(15) DEFAULT NULL,
  `status` char(15) DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
  `kode_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) DEFAULT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` int(11) DEFAULT NULL,
  `jumlah_stok` int(11) DEFAULT NULL,
  `sisa_stok` int(11) DEFAULT NULL,
  `kode_member` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`kode_buku`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE IF NOT EXISTS `fasilitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fasilitas` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE IF NOT EXISTS `guru` (
  `kode_guru` int(11) NOT NULL AUTO_INCREMENT,
  `nip_nuptk` char(25) DEFAULT NULL,
  `nama_guru` varchar(100) DEFAULT NULL,
  `jk` char(15) DEFAULT NULL,
  `tmt` char(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` char(13) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `agama` char(35) DEFAULT NULL,
  `tempat_lahir` char(35) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `status_kepegawaian` char(25) DEFAULT NULL,
  `pendidikan_terakhir` char(100) DEFAULT NULL,
  `status` char(15) DEFAULT NULL,
  `no_urut` char(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` char(20) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  PRIMARY KEY (`kode_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE IF NOT EXISTS `jadwal` (
  `kode_jadwal` int(11) NOT NULL AUTO_INCREMENT,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') DEFAULT NULL,
  `kode_jam` int(11) DEFAULT NULL,
  `kode_kelas` int(11) DEFAULT NULL,
  `kode_guru_mapel` int(11) DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  PRIMARY KEY (`kode_jadwal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_jam`
--

CREATE TABLE IF NOT EXISTS `jadwal_jam` (
  `kode_jam` int(11) NOT NULL AUTO_INCREMENT,
  `jam_ke` int(11) DEFAULT NULL,
  `jam` char(35) DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  PRIMARY KEY (`kode_jam`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
  `kode_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(255) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `kode_guru` char(15) DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`kode_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `kurikulum`
--

CREATE TABLE IF NOT EXISTS `kurikulum` (
  `kode_kurikulum` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kurikulum` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`kode_kurikulum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE IF NOT EXISTS `mapel` (
  `kode_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(255) DEFAULT NULL,
  `kkm` int(11) DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  PRIMARY KEY (`kode_mapel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `mapel_guru`
--

CREATE TABLE IF NOT EXISTS `mapel_guru` (
  `kode_guru_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `kode_guru` int(11) DEFAULT NULL,
  `kode_mapel` int(11) DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  PRIMARY KEY (`kode_guru_mapel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `kode_member` char(30) NOT NULL,
  `nama_member` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `desa` varchar(100) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `no_hp` char(15) DEFAULT NULL,
  `status` char(15) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `npsn` char(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pos` char(10) DEFAULT NULL,
  `exp_date` datetime DEFAULT NULL,
  `kode_paket` int(11) DEFAULT NULL,
  `kode_tahun_pelajaran` int(11) DEFAULT NULL,
  `kode_kurikulum` int(11) DEFAULT NULL,
  `kategori` char(25) DEFAULT NULL,
  PRIMARY KEY (`kode_member`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_user` int(11) DEFAULT NULL,
  `status` char(20) DEFAULT NULL,
  `menu` char(35) DEFAULT NULL,
  `kode_member` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE IF NOT EXISTS `paket` (
  `kode_paket` int(11) NOT NULL AUTO_INCREMENT,
  `nama_paket` char(100) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `diskon` char(11) DEFAULT NULL,
  `ppn` char(11) DEFAULT NULL,
  PRIMARY KEY (`kode_paket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_siswa` int(11) DEFAULT NULL,
  `kode_buku` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kode_member` char(15) DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `tgl_dikembalikan` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan_tanah`
--

CREATE TABLE IF NOT EXISTS `penggunaan_tanah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `penggunaan_tanah` varchar(50) DEFAULT NULL,
  `luas_tanah` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE IF NOT EXISTS `presensi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_guru` char(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_in` time DEFAULT NULL,
  `jam_out` time DEFAULT NULL,
  `foto_in` text DEFAULT NULL,
  `foto_out` text DEFAULT NULL,
  `lokasi_in` text DEFAULT NULL,
  `lokasi_out` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

COMMIT;
