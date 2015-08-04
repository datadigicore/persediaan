<?php
include('../../model/modelUakpb.php');
include('../../config/purifier.php');
$Uakpb = new modelUakpb();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readuapb':
			$Uakpb->bacauapb();
		break;
		case 'readuappbe':
			$kduapb = $purifier->purify($_POST["kduapb"]);
			$Uakpb->bacauappbe($kduapb);
		break;
		case 'readuappbw':
			$kduapb = $purifier->purify($_POST["kduapb"]);
			$kduappbe = $purifier->purify($_POST["kduappbe"]);
			$data = array(
				'kd_uapb' => $kduapb,
				'kd_uappbe' => $kduappbe,
			);
			$Uakpb->bacauappbw($data);		
		break;
		case 'readuakpb':
			$Uakpb->bacauakpb();
		break;
		case 'adduakpb':
			$kodeuapb = $purifier->purify($_POST['kduapb']);
			$kodeuappbe1 = $purifier->purify($_POST['kduappbe']);
			$kodeuappbw = $purifier->purify($_POST['kduappbw']);
			$kodeuakpb = $purifier->purify($_POST['kduakpb']);
			$kodeuapkpb = $purifier->purify($_POST['kduapkpb']);
			$kodejk = $purifier->purify($_POST['kdjkel']);
			$nmuakpb = $purifier->purify($_POST['nmuakpb']);
			$kd_lokasi = $kodeuapb.''.$kodeuappbe1.''.$kodeuappbw.''.$kodeuakpb.''.$kodeuapkpb.''.$kodejk;

			$data = array(
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe1,
				"kd_uappbw" => $kodeuappbw,
				"kd_uakpb" => $kodeuakpb,
				"kd_uapkpb" => $kodeuapkpb,
				"jk" => $kodejk,
			  	"nm_uakpb" => $nmuakpb,
			  	"kd_lokasi" => $kd_lokasi
			);
			$Uakpb->tambahuakpb($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>