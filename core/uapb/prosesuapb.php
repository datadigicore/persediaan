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
		case 'upduapb':
			$id = $purifier->purify($_POST['id']);
			$kduapb = $purifier->purify($_POST['updkduapb']);
			$nmuapb = $purifier->purify($_POST['upduruapb']);
			$data = array(
				"id" => $id,
				"kd_uapb" => $kduapb,
		    	"nm_uapb" => $nmuapb
		    );
			$Uapb->ubahuapb($data);
		break;
		case 'deluapb':
			$id = $purifier->purify($_POST['id']);
			$Uapb->hapusuapb($id);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>