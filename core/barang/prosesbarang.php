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

		case 'cekkode':
			$kdbarang = $purifier->purify($_POST['kdsskel']);
			$kd_jbrg = $purifier->purify($_POST['kodebarang']);
			$kd_brg = $kdbarang.'.'.$kd_jbrg;
			$kd_lokasi = $_SESSION['kd_lok'];
			$data = array(
				"kd_brg" => $kd_brg,
		    	"kd_lokasi" => $kd_lokasi
		    );
			$Barang->cek_kd_barang($data);
		break;

		case 'readsskel':
			$Barang->bacasskel();
		break;

		case 'readbarang':
			$search = $_POST['q'];
			$Barang->bacabarang($search);
		break;

		case 'readsatuan':
			$search = $_POST['q'];
			$Barang->bacassatuan($search);
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

		case 'addsubbarang':
			$nokdbarang = $purifier->purify($_POST['kdbarang_no']);
			$kdbarang = $nokdbarang.'.'.$purifier->purify($_POST['kdbarang']);
			$nmbarang = $purifier->purify($_POST['nmbarang']);
			$spesifikasi = $purifier->purify($_POST['spesifikasi']);
			$satuan = $purifier->purify($_POST['satuan']);
			$data = array(
				"kdbrg" => $kdbarang,
				"nmbrg" => $nmbarang,
				"spesifikasi" => $spesifikasi,
				"satuan" => $satuan,
		    );
		    print_r($data);
			$Barang->tambahsubbrg($data);
			$datalog = array(
				"kd_brg" => $kdbarang,
				"nm_brg" => $nmbarang,
				"spesifikasi" => $spesifikasi,
				"satuan" => $satuan,
				"aksi" => "T-Persediaan"
		    );
			$Barang->loghistory($datalog);			
		break;

		case 'addbarang':
			$kdbarang = $purifier->purify($_POST['kdsskel']);
			$kd_jbrg = $purifier->purify($_POST['kodebarang']);
			$kd_brg = $kdbarang.''.$kd_jbrg;
			$nm_brg = $purifier->purify($_POST['namabarang']);
			$satuan = $purifier->purify($_POST['satuan']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_satker = $purifier->purify($_POST['readsatker']);
			$nm_satker = $_SESSION['nama_satker'];
			$user_id = $_SESSION['username'];
			$tanggal = date("Y-m-d h:i:sa");

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
		    	"kd_lokasi" => $kd_satker
		    );
			$Barang->tambahbrg($data);
			$datalog = array(
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"user_id" => $user_id,
				"aksi" => "T-Persediaan",
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,	
				"tanggal" => $tanggal
		    	
		    );
        	
			$Barang->loghistory($datalog);			
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
			$tanggal = date("Y-m-d h:i:sa");

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

			$datalog = array(
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"user_id" => $user_id,
				"aksi" => "U-Persediaan",
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,	
				"tanggal" => $tanggal
		    	
		    );
        	
			$Barang->loghistory($datalog);
		break;

		case 'updsubbarang':
			$id = $purifier->purify($_POST['id']);
			$kdbarang = $purifier->purify($_POST['updkdbarang']);
			$nmbarang = $purifier->purify($_POST['updurbarang']);
			$spesifikasi = $purifier->purify($_POST['updspesifikasi']);
			$satuan = $purifier->purify($_POST['updsatuan']);
			$data = array(
				"id" => $id,
				"kdbrg" => $kdbarang,
				"nmbrg" => $nmbarang,
				"spesifikasi" => $spesifikasi,
				"satuan" => $satuan,
		    );
		    // print_r($data);
			$Barang->ubahsubbrg($data);
			$datalog = array(
				"kdbrg" => $kdbarang,
				"nmbrg" => $nmbarang,
				"spesifikasi" => $spesifikasi,
				"satuan" => $satuan,
				"aksi" => "U-Persediaan"
		    );
			$Barang->loghistory($datalog);
		break;

		case 'hapusbarang':
			$id = $purifier->purify($_POST['id']);
			$kdbarang = $purifier->purify($_POST['sskel_row']);
			$kd_jbrg = $purifier->purify($_POST['kdbrg_row']);
			$kd_brg = $kdbarang.''.$kd_jbrg;
			$nm_brg = $purifier->purify($_POST['nmbrg_row']);
			$satuan = $purifier->purify($_POST['satuan_row']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$user_id = $_SESSION['username'];
			$tanggal = date("Y-m-d h:i:sa");

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
			$Barang->hapusbarang($data);

						$datalog = array(
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"user_id" => $user_id,
				"aksi" => "H-Persediaan",
				"kd_kbrg" => $kdbarang,
				"kd_jbrg" => $kd_jbrg,
				"kd_brg" => $kd_brg,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,	
				"tanggal" => $tanggal
		    	
		    );
			$Barang->loghistory($datalog);
		break;
		case 'delbarang':
			$id = $purifier->purify($_POST['id']);
			$idbarang = $purifier->purify($_POST['idbrg']);
			$nmbarang = $purifier->purify($_POST['urbrg']);
			$data = array(
				"id" => $id
		    );
			$Barang->hapusbarang($data);
			//========= Log History =========//
			$kdlokasiuser = $_SESSION['kd_lok'];
			$nmsatkeruser = $_SESSION['nama_satker'];
			$username = $_SESSION['username'];
			$aksi = "H-Satker";
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kdlokasiuser" => $kdlokasiuser,
				"nmsatkeruser" => $nmsatkeruser,
				"username" => $username,
				"kd_sektor" => $idsatker,
		    	"nm_sektor" => $nmsatker,
		    	"tahun" => $tahun,
		    	"aksi" => $aksi,
		    	"tanggal" => $tanggal
		    );
			$Barang->loghistory($datalog);
			print_r($_POST);
			//========= Log History =========//
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>