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
		case 'adduapb':
			$kodeuapb = $_POST['kodeuapb'];
			$uraianuapb = $_POST['uraianuapb'];
			$sql="insert into uapb (kd_uapb,nm_uapb) values ('$kodeuapb','$uraianuapb')";
			if ($connect->query($sql) === TRUE)
			{
			    echo "Data Berhasil Ditambahkan";
			}
			else
			{
			    echo "Error: " . $sql . "<br>" . $connect->error;
			}
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>