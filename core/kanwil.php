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
		case 'addkanwil':
			$kodeuapb = $_POST['kodeuapb'];
			$kodeuappbe1 = $_POST['kodeuappbe1'];
			$kodekanwil = $_POST['kodekanwil'];
			$uraiankanwil = $_POST['uraiankanwil'];
			$sql="insert into kanwil  values ('$kodeuapb','$kodeuappbe1','$kodekanwil','$uraiankanwil')";
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