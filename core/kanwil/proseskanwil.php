<?php
include('../../model/modelKanwil.php');
include('../../config/purifier.php');
$Kanwil = new modelKanwil();
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
			$kodeuapb = $purifier->purify($_POST['kodeuapb']);
			$kodeuappbe1 = $purifier->purify($_POST['kodeuappbe1']);
			$kodekanwil = $purifier->purify($_POST['kodekanwil']);
			$uraiankanwil = $purifier->purify($_POST['uraiankanwil']);

			$data = array(
				"kd_uapb" => $kodeuapb,
				"kd_uappbe1" => $kodeuappbe1,
				"kd_kanwil" => $kodekanwil,
		    	"nm_kanwil" => $uraiankanwil
		    );
			$Kanwil->tambahkanwil($data);

			// $sql="insert into kanwil  values ('$kodeuapb','$kodeuappbe1','$kodekanwil','$uraiankanwil')";
			// if ($connect->query($sql) === TRUE)
			// {
			//     echo "Data Berhasil Ditambahkan";
			// }
			// else
			// {
			//     echo "Error: " . $sql . "<br>" . $connect->error;
			// }
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>