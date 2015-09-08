<?php
include('../../model/modelsektor.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$Sektor = new modelSektor();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'addsektor':
			$kdsektor = $purifier->purify($_POST['kdsektor']);
			$nmsektor = $purifier->purify($_POST['nmsektor']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"kd_sektor" => $kdsektor,
		    	"nm_sektor" => $nmsektor,
		    	"tahun" => $tahun
		    );
			$Sektor->tambahsektor($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "T-Sektor";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $kdsektor,
		    	"nm_sektor" => $nmsektor,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Sektor->loghistory($datalog);
			//========= Log History =========//
		break;
		case 'updsektor':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$nmsektor = $purifier->purify($_POST['updursektor']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"id" => $id,
				"kd_sektor" => $kdsektor,
		    	"nm_sektor" => $nmsektor
		    );
			$Sektor->ubahsektor($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "U-Sektor";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $kdsektor,
		    	"nm_sektor" => $nmsektor,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Sektor->loghistory($datalog);
			//========= Log History =========//
		break;
		case 'delsektor':
			$id = $purifier->purify($_POST['id']);
			$idsektor = $purifier->purify($_POST['idsektor']);
			$nmsektor = $purifier->purify($_POST['nmsektor']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"id" => $id,
				"idsektor" => $idsektor
		    );
			$Sektor->hapussektor($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "H-Sektor";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $idsektor,
		    	"nm_sektor" => $nmsektor,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Sektor->loghistory($datalog);
			//========= Log History =========//
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>