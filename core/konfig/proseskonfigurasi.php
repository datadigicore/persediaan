<?php
include('../../model/modelkonfigurasi.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$Konfig = new modelKonfigurasi();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readthn':
			$Konfig->bacatahun();
		break;
		case 'addthnaktif':
			$thnaktif = $purifier->purify($_POST['thnaktif']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$status = $purifier->purify($_POST['status']);
			if ($status == '') {
				$data = array(
					"thnaktif" => $thnaktif,
					"keterangan" => $keterangan
		    	);
		    	$Konfig->tambahtahun($data);
			}
			else{
				$data = array(
					"thnaktif" => $thnaktif,
					"keterangan" => $keterangan,
			    	"status" => $status
		    	);
		    	$Konfig->tambahtahunaktif($data);
			}
		break;
		case 'setaktif':
			$id = $purifier->purify($_POST['id']);
			$Konfig->aktifkantahun($id);
		break;
		case 'exporttahun':
			$thnawal = $purifier->purify($_POST['thnawal']);
			$thntujuan = $purifier->purify($_POST['thntujuan']);
			$data = array(
				"thnawal" => $thnawal,
				"thntujuan" => $thntujuan
	    	);
			$Konfig->exportkonfig($data);
		break;
		case 'delkonfig':
			$id = $purifier->purify($_POST['id']);
			$Konfig->hapustahun($id);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>