-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2019 at 06:02 PM
-- Server version: 5.6.13
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ta`
--
CREATE DATABASE IF NOT EXISTS `ta` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ta`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_bidang`
--

CREATE TABLE IF NOT EXISTS `tb_bidang` (
  `id_bidang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_bidang` varchar(200) NOT NULL,
  `slug_bidang` varchar(200) NOT NULL,
  PRIMARY KEY (`id_bidang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tb_bidang`
--

INSERT INTO `tb_bidang` (`id_bidang`, `nama_bidang`, `slug_bidang`) VALUES
(1, 'KEDARURATAN DAN LOGISTIK', 'kedaruratan-dan-logistik'),
(2, 'PENCEGAHAN, KESIAPSIAGAAN DAN KEBAKARAN', 'pencegahan-kesiapsiagaan-dan-kebakaran'),
(3, 'REHABILITASI DAN KONSTRUKSI', 'rehabilitasi-dan-konstruksi'),
(4, 'TATA USAHA', 'tata-usaha');

-- --------------------------------------------------------

--
-- Table structure for table `tb_history`
--

CREATE TABLE IF NOT EXISTS `tb_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `log` varchar(200) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `tb_history`
--

INSERT INTO `tb_history` (`id`, `id_user`, `log`, `tanggal`) VALUES
(1, 1, 'Mengedit surat masuk', '2019-07-01 14:20:49'),
(2, 1, 'Menambah surat masuk', '2019-07-01 14:23:50'),
(3, 14, 'Menindaklanjuti surat masuk', '2019-07-01 14:24:38'),
(4, 1, 'Menambah surat masuk', '2019-07-01 14:27:33'),
(5, 14, 'Menindaklanjuti surat masuk', '2019-07-01 14:28:03'),
(6, 14, 'Menindaklanjuti surat masuk', '2019-07-01 14:28:15'),
(7, 14, 'Menindaklanjuti surat masuk', '2019-07-01 14:29:03'),
(8, 14, 'Menindaklanjuti surat masuk', '2019-07-01 14:30:58'),
(9, 15, 'Menindaklanjuti surat masuk', '2019-07-01 14:31:49'),
(10, 16, 'Menindaklanjuti surat masuk brow', '2019-07-01 15:56:05'),
(11, 1, 'Mengedit surat masuk', '2019-07-01 16:06:48'),
(12, 1, 'Menambah surat masuk', '2019-07-02 06:08:07'),
(13, 14, 'Menindaklanjuti surat masuk', '2019-07-02 06:09:05'),
(14, 15, 'Menindaklanjuti surat masuk', '2019-07-02 06:10:05'),
(15, 16, 'Menindaklanjuti surat masuk', '2019-07-02 06:10:43'),
(16, 1, 'Mengganti password', '2019-07-02 11:26:04'),
(17, 21, 'Mengganti password', '2019-07-02 11:31:31'),
(18, 21, 'Menindaklanjuti surat masuk', '2019-07-02 11:32:37'),
(19, 17, 'Menambah surat masuk', '2019-07-03 08:09:15'),
(20, 1, 'Menambah surat keluar', '2019-07-03 17:41:34'),
(21, 1, 'Mengedit surat masuk', '2019-07-03 17:51:59'),
(22, 1, 'Mengedit surat masuk', '2019-07-03 17:54:00'),
(23, 1, 'Menghapus surat keluar', '2019-07-03 17:55:48'),
(24, 1, 'Generate PDF surat keluar', '2019-07-03 20:58:08'),
(25, 1, 'Generate PDF surat keluar', '2019-07-03 21:07:44'),
(26, 1, 'Generate PDF surat keluar', '2019-07-03 21:13:47'),
(27, 1, 'Generate PDF surat keluar', '2019-07-03 21:14:52'),
(28, 1, 'Generate PDF surat keluar', '2019-07-03 21:18:37'),
(29, 1, 'Generate PDF surat keluar', '2019-07-03 21:19:50'),
(30, 1, 'Generate PDF surat keluar', '2019-07-03 21:26:13'),
(31, 1, 'Generate PDF surat keluar', '2019-07-03 21:32:32'),
(32, 1, 'Mengedit surat masuk', '2019-07-03 21:37:53'),
(33, 1, 'Generate PDF surat keluar', '2019-07-03 21:38:01'),
(34, 1, 'Generate PDF surat keluar', '2019-07-03 21:38:31'),
(35, 1, 'Menindaklanjuti surat keluar', '2019-07-03 21:39:14'),
(36, 1, 'Menindaklanjuti surat keluar', '2019-07-03 21:41:19'),
(37, 1, 'Generate PDF surat keluar', '2019-07-03 21:44:23'),
(38, 1, 'Generate PDF surat keluar', '2019-07-03 21:44:29'),
(39, 1, 'Menindaklanjuti surat keluar', '2019-07-03 21:45:26'),
(40, 1, 'Generate PDF surat keluar', '2019-07-03 21:46:28'),
(41, 1, 'Generate PDF surat keluar', '2019-07-03 21:47:35'),
(42, 1, 'Generate PDF surat keluar', '2019-07-03 21:49:12'),
(43, 1, 'Mengedit surat masuk', '2019-07-03 21:50:18'),
(44, 14, 'Generate PDF surat keluar', '2019-07-03 22:04:22'),
(45, 14, 'Menindaklanjuti surat keluar', '2019-07-03 22:09:20'),
(46, 15, 'Menindaklanjuti surat keluar', '2019-07-03 22:27:53'),
(47, 16, 'Menindaklanjuti surat keluar', '2019-07-03 22:28:59'),
(48, 1, 'Generate PDF surat keluar', '2019-07-03 22:41:16');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE IF NOT EXISTS `tb_pegawai` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `id_bidang` int(11) NOT NULL,
  `nama_pegawai` varchar(200) NOT NULL,
  `jabatan` varchar(200) NOT NULL,
  `slug_pegawai` varchar(200) NOT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`id_pegawai`, `id_bidang`, `nama_pegawai`, `jabatan`, `slug_pegawai`) VALUES
