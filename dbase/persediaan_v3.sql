-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2015 at 05:08 
-- Server version: 5.6.24
-- PHP Version: 5.5.24

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
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

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
(94, '123', '01', '920', 'Dummy Data'),
(96, '001', '01', '001', 'KANWIL JAKARTA UTARA NYA');

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
-- Table structure for table `log_history`
--

CREATE TABLE IF NOT EXISTS `log_history` (
  `id` int(255) NOT NULL,
  `kodesatker` varchar(24) DEFAULT NULL,
  `namasatker` text,
  `thnanggaran` int(6) NOT NULL,
  `username` varchar(32) NOT NULL,
  `aksi` varchar(16) NOT NULL,
  `ket_kdsatker` varchar(16) NOT NULL,
  `ket_nmsatker` text NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `opname`
--

CREATE TABLE IF NOT EXISTS `opname` (
  `id` int(11) NOT NULL,
  `id_masuk` int(11) DEFAULT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `kd_lok_msk` varchar(20) DEFAULT NULL,
  `nm_satker` varchar(40) DEFAULT NULL,
  `thn_ang` year(4) DEFAULT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `kd_sskel` varchar(15) DEFAULT NULL,
  `nm_sskel` varchar(30) DEFAULT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `nm_brg` varchar(30) DEFAULT NULL,
  `kd_perk` varchar(7) DEFAULT NULL,
  `nm_perk` varchar(20) DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `qty` mediumint(9) NOT NULL,
  `harga_sat` int(11) NOT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `status_edit` tinyint(1) NOT NULL DEFAULT '0',
  `status_hapus` tinyint(1) NOT NULL DEFAULT '0',
  `status_ambil` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_update` date DEFAULT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `persediaan`
--

CREATE TABLE IF NOT EXISTS `persediaan` (
  `id` int(11) NOT NULL,
  `kd_kbrg` varchar(20) NOT NULL,
  `nm_sskel` varchar(20) DEFAULT NULL,
  `kd_jbrg` varchar(10) NOT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `nm_brg` varchar(30) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `kd_perk` varchar(10) NOT NULL,
  `nm_perk` varchar(20) DEFAULT NULL,
  `kd_lokasi` varchar(30) DEFAULT NULL,
  `nm_satker` varchar(40) DEFAULT NULL,
  `user_id` varchar(12) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `persediaan`
--

INSERT INTO `persediaan` (`id`, `kd_kbrg`, `nm_sskel`, `kd_jbrg`, `kd_brg`, `nm_brg`, `satuan`, `kd_perk`, `nm_perk`, `kd_lokasi`, `nm_satker`, `user_id`) VALUES
(1, '1010301005', NULL, '001', '1010301005001', 'PEDOMAN HUBUNGAN BILATERAL', 'Buah', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(2, '1010301005', NULL, '002', '1010301005002', 'SISTEM AKUNTANSI DAN PENYUSUNA', 'Buah', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(3, '1010301999', NULL, '003', '1010301999003', 'Materai 1000', 'Buah', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(4, '1010301001', NULL, '004', '1010301001004', 'Penggaris Butterfly 30cm', 'Buah', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(5, '1010301001', NULL, '005', '1010301001005', 'Cutter ', 'Buah', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(6, '1010301001', NULL, '006', '1010301001006', 'Amplo Besar', 'Box', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(7, '1010301001', NULL, '007', '1010301001007', 'Map Kertas', 'Lembar', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(8, '1010302001', NULL, '001', '1010302001001', 'Kertas A4', 'rim', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(9, '1010302001', NULL, '004', '1010302001004', 'Kertas f4', 'rim', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(10, '1010304004', NULL, '001', '1010304004001', 'Refiil Ink Canon', 'Set', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(11, '1010305005', NULL, '002', '1010305005002', 'Kunci Gembok', 'Set', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(12, '1010305001', NULL, '004', '1010305001004', 'Sapu ', 'Buah', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(13, '1010306001', NULL, '004', '1010306001004', 'Kabel Listrik', 'meter', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(14, '1010401001', NULL, '004', '1010401001004', 'Obat Merah Sedang', 'Botol', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(15, '1010301001', NULL, '003', '1010301001003', 'Ballpoint', 'Buah', 'sementara', NULL, '018010100010111', NULL, 'fikri'),
(16, '1010304006', NULL, '1371', '101030400601', 'SEAGATE', 'Buah', 'sementara', NULL, '21.01.01.01', NULL, 'pengguna'),
(17, '1010101001', 'Aspal', '88', '101010100188', 'Aspal Cair', 'Drum', '115131', 'Bahan Baku', '21.01.01.01', 'URUSAN BERSAMA BPOM DKI', 'pengguna'),
(20, '1010301010', 'Alat Perekat        ', '23', '101030101023', 'Lem Aibon', 'Kaleng', '115111', 'Barang Konsumsi     ', '21.01.01.01', 'URUSAN BERSAMA BPOM DKI', 'pengguna'),
(21, '1010301013', 'Isi Staples         ', '011', '1010301013011', 'Stapler Content', 'Pack', '115111', 'Barang Konsumsi     ', '010101', 'Sekretariat Dewan/DPRD', 'fikri.baru'),
(22, '1010101001', 'Aspal               ', '231', '1010101001231', 'ASPAL TIGA RODA', 'Drum', '115131', 'Bahan Baku          ', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 'pengguna'),
(23, '1010301013', 'Isi Staples         ', '123', '1010301013123', 'ISI STAPLES', 'Box', '115111', 'Barang Konsumsi     ', '01.01.01.01', 'Sekretariat Dewan/DPRD', 'koreksi'),
(24, '1010101020', 'Karung              ', '021', '1010101020021', 'Karung Vinyl', 'pack', '115131', 'Bahan Baku          ', '01.01.01.01', 'Sekretariat Dewan/DPRD', 'koreksi'),
(25, '1010301012', 'Staples             ', '001', '1010301012001', 'Staples +Merk', 'Buah', '115111', 'Barang Konsumsi     ', '01.01.01.01', 'Sekretariat Dewan/DPRD', 'fikri.f'),
(26, '1010301001', 'Alat Tulis          ', '127', '1010301001127', 'FAber Castel', 'Lusin', '115111', 'Barang Konsumsi     ', '01.01.01.01', 'Sekretariat Dewan/DPRD', 'fikri.f');

-- --------------------------------------------------------

--
-- Table structure for table `satker`
--

CREATE TABLE IF NOT EXISTS `satker` (
  `Satker_ID` int(11) NOT NULL,
  `KodeSektor` varchar(30) DEFAULT NULL,
  `KodeSatker` varchar(30) DEFAULT NULL,
  `KodeUnit` varchar(30) DEFAULT NULL,
  `Gudang` varchar(255) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `NamaSatker` varchar(255) DEFAULT NULL,
  `tahun` int(6) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=476 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `satker`
--

INSERT INTO `satker` (`Satker_ID`, `KodeSektor`, `KodeSatker`, `KodeUnit`, `Gudang`, `kode`, `NamaSatker`, `tahun`) VALUES
(1, '01', NULL, NULL, NULL, '01', 'Sekwan/DPRD', NULL),
(2, '02', NULL, NULL, NULL, '02', 'Gubernur/Bupati/Walikota', NULL),
(3, '03', NULL, NULL, NULL, '03', 'Wakil Gubernur/Bupati/Walikota', NULL),
(4, '04', NULL, NULL, NULL, '04', 'Sekretariat Daerah', NULL),
(5, '05', NULL, NULL, NULL, '05', 'Bidang Kimpraswil/PU', NULL),
(6, '06', NULL, NULL, NULL, '06', 'Bidang Perhubungan', NULL),
(7, '07', NULL, NULL, NULL, '07', 'Bidang Kesehatan', NULL),
(8, '08', NULL, NULL, NULL, '08', 'Bidang Pendidikan dan Kebudayaan', NULL),
(9, '09', NULL, NULL, NULL, '09', 'Bidang Sosial', NULL),
(10, '10', NULL, NULL, NULL, '10', 'Bidang Kependudukan', NULL),
(11, '11', NULL, NULL, NULL, '11', 'Bidang Pertanian', NULL),
(12, '12', NULL, NULL, NULL, '12', 'Bidang Perindustrian', NULL),
(13, '13', NULL, NULL, NULL, '13', 'Bidang Pendapatan', NULL),
(14, '14', NULL, NULL, NULL, '14', 'Bidang Pengawasan', NULL),
(15, '15', NULL, NULL, NULL, '15', 'Bidang Perencanaan', NULL),
(16, '16', NULL, NULL, NULL, '16', 'Bidang Lingkungan Hidup', NULL),
(17, '17', NULL, NULL, NULL, '17', 'Bidang Pariwisata', NULL),
(18, '18', NULL, NULL, NULL, '18', 'Bidang Kesatuan Bangsa', NULL),
(19, '19', NULL, NULL, NULL, '19', 'Bidang Kepegawaian', NULL),
(20, '20', NULL, NULL, NULL, '20', 'Bidang Penghubung', NULL),
(21, '21', NULL, NULL, NULL, '21', 'Bidang Komunikasi, Informasi dan Dokumentasi', NULL),
(22, '22', NULL, NULL, NULL, '22', 'Bidang BUMD', NULL),
(23, '50', NULL, NULL, NULL, '50', 'Bidang Kecamatan', NULL),
(24, '01', '01', NULL, NULL, '01.01', 'Sekretariat Dewan/DPRD', NULL),
(25, '02', '01', NULL, NULL, '02.01', 'Walikota', NULL),
(26, '03', '01', NULL, NULL, '03.01', 'Wakil Walikota', NULL),
(27, '04', '01', NULL, NULL, '04.01', 'Sekretaris Daerah', NULL),
(28, '04', '02', NULL, NULL, '04.02', 'DINAS PENDAPATAN, PENGELOLAAN KEUANGAN DAN ASET DAERAH', NULL),
(29, '05', '01', NULL, NULL, '05.01', 'DINAS PEKERJAAN UMUM', NULL),
(30, '06', '01', NULL, NULL, '06.01', 'DINAS PERHUBUNGAN, PARIWISATA DAN KEBUDAYAAN', NULL),
(31, '07', '01', NULL, NULL, '07.01', 'DINAS KESEHATAN', NULL),
(32, '07', '02', NULL, NULL, '07.02', 'RSUD BENDAN', NULL),
(33, '08', '01', NULL, NULL, '08.01', 'DINAS PENDIDIKAN, PEMUDA DAN OLAHRAGA', NULL),
(34, '09', '01', NULL, NULL, '09.01', 'BADAN PERMBERDAYAAN MASYARAKAT, PEREMPUAN, PERLINDUNGAN ANAK DAN KB', NULL),
(35, '10', '01', NULL, NULL, '10.01', 'DINAS SOSIAL, TENAGA KERJA DAN TRANSMIGRASI', NULL),
(36, '10', '02', NULL, NULL, '10.02', 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL', NULL),
(37, '11', '01', NULL, NULL, '11.01', 'DINAS PERTANIAN, PETERNAKAN, DAN KELAUTAN', NULL),
(38, '11', '02', NULL, NULL, '11.02', 'KANTOR KETAHANAN PANGAN', NULL),
(39, '12', '01', NULL, NULL, '12.01', 'DINAS PERINDUSTRIAN, PERDAGANGAN, KOPERASI, DAN USAHA KECIL DAN MENENGAH', NULL),
(40, '13', '01', NULL, NULL, '13.01', 'BPMP2T', NULL),
(41, '14', '01', NULL, NULL, '14.01', 'INSPEKTORAT', NULL),
(42, '15', '01', NULL, NULL, '15.01', 'BADAN PERENCANAAN PEMBANGUNAN DAERAH', NULL),
(43, '16', '01', NULL, NULL, '16.01', 'KANTOR LINGKUNGAN HIDUP', NULL),
(44, '18', '01', NULL, NULL, '18.01', 'KANTOR KESATUAN BANGSA DAN POLITIK  ', NULL),
(45, '18', '02', NULL, NULL, '18.02', 'SATUAN POLISI PAMONG PRAJA', NULL),
(46, '19', '01', NULL, NULL, '19.01', 'BADAN  KEPEGAWAIAN DAERAH', NULL),
(47, '21', '01', NULL, NULL, '21.01', 'KANTOR PERPUSTAKAAN  DAN ARSIP DAERAH', NULL),
(48, '21', '02', NULL, NULL, '21.02', 'DINAS KOMUNIKASI DAN INFORMATIKA', NULL),
(49, '22', '01', NULL, NULL, '22.01', 'PDAM', NULL),
(50, '22', '02', NULL, NULL, '22.02', 'BANK PASAR', NULL),
(51, '22', '03', NULL, NULL, '22.03', 'BKK KEC BARAT', NULL),
(52, '22', '04', NULL, NULL, '22.04', 'BKK KEC TIMUR', NULL),
(53, '22', '05', NULL, NULL, '22.05', 'BKK KEC UTARA', NULL),
(54, '22', '06', NULL, NULL, '22.06', 'BKK KEC SELATAN', NULL),
(55, '50', '01', NULL, NULL, '50.01', 'KECAMATAN PEKALONGAN BARAT', NULL),
(56, '50', '02', NULL, NULL, '50.02', 'KECAMATAN PEKALONGAN TIMUR', NULL),
(57, '50', '03', NULL, NULL, '50.03', 'KECAMATAN PEKALONGAN UTARA', NULL),
(58, '50', '04', NULL, NULL, '50.04', 'KECAMATAN PEKALONGAN SELATAN', NULL),
(59, '01', '01', '01', NULL, '01.01.01', 'Sekretariat Dewan/DPRD', NULL),
(60, '02', '01', '01', NULL, '02.01.01', 'Walikota', NULL),
(61, '03', '01', '01', NULL, '03.01.01', 'Wakil Walikota', NULL),
(62, '04', '01', '01', NULL, '04.01.01', 'Bagian Umum', NULL),
(63, '04', '01', '02', NULL, '04.01.02', 'Bagian Pemerintahan', NULL),
(64, '04', '01', '03', NULL, '04.01.03', 'Bagian Perekonomian', NULL),
(65, '04', '01', '04', NULL, '04.01.04', 'Bagian Administrasi Pembangunan', NULL),
(66, '04', '01', '05', NULL, '04.01.05', 'Bagian Hukum', NULL),
(67, '04', '01', '06', NULL, '04.01.06', '', NULL),
(68, '04', '01', '07', NULL, '04.01.07', 'Bagian Humas dan Protokol', NULL),
(69, '04', '01', '08', NULL, '04.01.08', 'Bagian Kesejahteraan Rakyat', NULL),
(70, '04', '01', '09', NULL, '04.01.09', 'Bagian Organisasi', NULL),
(71, '04', '01', '10', NULL, '04.01.10', '', NULL),
(72, '04', '02', '01', NULL, '04.02.01', 'DINAS PENDAPAAN, PENGELOLAAN KEUANGAN DAN ASET DAERAH', NULL),
(73, '05', '01', '01', NULL, '05.01.01', 'DINAS PEKERJAAN UMUM', NULL),
(74, '06', '01', '01', NULL, '06.01.01', 'DINAS PERHUBUNGAN, PARIWISATA DAN KEBUDAYAAN', NULL),
(75, '07', '01', '01', NULL, '07.01.01', 'DINAS KESEHATAN', NULL),
(76, '07', '01', '02', NULL, '07.01.02', 'Puskesmas Kota Pekalongan', NULL),
(77, '07', '02', '01', NULL, '07.02.01', 'RSUD BENDAN', NULL),
(78, '08', '01', '01', NULL, '08.01.01', 'DINAS PENDIDIKAN, PEMUDA DAN OLAHRAGA', NULL),
(79, '08', '01', '02', NULL, '08.01.02', 'SMPN 01', NULL),
(80, '08', '01', '03', NULL, '08.01.03', 'SMPN 02', NULL),
(81, '08', '01', '04', NULL, '08.01.04', 'SMPN 03', NULL),
(82, '08', '01', '05', NULL, '08.01.05', 'SMPN 04', NULL),
(83, '08', '01', '06', NULL, '08.01.06', 'SMPN 05', NULL),
(84, '08', '01', '07', NULL, '08.01.07', 'SMPN 06', NULL),
(85, '08', '01', '08', NULL, '08.01.08', 'SMPN 07', NULL),
(86, '08', '01', '09', NULL, '08.01.09', 'SMPN 08', NULL),
(87, '08', '01', '10', NULL, '08.01.10', 'SMPN 09', NULL),
(88, '08', '01', '11', NULL, '08.01.11', 'SMPN 10', NULL),
(89, '08', '01', '12', NULL, '08.01.12', 'SMPN 11', NULL),
(90, '08', '01', '13', NULL, '08.01.13', 'SMPN 12', NULL),
(91, '08', '01', '14', NULL, '08.01.14', 'SMPN 13', NULL),
(92, '08', '01', '15', NULL, '08.01.15', 'SMPN 14', NULL),
(93, '08', '01', '16', NULL, '08.01.16', 'SMPN 15', NULL),
(94, '08', '01', '17', NULL, '08.01.17', 'SMPN 16', NULL),
(95, '08', '01', '18', NULL, '08.01.18', 'SMPN 17', NULL),
(96, '08', '01', '19', NULL, '08.01.19', 'SMA N 01', NULL),
(97, '08', '01', '20', NULL, '08.01.20', 'SMA N 02', NULL),
(98, '08', '01', '21', NULL, '08.01.21', 'SMA N 03', NULL),
(99, '08', '01', '22', NULL, '08.01.22', 'SMA N 04', NULL),
(100, '08', '01', '23', NULL, '08.01.23', 'SMK N 01', NULL),
(101, '08', '01', '24', NULL, '08.01.24', 'SMK N 02', NULL),
(102, '08', '01', '25', NULL, '08.01.25', 'SMK N 03', NULL),
(103, '08', '01', '26', NULL, '08.01.26', 'SMK N 04', NULL),
(104, '08', '01', '27', NULL, '08.01.27', '....', NULL),
(105, '09', '01', '01', NULL, '09.01.01', 'BADAN PERMBERDAYAAN MASYARAKAT, PEREMPUAN, PERLINDUNGAN ANAK DAN KB', NULL),
(106, '10', '01', '01', NULL, '10.01.01', 'DINAS SOSIAL, TENAGA KERJA DAN TRANSMIGRASI', NULL),
(107, '10', '02', '01', NULL, '10.02.01', 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL', NULL),
(108, '11', '01', '01', NULL, '11.01.01', 'DINAS PERTANIAN, PETERNAKAN, DAN KELAUTAN', NULL),
(109, '11', '02', '01', NULL, '11.02.01', 'KANTOR KETAHANAN PANGAN', NULL),
(110, '12', '01', '01', NULL, '12.01.01', 'DINAS PERINDUSTRIAN, PERDAGANGAN, KOPERASI, DAN USAHA KECIL DAN MENENGAH', NULL),
(111, '13', '01', '01', NULL, '13.01.01', 'BPMP2T', NULL),
(112, '14', '01', '01', NULL, '14.01.01', 'Inspektorat', NULL),
(113, '15', '01', '01', NULL, '15.01.01', 'BADAN PERENCANAAN PEMBANGUNAN DAERAH', NULL),
(114, '16', '01', '01', NULL, '16.01.01', 'KANTOR LINGKUNGAN HIDUP', NULL),
(115, '18', '01', '01', NULL, '18.01.01', 'KANTOR KESATUAN BANGSA DAN POLITIK ', NULL),
(116, '18', '02', '01', NULL, '18.02.01', 'SATUAN POLISI PAMONG PRAJA', NULL),
(117, '19', '01', '01', NULL, '19.01.01', 'BADAN KEPEGAWAIAN DAERAH', NULL),
(118, '21', '01', '01', NULL, '21.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', NULL),
(119, '21', '02', '01', NULL, '21.02.01', 'DINAS KOMUNIKASI DAN INFORMATIKA', NULL),
(120, '22', '01', '01', NULL, '22.01.01', 'PDAM', NULL),
(121, '22', '02', '01', NULL, '22.02.01', 'Bank Pasar', NULL),
(122, '22', '03', '01', NULL, '22.03.01', 'BKK Kec Barat', NULL),
(123, '22', '04', '01', NULL, '22.04.01', 'BKK Kec Timur', NULL),
(124, '22', '05', '01', NULL, '22.05.01', 'BKK Kec Utara', NULL),
(125, '22', '06', '01', NULL, '22.06.01', 'BKK Kec Selatan', NULL),
(126, '50', '01', '01', NULL, '50.01.01', 'Kecamatan Pekalongan Barat', NULL),
(127, '50', '01', '02', NULL, '50.01.02', 'Kelurahan Kraton Kidul', NULL),
(128, '50', '01', '03', NULL, '50.01.03', 'Kelurahan Kergon', NULL),
(129, '50', '01', '04', NULL, '50.01.04', 'Kelurahan Sapuro', NULL),
(130, '50', '01', '05', NULL, '50.01.05', 'Kelurahan Kebulen', NULL),
(131, '50', '01', '06', NULL, '50.01.06', 'Kelurahan Kramatsari', NULL),
(132, '50', '01', '07', NULL, '50.01.07', 'Kelurahan Bendan', NULL),
(133, '50', '01', '08', NULL, '50.01.08', 'Kelurahan Podosugih', NULL),
(134, '50', '01', '09', NULL, '50.01.09', 'Kelurahan Medono', NULL),
(135, '50', '01', '10', NULL, '50.01.10', 'Kelurahan Tirto', NULL),
(136, '50', '01', '11', NULL, '50.01.11', 'Kelurahan Tegal Rejo', NULL),
(137, '50', '01', '12', NULL, '50.01.12', 'Kelurahan Bumi Rejo', NULL),
(138, '50', '01', '13', NULL, '50.01.13', 'Kelurahan Pringlangu', NULL),
(139, '50', '01', '14', NULL, '50.01.14', 'Kelurahan Pasirsari', NULL),
(140, '50', '02', '01', NULL, '50.02.01', 'Kecamatan Pekalongan Timur', NULL),
(141, '50', '02', '02', NULL, '50.02.02', 'Kelurahan Poncol', NULL),
(142, '50', '02', '03', NULL, '50.02.03', 'Kelurahan Noyontaan', NULL),
(143, '50', '02', '04', NULL, '50.02.04', 'Kelurahan Sugihwaras', NULL),
(144, '50', '02', '05', NULL, '50.02.05', 'Kelurahan Sampangan', NULL),
(145, '50', '02', '06', NULL, '50.02.06', 'Kelurahan Kauman', NULL),
(146, '50', '02', '07', NULL, '50.02.07', 'Kelurahan Keputran', NULL),
(147, '50', '02', '08', NULL, '50.02.08', 'Kelurahan Landungsari', NULL),
(148, '50', '02', '09', NULL, '50.02.09', 'Kelurahan Klego', NULL),
(149, '50', '02', '10', NULL, '50.02.10', 'Kelurahan Gamer', NULL),
(150, '50', '02', '11', NULL, '50.02.11', 'Kelurahan Dekoro', NULL),
(151, '50', '02', '12', NULL, '50.02.12', 'Kelurahan Karang Malang', NULL),
(152, '50', '02', '13', NULL, '50.02.13', 'Kelurahan Baros', NULL),
(153, '50', '02', '14', NULL, '50.02.14', 'Kelurahan Sokorejo', NULL),
(154, '50', '03', '01', NULL, '50.03.01', 'Kecamatan Pekalongan Utara', NULL),
(155, '50', '03', '02', NULL, '50.03.02', 'Kelurahan Krapyak Kidul', NULL),
(156, '50', '03', '03', NULL, '50.03.03', 'Kelurahan Krapyak Lor', NULL),
(157, '50', '03', '04', NULL, '50.03.04', 'Kelurahan Kd. Panjang', NULL),
(158, '50', '03', '05', NULL, '50.03.05', 'Kelurahan Panjang Wetan', NULL),
(159, '50', '03', '06', NULL, '50.03.06', 'Kelurahan Kraton Lor', NULL),
(160, '50', '03', '07', NULL, '50.03.07', 'Kelurahan Dukuh', NULL),
(161, '50', '03', '08', NULL, '50.03.08', 'Kelurahan Degayu', NULL),
(162, '50', '03', '09', NULL, '50.03.09', 'Kelurahan Pabean', NULL),
(163, '50', '03', '10', NULL, '50.03.10', 'Kelurahan Bandengan', NULL),
(164, '50', '03', '11', NULL, '50.03.11', 'Kelurahan Panjang Baru', NULL),
(165, '50', '03', '12', NULL, '50.03.12', '-', NULL),
(166, '50', '04', '01', NULL, '50.04.01', 'Kecamatan Pekalongan Selatan', NULL),
(167, '50', '04', '02', NULL, '50.04.02', 'Kelurahan Kradenan', NULL),
(168, '50', '04', '03', NULL, '50.04.03', 'Kelurahan Banyurip Alit', NULL),
(169, '50', '04', '04', NULL, '50.04.04', 'Kelurahan Buaran', NULL),
(170, '50', '04', '05', NULL, '50.04.05', 'Kelurahan Jenggot', NULL),
(171, '50', '04', '06', NULL, '50.04.06', 'Kelurahan Kertoharjo', NULL),
(172, '50', '04', '07', NULL, '50.04.07', 'Kelurahan Kuripan Kidul', NULL),
(173, '50', '04', '08', NULL, '50.04.08', 'Kelurahan Kuripan Lor', NULL),
(174, '50', '04', '09', NULL, '50.04.09', 'Kelurahan Yosorejo', NULL),
(175, '50', '04', '10', NULL, '50.04.10', 'Kelurahan Duwet', NULL),
(176, '50', '04', '11', NULL, '50.04.11', 'Kelurahan Soko', NULL),
(177, '50', '04', '12', NULL, '50.04.12', 'Kelurahan Banyurip Ageng', NULL),
(178, '01', '01', '01', '01', '01.01.01.01', 'Sekretariat Dewan/DPRD', NULL),
(179, '02', '01', '01', '01', '02.01.01.01', 'Walikota', NULL),
(180, '03', '01', '01', '01', '03.01.01.01', 'Wakil Walikota', NULL),
(181, '04', '01', '01', '01', '04.01.01.01', 'Sekretaris Daerah', NULL),
(182, '04', '01', '01', '02', '04.01.01.02', 'Asisten I', NULL),
(183, '04', '01', '01', '03', '04.01.01.03', 'Asisten II', NULL),
(184, '04', '01', '01', '04', '04.01.01.04', 'Asisten III', NULL),
(185, '04', '01', '01', '05', '04.01.01.05', 'Bagian Umum', NULL),
(186, '04', '01', '02', '01', '04.01.02.01', 'Bagian Pemerintahan', NULL),
(187, '04', '01', '03', '01', '04.01.03.01', 'Bagian Perekonomian', NULL),
(188, '04', '01', '04', '01', '04.01.04.01', 'Bagian Adm. Pembangunan', NULL),
(189, '04', '01', '05', '01', '04.01.05.01', 'Bagian Hukum', NULL),
(190, '04', '01', '06', '01', '04.01.06.01', '', NULL),
(191, '04', '01', '07', '01', '04.01.07.01', 'Bagian Humas dan Protokol', NULL),
(192, '04', '01', '08', '01', '04.01.08.01', 'Bagian Kesra', NULL),
(193, '04', '01', '09', '01', '04.01.09.01', 'Bagian Organisasi', NULL),
(194, '04', '01', '10', '01', '04.01.10.01', '', NULL),
(195, '04', '02', '01', '01', '04.02.01.01', 'DINAS PENDAPATAN, PENGELOLAAN KEUANGAN DAN ASET DAERAH', NULL),
(196, '05', '01', '01', '01', '05.01.01.01', 'DINAS PEKERJAAN UMUM', NULL),
(197, '06', '01', '01', '01', '06.01.01.01', 'DINAS PERHUBUNGAN, KOMUNIKASI INFORMATIKA, PARIWISATA DAN KEBUDAYAAN', NULL),
(198, '07', '01', '01', '01', '07.01.01.01', 'DINAS KESEHATAN', NULL),
(199, '07', '01', '01', '02', '07.01.01.02', 'UPTD BP Paru-paru', NULL),
(200, '07', '01', '01', '03', '07.01.01.03', 'UPTD Farmasi', NULL),
(201, '07', '01', '01', '04', '07.01.01.04', 'Puskesmas Bendan', NULL),
(202, '07', '01', '01', '05', '07.01.01.05', 'Pukesmas Medono', NULL),
(203, '07', '01', '01', '06', '07.01.01.06', 'Pustu Medono Indah', NULL),
(204, '07', '01', '01', '07', '07.01.01.07', 'Pustu Kebulen', NULL),
(205, '07', '01', '01', '08', '07.01.01.08', 'Pustu Pemkot', NULL),
(206, '07', '01', '01', '09', '07.01.01.09', 'Puskesmas Kramatsari', NULL),
(207, '07', '01', '01', '10', '07.01.01.10', 'Pustu Pasirsari', NULL),
(208, '07', '01', '01', '11', '07.01.01.11', 'Puskesmas Tirto', NULL),
(209, '07', '01', '01', '12', '07.01.01.12', 'Pustu Bumirejo', NULL),
(210, '07', '01', '01', '13', '07.01.01.13', 'Puskesmas Noyontaan', NULL),
(211, '07', '01', '01', '14', '07.01.01.14', 'Pustu Kalisari', NULL),
(212, '07', '01', '01', '15', '07.01.01.15', 'Pustu Pragak', NULL),
(213, '07', '01', '01', '16', '07.01.01.16', 'Pustu Baros', NULL),
(214, '07', '01', '01', '17', '07.01.01.17', 'Puskesmas Tondano', NULL),
(215, '07', '01', '01', '18', '07.01.01.18', 'Pustu Dekoro', NULL),
(216, '07', '01', '01', '19', '07.01.01.19', 'Pustu Gamer', NULL),
(217, '07', '01', '01', '20', '07.01.01.20', 'Puskesmas Klego', NULL),
(218, '07', '01', '01', '21', '07.01.01.21', 'Puskesmas Kusuma Bangsa', NULL),
(219, '07', '01', '01', '22', '07.01.01.22', 'Pustu Panjang Wetan', NULL),
(220, '07', '01', '01', '23', '07.01.01.23', 'Pustu Bandengan', NULL),
(221, '07', '01', '01', '24', '07.01.01.24', 'Puskesmas Krapyak Kidul', NULL),
(222, '07', '01', '01', '25', '07.01.01.25', 'Pustu Degayu', NULL),
(223, '07', '01', '01', '26', '07.01.01.26', 'Pustu Slamaran', NULL),
(224, '07', '01', '01', '27', '07.01.01.27', 'Pukesmas Dukuh', NULL),
(225, '07', '01', '01', '28', '07.01.01.28', 'Puskesmas Kecamatan Pekalongan Selatan', NULL),
(226, '07', '01', '01', '29', '07.01.01.29', 'Pustu Soko', NULL),
(227, '07', '01', '01', '30', '07.01.01.30', 'Pustu Kuripan Lor 1', NULL),
(228, '07', '01', '01', '31', '07.01.01.31', 'Pustu Kuripan Lor 2', NULL),
(229, '07', '01', '01', '32', '07.01.01.32', 'Pustu Kertoharjo', NULL),
(230, '07', '01', '01', '33', '07.01.01.33', 'Puskesmas Jenggot', NULL),
(231, '07', '01', '01', '34', '07.01.01.34', 'Pustu Kradenan', NULL),
(232, '07', '01', '01', '35', '07.01.01.35', 'Pustu Banyurip Ageng', NULL),
(233, '07', '01', '01', '36', '07.01.01.36', 'Laboratorium Kesehatan Daerah', NULL),
(234, '07', '01', '01', '37', '07.01.01.37', 'Pustu Pabean', NULL),
(235, '07', '01', '01', '38', '07.01.01.38', 'Pustu Karang Malang', NULL),
(236, '07', '01', '01', '39', '07.01.01.39', 'Pustu Kergon', NULL),
(237, '07', '01', '01', '40', '07.01.01.40', 'Pustu Salam Manis', NULL),
(238, '07', '01', '01', '41', '07.01.01.41', 'Pustu Duwet', NULL),
(239, '07', '01', '01', '42', '07.01.01.42', 'Puskesmas Sokorejo', NULL),
(240, '07', '01', '01', '43', '07.01.01.43', 'Pustu Pringlangu', NULL),
(241, '07', '01', '01', '44', '07.01.01.44', 'Puskesmas Buaran', NULL),
(242, '07', '01', '01', '45', '07.01.01.45', 'Pustu Kelgo Bantaran', NULL),
(243, '07', '01', '01', '46', '07.01.01.46', 'P4TO', NULL),
(244, '07', '01', '01', '47', '07.01.01.47', '..', NULL),
(245, '07', '01', '02', '01', '07.01.02.01', 'Pukesmas Kota Pekalongan', NULL),
(246, '07', '02', '01', '01', '07.02.01.01', 'RSUD BENDAN', NULL),
(247, '08', '01', '01', '01', '08.01.01.01', 'DINAS PENDIDIKAN, PEMUDA DAN OLAHRAGA', NULL),
(248, '08', '01', '01', '02', '08.01.01.02', 'UPTD Pendidikan Kec. Pekalongan Barat', NULL),
(249, '08', '01', '01', '03', '08.01.01.03', 'SDN Kraton Kidul', NULL),
(250, '08', '01', '01', '04', '08.01.01.04', 'SDN Kramatsari 01', NULL),
(251, '08', '01', '01', '05', '08.01.01.05', 'SDN Kramatsari 02', NULL),
(252, '08', '01', '01', '06', '08.01.01.06', 'SDN Bendan 01', NULL),
(253, '08', '01', '01', '07', '08.01.01.07', 'SDN Bendan 03', NULL),
(254, '08', '01', '01', '08', '08.01.01.08', 'SDN Bendan 04', NULL),
(255, '08', '01', '01', '09', '08.01.01.09', 'SDN Bendan 08', NULL),
(256, '08', '01', '01', '10', '08.01.01.10', 'SDN Sapuro 01', NULL),
(257, '08', '01', '01', '11', '08.01.01.11', 'SDN Sapuro 02', NULL),
(258, '08', '01', '01', '12', '08.01.01.12', 'SDN Sapuro 03', NULL),
(259, '08', '01', '01', '13', '08.01.01.13', 'SDN Sapuro 04', NULL),
(260, '08', '01', '01', '14', '08.01.01.14', 'SDN Sapuro 05', NULL),
(261, '08', '01', '01', '15', '08.01.01.15', 'SDN Podosugih 01', NULL),
(262, '08', '01', '01', '16', '08.01.01.16', 'SDN Podosugih 03', NULL),
(263, '08', '01', '01', '17', '08.01.01.17', 'SDN Medono 01', NULL),
(264, '08', '01', '01', '18', '08.01.01.18', 'SDN Medono 04', NULL),
(265, '08', '01', '01', '19', '08.01.01.19', 'SDN Medono 05', NULL),
(266, '08', '01', '01', '20', '08.01.01.20', 'SDN Medono 07', NULL),
(267, '08', '01', '01', '21', '08.01.01.21', 'SDN Medono 08', NULL),
(268, '08', '01', '01', '22', '08.01.01.22', 'SDN Kebulen', NULL),
(269, '08', '01', '01', '23', '08.01.01.23', 'SDN Tirto 01', NULL),
(270, '08', '01', '01', '24', '08.01.01.24', 'SDN Tirto 02', NULL),
(271, '08', '01', '01', '25', '08.01.01.25', 'SDN Tirto 03', NULL),
(272, '08', '01', '01', '26', '08.01.01.26', 'SDN Tirto 04', NULL),
(273, '08', '01', '01', '27', '08.01.01.27', 'SDN Pasirsari 01', NULL),
(274, '08', '01', '01', '28', '08.01.01.28', 'SDN Pasirsari 02', NULL),
(275, '08', '01', '01', '29', '08.01.01.29', 'SDN Tegal Rejo', NULL),
(276, '08', '01', '01', '30', '08.01.01.30', 'SDN Bumi Rejo', NULL),
(277, '08', '01', '01', '31', '08.01.01.31', 'SDN Pringlangu', NULL),
(278, '08', '01', '01', '32', '08.01.01.32', 'SDN Luar Biasa', NULL),
(279, '08', '01', '01', '33', '08.01.01.33', 'UPTD Pendidikan Kec. Pekalongan Timur', NULL),
(280, '08', '01', '01', '34', '08.01.01.34', 'SDN Keputran 01', NULL),
(281, '08', '01', '01', '35', '08.01.01.35', 'SDN Keputran 02', NULL),
(282, '08', '01', '01', '36', '08.01.01.36', 'SDN Keputran 04', NULL),
(283, '08', '01', '01', '37', '08.01.01.37', 'SDN Keputran 06', NULL),
(284, '08', '01', '01', '38', '08.01.01.38', 'SDN Keputran 08', NULL),
(285, '08', '01', '01', '39', '08.01.01.39', 'SDN Noyontaan 03', NULL),
(286, '08', '01', '01', '40', '08.01.01.40', 'SDN Landungsari 01', NULL),
(287, '08', '01', '01', '41', '08.01.01.41', 'SDN Landungsari 02', NULL),
(288, '08', '01', '01', '42', '08.01.01.42', 'SDN Landungsari 03', NULL),
(289, '08', '01', '01', '43', '08.01.01.43', 'SDN Landungsari 04', NULL),
(290, '08', '01', '01', '44', '08.01.01.44', 'SDN Landungsari 05', NULL),
(291, '08', '01', '01', '45', '08.01.01.45', 'SDN Poncol 01', NULL),
(292, '08', '01', '01', '46', '08.01.01.46', 'SDN Poncol 02', NULL),
(293, '08', '01', '01', '47', '08.01.01.47', 'SDN Poncol 03', NULL),
(294, '08', '01', '01', '48', '08.01.01.48', 'SDN Poncol 04', NULL),
(295, '08', '01', '01', '49', '08.01.01.49', 'SDN Poncol 06', NULL),
(296, '08', '01', '01', '50', '08.01.01.50', 'SDN Poncol 07', NULL),
(297, '08', '01', '01', '51', '08.01.01.51', 'SDN Sampangan 01', NULL),
(298, '08', '01', '01', '52', '08.01.01.52', 'SDN Sampangan 02', NULL),
(299, '08', '01', '01', '53', '08.01.01.53', 'SDN Klego 01', NULL),
(300, '08', '01', '01', '54', '08.01.01.54', 'SDN Klego 04', NULL),
(301, '08', '01', '01', '55', '08.01.01.55', 'SDN Gamer 01', NULL),
(302, '08', '01', '01', '56', '08.01.01.56', 'SDN Gamer 02', NULL),
(303, '08', '01', '01', '57', '08.01.01.57', 'SDN Sokorejo', NULL),
(304, '08', '01', '01', '58', '08.01.01.58', 'SDN Baros', NULL),
(305, '08', '01', '01', '59', '08.01.01.59', 'SDN Dekoro', NULL),
(306, '08', '01', '01', '60', '08.01.01.60', 'SDN Karang malang', NULL),
(307, '08', '01', '01', '61', '08.01.01.61', 'UPTD Pendidikan Kec. Pekalongan Utara', NULL),
(308, '08', '01', '01', '62', '08.01.01.62', 'SDN Panjang Wetan 01', NULL),
(309, '08', '01', '01', '63', '08.01.01.63', 'SDN Panjang Wetan 02', NULL),
(310, '08', '01', '01', '64', '08.01.01.64', 'SDN Panjang Wetan 03', NULL),
(311, '08', '01', '01', '65', '08.01.01.65', 'SDN Panjang Wetan 04', NULL),
(312, '08', '01', '01', '66', '08.01.01.66', 'SDN Panjang Wetan 05', NULL),
(313, '08', '01', '01', '67', '08.01.01.67', 'SDN Panjang Wetan 06', NULL),
(314, '08', '01', '01', '68', '08.01.01.68', 'SDN Kandang Panjang 01', NULL),
(315, '08', '01', '01', '69', '08.01.01.69', 'SDN Kandang Panjang 02', NULL),
(316, '08', '01', '01', '70', '08.01.01.70', 'SDN Kandang Panjang 03', NULL),
(317, '08', '01', '01', '71', '08.01.01.71', 'SDN Kandang Panjang 04', NULL),
(318, '08', '01', '01', '72', '08.01.01.72', 'SDN Kandang Panjang 05', NULL),
(319, '08', '01', '01', '73', '08.01.01.73', 'SDN Kandang Panjang 07', NULL),
(320, '08', '01', '01', '74', '08.01.01.74', 'SDN Kandang Panjang 08', NULL),
(321, '08', '01', '01', '75', '08.01.01.75', 'SDN Kandang Panjang 10', NULL),
(322, '08', '01', '01', '76', '08.01.01.76', 'SDN Kandang Panjang 11', NULL),
(323, '08', '01', '01', '77', '08.01.01.77', 'SDN Dukuh 01', NULL),
(324, '08', '01', '01', '78', '08.01.01.78', 'SDN Kraton', NULL),
(325, '08', '01', '01', '79', '08.01.01.79', 'SDN Krapyak Lor 01', NULL),
(326, '08', '01', '01', '80', '08.01.01.80', 'SDN Krapyak Lor 02', NULL),
(327, '08', '01', '01', '81', '08.01.01.81', 'SDN Krapyak Lor 04', NULL),
(328, '08', '01', '01', '82', '08.01.01.82', 'SDN Krapyak Lor 05', NULL),
(329, '08', '01', '01', '83', '08.01.01.83', 'SDN Pabean', NULL),
(330, '08', '01', '01', '84', '08.01.01.84', 'SDN Bandengan 01', NULL),
(331, '08', '01', '01', '85', '08.01.01.85', 'SDN Bandengan 02', NULL),
(332, '08', '01', '01', '86', '08.01.01.86', 'SDN Degayu 01', NULL),
(333, '08', '01', '01', '87', '08.01.01.87', 'SDN Degayu 02', NULL),
(334, '08', '01', '01', '88', '08.01.01.88', 'UPTD Pendidikan Kec. Pekalongan Selatan', NULL),
(335, '08', '01', '01', '89', '08.01.01.89', 'SDN Kradenan 01', NULL),
(336, '08', '01', '01', '90', '08.01.01.90', 'SDN Kradenan 02', NULL),
(337, '08', '01', '01', '91', '08.01.01.91', 'SDN Kradenan 04', NULL),
(338, '08', '01', '01', '92', '08.01.01.92', 'SDN Buaran', NULL),
(339, '08', '01', '01', '93', '08.01.01.93', 'SDN Banyurip Ageng', NULL),
(340, '08', '01', '01', '94', '08.01.01.94', 'SDN Jenggot', NULL),
(341, '08', '01', '01', '95', '08.01.01.95', 'SDN Kertoharjo 01', NULL),
(342, '08', '01', '01', '96', '08.01.01.96', 'SDN Kertoharjo 02', NULL),
(343, '08', '01', '01', '97', '08.01.01.97', 'SDN Kuripan Kidul 01', NULL),
(344, '08', '01', '01', '98', '08.01.01.98', 'SDN Kuripan Kidul 02', NULL),
(345, '08', '01', '01', '99', '08.01.01.99', 'SDN Kuripan Lor 01', NULL),
(346, '08', '01', '01', '100', '08.01.01.100', 'SDN Kuripan Lor 02', NULL),
(347, '08', '01', '01', '101', '08.01.01.101', 'SDN Yosorejo 01', NULL),
(348, '08', '01', '01', '102', '08.01.01.102', 'SDN Yosorejo 02', NULL),
(349, '08', '01', '01', '103', '08.01.01.103', 'SDN Duwet', NULL),
(350, '08', '01', '01', '104', '08.01.01.104', 'SDN Soko', NULL),
(351, '08', '01', '01', '105', '08.01.01.105', 'SDN Krapyak Kidul 02', NULL),
(352, '08', '01', '01', '106', '08.01.01.106', 'TK Cempaka Jaya', NULL),
(353, '08', '01', '01', '107', '08.01.01.107', 'TK Pembina Utara', NULL),
(354, '08', '01', '01', '108', '08.01.01.108', 'TK Pembina Barat', NULL),
(355, '08', '01', '01', '109', '08.01.01.109', '..', NULL),
(356, '08', '01', '02', '01', '08.01.02.01', 'SMPN 01', NULL),
(357, '08', '01', '03', '01', '08.01.03.01', 'SMPN 02', NULL),
(358, '08', '01', '04', '01', '08.01.04.01', 'SMPN 03', NULL),
(359, '08', '01', '05', '01', '08.01.05.01', 'SMPN 04', NULL),
(360, '08', '01', '06', '01', '08.01.06.01', 'SMPN 05', NULL),
(361, '08', '01', '07', '01', '08.01.07.01', 'SMPN 06', NULL),
(362, '08', '01', '08', '01', '08.01.08.01', 'SMPN 07', NULL),
(363, '08', '01', '09', '01', '08.01.09.01', 'SMPN 08', NULL),
(364, '08', '01', '10', '01', '08.01.10.01', 'SMPN 09', NULL),
(365, '08', '01', '11', '01', '08.01.11.01', 'SMPN 10', NULL),
(366, '08', '01', '12', '01', '08.01.12.01', 'SMPN 11', NULL),
(367, '08', '01', '13', '01', '08.01.13.01', 'SMPN 12', NULL),
(368, '08', '01', '14', '01', '08.01.14.01', 'SMPN 13', NULL),
(369, '08', '01', '15', '01', '08.01.15.01', 'SMPN 14', NULL),
(370, '08', '01', '16', '01', '08.01.16.01', 'SMPN 15', NULL),
(371, '08', '01', '17', '01', '08.01.17.01', 'SMPN 16', NULL),
(372, '08', '01', '18', '01', '08.01.18.01', 'SMPN 17', NULL),
(373, '08', '01', '19', '01', '08.01.19.01', 'SMA N 01', NULL),
(374, '08', '01', '20', '01', '08.01.20.01', 'SMA N 02', NULL),
(375, '08', '01', '21', '01', '08.01.21.01', 'SMA N 03', NULL),
(376, '08', '01', '22', '01', '08.01.22.01', 'SMA N 04', NULL),
(377, '08', '01', '23', '01', '08.01.23.01', 'SMK N 01', NULL),
(378, '08', '01', '24', '01', '08.01.24.01', 'SMK N 02', NULL),
(379, '08', '01', '25', '01', '08.01.25.01', 'SMK N 03', NULL),
(380, '08', '01', '26', '01', '08.01.26.01', 'SMK N 4', NULL),
(381, '08', '01', '27', '01', '08.01.27.01', '..', NULL),
(382, '09', '01', '01', '01', '09.01.01.01', 'BADAN PERMBERDAYAAN MASYARAKAT, PEREMPUAN, PERLINDUNGAN ANAK DAN KB', NULL),
(383, '10', '01', '01', '01', '10.01.01.01', 'DINAS SOSIAL, TENAGA KERJA DAN TRANSMIGRASI', NULL),
(384, '10', '02', '01', '01', '10.02.01.01', 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL', NULL),
(385, '11', '01', '01', '01', '11.01.01.01', 'DINAS PERTANIAN, PETERNAKAN, DAN KELAUTAN', NULL),
(386, '11', '02', '01', '01', '11.02.01.01', 'KANTOR KETAHANAN PANGAN', NULL),
(387, '12', '01', '01', '01', '12.01.01.01', 'DINAS PERINDUSTRIAN, PERDAGANGAN, KOPERASI, DAN USAHA KECIL DAN MENENGAH', NULL),
(388, '13', '01', '01', '01', '13.01.01.01', 'BPMP2T', NULL),
(389, '14', '01', '01', '01', '14.01.01.01', 'Inspektorat', NULL),
(390, '15', '01', '01', '01', '15.01.01.01', 'BADAN PERENCANAAN PEMBANGUNAN DAERAH', NULL),
(391, '16', '01', '01', '01', '16.01.01.01', 'KANTOR LINGKUNGAN HIDUP', NULL),
(392, '18', '01', '01', '01', '18.01.01.01', 'KANTOR KESATUAN BANGSA DAN POLITIK', NULL),
(393, '18', '02', '01', '01', '18.02.01.01', 'SATUAN POLISI PAMONG PRAJA', NULL),
(394, '19', '01', '01', '01', '19.01.01.01', 'BADAN KEPEGAWAIAN DAERAH', NULL),
(395, '21', '01', '01', '01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', NULL),
(396, '21', '02', '01', '01', '21.02.01.01', 'DINAS KOMUNIKASI DAN INFORMATIKA', NULL),
(397, '22', '01', '01', '01', '22.01.01.01', 'PDAM', NULL),
(398, '22', '02', '01', '01', '22.02.01.01', 'Bank Pasar', NULL),
(399, '22', '03', '01', '01', '22.03.01.01', 'BKK Kec Barat', NULL),
(400, '22', '04', '01', '01', '22.04.01.01', 'BKK Kec Timur', NULL),
(401, '22', '05', '01', '01', '22.05.01.01', 'BKK Kec Utara', NULL),
(402, '22', '06', '01', '01', '22.06.01.01', 'BKK Kec Selatan', NULL),
(403, '50', '01', '01', '01', '50.01.01.01', 'Kecamatan Pekalongan Barat', NULL),
(404, '50', '01', '02', '01', '50.01.02.01', 'Kelurahan Kraton Kidul', NULL),
(405, '50', '01', '03', '01', '50.01.03.01', 'Kelurahan Kergon', NULL),
(406, '50', '01', '04', '01', '50.01.04.01', 'Kelurahan Sapuro', NULL),
(407, '50', '01', '05', '01', '50.01.05.01', 'Kelurahan Kebulen', NULL),
(408, '50', '01', '06', '01', '50.01.06.01', 'Kelurahan Kramatsari', NULL),
(409, '50', '01', '07', '01', '50.01.07.01', 'Kelurahan Bendan', NULL),
(410, '50', '01', '08', '01', '50.01.08.01', 'Kelurahan Podosugih', NULL),
(411, '50', '01', '09', '01', '50.01.09.01', 'Kelurahan Medono', NULL),
(412, '50', '01', '10', '01', '50.01.10.01', 'Kelurahan Tirto', NULL),
(413, '50', '01', '11', '01', '50.01.11.01', 'Kelurahan Tegal Rejo', NULL),
(414, '50', '01', '12', '01', '50.01.12.01', 'Kelurahan Bumi Rejo', NULL),
(415, '50', '01', '13', '01', '50.01.13.01', 'Kelurahan Pringlangu', NULL),
(416, '50', '01', '14', '01', '50.01.14.01', 'Kelurahan Pasirsari', NULL),
(417, '50', '02', '01', '01', '50.02.01.01', 'Kecamatan Pekalongan Timur', NULL),
(418, '50', '02', '02', '01', '50.02.02.01', 'Kelurahan Poncol', NULL),
(419, '50', '02', '03', '01', '50.02.03.01', 'Kelurahan Noyontaan', NULL),
(420, '50', '02', '04', '01', '50.02.04.01', 'Kelurahan Sugihwaras', NULL),
(421, '50', '02', '05', '01', '50.02.05.01', 'Kelurahan Sampangan', NULL),
(422, '50', '02', '06', '01', '50.02.06.01', 'Kelurahan Kauman', NULL),
(423, '50', '02', '07', '01', '50.02.07.01', 'Kelurahan Keputran', NULL),
(424, '50', '02', '08', '01', '50.02.08.01', 'Kelurahan Landungsari', NULL),
(425, '50', '02', '09', '01', '50.02.09.01', 'Kelurahan Klego', NULL),
(426, '50', '02', '10', '01', '50.02.10.01', 'Kelurahan Gamer', NULL),
(427, '50', '02', '11', '01', '50.02.11.01', 'Kelurahan Dekoro', NULL),
(428, '50', '02', '12', '01', '50.02.12.01', 'Kelurahan Karang Malang', NULL),
(429, '50', '02', '13', '01', '50.02.13.01', 'Kelurahan Baros', NULL),
(430, '50', '02', '14', '01', '50.02.14.01', 'Kelurahan Sokorejo', NULL),
(431, '50', '03', '01', '01', '50.03.01.01', 'Kecamatan Pekalongan Utara', NULL),
(432, '50', '03', '02', '01', '50.03.02.01', 'Kelurahan Krapyak Kidul', NULL),
(433, '50', '03', '03', '01', '50.03.03.01', 'Kelurahan Krapyak Lor', NULL),
(434, '50', '03', '04', '01', '50.03.04.01', 'Kelurahan Kd. Panjang', NULL),
(435, '50', '03', '05', '01', '50.03.05.01', 'Kelurahan Panjang Wetan', NULL),
(436, '50', '03', '06', '01', '50.03.06.01', 'Kelurahan Kraton Lor', NULL),
(437, '50', '03', '07', '01', '50.03.07.01', 'Kelurahan Dukuh', NULL),
(438, '50', '03', '08', '01', '50.03.08.01', 'Kelurahan Degayu', NULL),
(439, '50', '03', '09', '01', '50.03.09.01', 'Kelurahan Pabean', NULL),
(440, '50', '03', '10', '01', '50.03.10.01', 'Kelurahan Bandengan', NULL),
(441, '50', '03', '11', '01', '50.03.11.01', 'Kelurahan Panjang Baru', NULL),
(442, '50', '03', '12', '01', '50.03.12.01', '-', NULL),
(443, '50', '04', '01', '01', '50.04.01.01', 'Kecamatan Pekalongan Selatan', NULL),
(444, '50', '04', '02', '01', '50.04.02.01', 'Kelurahan Kradenan', NULL),
(445, '50', '04', '03', '01', '50.04.03.01', 'Kelurahan Banyurip Alit', NULL),
(446, '50', '04', '04', '01', '50.04.04.01', 'Kelurahan Buaran', NULL),
(447, '50', '04', '05', '01', '50.04.05.01', 'Kelurahan Jenggot', NULL),
(448, '50', '04', '06', '01', '50.04.06.01', 'Kelurahan Kertoharjo', NULL),
(449, '50', '04', '07', '01', '50.04.07.01', 'Kelurahan Kuripan Kidul', NULL),
(450, '50', '04', '08', '01', '50.04.08.01', 'Kelurahan Kuripan Lor', NULL),
(451, '50', '04', '09', '01', '50.04.09.01', 'Kelurahan Yosorejo', NULL),
(452, '50', '04', '10', '01', '50.04.10.01', 'Kelurahan Duwet', NULL),
(453, '50', '04', '11', '01', '50.04.11.01', 'Kelurahan Soko', NULL),
(454, '50', '04', '12', '01', '50.04.12.01', 'Kelurahan Banyurip Ageng', NULL),
(455, '09', '02', NULL, NULL, NULL, 'BADAN PENANGGULANGAN BENCANA DAERAH', NULL),
(456, '09', '02', '01', NULL, NULL, 'BADAN PENANGGULANGAN BENCANA DAERAH', NULL),
(457, '09', '02', '01', '01', '09.09.02.01', 'BADAN PENANGGULANGAN BENCANA DAERAH', NULL),
(458, '21', '03', NULL, NULL, '21.03', 'Kantor Riset Teknologi dan Inovasi', NULL),
(459, '21', '03', '01', NULL, '21.03.01', 'Kantor Riset Teknologi dan Inovasi', NULL),
(460, '21', '03', '01', '01', '21.03.01.01', 'Kantor Riset Teknologi dan Inovasi', NULL);

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
  `kd_brg` varchar(20) NOT NULL,
  `kd_perk` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=345 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sskel`
--

INSERT INTO `sskel` (`id`, `kd_gol`, `kd_bid`, `kd_kel`, `kd_skel`, `kd_sskel`, `nm_sskel`, `kd_brg`, `kd_perk`) VALUES
(1, '1', '01', '01', '01', '', 'Aspal                         ', '1010101001', '115131'),
(2, '1', '01', '01', '01', '', 'Semen                         ', '1010101002', '115131'),
(3, '1', '01', '01', '01', '', 'Kaca                          ', '1010101003', '115131'),
(4, '1', '01', '01', '01', '', 'Pasir                         ', '1010101004', '115131'),
(5, '1', '01', '01', '01', '', 'Batu                          ', '1010101005', '115131'),
(6, '1', '01', '01', '01', '', 'Cat                           ', '1010101006', '115131'),
(7, '1', '01', '01', '01', '', 'Seng                          ', '1010101007', '115131'),
(8, '1', '01', '01', '01', '', 'Baja                          ', '1010101008', '115131'),
(9, '1', '01', '01', '01', '', 'Electro Dalas                 ', '1010101009', '115131'),
(10, '1', '01', '01', '01', '', 'Patok Beton                   ', '1010101010', '115131'),
(11, '1', '01', '01', '01', '', 'Tiang Beton                   ', '1010101011', '115131'),
(12, '1', '01', '01', '01', '', 'Besi Beton                    ', '1010101012', '115131'),
(13, '1', '01', '01', '01', '', 'Tegel                         ', '1010101013', '115131'),
(14, '1', '01', '01', '01', '', 'Genteng                       ', '1010101014', '115131'),
(15, '1', '01', '01', '01', '', 'Bis Beton                     ', '1010101015', '115131'),
(16, '1', '01', '01', '01', '', 'Plat                          ', '1010101016', '115131'),
(17, '1', '01', '01', '01', '', 'Steel Sheet Pile              ', '1010101017', '115131'),
(18, '1', '01', '01', '01', '', 'Concrete Sheet Pile           ', '1010101018', '115131'),
(19, '1', '01', '01', '01', '', 'Kawat Bronjong                ', '1010101019', '115131'),
(20, '1', '01', '01', '01', '', 'Karung                        ', '1010101020', '115131'),
(21, '1', '01', '01', '01', '', 'Minyak Cat/Thinner            ', '1010101021', '115131'),
(22, '1', '01', '01', '01', '', 'Bahan Bangunan Dan Konstruksi ', '1010101999', '115131'),
(23, '1', '01', '01', '02', '', 'Bahan Kimia Padat             ', '1010102001', '115131'),
(24, '1', '01', '01', '02', '', 'Bahan Kimia Cair              ', '1010102002', '115131'),
(25, '1', '01', '01', '02', '', 'Bahan Kimia Gas               ', '1010102003', '115131'),
(26, '1', '01', '01', '02', '', 'Bahan Kimia Nuklir            ', '1010102005', '115131'),
(27, '1', '01', '01', '02', '', 'Bahan Kimia Lainnya           ', '1010102999', '115131'),
(28, '1', '01', '01', '03', '', 'Anfo                          ', '1010103001', '115112'),
(29, '1', '01', '01', '03', '', 'Detonator                     ', '1010103002', '115112'),
(30, '1', '01', '01', '03', '', 'Dinamit                       ', '1010103003', '115112'),
(31, '1', '01', '01', '03', '', 'Gelatine                      ', '1010103004', '115112'),
(32, '1', '01', '01', '03', '', 'Sumbu Ledak/Api               ', '1010103005', '115112'),
(33, '1', '01', '01', '03', '', 'Amunisi                       ', '1010103006', '115112'),
(34, '1', '01', '01', '03', '', 'Bahan Peledak Lainnya         ', '1010103999', '115112'),
(35, '1', '01', '01', '04', '', 'Bahan Bakar Minyak            ', '1010104001', '115131'),
(36, '1', '01', '01', '04', '', 'Minyak Pelumas                ', '1010104002', '115131'),
(37, '1', '01', '01', '04', '', 'Minyak Hydrolis               ', '1010104003', '115131'),
(38, '1', '01', '01', '04', '', 'Bahan Bakar Gas               ', '1010104004', '115131'),
(39, '1', '01', '01', '04', '', 'Batubara                      ', '1010104005', '115131'),
(40, '1', '01', '01', '04', '', 'Bahan Bakar Dan Pelumas Lainny', '1010104999', '115131'),
(41, '1', '01', '01', '05', '', 'Kawat                         ', '1010105001', '115131'),
(42, '1', '01', '01', '05', '', 'Kayu                          ', '1010105002', '115131'),
(43, '1', '01', '01', '05', '', 'Logam/Metalorgi               ', '1010105003', '115131'),
(44, '1', '01', '01', '05', '', 'Latex                         ', '1010105004', '115131'),
(45, '1', '01', '01', '05', '', 'Biji Plastik                  ', '1010105005', '115131'),
(46, '1', '01', '01', '05', '', 'Karet (Bahan Baku)            ', '1010105006', '115131'),
(47, '1', '01', '01', '05', '', 'Bahan Baku Lainnya            ', '1010105999', '115131'),
(48, '1', '01', '01', '06', '', 'Uranium - 233                 ', '1010106001', '115131'),
(49, '1', '01', '01', '06', '', 'Uranium - 235                 ', '1010106002', '115131'),
(50, '1', '01', '01', '06', '', 'Uranium - 238                 ', '1010106003', '115131'),
(51, '1', '01', '01', '06', '', 'Plutonium (PU)                ', '1010106004', '115131'),
(52, '1', '01', '01', '06', '', 'Neptarim (NP)                 ', '1010106005', '115131'),
(53, '1', '01', '01', '06', '', 'Uranium Dioksida              ', '1010106006', '115131'),
(54, '1', '01', '01', '06', '', 'Thorium                       ', '1010106007', '115131'),
(55, '1', '01', '01', '06', '', 'Bahan Kimia Nuklir Lainnya    ', '1010106999', '115131'),
(56, '1', '01', '01', '07', '', 'Barang Dalam Proses           ', '1010107001', '115131'),
(57, '1', '01', '01', '07', '', 'Barang Dalam Proses Lainnya   ', '1010107999', '115131'),
(58, '1', '01', '01', '99', '', 'Bahan Lainnya                 ', '1010199999', '115131'),
(59, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Dara', '1010201001', '115114'),
(60, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Dara', '1010201002', '115114'),
(61, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Apun', '1010201003', '115114'),
(62, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Apun', '1010201004', '115114'),
(63, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Udar', '1010201005', '115114'),
(64, '1', '01', '02', '01', '', 'Suku Cadang Alat Angkutan Lain', '1010201999', '115114'),
(65, '1', '01', '02', '02', '', 'Suku Cadang Alat Besar Darat  ', '1010202001', '115114'),
(66, '1', '01', '02', '02', '', 'Suku Cadang Alat Besar Apung  ', '1010202002', '115114'),
(67, '1', '01', '02', '02', '', 'Suku Cadang Alat Besar Bantu  ', '1010202003', '115114'),
(68, '1', '01', '02', '02', '', 'Suku Cadang Alat Besar Lainnya', '1010202999', '115114'),
(69, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Um', '1010203001', '115114'),
(70, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Gi', '1010203002', '115114'),
(71, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ke', '1010203003', '115114'),
(72, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Be', '1010203004', '115114'),
(73, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ke', '1010203005', '115114'),
(74, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran TH', '1010203006', '115114'),
(75, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ma', '1010203007', '115114'),
(76, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Pe', '1010203008', '115114'),
(77, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Al', '1010203009', '115114'),
(78, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Po', '1010203010', '115114'),
(79, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Un', '1010203011', '115114'),
(80, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Sy', '1010203012', '115114'),
(81, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ja', '1010203013', '115114'),
(82, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Nu', '1010203014', '115114'),
(83, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ra', '1010203015', '115114'),
(84, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ku', '1010203016', '115114'),
(85, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran Ug', '1010203017', '115114'),
(86, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran He', '1010203018', '115114'),
(87, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran He', '1010203019', '115114'),
(88, '1', '01', '02', '03', '', 'Suku Cadang Alat Kedokteran La', '1010203999', '115114'),
(89, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204001', '115114'),
(90, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204002', '115114'),
(91, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204003', '115114'),
(92, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204004', '115114'),
(93, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204005', '115114'),
(94, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204006', '115114'),
(95, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204007', '115114'),
(96, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204008', '115114'),
(97, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204009', '115114'),
(98, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204010', '115114'),
(99, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204011', '115114'),
(100, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204012', '115114'),
(101, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204013', '115114'),
(102, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204014', '115114'),
(103, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204015', '115114'),
(104, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204016', '115114'),
(105, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204017', '115114'),
(106, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204018', '115114'),
(107, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204019', '115114'),
(108, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204020', '115114'),
(109, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204021', '115114'),
(110, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204022', '115114'),
(111, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204023', '115114'),
(112, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204024', '115114'),
(113, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204025', '115114'),
(114, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204026', '115114'),
(115, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204027', '115114'),
(116, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204028', '115114'),
(117, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204029', '115114'),
(118, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204030', '115114'),
(119, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204031', '115114'),
(120, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204032', '115114'),
(121, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204033', '115114'),
(122, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204034', '115114'),
(123, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204035', '115114'),
(124, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204036', '115114'),
(125, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204037', '115114'),
(126, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204038', '115114'),
(127, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204039', '115114'),
(128, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204040', '115114'),
(129, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204041', '115114'),
(130, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204042', '115114'),
(131, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204043', '115114'),
(132, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204044', '115114'),
(133, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204045', '115114'),
(134, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204046', '115114'),
(135, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204047', '115114'),
(136, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204048', '115114'),
(137, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204049', '115114'),
(138, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204050', '115114'),
(139, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204051', '115114'),
(140, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204052', '115114'),
(141, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204053', '115114'),
(142, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204054', '115114'),
(143, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204055', '115114'),
(144, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204056', '115114'),
(145, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204057', '115114'),
(146, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204058', '115114'),
(147, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204059', '115114'),
(148, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204060', '115114'),
(149, '1', '01', '02', '04', '', 'Suku Cadang Alat Laboratorium ', '1010204999', '115114'),
(150, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar MF/M', '1010205001', '115114'),
(151, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar HF/S', '1010205002', '115114'),
(152, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar FHF/', '1010205003', '115114'),
(153, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar UHF ', '1010205004', '115114'),
(154, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar SHF ', '1010205005', '115114'),
(155, '1', '01', '02', '05', '', 'Suku Cadang Alat Pemancar Lain', '1010205999', '115114'),
(156, '1', '01', '02', '06', '', 'Suku Cadang Alat Studio       ', '1010206001', '115114'),
(157, '1', '01', '02', '06', '', 'Suku Cadang Alat Komunikasi   ', '1010206002', '115114'),
(158, '1', '01', '02', '06', '', 'Suku Cadang Alat Studio Dan Ko', '1010206999', '115114'),
(159, '1', '01', '02', '07', '', 'Suku Cadang Alat Pengolahan Te', '1010207001', '115114'),
(160, '1', '01', '02', '07', '', 'Suku Cadang Alat Pemeliharaan ', '1010207002', '115114'),
(161, '1', '01', '02', '07', '', 'Suku Cadang Alat Panen        ', '1010207003', '115114'),
(162, '1', '01', '02', '07', '', 'Suku Cadang Alat Penyimpanan H', '1010207004', '115114'),
(163, '1', '01', '02', '07', '', 'Suku Cadang Alat Laboratorium ', '1010207005', '115114'),
(164, '1', '01', '02', '07', '', 'Suku Cadang Alat Prossesing   ', '1010207006', '115114'),
(165, '1', '01', '02', '07', '', 'Suku Cadang Alat Paska Panen  ', '1010207007', '115114'),
(166, '1', '01', '02', '07', '', 'Suku Cadang Alat Produksi     ', '1010207008', '115114'),
(167, '1', '01', '02', '07', '', 'Suku Cadang Alat Pertanian Lai', '1010207999', '115114'),
(168, '1', '01', '02', '08', '', 'Suku Cadang Alat Bengkel Berme', '1010208001', '115114'),
(169, '1', '01', '02', '08', '', 'Suku Cadang Alat Bengkel Tidak', '1010208002', '115114'),
(170, '1', '01', '02', '08', '', 'Suku Cadang Alat Bengkel Lainn', '1010208999', '115114'),
(171, '1', '01', '02', '99', '', 'Suku Cadang Lainnya           ', '1010299999', '115114'),
(172, '1', '01', '03', '01', '', 'Alat Tulis                    ', '1010301001', '115111'),
(173, '1', '01', '03', '01', '', 'Tinta Tulis, Tinta Stempel    ', '1010301002', '115111'),
(174, '1', '01', '03', '01', '', 'Penjepit Kertas               ', '1010301003', '115111'),
(175, '1', '01', '03', '01', '', 'Penghapus/Korektor            ', '1010301004', '115111'),
(176, '1', '01', '03', '01', '', 'Buku Tulis                    ', '1010301005', '115111'),
(177, '1', '01', '03', '01', '', 'Ordner Dan Map                ', '1010301006', '115111'),
(178, '1', '01', '03', '01', '', 'Penggaris                     ', '1010301007', '115111'),
(179, '1', '01', '03', '01', '', 'Cutter (Alat Tulis Kantor)    ', '1010301008', '115111'),
(180, '1', '01', '03', '01', '', 'Pita Mesin Ketik              ', '1010301009', '115111'),
(181, '1', '01', '03', '01', '', 'Alat Perekat                  ', '1010301010', '115111'),
(182, '1', '01', '03', '01', '', 'Stadler HD                    ', '1010301011', '115111'),
(183, '1', '01', '03', '01', '', 'Staples                       ', '1010301012', '115111'),
(184, '1', '01', '03', '01', '', 'Isi Staples                   ', '1010301013', '115111'),
(185, '1', '01', '03', '01', '', 'Barang Cetakan                ', '1010301014', '115111'),
(186, '1', '01', '03', '01', '', 'Seminar Kit                   ', '1010301015', '115111'),
(187, '1', '01', '03', '01', '', 'Alat Tulis Kantor Lainnya     ', '1010301999', '115111'),
(188, '1', '01', '03', '02', '', 'Kertas HVS                    ', '1010302001', '115111'),
(189, '1', '01', '03', '02', '', 'Berbagai Kertas               ', '1010302002', '115111'),
(190, '1', '01', '03', '02', '', 'Kertas Cover                  ', '1010302003', '115111'),
(191, '1', '01', '03', '02', '', 'Amplop                        ', '1010302004', '115111'),
(192, '1', '01', '03', '02', '', 'Kop Surat                     ', '1010302005', '115111'),
(193, '1', '01', '03', '02', '', 'Kertas Dan Cover Lainnya      ', '1010302999', '115111'),
(194, '1', '01', '03', '03', '', 'Transparant Sheet             ', '1010303001', '115111'),
(195, '1', '01', '03', '03', '', 'Tinta Cetak                   ', '1010303002', '115111'),
(196, '1', '01', '03', '03', '', 'Plat Cetak                    ', '1010303003', '115111'),
(197, '1', '01', '03', '03', '', 'Stensil Sheet                 ', '1010303004', '115111'),
(198, '1', '01', '03', '03', '', 'Chenical/Bahan Kimia Cetak    ', '1010303005', '115111'),
(199, '1', '01', '03', '03', '', 'Film Cetak                    ', '1010303006', '115111'),
(200, '1', '01', '03', '03', '', 'Bahan Cetak Lainnya           ', '1010303999', '115111'),
(201, '1', '01', '03', '04', '', 'Continuous Form               ', '1010304001', '115111'),
(202, '1', '01', '03', '04', '', 'Computer File/Tempat Disket   ', '1010304002', '115111'),
(203, '1', '01', '03', '04', '', 'Pita Printer                  ', '1010304003', '115111'),
(204, '1', '01', '03', '04', '', 'Tinta/Toner Printer           ', '1010304004', '115111'),
(205, '1', '01', '03', '04', '', 'Disket                        ', '1010304005', '115111'),
(206, '1', '01', '03', '04', '', 'USB/Flash Disk                ', '1010304006', '115111'),
(207, '1', '01', '03', '04', '', 'kartu Memori                  ', '1010304007', '115111'),
(208, '1', '01', '03', '04', '', 'CD/DVD Drive                  ', '1010304008', '115111'),
(209, '1', '01', '03', '04', '', 'Harddisk Internal             ', '1010304009', '115111'),
(210, '1', '01', '03', '04', '', 'Mouse                         ', '1010304010', '115111'),
(211, '1', '01', '03', '04', '', 'CD/DVD                        ', '1010304011', '115111'),
(212, '1', '01', '03', '04', '', 'Bahan Komputer Lainnya        ', '1010304999', '115111'),
(213, '1', '01', '03', '05', '', 'Sapu Dan Sikat                ', '1010305001', '115113'),
(214, '1', '01', '03', '05', '', 'Alat-Alat Pel Dan Lap         ', '1010305002', '115113'),
(215, '1', '01', '03', '05', '', 'Ember, Slang, Dan Tempat Air L', '1010305003', '115113'),
(216, '1', '01', '03', '05', '', 'Keset Dan Tempat Sampah       ', '1010305004', '115113'),
(217, '1', '01', '03', '05', '', 'Kunci, Kran Dan Semprotan     ', '1010305005', '115113'),
(218, '1', '01', '03', '05', '', 'Alat Pengikat                 ', '1010305006', '115113'),
(219, '1', '01', '03', '05', '', 'Peralatan Ledeng              ', '1010305007', '115113'),
(220, '1', '01', '03', '05', '', 'Bahan Kimia Untuk Pembersih   ', '1010305008', '115113'),
(221, '1', '01', '03', '05', '', 'Alat Untuk Makan Dan Minum    ', '1010305009', '115113'),
(222, '1', '01', '03', '05', '', 'Kaos Lampu Petromak           ', '1010305010', '115113'),
(223, '1', '01', '03', '05', '', 'Kaca Lampu Petromak           ', '1010305011', '115113'),
(224, '1', '01', '03', '05', '', 'Pengharum Ruangan             ', '1010305012', '115113'),
(225, '1', '01', '03', '05', '', 'Kuas                          ', '1010305013', '115113'),
(226, '1', '01', '03', '05', '', 'Segel/Tanda Pengaman          ', '1010305014', '115113'),
(227, '1', '01', '03', '05', '', 'Perabot Kantor Lainnya        ', '1010305999', '115113'),
(228, '1', '01', '03', '06', '', 'Kabel Listrik                 ', '1010306001', '115111'),
(229, '1', '01', '03', '06', '', 'Lampu Listrik                 ', '1010306002', '115111'),
(230, '1', '01', '03', '06', '', 'Stop Kontak                   ', '1010306003', '115111'),
(231, '1', '01', '03', '06', '', 'Saklar                        ', '1010306004', '115111'),
(232, '1', '01', '03', '06', '', 'Stacker                       ', '1010306005', '115111'),
(233, '1', '01', '03', '06', '', 'Balast                        ', '1010306006', '115111'),
(234, '1', '01', '03', '06', '', 'Starter                       ', '1010306007', '115111'),
(235, '1', '01', '03', '06', '', 'Vitting                       ', '1010306008', '115111'),
(236, '1', '01', '03', '06', '', 'Accu                          ', '1010306009', '115111'),
(237, '1', '01', '03', '06', '', 'Batu Baterai                  ', '1010306010', '115111'),
(238, '1', '01', '03', '06', '', 'Stavol                        ', '1010306011', '115111'),
(239, '1', '01', '03', '06', '', 'Alat Listrik Lainnya          ', '1010306999', '115111'),
(240, '1', '01', '03', '07', '', 'Bahan Baku Pakaian            ', '1010307001', '115111'),
(241, '1', '01', '03', '07', '', 'Penutup Kepala                ', '1010307002', '115111'),
(242, '1', '01', '03', '07', '', 'Penutup Badan                 ', '1010307003', '115111'),
(243, '1', '01', '03', '07', '', 'Penutup Tangan                ', '1010307004', '115111'),
(244, '1', '01', '03', '07', '', 'Penutup Kaki                  ', '1010307005', '115111'),
(245, '1', '01', '03', '07', '', 'Atribut                       ', '1010307006', '115111'),
(246, '1', '01', '03', '07', '', 'Perlengkapan Lapangan         ', '1010307007', '115111'),
(247, '1', '01', '03', '07', '', 'Perlengkapan Dinas Lainnya    ', '1010307999', '115111'),
(248, '1', '01', '03', '08', '', 'Kaporlap dan Perlengkapan Satw', '1010308001', '115111'),
(249, '1', '01', '03', '08', '', 'Kaporlap dan Perlengkapan Satw', '1010308002', '115111'),
(250, '1', '01', '03', '08', '', 'Kaporlap Dan Perlengkapan Satw', '1010308999', '115111'),
(251, '1', '01', '03', '99', '', 'Alat/bahan Untuk Kegiatan Kant', '1010399999', '115111'),
(252, '1', '01', '04', '01', '', 'Obat Cair                     ', '1010401001', '115199'),
(253, '1', '01', '04', '01', '', 'Obat Padat                    ', '1010401002', '115199'),
(254, '1', '01', '04', '01', '', 'Obat Gas                      ', '1010401003', '115199'),
(255, '1', '01', '04', '01', '', 'Obat Serbuk/Tepung            ', '1010401004', '115199'),
(256, '1', '01', '04', '01', '', 'Obat Gel/Salep                ', '1010401005', '115199'),
(257, '1', '01', '04', '01', '', 'Alat/Obat Kontrasepsi Keluarga', '1010401006', '115199'),
(258, '1', '01', '04', '01', '', 'Non Alat/Obat Kontrasepsi Kelu', '1010401007', '115199'),
(259, '1', '01', '04', '01', '', 'Obat Lainnya                  ', '1010401999', '115199'),
(260, '1', '01', '05', '01', '', 'Pita Cukai, Materai, Leges    ', '1010501001', '115121'),
(261, '1', '01', '05', '01', '', 'Tanah dan Bangunan            ', '1010501002', '115122'),
(262, '1', '01', '05', '01', '', 'Hewan dan Tanaman             ', '1010501003', '115123'),
(263, '1', '01', '05', '01', '', 'Peralatan dan Mesin           ', '1010501004', '115124'),
(264, '1', '01', '05', '01', '', 'Jalan, Irigasi, dan Jaringan  ', '1010501005', '115125'),
(265, '1', '01', '05', '01', '', 'Aset Tetap Lainnya            ', '1010501006', '115126'),
(266, '1', '01', '05', '01', '', 'Aset Lain-lain                ', '1010501007', '115127'),
(267, '1', '01', '05', '01', '', 'Barang Persediaan             ', '1010501008', '115128'),
(268, '1', '01', '06', '01', '', 'Cadangan Energi               ', '1010601001', '115191'),
(269, '1', '01', '06', '01', '', 'Cadangan Pangan               ', '1010601002', '115191'),
(270, '1', '01', '06', '01', '', 'Persediaan Untuk Tujuan Strate', '1010601999', '115191'),
(271, '1', '01', '07', '01', '', 'Makanan/Sembako               ', '1010701001', '115111'),
(272, '1', '01', '07', '01', '', 'Minuman                       ', '1010701002', '115111'),
(273, '1', '01', '07', '01', '', 'Natura Lainnya                ', '1010701999', '115111'),
(274, '1', '01', '07', '02', '', 'Pakan Hewan                   ', '1010702001', '115111'),
(275, '1', '01', '07', '02', '', 'Pakan Ikan                    ', '1010702002', '115111'),
(276, '1', '01', '07', '02', '', 'Pakan Lainnya                 ', '1010702999', '115111'),
(277, '1', '01', '07', '99', '', 'Natura Dan Pakan Lainnya      ', '1010799999', '115111'),
(278, '1', '01', '08', '01', '', 'Hewan/Ternak                  ', '1010801001', '115199'),
(279, '1', '01', '08', '01', '', 'Biota Laut/Ikan               ', '1010801002', '115199'),
(280, '1', '01', '08', '01', '', 'Tanaman                       ', '1010801003', '115199'),
(281, '1', '01', '08', '01', '', 'Persediaan Penelitian Biologi ', '1010801999', '115199'),
(282, '1', '02', '01', '01', '', 'Komponen Jembatan Bailley     ', '1020101001', '115199'),
(283, '1', '02', '01', '01', '', 'Komponen Jembatan Baja Prefab ', '1020101002', '115199'),
(284, '1', '02', '01', '01', '', 'Komponen Jembatan Baja Lainnya', '1020101999', '115199'),
(285, '1', '02', '01', '02', '', 'Komponen Jembatan Pratekan Pre', '1020102001', '115199'),
(286, '1', '02', '01', '02', '', 'Komponen Jembatan Pratekan Lai', '1020102999', '115199'),
(287, '1', '02', '01', '03', '', 'Dinamo Amper                  ', '1020103001', '115199'),
(288, '1', '02', '01', '03', '', 'Dinamo Start                  ', '1020103002', '115199'),
(289, '1', '02', '01', '03', '', 'Transmisi                     ', '1020103003', '115199'),
(290, '1', '02', '01', '03', '', 'Injection Pump                ', '1020103004', '115199'),
(291, '1', '02', '01', '03', '', 'Karburator Unit               ', '1020103005', '115199'),
(292, '1', '02', '01', '03', '', 'Motor Hidrolik                ', '1020103006', '115199'),
(293, '1', '02', '01', '03', '', 'Engine Bensin                 ', '1020103007', '115199'),
(294, '1', '02', '01', '03', '', 'Engine Diesel                 ', '1020103008', '115199'),
(295, '1', '02', '01', '03', '', 'Komponen Peralatan Lainnya    ', '1020103999', '115199'),
(296, '1', '02', '01', '04', '', 'Komponen Rambu-Rambu Darat    ', '1020104001', '115199'),
(297, '1', '02', '01', '04', '', 'Komponen Rambu-Rambu Udara    ', '1020104002', '115199'),
(298, '1', '02', '01', '04', '', 'Komponen Rambu-Rambu Lainnya  ', '1020104999', '115199'),
(299, '1', '02', '01', '05', '', 'Blade                         ', '1020105001', '115199'),
(300, '1', '02', '01', '05', '', 'Boom                          ', '1020105002', '115199'),
(301, '1', '02', '01', '05', '', 'Bucket                        ', '1020105003', '115199'),
(302, '1', '02', '01', '05', '', 'Scarifier                     ', '1020105004', '115199'),
(303, '1', '02', '01', '05', '', 'Attachment Lainnya            ', '1020105999', '115199'),
(304, '1', '02', '01', '99', '', 'Komponen Lainnya              ', '1020199999', '115199'),
(305, '1', '02', '02', '01', '', 'DCI Filter                    ', '1020201001', '115199'),
(306, '1', '02', '02', '01', '', 'Pipa Air Besi Tuang           ', '1020201002', '115199'),
(307, '1', '02', '02', '01', '', 'Pipa Air Besi Tuang (DCI) Lain', '1020201999', '115199'),
(313, '1', '02', '02', '02', '', 'Pipa Asbes Semen (ACP) Lainnya', '1020202999', '115199'),
(314, '1', '02', '02', '03', '', 'Pipa Baja Gelombang           ', '1020203001', '115199'),
(315, '1', '02', '02', '03', '', 'Pipa Baja Konstruksi (CSP)    ', '1020203002', '115199'),
(316, '1', '02', '02', '03', '', 'Pipa Baja Lapis Polyethelene  ', '1020203003', '115199'),
(317, '1', '02', '02', '03', '', 'Pipa Baja Lapis Seng (GIP)    ', '1020203004', '115199'),
(318, '1', '02', '02', '03', '', 'Pipa Baja Lainnya             ', '1020203999', '115199'),
(319, '1', '02', '02', '04', '', 'Fitter Pipa Beton Pratekan    ', '1020204001', '115199'),
(320, '1', '02', '02', '04', '', 'Pipa Beton Pratekan           ', '1020204002', '115199'),
(321, '1', '02', '02', '04', '', 'Pipa Beton Pratekan Lainnya   ', '1020204999', '115199'),
(322, '1', '02', '02', '05', '', 'Filter Pipa Fiber Glass       ', '1020205001', '115199'),
(323, '1', '02', '02', '05', '', 'Pipa Fiber Glass              ', '1020205002', '115199'),
(324, '1', '02', '02', '05', '', 'Pipa Fiber Glass Lainnya      ', '1020205999', '115199'),
(325, '1', '02', '02', '06', '', 'Pipa Plastik PVC              ', '1020206001', '115199'),
(326, '1', '02', '02', '06', '', 'UPVC Fitter                   ', '1020206002', '115199'),
(327, '1', '02', '02', '06', '', 'Pipa Plastik PVC (UPVC) Lainny', '1020206999', '115199'),
(328, '1', '02', '02', '99', '', 'P I P A Lainnya               ', '1020299999', '115199'),
(329, '1', '02', '03', '01', '', 'Rambu - Rambu Lalu Lintas     ', '1020301001', '115199'),
(330, '1', '02', '03', '01', '', 'Rambu-rambu Lainnya           ', '1020301999', '115199'),
(331, '1', '03', '01', '01', '', 'Komponen Jembatan Baja Bekas  ', '1030101001', '115199'),
(332, '1', '03', '01', '01', '', 'Komponen Jembatan Pratekan Bek', '1030101002', '115199'),
(333, '1', '03', '01', '01', '', 'Komponen Peralatan Bekas      ', '1030101003', '115199'),
(334, '1', '03', '01', '01', '', 'Attachment Bekas              ', '1030101004', '115199'),
(335, '1', '03', '01', '01', '', 'Kotak dan Bilik Suara         ', '1030101005', '115199'),
(336, '1', '03', '01', '01', '', 'Komponen Bekas Lainnya        ', '1030101999', '115199'),
(337, '1', '03', '01', '02', '', 'Pipa Air Besi Tuang Bekas     ', '1030102001', '115199'),
(338, '1', '03', '01', '02', '', 'Pipa Asbes Semen Bekas        ', '1030102002', '115199'),
(339, '1', '03', '01', '02', '', 'Pipa Baja Bekas               ', '1030102003', '115199'),
(340, '1', '03', '01', '02', '', 'Pipa Beton Pratekan Bekas     ', '1030102004', '115199'),
(341, '1', '03', '01', '02', '', 'Pipa Fiber Gelas Bekas        ', '1030102005', '115199'),
(342, '1', '03', '01', '02', '', 'Pipa Plastik PVC (UPVC) Bekas ', '1030102006', '115199'),
(343, '1', '03', '01', '02', '', 'Pipa Bekas Lainnya            ', '1030102999', '115199'),
(344, '1', '03', '01', '99', '', 'Komponen Bekas Dan Pipa Bekas ', '1030199999', '115199');

-- --------------------------------------------------------

--
-- Table structure for table `thn_aktif`
--

CREATE TABLE IF NOT EXISTS `thn_aktif` (
  `id` int(6) NOT NULL,
  `tahun` int(6) NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'Tidak Aktif',
  `keterangan` varchar(128) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thn_aktif`
--

INSERT INTO `thn_aktif` (`id`, `tahun`, `status`, `keterangan`) VALUES
(6, 2015, 'Tidak Aktif', 'Tahun 2015'),
(7, 2016, 'Tidak Aktif', 'Tahun 2016'),
(8, 2014, 'Aktif', 'Anggaran 2014'),
(9, 2017, 'Tidak Aktif', 'Tahun Export'),
(10, 2013, 'Tidak Aktif', 'Aktifkan');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_full`
--

CREATE TABLE IF NOT EXISTS `transaksi_full` (
  `id_history` int(11) NOT NULL,
  `id_trans` int(11) DEFAULT NULL,
  `id_masuk` int(11) DEFAULT NULL,
  `id_keluar` int(11) DEFAULT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `kd_lok_msk` varchar(20) DEFAULT NULL,
  `nm_satker` varchar(40) NOT NULL,
  `thn_ang` year(4) DEFAULT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `kd_sskel` varchar(15) DEFAULT NULL,
  `nm_sskel` varchar(30) DEFAULT NULL,
  `nm_brg` varchar(30) DEFAULT NULL,
  `kd_perk` varchar(15) DEFAULT NULL,
  `nm_perk` varchar(20) DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `qty` mediumint(9) NOT NULL,
  `harga_sat` int(11) NOT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `status_edit` tinyint(1) NOT NULL DEFAULT '0',
  `status_hapus` tinyint(1) NOT NULL DEFAULT '0',
  `status_ambil` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_update` date DEFAULT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=680 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_full`
--

INSERT INTO `transaksi_full` (`id_history`, `id_trans`, `id_masuk`, `id_keluar`, `kd_lokasi`, `kd_lok_msk`, `nm_satker`, `thn_ang`, `no_dok`, `tgl_dok`, `tgl_buku`, `no_bukti`, `kd_brg`, `kd_sskel`, `nm_sskel`, `nm_brg`, `kd_perk`, `nm_perk`, `satuan`, `qty`, `harga_sat`, `total_harga`, `jns_trans`, `keterangan`, `status`, `status_edit`, `status_hapus`, `status_ambil`, `tgl_update`, `user_id`) VALUES
(589, 4, NULL, NULL, '21.01.01.01', '0630101000101UB', '', 2015, 'C-2015/03/01', '2015-03-01', '2015-03-01', 'C-2015/03/01', '101030101023', '1010301010', 'Alat Perekat        ', 'Lem Aibon', '115111', 'Barang Konsumsi     ', 'Kaleng', 10, 4500, 45000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(590, 5, NULL, NULL, '21.01.01.01', '0630101000101UB', '', 2015, 'C-2015/05/01', '2015-05-01', '2015-05-01', 'C-2015/05/01', '101030101023', '1010301010', 'Alat Perekat        ', 'Lem Aibon', '115111', 'Barang Konsumsi     ', 'Kaleng', 20, 12000, 240000, 'M03', 'Distribusi Masuk', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(595, 8, NULL, NULL, '21.01.01.01', '0630101000101UB', '', 2015, 'S-2015/01/01', '2015-01-01', '2015-01-01', 'S-2015/01/01', '101010100188', '1010101001', 'Aspal', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 20, 25000, 500000, 'M01', 'Saldo Awal', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(596, 9, NULL, NULL, '21.01.01.01', '0630101000101UB', '', 2015, 'P-2015/02/01', '2015-02-01', '2015-02-01', 'P-2015/02/01', '101010100188', '1010101001', 'Aspal', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 100, 30000, 3000000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(605, 8, NULL, NULL, '21.01.01.01', '0630101000101UB', '', 2014, 'S-2015/01/01', '2014-01-01', '2014-01-01', 'S-2014/01/01', '101010100188', '1010101001', 'Aspal', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 20, 25000, 500000, 'M01', 'Saldo Awal', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(606, 11, NULL, NULL, '010101', '010101', '', 2015, '', '2015-01-01', '2015-01-01', '', '1010301013011', '1010301013', 'Isi Staples         ', 'Stapler Content', '115111', 'Barang Konsumsi     ', 'Pack', 30, 5000, 150000, 'M01', 'Saldo awal', 1, 0, 0, 0, '2015-09-01', 'fikri.baru'),
(607, 12, NULL, NULL, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, '90sa', '2015-03-02', '2015-03-02', '90sa', '101010100188', '1010101001', 'Aspal', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 20, 1300000, 26000000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-02', 'pengguna'),
(609, 13, NULL, NULL, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, 'PB-2015/05/12', '2015-05-12', '2015-05-12', 'PB-2015/05/12', '101010100188', '1010101001', 'Aspal', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 4, 35000, 140000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-02', 'pengguna'),
(611, 14, NULL, NULL, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, 'PB-2015/05/01', '2015-05-01', '2015-05-01', 'PB-2015/05/01', '1010101001231', '1010101001', 'Aspal               ', 'ASPAL TIGA RODA', '115131', 'Bahan Baku          ', 'Drum', 5, 59999, 299995, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-02', 'pengguna'),
(613, 15, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '1234', '2015-01-01', '2015-01-01', '1234', '1010301013123', '1010301013', 'Isi Staples         ', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', 20, 2999, 59980, 'M01', 'Saldo Awal', 1, 0, 0, 0, '2015-09-03', 'koreksi'),
(653, 16, NULL, NULL, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, 'AAA', '2015-09-01', '2015-09-01', 'AAAA', '101010100188', '1010101001', 'Aspal', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 5, 16000, 80000, 'M01', 'Saldo Awal', 1, 0, 0, 0, '2015-09-03', 'pengguna'),
(655, 18, NULL, NULL, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, '111', '2015-09-03', '2015-09-03', '111', '101030101023', '1010301010', 'Alat Perekat        ', 'Lem Aibon', '115111', 'Barang Konsumsi     ', 'Kaleng', 6, 10000, 60000, 'M01', 'AibonSaldo', 1, 0, 0, 0, '2015-09-03', 'pengguna'),
(657, 33, NULL, NULL, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, '', '2015-09-03', '2015-09-03', '', '101010100188', '1010101001', 'Aspal', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', -9, -25000, -225000, 'K03', 'Rusak', 1, 0, 0, 0, '2015-09-03', 'pengguna'),
(658, 19, NULL, NULL, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, 'Masuk', '2015-05-01', '2015-09-03', 'Masuk', '101030101023', '1010301010', 'Alat Perekat        ', 'Lem Aibon', '115111', 'Barang Konsumsi     ', 'Kaleng', 50, 1000, 50000, 'M03', 'Masuk', 1, 0, 0, 0, '2015-09-03', 'pengguna'),
(659, 20, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-01-01', '2014-09-04', '', '1010301013123', '1010301013', 'Isi Staples         ', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', 20, 5000, 100000, 'M02', 'Pembelian ', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(660, 21, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-09-12', '2014-09-19', '', '1010301013123', '1010301013', 'Isi Staples         ', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', 10, 4500, 45000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(661, 22, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-08-17', '2014-08-17', '', '1010101020021', '1010101020', 'Karung              ', 'Karung Vinyl', '115131', 'Bahan Baku          ', 'pack', 30, 10000, 300000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(662, 23, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-08-20', '2014-08-20', '', '1010101020021', '1010101020', 'Karung              ', 'Karung Vinyl', '115131', 'Bahan Baku          ', 'pack', 20, 5000, 100000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(663, 34, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-09-20', '2014-09-20', '', '1010301013123', '1010301013', 'Isi Staples         ', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', -20, -5000, -100000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(664, 35, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-09-20', '2014-09-20', '', '1010301013123', '1010301013', 'Isi Staples         ', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', -5, -4500, -22500, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(665, 36, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-08-17', '2014-08-17', '', '1010101020021', '1010101020', 'Karung              ', 'Karung Vinyl', '115131', 'Bahan Baku          ', 'pack', -30, -10000, -300000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(666, 37, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-08-17', '2014-08-17', '', '1010101020021', '1010101020', 'Karung              ', 'Karung Vinyl', '115131', 'Bahan Baku          ', 'pack', -5, -5000, -25000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(667, 24, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-09-01', '2014-09-01', '', '1010301013123', '1010301013', 'Isi Staples         ', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', 10, 3000, 30000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(669, 25, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '9263829', '2015-08-01', '2015-08-01', '8376473', '1010301012001', '1010301012', 'Staples             ', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', 10, 10000, 100000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(670, 26, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'jsjkakdka', '2015-08-10', '2015-08-10', 'aksjdhfjsue', '1010301012001', '1010301012', 'Staples             ', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', 20, 15000, 300000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(671, 38, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '08273638', '2015-09-02', '2015-09-02', '273849', '1010301012001', '1010301012', 'Staples             ', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', -10, -10000, -100000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(672, 39, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '08273638', '2015-09-02', '2015-09-02', '273849', '1010301012001', '1010301012', 'Staples             ', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', -1, -15000, -15000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(673, 40, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'ajsh', '2015-09-03', '2015-09-03', 'jsjsj', '1010301012001', '1010301012', 'Staples             ', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', -19, -15000, -285000, 'K01', 'Habis DIpake', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(674, 39, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '', '2015-09-02', '2015-09-02', '273849', '1010301012001', '1010301012', 'Staples             ', 'Staples +Merk', '115111', 'Barang Konsumsi     ', '', 1, 15000, 15000, 'H01', 'Hapus Transaksi', 0, 0, 0, 0, '2015-09-04', 'fikri.f'),
(675, 41, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'ajsh', '2015-09-04', '2015-09-04', 'jsjdj', '1010301012001', '1010301012', 'Staples             ', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', -1, -15000, -15000, 'K02', 'Usang', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(676, 27, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'testing', '2015-05-05', '2015-05-01', 'testing', '1010301001127', '1010301001', 'Alat Tulis          ', 'FAber Castel', '115111', 'Barang Konsumsi     ', 'Lusin', 10, 10000, 100000, 'M02', 'esting', 1, 0, 0, 0, '2015-09-05', 'fikri.f'),
(677, 28, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'tes2', '2015-08-13', '2015-08-14', 'tes2', '1010301001127', '1010301001', 'Alat Tulis          ', 'FAber Castel', '115111', 'Barang Konsumsi     ', 'Lusin', 10, 12000, 120000, 'M02', 'tes', 1, 0, 0, 0, '2015-09-05', 'fikri.f'),
(678, 42, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'tes2', '2015-09-01', '2015-09-01', 'tes2', '1010301001127', '1010301001', 'Alat Tulis          ', 'FAber Castel', '115111', 'Barang Konsumsi     ', 'Lusin', -10, -10000, -100000, 'K01', 'tes2', 1, 0, 0, 0, '2015-09-05', 'fikri.f'),
(679, 43, NULL, NULL, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'tes2', '2015-09-01', '2015-09-01', 'tes2', '1010301001127', '1010301001', 'Alat Tulis          ', 'FAber Castel', '115111', 'Barang Konsumsi     ', 'Lusin', -3, -12000, -36000, 'K01', 'tes2', 1, 0, 0, 0, '2015-09-05', 'fikri.f');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_keluar`
--

CREATE TABLE IF NOT EXISTS `transaksi_keluar` (
  `id` int(11) NOT NULL,
  `id_masuk` int(11) DEFAULT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `kd_lok_msk` varchar(20) DEFAULT NULL,
  `nm_satker` varchar(40) DEFAULT NULL,
  `thn_ang` year(4) DEFAULT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `kd_sskel` varchar(15) DEFAULT NULL,
  `nm_sskel` varchar(30) DEFAULT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `nm_brg` varchar(30) DEFAULT NULL,
  `kd_perk` varchar(7) DEFAULT NULL,
  `nm_perk` varchar(20) DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `qty` mediumint(9) NOT NULL,
  `harga_sat` int(11) NOT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `status_edit` tinyint(1) NOT NULL DEFAULT '0',
  `status_hapus` tinyint(1) NOT NULL DEFAULT '0',
  `status_ambil` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_update` date DEFAULT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_keluar`
--

INSERT INTO `transaksi_keluar` (`id`, `id_masuk`, `kd_lokasi`, `kd_lok_msk`, `nm_satker`, `thn_ang`, `no_dok`, `tgl_dok`, `tgl_buku`, `no_bukti`, `kd_sskel`, `nm_sskel`, `kd_brg`, `nm_brg`, `kd_perk`, `nm_perk`, `satuan`, `qty`, `harga_sat`, `total_harga`, `jns_trans`, `keterangan`, `status`, `status_edit`, `status_hapus`, `status_ambil`, `tgl_update`, `user_id`) VALUES
(33, 10, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, '', '2015-09-03', '2015-09-03', '', '1010101001', 'Aspal', '101010100188', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', -9, 25000, -225000, 'K03', 'Rusak', 1, 0, 0, 0, '2015-09-03', 'pengguna'),
(34, 20, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-09-20', '2014-09-20', '', '1010301013', 'Isi Staples         ', '1010301013123', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', -20, 5000, -100000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(35, 21, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-09-20', '2014-09-20', '', '1010301013', 'Isi Staples         ', '1010301013123', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', -5, 4500, -22500, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(36, 22, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-08-17', '2014-08-17', '', '1010101020', 'Karung              ', '1010101020021', 'Karung Vinyl', '115131', 'Bahan Baku          ', 'pack', -30, 10000, -300000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(37, 23, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-08-17', '2014-08-17', '', '1010101020', 'Karung              ', '1010101020021', 'Karung Vinyl', '115131', 'Bahan Baku          ', 'pack', -5, 5000, -25000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(38, 25, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '08273638', '2015-09-02', '2015-09-02', '273849', '1010301012', 'Staples             ', '1010301012001', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', -10, 10000, -100000, 'K01', 'Habis Pakai', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(39, 26, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '08273638', '2015-09-02', '2015-09-02', '273849', '1010301012', 'Staples             ', '1010301012001', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', -1, 15000, -15000, 'K01', 'Habis Pakai', 1, 0, 1, 0, '2015-09-04', 'fikri.f'),
(40, 26, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'ajsh', '2015-09-03', '2015-09-03', 'jsjsj', '1010301012', 'Staples             ', '1010301012001', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', -19, 15000, -285000, 'K01', 'Habis DIpake', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(41, 26, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'ajsh', '2015-09-04', '2015-09-04', 'jsjdj', '1010301012', 'Staples             ', '1010301012001', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', -1, 15000, -15000, 'K02', 'Usang', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(42, 27, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'tes2', '2015-09-01', '2015-09-01', 'tes2', '1010301001', 'Alat Tulis          ', '1010301001127', 'FAber Castel', '115111', 'Barang Konsumsi     ', 'Lusin', -10, 10000, -100000, 'K01', 'tes2', 1, 0, 0, 0, '2015-09-05', 'fikri.f'),
(43, 28, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'tes2', '2015-09-01', '2015-09-01', 'tes2', '1010301001', 'Alat Tulis          ', '1010301001127', 'FAber Castel', '115111', 'Barang Konsumsi     ', 'Lusin', -3, 12000, -36000, 'K01', 'tes2', 1, 0, 0, 0, '2015-09-05', 'fikri.f');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_masuk`
--

CREATE TABLE IF NOT EXISTS `transaksi_masuk` (
  `id` int(11) NOT NULL,
  `kd_lokasi` varchar(20) NOT NULL,
  `kd_lok_msk` varchar(20) DEFAULT NULL,
  `nm_satker` varchar(40) DEFAULT NULL,
  `thn_ang` year(4) DEFAULT NULL,
  `no_dok` varchar(20) NOT NULL,
  `tgl_dok` date NOT NULL,
  `tgl_buku` date NOT NULL,
  `no_bukti` varchar(20) NOT NULL,
  `kd_sskel` varchar(20) DEFAULT NULL,
  `nm_sskel` varchar(30) DEFAULT NULL,
  `kd_brg` varchar(30) NOT NULL,
  `nm_brg` varchar(30) DEFAULT NULL,
  `kd_perk` varchar(7) DEFAULT NULL,
  `nm_perk` varchar(20) DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `qty` mediumint(9) NOT NULL,
  `qty_akhir` mediumint(9) DEFAULT NULL,
  `harga_sat` int(11) NOT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `jns_trans` varchar(5) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `status_edit` tinyint(1) NOT NULL DEFAULT '0',
  `status_hapus` tinyint(1) NOT NULL DEFAULT '0',
  `status_ambil` tinyint(1) NOT NULL DEFAULT '0',
  `tgl_update` date DEFAULT NULL,
  `user_id` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi_masuk`
--

INSERT INTO `transaksi_masuk` (`id`, `kd_lokasi`, `kd_lok_msk`, `nm_satker`, `thn_ang`, `no_dok`, `tgl_dok`, `tgl_buku`, `no_bukti`, `kd_sskel`, `nm_sskel`, `kd_brg`, `nm_brg`, `kd_perk`, `nm_perk`, `satuan`, `qty`, `qty_akhir`, `harga_sat`, `total_harga`, `jns_trans`, `keterangan`, `status`, `status_edit`, `status_hapus`, `status_ambil`, `tgl_update`, `user_id`) VALUES
(4, '21.01.01.01', '0630101000101UB', 'URUSAN BERSAMA BPOM DKI', 2015, 'C-2015/03/01', '2015-03-01', '2015-03-01', 'C-2015/03/01', '1010301010', 'Alat Perekat        ', '101030101023', 'Lem Aibon', '115111', 'Barang Konsumsi     ', 'Kaleng', 10, 10, 4500, 45000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(5, '21.01.01.01', '0630101000101UB', 'URUSAN BERSAMA BPOM DKI', 2015, 'C-2015/05/01', '2015-05-01', '2015-05-01', 'C-2015/05/01', '1010301010', 'Alat Perekat        ', '101030101023', 'Lem Aibon', '115111', 'Barang Konsumsi     ', 'Kaleng', 20, 20, 12000, 240000, 'M03', 'Distribusi Masuk', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(8, '21.01.01.01', '0630101000101UB', 'URUSAN BERSAMA BPOM DKI', 2015, 'S-2015/01/01', '2015-01-01', '2015-01-01', 'S-2015/01/01', '1010101001', 'Aspal', '101010100188', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 20, 20, 25000, 500000, 'M01', 'Saldo Awal', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(9, '21.01.01.01', '0630101000101UB', 'URUSAN BERSAMA BPOM DKI', 2015, 'P-2015/02/01', '2015-02-01', '2015-02-01', 'P-2015/02/01', '1010101001', 'Aspal', '101010100188', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 100, 100, 30000, 3000000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(10, '21.01.01.01', '0630101000101UB', 'URUSAN BERSAMA BPOM DKI', 2014, 'S-2014/01/01', '2014-01-01', '2014-01-01', 'S-2014/01/01', '1010101001', 'Aspal', '101010100188', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 20, 11, 25000, 500000, 'M01', 'Saldo Awal', 1, 0, 0, 0, '2015-08-27', 'pengguna'),
(11, '010101', '010101', 'Sekretariat Dewan/DPRD', 2015, '', '2015-01-01', '2015-01-01', '', '1010301013', 'Isi Staples         ', '1010301013011', 'Stapler Content', '115111', 'Barang Konsumsi     ', 'Pack', 30, 30, 5000, 150000, 'M01', 'Saldo awal', 1, 0, 0, 0, '2015-09-01', 'fikri.baru'),
(12, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, '90sa', '2015-03-02', '2015-03-02', '90sa', '1010101001', 'Aspal', '101010100188', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 20, 20, 1300000, 26000000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-02', 'pengguna'),
(13, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, 'PB-2015/05/12', '2015-05-12', '2015-05-12', 'PB-2015/05/12', '1010101001', 'Aspal', '101010100188', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 4, 4, 35000, 140000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-02', 'pengguna'),
(14, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, 'PB-2015/05/01', '2015-05-01', '2015-05-01', 'PB-2015/05/01', '1010101001', 'Aspal               ', '1010101001231', 'ASPAL TIGA RODA', '115131', 'Bahan Baku          ', 'Drum', 5, 5, 59999, 299995, 'M02', 'Pembelian', 1, 0, 1, 0, '2015-09-02', 'pengguna'),
(15, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '1234', '2015-01-01', '2015-01-01', '1234', '1010301013', 'Isi Staples         ', '1010301013123', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', 21, 21, 3501, 73521, 'M01', 'Saldo Awal', 1, 0, 1, 0, '2015-09-03', 'koreksi'),
(16, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, 'AAA', '2015-09-01', '2015-09-01', 'AAAA', '1010101001', 'Aspal', '101010100188', 'Aspal Cair', '115131', 'Bahan Baku', 'Drum', 5, 5, 16000, 80000, 'M01', 'Saldo Awal', 1, 0, 0, 0, '2015-09-03', 'pengguna'),
(18, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, '111', '2015-09-03', '2015-09-03', '111', '1010301010', 'Alat Perekat        ', '101030101023', 'Lem Aibon', '115111', 'Barang Konsumsi     ', 'Kaleng', 6, 6, 10000, 60000, 'M01', 'AibonSaldo', 1, 0, 1, 0, '2015-09-03', 'pengguna'),
(19, '21.01.01.01', '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', 2015, 'Masuk', '2015-05-01', '2015-09-03', 'Masuk', '1010301010', 'Alat Perekat        ', '101030101023', 'Lem Aibon', '115111', 'Barang Konsumsi     ', 'Kaleng', 50, 50, 1000, 50000, 'M03', 'Masuk', 1, 0, 0, 0, '2015-09-03', 'pengguna'),
(20, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-01-01', '2014-09-04', '', '1010301013', 'Isi Staples         ', '1010301013123', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', 20, 0, 5000, 100000, 'M02', 'Pembelian ', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(21, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-09-12', '2014-09-19', '', '1010301013', 'Isi Staples         ', '1010301013123', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', 10, 5, 4500, 45000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(22, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-08-17', '2014-08-17', '', '1010101020', 'Karung              ', '1010101020021', 'Karung Vinyl', '115131', 'Bahan Baku          ', 'pack', 30, 0, 10000, 300000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(23, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-08-20', '2014-08-20', '', '1010101020', 'Karung              ', '1010101020021', 'Karung Vinyl', '115131', 'Bahan Baku          ', 'pack', 20, 15, 5000, 100000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'koreksi'),
(24, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2014, '', '2014-09-01', '2014-09-01', '', '1010301013', 'Isi Staples         ', '1010301013123', 'ISI STAPLES', '115111', 'Barang Konsumsi     ', 'Box', 10, 10, 3000, 30000, 'M02', 'Pembelian', 1, 0, 1, 0, '2015-09-04', 'koreksi'),
(25, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, '9263829', '2015-08-01', '2015-08-01', '8376473', '1010301012', 'Staples             ', '1010301012001', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', 10, 0, 10000, 100000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(26, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'jsjkakdka', '2015-08-10', '2015-08-10', 'aksjdhfjsue', '1010301012', 'Staples             ', '1010301012001', 'Staples +Merk', '115111', 'Barang Konsumsi     ', 'Buah', 20, 0, 15000, 300000, 'M02', 'Pembelian', 1, 0, 0, 0, '2015-09-04', 'fikri.f'),
(27, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'testing', '2015-05-05', '2015-05-01', 'testing', '1010301001', 'Alat Tulis          ', '1010301001127', 'FAber Castel', '115111', 'Barang Konsumsi     ', 'Lusin', 10, 0, 10000, 100000, 'M02', 'esting', 1, 0, 0, 0, '2015-09-05', 'fikri.f'),
(28, '01.01.01.01', '01.01.01.01', 'Sekretariat Dewan/DPRD', 2015, 'tes2', '2015-08-13', '2015-08-14', 'tes2', '1010301001', 'Alat Tulis          ', '1010301001127', 'FAber Castel', '115111', 'Barang Konsumsi     ', 'Lusin', 10, 7, 12000, 120000, 'M02', 'tes', 1, 0, 0, 0, '2015-09-05', 'fikri.f');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ttd`
--

INSERT INTO `ttd` (`id`, `kd_lokasi`, `kota`, `tanggal`, `nip`, `nama`, `jabatan`, `nip2`, `nama2`, `jabatan2`, `tgl_isi`, `tgl_setuju`, `unit`) VALUES
(1, '01.01.01.01', 'Depok', '0000-00-00', '9283731', 'Iman', 'Kepala', '8379299', 'BAyu', 'Wakil', '0000-00-00', '0000-00-00', '1');

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
  `kd_lokasi` varchar(20) DEFAULT NULL,
  `nm_satker` varchar(40) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_level`, `kd_lokasi`, `nm_satker`, `tahun`) VALUES
(1, 'masteradmin', '0192023a7bbd73250516f069df18b500', 'yohanes.christomas@gmail.com', 1, NULL, NULL, NULL),
(2, 'masteruser', '0192023a7bbd73250516f069df18b500', 'yohanes.christomas@gmail.com', 2, NULL, NULL, NULL),
(6, 'fikri', 'e10adc3949ba59abbe56e057f20f883e', 'fikri.fadlillah@yahoo.com', 2, '0010101000101KP', 'KANTOR PUSAT SEKJEN MPR', NULL),
(7, 'pengguna', 'e10adc3949ba59abbe56e057f20f883e', 'pengguna@yahoo.com', 2, '21.01.01.01', 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH', NULL),
(8, 'koreksi', 'c4ca4238a0b923820dcc509a6f75849b', 'koreksi', 2, '01.01.01.01', 'Sekretariat Dewan/DPRD', NULL),
(9, 'fikri.f', 'e10adc3949ba59abbe56e057f20f883e', 'fikri.fadlillah@yahoo.com', 2, '01.01.01.01', 'Sekretariat Dewan/DPRD', NULL),
(10, 'iman', 'c4ca4238a0b923820dcc509a6f75849b', 'iman@gmail.com', 2, '01', 'Sekwan/DPRD', NULL),
(11, 'atas', 'c4ca4238a0b923820dcc509a6f75849b', 'atas@yahoo.com', 2, '01', 'Sekwan/DPRD', NULL);

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
(2, '0100', 'DKI JAKARTA'),
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
-- Indexes for table `bid`
--
ALTER TABLE `bid`
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
-- Indexes for table `log_history`
--
ALTER TABLE `log_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opname`
--
ALTER TABLE `opname`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `perk`
--
ALTER TABLE `perk`
  ADD PRIMARY KEY (`kd_perk`);

--
-- Indexes for table `persediaan`
--
ALTER TABLE `persediaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satker`
--
ALTER TABLE `satker`
  ADD PRIMARY KEY (`Satker_ID`);

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
-- Indexes for table `thn_aktif`
--
ALTER TABLE `thn_aktif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_full`
--
ALTER TABLE `transaksi_full`
  ADD PRIMARY KEY (`id_history`);

--
-- Indexes for table `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_masuk`
--
ALTER TABLE `transaksi_masuk`
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
-- AUTO_INCREMENT for table `bid`
--
ALTER TABLE `bid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kanwil`
--
ALTER TABLE `kanwil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `kel`
--
ALTER TABLE `kel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `log_history`
--
ALTER TABLE `log_history`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `opname`
--
ALTER TABLE `opname`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `persediaan`
--
ALTER TABLE `persediaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `satker`
--
ALTER TABLE `satker`
  MODIFY `Satker_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=476;
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
-- AUTO_INCREMENT for table `thn_aktif`
--
ALTER TABLE `thn_aktif`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `transaksi_full`
--
ALTER TABLE `transaksi_full`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=680;
--
-- AUTO_INCREMENT for table `transaksi_keluar`
--
ALTER TABLE `transaksi_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `transaksi_masuk`
--
ALTER TABLE `transaksi_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `ttd`
--
ALTER TABLE `ttd`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(32) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=706;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
