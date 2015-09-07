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
		break;
		case 'updsektor':
			$id = $purifier->purify($_POST['id']);
			$kdsektor = $purifier->purify($_POST['updkdsektor']);
			$nmsektor = $purifier->purify($_POST['updursektor']);
			$data = array(
				"id" => $id,
				"kd_sektor" => $kdsektor,
		    	"nm_sektor" => $nmsektor
		    );
			$Sektor->ubahsektor($data);
		break;
		case 'delsektor':
			$id = $purifier->purify($_POST['id']);
			$idsektor = $purifier->purify($_POST['idsektor']);
			$data = array(
				"id" => $id,
				"idsektor" => $idsektor
		    );
			$Sektor->hapussektor($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>