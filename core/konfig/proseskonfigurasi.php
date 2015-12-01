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
		case 'checkthnaktif':
			$thnaktif = urldecode($_POST['thnaktif']);
			$Konfig->bacathnaktif($thnaktif);
		break;
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
		case 'exporttahun_user':
			$thnawal = $purifier->purify($_POST['thnawal']);
			$thntujuan = $purifier->purify($_POST['thntujuan']);
			$data = array(
				"thnawal" => $thnawal,
				"thntujuan" => $thntujuan
	    	);
			$Konfig->exportkonfig_user($data);
		break;
		case 'delkonfig':
			$id = $purifier->purify($_POST['id']);
			$Konfig->hapustahun($id);
		break;

		case 'baca_upb_admin':
		$search = $_POST['q'];
		$Konfig->baca_upb_admin($search);
		break;		

		case 'refresh':
		$kd_lokasi = $purifier->purify($_POST['satker']);
		$thn_ang = $_SESSION['thn_ang'];

		$user_id = $_SESSION['username'];
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang,
				"user_id" => $user_id
		);
		$Konfig->refresh($kd_lokasi, $thn_ang, $user_id);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>