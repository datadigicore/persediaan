<?php
include('../../model/modelWilayah.php');
include('../../config/purifier.php');
$Wilayah = new modelWilayah();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'addwil':

			$kodewil = $purifier->purify($_POST['kodewil']);
			$uraianwil = $purifier->purify($_POST['uraianwil']);
			$data = array(
				"kd_wil" => $kodewil,
		    	"nm_wil" => $uraianwil
		    );
			$Wilayah->tambahwilayah($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>