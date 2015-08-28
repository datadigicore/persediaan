<?php
include('../../model/modelReport.php');
include('../../config/purifier.php');
$Report = new modelReport();
session_start();

if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'buku_persediaan':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$user_id= $_SESSION['username'];
			$data = array(
				"kd_brg" => $kd_brg,
				"tgl_awal" => $tgl_awal,
				"tgl_akhir" => $tgl_akhir,
				"kd_lokasi" => $_SESSION['kd_lok'],
				"user_id" => $user_id
			   );
			$Report->buku_persediaan($data);
		break;

		case 'lap_persediaan':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$user_id= $_SESSION['username'];
			$data = array(
			"kd_brg" => $kd_brg,
			"tgl_awal" => $tgl_awal,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $_SESSION['kd_lok'],
			"user_id" => $user_id);
			$Report->laporan_persediaan($data);
		break;

		case 'mutasi':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$user_id= $_SESSION['username'];
			$data = array(
			"kd_brg" => $kd_brg,
			"tgl_awal" => $tgl_awal,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $_SESSION['kd_lok'],
			"user_id" => $user_id);
			$Report->mutasi_persediaan($data);
		break;		

		case 'neraca':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$user_id= $_SESSION['username'];
			$data = array(
			"kd_brg" => $kd_brg,
			"tgl_awal" => $tgl_awal,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $_SESSION['kd_lok'],
			"user_id" => $user_id);
			$Report->neraca($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>