(1, 4, 'didi hartono, s.sos, mm', 'kepala bidang', 'didi-hartono-ssos-mm'),
(2, 1, 'bahrani, s.sos, mm', 'kepala bidang', 'bahrani-ssos-mm'),
(3, 2, 'abdurrahim', 'kepala bidang', 'abdurrahim'),
(4, 3, 'sabowo, se, mm', 'kepala bidang', 'sabowo-se-mm'),
(5, 2, 'misran, se', 'pelaksana', 'misran-se'),
(6, 3, 'yunus ariyandie. h', 'pelaksana', 'yunus-ariyandie-h'),
(7, 1, 'ivan susanto, a.md', 'pelaksana', 'ivan-susanto-amd'),
(8, 4, 'rosida ariyantie, a. md', 'pelaksana', 'rosida-ariyantie-a-md');

-- --------------------------------------------------------

--
-- Table structure for table `tb_surat_keluar`
--

CREATE TABLE IF NOT EXISTS `tb_surat_keluar` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `no_surat` varchar(50) NOT NULL,
  `perihal` varchar(200) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tempat_tujuan` varchar(250) NOT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `isi` varchar(250) DEFAULT NULL,
  `surat_keluar` varchar(200) NOT NULL DEFAULT 'default.pdf',
  `tujuan` varchar(4) DEFAULT NULL,
  `tgl_proses` date NOT NULL,
  `status` varchar(25) NOT NULL,
  `lvl1` int(5) DEFAULT NULL,
  `lvl2` int(5) DEFAULT NULL,
  `lvl3` int(5) DEFAULT NULL,
  `notif` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_surat_keluar`
--

