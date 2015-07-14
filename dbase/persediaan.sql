-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 14, 2015 at 10:22 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `persediaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

CREATE TABLE IF NOT EXISTS `bid` (
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `nm_bid` varchar(30) NOT NULL,
  PRIMARY KEY (`kd_bid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `brg`
--

CREATE TABLE IF NOT EXISTS `brg` (
  `kd_kbrg` varchar(20) NOT NULL,
  `kd_jbrg` varchar(10) NOT NULL,
  `kd_brg` varchar(20) NOT NULL,
  `nm_brg` varchar(30) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `kd_lokasi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gol`
--

CREATE TABLE IF NOT EXISTS `gol` (
  `kd_gol` varchar(10) NOT NULL,
  `nm_gol` varchar(30) NOT NULL,
  PRIMARY KEY (`kd_gol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jns_transaksi`
--

CREATE TABLE IF NOT EXISTS `jns_transaksi` (
  `kd_trans` varchar(10) NOT NULL,
  `jns_trans` varchar(10) NOT NULL,
  PRIMARY KEY (`kd_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kanwil`
--

CREATE TABLE IF NOT EXISTS `kanwil` (
  `kd_uapb` varchar(10) NOT NULL,
  `kd_uappbe1` varchar(10) NOT NULL,
  `kd_kanwil` varchar(5) NOT NULL,
  `nm_kanwil` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kel`
--

CREATE TABLE IF NOT EXISTS `kel` (
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `kd_kel` varchar(10) NOT NULL,
  `nm_kel` varchar(30) NOT NULL,
  PRIMARY KEY (`kd_kel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `kd_lokasi` varchar(30) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `level` varchar(2) NOT NULL,
  PRIMARY KEY (`kd_lokasi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `perk`
--

CREATE TABLE IF NOT EXISTS `perk` (
  `kd_perk` varchar(10) NOT NULL,
  `nm_perk` varchar(30) NOT NULL,
  PRIMARY KEY (`kd_perk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sedia`
--

CREATE TABLE IF NOT EXISTS `sedia` (
  `kd_lokasi` varchar(20) NOT NULL,
  `thn_ang` varchar(4) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `kd_brg` varchar(10) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `asal` varchar(20) NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `rph_sat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `skel`
--

CREATE TABLE IF NOT EXISTS `skel` (
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `kd_kel` varchar(10) NOT NULL,
  `kd_skel` varchar(10) NOT NULL,
  `nm_skel` varchar(30) NOT NULL,
  PRIMARY KEY (`kd_skel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sskel`
--

CREATE TABLE IF NOT EXISTS `sskel` (
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `kd_kel` varchar(10) NOT NULL,
  `kd_skel` varchar(10) NOT NULL,
  `kd_sskel` varchar(10) NOT NULL,
  `nm_sskel` varchar(30) NOT NULL,
  `kd_kbrg` varchar(20) NOT NULL,
  `kd_perk` varchar(15) NOT NULL,
  PRIMARY KEY (`kd_sskel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ttd`
--

CREATE TABLE IF NOT EXISTS `ttd` (
  `kd_lokasi` varchar(20) NOT NULL,
  `kota` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jabatan` varchar(25) NOT NULL,
  `nip2` varchar(20) NOT NULL,
  `nama2` varchar(30) NOT NULL,
  `jabatan2` varchar(25) NOT NULL,
  `tgl_isi` date NOT NULL,
  `tgl_setuju` date NOT NULL,
  `unit` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uakpb`
--

CREATE TABLE IF NOT EXISTS `uakpb` (
  `kd_uapb` varchar(4) NOT NULL,
  `kd_uappbe1` varchar(4) NOT NULL,
  `kd_uappbw` varchar(10) NOT NULL,
  `kd_uakpb` varchar(10) NOT NULL,
  `kd_uapkpb` varchar(5) NOT NULL,
  `jk` varchar(3) NOT NULL,
  `nm_uakpb` varchar(25) NOT NULL,
  `kd_lokasi` varchar(30) NOT NULL,
  PRIMARY KEY (`kd_uakpb`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uapb`
--

CREATE TABLE IF NOT EXISTS `uapb` (
  `kd_uapb` varchar(4) NOT NULL,
  `nm_uapb` varchar(30) NOT NULL,
  PRIMARY KEY (`kd_uapb`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uappbe1`
--

CREATE TABLE IF NOT EXISTS `uappbe1` (
  `kd_uapb` int(11) NOT NULL,
  `kd_uappbe1` int(11) NOT NULL,
  `nm_uappb` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uappbw`
--

CREATE TABLE IF NOT EXISTS `uappbw` (
  `kd_uapb` varchar(4) NOT NULL,
  `kd_uappb` varchar(11) NOT NULL,
  `kd_uappbw` varchar(10) NOT NULL,
  `nm_uappbw` varchar(30) NOT NULL,
  PRIMARY KEY (`kd_uappbw`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE IF NOT EXISTS `wilayah` (
  `kd_wil` varchar(10) NOT NULL,
  `nm_wil` varchar(20) NOT NULL,
  PRIMARY KEY (`kd_wil`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
