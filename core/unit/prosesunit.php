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
			$Unit->bacasatker();
		break;
		case 'addunit':
			$kdsektor = $purifier->purify(substr($_POST['kdsatker'], 0, 2));
			$kdsatker = $purifier->purify(substr($_POST['kdsatker'], -2));
			$kdunit = $purifier->purify($_POST['kdunit']);
			$nmunit = $purifier->purify($_POST['nmunit']);
			$data = array(
				"kd_sektor" => $kdsektor,
				"kd_satker" => $kdsatker,
				"kd_unit" => $kdunit,
			  	"nm_unit" => $nmunit
			);
			$Unit->tambahunit($data);
		break;
		case 'updunit':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$kdsatker = $purifier->purify($_POST['updkdsatker']);
			$kdunit = $purifier->purify($_POST['updkdunit']);
			$nmunit = $purifier->purify($_POST['updurunit']);
			$data = array(
				"id" => $id,
				"kd_sektor" => $kdsektor,
				"kd_satker" => $kdsatker,
				"kd_unit" => $kdunit,
		    	"nm_unit" => $nmunit
		    );
			$Unit->ubahunit($data);
		break;
		case 'delunit':
			$id = $purifier->purify($_POST['id']);
			$idunit = $purifier->purify($_POST['idunit']);
			$data = array(
				"id" => $id,
				"idunit" => $idunit
		    );
			$Unit->hapusunit($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>