-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2015 at 05:27 
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `persediaan_v1`
--
CREATE DATABASE IF NOT EXISTS `persediaan_v1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `persediaan_v1`;

-- --------------------------------------------------------

--
-- Table structure for table `bid`
--

CREATE TABLE IF NOT EXISTS `bid` (
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `nm_bid` varchar(30) NOT NULL,
  `kd_bidbrg` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bid`
--

INSERT INTO `bid` (`kd_gol`, `kd_bid`, `nm_bid`, `kd_bidbrg`) VALUES
('1', '01', 'BARANG PAKAI HABIS            ', '101'),
('1', '02', 'BARANG TAK HABIS PAKAI        ', '102'),
('1', '03', 'BARANG BEKAS DIPAKAI          ', '103');

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
  `kd_perk` varchar(10) NOT NULL,
  `kd_lokasi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brg`
--

INSERT INTO `brg` (`kd_kbrg`, `kd_jbrg`, `kd_brg`, `nm_brg`, `satuan`, `kd_perk`, `kd_lokasi`) VALUES
('1010304007', '000002', '1010304007000002', 'TRANSCEND', 'PCS', '115111', '001010100000000000KD'),
('1010304008', '000001', '1010304008000001', 'ASUS LIGHTSCRIBE', 'pcs', '115111', '001010100000000000KD'),
('1010301005', '000001', '1010301005000001', 'TISERA', 'PCS', '115111', '001010100000000000KD'),
('1020103006', '000001', '1020103006000001', 'BAKTOR TIZERA', 'UNIT', '115199', '113010155000000000KP'),
('1010101006', '000001', '1010101006000001', 'NIPPON PAINT', 'UNIT', '115131', '113010155000000000KP'),
('1010304999', '000001', '1010304999000001', 'MONITOR', 'UNIT', '115111', '113010155000000000KP'),
('1010304999', '000002', '1010304999000002', 'CENTRAL PROCESSING UNIT', 'UNIT', '115111', '113010155000000000KP');

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
  `kd_uapb` varchar(10) NOT NULL,
  `kd_uappbe1` varchar(10) NOT NULL,
  `kd_kanwil` varchar(5) NOT NULL,
  `nm_kanwil` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kanwil`
--

INSERT INTO `kanwil` (`kd_uapb`, `kd_uappbe1`, `kd_kanwil`, `nm_kanwil`) VALUES
('015', '09', '001', 'KANWIL  I DJKN BANDA ACEH     '),
('015', '09', '002', 'KANWIL II DJKN MEDAN          '),
('015', '09', '003', 'KANWIL III DJKN PEKANBARU     '),
('015', '09', '004', 'KANWIL IV DJKN PALEMBANG      '),
('015', '09', '005', 'KANWIL V DJKN BANDAR LAMPUNG  '),
('015', '09', '006', 'KANWIL VI DJKN SERANG         '),
('015', '09', '007', 'KANWIL VII DJKN JAKARTA       '),
('015', '09', '008', 'KANWIL VIII DJKN BANDUNG      '),
('015', '09', '009', 'KANWIL IX DJKN SEMARANG       '),
('015', '09', '010', 'KANWIL X DJKN SURABAYA        '),
('015', '09', '011', 'KANWIL XI DJKN PONTIANAK      '),
('015', '09', '012', 'KANWIL XII DJKN BANJARMASIN   '),
('015', '09', '013', 'KANWIL XIII DJKN SAMARINDA    '),
('015', '09', '014', 'KANWIL XIV DJKN DENPASAR      '),
('015', '09', '015', 'KANWIL XV DJKN MAKASAR        '),
('015', '09', '016', 'KANWIL XVI DJKN MANADO        '),
('015', '09', '017', 'KANWIL XVII DJKN JAYAPURA     '),
('015', '04', '010', 'Kantor Wilayah DJP Nangroe Ace'),
('015', '04', '020', 'Kantor Wilayah DJP Sumatera Ut'),
('015', '04', '030', 'Kantor Wilayah DJP Sumatera Ut'),
('015', '04', '040', 'Kantor Wilayah DJP Riau dan Ke'),
('015', '04', '050', 'Kantor Wilayah DJP Sumatera Ba'),
('015', '04', '060', 'Kantor Wilayah DJP Sumatera Se'),
('015', '04', '070', 'Kantor Wilayah DJP Bengkulu da'),
('015', '04', '080', 'Kantor Wilayah DJP Jakarta Pus'),
('015', '04', '090', 'Kantor Wilayah DJP Jakarta Bar'),
('015', '04', '100', 'Kantor Wilayah DJP Jakarta Sel'),
('015', '04', '110', 'Kantor Wilayah DJP Jakarta Tim'),
('015', '04', '120', 'Kantor Wilayah DJP Jakarta Uta'),
('015', '04', '130', 'Kantor Wilayah DJP Jakarta Khu'),
('015', '04', '140', 'Kantor Wilayah DJP Banten     '),
('015', '04', '150', 'Kantor Wilayah DJP Jawa Barat '),
('015', '04', '160', 'Kantor Wilayah DJP Jawa Barat '),
('015', '04', '170', 'Kantor Wilayah DJP Jawa Tengah'),
('015', '04', '180', 'Kantor Wilayah DJP Jawa Tengah'),
('015', '04', '190', 'Kantor Wilayah DJP Daerah Isti'),
('015', '04', '200', 'Kantor Wilayah DJP Jawa Timur '),
('015', '04', '210', 'Kantor Wilayah DJP Jawa Timur '),
('015', '04', '220', 'Kantor Wilayah DJP Jawa Timur '),
('015', '04', '230', 'Kantor Wilayah DJP Kalimantan '),
('015', '04', '240', 'Kantor Wilayah DJP Kalimantan '),
('015', '04', '250', 'Kantor Wilayah DJP Kalimantan '),
('015', '04', '260', 'Kantor Wilayah DJP Sulawesi Se'),
('015', '04', '270', 'Kantor Wilayah DJP Sulawesi Ut'),
('015', '04', '280', 'Kantor Wilayah DJP Bali       '),
('015', '04', '290', 'Kantor Wilayah DJP Nusa Tengga'),
('015', '04', '300', 'Kantor Wilayah DJP Papua dan M'),
('015', '04', '310', 'Kantor Wilayah DJp Wajib Pajak'),
('015', '05', '001', 'Kanwil DJBC Nangroe Aceh Darus'),
('015', '05', '002', 'Kanwil DJBC  Sumatera Utara   '),
('015', '05', '003', 'Kanwil DJBC Riau dan Sumatera '),
('015', '05', '004', 'Kanwil DJBC Kepulauan Riau    '),
('015', '05', '005', 'Kanwil DJBC Sumatera Bagian Se'),
('015', '05', '006', 'Kanwil DJBC Banten            '),
('015', '05', '007', 'Kanwil DJBC Jakarta           '),
('015', '05', '008', 'Kanwil DJBC Jawa Barat        '),
('015', '05', '009', 'Kanwil DJBC Jawa Tengah dan DI'),
('015', '05', '010', 'Kanwil DJBC Jawa Timur I      '),
('015', '05', '011', 'Kanwil DJBC  Jawa Timur II    '),
('015', '05', '012', 'Kanwil DJBC Bali, NTB, dan NTT'),
('015', '05', '013', 'Kanwil DJBC Kalimantan Bagian '),
('015', '05', '014', 'Kanwil DJBC Kalimantan Bagian '),
('015', '05', '015', 'Kanwil DJBC Sulawesi          '),
('015', '05', '016', 'Kanwil DJBC Maluku, Papua dan '),
('015', '08', '001', 'Kanwil  I  Banda Aceh         '),
('015', '08', '002', 'Kanwil  II  Medan             '),
('015', '08', '003', 'Kanwil  III  Padang           '),
('015', '08', '004', 'Kanwil  IV  Pekanbaru         '),
('015', '08', '005', 'Kanwil  V  Jambi              '),
('015', '08', '006', 'Kanwil  VI  Palembang         '),
('015', '08', '007', 'Kanwil  VII  Bandar Lampung   '),
('015', '08', '008', 'Kanwil  VIII  Bengkulu        '),
('015', '08', '009', 'Kanwil  IX  Pangkal Pinang    '),
('015', '08', '010', 'Kanwil  X  Serang             '),
('015', '08', '011', 'Kanwil  XI  Jakarta           '),
('015', '08', '012', 'Kanwil  XII  Bandung          '),
('015', '08', '013', 'Kanwil  XIII  Semarang        '),
('015', '08', '014', 'Kanwil  XIV  Yogyakarta       '),
('015', '08', '015', 'Kanwil  XV  Surabaya          '),
('015', '08', '016', 'Kanwil  XVI  Pontianak        '),
('015', '08', '017', 'Kanwil  XVII  Palangkaraya    '),
('015', '08', '018', 'Kanwil  XVIII  Banjarmasin    '),
('015', '08', '019', 'Kanwil  XIX  Samarinda        '),
('015', '08', '020', 'Kanwil  XX  Denpasar          '),
('015', '08', '021', 'Kanwil  XXI  Mataram          '),
('015', '08', '022', 'Kanwil  XXII  Kupang          '),
('015', '08', '023', 'Kanwil  XXIII  Makassar       '),
('015', '08', '024', 'Kanwil  XXIV  Palu            '),
('015', '08', '025', 'Kanwil  XXV  Kendari          '),
('015', '08', '026', 'Kanwil  XXVI  Gorontalo       '),
('015', '08', '027', 'Kanwil  XXVII  Manado         '),
('015', '08', '029', 'Kanwil  XXIX  Ambon           '),
('015', '08', '030', 'Kanwil  XXX  Jayapura         ');

-- --------------------------------------------------------

--
-- Table structure for table `kel`
--

CREATE TABLE IF NOT EXISTS `kel` (
  `kd_gol` varchar(10) NOT NULL,
  `kd_bid` varchar(10) NOT NULL,
  `kd_kel` varchar(10) NOT NULL,
  `nm_kel` varchar(30) NOT NULL,
  `kd_kelbrg` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kel`
--

