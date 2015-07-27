<?php
include('../../model/modelTransKlr.php');
include('../../config/purifier.php');
$TransKlr = new modelTransKlr();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'addtransklr':
			$kd_lokasi_ = $purifier->purify($_POST['kd_lokasi']);
			$kd_lok_klr = $purifier->purify($_POST['kd_lok_klr']);
			$thn_ang = $purifier->purify($_POST['thn_ang']);
			$no_dok = $purifier->purify($_POST['no_dok']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$kuantitas = $purifier->purify($_POST['kuantitas']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$jns_trans = $purifier->purify($_POST['jns_trans']);
			$rph_sat = $purifier->purify($_POST['rph_sat']);


			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_klr" => $kd_lok_klr,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"kd_brg" => $kd_brg,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
				"no_bukti" => $no_bukti,
				"jns_trans" => $jns_trans,
				"rph_sat" => $rph_sat,
		    	"rph_sat" => $rph_sat
		    );
			$TransKlr->tambahtransklr($data);
		break;
		case 'ubahtransklr':
			$kd_lokasi_ = $purifier->purify($_POST['kd_lokasi']);
			$kd_lok_msk = $purifier->purify($_POST['kd_lok_msk']);
			$thn_ang = $purifier->purify($_POST['thn_ang']);
			$no_dok = $purifier->purify($_POST['no_dok']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$kuantitas = $purifier->purify($_POST['kuantitas']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$jns_trans = $purifier->purify($_POST['jns_trans']);
			$rph_sat = $purifier->purify($_POST['rph_sat']);

			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"kd_brg" => $kd_brg,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
				"no_bukti" => $no_bukti,
				"jns_trans" => $jns_trans,
				"rph_sat" => $rph_sat,
		    	"rph_sat" => $rph_sat
		    );
			$TransKlr->ubahtransklr($data);  
		break;

		case 'hapustransklr':
			$kd_lokasi_ = $purifier->purify($_POST['kd_lokasi']);
			$kd_lok_msk = $purifier->purify($_POST['kd_lok_msk']);
			$thn_ang = $purifier->purify($_POST['thn_ang']);
			$no_dok = $purifier->purify($_POST['no_dok']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$kuantitas = $purifier->purify($_POST['kuantitas']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$jns_trans = $purifier->purify($_POST['jns_trans']);
			$rph_sat = $purifier->purify($_POST['rph_sat']);


			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"kd_brg" => $kd_brg,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
				"no_bukti" => $no_bukti,
				"jns_trans" => $jns_trans,
				"rph_sat" => $rph_sat,
		    	"rph_sat" => $rph_sat
		    );
			$TransKlr->hapustransklr($data);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>