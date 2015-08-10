-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2015 at 11:09 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `persediaan_v3`
--
CREATE DATABASE IF NOT EXISTS `persediaan_v3` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `persediaan_v3`;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `id` int(11) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `rph_sat` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang_klr`
--

CREATE TABLE IF NOT EXISTS `barang_klr` (
  `id` int(11) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `rph_sat` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang_msk`
--

CREATE TABLE IF NOT EXISTS `barang_msk` (
  `id` int(11) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `rph_sat` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_msk`
--

INSERT INTO `barang_msk` (`id`, `no_dok`, `kd_brg`, `kuantitas`, `rph_sat`, `user_id`) VALUES
(10, '010100000KPA01', 'andreas', 5, 30000, 'fikri.fd'),
(11, 'rert', '101030600912', 4, 60000, 'fikri.fd');

-- --------------------------------------------------------

--
-- Table structure for table `barang_opsik`
--

CREATE TABLE IF NOT EXISTS `barang_opsik` (
  `id` int(11) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `rph_sat` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

CREATE TABLE IF NOT EXISTS `bid` (
  `id` int(11) NOT NULL,
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `nm_bid` varchar(30) NOT NULL,
  `kd_bidbrg` varchar(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bid`
--

INSERT INTO `bid` (`id`, `kd_gol`, `kd_bid`, `nm_bid`, `kd_bidbrg`) VALUES
(1, '1', '01', 'BARANG PAKAI HABIS            ', '101'),
(2, '1', '02', 'BARANG TAK HABIS PAKAI        ', '102'),
(3, '1', '03', 'BARANG BEKAS DIPAKAI          ', '103');

-- --------------------------------------------------------

--
-- Table structure for table `brg`
--

CREATE TABLE IF NOT EXISTS `brg` (
  `id` int(11) NOT NULL,
  `kd_kbrg` varchar(20) NOT NULL,
  `kd_jbrg` varchar(10) NOT NULL,
  `kd_brg` varchar(20) NOT NULL,
  `nm_brg` varchar(30) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `kd_perk` varchar(10) NOT NULL,
  `kd_lokasi` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brg`
--

INSERT INTO `brg` (`id`, `kd_kbrg`, `kd_jbrg`, `kd_brg`, `nm_brg`, `satuan`, `kd_perk`, `kd_lokasi`) VALUES
(1, '1010304007', '000002', '1010304007000002', 'Transcend Flash Drive', 'Buah', '115111', '001010100000000000KD'),
(2, '1010304008', '000001', '1010304008000001', 'Hardisk External', 'Buah', '115111', '001010100000000000KD'),
(4, '1020103006', '000001', '1020103006000001', 'BAKTOR TIZERA', 'UNIT', '115199', '113010155000000000KP'),
(5, '1010101006', '000001', '1010101006000001', 'NIPPON PAINT', 'UNIT', '115131', '113010155000000000KP'),
(6, '1010304999', '000001', '1010304999000001', 'LG LCD Dipslay', 'Buah', '115111', '113010155000000000KP'),
(7, '1010304999', '000002', '1010304999000002', 'CENTRAL PROCESSING UNIT', 'UNIT', '115111', '113010155000000000KP'),
(21, '1010301001', '11011', '101030100111011', 'FABER CASTELL PENCILS', 'Lusin', 'sementara', '018010100010111'),
(22, '1010101002', '001', '1010101002001', 'Semen Tiga Roda', 'Liter', 'sementara', '018010100010111'),
(23, '1010306009', '12', '101030600912', 'asd', 'asd', 'sementara', '018010100010111'),
(24, '1010306009', '12', '101030600912', 'asd', 'asd', 'sementara', '018010100010111'),
(25, '1010306009', '12', '101030600912', 'asd', 'asd', 'sementara', '018010100010111'),
(26, '1010306009', '32', '101030600932', '34', 'dd', 'sementara', '018010100010111'),
(27, '1010306999', 'asd', '1010306999asd', 'asd', 'asd', 'sementara', '018010100010111');

-- --------------------------------------------------------

--
-- Table structure for table `gol`
--

CREATE TABLE IF NOT EXISTS `gol` (
  `kd_gol` varchar(10) NOT NULL,
  `nm_gol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gol`
--

INSERT INTO `gol` (`kd_gol`, `nm_gol`) VALUES
('1', 'PERSEDIAAN');

-- --------------------------------------------------------

--
-- Table structure for table `jns_transaksi`
--

CREATE TABLE IF NOT EXISTS `jns_transaksi` (
  `kd_trans` varchar(10) NOT NULL,
  `jns_trans` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jns_transaksi`
--

INSERT INTO `jns_transaksi` (`kd_trans`, `jns_trans`) VALUES
('H01', 'Hapus Usang'),
('H02', 'Hapus Rusak'),
('K01', 'Habis Pakai'),
('K02', 'Transfer Keluar'),
('K03', 'Hibah Keluar'),
('K04', 'Barang Usang'),
('K05', 'Barang Rusak'),
('K06', 'Penghapusan Lainnya'),
('K99', 'Koreksi Kurang'),
('M01', 'Saldo Awal'),
('M02', 'Pembelian'),
('M03', 'Transfer Masuk'),
('M04', 'Hibah (Masuk)'),
('M05', 'Rampasan'),
('M06', 'Perolehan Lainnya'),
('M09', 'Koreksi Hasil Migras'),
('M99', 'Koreksi Tambah'),
('P01', 'Hasil Opname Fisik');

-- --------------------------------------------------------

--
-- Table structure for table `kanwil`
--

CREATE TABLE IF NOT EXISTS `kanwil` (
  `id` int(11) NOT NULL,
  `kd_uapb` varchar(10) NOT NULL,
  `kd_uappbe1` varchar(10) NOT NULL,
  `kd_kanwil` varchar(5) NOT NULL,
  `nm_kanwil` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kanwil`
--

INSERT INTO `kanwil` (`id`, `kd_uapb`, `kd_uappbe1`, `kd_kanwil`, `nm_kanwil`) VALUES
(1, '015', '09', '001', 'KANWIL  I DJKN BANDA ACEH     '),
(2, '015', '09', '002', 'KANWIL II DJKN MEDAN          '),
(3, '015', '09', '003', 'KANWIL III DJKN PEKANBARU     '),
(4, '015', '09', '004', 'KANWIL IV DJKN PALEMBANG      '),
(5, '015', '09', '005', 'KANWIL V DJKN BANDAR LAMPUNG  '),
(6, '015', '09', '006', 'KANWIL VI DJKN SERANG         '),
(7, '015', '09', '007', 'KANWIL VII DJKN JAKARTA       '),
(8, '015', '09', '008', 'KANWIL VIII DJKN BANDUNG      '),
(9, '015', '09', '009', 'KANWIL IX DJKN SEMARANG       '),
(10, '015', '09', '010', 'KANWIL X DJKN SURABAYA        '),
(11, '015', '09', '011', 'KANWIL XI DJKN PONTIANAK      '),
(12, '015', '09', '012', 'KANWIL XII DJKN BANJARMASIN   '),
(13, '015', '09', '013', 'KANWIL XIII DJKN SAMARINDA    '),
(14, '015', '09', '014', 'KANWIL XIV DJKN DENPASAR      '),
(15, '015', '09', '015', 'KANWIL XV DJKN MAKASAR        '),
(16, '015', '09', '016', 'KANWIL XVI DJKN MANADO        '),
(17, '015', '09', '017', 'KANWIL XVII DJKN JAYAPURA     '),
(18, '015', '04', '010', 'Kantor Wilayah DJP Nangroe Ace'),
(19, '015', '04', '020', 'Kantor Wilayah DJP Sumatera Ut'),
(20, '015', '04', '030', 'Kantor Wilayah DJP Sumatera Ut'),
(21, '015', '04', '040', 'Kantor Wilayah DJP Riau dan Ke'),
(22, '015', '04', '050', 'Kantor Wilayah DJP Sumatera Ba'),
(23, '015', '04', '060', 'Kantor Wilayah DJP Sumatera Se'),
(24, '015', '04', '070', 'Kantor Wilayah DJP Bengkulu da'),
(25, '015', '04', '080', 'Kantor Wilayah DJP Jakarta Pus'),
(26, '015', '04', '090', 'Kantor Wilayah DJP Jakarta Bar'),
(27, '015', '04', '100', 'Kantor Wilayah DJP Jakarta Sel'),
(28, '015', '04', '110', 'Kantor Wilayah DJP Jakarta Tim'),
(29, '015', '04', '120', 'Kantor Wilayah DJP Jakarta Uta'),
(30, '015', '04', '130', 'Kantor Wilayah DJP Jakarta Khu'),
(31, '015', '04', '140', 'Kantor Wilayah DJP Banten     '),
(32, '015', '04', '150', 'Kantor Wilayah DJP Jawa Barat '),
(33, '015', '04', '160', 'Kantor Wilayah DJP Jawa Barat '),
(34, '015', '04', '170', 'Kantor Wilayah DJP Jawa Tengah'),
(35, '015', '04', '180', 'Kantor Wilayah DJP Jawa Tengah'),
(36, '015', '04', '190', 'Kantor Wilayah DJP Daerah Isti'),
(37, '015', '04', '200', 'Kantor Wilayah DJP Jawa Timur '),
(38, '015', '04', '210', 'Kantor Wilayah DJP Jawa Timur '),
(39, '015', '04', '220', 'Kantor Wilayah DJP Jawa Timur '),
(40, '015', '04', '230', 'Kantor Wilayah DJP Kalimantan '),
(41, '015', '04', '240', 'Kantor Wilayah DJP Kalimantan '),
(42, '015', '04', '250', 'Kantor Wilayah DJP Kalimantan '),
(43, '015', '04', '260', 'Kantor Wilayah DJP Sulawesi Se'),
(44, '015', '04', '270', 'Kantor Wilayah DJP Sulawesi Ut'),
(45, '015', '04', '280', 'Kantor Wilayah DJP Bali       '),
(46, '015', '04', '290', 'Kantor Wilayah DJP Nusa Tengga'),
(47, '015', '04', '300', 'Kantor Wilayah DJP Papua dan M'),
(48, '015', '04', '310', 'Kantor Wilayah DJp Wajib Pajak'),
(49, '015', '05', '001', 'Kanwil DJBC Nangroe Aceh Darus'),
(50, '015', '05', '002', 'Kanwil DJBC  Sumatera Utara   '),
(51, '015', '05', '003', 'Kanwil DJBC Riau dan Sumatera '),
(52, '015', '05', '004', 'Kanwil DJBC Kepulauan Riau    '),
(53, '015', '05', '005', 'Kanwil DJBC Sumatera Bagian Se'),
(54, '015', '05', '006', 'Kanwil DJBC Banten            '),
(55, '015', '05', '007', 'Kanwil DJBC Jakarta           '),
(56, '015', '05', '008', 'Kanwil DJBC Jawa Barat        '),
(57, '015', '05', '009', 'Kanwil DJBC Jawa Tengah dan DI'),
(58, '015', '05', '010', 'Kanwil DJBC Jawa Timur I      '),
(59, '015', '05', '011', 'Kanwil DJBC  Jawa Timur II    '),
(60, '015', '05', '012', 'Kanwil DJBC Bali, NTB, dan NTT'),
(61, '015', '05', '013', 'Kanwil DJBC Kalimantan Bagian '),
(62, '015', '05', '014', 'Kanwil DJBC Kalimantan Bagian '),
(63, '015', '05', '015', 'Kanwil DJBC Sulawesi          '),
(64, '015', '05', '016', 'Kanwil DJBC Maluku, Papua dan '),
(65, '015', '08', '001', 'Kanwil  I  Banda Aceh         '),
(66, '015', '08', '002', 'Kanwil  II  Medan             '),
(67, '015', '08', '003', 'Kanwil  III  Padang           '),
(68, '015', '08', '004', 'Kanwil  IV  Pekanbaru         '),
(69, '015', '08', '005', 'Kanwil  V  Jambi              '),
(70, '015', '08', '006', 'Kanwil  VI  Palembang         '),
(71, '015', '08', '007', 'Kanwil  VII  Bandar Lampung   '),
(72, '015', '08', '008', 'Kanwil  VIII  Bengkulu        '),
(73, '015', '08', '009', 'Kanwil  IX  Pangkal Pinang    '),
(74, '015', '08', '010', 'Kanwil  X  Serang             '),
(75, '015', '08', '011', 'Kanwil  XI  Jakarta           '),
(76, '015', '08', '012', 'Kanwil  XII  Bandung          '),
(77, '015', '08', '013', 'Kanwil  XIII  Semarang        '),
(78, '015', '08', '014', 'Kanwil  XIV  Yogyakarta       '),
(79, '015', '08', '015', 'Kanwil  XV  Surabaya          '),
(80, '015', '08', '016', 'Kanwil  XVI  Pontianak        '),
(81, '015', '08', '017', 'Kanwil  XVII  Palangkaraya    '),
(82, '015', '08', '018', 'Kanwil  XVIII  Banjarmasin    '),
(83, '015', '08', '019', 'Kanwil  XIX  Samarinda        '),
(84, '015', '08', '020', 'Kanwil  XX  Denpasar          '),
(85, '015', '08', '021', 'Kanwil  XXI  Mataram          '),
(86, '015', '08', '022', 'Kanwil  XXII  Kupang          '),
(87, '015', '08', '023', 'Kanwil  XXIII  Makassar       '),
(88, '015', '08', '024', 'Kanwil  XXIV  Palu            '),
(89, '015', '08', '025', 'Kanwil  XXV  Kendari          '),
(90, '015', '08', '026', 'Kanwil  XXVI  Gorontalo       '),
(91, '015', '08', '027', 'Kanwil  XXVII  Manado         '),
(92, '015', '08', '029', 'Kanwil  XXIX  Ambon           '),
(93, '015', '08', '030', 'Kanwil  XXX  Jayapura         '),
(94, '123', '01', '920', 'Dummy Data');

-- --------------------------------------------------------

--
-- Table structure for table `kel`
--

CREATE TABLE IF NOT EXISTS `kel` (
  `id` int(11) NOT NULL,
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `kd_kel` varchar(10) NOT NULL,
  `nm_kel` varchar(30) NOT NULL,
  `kd_kelbrg` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kel`
--

INSERT INTO `kel` (`id`, `kd_gol`, `kd_bid`, `kd_kel`, `nm_kel`, `kd_kelbrg`) VALUES
(1, '1', '01', '01', 'BAHAN                         ', '10101'),
(2, '1', '01', '02', 'SUKU CADANG                   ', '10102'),
(3, '1', '01', '03', 'ALAT/BAHAN UNTUK KEGIATAN KANT', '10103'),
(4, '1', '01', '04', 'OBAT-OBATAN                   ', '10104'),
(5, '1', '01', '05', 'PERSEDIAAN UNTUK DIJUAL/DISERA', '10105'),
(6, '1', '01', '06', 'PERSEDIAAN UNTUK TUJUAN STRATE', '10106'),
(7, '1', '01', '07', 'NATURA DAN PAKAN              ', '10107'),
(8, '1', '01', '08', 'PERSEDIAAN PENELITIAN BIOLOGI ', '10108');

-- --------------------------------------------------------

--
-- Table structure for table `opsik`
--

CREATE TABLE IF NOT EXISTS `opsik` (
  `id` int(11) NOT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `thn_ang` varchar(4) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `opsik`
--

INSERT INTO `opsik` (`id`, `kd_lokasi`, `thn_ang`, `no_dok`, `tgl_dok`, `tgl_buku`, `no_bukti`, `jns_trans`, `keterangan`, `user_id`) VALUES
(5, '1130257010001', '2015', 'wef', '2015-08-13', '2015-08-06', 'df', 'P01', 'sDFsdf', 'fikri.fd');

-- --------------------------------------------------------

--
-- Table structure for table `perk`
--

CREATE TABLE IF NOT EXISTS `perk` (
  `kd_perk` varchar(10) NOT NULL,
  `nm_perk` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `perk`
--

INSERT INTO `perk` (`kd_perk`, `nm_perk`) VALUES
('115111', 'Barang Konsumsi               '),
('115112', 'Amunisi                       '),
('115113', 'Bahan untuk Pemeliharaan      '),
('115114', 'Suku Cadang                   '),
('115121', 'Pita Cukai, Materai dan Leges '),
('115122', 'Tanah Bangunan untuk dijual at'),
('115123', 'Hewan dan Tanaman untuk dijual'),
('115124', 'Peralatan dan Mesin untuk diju'),
('115125', 'Jalan, Irigasi dan Jaringan un'),
('115126', 'Aset Tetap Lainnya untuk diser'),
('115127', 'Aset Lain-Lain untuk diserahka'),
('115128', 'Barang Lainnya Untuk dijual at'),
('115131', 'Bahan Baku                    '),
('115132', 'Barang dalam Proses           '),
('115191', 'Persediaan untuk tujuan strate'),
('115192', 'Persediaan Barang Hasil Sitaan'),
('115199', 'Persediaan Lainnya            '),
('115211', 'Persediaan BLU Pelayanan Keseh'),
('115212', 'Persediaan BLU Pelayanan Pendi'),
('115213', 'Persediaan BLU penunjang Konst'),
('115214', 'Persediaan BLU Penyedian Jasa '),
('115219', 'Persediaan BLU Penyedian Baran'),
('115221', 'Persediaan BLU Pengelola Kawas'),
('115222', 'Persediaan BLU Pengelola Kawas'),
('115229', 'Persediaan BLU Pengelola Kawas'),
('115231', 'Persediaan BLU Pengelola Dana '),
('115232', 'Persediaan BLU Pengelola Dana '),
('115239', 'Persediaan BLU Pengelola Dana '),
('131111', 'Tanah                         '),
('131211', 'Tanah Sebelum Disesuaikan     '),
('131311', 'Peralatan dan Mesin           '),
('131411', 'Peralatan dan Mesin Sebelum Di'),
('131511', 'Gedung dan Bangunan           '),
('131611', 'Gedung dan Bangunan Sebelum Di'),
('131711', 'Jalan dan Jembatan            '),
('131712', 'Irigasi                       '),
('131713', 'Jaringan                      '),
('131811', 'Jalan dan Jembatan Sebelum Dis'),
('131812', 'Irigasi Sebelum Disesuaikan   '),
('131813', 'Jaringan Sebelum Disesuaikan  '),
('131911', 'Aset Tetap dalam Renovasi     '),
('131921', 'Aset Tetap Lainnya            '),
('132111', 'Konstruksi Dalam pengerjaan   '),
('133111', 'Akumulasi Penyusutan Peralatan'),
('133121', 'Akumulasi Penyusutan Gedung da'),
('133131', 'Akumulasi Penyusutan Jalan dan'),
('133132', 'Akumulasi Penyusutan Jaringan '),
('133141', 'Akumulasi Penyusutan Aset Teta'),
('135111', 'Tanah                         '),
('135121', 'Akumulasi Penyusutan Peralatan'),
('135211', 'Peralatan dan Mesin           '),
('135311', 'Gedung dan Bangunan           '),
('135321', 'Akumulasi Penyusutan Gedung da'),
('135411', 'Jalan, Irigasi, dan Jaringan  '),
('135421', 'Akumulasi Penyusutan Jalan,Iri'),
('135511', 'Aset Tetap Lainnya            '),
('135521', 'Akumulasi Penyusutan Aset Teta'),
('135611', 'Konstruksi Dalam Pengerjaan Ba'),
('153111', 'Goodwill                      '),
('153121', 'Hak Cipta                     '),
('153131', 'Royalti                       '),
('153141', 'Paten                         '),
('153151', 'Software'),
('153161', 'Lisensi'),
('153171', 'Hasil Kajian/Penelitian   '),
('153191', 'Aset Tak Berwujud Lainnya     '),
('153211', 'Software-Badan Layanan Umum   '),
('153221', 'Hak Cipta BLU                 '),
('153231', 'Royalti BLU                   '),
('153241', 'Paten BLU                     '),
('153291', 'Aset Tak Berwujud Lainnya-Bada'),
('154111', 'Aset Lain-lain                '),
('154112', 'Aset Tetap yang tidak digunaka'),
('154411', 'Aset Lain-lain-Badan Layanan U'),
('154412', 'Aset Tetap yang tidak digunaka');

-- --------------------------------------------------------

--
-- Table structure for table `satker`
--

CREATE TABLE IF NOT EXISTS `satker` (
  `id` int(11) NOT NULL,
  `kd_uapb` varchar(4) NOT NULL,
  `kd_uappbe1` varchar(4) DEFAULT NULL,
  `kd_uappbw` varchar(10) DEFAULT NULL,
  `kd_uakpb` varchar(10) DEFAULT NULL,
  `kd_uapkpb` varchar(5) DEFAULT NULL,
  `jk` varchar(3) DEFAULT NULL,
  `kd_jk` varchar(32) DEFAULT NULL,
  `nm_satker` varchar(40) DEFAULT NULL,
  `kode` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=409 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satker`
--

INSERT INTO `satker` (`id`, `kd_uapb`, `kd_uappbe1`, `kd_uappbw`, `kd_uakpb`, `kd_uapkpb`, `jk`, `kd_jk`, `nm_satker`, `kode`) VALUES
(1, '001', NULL, NULL, NULL, NULL, NULL, '', 'MAJELIS PERMUSYAWARATAN RAKYAT', '001'),
(2, '002', NULL, NULL, NULL, NULL, '', '', 'DEWAN PERWAKILAN RAKYAT', '002'),
(3, '004', NULL, NULL, NULL, NULL, '', '', 'BADAN PEMERIKSA KEUANGAN', '004'),
(4, '005', NULL, NULL, NULL, NULL, '', '', 'MAHKAMAH AGUNG', '005'),
(5, '006', NULL, NULL, NULL, NULL, '', '', 'KEJAKSAAN REPUBLIK INDONESIA', '006'),
(6, '007', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN SEKRETARIAT NEGARA', '007'),
(7, '010', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN DALAM  NEGERI', '010'),
(8, '011', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN LUAR NEGERI', '011'),
(9, '012', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PERTAHANAN', '012'),
(10, '013', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA', '013'),
(11, '015', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KEUANGAN', '015'),
(12, '018', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PERTANIAN', '018'),
(13, '019', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PERINDUSTRIAN', '019'),
(14, '020', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN ENERGI DAN SUMBER DAYA MINER', '020'),
(15, '022', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PERHUBUNGAN', '022'),
(16, '023', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PENDIDIKAN NASIONAL', '023'),
(17, '024', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KESEHATAN', '024'),
(18, '025', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN AGAMA', '025'),
(19, '026', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN TENAGA KERJA DAN TRANSMIGRAS', '026'),
(20, '027', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN SOSIAL', '027'),
(21, '029', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KEHUTANAN', '029'),
(22, '032', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KELAUTAN DAN PERIKANAN', '032'),
(23, '033', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PEKERJAAN UMUM', '033'),
(24, '034', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KOORDINATOR BIDANG POLITIK,', '034'),
(25, '035', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KOORDINATOR BIDANG PEREKONOM', '035'),
(26, '036', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KOORDINATOR BIDANG KESEJAHTE', '036'),
(27, '040', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KEBUDAYAAN DAN PARIWISATA', '040'),
(28, '041', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN BADAN USAHA MILIK NEGARA', '041'),
(29, '042', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN RISET DAN TEKNOLOGI', '042'),
(30, '043', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN LINGKUNGAN HIDUP', '043'),
(31, '044', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KOPERASI DAN PENGUSAHA KECIL', '044'),
(32, '047', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PEMBERDAYAAN PEREMPUAN DAN P', '047'),
(33, '048', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PENDAYAGUNAAN APARATUR NEGAR', '048'),
(34, '050', NULL, NULL, NULL, NULL, '', '', 'BADAN INTELIJEN NEGARA', '050'),
(35, '051', NULL, NULL, NULL, NULL, '', '', 'LEMBAGA SANDI NEGARA', '051'),
(36, '052', NULL, NULL, NULL, NULL, '', '', 'DEWAN KETAHANAN NASIONAL', '052'),
(37, '054', NULL, NULL, NULL, NULL, '', '', 'BADAN PUSAT STATISTIK', '054'),
(38, '055', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PERENCANAAN PEMBANGUNAN NASI', '055'),
(39, '056', NULL, NULL, NULL, NULL, '', '', 'BADAN PERTANAHAN NASIONAL', '056'),
(40, '057', NULL, NULL, NULL, NULL, '', '', 'PERPUSTAKAAN NASIONAL REPUBLIK INDONESIA', '057'),
(41, '059', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN KOMUNIKASI DAN INFORMATIKA', '059'),
(42, '060', NULL, NULL, NULL, NULL, '', '', 'KEPOLISIAN NEGARA REPUBLIK INDONESIA', '060'),
(43, '061', NULL, NULL, NULL, NULL, '', '', 'CICILAN BUNGA HUTANG', '061'),
(44, '062', NULL, NULL, NULL, NULL, '', '', 'SUBSIDI DAN TRANSFER', '062'),
(45, '063', NULL, NULL, NULL, NULL, '', '', 'BADAN PENGAWAS OBAT DAN MAKANAN', '063'),
(46, '064', NULL, NULL, NULL, NULL, '', '', 'LEMBAGA KETAHANAN NASIONAL', '064'),
(47, '065', NULL, NULL, NULL, NULL, '', '', 'BADAN KOORDINASI PENANAMAN MODAL', '065'),
(48, '066', NULL, NULL, NULL, NULL, '', '', 'BADAN NARKOTIKA NASIONAL', '066'),
(49, '067', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PEMBANGUNAN DAERAH TERTINGGA', '067'),
(50, '068', NULL, NULL, NULL, NULL, '', '', 'BADAN KOORDINASI KELUARGA BERENCANA NASI', '068'),
(51, '069', NULL, NULL, NULL, NULL, '', '', 'BELANJA LAIN-LAIN', '069'),
(52, '070', NULL, NULL, NULL, NULL, '', '', 'DANA PERIMBANGAN', '070'),
(53, '071', NULL, NULL, NULL, NULL, '', '', 'DANA OTONOMI KHUSUS PENYEIMBANG', '071'),
(54, '074', NULL, NULL, NULL, NULL, '', '', 'KOMISI NASIONAL HAK ASASI MANUSIA', '074'),
(55, '075', NULL, NULL, NULL, NULL, '', '', 'BADAN METEOROLOGI, KLIMATOLOGI DAN GEOFI', '075'),
(56, '076', NULL, NULL, NULL, NULL, '', '', 'KOMISI PEMILIHAN UMUM', '076'),
(57, '077', NULL, NULL, NULL, NULL, '', '', 'MAHKAMAH KONSTITUSI RI', '077'),
(58, '078', NULL, NULL, NULL, NULL, '', '', 'PUSAT PELAPORAN DAN ANALISIS TRANSAKSI K', '078'),
(59, '079', NULL, NULL, NULL, NULL, '', '', 'LEMBAGA ILMU PENGETAHUAN INDONESIA', '079'),
(60, '080', NULL, NULL, NULL, NULL, '', '', 'BADAN TENAGA NUKLIR NASIONAL', '080'),
(61, '081', NULL, NULL, NULL, NULL, '', '', 'BADAN PENGKAJIAN DAN PENERAPAN TEKNOLOGI', '081'),
(62, '082', NULL, NULL, NULL, NULL, '', '', 'LEMBAGA PENERBANGAN DAN ANTARIKSA NASION', '082'),
(63, '083', NULL, NULL, NULL, NULL, '', '', 'BADAN KOORDINASI SURVEI DAN PEMETAAN NAS', '083'),
(64, '084', NULL, NULL, NULL, NULL, '', '', 'BADAN STANDARISASI NASIONAL', '084'),
(65, '085', NULL, NULL, NULL, NULL, '', '', 'BADAN PENGAWAS TENAGA NUKLIR', '085'),
(66, '086', NULL, NULL, NULL, NULL, '', '', 'LEMBAGA ADMINISTRASI NEGARA', '086'),
(67, '087', NULL, NULL, NULL, NULL, '', '', 'ARSIP NASIONAL REPUBLIK INDONESIA', '087'),
(68, '088', NULL, NULL, NULL, NULL, '', '', 'BADAN KEPEGAWAIAN NEGARA', '088'),
(69, '089', NULL, NULL, NULL, NULL, '', '', 'BADAN PENGAWASAN  KEUANGAN DAN PEMBANGUN', '089'),
(70, '090', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PERDAGANGAN', '090'),
(71, '091', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PERUMAHAN RAKYAT', '091'),
(72, '092', NULL, NULL, NULL, NULL, '', '', 'KEMENTERIAN PEMUDA DAN OLAH RAGA', '092'),
(73, '093', NULL, NULL, NULL, NULL, '', '', 'KOMISI PEMBERANTASAN KORUPSI', '093'),
(74, '095', NULL, NULL, NULL, NULL, '', '', 'DEWAN PERWAKILAN DAERAH (DPD)', '095'),
(75, '096', NULL, NULL, NULL, NULL, '', '', 'PEMBAYARAN CICILAN POKOK HUTANG LUAR NEG', '096'),
(76, '097', NULL, NULL, NULL, NULL, '', '', 'PEMBAYARAN CICILAN POKOK HUTANG DALAM NE', '097'),
(77, '098', NULL, NULL, NULL, NULL, '', '', 'PENERUSAN PINJAMAN', '098'),
(78, '099', NULL, NULL, NULL, NULL, '', '', 'PENYERTAAN MODAL NEGARA', '099'),
(79, '100', NULL, NULL, NULL, NULL, '', '', 'KOMISI YUDISIAL RI', '100'),
(80, '101', NULL, NULL, NULL, NULL, '', '', 'PENERUSAN PINJAMAN SEBAGAI HIBAH', '101'),
(81, '102', NULL, NULL, NULL, NULL, '', '', 'PENERUSAN  HIBAH', '102'),
(82, '103', NULL, NULL, NULL, NULL, '', '', 'BADAN NASIONAL PENANGGULANGAN BENCANA', '103'),
(83, '104', NULL, NULL, NULL, NULL, '', '', 'BADAN NASIONAL PENEMPATAN DAN PERLINDUNG', '104'),
(84, '105', NULL, NULL, NULL, NULL, '', '', 'BADAN PENANGGULANGAN LUMPUR SIDOARJO (BP', '105'),
(85, '106', NULL, NULL, NULL, NULL, '', '', 'LEMBAGA KEBIJAKAN PENGADAAN BARANG/JASA', '106'),
(86, '107', NULL, NULL, NULL, NULL, '', '', 'BADAN SAR NASIONAL', '107'),
(87, '108', NULL, NULL, NULL, NULL, '', '', 'KOMISI PENGAWAS PERSAINGAN USAHA', '108'),
(88, '109', NULL, NULL, NULL, NULL, '', '', 'BADAN PENGEMBANGAN WILAYAH SURAMADU', '109'),
(89, '110', NULL, NULL, NULL, NULL, '', '', 'OMBUDSMAN REPUBLIK INDONESIA', '110'),
(90, '111', NULL, NULL, NULL, NULL, '', '', 'BADAN NASIONAL PENGELOLA PERBATASAN', '111'),
(91, '999', NULL, NULL, NULL, NULL, '', '', 'BENDAHARA UMUM NEGARA', '999'),
(92, '008', NULL, NULL, NULL, NULL, '', '', 'WAKIL PRESIDEN', '008'),
(93, '053', NULL, NULL, NULL, NULL, '', '', 'BADAN URUSAN LOGISTIK', '053'),
(94, '094', NULL, NULL, NULL, NULL, '', '', 'BADAN  REHABILITASI DAN REKONSTRUKSI NAD', '094'),
(95, '001', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '001.01'),
(96, '001', '02', NULL, NULL, NULL, '', '', 'M A J E L I S', '001.02'),
(97, '002', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '002.01'),
(98, '002', '02', NULL, NULL, NULL, '', '', 'D E W A N', '002.02'),
(99, '004', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '004.01'),
(100, '004', '02', NULL, NULL, NULL, '', '', 'B. P. K.  PUSAT', '004.02'),
(101, '005', '01', NULL, NULL, NULL, '', '', 'BADAN URUSAN ADMINISTRASI', '005.01'),
(102, '005', '02', NULL, NULL, NULL, '', '', 'KEPANITERAAN', '005.02'),
(103, '005', '03', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL BADAN', '005.03'),
(104, '005', '04', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL BADAN', '005.04'),
(105, '005', '05', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL BADAN', '005.05'),
(106, '005', '06', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '005.06'),
(107, '005', '07', NULL, NULL, NULL, '', '', 'BADAN PENGAWASAN MAHKAMAH', '005.07'),
(108, '006', '01', NULL, NULL, NULL, '', '', 'KEJAKSAAN REPUBLIK INDONE', '006.01'),
(109, '007', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT NEGARA', '007.01'),
(110, '007', '02', NULL, NULL, NULL, '', '', 'SEKRETARIAT KABINET', '007.02'),
(111, '007', '03', NULL, NULL, NULL, '', '', 'RUMAH TANGGA KEPRESIDENAN', '007.03'),
(112, '007', '04', NULL, NULL, NULL, '', '', 'SEKRETARIAT WAKIL PRESIDE', '007.04'),
(113, '007', '05', NULL, NULL, NULL, '', '', 'SEKRETARIAT MILITER PRESIDEN', '007.05'),
(114, '007', '06', NULL, NULL, NULL, '', '', 'PASUKAN PENGAMANAN PRESIDEN', '007.06'),
(115, '007', '07', NULL, NULL, NULL, '', '', 'DEWAN PERTIMBANGAN PRESID', '007.07'),
(116, '007', '08', NULL, NULL, NULL, '', '', 'UNIT KERJA PRESIDEN BD.PE', '007.08'),
(117, '007', '09', NULL, NULL, NULL, '', '', 'LEMBAGA PERLINDUNGAN SAKS', '007.09'),
(118, '010', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '010.01'),
(119, '010', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '010.02'),
(120, '010', '03', NULL, NULL, NULL, '', '', 'DITJEN KESATUAN BANGSA DA', '010.03'),
(121, '010', '04', NULL, NULL, NULL, '', '', 'DITJEN PEMERINTAHAN UMUM', '010.04'),
(122, '010', '05', NULL, NULL, NULL, '', '', 'DITJEN PEMBERDAYAAN MASYA', '010.05'),
(123, '010', '06', NULL, NULL, NULL, '', '', 'DITJEN BINA PEMBANGUNAN D', '010.06'),
(124, '010', '07', NULL, NULL, NULL, '', '', 'DITJEN OTONOMI DAERAH', '010.07'),
(125, '010', '08', NULL, NULL, NULL, '', '', 'DITJEN KEPENDUDUKAN DAN P', '010.08'),
(126, '010', '09', NULL, NULL, NULL, '', '', 'DITJEN KEUANGAN DAERAH', '010.09'),
(127, '010', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '010.11'),
(128, '010', '12', NULL, NULL, NULL, '', '', 'BADAN PENDIDIKAN DAN PELA', '010.12'),
(129, '011', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '011.01'),
(130, '011', '02', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL ASIA', '011.02'),
(131, '011', '03', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL AMERI', '011.03'),
(132, '011', '04', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL KERJA', '011.04'),
(133, '011', '05', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL MULTI', '011.05'),
(134, '011', '06', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL INFOR', '011.06'),
(135, '011', '07', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL HUKUM', '011.07'),
(136, '011', '08', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL PROTO', '011.08'),
(137, '011', '09', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '011.09'),
(138, '011', '11', NULL, NULL, NULL, '', '', 'BADAN PENGKAJIAN DAN PENG', '011.11'),
(139, '012', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN PERTAHANAN', '012.01'),
(140, '012', '21', NULL, NULL, NULL, '', '', 'MARKAS BESAR TNI', '012.21'),
(141, '012', '22', NULL, NULL, NULL, '', '', 'MARKAS BESAR TNI AD', '012.22'),
(142, '012', '23', NULL, NULL, NULL, '', '', 'MARKAS BESAR TNI AL', '012.23'),
(143, '012', '24', NULL, NULL, NULL, '', '', 'MARKAS BESAR TNI AU', '012.24'),
(144, '013', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '013.01'),
(145, '013', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '013.02'),
(146, '013', '03', NULL, NULL, NULL, '', '', 'DITJEN ADMINISTRASI HUKUM', '013.03'),
(147, '013', '05', NULL, NULL, NULL, '', '', 'DITJEN PEMASYARAKATAN', '013.05'),
(148, '013', '06', NULL, NULL, NULL, '', '', 'DITJEN IMIGRASI', '013.06'),
(149, '013', '07', NULL, NULL, NULL, '', '', 'DITJEN HAK ATAS KEKAYAAN', '013.07'),
(150, '013', '08', NULL, NULL, NULL, '', '', 'DITJEN PERATURAN PERUNDAN', '013.08'),
(151, '013', '09', NULL, NULL, NULL, '', '', 'DITJEN HAK ASASI MANUSIA', '013.09'),
(152, '013', '10', NULL, NULL, NULL, '', '', 'BADAN PEMBINAAN HUKUM NAS', '013.10'),
(153, '013', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '013.11'),
(154, '013', '12', NULL, NULL, NULL, '', '', 'BADAN PENGEMBANGAN SUMBER', '013.12'),
(155, '015', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '015.01'),
(156, '015', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '015.02'),
(157, '015', '03', NULL, NULL, NULL, '', '', 'DITJEN ANGGARAN', '015.03'),
(158, '015', '04', NULL, NULL, NULL, '', '', 'DITJEN PAJAK', '015.04'),
(159, '015', '05', NULL, NULL, NULL, '', '', 'DITJEN BEA DAN CUKAI', '015.05'),
(160, '015', '06', NULL, NULL, NULL, '', '', 'DITJEN PERIMBANGAN KEUANG', '015.06'),
(161, '015', '07', NULL, NULL, NULL, '', '', 'DITJEN PENGELOLAAN UTANG', '015.07'),
(162, '015', '08', NULL, NULL, NULL, '', '', 'DITJEN PERBENDAHARAAN', '015.08'),
(163, '015', '09', NULL, NULL, NULL, '', '', 'DITJEN KEKAYAAN NEGARA', '015.09'),
(164, '015', '10', NULL, NULL, NULL, '', '', 'BADAN PENGAWAS PASAR MODA', '015.10'),
(165, '015', '11', NULL, NULL, NULL, '', '', 'BADAN PENDIDIKAN DAN PELA', '015.11'),
(166, '015', '12', NULL, NULL, NULL, '', '', 'BADAN KEBIJAKAN FISKAL', '015.12'),
(167, '018', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '018.01'),
(168, '018', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '018.02'),
(169, '018', '03', NULL, NULL, NULL, '', '', 'DITJEN TANAMAN PANGAN', '018.03'),
(170, '018', '04', NULL, NULL, NULL, '', '', 'DITJEN HORTIKULTURA', '018.04'),
(171, '018', '05', NULL, NULL, NULL, '', '', 'DITJEN PERKEBUNAN', '018.05'),
(172, '018', '06', NULL, NULL, NULL, '', '', 'DITJEN PETERNAKAN DAN KES', '018.06'),
(173, '018', '07', NULL, NULL, NULL, '', '', 'DITJEN PENGOLAHAN DAN PEM', '018.07'),
(174, '018', '08', NULL, NULL, NULL, '', '', 'DITJEN PRASARANA DAN SARA', '018.08'),
(175, '018', '09', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '018.09'),
(176, '018', '10', NULL, NULL, NULL, '', '', 'BADAN PENYULUHAN DAN PENG', '018.10'),
(177, '018', '11', NULL, NULL, NULL, '', '', 'BADAN KETAHANAN PANGAN', '018.11'),
(178, '018', '12', NULL, NULL, NULL, '', '', 'BADAN KARANTINA PERTANIAN', '018.12'),
(179, '019', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '019.01'),
(180, '019', '02', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL INDUS', '019.02'),
(181, '019', '03', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL BASIS', '019.03'),
(182, '019', '04', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL INDUS', '019.04'),
(183, '019', '05', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL INDUS', '019.05'),
(184, '019', '06', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '019.06'),
(185, '019', '07', NULL, NULL, NULL, '', '', 'BADAN PENGKAJIAN KEBIJAKA', '019.07'),
(186, '019', '08', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL PENGE', '019.08'),
(187, '019', '09', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL KERJA', '019.09'),
(188, '020', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '020.01'),
(189, '020', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '020.02'),
(190, '020', '04', NULL, NULL, NULL, '', '', 'DITJEN MINYAK DAN GAS BUM', '020.04'),
(191, '020', '05', NULL, NULL, NULL, '', '', 'DITJEN KETENAGALISTRIKAN', '020.05'),
(192, '020', '06', NULL, NULL, NULL, '', '', 'DITJEN MINERAL DAN BUDIDA', '020.06'),
(193, '020', '07', NULL, NULL, NULL, '', '', 'DEWAN ENERGI NASIONAL', '020.07'),
(194, '020', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '020.11'),
(195, '020', '12', NULL, NULL, NULL, '', '', 'BADAN DIKLAT ENERGI DAN S', '020.12'),
(196, '020', '13', NULL, NULL, NULL, '', '', 'BADAN GEOLOGI', '020.13'),
(197, '020', '14', NULL, NULL, NULL, '', '', 'BPH MIGAS', '020.14'),
(198, '020', '15', NULL, NULL, NULL, '', '', 'DITJEN ENERGI BARU TERBAR', '020.15'),
(199, '022', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '022.01'),
(200, '022', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '022.02'),
(201, '022', '03', NULL, NULL, NULL, '', '', 'DITJEN PERHUBUNGAN DARAT', '022.03'),
(202, '022', '04', NULL, NULL, NULL, '', '', 'DITJEN PERHUBUNGAN LAUT', '022.04'),
(203, '022', '05', NULL, NULL, NULL, '', '', 'DITJEN PERHUBUNGAN UDARA', '022.05'),
(204, '022', '08', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL PERKE', '022.08'),
(205, '022', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '022.11'),
(206, '022', '12', NULL, NULL, NULL, '', '', 'BADAN PENGEMBANGAN SUMBER', '022.12'),
(207, '023', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '023.01'),
(208, '023', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '023.02'),
(209, '023', '03', NULL, NULL, NULL, '', '', 'DITJEN MANAJEMEN PENDIDIK', '023.03'),
(210, '023', '04', NULL, NULL, NULL, '', '', 'DITJEN PENDIDIKAN TINGGI', '023.04'),
(211, '023', '05', NULL, NULL, NULL, '', '', 'DITJEN PENDIDIKAN NONFORM', '023.05'),
(212, '023', '08', NULL, NULL, NULL, '', '', 'DITJEN PENINGKATAN MUTU P', '023.08'),
(213, '023', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '023.11'),
(214, '024', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '024.01'),
(215, '024', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '024.02'),
(216, '024', '03', NULL, NULL, NULL, '', '', 'DITJEN BINA GIZI DAN KESE', '024.03'),
(217, '024', '04', NULL, NULL, NULL, '', '', 'DITJEN BINA UPAYA KESEHAT', '024.04'),
(218, '024', '05', NULL, NULL, NULL, '', '', 'DITJEN PENGENDALIAAN PENY', '024.05'),
(219, '024', '07', NULL, NULL, NULL, '', '', 'DITJEN BINA KEFARMASIAN D', '024.07'),
(220, '024', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '024.11'),
(221, '024', '12', NULL, NULL, NULL, '', '', 'BADAN PENGEMBANGAN DAN PE', '024.12'),
(222, '025', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '025.01'),
(223, '025', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '025.02'),
(224, '025', '03', NULL, NULL, NULL, '', '', 'DITJEN BIMBINGAN MASYARAK', '025.03'),
(225, '025', '04', NULL, NULL, NULL, '', '', 'DITJEN PENDIDIKAN ISLAM', '025.04'),
(226, '025', '05', NULL, NULL, NULL, '', '', 'DITJEN BIMBINGAN MASYARAK', '025.05'),
(227, '025', '06', NULL, NULL, NULL, '', '', 'DITJEN BIMBINGAN MASYARAK', '025.06'),
(228, '025', '07', NULL, NULL, NULL, '', '', 'DITJEN BIMBINGAN MASYARAK', '025.07'),
(229, '025', '08', NULL, NULL, NULL, '', '', 'DITJEN BIMBINGAN MASYARAK', '025.08'),
(230, '025', '09', NULL, NULL, NULL, '', '', 'DITJEN PENYELENGGARAAN HA', '025.09'),
(231, '025', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN PENGEMBA', '025.11'),
(232, '026', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '026.01'),
(233, '026', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '026.02'),
(234, '026', '04', NULL, NULL, NULL, '', '', 'DITJEN PEMBINAAN PENEMPAT', '026.04'),
(235, '026', '05', NULL, NULL, NULL, '', '', 'DITJEN PEMBINAAN HUBUNGAN', '026.05'),
(236, '026', '06', NULL, NULL, NULL, '', '', 'DITJEN PEMBINAAN PEMBANGU', '026.06'),
(237, '026', '07', NULL, NULL, NULL, '', '', 'DITJEN PEMBINAAN PENGEMBA', '026.07'),
(238, '026', '08', NULL, NULL, NULL, '', '', 'DITJEN PEMBINAAN PENGAWAS', '026.08'),
(239, '026', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN, PENGEMB', '026.11'),
(240, '026', '13', NULL, NULL, NULL, '', '', 'DITJEN PEMBINAAN PELATIHA', '026.13'),
(241, '027', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '027.01'),
(242, '027', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '027.02'),
(243, '027', '03', NULL, NULL, NULL, '', '', 'DITJEN PEMBERDAYAAN SOSIA', '027.03'),
(244, '027', '04', NULL, NULL, NULL, '', '', 'DITJEN REHABILITASI SOSIA', '027.04'),
(245, '027', '05', NULL, NULL, NULL, '', '', 'DITJEN PERLINDUNGAN DAN J', '027.05'),
(246, '027', '11', NULL, NULL, NULL, '', '', 'BADAN PENDIDIKAN DAN PENE', '027.11'),
(247, '029', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '029.01'),
(248, '029', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '029.02'),
(249, '029', '03', NULL, NULL, NULL, '', '', 'DITJEN BINA USAHA KEHUTAN', '029.03'),
(250, '029', '04', NULL, NULL, NULL, '', '', 'DITJEN BINA PENGELOLAAN D', '029.04'),
(251, '029', '05', NULL, NULL, NULL, '', '', 'DITJEN PERLINDUNGAN HUTAN', '029.05'),
(252, '029', '06', NULL, NULL, NULL, '', '', 'DITJEN PLANOLOGI KEHUTANA', '029.06'),
(253, '029', '07', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '029.07'),
(254, '029', '08', NULL, NULL, NULL, '', '', 'BADAN PENYULUHAN DAN PENG', '029.08'),
(255, '032', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '032.01'),
(256, '032', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '032.02'),
(257, '032', '03', NULL, NULL, NULL, '', '', 'DITJEN PERIKANAN TANGKAP', '032.03'),
(258, '032', '04', NULL, NULL, NULL, '', '', 'DITJEN PERIKANAN BUDIDAYA', '032.04'),
(259, '032', '05', NULL, NULL, NULL, '', '', 'DITJEN PENGAWASAN SUMBERD', '032.05'),
(260, '032', '06', NULL, NULL, NULL, '', '', 'DITJEN PENGOLAHAN DAN PEM', '032.06'),
(261, '032', '07', NULL, NULL, NULL, '', '', 'DITJEN KELAUTAN, PESISIR', '032.07'),
(262, '032', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '032.11'),
(263, '032', '12', NULL, NULL, NULL, '', '', 'BADAN PENGEMBANGAN SDM KE', '032.12'),
(264, '032', '13', NULL, NULL, NULL, '', '', 'BADAN KARANTINA IKAN, PEN', '032.13'),
(265, '033', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '033.01'),
(266, '033', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '033.02'),
(267, '033', '03', NULL, NULL, NULL, '', '', 'DITJEN PENATAAN RUANG', '033.03'),
(268, '033', '04', NULL, NULL, NULL, '', '', 'DITJEN BINA MARGA', '033.04'),
(269, '033', '05', NULL, NULL, NULL, '', '', 'DITJEN CIPTA KARYA', '033.05'),
(270, '033', '06', NULL, NULL, NULL, '', '', 'DITJEN SUMBER DAYA AIR', '033.06'),
(271, '033', '11', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '033.11'),
(272, '033', '13', NULL, NULL, NULL, '', '', 'BADAN PEMBINAAN KONSTRUKS', '033.13'),
(273, '034', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN KOORDINATOR B', '034.01'),
(274, '035', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN KOORDINATOR B', '035.01'),
(275, '036', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN KOORDINATOR B', '036.01'),
(276, '040', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '040.01'),
(277, '040', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '040.02'),
(278, '040', '03', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL NILAI', '040.03'),
(279, '040', '04', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL SEJAR', '040.04'),
(280, '040', '05', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL PENGE', '040.05'),
(281, '040', '06', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL PEMAS', '040.06'),
(282, '040', '10', NULL, NULL, NULL, '', '', 'BADAN PENGEMBANGAN SUMBER', '040.10'),
(283, '041', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN BADAN USAHA M', '041.01'),
(284, '042', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN RISET DAN TEK', '042.01'),
(285, '043', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN LINGKUNGAN HI', '043.01'),
(286, '044', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN KOPERASI DAN', '044.01'),
(287, '047', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN PEMBERDAYAAN', '047.01'),
(288, '048', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN PENDAYAGUNAAN', '048.01'),
(289, '050', '01', NULL, NULL, NULL, '', '', 'BADAN INTELIJEN NEGARA', '050.01'),
(290, '051', '01', NULL, NULL, NULL, '', '', 'LEMBAGA SANDI NEGARA', '051.01'),
(291, '052', '01', NULL, NULL, NULL, '', '', 'SETJEN DEWAN KETAHANAN NA', '052.01'),
(292, '054', '01', NULL, NULL, NULL, '', '', 'BADAN PUSAT STATISTIK', '054.01'),
(293, '055', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN PERENCANAAN P', '055.01'),
(294, '056', '01', NULL, NULL, NULL, '', '', 'BADAN PERTANAHAN NASIONAL', '056.01'),
(295, '057', '01', NULL, NULL, NULL, '', '', 'PERPUSTAKAAN NASIONAL', '057.01'),
(296, '059', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '059.01'),
(297, '059', '02', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '059.02'),
(298, '059', '03', NULL, NULL, NULL, '', '', 'DITJEN SUMBER DAYA DAN PE', '059.03'),
(299, '059', '04', NULL, NULL, NULL, '', '', 'DITJEN APLIKASI INFORMATI', '059.04'),
(300, '059', '05', NULL, NULL, NULL, '', '', 'DITJEN PENYELENGGARAAN PO', '059.05'),
(301, '059', '06', NULL, NULL, NULL, '', '', 'BADAN PENELITIAN DAN PENG', '059.06'),
(302, '059', '07', NULL, NULL, NULL, '', '', 'DITJEN INFORMASI DAN KOMU', '059.07'),
(303, '060', '01', NULL, NULL, NULL, '', '', 'KEPOLISIAN NEGARA REPUBLI', '060.01'),
(304, '061', '03', NULL, NULL, NULL, '', '', 'CICILAN DAN BUNGA HUTANG', '061.03'),
(305, '062', '03', NULL, NULL, NULL, '', '', 'SUBSIDI DAN TRANSFER', '062.03'),
(306, '063', '01', NULL, NULL, NULL, '', '', 'BADAN PENGAWAS OBAT DAN M', '063.01'),
(307, '064', '01', NULL, NULL, NULL, '', '', 'LEMBAGA KETAHANAN NASIONA', '064.01'),
(308, '065', '01', NULL, NULL, NULL, '', '', 'BADAN KOORDINASI PENANAMA', '065.01'),
(309, '066', '01', NULL, NULL, NULL, '', '', 'BADAN NARKOTIKA NASIONAL', '066.01'),
(310, '067', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN PEMBANGUNAN D', '067.01'),
(311, '068', '01', NULL, NULL, NULL, '', '', 'BADAN KOORDINASI KELUARGA', '068.01'),
(312, '069', '03', NULL, NULL, NULL, '', '', 'BELANJA LAIN-LAIN', '069.03'),
(313, '069', '10', NULL, NULL, NULL, '', '', 'DEPARTEMEN DALAM NEGERI', '069.10'),
(314, '070', '03', NULL, NULL, NULL, '', '', 'DANA PERIMBANGAN', '070.03'),
(315, '071', '03', NULL, NULL, NULL, '', '', 'DANA OTONOMI KHUSUS PENYE', '071.03'),
(316, '074', '01', NULL, NULL, NULL, '', '', 'KOMNAS HAM', '074.01'),
(317, '075', '01', NULL, NULL, NULL, '', '', 'BADAN METEOROLOGI, KLIMAT', '075.01'),
(318, '076', '01', NULL, NULL, NULL, '', '', 'KOMISI PEMILIHAN UMUM', '076.01'),
(319, '077', '01', NULL, NULL, NULL, '', '', 'MAHKAMAH KONSTITUSI RI', '077.01'),
(320, '078', '01', NULL, NULL, NULL, '', '', 'PUSAT PELAPORAN DAN ANALI', '078.01'),
(321, '079', '01', NULL, NULL, NULL, '', '', 'LEMBAGA ILMU PENGETAHUAN', '079.01'),
(322, '080', '01', NULL, NULL, NULL, '', '', 'BADAN TENAGA NUKLIR NASIO', '080.01'),
(323, '081', '01', NULL, NULL, NULL, '', '', 'BADAN PENGKAJIAN DAN PENE', '081.01'),
(324, '082', '01', NULL, NULL, NULL, '', '', 'L A P A N', '082.01'),
(325, '083', '01', NULL, NULL, NULL, '', '', 'BADAN KOORDINASI SURVEI D', '083.01'),
(326, '084', '01', NULL, NULL, NULL, '', '', 'BADAN STANDARISASI NASION', '084.01'),
(327, '085', '01', NULL, NULL, NULL, '', '', 'BADAN PENGAWAS TENAGA NUK', '085.01'),
(328, '086', '01', NULL, NULL, NULL, '', '', 'LEMBAGA ADMINISTRASI NEGA', '086.01'),
(329, '087', '01', NULL, NULL, NULL, '', '', 'ARSIP NASIONAL', '087.01'),
(330, '088', '01', NULL, NULL, NULL, '', '', 'BADAN KEPEGAWAIAN NEGARA', '088.01'),
(331, '089', '01', NULL, NULL, NULL, '', '', 'BADAN PENGAWASAN KEUANGAN', '089.01'),
(332, '090', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL', '090.01'),
(333, '090', '02', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL PERDA', '090.02'),
(334, '090', '03', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL PERDA', '090.03'),
(335, '090', '04', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL KERJA', '090.04'),
(336, '090', '05', NULL, NULL, NULL, '', '', 'INSPEKTORAT JENDERAL', '090.05'),
(337, '090', '06', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL PENGE', '090.06'),
(338, '090', '07', NULL, NULL, NULL, '', '', 'BADAN PENGAWAS PERDAGANGA', '090.07'),
(339, '090', '08', NULL, NULL, NULL, '', '', 'BADAN PENGKAJIAN  DAN PEN', '090.08'),
(340, '090', '09', NULL, NULL, NULL, '', '', 'DIREKTORAT JENDERAL STAND', '090.09'),
(341, '091', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN PERUMAHAN RAK', '091.01'),
(342, '092', '01', NULL, NULL, NULL, '', '', 'KEMENTERIAN PEMUDA DAN OL', '092.01'),
(343, '093', '01', NULL, NULL, NULL, '', '', 'KOMISI PEMBERANTASAN KORU', '093.01'),
(344, '095', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT JENDERAL DPD', '095.01'),
(345, '095', '02', NULL, NULL, NULL, '', '', 'DEWAN PERWAKILAN DAERAH', '095.02'),
(346, '096', '03', NULL, NULL, NULL, '', '', 'PEMBAYARAN CICILAN POKOK', '096.03'),
(347, '097', '03', NULL, NULL, NULL, '', '', 'PEMBAYARAN CICILAN POKOK', '097.03'),
(348, '098', '03', NULL, NULL, NULL, '', '', 'PENERUSAN PINJAMAN', '098.03'),
(349, '099', '03', NULL, NULL, NULL, '', '', 'PENYERTAAN MODAL NEGARA', '099.03'),
(350, '100', '01', NULL, NULL, NULL, '', '', 'KOMISI YUDISIAL RI', '100.01'),
(351, '101', '03', NULL, NULL, NULL, '', '', 'PENERUSAN PINJAMAN SEBAGA', '101.03'),
(352, '102', '03', NULL, NULL, NULL, '', '', 'PENERUSAN  HIBAH', '102.03'),
(353, '103', '01', NULL, NULL, NULL, '', '', 'BADAN NASIONAL PENANGGULA', '103.01'),
(354, '104', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT UTAMA BNP2TKI', '104.01'),
(355, '105', '01', NULL, NULL, NULL, '', '', 'BADAN PENANGGULANGAN LUMP', '105.01'),
(356, '106', '01', NULL, NULL, NULL, '', '', 'LEMBAGA KEBIJAKAN PENGADA', '106.01'),
(357, '107', '01', NULL, NULL, NULL, '', '', 'BADAN SAR NASIONAL', '107.01'),
(358, '108', '01', NULL, NULL, NULL, '', '', 'KOMISI PENGAWAS PERSAINGA', '108.01'),
(359, '109', '01', NULL, NULL, NULL, '', '', 'BADAN PENGEMBANGAN WILAYA', '109.01'),
(360, '110', '01', NULL, NULL, NULL, '', '', 'OMBUDSMAN REPUBLIK INDONE', '110.01'),
(361, '111', '01', NULL, NULL, NULL, '', '', 'BADAN NASIONAL PENGELOLA', '111.01'),
(362, '999', '01', NULL, NULL, NULL, '', '', 'PENGELOLAAN UTANG', '999.01'),
(363, '999', '02', NULL, NULL, NULL, '', '', 'PENGELOLAAN HIBAH', '999.02'),
(364, '999', '03', NULL, NULL, NULL, '', '', 'PENGELOLAAN INVESTASI PEM', '999.03'),
(365, '999', '04', NULL, NULL, NULL, '', '', 'PENGELOLAAN PENERUSAN PIN', '999.04'),
(366, '999', '05', NULL, NULL, NULL, '', '', 'PENGELOLAAN TRANSFER KE D', '999.05'),
(367, '999', '06', NULL, NULL, NULL, '', '', 'PENGELOLAAN BELANJA SUBSI', '999.06'),
(368, '999', '07', NULL, NULL, NULL, '', '', 'PENGELOLAAN BELANJA SUBSI', '999.07'),
(369, '999', '08', NULL, NULL, NULL, '', '', 'PENGELOLAAN BELANJA LAIN-', '999.08'),
(370, '999', '99', NULL, NULL, NULL, '', '', 'PENGELOLAAN TRANSAKSI KHU', '999.99'),
(371, '005', '08', NULL, NULL, NULL, '', '', 'BADAN PENGAWASAN MAHKAMAH', '005.08'),
(372, '008', '01', NULL, NULL, NULL, '', '', 'SEKRETARIAT WAKIL PRESIDE', '008.01'),
(373, '008', '02', NULL, NULL, NULL, '', '', 'BAKORNAS PENANGGULANGAN B', '008.02'),
(374, '022', '13', NULL, NULL, NULL, '', '', 'BADAN SAR NASIONAL', '022.13'),
(375, '026', '03', NULL, NULL, NULL, '', '', 'DITJEN PEMBINAAN DAN PENE', '026.03'),
(376, '033', '14', NULL, NULL, NULL, '', '', 'BADAN PENGELOLA JALAN TOL', '033.14'),
(377, '033', '15', NULL, NULL, NULL, '', '', 'BADAN PENDUKUNG PENGELOLA', '033.15'),
(378, '053', '01', NULL, NULL, NULL, '', '', 'BADAN URUSAN LOGISTIK', '053.01'),
(379, '065', '02', NULL, NULL, NULL, '', '', 'DEPUTI BIDANG PENGEMBANGA', '065.02'),
(380, '065', '03', NULL, NULL, NULL, '', '', 'DEPUTI BIDANG PROMOSI PEN', '065.03'),
(381, '065', '04', NULL, NULL, NULL, '', '', 'DEPUTI BIDANG KERJA SAMA', '065.04'),
(382, '065', '05', NULL, NULL, NULL, '', '', 'DEPUTI BIDANG PELAYANAN P', '065.05'),
(383, '065', '06', NULL, NULL, NULL, '', '', 'DEPUTI BIDANG PENGENDALIA', '065.06'),
(384, '065', '07', NULL, NULL, NULL, '', '', 'INSPEKTORAT', '065.07'),
(385, '065', '08', NULL, NULL, NULL, '', '', 'PUSAT PENELITIAN DAN PELA', '065.08'),
(386, '069', '08', NULL, NULL, NULL, '', '', 'BELANJA LAIN-LAIN', '069.08'),
(387, '091', '02', NULL, NULL, NULL, '', '', 'DEPUTI PEMBIAYAAN', '091.02'),
(388, '091', '03', NULL, NULL, NULL, '', '', 'DEPUTI PENGEMBANGAN KAWAS', '091.03'),
(389, '091', '04', NULL, NULL, NULL, '', '', 'DEPUTI PERUMAHAN FORMAL', '091.04'),
(390, '091', '05', NULL, NULL, NULL, '', '', 'DEPUTI PERUMAHAN SWADAYA', '091.05'),
(391, '094', '01', NULL, NULL, NULL, '', '', 'BIDANG PENGAWASAN', '094.01'),
(392, '094', '02', NULL, NULL, NULL, '', '', 'BIDANG KEUANGAN DAN PEREN', '094.02'),
(393, '094', '03', NULL, NULL, NULL, '', '', 'BIDANG AGAMA, SOSIAL DAN', '094.03'),
(394, '094', '04', NULL, NULL, NULL, '', '', 'BIDANG EKONOMI DAN USAHA', '094.04'),
(395, '094', '05', NULL, NULL, NULL, '', '', 'BIDANG PENDIDIKAN, KESEHA', '094.05'),
(396, '094', '06', NULL, NULL, NULL, '', '', 'BIDANG PERUMAHAN DAN PERM', '094.06'),
(397, '094', '07', NULL, NULL, NULL, '', '', 'BIDANG INFRASTRUKTUR, LIN', '094.07'),
(398, '094', '08', NULL, NULL, NULL, '', '', 'BIDANG KELEMBAGAAN DAN PE', '094.08'),
(399, '094', '09', NULL, NULL, NULL, '', '', 'SEKRETARIAT, KOMUNIKASI D', '094.09'),
(400, '094', '10', NULL, NULL, NULL, '', '', 'BIDANG OPERASI', '094.10'),
(403, '001', '03', NULL, NULL, NULL, NULL, '', 'MAJELIS TAKLIM', '001.03'),
(404, '001', '03', '0100', NULL, NULL, NULL, '', 'KEMAYORAN', '001.03.0100'),
(408, '001', '03', '0100', '000001', '001', 'KD', '001030100000001001KD', 'BALAI DIKLAT KEMAYORAN', '001.03.0100.000001.001');

-- --------------------------------------------------------

--
-- Table structure for table `skel`
--

CREATE TABLE IF NOT EXISTS `skel` (
  `id` int(11) NOT NULL,
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `kd_kel` varchar(10) NOT NULL,
  `kd_skel` varchar(10) NOT NULL,
  `nm_skel` varchar(30) NOT NULL,
  `kd_skelbrg` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skel`
--

INSERT INTO `skel` (`id`, `kd_gol`, `kd_bid`, `kd_kel`, `kd_skel`, `nm_skel`, `kd_skelbrg`) VALUES
(1, '1', '01', '01', '01', 'BAHAN BANGUNAN DAN KONSTRUKSI ', '1010101'),
(2, '1', '01', '01', '02', 'BAHAN KIMIA                   ', '1010102'),
(3, '1', '01', '01', '03', 'BAHAN PELEDAK                 ', '1010103'),
(4, '1', '01', '01', '04', 'BAHAN BAKAR DAN PELUMAS       ', '1010104'),
(5, '1', '01', '01', '05', 'BAHAN BAKU                    ', '1010105'),
(6, '1', '01', '01', '06', 'BAHAN KIMIA NUKLIR            ', '1010106'),
(7, '1', '01', '01', '07', 'BARANG DALAM PROSES           ', '1010107'),
(8, '1', '01', '02', '08', 'SUKU CADANG ALAT BENGKEL      ', '1010208'),
(9, '1', '01', '01', '99', 'BAHAN LAINNYA                 ', '1010199');

-- --------------------------------------------------------

--
-- Table structure for table `sskel`
--

CREATE TABLE IF NOT EXISTS `sskel` (
  `id` int(11) NOT NULL,
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `kd_kel` varchar(10) NOT NULL,
  `kd_skel` varchar(10) NOT NULL,
  `kd_sskel` varchar(10) NOT NULL,
  `nm_sskel` varchar(30) NOT NULL,
  `satuan` varchar(7) NOT NULL,
  `kd_brg` varchar(20) NOT NULL,
  `kd_perk` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=345 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sskel`
--

INSERT INTO `sskel` (`id`, `kd_gol`, `kd_bid`, `kd_kel`, `kd_skel`, `kd_sskel`, `nm_sskel`, `satuan`, `kd_brg`, `kd_perk`) VALUES
(1, '1', '01', '01', '01', '', 'Aspal                         ', '       ', '1010101001', '115131'),
(2, '1', '01', '01', '01', '', 'Semen                         ', '       ', '1010101002', '115131'),
(3, '1', '01', '01', '01', '', 'Kaca                          ', '       ', '1010101003', '115131'),
(4, '1', '01', '01', '01', '', 'Pasir                         ', '       ', '1010101004', '115131'),
(5, '1', '01', '01', '01', '', 'Batu                          ', '       ', '1010101005', '115131'),
(6, '1', '01', '01', '01', '', 'Cat                           ', '       ', '1010101006', '115131'),
(7, '1', '01', '01', '01', '', 'Seng                          ', '       ', '1010101007', '115131'),
(8, '1', '01', '01', '01', '', 'Baja                          ', '       ', '1010101008', '115131'),
(9, '1', '01', '01', '01', '', 'Electro Dalas                 ', '       ', '1010101009', '115131'),
(10, '1', '01', '01', '01', '', 'Patok Beton                   ', '       ', '1010101010', '115131'),
(11, '1', '01', '01', '01', '', 'Tiang Beton                   ', '       ', '1010101011', '115131'),
(12, '1', '01', '01', '01', '', 'Besi Beton                    ', '       ', '1010101012', '115131'),
(13, '1', '01', '01', '01', '', 'Tegel                         ', '       ', '1010101013', '115131'),
(14, '1', '01', '01', '01', '', 'Genteng                       ', '       ', '1010101014', '115131'),
(15, '1', '01', '01', '01', '', 'Bis Beton                     ', '       ', '1010101015', '115131'),
(16, '1', '01', '01', '01', '', 'Plat                          ', '       ', '1010101016', '115131'),
(17, '1', '01', '01', '01', '', 'Steel Sheet Pile              ', '       ', '1010101017', '115131'),
(18, '1', '01', '01', '01', '', 'Concrete Sheet Pile           ', '       ', '1010101018', '115131'),
(19, '1', '01', '01', '01', '', 'Kawat Bronjong                ', '       ', '1010101019', '115131'),
(20, '1', '01', '01', '01', '', 'Karung                        ', '       ', '1010101020', '115131'),
(21, '1', '01', '01', '01', '', 'Minyak Cat/Thinner            ', '       ', '1010101021', '115131'),
(22, '1', '01', '01', '01', '', 'Bahan Bangunan Dan Konstruksi ', '       ', '1010101999', '115131'),
(23, '1', '01', '01', '02', '', 'Bahan Kimia Padat             ', '       ', '1010102001', '115131'),
(24, '1', '01', '01', '02', '', 'Bahan Kimia Cair              ', '       ', '1010102002', '115131'),
(25, '1', '01', '01', '02', '', 'Bahan Kimia Gas               ', '       ', '1010102003', '115131'),
(26, '1', '01', '01', '02', '', 'Bahan Kimia Nuklir            ', '       ', '1010102005', '115131'),
(27, '1', '01', '01', '02', '', 'Bahan Kimia Lainnya           ', '       ', '1010102999', '115131'),
(28, '1', '01', '01', '03', '', 'Anfo                          ', '       ', '1010103001', '115112'),
(29, '1', '01', '01', '03', '', 'Detonator                     ', '       ', '1010103002', '115112'),
(30, '1', '01', '01', '03', '', 'Dinamit                       ', '       ', '1010103003', '115112'),
(31, '1', '01', '01', '03', '', 'Gelatine                      ', '       ', '1010103004', '115112'),
(32, '1', '01', '01', '03', '', 'Sumbu Ledak/Api               ', '       ', '1010103005', '115112'),
(33, '1', '01', '01', '03', '', 'Amunisi                       ', '       ', '1010103006', '115112'),
(34, '1', '01', '01', '03', '', 'Bahan Peledak Lainnya         ', '       ', '1010103999', '115112'),
(35, '1', '01', '01', '04', '', 'Bahan Bakar Minyak            ', '       ', '1010104001', '115131'),
(36, '1', '01', '01', '04', '', 'Minyak Pelumas                ', '       ', '1010104002', '115131'),
(37, '1', '01', '01', '04', '', 'Minyak Hydrolis               ', '       ', '1010104003', '115131'),
(38, '1', '01', '01', '04', '', 'Bahan Bakar Gas               ', '       ', '1010104004', '115131'),
(39, '1', '01', '01', '04', '', 'Batubara                      ', '       ', '1010104005', '115131'),
(40, '1', '01', '01', '04', '', 'Bahan Bakar Dan Pelumas Lainny', '       ', '1010104999', '115131'),
(41, '1', '01', '01', '05', '', 'Kawat                         ', '       ', '1010105001', '115131'),
(42, '1', '01', '01', '05', '', 'Kayu                          ', '       ', '1010105002', '115131'),
(43, '1', '01', '01', '05', '', 'Logam/Metalorgi               ', '       ', '1010105003', '115131'),
(44, '1', '01', '01', '05', '', 'Latex                         ', '       ', '1010105004', '115131'),
(45, '1', '01', '01', '05', '', 'Biji Plastik                  ', '       ', '1010105005', '115131'),
(46, '1', '01', '01', '05', '', 'Karet (Bahan Baku)            ', '       ', '1010105006', '115131'),
(47, '1', '01', '01', '05', '', 'Bahan Baku Lainnya            ', '       ', '1010105999', '115131'),
(48, '1', '01', '01', '06', '', 'Uranium - 233                 ', '       ', '1010106001', '115131'),
(49, '1', '01', '01', '06', '', 'Uranium - 235                 ', '       ', '1010106002', '115131'),
(50, '1', '01', '01', '06', '', 'Uranium - 238                 ', '       ', '1010106003', '115131'),
(51, '1', '01', '01', '06', '', 'Plutonium (PU)                ', '       ', '1010106004', '115131'),
(52, '1', '01', '01', '06', '', 'Neptarim (NP)                 ', '       ', '1010106005', '115131'),
(53, '1', '01', '01', '06', '', 'Uranium Dioksida              ', '       ', '1010106006', '115131'),
(54, '1', '01', '01', '06', '', 'Thorium                       ', '       ', '1010106007', '115131'),
(55, '1', '01', '01', '06', '', 'Bahan Kimia Nuklir Lainnya    ', '       ', '1010106999', '115131'),
(56, '1', '01', '01', '07', '', 'Barang Dalam Proses           ', '       ', '1010107001', '115131'),
(57, '1', '01', '01', '07', '', 'Barang Dalam Proses Lainnya   ', '       ', '1010107999', '115131'),
(58, '1', '01', '01', '99', '', 'Bahan Lainnya                 ', '       ', '1010199999', '115131'),
(59, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Dara', '       ', '1010201001', '115114'),
(60, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Dara', '       ', '1010201002', '115114'),
(61, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Apun', '       ', '1010201003', '115114'),
(62, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Apun', '       ', '1010201004', '115114'),
(63, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Udar', '       ', '1010201005', '115114'),
(64, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Lain', '       ', '1010201999', '115114'),
(65, '1', '01', '02', '02', '', 'Suku Cadang Alat Besar Darat  ', '       ', '1010202001', '115114'),
(66, '1', '01', '02', '02', '', 'Suku Cadang Alat Besar Apung  ', '       ', '1010202002', '115114'),
(67, '1', '01', '02', '02', '', 'Suku Cadang Alat Besar Bantu  ', '       ', '1010202003', '115114'),
(68, '1', '01', '02', '02', '', 'Suku Cadang Alat Besar Lainnya', '       ', '1010202999', '115114'),
(69, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Um', '       ', '1010203001', '115114'),
(70, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Gi', '       ', '1010203002', '115114'),
(71, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ke', '       ', '1010203003', '115114'),
(72, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Be', '       ', '1010203004', '115114'),
(73, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ke', '       ', '1010203005', '115114'),
(74, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran TH', '       ', '1010203006', '115114'),
(75, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ma', '       ', '1010203007', '115114'),
(76, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Pe', '       ', '1010203008', '115114'),
(77, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Al', '       ', '1010203009', '115114'),
(78, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Po', '       ', '1010203010', '115114'),
(79, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Un', '       ', '1010203011', '115114'),
(80, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Sy', '       ', '1010203012', '115114'),
(81, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ja', '       ', '1010203013', '115114'),
(82, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Nu', '       ', '1010203014', '115114'),
(83, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ra', '       ', '1010203015', '115114'),
(84, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ku', '       ', '1010203016', '115114'),
(85, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ug', '       ', '1010203017', '115114'),
(86, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran He', '       ', '1010203018', '115114'),
(87, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran He', '       ', '1010203019', '115114'),
(88, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran La', '       ', '1010203999', '115114'),
(89, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204001', '115114'),
(90, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204002', '115114'),
(91, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204003', '115114'),
(92, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204004', '115114'),
(93, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204005', '115114'),
(94, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204006', '115114'),
(95, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204007', '115114'),
(96, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204008', '115114'),
(97, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204009', '115114'),
(98, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204010', '115114'),
(99, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204011', '115114'),
(100, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204012', '115114'),
(101, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204013', '115114'),
(102, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204014', '115114'),
(103, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204015', '115114'),
(104, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204016', '115114'),
(105, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204017', '115114'),
(106, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204018', '115114'),
(107, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204019', '115114'),
(108, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204020', '115114'),
(109, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204021', '115114'),
(110, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204022', '115114'),
(111, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204023', '115114'),
(112, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204024', '115114'),
(113, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204025', '115114'),
(114, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204026', '115114'),
(115, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204027', '115114'),
(116, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204028', '115114'),
(117, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204029', '115114'),
(118, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204030', '115114'),
(119, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204031', '115114'),
(120, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204032', '115114'),
(121, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204033', '115114'),
(122, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204034', '115114'),
(123, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204035', '115114'),
(124, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204036', '115114'),
(125, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204037', '115114'),
(126, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204038', '115114'),
(127, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204039', '115114'),
(128, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204040', '115114'),
(129, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204041', '115114'),
(130, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204042', '115114'),
(131, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204043', '115114'),
(132, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204044', '115114'),
(133, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204045', '115114'),
(134, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204046', '115114'),
(135, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204047', '115114'),
(136, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204048', '115114'),
(137, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204049', '115114'),
(138, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204050', '115114'),
(139, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204051', '115114'),
(140, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204052', '115114'),
(141, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204053', '115114'),
(142, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204054', '115114'),
(143, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204055', '115114'),
(144, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204056', '115114'),
(145, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204057', '115114'),
(146, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204058', '115114'),
(147, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204059', '115114'),
(148, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204060', '115114'),
(149, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010204999', '115114'),
(150, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar MF/M', '       ', '1010205001', '115114'),
(151, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar HF/S', '       ', '1010205002', '115114'),
(152, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar FHF/', '       ', '1010205003', '115114'),
(153, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar UHF ', '       ', '1010205004', '115114'),
(154, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar SHF ', '       ', '1010205005', '115114'),
(155, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar Lain', '       ', '1010205999', '115114'),
(156, '1', '01', '02', '06', '', 'Suku Cadang Alat Studio       ', '       ', '1010206001', '115114'),
(157, '1', '01', '02', '06', '', 'Suku Cadang Alat Komunikasi   ', '       ', '1010206002', '115114'),
(158, '1', '01', '02', '06', '', 'Suku Cadang Alat Studio Dan Ko', '       ', '1010206999', '115114'),
(159, '1', '01', '02', '07', '', 'Suku Cadang Alat Pengolahan Te', '       ', '1010207001', '115114'),
(160, '1', '01', '02', '07', '', 'Suku Cadang Alat Pemeliharaan ', '       ', '1010207002', '115114'),
(161, '1', '01', '02', '07', '', 'Suku Cadang Alat Panen        ', '       ', '1010207003', '115114'),
(162, '1', '01', '02', '07', '', 'Suku Cadang Alat Penyimpanan H', '       ', '1010207004', '115114'),
(163, '1', '01', '02', '07', '', 'Suku Cadang Alat Laboratorium ', '       ', '1010207005', '115114'),
(164, '1', '01', '02', '07', '', 'Suku Cadang Alat Prossesing   ', '       ', '1010207006', '115114'),
(165, '1', '01', '02', '07', '', 'Suku Cadang Alat Paska Panen  ', '       ', '1010207007', '115114'),
(166, '1', '01', '02', '07', '', 'Suku Cadang Alat Produksi     ', '       ', '1010207008', '115114'),
(167, '1', '01', '02', '07', '', 'Suku Cadang Alat Pertanian Lai', '       ', '1010207999', '115114'),
(168, '1', '01', '02', '08', '', 'Suku Cadang Alat Bengkel Berme', '       ', '1010208001', '115114'),
(169, '1', '01', '02', '08', '', 'Suku Cadang Alat Bengkel Tidak', '       ', '1010208002', '115114'),
(170, '1', '01', '02', '08', '', 'Suku Cadang Alat Bengkel Lainn', '       ', '1010208999', '115114'),
(171, '1', '01', '02', '99', '', 'Suku Cadang Lainnya           ', '       ', '1010299999', '115114'),
(172, '1', '01', '03', '01', '', 'Alat Tulis                    ', '       ', '1010301001', '115111'),
(173, '1', '01', '03', '01', '', 'Tinta Tulis, Tinta Stempel    ', '       ', '1010301002', '115111'),
(174, '1', '01', '03', '01', '', 'Penjepit Kertas               ', '       ', '1010301003', '115111'),
(175, '1', '01', '03', '01', '', 'Penghapus/Korektor            ', '       ', '1010301004', '115111'),
(176, '1', '01', '03', '01', '', 'Buku Tulis                    ', '       ', '1010301005', '115111'),
(177, '1', '01', '03', '01', '', 'Ordner Dan Map                ', '       ', '1010301006', '115111'),
(178, '1', '01', '03', '01', '', 'Penggaris                     ', '       ', '1010301007', '115111'),
(179, '1', '01', '03', '01', '', 'Cutter (Alat Tulis Kantor)    ', '       ', '1010301008', '115111'),
(180, '1', '01', '03', '01', '', 'Pita Mesin Ketik              ', '       ', '1010301009', '115111'),
(181, '1', '01', '03', '01', '', 'Alat Perekat                  ', '       ', '1010301010', '115111'),
(182, '1', '01', '03', '01', '', 'Stadler HD                    ', '       ', '1010301011', '115111'),
(183, '1', '01', '03', '01', '', 'Staples                       ', '       ', '1010301012', '115111'),
(184, '1', '01', '03', '01', '', 'Isi Staples                   ', '       ', '1010301013', '115111'),
(185, '1', '01', '03', '01', '', 'Barang Cetakan                ', '       ', '1010301014', '115111'),
(186, '1', '01', '03', '01', '', 'Seminar Kit                   ', '       ', '1010301015', '115111'),
(187, '1', '01', '03', '01', '', 'Alat Tulis Kantor Lainnya     ', '       ', '1010301999', '115111'),
(188, '1', '01', '03', '02', '', 'Kertas HVS                    ', '       ', '1010302001', '115111'),
(189, '1', '01', '03', '02', '', 'Berbagai Kertas               ', '       ', '1010302002', '115111'),
(190, '1', '01', '03', '02', '', 'Kertas Cover                  ', '       ', '1010302003', '115111'),
(191, '1', '01', '03', '02', '', 'Amplop                        ', '       ', '1010302004', '115111'),
(192, '1', '01', '03', '02', '', 'Kop Surat                     ', '       ', '1010302005', '115111'),
(193, '1', '01', '03', '02', '', 'Kertas Dan Cover Lainnya      ', '       ', '1010302999', '115111'),
(194, '1', '01', '03', '03', '', 'Transparant Sheet             ', '       ', '1010303001', '115111'),
(195, '1', '01', '03', '03', '', 'Tinta Cetak                   ', '       ', '1010303002', '115111'),
(196, '1', '01', '03', '03', '', 'Plat Cetak                    ', '       ', '1010303003', '115111'),
(197, '1', '01', '03', '03', '', 'Stensil Sheet                 ', '       ', '1010303004', '115111'),
(198, '1', '01', '03', '03', '', 'Chenical/Bahan Kimia Cetak    ', '       ', '1010303005', '115111'),
(199, '1', '01', '03', '03', '', 'Film Cetak                    ', '       ', '1010303006', '115111'),
(200, '1', '01', '03', '03', '', 'Bahan Cetak Lainnya           ', '       ', '1010303999', '115111'),
(201, '1', '01', '03', '04', '', 'Continuous Form               ', '       ', '1010304001', '115111'),
(202, '1', '01', '03', '04', '', 'Computer File/Tempat Disket   ', '       ', '1010304002', '115111'),
(203, '1', '01', '03', '04', '', 'Pita Printer                  ', '       ', '1010304003', '115111'),
(204, '1', '01', '03', '04', '', 'Tinta/Toner Printer           ', '       ', '1010304004', '115111'),
(205, '1', '01', '03', '04', '', 'Disket                        ', '       ', '1010304005', '115111'),
(206, '1', '01', '03', '04', '', 'USB/Flash Disk                ', '       ', '1010304006', '115111'),
(207, '1', '01', '03', '04', '', 'kartu Memori                  ', '       ', '1010304007', '115111'),
(208, '1', '01', '03', '04', '', 'CD/DVD Drive                  ', '       ', '1010304008', '115111'),
(209, '1', '01', '03', '04', '', 'Harddisk Internal             ', '       ', '1010304009', '115111'),
(210, '1', '01', '03', '04', '', 'Mouse                         ', '       ', '1010304010', '115111'),
(211, '1', '01', '03', '04', '', 'CD/DVD                        ', '       ', '1010304011', '115111'),
(212, '1', '01', '03', '04', '', 'Bahan Komputer Lainnya        ', '       ', '1010304999', '115111'),
(213, '1', '01', '03', '05', '', 'Sapu Dan Sikat                ', '       ', '1010305001', '115113'),
(214, '1', '01', '03', '05', '', 'Alat-Alat Pel Dan Lap         ', '       ', '1010305002', '115113'),
(215, '1', '01', '03', '05', '', 'Ember, Slang, Dan Tempat Air L', '       ', '1010305003', '115113'),
(216, '1', '01', '03', '05', '', 'Keset Dan Tempat Sampah       ', '       ', '1010305004', '115113'),
(217, '1', '01', '03', '05', '', 'Kunci, Kran Dan Semprotan     ', '       ', '1010305005', '115113'),
(218, '1', '01', '03', '05', '', 'Alat Pengikat                 ', '       ', '1010305006', '115113'),
(219, '1', '01', '03', '05', '', 'Peralatan Ledeng              ', '       ', '1010305007', '115113'),
(220, '1', '01', '03', '05', '', 'Bahan Kimia Untuk Pembersih   ', '       ', '1010305008', '115113'),
(221, '1', '01', '03', '05', '', 'Alat Untuk Makan Dan Minum    ', '       ', '1010305009', '115113'),
(222, '1', '01', '03', '05', '', 'Kaos Lampu Petromak           ', '       ', '1010305010', '115113'),
(223, '1', '01', '03', '05', '', 'Kaca Lampu Petromak           ', '       ', '1010305011', '115113'),
(224, '1', '01', '03', '05', '', 'Pengharum Ruangan             ', '       ', '1010305012', '115113'),
(225, '1', '01', '03', '05', '', 'Kuas                          ', '       ', '1010305013', '115113'),
(226, '1', '01', '03', '05', '', 'Segel/Tanda Pengaman          ', '       ', '1010305014', '115113'),
(227, '1', '01', '03', '05', '', 'Perabot Kantor Lainnya        ', '       ', '1010305999', '115113'),
(228, '1', '01', '03', '06', '', 'Kabel Listrik                 ', '       ', '1010306001', '115111'),
(229, '1', '01', '03', '06', '', 'Lampu Listrik                 ', '       ', '1010306002', '115111'),
(230, '1', '01', '03', '06', '', 'Stop Kontak                   ', '       ', '1010306003', '115111'),
(231, '1', '01', '03', '06', '', 'Saklar                        ', '       ', '1010306004', '115111'),
(232, '1', '01', '03', '06', '', 'Stacker                       ', '       ', '1010306005', '115111'),
(233, '1', '01', '03', '06', '', 'Balast                        ', '       ', '1010306006', '115111'),
(234, '1', '01', '03', '06', '', 'Starter                       ', '       ', '1010306007', '115111'),
(235, '1', '01', '03', '06', '', 'Vitting                       ', '       ', '1010306008', '115111'),
(236, '1', '01', '03', '06', '', 'Accu                          ', '       ', '1010306009', '115111'),
(237, '1', '01', '03', '06', '', 'Batu Baterai                  ', '       ', '1010306010', '115111'),
(238, '1', '01', '03', '06', '', 'Stavol                        ', '       ', '1010306011', '115111'),
(239, '1', '01', '03', '06', '', 'Alat Listrik Lainnya          ', '       ', '1010306999', '115111'),
(240, '1', '01', '03', '07', '', 'Bahan Baku Pakaian            ', '       ', '1010307001', '115111'),
(241, '1', '01', '03', '07', '', 'Penutup Kepala                ', '       ', '1010307002', '115111'),
(242, '1', '01', '03', '07', '', 'Penutup Badan                 ', '       ', '1010307003', '115111'),
(243, '1', '01', '03', '07', '', 'Penutup Tangan                ', '       ', '1010307004', '115111'),
(244, '1', '01', '03', '07', '', 'Penutup Kaki                  ', '       ', '1010307005', '115111'),
(245, '1', '01', '03', '07', '', 'Atribut                       ', '       ', '1010307006', '115111'),
(246, '1', '01', '03', '07', '', 'Perlengkapan Lapangan         ', '       ', '1010307007', '115111'),
(247, '1', '01', '03', '07', '', 'Perlengkapan Dinas Lainnya    ', '       ', '1010307999', '115111'),
(248, '1', '01', '03', '08', '', 'Kaporlap dan Perlengkapan Satw', '       ', '1010308001', '115111'),
(249, '1', '01', '03', '08', '', 'Kaporlap dan Perlengkapan Satw', '       ', '1010308002', '115111'),
(250, '1', '01', '03', '08', '', 'Kaporlap Dan Perlengkapan Satw', '       ', '1010308999', '115111'),
(251, '1', '01', '03', '99', '', 'Alat/bahan Untuk Kegiatan Kant', '       ', '1010399999', '115111'),
(252, '1', '01', '04', '01', '', 'Obat Cair                     ', '       ', '1010401001', '115199'),
(253, '1', '01', '04', '01', '', 'Obat Padat                    ', '       ', '1010401002', '115199'),
(254, '1', '01', '04', '01', '', 'Obat Gas                      ', '       ', '1010401003', '115199'),
(255, '1', '01', '04', '01', '', 'Obat Serbuk/Tepung            ', '       ', '1010401004', '115199'),
(256, '1', '01', '04', '01', '', 'Obat Gel/Salep                ', '       ', '1010401005', '115199'),
(257, '1', '01', '04', '01', '', 'Alat/Obat Kontrasepsi Keluarga', '       ', '1010401006', '115199'),
(258, '1', '01', '04', '01', '', 'Non Alat/Obat Kontrasepsi Kelu', '       ', '1010401007', '115199'),
(259, '1', '01', '04', '01', '', 'Obat Lainnya                  ', '       ', '1010401999', '115199'),
(260, '1', '01', '05', '01', '', 'Pita Cukai, Materai, Leges    ', '       ', '1010501001', '115121'),
(261, '1', '01', '05', '01', '', 'Tanah dan Bangunan            ', '       ', '1010501002', '115122'),
(262, '1', '01', '05', '01', '', 'Hewan dan Tanaman             ', '       ', '1010501003', '115123'),
(263, '1', '01', '05', '01', '', 'Peralatan dan Mesin           ', '       ', '1010501004', '115124'),
(264, '1', '01', '05', '01', '', 'Jalan, Irigasi, dan Jaringan  ', '       ', '1010501005', '115125'),
(265, '1', '01', '05', '01', '', 'Aset Tetap Lainnya            ', '       ', '1010501006', '115126'),
(266, '1', '01', '05', '01', '', 'Aset Lain-lain                ', '       ', '1010501007', '115127'),
(267, '1', '01', '05', '01', '', 'Barang Persediaan             ', '       ', '1010501008', '115128'),
(268, '1', '01', '06', '01', '', 'Cadangan Energi               ', '       ', '1010601001', '115191'),
(269, '1', '01', '06', '01', '', 'Cadangan Pangan               ', '       ', '1010601002', '115191'),
(270, '1', '01', '06', '01', '', 'Persediaan Untuk Tujuan Strate', '       ', '1010601999', '115191'),
(271, '1', '01', '07', '01', '', 'Makanan/Sembako               ', '       ', '1010701001', '115111'),
(272, '1', '01', '07', '01', '', 'Minuman                       ', '       ', '1010701002', '115111'),
(273, '1', '01', '07', '01', '', 'Natura Lainnya                ', '       ', '1010701999', '115111'),
(274, '1', '01', '07', '02', '', 'Pakan Hewan                   ', '       ', '1010702001', '115111'),
(275, '1', '01', '07', '02', '', 'Pakan Ikan                    ', '       ', '1010702002', '115111'),
(276, '1', '01', '07', '02', '', 'Pakan Lainnya                 ', '       ', '1010702999', '115111'),
(277, '1', '01', '07', '99', '', 'Natura Dan Pakan Lainnya      ', '       ', '1010799999', '115111'),
(278, '1', '01', '08', '01', '', 'Hewan/Ternak                  ', '       ', '1010801001', '115199'),
(279, '1', '01', '08', '01', '', 'Biota Laut/Ikan               ', '       ', '1010801002', '115199'),
(280, '1', '01', '08', '01', '', 'Tanaman                       ', '       ', '1010801003', '115199'),
(281, '1', '01', '08', '01', '', 'Persediaan Penelitian Biologi ', '       ', '1010801999', '115199'),
(282, '1', '02', '01', '01', '', 'Komponen Jembatan Bailley     ', '       ', '1020101001', '115199'),
(283, '1', '02', '01', '01', '', 'Komponen Jembatan Baja Prefab ', '       ', '1020101002', '115199'),
(284, '1', '02', '01', '01', '', 'Komponen Jembatan Baja Lainnya', '       ', '1020101999', '115199'),
(285, '1', '02', '01', '02', '', 'Komponen Jembatan Pratekan Pre', '       ', '1020102001', '115199'),
(286, '1', '02', '01', '02', '', 'Komponen Jembatan Pratekan Lai', '       ', '1020102999', '115199'),
(287, '1', '02', '01', '03', '', 'Dinamo Amper                  ', '       ', '1020103001', '115199'),
(288, '1', '02', '01', '03', '', 'Dinamo Start                  ', '       ', '1020103002', '115199'),
(289, '1', '02', '01', '03', '', 'Transmisi                     ', '       ', '1020103003', '115199'),
(290, '1', '02', '01', '03', '', 'Injection Pump                ', '       ', '1020103004', '115199'),
(291, '1', '02', '01', '03', '', 'Karburator Unit               ', '       ', '1020103005', '115199'),
(292, '1', '02', '01', '03', '', 'Motor Hidrolik                ', '       ', '1020103006', '115199'),
(293, '1', '02', '01', '03', '', 'Engine Bensin                 ', '       ', '1020103007', '115199'),
(294, '1', '02', '01', '03', '', 'Engine Diesel                 ', '       ', '1020103008', '115199'),
(295, '1', '02', '01', '03', '', 'Komponen Peralatan Lainnya    ', '       ', '1020103999', '115199'),
(296, '1', '02', '01', '04', '', 'Komponen Rambu-Rambu Darat    ', '       ', '1020104001', '115199'),
(297, '1', '02', '01', '04', '', 'Komponen Rambu-Rambu Udara    ', '       ', '1020104002', '115199'),
(298, '1', '02', '01', '04', '', 'Komponen Rambu-Rambu Lainnya  ', '       ', '1020104999', '115199'),
(299, '1', '02', '01', '05', '', 'Blade                         ', '       ', '1020105001', '115199'),
(300, '1', '02', '01', '05', '', 'Boom                          ', '       ', '1020105002', '115199'),
(301, '1', '02', '01', '05', '', 'Bucket                        ', '       ', '1020105003', '115199'),
(302, '1', '02', '01', '05', '', 'Scarifier                     ', '       ', '1020105004', '115199'),
(303, '1', '02', '01', '05', '', 'Attachment Lainnya            ', '       ', '1020105999', '115199'),
(304, '1', '02', '01', '99', '', 'Komponen Lainnya              ', '       ', '1020199999', '115199'),
(305, '1', '02', '02', '01', '', 'DCI Filter                    ', '       ', '1020201001', '115199'),
(306, '1', '02', '02', '01', '', 'Pipa Air Besi Tuang           ', '       ', '1020201002', '115199'),
(307, '1', '02', '02', '01', '', 'Pipa Air Besi Tuang (DCI) Lain', '       ', '1020201999', '115199'),
(313, '1', '02', '02', '02', '', 'Pipa Asbes Semen (ACP) Lainnya', '       ', '1020202999', '115199'),
(314, '1', '02', '02', '03', '', 'Pipa Baja Gelombang           ', '       ', '1020203001', '115199'),
(315, '1', '02', '02', '03', '', 'Pipa Baja Konstruksi (CSP)    ', '       ', '1020203002', '115199'),
(316, '1', '02', '02', '03', '', 'Pipa Baja Lapis Polyethelene  ', '       ', '1020203003', '115199'),
(317, '1', '02', '02', '03', '', 'Pipa Baja Lapis Seng (GIP)    ', '       ', '1020203004', '115199'),
(318, '1', '02', '02', '03', '', 'Pipa Baja Lainnya             ', '       ', '1020203999', '115199'),
(319, '1', '02', '02', '04', '', 'Fitter Pipa Beton Pratekan    ', '       ', '1020204001', '115199'),
(320, '1', '02', '02', '04', '', 'Pipa Beton Pratekan           ', '       ', '1020204002', '115199'),
(321, '1', '02', '02', '04', '', 'Pipa Beton Pratekan Lainnya   ', '       ', '1020204999', '115199'),
(322, '1', '02', '02', '05', '', 'Filter Pipa Fiber Glass       ', '       ', '1020205001', '115199'),
(323, '1', '02', '02', '05', '', 'Pipa Fiber Glass              ', '       ', '1020205002', '115199'),
(324, '1', '02', '02', '05', '', 'Pipa Fiber Glass Lainnya      ', '       ', '1020205999', '115199'),
(325, '1', '02', '02', '06', '', 'Pipa Plastik PVC              ', '       ', '1020206001', '115199'),
(326, '1', '02', '02', '06', '', 'UPVC Fitter                   ', '       ', '1020206002', '115199'),
(327, '1', '02', '02', '06', '', 'Pipa Plastik PVC (UPVC) Lainny', '       ', '1020206999', '115199'),
(328, '1', '02', '02', '99', '', 'P I P A Lainnya               ', '       ', '1020299999', '115199'),
(329, '1', '02', '03', '01', '', 'Rambu - Rambu Lalu Lintas     ', '       ', '1020301001', '115199'),
(330, '1', '02', '03', '01', '', 'Rambu-rambu Lainnya           ', '       ', '1020301999', '115199'),
(331, '1', '03', '01', '01', '', 'Komponen Jembatan Baja Bekas  ', '       ', '1030101001', '115199'),
(332, '1', '03', '01', '01', '', 'Komponen Jembatan Pratekan Bek', '       ', '1030101002', '115199'),
(333, '1', '03', '01', '01', '', 'Komponen Peralatan Bekas      ', '       ', '1030101003', '115199'),
(334, '1', '03', '01', '01', '', 'Attachment Bekas              ', '       ', '1030101004', '115199'),
(335, '1', '03', '01', '01', '', 'Kotak dan Bilik Suara         ', '       ', '1030101005', '115199'),
(336, '1', '03', '01', '01', '', 'Komponen Bekas Lainnya        ', '       ', '1030101999', '115199'),
(337, '1', '03', '01', '02', '', 'Pipa Air Besi Tuang Bekas     ', '       ', '1030102001', '115199'),
(338, '1', '03', '01', '02', '', 'Pipa Asbes Semen Bekas        ', '       ', '1030102002', '115199'),
(339, '1', '03', '01', '02', '', 'Pipa Baja Bekas               ', '       ', '1030102003', '115199'),
(340, '1', '03', '01', '02', '', 'Pipa Beton Pratekan Bekas     ', '       ', '1030102004', '115199'),
(341, '1', '03', '01', '02', '', 'Pipa Fiber Gelas Bekas        ', '       ', '1030102005', '115199'),
(342, '1', '03', '01', '02', '', 'Pipa Plastik PVC (UPVC) Bekas ', '       ', '1030102006', '115199'),
(343, '1', '03', '01', '02', '', 'Pipa Bekas Lainnya            ', '       ', '1030102999', '115199'),
(344, '1', '03', '01', '99', '', 'Komponen Bekas Dan Pipa Bekas ', '       ', '1030199999', '115199');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int(11) NOT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `kd_lok_msk` varchar(20) DEFAULT NULL,
  `thn_ang` varchar(4) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `nm_brg` varchar(30) DEFAULT NULL,
  `qty` mediumint(9) NOT NULL,
  `harga_sat` int(11) NOT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trans_klr`
--

CREATE TABLE IF NOT EXISTS `trans_klr` (
  `id` int(11) NOT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `kd_lok_msk` varchar(20) DEFAULT NULL,
  `thn_ang` varchar(4) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trans_msk`
--

CREATE TABLE IF NOT EXISTS `trans_msk` (
  `id` int(11) NOT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `kd_lok_msk` varchar(20) DEFAULT NULL,
  `thn_ang` varchar(4) NOT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trans_msk`
--

INSERT INTO `trans_msk` (`id`, `kd_lokasi`, `kd_lok_msk`, `thn_ang`, `no_dok`, `tgl_dok`, `tgl_buku`, `no_bukti`, `jns_trans`, `keterangan`, `user_id`) VALUES
(1, '018010100010111', '018010100010111', '-- T', 'sdf', '2015-08-06', '2015-08-13', 'sdf', 'M01', 'sdfsdf', 'fikri.fd'),
(2, '018010100010111', '018010100010111', '-- T', 'KPAI10000', '2015-08-07', '2015-08-08', '09976344', 'M01', 'MASUK', 'fikri.fd');

-- --------------------------------------------------------

--
-- Table structure for table `ttd`
--

CREATE TABLE IF NOT EXISTS `ttd` (
  `id` int(11) NOT NULL,
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
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(32) NOT NULL,
  `user_name` varchar(32) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_level` int(4) NOT NULL,
  `kd_lokasi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_level`, `kd_lokasi`) VALUES
(1, 'masteradmin', '0192023a7bbd73250516f069df18b500', 'yohanes.christomas@gmail.com', 1, NULL),
(2, 'masteruser', '0192023a7bbd73250516f069df18b500', 'yohanes.christomas@gmail.com', 2, NULL),
(5, 'fikri.fd', 'e10adc3949ba59abbe56e057f20f883e', 'fikri_fadlillah@yahoo.com', 2, '018010100010111');

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE IF NOT EXISTS `wilayah` (
  `id` int(11) NOT NULL,
  `kd_wil` varchar(10) NOT NULL,
  `nm_wil` varchar(60) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=706 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`id`, `kd_wil`, `nm_wil`) VALUES
(2, '0100', 'DKI JAKARTA         '),
(3, '0151', 'KOTA JAKARTA PUSAT  '),
(4, '0152', 'KOTA JAKARTA UTARA  '),
(5, '0153', 'KOTA JAKARTA BARAT  '),
(6, '0154', 'KOTA JAKARTA SELATAN'),
(7, '0155', 'KOTA JAKARTA TIMUR  '),
(8, '0156', 'KEPULAUAN SEREBU    '),
(9, '0200', 'JAWA BARAT          '),
(10, '0205', 'KAB. BOGOR          '),
(11, '0206', 'KAB. SUKABUMI       '),
(12, '0207', 'KAB. CIANJUR        '),
(13, '0208', 'KAB. BEKASI         '),
(14, '0209', 'KAB. KARAWANG       '),
(15, '0210', 'KAB. PURWAKARTA     '),
(16, '0211', 'KAB. SUBANG         '),
(17, '0212', 'KAB. BANDUNG        '),
(18, '0213', 'KAB. SUMEDANG       '),
(19, '0214', 'KAB. G A R U T      '),
(20, '0215', 'KAB. TASIKMALAYA    '),
(21, '0216', 'KAB. CIAMIS         '),
(22, '0217', 'KAB. CIREBON        '),
(23, '0218', 'KAB. KUNINGAN       '),
(24, '0219', 'KAB. INDRAMAYU      '),
(25, '0220', 'KAB. MAJALENGKA     '),
(26, '0221', 'KAB. BANDUNG BARAT  '),
(27, '0251', 'KOTA BANDUNG        '),
(28, '0252', 'KOTA BOGOR          '),
(29, '0253', 'KOTA SUKABUMI       '),
(30, '0254', 'KOTA CIREBON        '),
(31, '0257', 'KOTA BEKASI         '),
(32, '0258', 'KOTA DEPOK          '),
(33, '0260', 'KOTA TASIKMALAYA    '),
(34, '0261', 'KOTA CIMAHI         '),
(35, '0262', 'KOTA BANJAR         '),
(36, '0300', 'JAWA TENGAH         '),
(37, '0301', 'KAB. SEMARANG       '),
(38, '0302', 'KAB. KENDAL         '),
(39, '0303', 'KAB. DEMAK          '),
(40, '0304', 'KAB. GROBOGAN       '),
(41, '0305', 'KAB. PEKALONGAN     '),
(42, '0306', 'KAB. BATANG         '),
(43, '0307', 'KAB. TEGAL          '),
(44, '0308', 'KAB. BREBES         '),
(45, '0309', 'KAB. PATI           '),
(46, '0310', 'KAB. KUDUS          '),
(47, '0311', 'KAB. PEMALANG       '),
(48, '0312', 'KAB. JEPARA         '),
(49, '0313', 'KAB. REMBANG        '),
(50, '0314', 'KAB. BLORA          '),
(51, '0315', 'KAB. BANYUMAS       '),
(52, '0316', 'KAB. CILACAP        '),
(53, '0317', 'KAB. PURBALINGGA    '),
(54, '0318', 'KAB. BANJARNEGARA   '),
(55, '0319', 'KAB. MAGELANG       '),
(56, '0320', 'KAB. TEMANGGUNG     '),
(57, '0321', 'KAB. WONOSOBO       '),
(58, '0322', 'KAB. PURWOREJO      '),
(59, '0323', 'KAB. KEBUMEN        '),
(60, '0324', 'KAB. KLATEN         '),
(61, '0325', 'KAB. BOYOLALI       '),
(62, '0326', 'KAB. SRAGEN         '),
(63, '0327', 'KAB. SUKOHARJO      '),
(64, '0328', 'KAB. KARANGANYAR    '),
(65, '0329', 'KAB. WONOGIRI       '),
(66, '0330', 'KAB. CEPU           '),
(67, '0351', 'KOTA SEMARANG       '),
(68, '0352', 'KOTA SALATIGA       '),
(69, '0353', 'KOTA PEKALONGAN     '),
(70, '0354', 'KOTA TEGAL          '),
(71, '0355', 'KOTA MAGELANG       '),
(72, '0356', 'KOTA SURAKARTA      '),
(73, '0400', 'DI YOGYAKARTA       '),
(74, '0401', 'KAB. BANTUL         '),
(75, '0402', 'KAB. SLEMAN         '),
(76, '0403', 'KAB. GUNUNGKIDUL    '),
(77, '0404', 'KAB. KULONPROGO     '),
(78, '0451', 'KOTA YOGYAKARTA     '),
(79, '0500', 'JAWA TIMUR          '),
(80, '0501', 'KAB. GRESIK         '),
(81, '0502', 'KAB. MOJOKERTO      '),
(82, '0503', 'KAB. SIDOARJO       '),
(83, '0504', 'KAB. JOMBANG        '),
(84, '0505', 'KAB. SAMPANG        '),
(85, '0506', 'KAB. PAMEKASAN      '),
(86, '0507', 'KAB. SUMENEP        '),
(87, '0508', 'KAB. BANGKALAN      '),
(88, '0509', 'KAB. BONDOWOSO      '),
(89, '0510', 'KAB. SITUBONDO      '),
(90, '0511', 'KAB. BANYUWANGI     '),
(91, '0512', 'KAB. JEMBER         '),
(92, '0513', 'KAB. MALANG         '),
(93, '0514', 'KAB. PASURUAN       '),
(94, '0515', 'KAB. PROBOLINGGO    '),
(95, '0516', 'KAB. LUMAJANG       '),
(96, '0517', 'KAB. KEDIRI         '),
(97, '0518', 'KAB. TULUNGAGUNG    '),
(98, '0519', 'KAB. NGANJUK        '),
(99, '0520', 'KAB. TRENGGALEK     '),
(100, '0521', 'KAB. BLITAR         '),
(101, '0522', 'KAB. MADIUN         '),
(102, '0523', 'KAB. NGAWI          '),
(103, '0524', 'KAB. MAGETAN        '),
(104, '0525', 'KAB. PONOROGO       '),
(105, '0526', 'KAB. PACITAN        '),
(106, '0527', 'KAB. BOJONEGORO     '),
(107, '0528', 'KAB. TUBAN          '),
(108, '0529', 'KAB. LAMONGAN       '),
(109, '0551', 'KOTA SURABAYA       '),
(110, '0552', 'KOTA MOJOKERTO      '),
(111, '0553', 'KOTA MALANG         '),
(112, '0554', 'KOTA PASURUAN       '),
(113, '0555', 'KOTA PROBOLINGGO    '),
(114, '0556', 'KOTA BLITAR         '),
(115, '0557', 'KOTA KEDIRI         '),
(116, '0558', 'KOTA MADIUN         '),
(117, '0559', 'KOTA BATU           '),
(118, '0600', 'NANGGROE ACEH DARUSS'),
(119, '0601', 'KAB. ACEH BESAR     '),
(120, '0602', 'KAB. P I D I E      '),
(121, '0603', 'KAB. ACEH UTARA     '),
(122, '0604', 'KAB. ACEH TIMUR     '),
(123, '0605', 'KAB. ACEH SELATAN   '),
(124, '0606', 'KAB. ACEH BARAT     '),
(125, '0607', 'KAB. ACEH TENGAH    '),
(126, '0608', 'KAB. ACEH TENGGARA  '),
(127, '0609', 'KAB. SIMEULEU       '),
(128, '0610', 'KAB. ACEH SINGKIL   '),
(129, '0611', 'KAB. BIREUN         '),
(130, '0612', 'KAB. ACEH BARAT DAYA'),
(131, '0613', 'KAB. ACEH GAYO LUES '),
(132, '0614', 'KAB. ACEH JAYA      '),
(133, '0615', 'KAB. NAGAN RAYA     '),
(134, '0616', 'KAB. ACEH TAMIANG   '),
(135, '0617', 'KAB. BENER MERIAH   '),
(136, '0618', 'KAB. PIDIE JAYA     '),
(137, '0651', 'KOTA BANDA ACEH     '),
(138, '0652', 'KOTA SABANG         '),
(139, '0653', 'KOTA LANGSA         '),
(140, '0654', 'KOTA LHOKSEUMAWE    '),
(141, '0655', 'KOTA  MEULABOH      '),
(142, '0656', 'KOTA SUMBULUSSALAM  '),
(143, '0700', 'SUMATERA UTARA      '),
(144, '0701', 'KAB. DELISERDANG    '),
(145, '0702', 'KAB. KARO           '),
(146, '0703', 'KAB. LANGKAT        '),
(147, '0704', 'KAB. TAPANULI TENGAH'),
(148, '0705', 'KAB. SIMALUNGUN     '),
(149, '0706', 'KAB. LABUHANBATU    '),
(150, '0707', 'KAB. D A I R I      '),
(151, '0708', 'KAB. TAPANULI UTARA '),
(152, '0709', 'KAB. TAPANULI SELATA'),
(153, '0710', 'KAB. ASAHAN         '),
(154, '0711', 'KAB. N  I  A  S     '),
(155, '0712', 'KAB. SAMOSIR        '),
(156, '0713', 'KAB. MANDAILING NATA'),
(157, '0714', 'KAB. NIAS SELATAN   '),
(158, '0715', 'KAB. PAKPAK BARAT   '),
(159, '0716', 'KAB. HUMBANG HASUNDU'),
(160, '0717', 'KAB. TOBA SAMOSIR   '),
(161, '0718', 'KAB. TARUTUNG       '),
(162, '0720', 'KAB. SERDANG BEDAGAI'),
(163, '0721', 'KAB. BATUBARA       '),
(164, '0722', 'KAB. PADANG LAWAS   '),
(165, '0723', 'KAB. PADANG LAWAS UT'),
(166, '0724', 'KAB. LABUHAN BATU SE'),
(167, '0725', 'KAB. LABUHAN BATU UT'),
(168, '0726', 'KAB. NIAS UTARA     '),
(169, '0727', 'KAB. NIAS BARAT     '),
(170, '0751', 'KOTA MEDAN          '),
(171, '0752', 'KOTA TEBINGTINGGI   '),
(172, '0753', 'KOTA B I N J A I    '),
(173, '0754', 'KOTA PEMATANGSIANTAR'),
(174, '0755', 'KOTA TANJUNGBALAI   '),
(175, '0756', 'KOTA SIBOLGA        '),
(176, '0757', 'KOTA PADANG SIDEMPUA'),
(177, '0758', 'KOTA STABAT         '),
(178, '0759', 'KOTA LUBUK PAKAM    '),
(179, '0760', 'KOTA SIDI KALANG    '),
(180, '0761', 'KOTA GUNUNG SITOLI  '),
(181, '0800', 'SUMATERA BARAT      '),
(182, '0801', 'KAB. A G A M        '),
(183, '0802', 'KAB. PASAMAN        '),
(184, '0803', 'KAB. LIMAPULUH KOTA '),
(185, '0804', 'KAB. S O L O K      '),
(186, '0805', 'KAB. PADANG PARIAMAN'),
(187, '0806', 'KAB. PESISIR SELATAN'),
(188, '0807', 'KAB. TANAH DATAR    '),
(189, '0808', 'KAB. SAWAHLUNTO     '),
(190, '0809', 'KAB. KEPULAUAN MENTA'),
(191, '0810', 'KAB. DHARMAS RAYA   '),
(192, '0811', 'KAB. SOLOK SELATAN  '),
(193, '0812', 'KAB. PASAMAN BARAT  '),
(194, '0813', 'KAB. SIJUNJUNG      '),
(195, '0814', 'KAB. SAWAHLUNTO SIJU'),
(196, '0851', 'KOTA BUKITTINGGI    '),
(197, '0852', 'KOTA PADANG PANJANG '),
(198, '0853', 'KOTA S O L O K      '),
(199, '0854', 'KOTA SAWAHLUNTO     '),
(200, '0855', 'KOTA PADANG         '),
(201, '0856', 'KOTA PAYAKUMBUH     '),
(202, '0857', 'KOTA PARIAMAN       '),
(203, '0858', 'KOTA LUBUK SIKAPING '),
(204, '0859', 'KOTA PAINAN         '),
(205, '0900', 'RIAU                '),
(206, '0901', 'KAB. KAMPAR         '),
(207, '0902', 'KAB. BENGKALIS      '),
(208, '0904', 'KAB. INDRAGIRI HULU '),
(209, '0905', 'KAB. INDRAGIRI HILIR'),
(210, '0906', 'KAB. PELALAWAN      '),
(211, '0907', 'KAB. ROKAN HULU     '),
(212, '0908', 'KAB. ROKAN HILIR    '),
(213, '0909', 'KAB. SIAK           '),
(214, '0912', 'KAB. KUANTAN SINGING'),
(215, '0913', 'KAB. KEPULAUAN MERAN'),
(216, '0951', 'KOTA PEKANBARU      '),
(217, '0953', 'KOTA DUMAI          '),
(218, '0954', 'KOTA RENGAT         '),
(219, '0955', 'OTORITA BATAM       '),
(220, '1000', 'JAMBI               '),
(221, '1001', 'KAB. BATANGHARI     '),
(222, '1002', 'KAB. TANJUNG JABUNG '),
(223, '1003', 'KAB. BUNGO          '),
(224, '1004', 'KAB. SAROLANGUN     '),
(225, '1005', 'KAB. KERINCI        '),
(226, '1006', 'KAB. MERANGIN       '),
(227, '1007', 'KAB. TANJUNG JABUNG '),
(228, '1008', 'KAB. T E B O        '),
(229, '1009', 'KAB. MUARO JAMBI    '),
(230, '1051', 'KOTA JAMBI          '),
(231, '1052', 'KOTA SUNGAI PENUH   '),
(232, '1100', 'SUMATERA SELATAN    '),
(233, '1103', 'KAB. MUSI BANYU ASIN'),
(234, '1104', 'KAB. OGAN KOMERING U'),
(235, '1105', 'KAB. MUARA ENIM     '),
(236, '1106', 'KAB. L A H A T      '),
(237, '1107', 'KAB. MUSI RAWAS     '),
(238, '1108', 'KAB. OGAN KOMERING I'),
(239, '1109', 'KAB. BANYUASIN      '),
(240, '1110', 'KAB. OKU TIMUR      '),
(241, '1111', 'KAB. OKU SELATAN    '),
(242, '1112', 'KAB. OGAN ILIR      '),
(243, '1113', 'KAB. OKU UTARA      '),
(244, '1115', 'KAB. IDRALAYA       '),
(245, '1116', 'KAB. BATU RAJA      '),
(246, '1117', 'KAB. EMPAT LAWANG   '),
(247, '1151', 'KOTA PALEMBANG      '),
(248, '1153', 'KOTA PRABUMULIH     '),
(249, '1154', 'KOTA PAGAR ALAM     '),
(250, '1155', 'KOTA LUBUK LINGGAU  '),
(251, '1200', 'LAMPUNG             '),
(252, '1201', 'KAB. LAMPUNG SELATAN'),
(253, '1202', 'KAB. LAMPUNG TENGAH '),
(254, '1203', 'KAB. LAMPUNG UTARA  '),
(255, '1204', 'KAB. LAMPUNG BARAT  '),
(256, '1205', 'KAB. TULANG BAWANG  '),
(257, '1206', 'KAB. TANGGAMUS      '),
(258, '1207', 'KAB. LAMPUNG TIMUR  '),
(259, '1208', 'KAB. WAY KANAN      '),
(260, '1209', 'KAB. PESAWARAN      '),
(261, '1210', 'KAB. PRINGSEWU      '),
(262, '1211', 'KAB. MESUJI         '),
(263, '1212', 'KAB. TULANG BAWANG B'),
(264, '1251', 'KOTA BANDAR LAMPUNG '),
(265, '1252', 'KOTA METRO          '),
(266, '1300', 'KALIMANTAN BARAT    '),
(267, '1301', 'KAB. SAMBAS         '),
(268, '1302', 'KAB. SANGGAU        '),
(269, '1303', 'KAB. SINTANG        '),
(270, '1304', 'KAB. PONTIANAK      '),
(271, '1305', 'KAB. KAPUAS HULU    '),
(272, '1306', 'KAB. KETAPANG       '),
(273, '1307', 'KAB. BENGKAYANG     '),
(274, '1308', 'KAB. LANDAK         '),
(275, '1309', 'KAB. MELAWI         '),
(276, '1310', 'KAB. SEKADAU        '),
(277, '1311', 'KAB. KAYONG UTARA   '),
(278, '1312', 'KAB. KUBU RAYA      '),
(279, '1351', 'KOTA PONTIANAK      '),
(280, '1352', 'KOTA SINGKAWANG     '),
(281, '1400', 'KALIMANTAN TENGAH   '),
(282, '1401', 'KAB. KAPUAS         '),
(283, '1402', 'KAB. BARITO UTARA   '),
(284, '1403', 'KAB. BARITO SELATAN '),
(285, '1404', 'KAB. KOTAWARINGIN TI'),
(286, '1405', 'KAB. KOTAWARINGIN BA'),
(287, '1406', 'KAB. KATINGAN       '),
(288, '1407', 'KAB. SERUYAN        '),
(289, '1408', 'KAB. SUKAMARA       '),
(290, '1409', 'KAB. LAMANDAU       '),
(291, '1410', 'KAB. GUNUNG MAS     '),
(292, '1411', 'KAB. PULANG PISAU   '),
(293, '1412', 'KAB. MURUNG RAYA    '),
(294, '1413', 'KAB. BARITO TIMUR   '),
(295, '1451', 'KOTA PALANGKARAYA   '),
(296, '1500', 'KALIMANTAN SELATAN  '),
(297, '1501', 'KAB. BANJAR         '),
(298, '1502', 'KAB. TANAH LAUT     '),
(299, '1503', 'KAB. TAPIN          '),
(300, '1504', 'KAB. HULU SUNGAI SEL'),
(301, '1505', 'KAB. HULU SUNGAI TEN'),
(302, '1506', 'KAB. BARITO KUALA   '),
(303, '1507', 'KAB. TABALONG       '),
(304, '1508', 'KAB. KOTABARU       '),
(305, '1509', 'KAB. HULU SUNGAI UTA'),
(306, '1510', 'KAB. TANAH BUMBU    '),
(307, '1511', 'KAB. BALANGAN       '),
(308, '1551', 'KOTA BANJARMASIN    '),
(309, '1552', 'KOTA BANJARBARU     '),
(310, '1600', 'KALIMANTAN TIMUR    '),
(311, '1601', 'KAB. K U T A I      '),
(312, '1602', 'KAB. P A S E R      '),
(313, '1603', 'KAB. BULUNGAN       '),
(314, '1604', 'KAB. B E R A U      '),
(315, '1605', 'KAB. NUNUKAN        '),
(316, '1606', 'KAB. MALINAU        '),
(317, '1607', 'KAB. KUTAI BARAT    '),
(318, '1608', 'KAB. KUTAI TIMUR    '),
(319, '1609', 'KAB. PENAJAM PASER U'),
(320, '1610', 'KAB. KUTAI KERTANEGA'),
(321, '1611', 'TENGGARONG          '),
(322, '1612', 'KAB. TANA TIDUNG    '),
(323, '1651', 'KOTA SAMARINDA      '),
(324, '1652', 'KOTA BALIKPAPAN     '),
(325, '1653', 'KOTA TARAKAN        '),
(326, '1654', 'KOTA BONTANG        '),
(327, '1700', 'SULAWESI UTARA      '),
(328, '1702', 'KAB. MINAHASA       '),
(329, '1703', 'KAB. BOLAANG MONGOND'),
(330, '1704', 'KAB. KEPULAUAN SANGI'),
(331, '1705', 'KAB. KEPULAUAN TALAU'),
(332, '1706', 'KAB. MINAHASA SELATA'),
(333, '1707', 'KAB. TOMOHON        '),
(334, '1708', 'KAB. MINAHASA UTARA '),
(335, '1709', 'KAB. KEP.SANGIHE TAL'),
(336, '1710', 'KAB. MINAHASA TENGGA'),
(337, '1711', 'KAB. BOLAANG MONGOND'),
(338, '1712', 'KAB. KEP. SIAU TAGUL'),
(339, '1713', 'KAB. BOLAANG MONGOND'),
(340, '1714', 'KAB. BOLAANG MONGOND'),
(341, '1751', 'KOTA MANADO         '),
(342, '1752', 'KOTA TOMOHON        '),
(343, '1753', 'KOTA BITUNG         '),
(344, '1754', 'KOTA KOTAMOBAGO     '),
(345, '1800', 'SULAWESI TENGAH     '),
(346, '1801', 'KAB. P O S O        '),
(347, '1802', 'KAB. DONGGALA       '),
(348, '1803', 'KAB. TOLI-TOLI      '),
(349, '1804', 'KAB. BANGGAI        '),
(350, '1805', 'KAB. B U O L        '),
(351, '1806', 'KAB. MOROWALI       '),
(352, '1807', 'KAB. BANGGAI KEPULAU'),
(353, '1808', 'KAB. PARIGI MOUTONG '),
(354, '1809', 'KAB. TOJO UNA-UNA   '),
(355, '1812', 'KAB. SIGI           '),
(356, '1851', 'KOTA PALU           '),
(357, '1900', 'SULAWESI SELATAN    '),
(358, '1901', 'KAB. PINRANG        '),
(359, '1902', 'KAB. GOWA           '),
(360, '1903', 'KAB. WAJO           '),
(361, '1905', 'KAB. BONE           '),
(362, '1906', 'KAB. TANATORAJA     '),
(363, '1907', 'KAB. MAROS          '),
(364, '1909', 'KAB. LUWU           '),
(365, '1910', 'KAB. SINJAI         '),
(366, '1911', 'KAB. BULUKUMBA      '),
(367, '1912', 'KAB. BANTAENG       '),
(368, '1913', 'KAB. JENEPONTO      '),
(369, '1914', 'KAB. KEPULAUAN SELAY'),
(370, '1915', 'KAB. TAKALAR        '),
(371, '1916', 'KAB. BARRU          '),
(372, '1917', 'KAB. SIDENRENG RAPPA'),
(373, '1918', 'KAB. PANGKAJENE KEPU'),
(374, '1919', 'KAB. SOPPENG        '),
(375, '1921', 'KAB. ENREKANG       '),
(376, '1922', 'KAB. LUWU UTARA     '),
(377, '1924', 'KAB. LUWU TIMUR     '),
(378, '1925', 'KAB. TORAJA UTARA   '),
(379, '1951', 'KOTA MAKASSAR       '),
(380, '1952', 'KOTA PARE-PARE      '),
(381, '1953', 'KOTA PALOPO         '),
(382, '2000', 'SULAWESI TENGGARA   '),
(383, '2001', 'KAB. KENDARI (SDH TI'),
(384, '2002', 'KAB. BUTON          '),
(385, '2003', 'KAB. MUNA           '),
(386, '2004', 'KAB. KOLAKA         '),
(387, '2005', 'KAB. KONAWE SELATAN '),
(388, '2006', 'KAB. BOMBANA        '),
(389, '2007', 'KAB. WAKATOBI       '),
(390, '2008', 'KAB. KOLAKA UTARA   '),
(391, '2009', 'KAB. KONAWE         '),
(392, '2010', 'KAB. KONAWE UTARA   '),
(393, '2011', 'KAB. BUTON UTARA    '),
(394, '2051', 'KOTA KENDARI        '),
(395, '2052', 'KOTA BAU-BAU        '),
(396, '2100', 'MALUKU              '),
(397, '2101', 'KAB. MALUKU TENGAH  '),
(398, '2102', 'KAB. MALUKU TENGGARA'),
(399, '2103', 'KAB. MALUKU TENGGARA'),
(400, '2104', 'KAB. PULAU BURU     '),
(401, '2105', 'KAB. KEPULAUAN ARU  '),
(402, '2106', 'KAB. SERAM BAGIAN BA'),
(403, '2107', 'KAB. SERAM BAGIAN TI'),
(404, '2108', 'KAB. MALUKU         '),
(405, '2109', 'KAB. MALUKU BARAT DA'),
(406, '2110', 'KAB. BURU SELATAN   '),
(407, '2151', 'KOTA AMBON          '),
(408, '2152', 'KOTA TUAL           '),
(409, '2200', 'BALI                '),
(410, '2201', 'KAB. BULELENG       '),
(411, '2202', 'KAB. JEMBRANA       '),
(412, '2203', 'KAB. KLUNGKUNG      '),
(413, '2204', 'KAB. GIANYAR        '),
(414, '2205', 'KAB. KARANGASEM     '),
(415, '2206', 'KAB. BANGLI         '),
(416, '2207', 'KAB. BADUNG         '),
(417, '2208', 'KAB. TABANAN        '),
(418, '2209', 'KAB. NEGARA         '),
(419, '2251', 'KOTA DENPASAR       '),
(420, '2300', 'NUSA TENGGARA BARAT '),
(421, '2301', 'KAB. LOMBOK BARAT   '),
(422, '2302', 'KAB. LOMBOK TENGAH  '),
(423, '2303', 'KAB. LOMBOK TIMUR   '),
(424, '2304', 'KAB. B I M A        '),
(425, '2305', 'KAB. SUMBAWA        '),
(426, '2306', 'KAB. DOMPU          '),
(427, '2307', 'KAB. SUMBAWA BARAT  '),
(428, '2308', 'KAB. LOMBOK UTARA   '),
(429, '2351', 'KOTA MATARAM        '),
(430, '2352', 'KOTA BIMA           '),
(431, '2400', 'NUSA TENGGARA TIMUR '),
(432, '2401', 'KAB. KUPANG         '),
(433, '2402', 'KAB. B E L U        '),
(434, '2403', 'KAB. TIMOR TENGAH UT'),
(435, '2404', 'KAB. TIMOR TENGAH SE'),
(436, '2405', 'KAB. A L O R        '),
(437, '2406', 'KAB. S I K K A      '),
(438, '2407', 'KAB. FLORES TIMUR   '),
(439, '2408', 'KAB. E N D E        '),
(440, '2409', 'KAB. NGADA          '),
(441, '2410', 'KAB. MANGGARAI      '),
(442, '2411', 'KAB. SUMBA TIMUR    '),
(443, '2412', 'KAB. SUMBA BARAT    '),
(444, '2413', 'KAB. LEMBATA        '),
(445, '2414', 'KAB. ROTE NDAO      '),
(446, '2415', 'KAB. MANGGARAI BARAT'),
(447, '2416', 'KAB. TIMOR          '),
(448, '2417', 'KAB. NAGEKEO        '),
(449, '2418', 'KAB. SUMBA TENGAH   '),
(450, '2419', 'KAB. SUMBA BARAT DAY'),
(451, '2420', 'MANGGARAI TIMUR     '),
(452, '2421', 'KAB. SABU RAIJUA    '),
(453, '2451', 'KOTA KUPANG         '),
(454, '2453', 'KAB. RUTENG         '),
(455, '2500', 'PAPUA               '),
(456, '2501', 'KAB. JAYAPURA       '),
(457, '2502', 'KAB. BIAK-NUMFOR    '),
(458, '2504', 'KAB. KEPULAUAN YAPEN'),
(459, '2507', 'KAB. MERAUKE        '),
(460, '2508', 'KAB. JAYAWIJAYA     '),
(461, '2509', 'KAB. PANIAI         '),
(462, '2510', 'KAB. NABIRE         '),
(463, '2511', 'KAB. PUNCAK JAYA    '),
(464, '2512', 'KAB. MIMIKA         '),
(465, '2513', 'KAB. MAPPI          '),
(466, '2514', 'KAB. ASMAT          '),
(467, '2515', 'KAB. BOVEN DIGOEL   '),
(468, '2516', 'KAB. SARMI          '),
(469, '2517', 'KAB. KEEROM         '),
(470, '2518', 'KAB. TOLIKARA       '),
(471, '2519', 'KAB. PEGUNUNGAN BINT'),
(472, '2520', 'KAB. MAMBERAMO RAYA '),
(473, '2523', 'KAB. WAROPEN        '),
(474, '2524', 'KAB. YAHUKIMO       '),
(475, '2527', 'KAB. SUPIORI        '),
(476, '2528', 'MAMBERAMO TENGAH    '),
(477, '2529', 'KAB. LANNY JAYA     '),
(478, '2530', 'DOGIYAI             '),
(479, '2531', 'YALIMO              '),
(480, '2532', 'NDUGA               '),
(481, '2533', 'KAB. PUNCAK         '),
(482, '2534', 'KAB. DAYAI          '),
(483, '2535', 'KAB. INTAN JAYA     '),
(484, '2536', 'KAB. DEIYAI         '),
(485, '2551', 'KOTA JAYAPURA       '),
(486, '2600', 'BENGKULU            '),
(487, '2601', 'KAB. BENGKULU UTARA '),
(488, '2602', 'KAB. BENGKULU SELATA'),
(489, '2603', 'KAB. REJANG LEBONG  '),
(490, '2604', 'KAB. SELUMA         '),
(491, '2605', 'KAB. K A U R        '),
(492, '2606', 'KAB. MUKO-MUKO      '),
(493, '2607', 'KAB. LEBONG         '),
(494, '2608', 'KAB. KEPAHIANG      '),
(495, '2609', 'KAB. BENGKULU TENGAH'),
(496, '2651', 'KOTA BENGKULU       '),
(497, '2800', 'MALUKU UTARA        '),
(498, '2801', 'KAB. MALUKU UTARA   '),
(499, '2802', 'KAB. HALMAHERA TENGA'),
(500, '2803', 'KAB. HALMAHERA UTARA'),
(501, '2804', 'KAB. HALMAHERA SELAT'),
(502, '2805', 'KAB. KEPULAUAN SULA '),
(503, '2806', 'KAB. HALMAHERA TIMUR'),
(504, '2807', 'KAB. HALMAHERA BARAT'),
(505, '2808', 'KAB. PULAU MOROTAI  '),
(506, '2851', 'KOTA TERNATE        '),
(507, '2852', 'KOTA TIDORE         '),
(508, '2853', 'KOTA TIDORE KEPULAUA'),
(509, '2900', 'BANTEN              '),
(510, '2901', 'KAB. SERANG         '),
(511, '2902', 'KAB. PANDEGLANG     '),
(512, '2903', 'KAB. LEBAK          '),
(513, '2904', 'KAB. TANGERANG      '),
(514, '2951', 'KOTA TANGERANG      '),
(515, '2952', 'KOTA CILEGON        '),
(516, '2953', 'KOTA SERANG         '),
(517, '2954', 'KOTA TANGERANG  SELA'),
(518, '3000', 'BANGKA BELITUNG     '),
(519, '3001', 'KAB. BELITUNG       '),
(520, '3002', 'KAB. BANGKA         '),
(521, '3003', 'KAB. BANGKA BARAT   '),
(522, '3004', 'KAB. BANGKA TENGAH  '),
(523, '3005', 'KAB. BANGKA SELATAN '),
(524, '3006', 'KAB. BELITUNG TIMUR '),
(525, '3007', 'KAB. SUNGAI LIAT    '),
(526, '3051', 'KOTA PANGKALPINANG  '),
(527, '3100', 'GORONTALO           '),
(528, '3101', 'KAB. GORONTALO      '),
(529, '3102', 'KAB. BOALEMO        '),
(530, '3103', 'KAB. POHUWATO       '),
(531, '3104', 'KAB. BONE BOLANGO   '),
(532, '3105', 'KAB. LIMBOTO        '),
(533, '3106', 'KAB. MARISA         '),
(534, '3107', 'KAB. GORONTALO UTARA'),
(535, '3151', 'KOTA GORONTALO      '),
(536, '3200', 'KEPULAUAN RIAU      '),
(537, '3201', 'KAB. BINTAN         '),
(538, '3202', 'KAB. KARIMUN        '),
(539, '3203', 'KAB. NATUNA         '),
(540, '3204', 'KAB. LINGGA         '),
(541, '3205', 'KAB. ANAMBAS        '),
(542, '3206', 'KAB. BARELANG       '),
(543, '3207', 'KAB. MERANTI        '),
(544, '3251', 'KOTA BATAM          '),
(545, '3252', 'KOTA TANJUNG PINANG '),
(546, '3300', 'PAPUA BARAT         '),
(547, '3301', 'KAB. MANOKWARI      '),
(548, '3302', 'KAB. SORONG         '),
(549, '3303', 'KAB. FAK FAK        '),
(550, '3304', 'KAB. SORONG SELATAN '),
(551, '3305', 'KAB. RAJA AMPAT     '),
(552, '3306', 'KAB. TELUK BINTUNI  '),
(553, '3307', 'KAB. TELUK WONDAMA  '),
(554, '3308', 'KAB. KAIMANA        '),
(555, '3309', 'KAB. TAMBRAUW       '),
(556, '3310', 'KAB. MAYBRAT        '),
(557, '3351', 'KOTA SORONG         '),
(558, '3400', 'PROP. SULAWESI BARAT'),
(559, '3401', 'KAB. MAJENE         '),
(560, '3402', 'KAB. MAMUJU         '),
(561, '3403', 'KAB. MAMUJU UTARA   '),
(562, '3404', 'KAB. POLEWALI MANDAR'),
(563, '3405', 'KAB. MAMASA         '),
(564, '3451', 'MAMUJU              '),
(565, '5001', 'PERWAKILAN RI DI LUA'),
(566, '5100', 'AMERIKA UTARA       '),
(567, '5101', 'WASHINGTON DC       '),
(568, '5102', 'NEW YORK KJRI       '),
(569, '5103', 'NEW YORK PTRI       '),
(570, '5104', 'CHICAGO             '),
(571, '5105', 'LOS ANGELES         '),
(572, '5106', 'SAN FRANSISCO       '),
(573, '5107', 'HOUSTON             '),
(574, '5108', 'OTTAWA              '),
(575, '5109', 'VANCOUVER           '),
(576, '5110', 'TORONTO             '),
(577, '5111', 'PANAMA CITY         '),
(578, '5200', 'AMERIKA SELATAN     '),
(579, '5201', 'HAVANA              '),
(580, '5202', 'MEXICO CITY         '),
(581, '5203', 'BOGOTA              '),
(582, '5204', 'CARACAS             '),
(583, '5205', 'PARAMARIBO          '),
(584, '5206', 'BUENOS AIRES        '),
(585, '5207', 'SANTIAGO            '),
(586, '5208', 'BRAZILIA            '),
(587, '5209', 'LIMA                '),
(588, '5210', 'QUITO               '),
(589, '5300', 'EROPA TIMUR DAN UTAR'),
(590, '5301', 'WARSAWA             '),
(591, '5302', 'BUDHAPEST           '),
(592, '5303', 'BUKHAREST           '),
(593, '5304', 'PRAHA               '),
(594, '5305', 'BRATISLAWA          '),
(595, '5306', 'SOFIA               '),
(596, '5307', 'BEOGRAD             '),
(597, '5308', 'TASKHENT            '),
(598, '5309', 'KIEV                '),
(599, '5310', 'MOSKOW              '),
(600, '5311', 'HELSINKI            '),
(601, '5312', 'ROMA                '),
(602, '5313', 'STOCKHOLM           '),
(603, '5314', 'VATICAN             '),
(604, '5315', 'LISABON             '),
(605, '5316', 'ZAGREB              '),
(606, '5317', 'ZAGREB              '),
(607, '5400', 'EROPA BARAT         '),
(608, '5401', 'LONDON              '),
(609, '5402', 'BRUSSEL PRI         '),
(610, '5403', 'BRUSSEL KBRI        '),
(611, '5404', 'DEN HAAG            '),
(612, '5405', 'FRANKFURT           '),
(613, '5406', 'BERLIN              '),
(614, '5407', 'HAMBURG             '),
(615, '5408', 'BERN                '),
(616, '5409', 'JENEWA              '),
(617, '5410', 'PARIS               '),
(618, '5411', 'MARSEILLES          '),
(619, '5412', 'KOPENHAGEN          '),
(620, '5413', 'OSLO                '),
(621, '5414', 'WIENA               '),
(622, '5415', 'MADRID              '),
(623, '5500', 'AFRIKA              '),
(624, '5501', 'KHARTOUM            '),
(625, '5502', 'TUNIS               '),
(626, '5503', 'RABBAT              '),
(627, '5504', 'ALJAZAIR            '),
(628, '5505', 'LAGOS               '),
(629, '5506', 'DAKAR               '),
(630, '5507', 'ADDIS ABABA         '),
(631, '5508', 'NAIROBI             '),
(632, '5509', 'DAR ES SALAM        '),
(633, '5510', 'WINDHOEK            '),
(634, '5511', 'HARARE              '),
(635, '5512', 'TANANARIVE          '),
(636, '5513', 'PRETORIA            '),
(637, '5514', 'CAPE TOWN           '),
(638, '5515', 'TRIPOLI             '),
(639, '5516', 'ABUJA               '),
(640, '5517', 'MAPUTO              '),
(641, '5600', 'ASIA TENGAH DAN TIMU'),
(642, '5601', 'KABOUL              '),
(643, '5602', 'NEW DELHI           '),
(644, '5603', 'MUMBAY              '),
(645, '5604', 'ISLAMABAD           '),
(646, '5605', 'KARACHI             '),
(647, '5606', 'DHAKA               '),
(648, '5607', 'COLOMBO             '),
(649, '5608', 'TOKYO               '),
(650, '5609', 'OSAKA               '),
(651, '5610', 'SEOUL               '),
(652, '5611', 'PYONGYANG           '),
(653, '5612', 'BEIJING             '),
(654, '5613', 'HONGKONG            '),
(655, '5614', 'PHNOM PENH          '),
(656, '5615', 'GUANGZHOU           '),
(657, '5616', 'ASTANA              '),
(658, '5617', 'BAKU                '),
(659, '5700', 'ASIA PASIFIK        '),
(660, '5701', 'CANBERRA            '),
(661, '5702', 'PERTH               '),
(662, '5703', 'DARWIN              '),
(663, '5704', 'MELBOURNE           '),
(664, '5705', 'SYDNEY              '),
(665, '5706', 'WELLINGTON          '),
(666, '5707', 'NOUMEA              '),
(667, '5708', 'DILLI, KUKRI        '),
(668, '5709', 'PORT MORESBY        '),
(669, '5710', 'VANIMO              '),
(670, '5711', 'SUVA                '),
(671, '5800', 'ASIA TENGGARA       '),
(672, '5801', 'HANOI               '),
(673, '5802', 'HO CHI MINH         '),
(674, '5803', 'VIENTIANE           '),
(675, '5804', 'YANGOON             '),
(676, '5805', 'BANGKOK             '),
(677, '5806', 'SONGKLA             '),
(678, '5807', 'KUALA LUMPUR        '),
(679, '5808', 'PENANG              '),
(680, '5809', 'KOTA KINABALU       '),
(681, '5810', 'JAHOR BAHRU         '),
(682, '5811', 'BANDAR SRI BEGAWAN  '),
(683, '5812', 'SINGAPURA           '),
(684, '5813', 'MANILA              '),
(685, '5814', 'DAVAO CITY          '),
(686, '5815', 'KUCHING             '),
(687, '5816', 'TAWAU               '),
(688, '5900', 'TIMUR TENGAH        '),
(689, '5901', 'ANKARA              '),
(690, '5902', 'DAMASCUS            '),
(691, '5903', 'BEIRUT              '),
(692, '5904', 'SANA''A              '),
(693, '5905', 'RIYADH              '),
(694, '5906', 'JEDDAH              '),
(695, '5907', 'KUWAIT              '),
(696, '5908', 'ABU DHABI           '),
(697, '5909', 'AMMAN               '),
(698, '5910', 'TEHERAN             '),
(699, '5911', 'BAGHDAD             '),
(700, '5912', 'DOHA                '),
(701, '5913', 'CAIRO               '),
(702, '5914', 'ATHENA              '),
(703, '5915', 'DUBAI               '),
(704, '5916', 'MANAMA              '),
(705, '5917', 'MUSCAT              ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_klr`
--
ALTER TABLE `barang_klr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_msk`
--
ALTER TABLE `barang_msk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_opsik`
--
ALTER TABLE `barang_opsik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brg`
--
ALTER TABLE `brg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gol`
--
ALTER TABLE `gol`
  ADD PRIMARY KEY (`kd_gol`);

--
-- Indexes for table `jns_transaksi`
--
ALTER TABLE `jns_transaksi`
  ADD PRIMARY KEY (`kd_trans`);

--
-- Indexes for table `kanwil`
--
ALTER TABLE `kanwil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kel`
--
ALTER TABLE `kel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opsik`
--
ALTER TABLE `opsik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perk`
--
ALTER TABLE `perk`
  ADD PRIMARY KEY (`kd_perk`);

--
-- Indexes for table `satker`
--
ALTER TABLE `satker`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skel`
--
ALTER TABLE `skel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sskel`
--
ALTER TABLE `sskel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_klr`
--
ALTER TABLE `trans_klr`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_msk`
--
ALTER TABLE `trans_msk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ttd`
--
ALTER TABLE `ttd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `barang_klr`
--
ALTER TABLE `barang_klr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `barang_msk`
--
ALTER TABLE `barang_msk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `barang_opsik`
--
ALTER TABLE `barang_opsik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bid`
--
ALTER TABLE `bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `brg`
--
ALTER TABLE `brg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `kanwil`
--
ALTER TABLE `kanwil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `kel`
--
ALTER TABLE `kel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `opsik`
--
ALTER TABLE `opsik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `satker`
--
ALTER TABLE `satker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=409;
--
-- AUTO_INCREMENT for table `skel`
--
ALTER TABLE `skel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sskel`
--
ALTER TABLE `sskel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=345;
--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trans_klr`
--
ALTER TABLE `trans_klr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `trans_msk`
--
ALTER TABLE `trans_msk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ttd`
--
ALTER TABLE `ttd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(32) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=706;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
