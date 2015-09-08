<?php
include('../../model/modelDashboard.php');
$Dashboard = new modelDashboard();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage) {
		case 'readtahun':
			$Dashboard->bacatahun();
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>
