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
			$kdlokasi 	= $purifier->purify($_POST['read_no_dok']);
			$kota 		= $purifier->purify($_POST['kota']);
			$tanggal 	= $purifier->purify($_POST['tanggal']);
			$nip 		= $purifier->purify($_POST['nip']);
			$nama 		= $purifier->purify($_POST['nama']);
			$jabatan 	= $purifier->purify($_POST['jabatan']);
			$nip2 		= $purifier->purify($_POST['nip2']);
			$nama2 		= $purifier->purify($_POST['nama2']);
			$jabatan2 	= $purifier->purify($_POST['jabatan2']);
			$nama_kasubkeu	= $purifier->purify($_POST['nama-kasubkeu']);
			$nip_kasubkeu 	= $purifier->purify($_POST['nip-kasubkeu']);
			$tgl_isi = $purifier->purify($_POST['tgl_isi']);
			$tgl_setuju = $purifier->purify($_POST['tgl_setuju']);
			$unit = "1";
			
			$data = array(
				"kd_lokasi" => $kdlokasi,
				"kd_ruang" => $_SESSION['kd_ruang'],
				"kota" => $kota,
				"tanggal" => $tanggal,
				"nip" => $nip,
				"nama" => $nama,
				"jabatan" => $jabatan,
				"nip2" => $nip2,
				"nama2" => $nama2,
				"jabatan2" => $jabatan2,
				"nama_kasubkeu" => $nama_kasubkeu,
				"nip_kasubkeu" => $nip_kasubkeu,
				"tgl_isi" => $tgl_isi,
				"tgl_setuju" => $tgl_setuju,
		    	"unit" => $unit
		    );
			$Tndatgn->tambahttd($data);
		break;

		case 'baca_data_pj':
		$data = $purifier->purify($_POST['kd_lok']);
		$Tndatgn->baca_data_pj($data);
		break;		

		case 'baca_data_awal':
		$data = $_SESSION['kd_lok'].$_SESSION['kd_ruang'];
		$Tndatgn->baca_data_awal($data);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>