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
		case 'adduakpb':
			$kodeuapb = $_POST['kodeuapb'];
			$kodeuappbe1 = $_POST['kodeuappbe1'];
			$kodeuappbw = $_POST['kodeuappbw'];
			$kodeuakpb = $_POST['kodeuakpb'];
			$kodeuapkpb = $_POST['kodeuapkpb'];
			$kodejk = $_POST['kodejk'];
			$uraianuakpb = $_POST['uraianuakpb'];

			$sql="insert into uakpb  values ('$kodeuapb','$kodeuappbe1','$kodeuappbw','$kodeuakpb','$kodeuapkpb','$kodejk','$uraianuakpb','asasasas')";
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