INSERT INTO `kel` (`kd_gol`, `kd_bid`, `kd_kel`, `nm_kel`, `kd_kelbrg`) VALUES
('1', '01', '01', 'BAHAN                         ', '10101'),
('1', '01', '02', 'SUKU CADANG                   ', '10102'),
('1', '01', '03', 'ALAT/BAHAN UNTUK KEGIATAN KANT', '10103'),
('1', '01', '04', 'OBAT-OBATAN                   ', '10104'),
('1', '01', '05', 'PERSEDIAAN UNTUK DIJUAL/DISERA', '10105'),
('1', '01', '06', 'PERSEDIAAN UNTUK TUJUAN STRATE', '10106'),
('1', '01', '07', 'NATURA DAN PAKAN              ', '10107'),
('1', '01', '08', 'PERSEDIAAN PENELITIAN BIOLOGI ', '10108');

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
  `level` varchar(2) NOT NULL
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
  `kd_skelbrg` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skel`
--

INSERT INTO `skel` (`kd_gol`, `kd_bid`, `kd_kel`, `kd_skel`, `nm_skel`, `kd_skelbrg`) VALUES
('1', '01', '01', '01', 'BAHAN BANGUNAN DAN KONSTRUKSI ', '1010101'),
('1', '01', '01', '02', 'BAHAN KIMIA                   ', '1010102'),
('1', '01', '01', '03', 'BAHAN PELEDAK                 ', '1010103'),
('1', '01', '01', '04', 'BAHAN BAKAR DAN PELUMAS       ', '1010104'),
('1', '01', '01', '05', 'BAHAN BAKU                    ', '1010105'),
('1', '01', '01', '06', 'BAHAN KIMIA NUKLIR            ', '1010106'),
('1', '01', '01', '07', 'BARANG DALAM PROSES           ', '1010107'),
('1', '01', '02', '08', 'SUKU CADANG ALAT BENGKEL      ', '1010208'),
('1', '01', '01', '99', 'BAHAN LAINNYA                 ', '1010199');

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
  `satuan` varchar(7) NOT NULL,
  `kd_brg` varchar(20) NOT NULL,
  `kd_perk` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sskel`
--

INSERT INTO `sskel` (`kd_gol`, `kd_bid`, `kd_kel`, `kd_skel`, `kd_sskel`, `nm_sskel`, `satuan`, `kd_brg`, `kd_perk`) VALUES
('1', '01', '01', '01', '001', 'Aspal                         ', '       ', '1010101001', '115131'),
('1', '01', '01', '01', '002', 'Semen                         ', '       ', '1010101002', '115131'),
('1', '01', '01', '01', '003', 'Kaca                          ', '       ', '1010101003', '115131'),
('1', '01', '01', '01', '004', 'Pasir                         ', '       ', '1010101004', '115131'),
('1', '01', '01', '01', '005', 'Batu                          ', '       ', '1010101005', '115131'),
('1', '01', '01', '01', '006', 'Cat                           ', '       ', '1010101006', '115131'),
('1', '01', '01', '01', '007', 'Seng                          ', '       ', '1010101007', '115131'),
('1', '01', '01', '01', '008', 'Baja                          ', '       ', '1010101008', '115131'),
('1', '01', '01', '01', '009', 'Electro Dalas                 ', '       ', '1010101009', '115131'),
('1', '01', '01', '01', '010', 'Patok Beton                   ', '       ', '1010101010', '115131'),
('1', '01', '01', '01', '011', 'Tiang Beton                   ', '       ', '1010101011', '115131'),
('1', '01', '01', '01', '012', 'Besi Beton                    ', '       ', '1010101012', '115131'),
('1', '01', '01', '01', '013', 'Tegel                         ', '       ', '1010101013', '115131'),
('1', '01', '01', '01', '014', 'Genteng                       ', '       ', '1010101014', '115131'),
('1', '01', '01', '01', '015', 'Bis Beton                     ', '       ', '1010101015', '115131'),
('1', '01', '01', '01', '016', 'Plat                          ', '       ', '1010101016', '115131'),
('1', '01', '01', '01', '017', 'Steel Sheet Pile              ', '       ', '1010101017', '115131'),
('1', '01', '01', '01', '018', 'Concrete Sheet Pile           ', '       ', '1010101018', '115131'),
('1', '01', '01', '01', '019', 'Kawat Bronjong                ', '       ', '1010101019', '115131'),
('1', '01', '01', '01', '020', 'Karung                        ', '       ', '1010101020', '115131'),
('1', '01', '01', '01', '021', 'Minyak Cat/Thinner            ', '       ', '1010101021', '115131'),
('1', '01', '02', '04', '022', 'Suku Cadang Alat Laboratorium ', '       ', '1010204022', '115114'),
('1', '01', '02', '04', '023', 'Suku Cadang Alat Laboratorium ', '       ', '1010204023', '115114'),
('1', '01', '02', '04', '024', 'Suku Cadang Alat Laboratorium ', '       ', '1010204024', '115114'),
('1', '01', '02', '04', '025', 'Suku Cadang Alat Laboratorium ', '       ', '1010204025', '115114'),
('1', '01', '02', '04', '026', 'Suku Cadang Alat Laboratorium ', '       ', '1010204026', '115114'),
('1', '01', '02', '04', '027', 'Suku Cadang Alat Laboratorium ', '       ', '1010204027', '115114'),
('1', '01', '02', '04', '028', 'Suku Cadang Alat Laboratorium ', '       ', '1010204028', '115114'),
('1', '01', '02', '04', '029', 'Suku Cadang Alat Laboratorium ', '       ', '1010204029', '115114'),
('1', '01', '02', '04', '030', 'Suku Cadang Alat Laboratorium ', '       ', '1010204030', '115114'),
('1', '01', '02', '04', '031', 'Suku Cadang Alat Laboratorium ', '       ', '1010204031', '115114'),
('1', '01', '02', '04', '032', 'Suku Cadang Alat Laboratorium ', '       ', '1010204032', '115114'),
('1', '01', '02', '04', '033', 'Suku Cadang Alat Laboratorium ', '       ', '1010204033', '115114'),
('1', '01', '02', '04', '034', 'Suku Cadang Alat Laboratorium ', '       ', '1010204034', '115114'),
('1', '01', '02', '04', '035', 'Suku Cadang Alat Laboratorium ', '       ', '1010204035', '115114'),
('1', '01', '02', '04', '036', 'Suku Cadang Alat Laboratorium ', '       ', '1010204036', '115114'),
('1', '01', '02', '04', '037', 'Suku Cadang Alat Laboratorium ', '       ', '1010204037', '115114'),
('1', '01', '02', '04', '038', 'Suku Cadang Alat Laboratorium ', '       ', '1010204038', '115114'),
('1', '01', '02', '04', '039', 'Suku Cadang Alat Laboratorium ', '       ', '1010204039', '115114'),
('1', '01', '02', '04', '040', 'Suku Cadang Alat Laboratorium ', '       ', '1010204040', '115114'),
('1', '01', '02', '04', '041', 'Suku Cadang Alat Laboratorium ', '       ', '1010204041', '115114'),
('1', '01', '02', '04', '042', 'Suku Cadang Alat Laboratorium ', '       ', '1010204042', '115114'),
('1', '01', '02', '04', '043', 'Suku Cadang Alat Laboratorium ', '       ', '1010204043', '115114'),
('1', '01', '02', '04', '044', 'Suku Cadang Alat Laboratorium ', '       ', '1010204044', '115114'),
('1', '01', '02', '04', '045', 'Suku Cadang Alat Laboratorium ', '       ', '1010204045', '115114'),
('1', '01', '02', '04', '046', 'Suku Cadang Alat Laboratorium ', '       ', '1010204046', '115114'),
('1', '01', '02', '04', '047', 'Suku Cadang Alat Laboratorium ', '       ', '1010204047', '115114'),
('1', '01', '02', '04', '048', 'Suku Cadang Alat Laboratorium ', '       ', '1010204048', '115114'),
('1', '01', '02', '04', '049', 'Suku Cadang Alat Laboratorium ', '       ', '1010204049', '115114'),
('1', '01', '02', '04', '050', 'Suku Cadang Alat Laboratorium ', '       ', '1010204050', '115114'),
('1', '01', '02', '04', '051', 'Suku Cadang Alat Laboratorium ', '       ', '1010204051', '115114'),
('1', '01', '02', '04', '052', 'Suku Cadang Alat Laboratorium ', '       ', '1010204052', '115114'),
('1', '01', '02', '04', '053', 'Suku Cadang Alat Laboratorium ', '       ', '1010204053', '115114'),
('1', '01', '02', '04', '054', 'Suku Cadang Alat Laboratorium ', '       ', '1010204054', '115114'),
('1', '01', '02', '04', '055', 'Suku Cadang Alat Laboratorium ', '       ', '1010204055', '115114'),
('1', '01', '02', '04', '056', 'Suku Cadang Alat Laboratorium ', '       ', '1010204056', '115114'),
('1', '01', '02', '04', '057', 'Suku Cadang Alat Laboratorium ', '       ', '1010204057', '115114'),
('1', '01', '02', '04', '058', 'Suku Cadang Alat Laboratorium ', '       ', '1010204058', '115114'),
('1', '01', '02', '04', '059', 'Suku Cadang Alat Laboratorium ', '       ', '1010204059', '115114'),
('1', '01', '02', '04', '060', 'Suku Cadang Alat Laboratorium ', '       ', '1010204060', '115114'),
('1', '01', '01', '01', '999', 'Bahan Bangunan Dan Konstruksi ', '       ', '1010101999', '115131');

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
  `kd_lokasi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uapb`
--

