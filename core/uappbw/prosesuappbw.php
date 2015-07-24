<?php
include('../../model/modelUappbw.php');
include('../../config/purifier.php');
$Uappbw = new modelUappbw();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readuapb':
			$Uappbw->bacauapb();	
		break;
		case 'readuappbe':
			$kduapb = $purifier->purify($_POST["kduapb"]);
			$Uappbw->bacauappbe($kduapb);
		break;
		case 'readwil':
			$Uappbw->bacawilayah();
		break;
		case 'adduappbw':
			$kduapb = $purifier->purify($_POST['kduapb']);
			$kduappbe1 = $purifier->purify($_POST['kduappbe']);
			$kduappbw = $purifier->purify($_POST['kduappbw']);
			$nmuappbw = $purifier->purify($_POST['nmuappbw']);
			$data = array(
				"kd_uapb" => $kduapb,
				"kd_uappbe1" => $kduappbe1,
				"kd_uappbw" => $kduappbw,
			  	"nm_uappbw" => $nmuappbw
			);
			$Uappbw->tambahuappbw($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>