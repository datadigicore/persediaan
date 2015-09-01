<?php
include('../../model/modelDashboard.php');
include('../../config/admin.php');
$Dashboard = new modelDashboard();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage) {
		case 'countdata':
			$Dashboard->countdata();
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>
