<?php
include('../config/dbconf.php');
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'totaluapb':
			$sql="select * from uapb";
			echo mysqli_num_rows($connect->query($sql));
		break;
		case 'totaluappbe':
			$sql="select * from uappbe1";
			echo mysqli_num_rows($connect->query($sql));
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>