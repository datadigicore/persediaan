<?php
include('../../model/modelUapb.php');
include('../../config/purifier.php');
$Uapb = new modelUapb();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'adduapb':
			$kduapb = $purifier->purify($_POST['kduapb']);
			$nmuapb = $purifier->purify($_POST['nmuapb']);
			$data = array(
				"kd_uapb" => $kduapb,
		    	"nm_uapb" => $nmuapb
		    );
			$Uapb->tambahuapb($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>