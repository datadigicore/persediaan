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
			echo '<option value="">-- Pilih Kode UAPPB-E1 --</option>';
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_uappbe1'].'">'.$row['kd_uappbe1'].' '.$row['nm_uappbe1']."</option>";
			}		
		break;
		case 'readwil':
			$sql='select * from wilayah';
			$result = $connect->query($sql);
			echo '<option value="">-- Pilih Kode Wilayah --</option>';
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_wil'].'">'.$row['kd_wil'].' '.$row['nm_wil']."</option>";
			}		
		break;
		case 'adduappbw':
			$kodeuapb = $_POST['kduapb'];
			$kodeuappbe = $_POST['kduappbe'];
			$kodeuappbw = $_POST['kduappbw'];
			$uraianuappbw = $_POST['uraianuappbw'];
			$sql="insert into uappbw (kd_uapb,kd_uappb,kd_uappbw,nm_uappbw) values ('$kodeuapb','$kodeuappbe','$kodeuappbw','$uraianuappbw')";
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