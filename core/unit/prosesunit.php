<?php
include('../../model/modelunit.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$Unit = new modelUnit();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readsatker':
			$tahun = $_SESSION['thn_ang'];
			$Unit->bacasatker($tahun);
		break;
		case 'addunit':
			$kdsektor = $purifier->purify(substr($_POST['kdsatker'], 0, 2));
			$kdsatker = $purifier->purify(substr($_POST['kdsatker'], -2));
			$kdunit = $purifier->purify($_POST['kdunit']);
			$nmunit = $purifier->purify($_POST['nmunit']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"kd_sektor" => $kdsektor,
				"kd_satker" => $kdsatker,
				"kd_unit" => $kdunit,
			  	"nm_unit" => $nmunit,
			  	"tahun" => $tahun
			);
			$Unit->tambahunit($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "T-Unit";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $kdsektor.".".$kdsatker.".".$kdunit,
		    	"nm_sektor" => $nmunit,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Unit->loghistory($datalog);
			//========= Log History =========//
		break;
		case 'updunit':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$kdsatker = $purifier->purify($_POST['updkdsatker']);
			$kdunit = $purifier->purify($_POST['updkdunit']);
			$nmunit = $purifier->purify($_POST['updurunit']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"id" => $id,
				"kd_sektor" => $kdsektor,
				"kd_satker" => $kdsatker,
				"kd_unit" => $kdunit,
		    	"nm_unit" => $nmunit
		    );
			$Unit->ubahunit($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "U-Unit";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $kdsektor.".".$kdsatker.".".$kdunit,
		    	"nm_sektor" => $nmunit,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Unit->loghistory($datalog);
			//========= Log History =========//
		break;
		case 'delunit':
			$id = $purifier->purify($_POST['id']);
			$idunit = $purifier->purify($_POST['idunit']);
			$nmunit = $purifier->purify($_POST['nmunit']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"id" => $id,
				"idunit" => $idunit
		    );
			$Unit->hapusunit($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "H-Unit";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $idunit,
		    	"nm_sektor" => $nmunit,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Unit->loghistory($datalog);
			//========= Log History =========//
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>