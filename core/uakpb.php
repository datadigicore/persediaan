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
			// $sql='select uappbw.kd_uapb as kd_uapb, uapb.nm_uapb as nm_uapb from uapb, uappbw where uappbw.kd_uapb = uapb.kd_uapb';
			$sql = 'select * from uapb';
			$result = $connect->query($sql);
			echo '<option value="">-- Pilih Kode UAPB --</option>';
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uapb'].' '.$row['nm_uapb']."</option>";
			}		
		break;
		case 'readuappbe':
			$kodeuapb = $_POST["kodeuapb"];
			$sql = "select y.kd_uapb, y.kd_uappb, x.nm_uappbe1 from (select kd_uapb, kd_uappbe1, nm_uappbe1 from uappbe1 where kd_uapb = '$kodeuapb') as x inner join (SELECT kd_uapb, kd_uappb FROM uappbw WHERE kd_uapb = '$kodeuapb') as y where x.kd_uappbe1 = y.kd_uappb";
			$result = $connect->query($sql);
			echo '<option value="">-- Pilih Kode UAPPB-E1 --</option>';
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_uappb'].'">'.$row['kd_uappb'].' '.$row['nm_uappbe1']."</option>";
			}		
		break;
		case 'readuappbw':
			$kodeuapb = $_POST["kodeuapb"];
			$kodeuappbe = $_POST["kodeuappbe"];
			$sql = "select kd_uappbw, nm_uappbw from uappbw where kd_uapb = '$kodeuapb' and kd_uappb = '$kodeuappbe'";
			$result = $connect->query($sql);
			echo '<option value="">-- Pilih Kode UAPPB-Wilayah --</option>';
			while ($row = mysqli_fetch_array($result))
			{
				echo '<option value="'.$row['kd_uappbw'].'">'.$row['kd_uappbw'].' '.$row['nm_uappbw']."</option>";
			}		
		break;
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