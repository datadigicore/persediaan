<?php
include('../../model/modelUappbe.php');
include('../../config/purifier.php');
$Uappbe = new modelUappbe();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readuapb':
			$Uappbe->bacauapb();
		break;
		case 'readtable':
			$kduapb = $purifier->purify($_POST['kduapb']);
			$Uappbe->bacatable($kduapb);
		break;
		case 'adduappbe':
			$kduapb = $purifier->purify($_POST['kduapb']);
			$kduappbe1 = $purifier->purify($_POST['kduappbe']);
			$nmuappbe1 = $purifier->purify($_POST['nmuappbe']);
			$data = array(
				"kd_uapb" => $kduapb,
				"kd_uappbe1" => $kduappbe1,
			  	"nm_uappbe1" => $nmuappbe1
			);
			$Uappbe->tambahuappbe($data);
		break;
		case 'upduappbe':
			$kduapb = $purifier->purify($_POST['updkduapb']);
			$kduappbe = $purifier->purify($_POST['updkduappbe']);
			$nmuappbe = $purifier->purify($_POST['upduruappbe']);
			$data = array(
				"kd_uapb" => $kduapb,
				"kd_uappbe1" => $kduappbe,
		    	"nm_uappbe1" => $nmuappbe
		    );
			$Uappbe->ubahuappbe($data);
		break;
		case 'deluappbe':
			$kduapb = $purifier->purify($_POST['kduapb']);
			$kduappbe = $purifier->purify($_POST['kduappbe']);
			$data = array(
				"kd_uapb" => $kduapb,
				"kd_uappbe1" => $kduappbe
			);
			$Uappbe->hapusuappbe($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>