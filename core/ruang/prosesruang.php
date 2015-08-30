<?php
include('../../model/modelruang.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$Ruang = new modelRuang();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readunit':
			$Ruang->bacaunit();
		break;
		case 'addruang':
			$kdsektor = $purifier->purify(substr($_POST['kdunit'], 0, 2));
			$kdsatker = $purifier->purify(substr($_POST['kdunit'], 3, 2));
			$kdunit = $purifier->purify(substr($_POST['kdunit'], -2));
			$kdruang = $purifier->purify($_POST['kdruang']);
			$kdgudang = $purifier->purify($_POST['kdgudang']);
			$nmruang = $purifier->purify($_POST['nmruang']);
			$data = array(
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker,
				"kodeunit" => $kdunit,
				"koderuang" => $kdruang,
				"gudang" => $kdgudang,
				"namaruang" => $nmruang
			);
			$Ruang->tambahruang($data);
			print_r($data);
		break;
		case 'updruang':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$kdsatker = $purifier->purify($_POST['updkdsatker']);
			$kdunit = $purifier->purify($_POST['updkdunit']);
			$kdruang = $purifier->purify($_POST['updkdruang']);
			$kdgudang = $purifier->purify($_POST['updkdgudang']);
			$nmruang = $purifier->purify($_POST['updnmruang']);
			$data = array(
				"id" => $id,
				"kodesektor" => $kdsektor,
				"kodesatker" => $kdsatker,
				"kodeunit" => $kdunit,
				"koderuang" => $kdruang,
				"kodegudang" => $kdgudang,
			  	"namaruang" => $nmruang,
			);
			$Ruang->ubahruang($data);
		break;
		case 'delruang':
			$id = $purifier->purify($_POST['id']);
			$Ruang->hapusruang($id);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>