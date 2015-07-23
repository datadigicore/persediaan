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
		case 'addbarang':
			$kd_kbrg = $_POST['kdsskel'];
			$kd_jbrg = $_POST['kdbarang'];
			$kd_brg = $kd_kbrg+$kd_jbrg;
			$nm_brg = $_POST['nmbarang'];
			$satuan = $_POST['satuan'];
			$sql="insert into brg (kd_kbrg, kd_jbrg, kd_brg, nm_brg, satuan, kd_perk, kd_lokasi) values ('$kd_kbrg','$kd_jbrg','$kd_kbrg','$nm_brg','$satuan','aaa','aaaa')";
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