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

		case 'cekbarang':

			$kdbarang = $purifier->purify($_POST['sskel_row']);
			$kd_jbrg = $purifier->purify($_POST['kdbrg_row']);
			$kd_brg = $kdbarang.''.$kd_jbrg;
			$kd_lokasi = $_SESSION['kd_lok'];
			$data = array(
				"kd_brg" => $kd_brg,
		    	"kd_lokasi" => $kd_lokasi
		    );
			$Barang->cek_barang($data);
		break;

		case 'addbarang':
			$kdbarang = $purifier->purify($_POST['kdsskel']);
			$kd_jbrg = $purifier->purify($_POST['kodebarang']);
			$kd_brg = $kdbarang.''.$kd_jbrg;
			$nm_brg = $purifier->purify($_POST['namabarang']);
			$satuan = $purifier->purify($_POST['satuan']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$user_id = $_SESSION['username'];

			$data = array(
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,
				"kd_perk" => "0",
				"nm_satker" => $nm_satker,
				"user_id" => $user_id,
		    	"kd_lokasi" => $kd_lokasi
		    );
			$Barang->tambahbrg($data);
		break;


		case 'updbarang':
			$id = $purifier->purify($_POST['id']);
			$kdbarang = $purifier->purify($_POST['updkdsskel']);
			$kd_jbrg = $purifier->purify($_POST['updkdbrg']);
			$kd_brg = $kdbarang.''.$kd_jbrg;
			$nm_brg = $purifier->purify($_POST['updnmbrg']);
			$satuan = $purifier->purify($_POST['updsatbrg']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$user_id = $_SESSION['username'];

			$data = array(
				"id" => $id,
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,
				"nm_satker" => $nm_satker,
				"user_id" => $user_id,
		    	"kd_lokasi" => $kd_lokasi
		    );
		    // print_r($data);
			$Barang->ubah_barang($data);
		break;

		case 'hapusbarang':
			$id = $purifier->purify($_POST['id']);

			$data = array(
				"id" => $id,
		    );
			$Barang->hapusbarang($data);
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>