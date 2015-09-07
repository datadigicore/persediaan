<?php
include('../../model/modelsatker.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$Satker = new modelSatker();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readsektor':
			$tahun = $_SESSION['thn_ang'];
			$Satker->bacasektor($tahun);
		break;
		case 'readtable':
			$kdsektor = $purifier->purify($_POST['kdsektor']);
			$Satker->bacatable($kdsektor);
		break;
		case 'addsatker':
			$kdsektor = $purifier->purify($_POST['kdsektor']);
			$kdsatker = $purifier->purify($_POST['kdsatker']);
			$nmsatker = $purifier->purify($_POST['nmsatker']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker,
			  	"namasatker" => $nmsatker,
			  	"tahun" => $tahun
			);
			$Satker->tambahsatker($data);
		break;
		case 'updsatker':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$kdsatker = $purifier->purify($_POST['updkdsatker']);
			$nmsatker = $purifier->purify($_POST['updursatker']);
			$data = array(
				"id" => $id,
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker,
		    	"namasatker" => $nmsatker
		    );
			$Satker->ubahsatker($data);
		break;
		case 'delsatker':
			$id = $purifier->purify($_POST['id']);
			$idsatker = $purifier->purify($_POST['idsatker']);
			$data = array(
				"id" => $id,
				"idsatker" => $idsatker
		    );
			$Satker->hapussatker($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>