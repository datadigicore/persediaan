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
		case 'readbrg':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$thn_ang = $_SESSION['thn_ang'];
			$data = array(
				"kd_lokasi"=>$kd_lokasi,
				"thn_ang" => $thn_ang
			   );
			$Report->bacabrg($data);
		break;
		
		case 'baca_satker':
		$kd_lokasi= $_SESSION['kd_lok'];
		$Report->baca_satker($kd_lokasi);
		break;		

		case 'baca_upb':
		$kd_lokasi= $_SESSION['kd_lok'];
		$Report->baca_upb($kd_lokasi);
		break;

		case 'baca_satker_admin':
		$search = $_POST['q'];
		$Report->baca_satker_admin($search);
		break;		

		case 'baca_upb_admin':
		$search = $_POST['q'];
		$Report->baca_upb_admin($search);
		break;
		
		case 'buku_persediaan':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$satker_asal = $_SESSION['kd_lok'];
			$jenis = $purifier->purify($_POST['jenis']);
			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$bulan = $purifier->purify($_POST['bulan']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$format = $purifier->purify($_POST['format']);
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$user_id= $_SESSION['username'];
			$data = array(
				"jenis"=>$jenis,
				"bulan"=>$bulan,
				"kd_brg" => $kd_brg,
				"thn_ang" => $thn_ang,
				"tgl_awal" => $tgl_awal,
				"tgl_akhir" => $tgl_akhir,
				"kd_lokasi" => $kd_lokasi,
				"satker_asal" => $satker_asal,
				"format" => $format,
				"user_id" => $user_id
			   );
			print_r($data);
			// if($kd_brg=="all" && $format=="pdf")
			// {
			// 	$Report->buku_persediaan_all($data);
			// }
			// elseif($kd_brg=="all" && $format=="excel")
			// {
			// 	$Report->buku_persediaan_all_excel($data);
			// }
			// elseif($format== "pdf")
			// {
			// 	$Report->buku_persediaan($data);
			// }
			// else
			// {
				$Report->buku_persediaan($data);
			// }
		break;

		case 'lap_persediaan':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$satker_asal = $purifier->purify($_POST['satker']);
			$jenis = $purifier->purify($_POST['jenis']);
			$semester = explode("-",$purifier->purify($_POST['smt']));
			$bln_awal = $semester[0];
			$bln_akhir = $semester[1];
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
			"kd_lokasi" => $kd_lokasi,
			"satker_asal" => $satker_asal,
			"format" => $format,
			"user_id" => $user_id);
		$Report->laporan_persediaan($data);

		break;

		case 'rincian':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$satker_asal = $_SESSION['kd_lok'];
			$jenis = $purifier->purify($_POST['jenis']);
			$lingkup = $purifier->purify($_POST['lingkup']);
			$semester = explode("-",$purifier->purify($_POST['smt']));
			$bln_awal = $semester[0];
			$bln_akhir = $semester[1];
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
			"kd_lokasi" => $kd_lokasi,
			"satker_asal" => $satker_asal,
			"lingkup" => $lingkup,
			"format" => $format,
			"user_id" => $user_id);
		print_r($data);
		$Report->rincian_persediaan2($data);
		break;		

		case 'neraca':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$satker_asal = $_SESSION['kd_lok'];
			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$lingkup = $purifier->purify($_POST['lingkup']);
			$format = $purifier->purify($_POST['format']);
			$user_id= $_SESSION['username'];
			$data = array(
			"jenis"=>"tanggal",
			"kd_brg" => $kd_brg,
			"thn_ang" => $thn_ang,
			"tgl_awal" => $tgl_awal,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $kd_lokasi,
			"satker_asal" => $satker_asal,
			"lingkup" => $lingkup,
			"format" => $format,
			"user_id" => $user_id);
			// print_r($data);
		$Report->neraca($data);

		break;

		case 'mutasi':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$satker_asal = $_SESSION['kd_lok'];
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$user_id= $_SESSION['username'];
			$data = array(
			"jenis" => "tanggal",
			"thn_ang" => $thn_ang,
			"kd_brg" => $kd_brg,
			"tgl_awal" => $tgl_awal,
			"tgl_akhir" => $tgl_akhir,
			"kd_lokasi" => $kd_lokasi,
			"satker_asal" => $satker_asal,
			"format" => $format,
			"user_id" => $user_id);
			// print_r($data);

		$Report->mutasi_prsedia($data);
			

			
		break;

		case 'transaksi':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$satker_asal = $_SESSION['kd_lok'];
			$jenis = $purifier->purify($_POST['jenis']);

			$trans = $purifier->purify($_POST['jenis_trans']);
			$detil_trans = explode("-", $trans);
			$kd_trans = $detil_trans[0];
			$nm_trans = $detil_trans[1];

			$thn_ang = $purifier->purify($_SESSION['thn_ang']);
			$bulan = $purifier->purify($_POST['bulan']);
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir = $purifier->purify($_POST['tgl_akhir']);
			$format = $purifier->purify($_POST['format']);
			$user_id= $_SESSION['username'];
			$data = array(
				"jenis"=>$jenis,
				"kd_trans"=>$kd_trans,
				"nm_trans"=>$nm_trans,
				"bulan"=>$bulan,
				"thn_ang" => $thn_ang,
				"tgl_awal" => $tgl_awal,
				"tgl_akhir" => $tgl_akhir,
				"kd_lokasi" => $kd_lokasi,
				"satker_asal" => $satker_asal,
				"format" => $format,
				"user_id" => $user_id
			   );
				$Report->transaksi_persediaan($data);

			
		break;

		case 'l_terima_brg':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			// $satker_asal = $_SESSION['kd_lok'];
			// $jenis = $purifier->purify($_POST['jenis']);
			// $semester = explode("-",$purifier->purify($_POST['smt']));
			// $bln_awal = $semester[0];
			// $bln_akhir = $semester[1];
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
				"kd_lokasi" => $kd_lokasi,
				"satker_asal" => $satker_asal,
				"user_id" => $user_id);

			$Report->l_terima_brg($data);
		break;
		
		case 'l_keluar_brg':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			// $satker_asal = $_SESSION['kd_lok'];
			// $jenis = $purifier->purify($_POST['jenis']);
			// $semester = explode("-",$purifier->purify($_POST['smt']));
			// $bln_awal = $semester[0];
			// $bln_akhir = $semester[1];
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
				"kd_lokasi" => $kd_lokasi,
				"satker_asal" => $satker_asal,
				"user_id" => $user_id);

			$Report->l_keluar_brg($data);
		break;

		case 'l_buku_bph':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			// $satker_asal = $_SESSION['kd_lok'];
			// $jenis = $purifier->purify($_POST['jenis']);
			// $semester = explode("-",$purifier->purify($_POST['smt']));
			// $bln_awal = $semester[0];
			// $bln_akhir = $semester[1];
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
				"kd_lokasi" => $kd_lokasi,
				"satker_asal" => $satker_asal,
				"user_id" => $user_id);

			$Report->buku_bph($data);
		break;		

		case 'l_kartu_brg':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			// $satker_asal = $_SESSION['kd_lok'];
			// $jenis = $purifier->purify($_POST['jenis']);
			// $semester = explode("-",$purifier->purify($_POST['smt']));
			// $bln_awal = $semester[0];
			// $bln_akhir = $semester[1];
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
				"kd_lokasi" => $kd_lokasi,
				"satker_asal" => $satker_asal,
				"user_id" => $user_id);

			$Report->kartu_barang($data);
		break;		

		case 'l_kartu_p_brg':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			// $satker_asal = $_SESSION['kd_lok'];
			// $jenis = $purifier->purify($_POST['jenis']);
			// $semester = explode("-",$purifier->purify($_POST['smt']));
			// $bln_awal = $semester[0];
			// $bln_akhir = $semester[1];
			$tgl_awal =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_awal']));
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
				"kd_lokasi" => $kd_lokasi,
				"satker_asal" => $satker_asal,
				"user_id" => $user_id);

			$Report->kartu_p_barang($data);
		break;

		case 'l_pp_bph':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$satker_asal = $_SESSION['kd_lok'];
			$jenis = $purifier->purify($_POST['jenis']);
			$semester = explode("-",$purifier->purify($_POST['smt']));
			$bln_awal = $semester[0];
			$bln_akhir = $semester[1];
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
						"kd_lokasi" => $kd_lokasi,
						"semester" => $bln_akhir,
						"satker_asal" => $satker_asal,
						"user_id" => $user_id);
			$Report->l_pp_bph($data);

		break;		

		case 'ba_opname':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$satker_asal = $_SESSION['kd_lok'];
			$jenis = $purifier->purify($_POST['jenis']);
			$semester = explode("-",$purifier->purify($_POST['smt']));
			$bln_awal = $semester[0];
			$bln_akhir = $semester[1];
			$tgl_akhir =  $Report->konversi_tanggal($purifier->purify($_POST['tgl_akhir']));
			$format = $purifier->purify($_POST['format']);
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
						"kd_lokasi" => $kd_lokasi,
						"semester" => $bln_akhir,
						"satker_asal" => $satker_asal,
						"user_id" => $user_id);
			$Report->ba_opname($data);

		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>