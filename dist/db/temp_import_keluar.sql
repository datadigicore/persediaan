-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2017 at 01:18 PM
-- Server version: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 5.6.30-4+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `persediaan_latihan`
--

-- --------------------------------------------------------

--
-- Table structure for table `temp_import_keluar`
--

CREATE TABLE `temp_import_keluar` (
  `id` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `kd_ruang` varchar(5) DEFAULT NULL,
  `nm_satker` varchar(255) DEFAULT NULL,
  `thn_ang` year(4) DEFAULT NULL,
  `no_dok` varchar(40) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(40) NOT NULL,
  `kd_sskel` varchar(20) DEFAULT NULL,
  `nm_sskel` varchar(70) DEFAULT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `nm_brg` varchar(70) DEFAULT NULL,
  `spesifikasi` varchar(70) DEFAULT NULL,
  `kd_perk` varchar(7) DEFAULT NULL,
  `nm_perk` varchar(70) DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `qty` decimal(50,2) NOT NULL,
  `tgl_update` date DEFAULT NULL,
  `user_id` varchar(20) NOT NULL,
  `error_message` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `temp_import_keluar`
--
ALTER TABLE `temp_import_keluar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `temp_import_keluar`
--
ALTER TABLE `temp_import_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
