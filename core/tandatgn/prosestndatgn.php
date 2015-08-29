<?php
include('../../model/modelTndtgn.php');
include('../../config/purifier.php');
$Tndatgn = new modelTndtgn();
session_start();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'addtndatgn':
			$kdlokasi = $_SESSION['kd_lok'];
			$kota = $purifier->purify($_POST['kota']);
			$tanggal = $purifier->purify($_POST['tanggal']);
			$nip = $purifier->purify($_POST['nip']);
			$nama = $purifier->purify($_POST['nama']);
			$jabatan = $purifier->purify($_POST['jabatan']);
			$nip2 = $purifier->purify($_POST['nip2']);
			$nama2 = $purifier->purify($_POST['nama2']);
			$jabatan2 = $purifier->purify($_POST['jabatan2']);
			$tgl_isi = $purifier->purify($_POST['tgl_isi']);
			$tgl_setuju = $purifier->purify($_POST['tgl_setuju']);
			$unit = "1";
			
			$data = array(
				"kd_lokasi" => $kdlokasi,
				"kota" => $kota,
				"tanggal" => $tanggal,
				"nip" => $nip,
				"nama" => $nama,
				"jabatan" => $jabatan,
				"nip2" => $nip2,
				"nama2" => $nama2,
				"jabatan2" => $jabatan2,
				"tgl_isi" => $tgl_isi,
				"tgl_setuju" => $tgl_setuju,
		    	"unit" => $unit
		    );
			$Tndatgn->tambahttd($data);
		break;

		case 'baca_data_pj':
		$data = $_SESSION['kd_lok'];
		$Tndatgn->baca_data_pj($data);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>