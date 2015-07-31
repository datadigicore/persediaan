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
		case 'upduappbw':
			$iduapb = $purifier->purify($_POST['iduapb']);
			$iduappbe = $purifier->purify($_POST['iduappbe']);
			$iduappbw = $purifier->purify($_POST['iduappbw']);
			$kodeuapb = $purifier->purify($_POST['updkduapb']);
			$kodeuappbe = $purifier->purify($_POST['updkduappbe']);
			$kodeuappbw = $purifier->purify($_POST['updkduappbw']);
			$uraianuappbw = $purifier->purify($_POST['upduruappbw']);
			$data = array(
				"id_uapb" => $iduapb,
				"id_uappbe1" => $iduappbe,
				"id_uappbw" => $iduappbw,
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe,
				"kd_uappbw" => $kodeuappbw,
		    	"nm_uappbw" => $uraianuappbw
		    );
			$Uappbw->ubahuappbw($data);
			print_r($data);
		break;
		case 'deluappbw':
			$kduapb = $purifier->purify($_POST['kduapb']);
			$kduappbe = $purifier->purify($_POST['kduappbe']);
			$kduappbw = $purifier->purify($_POST['kduappbw']);
			$data = array(
				"kd_uapb" => $kduapb,
				"kd_uappbe1" => $kduappbe,
				"kd_uappbw" => $kduappbw
			);
			$Uappbw->hapusuappbw($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>