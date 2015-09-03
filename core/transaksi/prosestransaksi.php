<?php
include('../../model/modelTransaksi.php');
include('../../config/purifier.php');
session_start();
$Transaksi = new modelTransaksi();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readbrg':
			$data = $_SESSION['kd_lok'];
			$Transaksi->bacabrg($data);
		break;		

		case 'readbrgmsk':
			$data = $_SESSION['kd_lok'];
			$Transaksi->baca_persediaan_masuk($data);
		break;		

		case 'baca_detil_trans':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$no_dok = $purifier->purify($_POST['no_dok']);
			$data = array(
				"no_dok" => $no_dok,
				"kd_brg" => $kd_brg
				);
			$Transaksi->baca_detil_trans($data);
		break;		

		case 'sisabarang':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_brg" => $kd_brg
				);
			$Transaksi->sisa_barang($data);
		break;

		case 'tbh_transaksi_klr':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_lok_msk = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$satuan = $purifier->purify($_POST['satuan']);
			$jns_trans = $_POST['jenis_trans'];
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$nm_brg = $purifier->purify($_POST['nm_brg']);
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			$status = 1;
			$user_id = $_SESSION['username'];
			
			
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"harga_sat" => $hrg_sat,
		    	"jns_trans" => $jns_trans,
				"keterangan" => $keterangan,
				"status" => $status,
				"user_id" => $user_id
			);
			$Transaksi->trnsaksi_keluar($data);
		break;

		case 'tbh_transaksi_msk':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_lok_msk = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$satuan = $purifier->purify($_POST['satuan']);
			$jns_trans = $_POST['jenis_trans'];
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$nm_brg = $purifier->purify($_POST['nm_brg']);
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			$status = 1;
			$user_id = $_SESSION['username'];

			$_SESSION['jns_trans'] = $purifier->purify($_POST['jenis_trans']);
			$_SESSION['no_dok'] = $purifier->purify($_POST['no_dok']);
			$_SESSION['no_bukti'] = $purifier->purify($_POST['no_bukti']);
			$_SESSION['tgl_dok'] = $purifier->purify($_POST['tgl_dok']);
			$_SESSION['tgl_buku'] = $purifier->purify($_POST['tgl_buku']);
			
			
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"harga_sat" => $hrg_sat,
		    	"jns_trans" => $jns_trans,
				"keterangan" => $keterangan,
				"status" => $status,
				"user_id" => $user_id
			);
			$Transaksi->transaksi_masuk($data);
		break;		

		case 'ubah_transaksi_msk':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_trans = $purifier->purify($_POST['kd_trans']);
			$kd_lok_msk = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);

			// $jns_trans = $_POST['jenis_trans'];

			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);

			$status = 1;
			$user_id = $_SESSION['username'];
			
			
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_trans" => $kd_trans,
				"kd_lok_msk" => $kd_lok_msk,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"harga_sat" => $hrg_sat,


				"keterangan" => $keterangan,
				"status" => $status,
				"user_id" => $user_id
			);
			print_r($data);
			$Transaksi->ubah_transaksi_masuk($data);
		break;		

		case 'tbh_koreksi':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_lok_msk = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$satuan = $purifier->purify($_POST['satuan']);
			$jns_trans = $_POST['jenis_trans'];
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$nm_brg = $purifier->purify($_POST['nm_brg']);
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			$status = 1;
			$user_id = $_SESSION['username'];
			
			
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"harga_sat" => $hrg_sat,
		    	"jns_trans" => $jns_trans,
				"keterangan" => $keterangan,
				"status" => $status,
				"user_id" => $user_id
			);
			$Transaksi->tbh_koreksi_masuk($data);
		break;

		case 'hapusTransMasuk':
			$id = $purifier->purify($_POST['id']);
			$user_id = $_SESSION['username'];
			$kd_lokasi = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];

			$data = array(
				"id" => $id,
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"user_id" => $user_id
			);

			$Transaksi->hapus_transaksi_masuk($data);
		break;		

		case 'hapusTransKeluar':
			$id = $purifier->purify($_POST['id']);
			$user_id = $_SESSION['username'];
			$kd_lokasi = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];

			$data = array(
				"id" => $id,
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"user_id" => $user_id
			);

			$Transaksi->hapus_transaksi_keluar($data);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>