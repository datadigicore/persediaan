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
			$kodewil = $purifier->purify($_POST['kdwil']);
			$uraianwil = $purifier->purify($_POST['urwil']);
			$data = array(
				"kd_wil" => $kodewil,
		    	"nm_wil" => $uraianwil
		    );
			$Wilayah->tambahwilayah($data);
		break;
		case 'updwil':
			$kdwil = $purifier->purify($_POST['updkdwil']);
			$nmwil = $purifier->purify($_POST['updurwil']);
			$data = array(
				"kd_wil" => $kdwil,
		    	"nm_wil" => $nmwil
		    );
			$Wilayah->ubahwilayah($data);
		break;
		case 'delwil':
			$kdwil = $purifier->purify($_POST['kdwil']);
			$Wilayah->hapuswilayah($kdwil);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>