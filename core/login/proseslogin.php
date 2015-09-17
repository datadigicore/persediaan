<?php
include('../../model/modelDashboard.php');
include('../../config/purifier.php');
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

		case 'check_tahun':
			$username = $purifier->purify($_POST['keyword']);
			if ($username == "masteradmin") {
				$Dashboard->bacatahun();
			}
			else{
				$Dashboard->check_tahun($username);
			}			
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>
