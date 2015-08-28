<?php
include('../../model/modelunit.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$Unit = new modelUnit();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readsatker':
			$Unit->bacasatker();
		break;
		case 'readwil':
			$Unit->bacawilayah();
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
			$Unit->tambahuappbw($data);
		break;
		case 'upduappbw':
			$id = $purifier->purify($_POST['id']);
			$kodeuapb = $purifier->purify($_POST['updkduapb']);
			$kodeuappbe = $purifier->purify($_POST['updkduappbe']);
			$kodeuappbw = $purifier->purify($_POST['updkduappbw']);
			$uraianuappbw = $purifier->purify($_POST['upduruappbw']);
			$data = array(
				"id" => $id,
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe,
				"kd_uappbw" => $kodeuappbw,
		    	"nm_uappbw" => $uraianuappbw
		    );
			$Unit->ubahuappbw($data);
		break;
		case 'deluappbw':
			$id = $purifier->purify($_POST['id']);
			$Unit->hapusuappbw($id);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>