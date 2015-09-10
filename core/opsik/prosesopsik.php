<?php
include('../../model/modelOpsik.php');
include('../../config/purifier.php');
$Opsik = new modelOpsik();
session_start();


function konversi_tanggal($tgl)
{
	$data_tgl = explode("-",$tgl);
	$array = array($data_tgl[2],$data_tgl[1],$data_tgl[0]);
	$tanggal = implode("/", $array );
	return $tanggal;
}

if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}


else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{

		case 'readdok':
			$Opsik->bacadok();
		break;		

		case 'readbrg':

		$kd_lokasi = $_SESSION['kd_lok'];
		$thn_ang = $_SESSION['thn_ang'];
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang
		);
			$Opsik->baca_persediaan_masuk($data);
		break;

		case 'tbh_opname':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_lok_msk = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];

			$no_dok = $kd_lokasi.$purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $Opsik->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Opsik->konversi_tanggal($purifier->purify($_POST['tgl_buku']));

			$jns_trans = $_POST['jenis_trans'];
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$status = 1;
			$user_id = $_SESSION['username'];

			
			
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"kd_brg" => $kd_brg,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"jns_trans" => $jns_trans,
				"keterangan" => $keterangan,
				"status" => $status,
				"user_id" => $user_id
			);

			// print_r($data);
			$Opsik->tbh_opname($data);
		break;		

		case 'ubahopsik':
			$thnang = $purifier->purify($_POST['thnang']);
			$kdlokasi = $purifier->purify($_POST['kdlokasi']);
			$kdbrg = $purifier->purify($_POST['kdbrg']);
			$tglbuku = $purifier->purify($_POST['tgldok']);
			$nodok = $purifier->purify($_POST['nodok']);
			$nobukti = $purifier->purify($_POST['nobukti']);
			$kuantitas = $purifier->purify($_POST['kuantitas']);
			$rphsat = $purifier->purify($_POST['srphsat']);

			$data = array(
				"thn_ang" => $thang,
				"kd_lokasi" => $kdlokasi,
				"kd_brg" => $kdbrg,
				"tglbuku" => $tglbuku,
				"nodok" => $nodok,
				"no_bukti" => $nobukti,
		    	"kuantitas" => $kuantitas,
		    	"rph_sat" => $rphsat
		    );
			$Opsik->ubahopsik($data);
		break;

		case 'hapusOpname':
			$id = $purifier->purify($_POST['id']);
			$user_id = $_SESSION['username'];
			$kd_lokasi = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];

			$data = array(
				"id" => $id,
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"user_id" => $user_id
			);

			$Opsik->hapus_opname($data);
		break;	
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}


}
?>