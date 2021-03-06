<?php
include('../../model/modelgudang.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$Gudang = new modelGudang();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readunit':
			$tahun = $_SESSION['thn_ang'];
			$Gudang->bacaunit($tahun);
		break;
		case 'addgudang':
			$row      = explode('.', $_POST['kdunit']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"kodesektor" => $row[0],
				"kodesatker" => $row[1],
				"kodeunit"   => $row[2],
				"gudang"     => $purifier->purify($_POST['kdgudang']),
				"namagudang" => $purifier->purify($_POST['nmgudang']),
				"tahun"      => $_SESSION['thn_ang']
			);
			$Gudang->tambahgudang($data);
			//========= Log History =========//
			$datalog = array(
				"kdlokasiuser" => $_SESSION['kd_lok'],
				"nmsatkeruser" => $_SESSION['nama_satker'],
				"username"     => $_SESSION['username'],
				"kd_sektor"    => $row[0].".".$row[1].".".$row[2].".".$purifier->purify($_POST['kdgudang']),
				"nm_sektor"    => $purifier->purify($_POST['nmgudang']),
				"tahun"        => $_SESSION['thn_ang'],
				"aksi"         => "T-Gudang",
				"tanggal"      => date("Y-m-d h:i:sa")
		    );
			$Gudang->loghistory($datalog);
			//========= Log History =========//
		break;
		case 'updgudang':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$kdsatker = $purifier->purify($_POST['updkdsatker']);
			$kdunit = $purifier->purify($_POST['updkdunit']);
			$kdgudang = $purifier->purify($_POST['updkdgudang']);
			$nmgudang = $purifier->purify($_POST['updnmgudang']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"id" => $id,
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker,
				"kodeunit" => $kdunit,
				"kodegudang" => $kdgudang,
			  	"namagudang" => $nmgudang,
			);
			$Gudang->ubahgudang($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "U-Gudang";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $kdsektor.".".$kdsatker.".".$kdunit.".".$kdgudang,
		    	"nm_sektor" => $nmgudang,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Gudang->loghistory($datalog);
			//========= Log History =========//
		break;
		case 'delgudang':
			$id = $purifier->purify($_POST['id']);
			$idgudang = $purifier->purify($_POST['idgudang']);
			$nmgudang = $purifier->purify($_POST['nmgudang']);
			$tahun = $_SESSION['thn_ang'];
			$Gudang->hapusgudang($id);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "H-Gudang";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $idgudang,
		    	"nm_sektor" => $nmgudang,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Gudang->loghistory($datalog);
			//========= Log History =========//
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>