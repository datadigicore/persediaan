<?php
include('../../model/modelOpsik.php');
include('../../config/purifier.php');
$Opsik = new modelOpsik();
session_start();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{

		case 'readdok':
			$Opsik->bacadok();
		break;		

		case 'readbrg':
			$Opsik->bacabrg();
		break;

		case 'tbhbrgopsik':
			$no_dok = $purifier->purify($_POST['no_dok']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$rph_sat = $purifier->purify($_POST['rph_sat']);
			$user_id = $_SESSION['username'];

			$data = array(
				"no_dok" => $no_dok,
				"kd_brg" => $kd_brg,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"rph_sat" => $rph_sat,
				"user_id" => $user_id
		    );
			$Opsik->tambahbrgopsik($data);

		break;		

		case 'tbhopsik':
			$kd_lokasi = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$tgl_dok = $purifier->purify($_POST['tgl_dok']);
			$tgl_buku = $purifier->purify($_POST['tgl_buku']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$jns_trans = "P01";
			$keterangan = $purifier->purify($_POST['keterangan']);
			$user_id = $_SESSION['username'];

			
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"jns_trans" => $jns_trans,
				"keterangan" => $keterangan,
				"user_id" => $user_id
		    );
			$Opsik->tambahopsik($data);
		break;

		case 'ubahopsik':
			$thnang = $purifier->purify($_POST['thnang']);
			$kdlokasi = $purifier->purify($_POST['kdlokasi']);
			$kdbrg = $purifier->purify($_POST['kdbrg']);
			$tglbuku = $purifier->purify($_POST['tgldok']);
			$nodok = $purifier->purify($_POST['nodok']);
			$nobukti = $purifier->purify($_POST['nobukti']);
			$kuantitas = $purifier->purify($_POST['kuantitas']);
			$rphsat = $purifier->purify($_POST['srphsat']);

			$data = array(
				"thn_ang" => $thang,
				"kd_lokasi" => $kdlokasi,
				"kd_brg" => $kdbrg,
				"tglbuku" => $tglbuku,
				"nodok" => $nodok,
				"no_bukti" => $nobukti,
		    	"kuantitas" => $kuantitas,
		    	"rph_sat" => $rphsat
		    );
			$Opsik->ubahopsik($data);
		break;

		case 'hapusopsik':
			$thnang = $purifier->purify($_POST['thnang']);
			$kdlokasi = $purifier->purify($_POST['kdlokasi']);
			$kdbrg = $purifier->purify($_POST['kdbrg']);
			$tglbuku = $purifier->purify($_POST['tgldok']);
			$nodok = $purifier->purify($_POST['nodok']);
			$nobukti = $purifier->purify($_POST['nobukti']);
			$kuantitas = $purifier->purify($_POST['kuantitas']);
			$rphsat = $purifier->purify($_POST['srphsat']);

			$data = array(
				"thn_ang" => $thang,
				"kd_lokasi" => $kdlokasi,
				"kd_brg" => $kdbrg,
				"tglbuku" => $tglbuku,
				"nodok" => $nodok,
				"no_bukti" => $nobukti,
		    	"kuantitas" => $kuantitas,
		    	"rph_sat" => $rphsat
		    );
			$Opsik->hapusopsik($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>