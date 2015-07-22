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
		case 'readuapb':
			$sql='select * from uapb';
			$result = $connect->query($sql);
			echo '<option value="">-- Select Kode UAPB --</option>';
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uapb'].' '.$row['nm_uapb']."</option>";
			}		
		break;
		case 'readtable':
			$kodeuapb = $_POST['kodeuapb'];
			$sql = "select * from uappbe1 where kd_uapb = '$kodeuapb'";
			$result = $connect->query($sql);
			while ($row = mysqli_fetch_assoc($result))
			{
				$rows[] = [$row['kd_uapb'],$row["kd_uappbe1"],$row["nm_uappbe1"]];
			}
			echo json_encode($rows);		
		break;
		case 'adduappbe':
			$kodeuapb = $_POST['kduapb'];
			$kodeuappbe = $_POST['kduappbe'];
			$uraianuappbe = $_POST['uraianuappbe'];
			$sql="insert into uappbe1 (kd_uapb,kd_uappbe1,nm_uappbe1) values ('$kodeuapb','$kodeuappbe','$uraianuappbe')";
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