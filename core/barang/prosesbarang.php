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
			$kdbarang = $purifier->purify($_POST['kdbarang']);
			$kd_jbrg = $purifier->purify($_POST['kd_jbrg']);
			$kd_brg = $kdbarang+$kd_jbrg;
			$nmbarang = $purifier->purify($_POST['nmbarang']);
			$satuan = $purifier->purify($_POST['satuan']);
			$kd_perk = $purifier->purify($_POST['kd_perk']);
			$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);

			$data = array(
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nmbarang,
				"satuan" => $satuan,
				"kd_perk" => $kd_perk,
		    	"kd_lokasi" => $kd_lokasi
		    	 );
			$Barang->tambahbrg($data);

		break;

		case 'readsskel':
				$kdsskel = $purifier->purify($_POST['kdsskel']);
				$Barang->$bacasskel($kdsskel);
			
			break;

		case 'ubahbarang':
			$kdbarang = $purifier->purify($_POST['kdbarang']);
			$kd_jbrg = $purifier->purify($_POST['kd_jbrg']);
			$kd_brg = $kdbarang+$kd_jbrg;
			$nmbarang = $purifier->purify($_POST['nmbarang']);
			$satuan = $purifier->purify($_POST['satuan']);
			$kd_perk = $purifier->purify($_POST['kd_perk']);
			$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);

			$data = array(
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nmbarang,
				"satuan" => $satuan,
				"kd_perk" => $kd_perk,
		    	"kd_lokasi" => $kd_lokasi
		    	 );
			$Barang->ubahbarang($data);
			break;

		case 'hapusbarang':
			$kdbarang = $purifier->purify($_POST['kdbarang']);
			$kd_jbrg = $purifier->purify($_POST['kd_jbrg']);
			$kd_brg = $kdbarang+$kd_jbrg;
			$nmbarang = $purifier->purify($_POST['nmbarang']);
			$satuan = $purifier->purify($_POST['satuan']);
			$kd_perk = $purifier->purify($_POST['kd_perk']);
			$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);

			$data = array(
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nmbarang,
				"satuan" => $satuan,
				"kd_perk" => $kd_perk,
		    	"kd_lokasi" => $kd_lokasi
		    	 );
			$Barang->hapusbarang($data);

		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>