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
		case 'countdata':
			$sql1="select * from uapb";
			$sql2="select * from uappbe1";
			$sql3="select * from uappbw";
			$sql4="select * from uakpb";
			$totaluapb = mysqli_num_rows($connect->query($sql1));
			$totaluappbe = mysqli_num_rows($connect->query($sql2));
			$totaluappbw = mysqli_num_rows($connect->query($sql3));
			$totaluakpb = mysqli_num_rows($connect->query($sql4));
			echo json_encode(array("uapb"=>$totaluapb,"uappbe"=>$totaluappbe,"uappbw"=>$totaluappbw,"uakpb"=>$totaluakpb));
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>