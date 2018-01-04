<?php
include('../../model/modelTransaksi.php');
include('../../config/purifier.php');
session_start();
$Transaksi = new modelTransaksi();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{

		case 'hapus_transfer':
			$data   =array(
				'id'      => $_POST['id'],
				'thn_ang' => $_SESSION['thn_ang'],
				'user_id' 	=> $_SESSION['username'],
				'kd_brg'  => $_POST['kd_brg']
	        	);
			$Transaksi->hapus_transfer_barang($data);
		break;
		case 'hapus_dokumen_masuk':
			$no_dok= $purifier->purify($_POST['no_dok']);
			$Transaksi->hapus_dokumen_masuk($no_dok);
		break;

		case 'hapus_dokumen_keluar':
			$no_dok= $purifier->purify($_POST['no_dok']);
			$Transaksi->hapus_dokumen_keluar($no_dok);
		break;

		case 'add_temp_item_trans_masuk':
			$result = $Transaksi->add_temp_item_trans_masuk();
			if ($result) {
				header('location:../../admin/trans_masuk');
			}
		break;

		case 'add_temp_item_trans_keluar':
			$result = $Transaksi->add_temp_item_trans_keluar();
			if ($result) {
				header('location:../../admin/trans_keluar');
			}
		break;

		case 'add_temp_item_trans_transfer':
			$result = $Transaksi->add_temp_item_trans_transfer();
			if ($result) {
				header('location:../../admin/transfer');
			}
		break;

		case 'checkErrorMessage':
			$Transaksi->check_error_message($_POST['jenis']);
		break;

		case 'update_rekening_barang':
		// echo "masuk";
		// exit;
			$id 			 = $purifier->purify($_POST['id']);
			$kd_rek_brg_baru = $purifier->purify($_POST['kd_rek_brg_baru']);
			$keterangan_baru = $purifier->purify($_POST['keterangan_baru']);

			$data = array(
				'id' => $id,
				'kd_rek_brg_baru' => $kd_rek_brg_baru,
				'keterangan_baru' => $keterangan_baru
				);
		// print_r($data);
		// exit;
			$Transaksi->update_data_rekening_barang($data);
		break;

		case 'update_rekening':
			$id 			 = $purifier->purify($_POST['id']);
			$nilai_baru 	 = $purifier->purify($_POST['nilai_baru']);
			$keterangan_baru = $purifier->purify($_POST['keterangan_baru']);

			$data = array(
				'id' => $id,
				'nilai_baru' => $nilai_baru,
				'keterangan_baru' => $keterangan_baru
				);
			$Transaksi->update_data_rekening($data);
		break;

		case 'batalkan_transfer':
			$id = $purifier->purify($_POST['id']);
			print_r($id);
			$Transaksi->hapus_usulan_transfer($id);
		break;

		case 'usulkan_transfer':
			$id = $purifier->purify($_POST['id']);
			print_r($id);
			$Transaksi->usulkan_transfer($id);
		break;

		case 'konfirmasi_transfer':
			foreach ($_POST['id'] as $key => $value) {
				$trf = $Transaksi->get_transfer_detail($value);
			// print_r($trf);
				$data = array(
						"id_brg_transfer" => $id,
						"kd_lokasi" => $trf['kd_lokasi'],
						"ruang_asal"=> $trf['kd_ruang'],
						"kd_lok_msk"=> $trf['kd_lok_msk'],
						"nm_satker" => $trf['nm_satker'],
						"thn_ang" 	=> $trf['thn_ang'],
						"no_dok" 	=> $trf['no_dok'],
						"user_id" 	=> $_SESSION['username'],
						"kd_brg" 	=> $trf['kd_brg'],
						"satuan" 	=> $trf['satuan'],
						"kuantitas" => $trf['qty'],
						"trf"=>$trf['id']
					);
				print_r($data);
				$Transaksi->trnsaksi_keluar($data);
			}	
		break;
		case 'baca_skpd':
			$kd_lokasi = $_SESSION['kd_lok'];
			$Transaksi->baca_skpd($kd_lokasi);
		break;
		case 'baca_skpd_luar':
			// $kd_lokasi = substr($_SESSION['kd_lok'], 0,2);
			$kd_lokasi = $_SESSION['kd_lok'];

			$Transaksi->baca_skpd_luar($kd_lokasi);
		break;
		case 'baca_rekening':
			$Transaksi->baca_rekening();
		break;
		case 'readbrg':
			$search = $_POST['q'];
			$Transaksi->bacabrg($search);
		break;

		case 'cek_tahun_aktif':
			$thn_ang = $_SESSION['thn_ang'];
			$Transaksi->cek_tahun_aktif($thn_ang);
		break;

		case 'cek_saldo_awal':
		$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);
		$thn_ang = $_SESSION['thn_ang'];
		$kd_ruang = $_SESSION['kd_ruang'];
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_ruang" => $kd_ruang,
				"thn_ang" => $thn_ang
				);
		$Transaksi->cek_saldo_awal($data);
		break;

		case 'cek_status_opname':
		$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);
		$thn_ang = $_SESSION['thn_ang'];
		$kd_ruang = $_SESSION['kd_ruang'];
		$kd_brg = $purifier->purify($_POST['kd_brg']);
		$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_ruang" => $kd_ruang,
				"thn_ang" => $thn_ang,
				"tgl_dok" => $tgl_dok,
				"kd_brg" => $kd_brg
				);
		$Transaksi->cek_status_opname($data);
		break;


		case 'cek_rangkap_brg_msk':
		$kd_lokasi = $purifier->purify($_POST['kd_lokasi']);
		$thn_ang = $_SESSION['thn_ang'];
		$kd_brg = $purifier->purify($_POST['kd_brg']);
		$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang,
				"kd_brg" => $kd_brg
				);
		$Transaksi->cek_rangkap_brg_msk($data);
		break;

		case 'readnodok':
			$no_dok = $purifier->purify($_POST['no_dok']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$data = array(
				"no_dok" => $no_dok,
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang
				);
			$Transaksi->bacanodok($data);
		break;
		case 'readsatkerdok':
			$no_dok = $purifier->purify($_POST['no_dok']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$data = array(
				"no_dok" => $no_dok,
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang
				);
			$Transaksi->bacasatkerdok($data);
		break;
		case 'get_bidang_report':
			// print_r($_POST);
			$Transaksi->get_bidang_report($_POST);
		break;
		case 'readbidang':
			$satker_tujuan= substr($purifier->purify($_POST['satker_tujuan']), 0,11);
			$kd_lokasi = substr($purifier->purify($_POST['satker_tujuan']), 0,11);
			$thn_ang = $_SESSION['thn_ang'];
			$data = array(
				"satker_tujuan" => $satker_tujuan,
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang
				);
			print_r($data);
			$Transaksi->baca_ruang($data);
			// echo "Read Bidang";
		break;
		case 'readsatkerdoks':
			$no_dok = $purifier->purify($_POST['no_dok']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$data = array(
				"no_dok" => $no_dok,
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang
				);
			$Transaksi->bacasatkerdoks($data);
		break;
		case 'readnodokklr':
			$no_dok = $purifier->purify($_POST['no_dok']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$data = array(
				"no_dok" => $no_dok,
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang
				);
			$Transaksi->bacanodok_klr($data);
		break;
		case 'readidenttrans':
			$thn_ang = $_SESSION['thn_ang'];
			$idtrans = $purifier->purify($_POST['idtrans']);
			if ($_SESSION['level'] == 1 AND isset($_POST['kdtrans'])) {
				$kd_ruang = $_POST['kdtrans'];
			}
			else {
				$kd_ruang = $_SESSION['kd_lok'].$_SESSION['kd_ruang'];
			}
			$Transaksi->bacaidenttrans($idtrans,$kd_ruang,$thn_ang);
		break;
		case 'readidenttransklr':
			$no_dok = $purifier->purify($_POST['no_dok']);
			$Transaksi->bacaidenttrans_klr($no_dok,1);
		break;
		case 'readidenttempitem':
			if (isset($_POST['id'])) {
				$id = $purifier->purify($_POST['id']);
				$Transaksi->readidenttempitem($id);
			}
			else {
				$Transaksi->readidenttempitem();
			}
		break;
		case 'readidenttempitemklr':
			if (isset($_POST['id'])) {
				$id = $purifier->purify($_POST['id']);
				$Transaksi->readidenttempitemklr($id);
			}
			else {
				$Transaksi->readidenttempitemklr();
			}
		break;
		case 'read_detail_transfer':
			$idtrans = $purifier->purify($_POST['idtrans']);
			$kd_ruang = $_SESSION['kd_lok'].$_SESSION['kd_ruang'];
			$Transaksi->bacaidenttrans_klr($idtrans,$kd_ruang,2);
		break;
		case 'readbrgmsk':
			$kd_lokasi = $purifier->purify($_POST['kd_satker']);
			$thn_ang = $_SESSION['thn_ang'];
			$kd_ruang = trim($_SESSION['kd_ruang']);
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_ruang" => $kd_ruang,
				"thn_ang" => $thn_ang
				);
			$Transaksi->baca_persediaan_masuk($data);
		break;

		case 'cek_brg_masuk':
			$kd_lokasi = $_SESSION['kd_lok'];
			$id_masuk = $purifier->purify($_POST['id_row']);
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"id_masuk" => $id_masuk
				);
			$Transaksi->cek_brg_masuk($data);
		break;

		case 'cek_brg_keluar':
			$kd_lokasi = $_SESSION['kd_lok'];
			$id_masuk = $purifier->purify($_POST['id_row']);
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"id_masuk" => $id_masuk
				);
			$Transaksi->cek_brg_keluar($data);
		break;

		case 'baca_detil_trans':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_ruang = $_SESSION['kd_ruang'];
			$data = array(
				"kd_brg" => $kd_brg,
				"kd_ruang" => $kd_ruang,
				"kd_lokasi" => $kd_lokasi
				);
			$Transaksi->baca_detil_trans($data);
		break;

		case 'sisabarang':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$no_dok = $purifier->purify($_POST['nodok']);
                        $dataDok = explode('-',$no_dok);
                        $kd_lokasi = trim($dataDok[0]);
			//$kd_lokasi = substr($no_dok, 0, 11);
			$thn_ang = $_SESSION['thn_ang'];
			$kd_ruang = $_SESSION['kd_ruang'];
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_ruang" => $kd_ruang,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"kd_brg" => $kd_brg
				);
                        //echo "<pre>";
                        //print_r($data);
                        //print_r($dataDok);
			$Transaksi->sisa_barang($data,1);
		break;

		case 'sisabarang_trf':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$no_dok = $purifier->purify($_POST['nodok']);
			$kd_lokasi = substr($no_dok, 0, 11);
			$thn_ang = $_SESSION['thn_ang'];
			$kd_ruang = $_SESSION['kd_ruang'];
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_ruang" => $kd_ruang,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"kd_brg" => $kd_brg
				);
			$Transaksi->sisa_barang($data,2);
		break;

		case 'tutup_tahun':
			$kd_lokasi = $purifier->purify($_POST['satker']);
			$thn_ang = $_SESSION['thn_ang'];
			$thn_ang_lalu = $_SESSION['thn_ang']-1;
			$user_id = $_SESSION['username'];
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang,
				"thn_ang_lalu" => $thn_ang_lalu,
				"user_id" => $user_id
				);
			//print_r($data);
			$Transaksi->tutup_tahun($data);
		break;

		case 'tbh_transfer':
			$kd_ruang="";
			$kd_brg="";
			$nm_ruang="";
			$kd_tujuan="";
			$kd_lokasi = $purifier->purify($_POST['read_no_dok']);
			$satkernodok = $purifier->purify($_POST['read_no_dok']);
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$ruang_asal = $_SESSION['kd_ruang'];
			$no_bukti = $purifier->purify($_POST['no_dok']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));
			$jns_trans="K06";
			$keterangan = $purifier->purify($_POST['keterangan']);
			$status = 0;
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$user_id = $_SESSION['username'];


			if($kd_brg==""){
				$instansi="";
				$data = explode("-", $purifier->purify($_POST['bidang_tujuan']));
				$kd_ruang = $data[0];
				$nm_ruang = $data[1];
				$data_tujuan = explode("-", $purifier->purify($_POST['satker_tujuan']));
				$kd_tujuan = $data_tujuan[0];
				$nm_tujuan = $data_tujuan[1];
				$jns_trans=$purifier->purify($_POST['jenis_transfer']);;

				$no_dok = $kd_lokasi.' - '.$purifier->purify($_POST['no_dok']);
				if($nm_ruang!=""){
					$instansi=$nm_ruang;
				}
				else{
					$instansi=$nm_satker;
				}
				$data = array(
					"kd_lokasi" => $kd_lokasi,
					"kd_lok_msk" => $kd_tujuan,
					"kd_ruang" => $kd_ruang,
					"ruang_asal" => $ruang_asal,
					"nm_ruang" => $nm_ruang,
					"nm_satker" => $nm_satker,
					"nm_satker_msk" => $nm_tujuan,
					"thn_ang" => $thn_ang,
					"jns_trans" => $jns_trans,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"no_bukti" => $no_bukti,
					"keterangan" => $keterangan,
					"status" => $status,
					"user_id" => $user_id

				);
				print_r($data);
				// echo "<br>Masuk Dokumen";

				$Transaksi->tbh_transfer($data,1);

			}
			else{

				$kuantitas = $purifier->purify($_POST['jml_msk']);
				$satuan = $purifier->purify($_POST['satuan']);
				$hrg_sat = $purifier->purify($_POST['rph_sat']);

				$no_dok = $purifier->purify($_POST['no_dok_item']);
				$data = array(
					"kd_lokasi" => $_SESSION['kd_lok'],
					"ruang_asal" => $ruang_asal,
					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"jns_trans" => $jns_trans,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"no_bukti" => $no_bukti,
					"status" => $status,
					"user_id" => $user_id,
					"kd_brg" => $kd_brg,
					"satuan" => $satuan,
					"kuantitas" => $kuantitas,
					"keterangan" => $keterangan,
					"harga_sat" => $hrg_sat,
					"keterangan" => $keterangan
				);
				// print_r($data);
				// echo "<br>Masuk Item";

				$Transaksi->tbh_transfer($data,2);


			}
		break;

		case 'tbh_transaksi_klr':
			$kd_ruang="";
			$nm_ruang="";
			$kd_tujuan="";
			$kd_lokasi = $purifier->purify($_POST['read_no_dok']);
			$satkernodok = $purifier->purify($_POST['read_no_dok']);
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$ruang_asal = $_SESSION['kd_ruang'];
			$no_bukti = $purifier->purify($_POST['no_dok']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));
			$jns_trans = $_POST['jenis_trans'];


			$kd_brg = $purifier->purify($_POST['kd_brg']);

			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$satuan = $purifier->purify($_POST['satuan']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			$status = 0;
			$user_id = $_SESSION['username'];
			if($_POST['satker_tujuan']!=""){
				$data = explode("-", $purifier->purify($_POST['bidang_tujuan']));
				$kd_ruang = $data[0];
				$nm_ruang = $data[1];
				$kd_tujuan = $purifier->purify($_POST['satker_tujuan']);
			 	$jns_trans="K06";
			 	// echo "Transfer Mode<br>";

			}
			if ($kd_brg=="")
			{
				$no_dok = $kd_lokasi.' - '.$purifier->purify($_POST['no_dok']);

				$data = array(
					"kd_lokasi" => $kd_lokasi,
					"kd_lok_msk" => $kd_tujuan,
					"kd_ruang" => $kd_ruang,
					"ruang_asal" => $ruang_asal,
					"nm_ruang" => $nm_ruang,
					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"jns_trans" => $jns_trans,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"no_bukti" => $no_bukti,
					"keterangan" => $keterangan,
					"status" => $status,
					"user_id" => $user_id

				);
				// echo "transa ident<br>";
				// print_r($data);
				$Transaksi->transaksi_keluar_ident($data);
			}
			else{
				$no_dok = $purifier->purify($_POST['no_dok_item']);
				$data = array(
					"kd_lokasi" => $_SESSION['kd_lok'],
					"ruang_asal" => $ruang_asal,
					"kd_lok_msk" => $kd_lok_msk,
					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"jns_trans" => $jns_trans,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"no_bukti" => $no_bukti,
					"status" => $status,
					"user_id" => $user_id,
					"kd_brg" => $kd_brg,
					"nm_brg" => $nm_brg,
					"satuan" => $satuan,
					"kuantitas" => $kuantitas,
					"keterangan" => $keterangan,
					"harga_sat" => $hrg_sat,
					"keterangan" => $keterangan
				);
				print_r($data);

				$Transaksi->trnsaksi_keluar($data);
			//========= Log History =========//


				$thn_ang = $_SESSION['thn_ang'];
				$jns_trans = $_POST['disjenistrans'];
				$kd_brg = $purifier->purify($_POST['kd_brg']);

				$kuantitas = $purifier->purify($_POST['jml_msk']);
				$keterangan = $purifier->purify($_POST['keterangan']);
				$hrg_sat = $purifier->purify($_POST['rph_sat']);

				$user_id = $_SESSION['username'];
				$tanggal = date("Y-m-d h:i:sa");
				$datalog = array(
					"kd_lokasi" => $kd_lokasi,

					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"no_bukti" => $no_bukti,
					"kd_brg" => $kd_brg,
					"kuantitas" => $kuantitas,
					"keterangan" => $keterangan,
					"aksi" => "T-transaksi keluar",
			    	"harga_sat" => $hrg_sat,
			    	"jns_trans" => $jns_trans,
					"keterangan" => $keterangan,

					"user_id" => $user_id,
			    	"tanggal" => $tanggal
			    );
				// $Transaksi->loghistory_keluar($datalog);
			}


				//========= Log History =========//

		break;

		case 'tbh_transaksi_msk':
			$kd_lokasi = $purifier->purify($_POST['read_no_dok']);
			$kd_ruang = $_SESSION['kd_ruang'];
			$satkernodok = $purifier->purify($_POST['read_no_dok']);
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$nilai_kontrak = $_POST['nilai_kontrak'];
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$ket_brg = $purifier->purify($_POST['ket_brg']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));


			// $kd_brg = $purifier->purify($_POST['kd_brg']);
			$detail_rek = explode("-", $_POST['kode_rek']);


			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$satuan = $purifier->purify($_POST['satuan']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			$status = 0;
			$user_id = $_SESSION['username'];
			if($nilai_kontrak > 0 && $kd_brg == ""){
				$ket_non_persediaan = $purifier->purify($_POST['ket_non_persediaan']);
				$no_dok = $purifier->purify($_POST['no_dok_item']);
				$kode_rek = $detail_rek[0];
				$nama_rek = $detail_rek[1];
				$data = array(
					"kd_lokasi" => $kd_lokasi,
					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"no_dok" => $no_dok,
					"nilai_kontrak" =>$nilai_kontrak,
					"ket_non_persediaan" =>$ket_non_persediaan,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"status" => $status,
					"user_id" => $user_id,
					"keterangan" => $keterangan,
					"kode_rek" => $kode_rek,
					"nama_rek" => $nama_rek,
					"keterangan" => $keterangan
				);
				// print_r($data);
				echo "Pemasukkan Rekening";
				$Transaksi->transaksi_masuk($data);
			}

			elseif ($kd_brg == "") {
			$no_dok	= $satkernodok.' - '.$purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_dok']);
			$jns_trans = $_POST['jenis_trans'];
			$data = array(
					"kd_lokasi" => $kd_lokasi,
					"kd_ruang" => $kd_ruang,
					// "kd_lok_msk" => $kd_lok_msk,
					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"jns_trans" => $jns_trans,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"no_bukti" => $no_bukti,
					"keterangan" => $keterangan,
					"nilai_kontrak" =>$nilai_kontrak,
					"status" => $status,
					"user_id" => $user_id

					// "kd_brg" => $kd_brg,
					// "nm_brg" => $nm_brg,
					// "satuan" => $satuan,
					// "kuantitas" => $kuantitas,
					// "keterangan" => $keterangan,
					// "harga_sat" => $hrg_sat,
					// "keterangan" => $keterangan,
				);
				// print_r($data);
				echo 'masuk identITAS Dokumen';
				$Transaksi->transaksi_masuk_ident($data);
			}
			else{
				$ket_non_persediaan = $purifier->purify($_POST['ket_non_persediaan']);

				$kode_rek = $detail_rek[0];
				$nama_rek = $detail_rek[1];
				$no_dok = $purifier->purify($_POST['no_dok_item']);

				$data = array(
					"kd_lokasi" => $kd_lokasi,
					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"status" => $status,
					"user_id" => $user_id,
					"kd_brg" => $kd_brg,
					"satuan" => $satuan,
					"kuantitas" => $kuantitas,
					"keterangan" => $keterangan,
					"harga_sat" => $hrg_sat,
					"kode_rek" => $kode_rek,
					"nama_rek" => $nama_rek,
					"ket_brg" => $ket_brg,
					"keterangan" => $keterangan,
					"nilai_kontrak" =>0,
					"ket_non_persediaan" =>$ket_non_persediaan,
					"kode_rek" => $kode_rek,
					"nama_rek" => $nama_rek
				);
				// print_r($data);
				echo "Pemasukkan Barang";
				$Transaksi->transaksi_masuk($data);
			}
			//========= Log History =========//
			$kd_lokasi = $_SESSION['kd_lok'];

			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];

			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));

			$kd_brg = $purifier->purify($_POST['kd_brg']);
			// $nm_brg = $purifier->purify($_POST['nm_brg']);
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);

			$user_id = $_SESSION['username'];
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"kd_brg" => $kd_brg,
				"satuan" => $satuan,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
				"aksi" => "T-transaksi masuk",
		    	"harga_sat" => $hrg_sat,
				"keterangan" => $keterangan,

				"user_id" => $user_id,
		    	"tanggal" => $tanggal
		    );
			$Transaksi->loghistory_masuk($datalog);
			//========= Log History =========//

		break;

		case 'ubah_dok_masuk':
			$kd_lokasi = $purifier->purify($_POST['kd_satker']);
			$kd_trans = $purifier->purify($_POST['jns_trans_baru']);
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $kd_lokasi.' - '.$purifier->purify($_POST['nodok_baru']);
			$no_dok_lama = $purifier->purify($_POST['no_dok_lama']);
			$no_bukti = $purifier->purify($_POST['nodok_baru']);
			$keterangan = $purifier->purify($_POST['ket_baru']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok_baru']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku_baru']));
			$user_id = $_SESSION['username'];
			$kd_ruang = $_SESSION['kd_ruang'];
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_ruang" => $kd_ruang,
				"kd_trans" => $kd_trans,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"no_dok_lama" => $no_dok_lama,
				"no_bukti" => $no_bukti,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"keterangan" => $keterangan,
				"user_id" => $user_id
			);
			print_r($data);
			$Transaksi->ubah_dok_masuk($data);
		break;

		case 'ubah_dok_keluar':
			$kd_lokasi = $purifier->purify($_POST['kd_satker']);
			$kd_trans = $purifier->purify($_POST['jns_trans_baru']);
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $kd_lokasi.' - '.$purifier->purify($_POST['nodok_baru']);
			$no_dok_lama = $purifier->purify($_POST['no_dok_lama']);
			$no_bukti = $purifier->purify($_POST['nodok_baru']);
			$keterangan = $purifier->purify($_POST['ket_baru']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok_baru']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku_baru']));
			$user_id = $_SESSION['username'];
			$kd_ruang = $_SESSION['kd_ruang'];
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_ruang" => $kd_ruang,
				"kd_trans" => $kd_trans,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"no_dok_lama" => $no_dok_lama,
				"no_bukti" => $no_bukti,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"keterangan" => $keterangan,
				"user_id" => $user_id
			);
			print_r($data);
			$Transaksi->ubah_dok_keluar($data);
		break;

		case 'ubah_transaksi_msk':

			$kd_trans = $purifier->purify($_POST['id']);
			$kd_lok_msk = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];

			$kuantitas = $purifier->purify($_POST['jumlah_baru']);
			$hrg_sat = $purifier->purify($_POST['harga_baru']);


			$user_id = $_SESSION['username'];
			$kd_ruang = $_SESSION['kd_ruang'];


			$data = array(

				"kd_trans" => $kd_trans,
				"kd_ruang" => $kd_ruang,
				"kd_lok" => $kd_lok_msk,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"kuantitas" => $kuantitas,
		    	"harga_sat" => $hrg_sat,

				"user_id" => $user_id
			);
			print_r($data);
			$Transaksi->ubah_transaksi_masuk($data);
		break;

		case 'tbh_koreksi':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_lok_msk = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));
			$satuan = $purifier->purify($_POST['satuan']);
			$jns_trans = $_POST['jenis_trans'];
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$nm_brg = $purifier->purify($_POST['nm_brg']);
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			$status = 0;
			$user_id = $_SESSION['username'];


			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"kd_brg" => $kd_brg,
				"nm_brg" => $nm_brg,
				"satuan" => $satuan,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"harga_sat" => $hrg_sat,
		    	"jns_trans" => $jns_trans,
				"keterangan" => $keterangan,
				"status" => $status,
				"user_id" => $user_id
			);
			$Transaksi->tbh_koreksi_masuk($data);
		break;

		case 'hapusRekening':
			$id = $purifier->purify($_POST['id']);
			$Transaksi->hapus_rekening($id);
		break;

		case 'hapusTransMasuk':
			$id = $purifier->purify($_POST['id']);
			$user_id = $_SESSION['username'];
			$kd_lokasi = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$tanggal = date("Y-m-d h:i:sa");


			$data = array(
				"id" => $id,
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"aksi" => "H-transaksi masuk",
				"tanggal" => $tanggal,
				"user_id" => $user_id
			);
			$Transaksi->loghistory_masuk_uh($data);
			$Transaksi->hapus_transaksi_masuk($data);
		break;

		case 'hapusTransKeluar':
			$id = $purifier->purify($_POST['id']);
			$user_id = $_SESSION['username'];
			$kd_lokasi = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$tanggal = date("Y-m-d h:i:sa");

			$data = array(
				"id" => $id,
				"kd_lokasi" => $kd_lokasi,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"aksi" => "HAPUS - KELUAR",
				"tanggal" => $tanggal,
				"user_id" => $user_id
			);
			$Transaksi->loghistory_keluar_uh($data);
			$Transaksi->hapus_transaksi_keluar($data);
		break;

		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>
