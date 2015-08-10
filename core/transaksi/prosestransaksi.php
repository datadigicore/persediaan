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
			$TransMsk->bacabrg();
		break;		

		case 'readuakpb':
			$TransMsk->bacauakpb();
		break;

		case 'readdok':
			$TransMsk->bacadok();
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

		case 'tbh_transaksi':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_lok_msk = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
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

		case 'tbh_transaksi_klr':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_lok_msk = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
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
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"harga_sat" => $hrg_sat,
		    	"jns_trans" => $jns_trans,
				"keterangan" => $keterangan,
				"status" => $status,
				"user_id" => $user_id
		    );
			$Transaksi->transaksi_keluar($data);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>