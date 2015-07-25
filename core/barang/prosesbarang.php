<?php
include('../../model/modelBarang.php');
include('../../config/purifier.php');
$Barang = new modelBarang();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'addbarang':
			$kd_kbrg = $purifier->purify($_POST['kd_kbrg']);
			$kd_jbrg = $purifier->purify($_POST['kd_jbrg']);
			$kd_brg = $kd_kbrg+$kd_jbrg;
			$nm_brg = $purifier->purify($_POST['nm_barang']);
			$satuan = $purifier->purify($_POST['satuan']);
			$kd_perk = $purifier->purify($_POST['kd_perk']);
			$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);

			$data = array(
				"kd_kbrg" => $kd_kbrg,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,
				"kd_perk" => $kd_perk,
		    	"kd_lokasi" => $kd_lokasi
		    	 );
			$Barang->tambahbarang($data);

		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>