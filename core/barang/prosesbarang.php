<?php
include('../../model/modelBarang.php');
include('../../config/purifier.php');
$Barang = new modelBarang();
session_start();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readsskel':
				$Barang->bacasskel();
		break;

		case 'addbarang':
			$kdbarang = $purifier->purify($_POST['kdsskel']);
			$kd_jbrg = $purifier->purify($_POST['kodebarang']);
			$kd_brg = $kdbarang.''.$kd_jbrg;
			$nm_brg = $purifier->purify($_POST['namabarang']);
			$satuan = $purifier->purify($_POST['satuan']);
			$kd_lokasi = $_SESSION['kd_lok'];

			$data = array(
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,
				"kd_perk" => "sementara",
		    	"kd_lokasi" => $kd_lokasi
		    );
			$Barang->tambahbrg($data);
		break;


		case 'ubahbarang':
			$kdbarang = $purifier->purify($_POST['kdbarang']);
			$kd_jbrg = $purifier->purify($_POST['kd_jbrg']);
			$kd_brg = $kdbarang.''.$kd_jbrg;
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