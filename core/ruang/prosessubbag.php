<?php
include('../../model/modelUpb.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$upb = new modelUpb();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readupb':
			$tahun = $_SESSION['thn_ang'];
			$upb->bacaunit($tahun);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>