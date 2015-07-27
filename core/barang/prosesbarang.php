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
			$nm_brg = $purifier->purify($_POST['nmbarang']);
			$satuan = $purifier->purify($_POST['satuan']);

			$data = array(
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nmbarang,
				"satuan" => $satuan,
				"kd_perk" => "sementara",
		    	"kd_lokasi" => "sementara"
		    );
			$Barang->tambahbarang($data);
		break;

		case 'readksskel':
				$kdsskel = $purifier->purify($_POST['kdkdsskel']);
				$Barang->$bacasskel($kdsskel);
		break;

		case 'ubahbarang':
			$kdbarang = $purifier->purify($_POST['kdbarang']);
			$kd_jbrg = $purifier->purify($_POST['kd_jbrg']);
			$kd_brg = $kdbarang+$kd_jbrg;
			$nm_brg = $purifier->purify($_POST['nmbarang']);
			$satuan = $purifier->purify($_POST['satuan']);

			$data = array(
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nmbarang,
				"satuan" => $satuan,
				"kd_perk" => "sementara",
		    	"kd_lokasi" => "sementara"
		    );
			$Barang->ubahbarang($data);
		break;

		case 'hapusbarang':
			$kdbarang = $purifier->purify($_POST['kdbarang']);
			$kd_jbrg = $purifier->purify($_POST['kd_jbrg']);
			$kd_brg = $kdbarang+$kd_jbrg;
			$nm_brg = $purifier->purify($_POST['nmbarang']);
			$satuan = $purifier->purify($_POST['satuan']);

			$data = array(
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nmbarang,
				"satuan" => $satuan,
				"kd_perk" => "sementara",
		    	"kd_lokasi" => "sementara"
		    );
			$Barang->hapusbarang($data);
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>