INSERT INTO `tb_surat_keluar` (`id_surat`, `no_surat`, `perihal`, `tgl_surat`, `tempat_tujuan`, `keterangan`, `isi`, `surat_keluar`, `tujuan`, `tgl_proses`, `status`, `lvl1`, `lvl2`, `lvl3`, `notif`) VALUES
(1, '1.1.13', 'UPDATE BARU', '2019-07-05', 'ANGSANA', 'UPDATE BARU', 'laksanakan', '20190704-064116.pdf', '15', '2019-07-04', '', 1, 15, 0, 1),
(2, '1.1.12', 'UPDATE BARU', '2019-07-05', 'DIRUMAH SAJA', 'SUCCESS', 'qwerty', '20190704-062859.pdf', '0', '2019-07-04', 'selesai', 14, 15, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_surat_masuk`
--

CREATE TABLE IF NOT EXISTS `tb_surat_masuk` (
  `id_surat` int(11) NOT NULL AUTO_INCREMENT,
  `no_surat` varchar(50) NOT NULL,
  `asal` varchar(200) NOT NULL,
  `perihal` varchar(200) NOT NULL,
  `tgl_surat` date NOT NULL,
  `tgl_terima` date NOT NULL,
  `file` varchar(200) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `isi` varchar(250) DEFAULT NULL,
  `disposisi` varchar(200) NOT NULL DEFAULT 'default.pdf',
  `tujuan` varchar(4) DEFAULT NULL,
  `tgl_disposisi` date NOT NULL,
  `status` varchar(25) NOT NULL,
  `lvl1` int(5) DEFAULT NULL,
  `lvl2` int(5) DEFAULT NULL,
  `lvl3` int(5) DEFAULT NULL,
  `notif` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_surat`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tb_surat_masuk`
--

INSERT INTO `tb_surat_masuk` (`id_surat`, `no_surat`, `asal`, `perihal`, `tgl_surat`, `tgl_terima`, `file`, `keterangan`, `isi`, `disposisi`, `tujuan`, `tgl_disposisi`, `status`, `lvl1`, `lvl2`, `lvl3`, `notif`) VALUES
(1, '050/0917/SUNRAM-EVA/BAPPEDA/2019', 'BAPPEDA', 'BANJARBARU RAINY DAY  II', '2019-04-01', '2019-04-02', 'test.pdf', '', 'SURATMASUKLAGIBRO', '20190701-222903.pdf', '15', '2019-07-01', 'kabag', 14, 15, NULL, 1),
(2, '050/0917/SUNRAM-EVA/BAPPEDA/2017', 'BAPPEDA', 'HARI JADI CIREBON KE-6476', '2019-04-18', '2019-04-19', 'pdf.pdf', '', 'asdasdas', '20190630-191452.pdf', '15', '2019-06-30', 'kabag', NULL, NULL, NULL, 1),
(3, '003.1.05/KEP.304-DINKES/2019', 'DINAS KESEHATAN CIREBON', 'PEPARNAS XV JAWA BARAT', '2019-04-03', '2019-04-04', 'Kuisioner Analisa Kebutuhan.pdf', '', '', '20190630-191552.pdf', NULL, '2019-06-30', 'kabag', NULL, NULL, NULL, 1),
(4, '165/179/ORG/2019', 'WALIKOTA BANJARBARU', 'SELEKSI MUTASI MASUK TAHAP I KE LINGKUNGAN PEMERINTAH KOTA BANJARBARU', '2019-04-01', '2019-04-02', 'ipi423412.pdf', '', '', '20190507-160616.pdf', NULL, '2019-04-21', 'super_admin', NULL, NULL, NULL, 1),
(5, '15/PDT.G/2015/BNPB-PROV.KALSEL', 'BNPB PROVINSI KALIMANTAN SELATAN', 'SOSIALISASI DAMPAK KEBAKARAN', '2019-06-25', '2019-06-26', '271-278-2-PB.pdf', 'HIMBAUAN AGAR MASYARAKAT IKUT SERTA PEDULI LINGKUNGAN', 'asdasd', '20190701-043421.pdf', '15', '2019-07-01', 'kabag', NULL, NULL, NULL, 1),
(6, 'TESTING MAS', 'TESTING MAS', 'TESTING MAS', '2019-07-01', '2019-07-02', '8671-23640-1-SM.pdf', 'TESTING MAS', 'koordinasikan dengan seluruh pegawai bpbd kota banjarbaru', '20190702-193237.pdf', '16', '2019-07-02', 'selesai', 14, 15, 16, 1),
(7, 'TES LAGI', 'TES LAGI', 'LAGI TES', '2019-06-30', '2019-07-01', '8671-23640-1-SM.pdf', 'TES LAGIASDASD', NULL, 'default.pdf', '', '2019-07-01', 'super_admin', NULL, NULL, NULL, 1),
(8, 'SURATMASUKLAGIBRO', 'SURATMASUKLAGIBRO', 'SURATMASUKLAGIBRO', '2019-06-30', '2019-07-01', '271-278-2-PB.pdf', 'SURATMASUKLAGIBRO', 'SURATMASUKLAGIBRO', '20190701-223327.pdf', '16', '2019-07-01', 'selesai', 14, 15, 16, 1),
(9, 'SURAT MASUK BARU', 'TESTING', 'TESTING', '2019-07-01', '2019-07-02', '8671-23640-1-SM.pdf', 'KOSONG', 'koordinasikan dengan petugas lapangan', '20190702-141043.pdf', '16', '2019-07-02', 'selesai', 14, 15, 16, 1),
(10, '1', '1', '1', '2019-01-01', '2019-01-01', '8671-23640-1-SM.pdf', '1', NULL, 'default.pdf', NULL, '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(11, '2', '2', '2', '2019-02-01', '2019-02-01', '8671-23640-1-SM.pdf', '2', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(12, '3', '3', '3', '2019-03-01', '2019-03-01', '8671-23640-1-SM.pdf', '3', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(13, '5', '5', '5', '2019-05-01', '2019-05-01', '8671-23640-1-SM.pdf', '5', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(14, '8', '8', '8', '2019-08-01', '2019-08-01', '8671-23640-1-SM.pdf', '', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(15, '9', '9', '9', '2019-09-01', '2019-09-01', '8671-23640-1-SM.pdf', '', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(16, '10', '10', '10', '2019-10-01', '2019-10-01', '8671-23640-1-SM.pdf', '', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(17, '11', '11', '11', '2019-11-01', '2019-11-01', '8671-23640-1-SM.pdf', '', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(18, '12', '12', '12', '2019-12-01', '2019-12-01', '8671-23640-1-SM.pdf', '', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1),
(19, '13', '13', '13', '2019-06-01', '2019-06-01', '8671-23640-1-SM.pdf', '', NULL, 'default.pdf', '', '2019-07-03', 'admin', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `nama_lengkap` varchar(200) DEFAULT NULL,
  `pass_login` varchar(200) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `login_terakhir` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `level_akses` enum('super_admin','admin','kalak','kabag','pelaksana') DEFAULT NULL,
  `id_bidang` int(11) NOT NULL,
  `ttd` varchar(200) NOT NULL,
  `status_user` enum('valid','not') DEFAULT NULL,
  `status` enum('online','offline') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `nama_lengkap`, `pass_login`, `email`, `foto`, `login_terakhir`, `level_akses`, `id_bidang`, `ttd`, `status_user`, `status`) VALUES
(1, 'admin', 'Operator', '$2y$10$uB1C76w2/y26PxNC8.KRdeBAutVW3ytWYmRJXCXNE6ze9CERn4fuu', 'emilio.andhy@gmaill.com', '95bb9e32c7e35ad823e3ba60145e1349.png', '2019-07-04 17:58:30', 'super_admin', 3, '2019-05-13-02-21-42-ttd.png', 'valid', 'online'),
(14, 'kalak', 'Drs. Budi Supriyanto M.Kom', '$2y$10$uB1C76w2/y26PxNC8.KRdeBAutVW3ytWYmRJXCXNE6ze9CERn4fuu', 'kalak@gmail.com', 'null', '2019-07-03 22:27:24', 'kalak', 0, 'ttd.png', 'valid', 'offline'),
(15, 'kabag', 'Ir. Rahayu S. MH', '$2y$10$uB1C76w2/y26PxNC8.KRdeBAutVW3ytWYmRJXCXNE6ze9CERn4fuu', 'kabag@gmail.com', 'null', '2019-07-03 22:28:07', 'kabag', 2, 'ttd1.png', 'valid', 'offline'),
(16, 'pelaksana', 'Emilio Andi Kriswanto', '$2y$10$Wd1MIbvrIJzBoUgJ56VjRuxoqndQM2G3rXTQJA8QSda30KultrjsG', 'pelaksana@gmail.com', 'null', '2019-07-03 22:36:22', 'pelaksana', 2, '2019-05-13-02-21-42-ttd.png', 'valid', 'offline'),
(17, 'admintu', 'admin', '$2y$10$uB1C76w2/y26PxNC8.KRdeBAutVW3ytWYmRJXCXNE6ze9CERn4fuu', 'admin@admin.com', 'null', '2019-07-03 08:08:26', 'admin', 4, '', 'valid', 'online'),
(18, 'tu', 'tu', '$2y$10$9xhvrfhyWW2IgJgxzE5HW.jK8/TCqgeGuw2intniWRXUkDrl.GjH.', 'tu@gmail.com', 'null', '2019-07-01 10:00:52', 'pelaksana', 1, 'ttd_pelaksana.png', 'valid', 'offline'),
(20, 'qwerty', 'qwerty', '$2y$10$lrNlNir077kRfB5/kYDDmeade9yI8idTijkqv14kJieHTla4N0jQS', NULL, 'null', '2019-07-01 10:00:54', 'pelaksana', 1, 'ttd_pelaksana.png', 'valid', 'offline'),
(21, '123123', '123123', '$2y$10$RM3h.jV0h7jSUSY3Ur2iouua6PHor3H0pItN/TLreTFosBOJcCH5C', NULL, 'null', '2019-07-02 11:31:35', 'pelaksana', 1, 'ttd_pelaksana.png', 'valid', 'online');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
