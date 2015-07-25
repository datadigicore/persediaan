<?php
include('../../model/modelOpsik.php');
include('../../config/purifier.php');
$Opsik = new modelOpsik();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'addopsik':
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
			$Opsik->tambahopsik($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>