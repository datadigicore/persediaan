<?php
include('../../model/modelTransKlr.php');
include('../../config/purifier.php');
session_start();
$TransKlr = new modelTransKlr();

$kd_lokasi = $_SESSION['kd_lok'];
$kd_lok_msk = $_SESSION['kd_lok'];
$thn_ang = $_SESSION['thn_ang'];
$no_dok = $purifier->purify($_POST['no_dok']);
$tgl_dok = $purifier->purify($_POST['tgl_dok']);
$tgl_buku = $purifier->purify($_POST['tgl_buku']);
$no_bukti = $purifier->purify($_POST['no_bukti']);
$jns_trans = "K01";
$keterangan = $purifier->purify($_POST['keterangan']);
$user_id = $_SESSION['username'];

$kd_brg = $purifier->purify($_POST['kd_brg']);
$kuantitas = $purifier->purify($_POST['jml_msk']);
$rph_sat = $purifier->purify($_POST['rph_sat']);

if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readbrg':
			$TransKlr->bacabrg();
		break;		

		case 'readuakpb':
			$TransKlr->bacauakpb();
		break;

		case 'readdok':
			$TransKlr->bacadok();
		break;

		case 'tbhdokklr':	
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"jns_trans" => "K02",
				"keterangan" => $keterangan,
				"user_id" => $user_id
			   );
			$TransKlr->tambahdokumen($data);
		break;

		case 'tbhbrgklr':
			$data = array(
				"no_dok" => $no_dok,
				"kd_brg" => $kd_brg,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"rph_sat" => $rph_sat,
				"user_id" => $user_id
		    );
			$TransKlr->tambahbrgklr($data);
		break;	

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>