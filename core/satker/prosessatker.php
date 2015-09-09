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
		case 'checkkdsatker':
			$kdsektor = urldecode($_POST['kdsektor']);
			$kdsatker = urldecode($_POST['kdsatker']);
			$data = array(
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker
			);
			$Satker->bacakdsatker($data);
		break;
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
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "T-Satker";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $kdsektor.".".$kdsatker,
		    	"nm_sektor" => $nmsatker,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Satker->loghistory($datalog);
			//========= Log History =========//
		break;
		case 'updsatker':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$kdsatker = $purifier->purify($_POST['updkdsatker']);
			$nmsatker = $purifier->purify($_POST['updursatker']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"id" => $id,
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker,
		    	"namasatker" => $nmsatker
		    );
			$Satker->ubahsatker($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "U-Satker";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $kdsektor.".".$kdsatker,
		    	"nm_sektor" => $nmsatker,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Satker->loghistory($datalog);
			//========= Log History =========//
		break;
		case 'delsatker':
			$id = $purifier->purify($_POST['id']);
			$idsatker = $purifier->purify($_POST['idsatker']);
			$nmsatker = $purifier->purify($_POST['nmsatker']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"id" => $id,
				"idsatker" => $idsatker
		    );
			$Satker->hapussatker($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "H-Satker";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $idsatker,
		    	"nm_sektor" => $nmsatker,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Satker->loghistory($datalog);
			print_r($_POST);
			//========= Log History =========//
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>