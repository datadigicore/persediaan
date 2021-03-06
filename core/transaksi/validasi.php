<?php
include('../../model/modelValidasi.php');
include('../../config/purifier.php');
session_start();
$Validasi = new modelValidasi();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'ubah_pwd';
		$user_name = $_SESSION['username'];
		$old_pwd = $purifier->purify(md5($_POST['old_password']));
		$new_pwd = $purifier->purify(md5($_POST['password']));
		$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);
		$data = array(
				"user_name" => $user_name,
				"old_pwd" => $old_pwd,
				"new_pwd" => $new_pwd,
				"kd_lokasi" => $kd_lokasi
			);
		print_r($data);
		$Validasi->ubah_pwd($data);
		break;

		case 'cek_dok_masuk':
		$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);
		$thn_ang = $_SESSION['thn_ang'];
		$no_dok = $purifier->purify($_POST['no_dok']);
		
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang,
				"nm_tabel" => "transaksi_masuk",
				"no_dok" => $no_dok
				);
		$Validasi->cek_dok_masuk($data);
		break;	

		case 'cek_dok_keluar':
		$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);
		$thn_ang = $_SESSION['thn_ang'];
		$no_dok = $purifier->purify($_POST['no_dok']);
		
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang,
				"nm_tabel" => "transaksi_keluar",
				"no_dok" => $no_dok
				);
		$Validasi->cek_dok_masuk($data);
		break;

		case 'cek_opname_thn_lalu':
		$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);
		$thn_ang = $_SESSION['thn_ang'];
		
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang
				);
		$Validasi->cek_opname_thn_lalu($data);
		break;		

		case 'cek_tutup_tahun':
		$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);
		$thn_ang = $_SESSION['thn_ang'];
		
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang
				);
		$Validasi->cek_tutup_tahun($data);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>