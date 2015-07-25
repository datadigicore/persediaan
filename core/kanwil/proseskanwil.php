<?php
include('../../model/modelKanwil.php');
include('../../config/purifier.php');
$Kanwil = new modelKanwil();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
			case 'addkanwil':
			$kodeuapb = $purifier->purify($_POST['kodeuapb']);
			$kodeuappbe1 = $purifier->purify($_POST['kodeuappbe1']);
			$kodekanwil = $purifier->purify($_POST['kodekanwil']);
			$uraiankanwil = $purifier->purify($_POST['uraiankanwil']);

			$data = array(
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe1,
				"kd_kanwil" => $kodekanwil,
		    	"nm_kanwil" => $uraiankanwil
		    );
			$Kanwil->tambahkanwil($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>