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
		case 'readuapb':
			$Kanwil->bacauapb();
		break;
		case 'readuappbe':
			$kduapb = $purifier->purify($_POST["kduapb"]);
			$Kanwil->bacauappbe($kduapb);
		break;
		case 'addkanwil':
			$kodeuapb = $purifier->purify($_POST['kduapb']);
			$kodeuappbe = $purifier->purify($_POST['kduappbe']);
			$kodekanwil = $purifier->purify($_POST['kdkanwil']);
			$uraiankanwil = $purifier->purify($_POST['urkanwil']);
			$data = array(
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe,
				"kd_kanwil" => $kodekanwil,
		    	"nm_kanwil" => $uraiankanwil
		    );
			$Kanwil->tambahkanwil($data);
		break;
		case 'updkanwil':
			$iduapb = $purifier->purify($_POST['updiduapb']);
			$iduappbe = $purifier->purify($_POST['updiduappbe']);
			$idkanwil = $purifier->purify($_POST['updidkanwil']);
			$kodeuapb = $purifier->purify($_POST['updkduapb']);
			$kodeuappbe = $purifier->purify($_POST['updkduappbe']);
			$kodekanwil = $purifier->purify($_POST['updkdkanwil']);
			$uraiankanwil = $purifier->purify($_POST['updurkanwil']);
			$data = array(
				"id_uapb" => $iduapb,
				"id_uappbe1" => $iduappbe,
				"id_kanwil" => $idkanwil,
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe,
				"kd_kanwil" => $kodekanwil,
		    	"nm_kanwil" => $uraiankanwil
		    );
			$Kanwil->ubahkanwil($data);
		break;
		case 'delkanwil':
			$kodeuapb = $purifier->purify($_POST['kduapb']);
			$kodeuappbe = $purifier->purify($_POST['kduappbe']);
			$kodekanwil = $purifier->purify($_POST['kdkanwil']);
			$data = array(
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe,
				"kd_kanwil" => $kodekanwil,
		    );
			$Kanwil->hapuskanwil($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>