CREATE TABLE IF NOT EXISTS `uapb` (
  `kd_uapb` varchar(4) NOT NULL,
  `nm_uapb` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uapb`
--

INSERT INTO `uapb` (`kd_uapb`, `nm_uapb`) VALUES
('001', 'MAJELIS PERMUSYAWARATAN RAKYAT'),
('002', 'DEWAN PERWAKILAN RAKYAT       '),
('004', 'BADAN PEMERIKSA KEUANGAN      '),
('005', 'MAHKAMAH AGUNG                '),
('006', 'KEJAKSAAN REPUBLIK INDONESIA  '),
('007', 'KEMENTERIAN SEKRETARIAT NEGARA'),
('008', 'WAKIL PRESIDEN                '),
('010', 'KEMENTERIAN DALAM  NEGERI     '),
('011', 'KEMENTERIAN LUAR NEGERI       '),
('012', 'KEMENTERIAN PERTAHANAN        '),
('013', 'KEMENTERIAN HUKUM DAN HAK ASAS'),
('015', 'KEMENTERIAN KEUANGAN          '),
('018', 'KEMENTERIAN PERTANIAN         '),
('019', 'KEMENTERIAN PERINDUSTRIAN     '),
('020', 'KEMENTERIAN ENERGI DAN SUMBER '),
('022', 'KEMENTERIAN PERHUBUNGAN       '),
('023', 'KEMENTERIAN PENDIDIKAN NASIONA'),
('024', 'KEMENTERIAN KESEHATAN         '),
('025', 'KEMENTERIAN AGAMA             '),
('026', 'KEMENTERIAN TENAGA KERJA DAN T'),
('027', 'KEMENTERIAN SOSIAL            '),
('029', 'KEMENTERIAN KEHUTANAN         '),
('032', 'KEMENTERIAN KELAUTAN DAN PERIK'),
('033', 'KEMENTERIAN PEKERJAAN UMUM    '),
('034', 'KEMENTERIAN KOORDINATOR BIDANG'),
('035', 'KEMENTERIAN KOORDINATOR BIDANG'),
('036', 'KEMENTERIAN KOORDINATOR BIDANG'),
('040', 'KEMENTERIAN KEBUDAYAAN DAN PAR'),
('041', 'KEMENTERIAN BADAN USAHA MILIK '),
('042', 'KEMENTERIAN RISET DAN TEKNOLOG'),
('043', 'KEMENTERIAN LINGKUNGAN HIDUP  '),
('044', 'KEMENTERIAN KOPERASI DAN PENGU'),
('047', 'KEMENTERIAN PEMBERDAYAAN PEREM'),
('048', 'KEMENTERIAN PENDAYAGUNAAN APAR'),
('050', 'BADAN INTELIJEN NEGARA        '),
('051', 'LEMBAGA SANDI NEGARA          '),
('052', 'DEWAN KETAHANAN NASIONAL      '),
('053', 'BADAN URUSAN LOGISTIK         '),
('054', 'BADAN PUSAT STATISTIK         '),
('055', 'KEMENTERIAN PERENCANAAN PEMBAN'),
('056', 'BADAN PERTANAHAN NASIONAL     '),
('057', 'PERPUSTAKAAN NASIONAL REPUBLIK'),
('059', 'KEMENTERIAN KOMUNIKASI DAN INF'),
('060', 'KEPOLISIAN NEGARA REPUBLIK IND'),
('061', 'CICILAN BUNGA HUTANG          '),
('062', 'SUBSIDI DAN TRANSFER          '),
('063', 'BADAN PENGAWAS OBAT DAN MAKANA'),
('064', 'LEMBAGA KETAHANAN NASIONAL    '),
('065', 'BADAN KOORDINASI PENANAMAN MOD'),
('066', 'BADAN NARKOTIKA NASIONAL      '),
('067', 'KEMENTERIAN PEMBANGUNAN DAERAH'),
('068', 'BADAN KOORDINASI KELUARGA BERE'),
('069', 'BELANJA LAIN-LAIN             '),
('070', 'DANA PERIMBANGAN              '),
('071', 'DANA OTONOMI KHUSUS PENYEIMBAN'),
('074', 'KOMISI NASIONAL HAK ASASI MANU'),
('075', 'BADAN METEOROLOGI, KLIMATOLOGI'),
('076', 'KOMISI PEMILIHAN UMUM         '),
('077', 'MAHKAMAH KONSTITUSI RI        '),
('078', 'PUSAT PELAPORAN DAN ANALISIS T'),
('079', 'LEMBAGA ILMU PENGETAHUAN INDON'),
('080', 'BADAN TENAGA NUKLIR NASIONAL  '),
('081', 'BADAN PENGKAJIAN DAN PENERAPAN'),
('082', 'LEMBAGA PENERBANGAN DAN ANTARI'),
('083', 'BADAN KOORDINASI SURVEI DAN PE'),
('084', 'BADAN STANDARISASI NASIONAL   '),
('085', 'BADAN PENGAWAS TENAGA NUKLIR  '),
('086', 'LEMBAGA ADMINISTRASI NEGARA   '),
('087', 'ARSIP NASIONAL REPUBLIK INDONE'),
('088', 'BADAN KEPEGAWAIAN NEGARA      '),
('089', 'BADAN PENGAWASAN  KEUANGAN DAN'),
('090', 'KEMENTERIAN PERDAGANGAN       '),
('091', 'KEMENTERIAN PERUMAHAN RAKYAT  '),
('092', 'KEMENTERIAN PEMUDA DAN OLAH RA'),
('093', 'KOMISI PEMBERANTASAN KORUPSI  '),
('094', 'BADAN  REHABILITASI DAN REKONS'),
('095', 'DEWAN PERWAKILAN DAERAH (DPD) '),
('096', 'PEMBAYARAN CICILAN POKOK HUTAN'),
('097', 'PEMBAYARAN CICILAN POKOK HUTAN'),
('098', 'PENERUSAN PINJAMAN            '),
('099', 'PENYERTAAN MODAL NEGARA       '),
('100', 'KOMISI YUDISIAL RI            '),
('101', 'PENERUSAN PINJAMAN SEBAGAI HIB'),
('102', 'PENERUSAN  HIBAH              '),
('103', 'BADAN NASIONAL PENANGGULANGAN '),
('104', 'BADAN NASIONAL PENEMPATAN DAN '),
('105', 'BADAN PENANGGULANGAN LUMPUR SI'),
('106', 'LEMBAGA KEBIJAKAN PENGADAAN BA'),
('107', 'BADAN SAR NASIONAL            '),
('108', 'KOMISI PENGAWAS PERSAINGAN USA'),
('109', 'BADAN PENGEMBANGAN WILAYAH SUR'),
('110', 'OMBUDSMAN REPUBLIK INDONESIA  '),
('111', 'BADAN NASIONAL PENGELOLA PERBA'),
('112', 'ANGKUTAN KOTA'),
('113', 'KARANG TARUNA RW 20'),
('123', 'GUNADARMA'),
('999', 'BENDAHARA UMUM NEGARA         ');

-- --------------------------------------------------------

--
-- Table structure for table `uappbe1`
--

CREATE TABLE IF NOT EXISTS `uappbe1` (
  `kd_uapb` varchar(11) NOT NULL,
  `kd_uappbe1` varchar(10) NOT NULL,
  `nm_uappbe1` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uappbe1`
--

INSERT INTO `uappbe1` (`kd_uapb`, `kd_uappbe1`, `nm_uappbe1`) VALUES
('001', '01', 'SEKRETARIAT JENDERAL     '),
('001', '02', 'M A J E L I S            '),
('002', '01', 'SEKRETARIAT JENDERAL     '),
('002', '02', 'D E W A N                '),
('004', '01', 'SEKRETARIAT JENDERAL     '),
('004', '02', 'B. P. K.  PUSAT          '),
('005', '01', 'BADAN URUSAN ADMINISTRASI'),
('005', '02', 'KEPANITERAAN             '),
('005', '03', 'DIREKTORAT JENDERAL BADAN'),
('005', '04', 'DIREKTORAT JENDERAL BADAN'),
('005', '05', 'DIREKTORAT JENDERAL BADAN'),
('005', '06', 'BADAN PENELITIAN DAN PENG'),
('005', '07', 'BADAN PENGAWASAN MAHKAMAH'),
('006', '01', 'KEJAKSAAN REPUBLIK INDONE'),
('007', '01', 'SEKRETARIAT NEGARA       '),
('007', '02', 'SEKRETARIAT KABINET      '),
('007', '03', 'RUMAH TANGGA KEPRESIDENAN'),
('007', '04', 'SEKRETARIAT WAKIL PRESIDE'),
('007', '05', 'SEKRETARIAT MILITER PRESI'),
('007', '06', 'PASUKAN PENGAMANAN PRESID'),
('007', '07', 'DEWAN PERTIMBANGAN PRESID'),
('007', '08', 'UNIT KERJA PRESIDEN BD.PE'),
('007', '09', 'LEMBAGA PERLINDUNGAN SAKS'),
('010', '01', 'SEKRETARIAT JENDERAL     '),
('010', '02', 'INSPEKTORAT JENDERAL     '),
('010', '03', 'DITJEN KESATUAN BANGSA DA'),
('010', '04', 'DITJEN PEMERINTAHAN UMUM '),
('010', '05', 'DITJEN PEMBERDAYAAN MASYA'),
('010', '06', 'DITJEN BINA PEMBANGUNAN D'),
('010', '07', 'DITJEN OTONOMI DAERAH    '),
('010', '08', 'DITJEN KEPENDUDUKAN DAN P'),
('010', '09', 'DITJEN KEUANGAN DAERAH   '),
('010', '11', 'BADAN PENELITIAN DAN PENG'),
('010', '12', 'BADAN PENDIDIKAN DAN PELA'),
('011', '01', 'SEKRETARIAT JENDERAL     '),
('011', '02', 'DIREKTORAT JENDERAL ASIA '),
('011', '03', 'DIREKTORAT JENDERAL AMERI'),
('011', '04', 'DIREKTORAT JENDERAL KERJA'),
('011', '05', 'DIREKTORAT JENDERAL MULTI'),
('011', '06', 'DIREKTORAT JENDERAL INFOR'),
('011', '07', 'DIREKTORAT JENDERAL HUKUM'),
('011', '08', 'DIREKTORAT JENDERAL PROTO'),
('011', '09', 'INSPEKTORAT JENDERAL     '),
('011', '11', 'BADAN PENGKAJIAN DAN PENG'),
('012', '01', 'KEMENTERIAN PERTAHANAN   '),
('012', '21', 'MARKAS BESAR TNI         '),
('012', '22', 'MARKAS BESAR TNI AD      '),
('012', '23', 'MARKAS BESAR TNI AL      '),
('012', '24', 'MARKAS BESAR TNI AU      '),
('013', '01', 'SEKRETARIAT JENDERAL     '),
('013', '02', 'INSPEKTORAT JENDERAL     '),
('013', '03', 'DITJEN ADMINISTRASI HUKUM'),
('013', '05', 'DITJEN PEMASYARAKATAN    '),
('013', '06', 'DITJEN IMIGRASI          '),
('013', '07', 'DITJEN HAK ATAS KEKAYAAN '),
('013', '08', 'DITJEN PERATURAN PERUNDAN'),
('013', '09', 'DITJEN HAK ASASI MANUSIA '),
('013', '10', 'BADAN PEMBINAAN HUKUM NAS'),
('013', '11', 'BADAN PENELITIAN DAN PENG'),
('013', '12', 'BADAN PENGEMBANGAN SUMBER'),
('015', '01', 'SEKRETARIAT JENDERAL     '),
('015', '02', 'INSPEKTORAT JENDERAL     '),
('015', '03', 'DITJEN ANGGARAN          '),
('015', '04', 'DITJEN PAJAK             '),
('015', '05', 'DITJEN BEA DAN CUKAI     '),
('015', '06', 'DITJEN PERIMBANGAN KEUANG'),
('015', '07', 'DITJEN PENGELOLAAN UTANG '),
('015', '08', 'DITJEN PERBENDAHARAAN    '),
('015', '09', 'DITJEN KEKAYAAN NEGARA   '),
('015', '10', 'BADAN PENGAWAS PASAR MODA'),
('015', '11', 'BADAN PENDIDIKAN DAN PELA'),
('015', '12', 'BADAN KEBIJAKAN FISKAL   '),
('018', '01', 'SEKRETARIAT JENDERAL     '),
('018', '02', 'INSPEKTORAT JENDERAL     '),
('018', '03', 'DITJEN TANAMAN PANGAN    '),
('018', '04', 'DITJEN HORTIKULTURA      '),
('018', '05', 'DITJEN PERKEBUNAN        '),
('018', '06', 'DITJEN PETERNAKAN DAN KES'),
('018', '07', 'DITJEN PENGOLAHAN DAN PEM'),
('018', '08', 'DITJEN PRASARANA DAN SARA'),
('018', '09', 'BADAN PENELITIAN DAN PENG'),
('018', '10', 'BADAN PENYULUHAN DAN PENG'),
('018', '11', 'BADAN KETAHANAN PANGAN   '),
('018', '12', 'BADAN KARANTINA PERTANIAN'),
('019', '01', 'SEKRETARIAT JENDERAL     '),
('019', '02', 'DIREKTORAT JENDERAL INDUS'),
('019', '03', 'DIREKTORAT JENDERAL BASIS'),
('019', '04', 'DIREKTORAT JENDERAL INDUS'),
('019', '05', 'DIREKTORAT JENDERAL INDUS'),
('019', '06', 'INSPEKTORAT JENDERAL     '),
('019', '07', 'BADAN PENGKAJIAN KEBIJAKA'),
('019', '08', 'DIREKTORAT JENDERAL PENGE'),
('019', '09', 'DIREKTORAT JENDERAL KERJA'),
('020', '01', 'SEKRETARIAT JENDERAL     '),
('020', '02', 'INSPEKTORAT JENDERAL     '),
('020', '04', 'DITJEN MINYAK DAN GAS BUM'),
('020', '05', 'DITJEN KETENAGALISTRIKAN '),
('020', '06', 'DITJEN MINERAL DAN BUDIDA'),
('020', '07', 'DEWAN ENERGI NASIONAL    '),
('020', '11', 'BADAN PENELITIAN DAN PENG'),
('020', '12', 'BADAN DIKLAT ENERGI DAN S'),
('020', '13', 'BADAN GEOLOGI            '),
('020', '14', 'BPH MIGAS                '),
('020', '15', 'DITJEN ENERGI BARU TERBAR'),
('022', '01', 'SEKRETARIAT JENDERAL     '),
('022', '02', 'INSPEKTORAT JENDERAL     '),
('022', '03', 'DITJEN PERHUBUNGAN DARAT '),
('022', '04', 'DITJEN PERHUBUNGAN LAUT  '),
('022', '05', 'DITJEN PERHUBUNGAN UDARA '),
('022', '08', 'DIREKTORAT JENDERAL PERKE'),
('022', '11', 'BADAN PENELITIAN DAN PENG'),
('022', '12', 'BADAN PENGEMBANGAN SUMBER'),
('023', '01', 'SEKRETARIAT JENDERAL     '),
('023', '02', 'INSPEKTORAT JENDERAL     '),
('023', '03', 'DITJEN MANAJEMEN PENDIDIK'),
('023', '04', 'DITJEN PENDIDIKAN TINGGI '),
('023', '05', 'DITJEN PENDIDIKAN NONFORM'),
('023', '08', 'DITJEN PENINGKATAN MUTU P'),
('023', '11', 'BADAN PENELITIAN DAN PENG'),
('024', '01', 'SEKRETARIAT JENDERAL     '),
('024', '02', 'INSPEKTORAT JENDERAL     '),
('024', '03', 'DITJEN BINA GIZI DAN KESE'),
('024', '04', 'DITJEN BINA UPAYA KESEHAT'),
('024', '05', 'DITJEN PENGENDALIAAN PENY'),
('024', '07', 'DITJEN BINA KEFARMASIAN D'),
('024', '11', 'BADAN PENELITIAN DAN PENG'),
('024', '12', 'BADAN PENGEMBANGAN DAN PE'),
('025', '01', 'SEKRETARIAT JENDERAL     '),
('025', '02', 'INSPEKTORAT JENDERAL     '),
('025', '03', 'DITJEN BIMBINGAN MASYARAK'),
('025', '04', 'DITJEN PENDIDIKAN ISLAM  '),
('025', '05', 'DITJEN BIMBINGAN MASYARAK'),
('025', '06', 'DITJEN BIMBINGAN MASYARAK'),
('025', '07', 'DITJEN BIMBINGAN MASYARAK'),
('025', '08', 'DITJEN BIMBINGAN MASYARAK'),
('025', '09', 'DITJEN PENYELENGGARAAN HA'),
('025', '11', 'BADAN PENELITIAN PENGEMBA'),
('026', '01', 'SEKRETARIAT JENDERAL     '),
('026', '02', 'INSPEKTORAT JENDERAL     '),
('026', '04', 'DITJEN PEMBINAAN PENEMPAT'),
('026', '05', 'DITJEN PEMBINAAN HUBUNGAN'),
('026', '06', 'DITJEN PEMBINAAN PEMBANGU'),
('026', '07', 'DITJEN PEMBINAAN PENGEMBA'),
('026', '08', 'DITJEN PEMBINAAN PENGAWAS'),
('026', '11', 'BADAN PENELITIAN, PENGEMB'),
('026', '13', 'DITJEN PEMBINAAN PELATIHA'),
('027', '01', 'SEKRETARIAT JENDERAL     '),
('027', '02', 'INSPEKTORAT JENDERAL     '),
('027', '03', 'DITJEN PEMBERDAYAAN SOSIA'),
('027', '04', 'DITJEN REHABILITASI SOSIA'),
('027', '05', 'DITJEN PERLINDUNGAN DAN J'),
('027', '11', 'BADAN PENDIDIKAN DAN PENE'),
('029', '01', 'SEKRETARIAT JENDERAL     '),
('029', '02', 'INSPEKTORAT JENDERAL     '),
('029', '03', 'DITJEN BINA USAHA KEHUTAN'),
('029', '04', 'DITJEN BINA PENGELOLAAN D'),
('029', '05', 'DITJEN PERLINDUNGAN HUTAN'),
('029', '06', 'DITJEN PLANOLOGI KEHUTANA'),
('029', '07', 'BADAN PENELITIAN DAN PENG'),
('029', '08', 'BADAN PENYULUHAN DAN PENG'),
('032', '01', 'SEKRETARIAT JENDERAL     '),
('032', '02', 'INSPEKTORAT JENDERAL     '),
('032', '03', 'DITJEN PERIKANAN TANGKAP '),
('032', '04', 'DITJEN PERIKANAN BUDIDAYA'),
('032', '05', 'DITJEN PENGAWASAN SUMBERD'),
('032', '06', 'DITJEN PENGOLAHAN DAN PEM'),
('032', '07', 'DITJEN KELAUTAN, PESISIR '),
('032', '11', 'BADAN PENELITIAN DAN PENG'),
('032', '12', 'BADAN PENGEMBANGAN SDM KE'),
('032', '13', 'BADAN KARANTINA IKAN, PEN'),
('033', '01', 'SEKRETARIAT JENDERAL     '),
('033', '02', 'INSPEKTORAT JENDERAL     '),
('033', '03', 'DITJEN PENATAAN RUANG    '),
('033', '04', 'DITJEN BINA MARGA        '),
('033', '05', 'DITJEN CIPTA KARYA       '),
('033', '06', 'DITJEN SUMBER DAYA AIR   '),
('033', '11', 'BADAN PENELITIAN DAN PENG'),
('033', '13', 'BADAN PEMBINAAN KONSTRUKS'),
('034', '01', 'KEMENTERIAN KOORDINATOR B'),
('035', '01', 'KEMENTERIAN KOORDINATOR B'),
('036', '01', 'KEMENTERIAN KOORDINATOR B'),
('040', '01', 'SEKRETARIAT JENDERAL     '),
('040', '02', 'INSPEKTORAT JENDERAL     '),
('040', '03', 'DIREKTORAT JENDERAL NILAI'),
('040', '04', 'DIREKTORAT JENDERAL SEJAR'),
('040', '05', 'DIREKTORAT JENDERAL PENGE'),
('040', '06', 'DIREKTORAT JENDERAL PEMAS'),
('040', '10', 'BADAN PENGEMBANGAN SUMBER'),
('041', '01', 'KEMENTERIAN BADAN USAHA M'),
('042', '01', 'KEMENTERIAN RISET DAN TEK'),
('043', '01', 'KEMENTERIAN LINGKUNGAN HI'),
('044', '01', 'KEMENTERIAN KOPERASI DAN '),
('047', '01', 'KEMENTERIAN PEMBERDAYAAN '),
('048', '01', 'KEMENTERIAN PENDAYAGUNAAN'),
('050', '01', 'BADAN INTELIJEN NEGARA   '),
('051', '01', 'LEMBAGA SANDI NEGARA     '),
('052', '01', 'SETJEN DEWAN KETAHANAN NA'),
('054', '01', 'BADAN PUSAT STATISTIK    '),
('055', '01', 'KEMENTERIAN PERENCANAAN P'),
('056', '01', 'BADAN PERTANAHAN NASIONAL'),
('057', '01', 'PERPUSTAKAAN NASIONAL    '),
('059', '01', 'SEKRETARIAT JENDERAL     '),
('059', '02', 'INSPEKTORAT JENDERAL     '),
('059', '03', 'DITJEN SUMBER DAYA DAN PE'),
('059', '04', 'DITJEN APLIKASI INFORMATI'),
('059', '05', 'DITJEN PENYELENGGARAAN PO'),
('059', '06', 'BADAN PENELITIAN DAN PENG'),
('059', '07', 'DITJEN INFORMASI DAN KOMU'),
('060', '01', 'KEPOLISIAN NEGARA REPUBLI'),
('061', '03', 'CICILAN DAN BUNGA HUTANG '),
('062', '03', 'SUBSIDI DAN TRANSFER     '),
('063', '01', 'BADAN PENGAWAS OBAT DAN M'),
('064', '01', 'LEMBAGA KETAHANAN NASIONA'),
('065', '01', 'BADAN KOORDINASI PENANAMA'),
('066', '01', 'BADAN NARKOTIKA NASIONAL '),
('067', '01', 'KEMENTERIAN PEMBANGUNAN D'),
('068', '01', 'BADAN KOORDINASI KELUARGA'),
('069', '03', 'BELANJA LAIN-LAIN        '),
('069', '10', 'DEPARTEMEN DALAM NEGERI  '),
('070', '03', 'DANA PERIMBANGAN         '),
('071', '03', 'DANA OTONOMI KHUSUS PENYE'),
('074', '01', 'KOMNAS HAM               '),
('075', '01', 'BADAN METEOROLOGI, KLIMAT'),
('076', '01', 'KOMISI PEMILIHAN UMUM    '),
('077', '01', 'MAHKAMAH KONSTITUSI RI   '),
('078', '01', 'PUSAT PELAPORAN DAN ANALI'),
('079', '01', 'LEMBAGA ILMU PENGETAHUAN '),
('080', '01', 'BADAN TENAGA NUKLIR NASIO'),
('081', '01', 'BADAN PENGKAJIAN DAN PENE'),
('082', '01', 'L A P A N                '),
('083', '01', 'BADAN KOORDINASI SURVEI D'),
('084', '01', 'BADAN STANDARISASI NASION'),
('085', '01', 'BADAN PENGAWAS TENAGA NUK'),
('086', '01', 'LEMBAGA ADMINISTRASI NEGA'),
('087', '01', 'ARSIP NASIONAL           '),
('088', '01', 'BADAN KEPEGAWAIAN NEGARA '),
('089', '01', 'BADAN PENGAWASAN KEUANGAN'),
('090', '01', 'SEKRETARIAT JENDERAL     '),
('090', '02', 'DIREKTORAT JENDERAL PERDA'),
('090', '03', 'DIREKTORAT JENDERAL PERDA'),
('090', '04', 'DIREKTORAT JENDERAL KERJA'),
('090', '05', 'INSPEKTORAT JENDERAL     '),
('090', '06', 'DIREKTORAT JENDERAL PENGE'),
('090', '07', 'BADAN PENGAWAS PERDAGANGA'),
('090', '08', 'BADAN PENGKAJIAN  DAN PEN'),
('090', '09', 'DIREKTORAT JENDERAL STAND'),
('091', '01', 'KEMENTERIAN PERUMAHAN RAK'),
('092', '01', 'KEMENTERIAN PEMUDA DAN OL'),
('093', '01', 'KOMISI PEMBERANTASAN KORU'),
('095', '01', 'SEKRETARIAT JENDERAL DPD '),
('095', '02', 'DEWAN PERWAKILAN DAERAH  '),
('096', '03', 'PEMBAYARAN CICILAN POKOK '),
('097', '03', 'PEMBAYARAN CICILAN POKOK '),
('098', '03', 'PENERUSAN PINJAMAN       '),
('099', '03', 'PENYERTAAN MODAL NEGARA  '),
('100', '01', 'KOMISI YUDISIAL RI       '),
('101', '03', 'PENERUSAN PINJAMAN SEBAGA'),
('102', '03', 'PENERUSAN  HIBAH         '),
('103', '01', 'BADAN NASIONAL PENANGGULA'),
('104', '01', 'SEKRETARIAT UTAMA BNP2TKI'),
('105', '01', 'BADAN PENANGGULANGAN LUMP'),
('106', '01', 'LEMBAGA KEBIJAKAN PENGADA'),
('107', '01', 'BADAN SAR NASIONAL       '),
('108', '01', 'KOMISI PENGAWAS PERSAINGA'),
('109', '01', 'BADAN PENGEMBANGAN WILAYA'),
('110', '01', 'OMBUDSMAN REPUBLIK INDONE'),
('111', '01', 'BADAN NASIONAL PENGELOLA '),
('999', '01', 'PENGELOLAAN UTANG        '),
('999', '02', 'PENGELOLAAN HIBAH        '),
('999', '03', 'PENGELOLAAN INVESTASI PEM'),
('999', '04', 'PENGELOLAAN PENERUSAN PIN'),
('999', '05', 'PENGELOLAAN TRANSFER KE D'),
('999', '06', 'PENGELOLAAN BELANJA SUBSI'),
('999', '07', 'PENGELOLAAN BELANJA SUBSI'),
('999', '08', 'PENGELOLAAN BELANJA LAIN-'),
('999', '99', 'PENGELOLAAN TRANSAKSI KHU'),
('005', '08', 'BADAN PENGAWASAN MAHKAMAH'),
('008', '01', 'SEKRETARIAT WAKIL PRESIDE'),
('008', '02', 'BAKORNAS PENANGGULANGAN B'),
('022', '13', 'BADAN SAR NASIONAL       '),
('026', '03', 'DITJEN PEMBINAAN DAN PENE'),
('033', '14', 'BADAN PENGELOLA JALAN TOL'),
('033', '15', 'BADAN PENDUKUNG PENGELOLA'),
('053', '01', 'BADAN URUSAN LOGISTIK    '),
('065', '02', 'DEPUTI BIDANG PENGEMBANGA'),
('065', '03', 'DEPUTI BIDANG PROMOSI PEN'),
('065', '04', 'DEPUTI BIDANG KERJA SAMA '),
('065', '05', 'DEPUTI BIDANG PELAYANAN P'),
('065', '06', 'DEPUTI BIDANG PENGENDALIA'),
('065', '07', 'INSPEKTORAT              '),
('065', '08', 'PUSAT PENELITIAN DAN PELA'),
('069', '08', 'BELANJA LAIN-LAIN        '),
('091', '02', 'DEPUTI PEMBIAYAAN        '),
('091', '03', 'DEPUTI PENGEMBANGAN KAWAS'),
('091', '04', 'DEPUTI PERUMAHAN FORMAL  '),
('091', '05', 'DEPUTI PERUMAHAN SWADAYA '),
('094', '01', 'BIDANG PENGAWASAN        '),
('094', '02', 'BIDANG KEUANGAN DAN PEREN'),
('094', '03', 'BIDANG AGAMA, SOSIAL DAN '),
('094', '04', 'BIDANG EKONOMI DAN USAHA '),
('094', '05', 'BIDANG PENDIDIKAN, KESEHA'),
('094', '06', 'BIDANG PERUMAHAN DAN PERM'),
('094', '07', 'BIDANG INFRASTRUKTUR, LIN'),
('094', '08', 'BIDANG KELEMBAGAAN DAN PE'),
('094', '09', 'SEKRETARIAT, KOMUNIKASI D'),
('094', '10', 'BIDANG OPERASI           '),
('112', '01', 'SUPIR'),
('112', '02', 'KENECK'),
('113', '01', 'SEKRETARIAT'),
('113', '02', 'PEMBINA');

-- --------------------------------------------------------

--
-- Table structure for table `uappbw`
--

CREATE TABLE IF NOT EXISTS `uappbw` (
  `kd_uapb` varchar(4) NOT NULL,
  `kd_uappb` varchar(11) NOT NULL,
  `kd_uappbw` varchar(10) NOT NULL,
  `nm_uappbw` varchar(30) NOT NULL
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
  `user_level` int(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_level`) VALUES
(1, 'masteradmin', '0192023a7bbd73250516f069df18b500', 'yohanes.christomas@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE IF NOT EXISTS `wilayah` (
  `kd_wil` varchar(10) NOT NULL,
  `nm_wil` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`kd_wil`, `nm_wil`) VALUES
('0100', 'DKI JAKARTA         '),
('0151', 'KOTA JAKARTA PUSAT  '),
('0152', 'KOTA JAKARTA UTARA  '),
('0153', 'KOTA JAKARTA BARAT  '),
('0154', 'KOTA JAKARTA SELATAN'),
('0155', 'KOTA JAKARTA TIMUR  '),
('0156', 'KEPULAUAN SEREBU    '),
('0200', 'JAWA BARAT          '),
('0205', 'KAB. BOGOR          '),
('0206', 'KAB. SUKABUMI       '),
('0207', 'KAB. CIANJUR        '),
('0208', 'KAB. BEKASI         '),
('0209', 'KAB. KARAWANG       '),
('0210', 'KAB. PURWAKARTA     '),
('0211', 'KAB. SUBANG         '),
('0212', 'KAB. BANDUNG        '),
('0213', 'KAB. SUMEDANG       '),
('0214', 'KAB. G A R U T      '),
('0215', 'KAB. TASIKMALAYA    '),
('0216', 'KAB. CIAMIS         '),
('0217', 'KAB. CIREBON        '),
('0218', 'KAB. KUNINGAN       '),
('0219', 'KAB. INDRAMAYU      '),
('0220', 'KAB. MAJALENGKA     '),
('0221', 'KAB. BANDUNG BARAT  '),
('0251', 'KOTA BANDUNG        '),
('0252', 'KOTA BOGOR          '),
('0253', 'KOTA SUKABUMI       '),
('0254', 'KOTA CIREBON        '),
('0257', 'KOTA BEKASI         '),
('0258', 'KOTA DEPOK          '),
('0260', 'KOTA TASIKMALAYA    '),
('0261', 'KOTA CIMAHI         '),
('0262', 'KOTA BANJAR         '),
('0300', 'JAWA TENGAH         '),
('0301', 'KAB. SEMARANG       '),
('0302', 'KAB. KENDAL         '),
('0303', 'KAB. DEMAK          '),
('0304', 'KAB. GROBOGAN       '),
('0305', 'KAB. PEKALONGAN     '),
('0306', 'KAB. BATANG         '),
('0307', 'KAB. TEGAL          '),
('0308', 'KAB. BREBES         '),
('0309', 'KAB. PATI           '),
('0310', 'KAB. KUDUS          '),
('0311', 'KAB. PEMALANG       '),
('0312', 'KAB. JEPARA         '),
('0313', 'KAB. REMBANG        '),
('0314', 'KAB. BLORA          '),
('0315', 'KAB. BANYUMAS       '),
('0316', 'KAB. CILACAP        '),
('0317', 'KAB. PURBALINGGA    '),
('0318', 'KAB. BANJARNEGARA   '),
('0319', 'KAB. MAGELANG       '),
('0320', 'KAB. TEMANGGUNG     '),
('0321', 'KAB. WONOSOBO       '),
('0322', 'KAB. PURWOREJO      '),
('0323', 'KAB. KEBUMEN        '),
('0324', 'KAB. KLATEN         '),
('0325', 'KAB. BOYOLALI       '),
('0326', 'KAB. SRAGEN         '),
('0327', 'KAB. SUKOHARJO      '),
('0328', 'KAB. KARANGANYAR    '),
('0329', 'KAB. WONOGIRI       '),
('0330', 'KAB. CEPU           '),
('0351', 'KOTA SEMARANG       '),
('0352', 'KOTA SALATIGA       '),
('0353', 'KOTA PEKALONGAN     '),
('0354', 'KOTA TEGAL          '),
('0355', 'KOTA MAGELANG       '),
('0356', 'KOTA SURAKARTA      '),
('0400', 'DI YOGYAKARTA       '),
('0401', 'KAB. BANTUL         '),
('0402', 'KAB. SLEMAN         '),
('0403', 'KAB. GUNUNGKIDUL    '),
('0404', 'KAB. KULONPROGO     '),
('0451', 'KOTA YOGYAKARTA     '),
('0500', 'JAWA TIMUR          '),
('0501', 'KAB. GRESIK         '),
('0502', 'KAB. MOJOKERTO      '),
('0503', 'KAB. SIDOARJO       '),
('0504', 'KAB. JOMBANG        '),
('0505', 'KAB. SAMPANG        '),
('0506', 'KAB. PAMEKASAN      '),
('0507', 'KAB. SUMENEP        '),
('0508', 'KAB. BANGKALAN      '),
('0509', 'KAB. BONDOWOSO      '),
('0510', 'KAB. SITUBONDO      '),
('0511', 'KAB. BANYUWANGI     '),
('0512', 'KAB. JEMBER         '),
('0513', 'KAB. MALANG         '),
('0514', 'KAB. PASURUAN       '),
('0515', 'KAB. PROBOLINGGO    '),
('0516', 'KAB. LUMAJANG       '),
('0517', 'KAB. KEDIRI         '),
('0518', 'KAB. TULUNGAGUNG    '),
('0519', 'KAB. NGANJUK        '),
('0520', 'KAB. TRENGGALEK     '),
('0521', 'KAB. BLITAR         '),
('0522', 'KAB. MADIUN         '),
('0523', 'KAB. NGAWI          '),
('0524', 'KAB. MAGETAN        '),
('0525', 'KAB. PONOROGO       '),
('0526', 'KAB. PACITAN        '),
('0527', 'KAB. BOJONEGORO     '),
('0528', 'KAB. TUBAN          '),
('0529', 'KAB. LAMONGAN       '),
('0551', 'KOTA SURABAYA       '),
('0552', 'KOTA MOJOKERTO      '),
('0553', 'KOTA MALANG         '),
('0554', 'KOTA PASURUAN       '),
('0555', 'KOTA PROBOLINGGO    '),
('0556', 'KOTA BLITAR         '),
('0557', 'KOTA KEDIRI         '),
('0558', 'KOTA MADIUN         '),
('0559', 'KOTA BATU           '),
('0600', 'NANGGROE ACEH DARUSS'),
('0601', 'KAB. ACEH BESAR     '),
('0602', 'KAB. P I D I E      '),
('0603', 'KAB. ACEH UTARA     '),
('0604', 'KAB. ACEH TIMUR     '),
('0605', 'KAB. ACEH SELATAN   '),
('0606', 'KAB. ACEH BARAT     '),
('0607', 'KAB. ACEH TENGAH    '),
('0608', 'KAB. ACEH TENGGARA  '),
('0609', 'KAB. SIMEULEU       '),
('0610', 'KAB. ACEH SINGKIL   '),
('0611', 'KAB. BIREUN         '),
('0612', 'KAB. ACEH BARAT DAYA'),
('0613', 'KAB. ACEH GAYO LUES '),
('0614', 'KAB. ACEH JAYA      '),
('0615', 'KAB. NAGAN RAYA     '),
('0616', 'KAB. ACEH TAMIANG   '),
('0617', 'KAB. BENER MERIAH   '),
('0618', 'KAB. PIDIE JAYA     '),
('0651', 'KOTA BANDA ACEH     '),
('0652', 'KOTA SABANG         '),
('0653', 'KOTA LANGSA         '),
('0654', 'KOTA LHOKSEUMAWE    '),
('0655', 'KOTA  MEULABOH      '),
('0656', 'KOTA SUMBULUSSALAM  '),
('0700', 'SUMATERA UTARA      '),
('0701', 'KAB. DELISERDANG    '),
('0702', 'KAB. KARO           '),
('0703', 'KAB. LANGKAT        '),
('0704', 'KAB. TAPANULI TENGAH'),
('0705', 'KAB. SIMALUNGUN     '),
('0706', 'KAB. LABUHANBATU    '),
('0707', 'KAB. D A I R I      '),
('0708', 'KAB. TAPANULI UTARA '),
('0709', 'KAB. TAPANULI SELATA'),
('0710', 'KAB. ASAHAN         '),
('0711', 'KAB. N  I  A  S     '),
('0712', 'KAB. SAMOSIR        '),
('0713', 'KAB. MANDAILING NATA'),
('0714', 'KAB. NIAS SELATAN   '),
('0715', 'KAB. PAKPAK BARAT   '),
('0716', 'KAB. HUMBANG HASUNDU'),
('0717', 'KAB. TOBA SAMOSIR   '),
('0718', 'KAB. TARUTUNG       '),
('0720', 'KAB. SERDANG BEDAGAI'),
('0721', 'KAB. BATUBARA       '),
('0722', 'KAB. PADANG LAWAS   '),
('0723', 'KAB. PADANG LAWAS UT'),
('0724', 'KAB. LABUHAN BATU SE'),
('0725', 'KAB. LABUHAN BATU UT'),
('0726', 'KAB. NIAS UTARA     '),
('0727', 'KAB. NIAS BARAT     '),
('0751', 'KOTA MEDAN          '),
('0752', 'KOTA TEBINGTINGGI   '),
('0753', 'KOTA B I N J A I    '),
('0754', 'KOTA PEMATANGSIANTAR'),
('0755', 'KOTA TANJUNGBALAI   '),
('0756', 'KOTA SIBOLGA        '),
('0757', 'KOTA PADANG SIDEMPUA'),
('0758', 'KOTA STABAT         '),
('0759', 'KOTA LUBUK PAKAM    '),
('0760', 'KOTA SIDI KALANG    '),
('0761', 'KOTA GUNUNG SITOLI  '),
('0800', 'SUMATERA BARAT      '),
('0801', 'KAB. A G A M        '),
('0802', 'KAB. PASAMAN        '),
('0803', 'KAB. LIMAPULUH KOTA '),
('0804', 'KAB. S O L O K      '),
('0805', 'KAB. PADANG PARIAMAN'),
('0806', 'KAB. PESISIR SELATAN'),
('0807', 'KAB. TANAH DATAR    '),
('0808', 'KAB. SAWAHLUNTO     '),
('0809', 'KAB. KEPULAUAN MENTA'),
('0810', 'KAB. DHARMAS RAYA   '),
('0811', 'KAB. SOLOK SELATAN  '),
('0812', 'KAB. PASAMAN BARAT  '),
('0813', 'KAB. SIJUNJUNG      '),
('0814', 'KAB. SAWAHLUNTO SIJU'),
('0851', 'KOTA BUKITTINGGI    '),
('0852', 'KOTA PADANG PANJANG '),
('0853', 'KOTA S O L O K      '),
('0854', 'KOTA SAWAHLUNTO     '),
('0855', 'KOTA PADANG         '),
('0856', 'KOTA PAYAKUMBUH     '),
('0857', 'KOTA PARIAMAN       '),
('0858', 'KOTA LUBUK SIKAPING '),
('0859', 'KOTA PAINAN         '),
('0900', 'RIAU                '),
('0901', 'KAB. KAMPAR         '),
('0902', 'KAB. BENGKALIS      '),
('0904', 'KAB. INDRAGIRI HULU '),
('0905', 'KAB. INDRAGIRI HILIR'),
('0906', 'KAB. PELALAWAN      '),
('0907', 'KAB. ROKAN HULU     '),
('0908', 'KAB. ROKAN HILIR    '),
('0909', 'KAB. SIAK           '),
('0912', 'KAB. KUANTAN SINGING'),
('0913', 'KAB. KEPULAUAN MERAN'),
('0951', 'KOTA PEKANBARU      '),
('0953', 'KOTA DUMAI          '),
('0954', 'KOTA RENGAT         '),
('0955', 'OTORITA BATAM       '),
('1000', 'JAMBI               '),
('1001', 'KAB. BATANGHARI     '),
('1002', 'KAB. TANJUNG JABUNG '),
('1003', 'KAB. BUNGO          '),
('1004', 'KAB. SAROLANGUN     '),
('1005', 'KAB. KERINCI        '),
('1006', 'KAB. MERANGIN       '),
('1007', 'KAB. TANJUNG JABUNG '),
('1008', 'KAB. T E B O        '),
('1009', 'KAB. MUARO JAMBI    '),
('1051', 'KOTA JAMBI          '),
('1052', 'KOTA SUNGAI PENUH   '),
('1100', 'SUMATERA SELATAN    '),
('1103', 'KAB. MUSI BANYU ASIN'),
('1104', 'KAB. OGAN KOMERING U'),
('1105', 'KAB. MUARA ENIM     '),
('1106', 'KAB. L A H A T      '),
('1107', 'KAB. MUSI RAWAS     '),
('1108', 'KAB. OGAN KOMERING I'),
('1109', 'KAB. BANYUASIN      '),
('1110', 'KAB. OKU TIMUR      '),
('1111', 'KAB. OKU SELATAN    '),
('1112', 'KAB. OGAN ILIR      '),
('1113', 'KAB. OKU UTARA      '),
('1115', 'KAB. IDRALAYA       '),
('1116', 'KAB. BATU RAJA      '),
('1117', 'KAB. EMPAT LAWANG   '),
('1151', 'KOTA PALEMBANG      '),
('1153', 'KOTA PRABUMULIH     '),
('1154', 'KOTA PAGAR ALAM     '),
('1155', 'KOTA LUBUK LINGGAU  '),
('1200', 'LAMPUNG             '),
('1201', 'KAB. LAMPUNG SELATAN'),
('1202', 'KAB. LAMPUNG TENGAH '),
('1203', 'KAB. LAMPUNG UTARA  '),
('1204', 'KAB. LAMPUNG BARAT  '),
('1205', 'KAB. TULANG BAWANG  '),
('1206', 'KAB. TANGGAMUS      '),
('1207', 'KAB. LAMPUNG TIMUR  '),
('1208', 'KAB. WAY KANAN      '),
('1209', 'KAB. PESAWARAN      '),
('1210', 'KAB. PRINGSEWU      '),
('1211', 'KAB. MESUJI         '),
('1212', 'KAB. TULANG BAWANG B'),
('1251', 'KOTA BANDAR LAMPUNG '),
('1252', 'KOTA METRO          '),
('1300', 'KALIMANTAN BARAT    '),
('1301', 'KAB. SAMBAS         '),
('1302', 'KAB. SANGGAU        '),
('1303', 'KAB. SINTANG        '),
('1304', 'KAB. PONTIANAK      '),
('1305', 'KAB. KAPUAS HULU    '),
('1306', 'KAB. KETAPANG       '),
('1307', 'KAB. BENGKAYANG     '),
('1308', 'KAB. LANDAK         '),
('1309', 'KAB. MELAWI         '),
('1310', 'KAB. SEKADAU        '),
('1311', 'KAB. KAYONG UTARA   '),
('1312', 'KAB. KUBU RAYA      '),
('1351', 'KOTA PONTIANAK      '),
('1352', 'KOTA SINGKAWANG     '),
('1400', 'KALIMANTAN TENGAH   '),
('1401', 'KAB. KAPUAS         '),
('1402', 'KAB. BARITO UTARA   '),
('1403', 'KAB. BARITO SELATAN '),
('1404', 'KAB. KOTAWARINGIN TI'),
('1405', 'KAB. KOTAWARINGIN BA'),
('1406', 'KAB. KATINGAN       '),
('1407', 'KAB. SERUYAN        '),
('1408', 'KAB. SUKAMARA       '),
('1409', 'KAB. LAMANDAU       '),
('1410', 'KAB. GUNUNG MAS     '),
('1411', 'KAB. PULANG PISAU   '),
('1412', 'KAB. MURUNG RAYA    '),
('1413', 'KAB. BARITO TIMUR   '),
('1451', 'KOTA PALANGKARAYA   '),
('1500', 'KALIMANTAN SELATAN  '),
('1501', 'KAB. BANJAR         '),
('1502', 'KAB. TANAH LAUT     '),
('1503', 'KAB. TAPIN          '),
('1504', 'KAB. HULU SUNGAI SEL'),
('1505', 'KAB. HULU SUNGAI TEN'),
('1506', 'KAB. BARITO KUALA   '),
('1507', 'KAB. TABALONG       '),
('1508', 'KAB. KOTABARU       '),
('1509', 'KAB. HULU SUNGAI UTA'),
('1510', 'KAB. TANAH BUMBU    '),
('1511', 'KAB. BALANGAN       '),
('1551', 'KOTA BANJARMASIN    '),
('1552', 'KOTA BANJARBARU     '),
('1600', 'KALIMANTAN TIMUR    '),
('1601', 'KAB. K U T A I      '),
('1602', 'KAB. P A S E R      '),
('1603', 'KAB. BULUNGAN       '),
('1604', 'KAB. B E R A U      '),
('1605', 'KAB. NUNUKAN        '),
('1606', 'KAB. MALINAU        '),
('1607', 'KAB. KUTAI BARAT    '),
('1608', 'KAB. KUTAI TIMUR    '),
('1609', 'KAB. PENAJAM PASER U'),
('1610', 'KAB. KUTAI KERTANEGA'),
('1611', 'TENGGARONG          '),
('1612', 'KAB. TANA TIDUNG    '),
('1651', 'KOTA SAMARINDA      '),
('1652', 'KOTA BALIKPAPAN     '),
('1653', 'KOTA TARAKAN        '),
('1654', 'KOTA BONTANG        '),
('1700', 'SULAWESI UTARA      '),
('1702', 'KAB. MINAHASA       '),
('1703', 'KAB. BOLAANG MONGOND'),
('1704', 'KAB. KEPULAUAN SANGI'),
('1705', 'KAB. KEPULAUAN TALAU'),
('1706', 'KAB. MINAHASA SELATA'),
('1707', 'KAB. TOMOHON        '),
('1708', 'KAB. MINAHASA UTARA '),
('1709', 'KAB. KEP.SANGIHE TAL'),
('1710', 'KAB. MINAHASA TENGGA'),
('1711', 'KAB. BOLAANG MONGOND'),
('1712', 'KAB. KEP. SIAU TAGUL'),
('1713', 'KAB. BOLAANG MONGOND'),
('1714', 'KAB. BOLAANG MONGOND'),
('1751', 'KOTA MANADO         '),
('1752', 'KOTA TOMOHON        '),
('1753', 'KOTA BITUNG         '),
('1754', 'KOTA KOTAMOBAGO     '),
('1800', 'SULAWESI TENGAH     '),
('1801', 'KAB. P O S O        '),
('1802', 'KAB. DONGGALA       '),
('1803', 'KAB. TOLI-TOLI      '),
('1804', 'KAB. BANGGAI        '),
('1805', 'KAB. B U O L        '),
('1806', 'KAB. MOROWALI       '),
('1807', 'KAB. BANGGAI KEPULAU'),
('1808', 'KAB. PARIGI MOUTONG '),
('1809', 'KAB. TOJO UNA-UNA   '),
('1812', 'KAB. SIGI           '),
('1851', 'KOTA PALU           '),
('1900', 'SULAWESI SELATAN    '),
('1901', 'KAB. PINRANG        '),
('1902', 'KAB. GOWA           '),
('1903', 'KAB. WAJO           '),
('1905', 'KAB. BONE           '),
('1906', 'KAB. TANATORAJA     '),
('1907', 'KAB. MAROS          '),
('1909', 'KAB. LUWU           '),
('1910', 'KAB. SINJAI         '),
('1911', 'KAB. BULUKUMBA      '),
('1912', 'KAB. BANTAENG       '),
('1913', 'KAB. JENEPONTO      '),
('1914', 'KAB. KEPULAUAN SELAY'),
('1915', 'KAB. TAKALAR        '),
('1916', 'KAB. BARRU          '),
('1917', 'KAB. SIDENRENG RAPPA'),
('1918', 'KAB. PANGKAJENE KEPU'),
('1919', 'KAB. SOPPENG        '),
('1921', 'KAB. ENREKANG       '),
('1922', 'KAB. LUWU UTARA     '),
('1924', 'KAB. LUWU TIMUR     '),
('1925', 'KAB. TORAJA UTARA   '),
('1951', 'KOTA MAKASSAR       '),
('1952', 'KOTA PARE-PARE      '),
('1953', 'KOTA PALOPO         '),
('2000', 'SULAWESI TENGGARA   '),
('2001', 'KAB. KENDARI (SDH TI'),
('2002', 'KAB. BUTON          '),
('2003', 'KAB. MUNA           '),
('2004', 'KAB. KOLAKA         '),
('2005', 'KAB. KONAWE SELATAN '),
('2006', 'KAB. BOMBANA        '),
('2007', 'KAB. WAKATOBI       '),
('2008', 'KAB. KOLAKA UTARA   '),
('2009', 'KAB. KONAWE         '),
('2010', 'KAB. KONAWE UTARA   '),
('2011', 'KAB. BUTON UTARA    '),
('2051', 'KOTA KENDARI        '),
('2052', 'KOTA BAU-BAU        '),
('2100', 'MALUKU              '),
('2101', 'KAB. MALUKU TENGAH  '),
('2102', 'KAB. MALUKU TENGGARA'),
('2103', 'KAB. MALUKU TENGGARA'),
('2104', 'KAB. PULAU BURU     '),
('2105', 'KAB. KEPULAUAN ARU  '),
('2106', 'KAB. SERAM BAGIAN BA'),
('2107', 'KAB. SERAM BAGIAN TI'),
('2108', 'KAB. MALUKU         '),
('2109', 'KAB. MALUKU BARAT DA'),
('2110', 'KAB. BURU SELATAN   '),
('2151', 'KOTA AMBON          '),
('2152', 'KOTA TUAL           '),
('2200', 'BALI                '),
('2201', 'KAB. BULELENG       '),
('2202', 'KAB. JEMBRANA       '),
('2203', 'KAB. KLUNGKUNG      '),
('2204', 'KAB. GIANYAR        '),
('2205', 'KAB. KARANGASEM     '),
('2206', 'KAB. BANGLI         '),
('2207', 'KAB. BADUNG         '),
('2208', 'KAB. TABANAN        '),
('2209', 'KAB. NEGARA         '),
('2251', 'KOTA DENPASAR       '),
('2300', 'NUSA TENGGARA BARAT '),
('2301', 'KAB. LOMBOK BARAT   '),
('2302', 'KAB. LOMBOK TENGAH  '),
('2303', 'KAB. LOMBOK TIMUR   '),
('2304', 'KAB. B I M A        '),
('2305', 'KAB. SUMBAWA        '),
('2306', 'KAB. DOMPU          '),
('2307', 'KAB. SUMBAWA BARAT  '),
('2308', 'KAB. LOMBOK UTARA   '),
('2351', 'KOTA MATARAM        '),
('2352', 'KOTA BIMA           '),
('2400', 'NUSA TENGGARA TIMUR '),
('2401', 'KAB. KUPANG         '),
('2402', 'KAB. B E L U        '),
('2403', 'KAB. TIMOR TENGAH UT'),
('2404', 'KAB. TIMOR TENGAH SE'),
('2405', 'KAB. A L O R        '),
('2406', 'KAB. S I K K A      '),
('2407', 'KAB. FLORES TIMUR   '),
('2408', 'KAB. E N D E        '),
('2409', 'KAB. NGADA          '),
('2410', 'KAB. MANGGARAI      '),
('2411', 'KAB. SUMBA TIMUR    '),
('2412', 'KAB. SUMBA BARAT    '),
('2413', 'KAB. LEMBATA        '),
('2414', 'KAB. ROTE NDAO      '),
('2415', 'KAB. MANGGARAI BARAT'),
('2416', 'KAB. TIMOR          '),
('2417', 'KAB. NAGEKEO        '),
('2418', 'KAB. SUMBA TENGAH   '),
('2419', 'KAB. SUMBA BARAT DAY'),
('2420', 'MANGGARAI TIMUR     '),
('2421', 'KAB. SABU RAIJUA    '),
('2451', 'KOTA KUPANG         '),
('2453', 'KAB. RUTENG         '),
('2500', 'PAPUA               '),
('2501', 'KAB. JAYAPURA       '),
('2502', 'KAB. BIAK-NUMFOR    '),
('2504', 'KAB. KEPULAUAN YAPEN'),
('2507', 'KAB. MERAUKE        '),
('2508', 'KAB. JAYAWIJAYA     '),
('2509', 'KAB. PANIAI         '),
('2510', 'KAB. NABIRE         '),
('2511', 'KAB. PUNCAK JAYA    '),
('2512', 'KAB. MIMIKA         '),
('2513', 'KAB. MAPPI          '),
('2514', 'KAB. ASMAT          '),
('2515', 'KAB. BOVEN DIGOEL   '),
('2516', 'KAB. SARMI          '),
('2517', 'KAB. KEEROM         '),
('2518', 'KAB. TOLIKARA       '),
('2519', 'KAB. PEGUNUNGAN BINT'),
('2520', 'KAB. MAMBERAMO RAYA '),
('2523', 'KAB. WAROPEN        '),
('2524', 'KAB. YAHUKIMO       '),
('2527', 'KAB. SUPIORI        '),
('2528', 'MAMBERAMO TENGAH    '),
('2529', 'KAB. LANNY JAYA     '),
('2530', 'DOGIYAI             '),
('2531', 'YALIMO              '),
('2532', 'NDUGA               '),
('2533', 'KAB. PUNCAK         '),
('2534', 'KAB. DAYAI          '),
('2535', 'KAB. INTAN JAYA     '),
('2536', 'KAB. DEIYAI         '),
('2551', 'KOTA JAYAPURA       '),
('2600', 'BENGKULU            '),
('2601', 'KAB. BENGKULU UTARA '),
('2602', 'KAB. BENGKULU SELATA'),
('2603', 'KAB. REJANG LEBONG  '),
('2604', 'KAB. SELUMA         '),
('2605', 'KAB. K A U R        '),
('2606', 'KAB. MUKO-MUKO      '),
('2607', 'KAB. LEBONG         '),
('2608', 'KAB. KEPAHIANG      '),
('2609', 'KAB. BENGKULU TENGAH'),
('2651', 'KOTA BENGKULU       '),
('2800', 'MALUKU UTARA        '),
('2801', 'KAB. MALUKU UTARA   '),
('2802', 'KAB. HALMAHERA TENGA'),
('2803', 'KAB. HALMAHERA UTARA'),
('2804', 'KAB. HALMAHERA SELAT'),
('2805', 'KAB. KEPULAUAN SULA '),
('2806', 'KAB. HALMAHERA TIMUR'),
('2807', 'KAB. HALMAHERA BARAT'),
('2808', 'KAB. PULAU MOROTAI  '),
('2851', 'KOTA TERNATE        '),
('2852', 'KOTA TIDORE         '),
('2853', 'KOTA TIDORE KEPULAUA'),
('2900', 'BANTEN              '),
('2901', 'KAB. SERANG         '),
('2902', 'KAB. PANDEGLANG     '),
('2903', 'KAB. LEBAK          '),
('2904', 'KAB. TANGERANG      '),
('2951', 'KOTA TANGERANG      '),
('2952', 'KOTA CILEGON        '),
('2953', 'KOTA SERANG         '),
('2954', 'KOTA TANGERANG  SELA'),
('3000', 'BANGKA BELITUNG     '),
('3001', 'KAB. BELITUNG       '),
('3002', 'KAB. BANGKA         '),
('3003', 'KAB. BANGKA BARAT   '),
('3004', 'KAB. BANGKA TENGAH  '),
('3005', 'KAB. BANGKA SELATAN '),
('3006', 'KAB. BELITUNG TIMUR '),
('3007', 'KAB. SUNGAI LIAT    '),
('3051', 'KOTA PANGKALPINANG  '),
('3100', 'GORONTALO           '),
('3101', 'KAB. GORONTALO      '),
('3102', 'KAB. BOALEMO        '),
('3103', 'KAB. POHUWATO       '),
('3104', 'KAB. BONE BOLANGO   '),
('3105', 'KAB. LIMBOTO        '),
('3106', 'KAB. MARISA         '),
('3107', 'KAB. GORONTALO UTARA'),
('3151', 'KOTA GORONTALO      '),
('3200', 'KEPULAUAN RIAU      '),
('3201', 'KAB. BINTAN         '),
('3202', 'KAB. KARIMUN        '),
('3203', 'KAB. NATUNA         '),
('3204', 'KAB. LINGGA         '),
('3205', 'KAB. ANAMBAS        '),
('3206', 'KAB. BARELANG       '),
('3207', 'KAB. MERANTI        '),
('3251', 'KOTA BATAM          '),
('3252', 'KOTA TANJUNG PINANG '),
('3300', 'PAPUA BARAT         '),
('3301', 'KAB. MANOKWARI      '),
('3302', 'KAB. SORONG         '),
('3303', 'KAB. FAK FAK        '),
('3304', 'KAB. SORONG SELATAN '),
('3305', 'KAB. RAJA AMPAT     '),
('3306', 'KAB. TELUK BINTUNI  '),
('3307', 'KAB. TELUK WONDAMA  '),
('3308', 'KAB. KAIMANA        '),
('3309', 'KAB. TAMBRAUW       '),
('3310', 'KAB. MAYBRAT        '),
('3351', 'KOTA SORONG         '),
('3400', 'PROP. SULAWESI BARAT'),
('3401', 'KAB. MAJENE         '),
('3402', 'KAB. MAMUJU         '),
('3403', 'KAB. MAMUJU UTARA   '),
('3404', 'KAB. POLEWALI MANDAR'),
('3405', 'KAB. MAMASA         '),
('3451', 'MAMUJU              '),
('5001', 'PERWAKILAN RI DI LUA'),
('5100', 'AMERIKA UTARA       '),
('5101', 'WASHINGTON DC       '),
('5102', 'NEW YORK KJRI       '),
('5103', 'NEW YORK PTRI       '),
('5104', 'CHICAGO             '),
('5105', 'LOS ANGELES         '),
('5106', 'SAN FRANSISCO       '),
('5107', 'HOUSTON             '),
('5108', 'OTTAWA              '),
('5109', 'VANCOUVER           '),
('5110', 'TORONTO             '),
('5111', 'PANAMA CITY         '),
('5200', 'AMERIKA SELATAN     '),
('5201', 'HAVANA              '),
('5202', 'MEXICO CITY         '),
('5203', 'BOGOTA              '),
('5204', 'CARACAS             '),
('5205', 'PARAMARIBO          '),
('5206', 'BUENOS AIRES        '),
('5207', 'SANTIAGO            '),
('5208', 'BRAZILIA            '),
('5209', 'LIMA                '),
('5210', 'QUITO               '),
('5300', 'EROPA TIMUR DAN UTAR'),
('5301', 'WARSAWA             '),
('5302', 'BUDHAPEST           '),
('5303', 'BUKHAREST           '),
('5304', 'PRAHA               '),
('5305', 'BRATISLAWA          '),
('5306', 'SOFIA               '),
('5307', 'BEOGRAD             '),
('5308', 'TASKHENT            '),
('5309', 'KIEV                '),
('5310', 'MOSKOW              '),
('5311', 'HELSINKI            '),
('5312', 'ROMA                '),
('5313', 'STOCKHOLM           '),
('5314', 'VATICAN             '),
('5315', 'LISABON             '),
('5316', 'ZAGREB              '),
('5317', 'ZAGREB              '),
('5400', 'EROPA BARAT         '),
('5401', 'LONDON              '),
('5402', 'BRUSSEL PRI         '),
('5403', 'BRUSSEL KBRI        '),
('5404', 'DEN HAAG            '),
('5405', 'FRANKFURT           '),
('5406', 'BERLIN              '),
('5407', 'HAMBURG             '),
('5408', 'BERN                '),
('5409', 'JENEWA              '),
('5410', 'PARIS               '),
('5411', 'MARSEILLES          '),
('5412', 'KOPENHAGEN          '),
('5413', 'OSLO                '),
('5414', 'WIENA               '),
('5415', 'MADRID              '),
('5500', 'AFRIKA              '),
('5501', 'KHARTOUM            '),
('5502', 'TUNIS               '),
('5503', 'RABBAT              '),
('5504', 'ALJAZAIR            '),
('5505', 'LAGOS               '),
('5506', 'DAKAR               '),
('5507', 'ADDIS ABABA         '),
('5508', 'NAIROBI             '),
('5509', 'DAR ES SALAM        '),
('5510', 'WINDHOEK            '),
('5511', 'HARARE              '),
('5512', 'TANANARIVE          '),
('5513', 'PRETORIA            '),
('5514', 'CAPE TOWN           '),
('5515', 'TRIPOLI             '),
('5516', 'ABUJA               '),
('5517', 'MAPUTO              '),
('5600', 'ASIA TENGAH DAN TIMU'),
('5601', 'KABOUL              '),
('5602', 'NEW DELHI           '),
('5603', 'MUMBAY              '),
('5604', 'ISLAMABAD           '),
('5605', 'KARACHI             '),
('5606', 'DHAKA               '),
('5607', 'COLOMBO             '),
('5608', 'TOKYO               '),
('5609', 'OSAKA               '),
('5610', 'SEOUL               '),
('5611', 'PYONGYANG           '),
('5612', 'BEIJING             '),
('5613', 'HONGKONG            '),
('5614', 'PHNOM PENH          '),
('5615', 'GUANGZHOU           '),
('5616', 'ASTANA              '),
('5617', 'BAKU                '),
('5700', 'ASIA PASIFIK        '),
('5701', 'CANBERRA            '),
('5702', 'PERTH               '),
('5703', 'DARWIN              '),
('5704', 'MELBOURNE           '),
('5705', 'SYDNEY              '),
('5706', 'WELLINGTON          '),
('5707', 'NOUMEA              '),
('5708', 'DILLI, KUKRI        '),
('5709', 'PORT MORESBY        '),
('5710', 'VANIMO              '),
('5711', 'SUVA                '),
('5800', 'ASIA TENGGARA       '),
('5801', 'HANOI               '),
('5802', 'HO CHI MINH         '),
('5803', 'VIENTIANE           '),
('5804', 'YANGOON             '),
('5805', 'BANGKOK             '),
('5806', 'SONGKLA             '),
('5807', 'KUALA LUMPUR        '),
('5808', 'PENANG              '),
('5809', 'KOTA KINABALU       '),
('5810', 'JAHOR BAHRU         '),
('5811', 'BANDAR SRI BEGAWAN  '),
('5812', 'SINGAPURA           '),
('5813', 'MANILA              '),
('5814', 'DAVAO CITY          '),
('5815', 'KUCHING             '),
('5816', 'TAWAU               '),
('5900', 'TIMUR TENGAH        '),
('5901', 'ANKARA              '),
('5902', 'DAMASCUS            '),
('5903', 'BEIRUT              '),
('5904', 'SANA''A              '),
('5905', 'RIYADH              '),
('5906', 'JEDDAH              '),
('5907', 'KUWAIT              '),
('5908', 'ABU DHABI           '),
('5909', 'AMMAN               '),
('5910', 'TEHERAN             '),
('5911', 'BAGHDAD             '),
('5912', 'DOHA                '),
('5913', 'CAIRO               '),
('5914', 'ATHENA              '),
('5915', 'DUBAI               '),
('5916', 'MANAMA              '),
('5917', 'MUSCAT              ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`kd_bid`);

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
-- Indexes for table `kel`
--
ALTER TABLE `kel`
  ADD PRIMARY KEY (`kd_kel`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`kd_lokasi`);

--
-- Indexes for table `perk`
--
ALTER TABLE `perk`
  ADD PRIMARY KEY (`kd_perk`);

--
-- Indexes for table `skel`
--
ALTER TABLE `skel`
  ADD PRIMARY KEY (`kd_skel`);

--
-- Indexes for table `sskel`
--
ALTER TABLE `sskel`
  ADD PRIMARY KEY (`kd_sskel`);

--
-- Indexes for table `uakpb`
--
ALTER TABLE `uakpb`
  ADD PRIMARY KEY (`kd_uakpb`);

--
-- Indexes for table `uapb`
--
ALTER TABLE `uapb`
  ADD PRIMARY KEY (`kd_uapb`);

--
-- Indexes for table `uappbw`
--
ALTER TABLE `uappbw`
  ADD PRIMARY KEY (`kd_uappbw`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`kd_wil`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(32) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
