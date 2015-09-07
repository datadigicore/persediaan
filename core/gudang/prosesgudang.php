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
			$kdsektor = $purifier->purify(substr($_POST['kdunit'], 0, 2));
			$kdsatker = $purifier->purify(substr($_POST['kdunit'], 3, 2));
			$kdunit = $purifier->purify(substr($_POST['kdunit'], -2));
			$kdgudang = $purifier->purify($_POST['kdgudang']);
			$nmgudang = $purifier->purify($_POST['nmgudang']);
			$tahun = $_SESSION['thn_ang'];
			$data = array(
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker,
				"kodeunit" => $kdunit,
				"gudang" => $kdgudang,
				"namagudang" => $nmgudang,
				"tahun" => $tahun
			);
			$Gudang->tambahgudang($data);
			print_r($data);
		break;
		case 'updgudang':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$kdsatker = $purifier->purify($_POST['updkdsatker']);
			$kdunit = $purifier->purify($_POST['updkdunit']);
			$kdgudang = $purifier->purify($_POST['updkdgudang']);
			$nmgudang = $purifier->purify($_POST['updnmgudang']);
			$data = array(
				"id" => $id,
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker,
				"kodeunit" => $kdunit,
				"kodegudang" => $kdgudang,
			  	"namagudang" => $nmgudang,
			);
			$Gudang->ubahgudang($data);
		break;
		case 'delgudang':
			$id = $purifier->purify($_POST['id']);
			$Gudang->hapusgudang($id);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>