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
			$select = array();
			$sql='select * from uapb';
			$result = $connect->query($sql);
			echo '<option value="">-- Select Kode UAPB --</option>';
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uapb'].' '.$row['nm_uapb']."</option>";
			}		
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>