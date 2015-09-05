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
			$jenis = $purifier->purify($_POST['jenis']);
			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$bulan = $purifier->purify($_POST['bulan']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$user_id= $_SESSION['username'];
			$data = array(
				"jenis"=>$jenis,
				"bulan"=>$bulan,
				"kd_brg" => $kd_brg,
				"thn_ang" => $thn_ang,
				"tgl_awal" => $tgl_awal,
				"tgl_akhir" => $tgl_akhir,
				"kd_lokasi" => $_SESSION['kd_lok'],
				"user_id" => $user_id
			   );
			$Report->buku_persediaan($data);
		break;

		case 'lap_persediaan':
			$jenis = $purifier->purify($_POST['jenis']);
			$semester = explode("-",$purifier->purify($_POST['smt']));
			$bln_awal = $semester[0];
			$bln_akhir = $semester[1];
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$user_id= $_SESSION['username'];
			$data = array(
			"jenis"=>$jenis,
			"bln_awal"=>$bln_awal,
			"bln_akhir"=>$bln_akhir,
			"thn_ang" => $thn_ang,
			"kd_brg" => $kd_brg,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $_SESSION['kd_lok'],
			"user_id" => $user_id);
			$Report->laporan_persediaan($data);
		break;

		case 'rincian':
			$jenis = $purifier->purify($_POST['jenis']);
			$semester = explode("-",$purifier->purify($_POST['smt']));
			$bln_awal = $semester[0];
			$bln_akhir = $semester[1];
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$user_id= $_SESSION['username'];
			$data = array(
			"jenis"=>$jenis,
			"bln_awal"=>$bln_awal,
			"bln_akhir"=>$bln_akhir,
			"thn_ang" => $thn_ang,
			"kd_brg" => $kd_brg,
			"tgl_awal" => $tgl_awal,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $_SESSION['kd_lok'],
			"user_id" => $user_id);
			$Report->rincian_persediaan($data);
		break;		

		case 'neraca':
			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$user_id= $_SESSION['username'];
			$data = array(
			"kd_brg" => $kd_brg,
			"thn_ang" => $thn_ang,
			"tgl_awal" => $tgl_awal,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $_SESSION['kd_lok'],
			"user_id" => $user_id);
			$Report->neraca($data);
		break;

		case 'mutasi':
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$user_id= $_SESSION['username'];
			$data = array(
			"thn_ang" => $thn_ang,
			"kd_brg" => $kd_brg,
			"tgl_awal" => $tgl_awal,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $_SESSION['kd_lok'],
			"user_id" => $user_id);
			$Report->mutasi_prsedia($data);
		break;

		case 'transaksi':
			$jenis = $purifier->purify($_POST['jenis']);

			$trans = $purifier->purify($_POST['jenis_trans']);
			$detil_trans = explode("-", $trans);
			$kd_trans = $detil_trans[0];
			$nm_trans = $detil_trans[1];

			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$bulan = $purifier->purify($_POST['bulan']);
			$tgl_awal = $purifier->purify($_POST['tgl_awal']);
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$user_id= $_SESSION['username'];
			$data = array(
				"jenis"=>$jenis,
				"kd_trans"=>$kd_trans,
				"nm_trans"=>$nm_trans,
				"bulan"=>$bulan,
				"thn_ang" => $thn_ang,
				"tgl_awal" => $tgl_awal,
				"tgl_akhir" => $tgl_akhir,
				"kd_lokasi" => $_SESSION['kd_lok'],
				"user_id" => $user_id
			   );
			$Report->transaksi_persediaan($data);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>