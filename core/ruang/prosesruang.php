<?php
include('../../model/modelruang.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$Ruang = new modelRuang();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readunit':
			$Ruang->bacaunit();
		break;
		case 'readuappbe':
			$kduapb = $purifier->purify($_POST["kduapb"]);
			$Ruang->bacauappbe($kduapb);
		break;
		case 'readuappbw':
			$kduapb = $purifier->purify($_POST["kduapb"]);
			$kduappbe = $purifier->purify($_POST["kduappbe"]);
			$data = array(
				'kd_uapb' => $kduapb,
				'kd_uappbe' => $kduappbe,
			);
			$Ruang->bacauappbw($data);		
		break;
		case 'adduakpb':
			$kodeuapb = $purifier->purify($_POST['kduapb']);
			$kodeuappbe1 = $purifier->purify($_POST['kduappbe']);
			$kodeuappbw = $purifier->purify($_POST['kduappbw']);
			$kodeuakpb = $purifier->purify($_POST['kduakpb']);
			$kodeuapkpb = $purifier->purify($_POST['kduapkpb']);
			$kodejk = $purifier->purify($_POST['kdjk']);
			$nmuakpb = $purifier->purify($_POST['nmuakpb']);
			$data = array(
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe1,
				"kd_uappbw" => $kodeuappbw,
				"kd_uakpb" => $kodeuakpb,
				"kd_uapkpb" => $kodeuapkpb,
				"jk" => $kodejk,
			  	"nm_uakpb" => $nmuakpb
			);
			$Ruang->tambahuakpb($data);
		break;
		case 'upduakpb':
			$id = $purifier->purify($_POST['id']);
			$kodeuapb = $purifier->purify($_POST['updkduapb']);
			$kodeuappbe1 = $purifier->purify($_POST['updkduappbe']);
			$kodeuappbw = $purifier->purify($_POST['updkduappbw']);
			$kodeuakpb = $purifier->purify($_POST['updkduakpb']);
			$kodeuapkpb = $purifier->purify($_POST['updkduapkpb']);
			$kodejk = $purifier->purify($_POST['updkdjk']);
			$nmuakpb = $purifier->purify($_POST['upduruakpb']);
			$kd_lokasi = $kodeuapb.''.$kodeuappbe1.''.$kodeuappbw.''.$kodeuakpb.''.$kodeuapkpb.''.$kodejk;
			$data = array(
				"id" => $id,
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe1,
				"kd_uappbw" => $kodeuappbw,
				"kd_uakpb" => $kodeuakpb,
				"kd_uapkpb" => $kodeuapkpb,
				"jk" => $kodejk,
			  	"nm_uakpb" => $nmuakpb,
			  	"kd_lokasi" => $kd_lokasi
			);
			$Ruang->ubahuakpb($data);
		break;
		case 'deluakpb':
			$id = $purifier->purify($_POST['id']);
			$Ruang->hapusuakpb($id);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>