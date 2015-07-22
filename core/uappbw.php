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
			echo '<option value="">-- Pilih Kode UAPB --</option>';
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uapb'].' '.$row['nm_uapb']."</option>";
			}		
		break;
		case 'readuappbe':
			$kodeuapb = $_POST["kodeuapb"];
			$sql = "select kd_uappbe1, nm_uappbe1 from uappbe1 where kd_uapb = '$kodeuapb'";
			$result = $connect->query($sql);
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_uappbe1'].'">'.$row['kd_uappbe1'].' '.$row['nm_uappbe1']."</option>";
			}		
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>