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
		case 'readbrg':
			$data = $_SESSION['kd_lok'];
			$Transaksi->bacabrg($data);
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
		case 'readnodokklr':
			$no_dok = $purifier->purify($_POST['no_dok']);
			$Transaksi->bacanodok_klr($no_dok);
		break;
		case 'readidenttrans':
			$idtrans = $purifier->purify($_POST['idtrans']);
			$Transaksi->bacaidenttrans($idtrans);
		break;
		case 'readidenttransklr':
			$idtrans = $purifier->purify($_POST['idtrans']);
			$Transaksi->bacaidenttrans_klr($idtrans);
		break;
		case 'readbrgmsk':
			$kd_lokasi = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$data = array(
				"kd_lokasi" => $kd_lokasi,
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
			$no_dok = $purifier->purify($_POST['no_dok']);
			$data = array(
				"no_dok" => $no_dok,
				"kd_brg" => $kd_brg
				);
			$Transaksi->baca_detil_trans($data);
		break;		

		case 'sisabarang':
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			$kd_lokasi = $_SESSION['kd_lok'];
			$thn_ang = $_SESSION['thn_ang'];
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"thn_ang" => $thn_ang,
				"kd_brg" => $kd_brg
				);
			$Transaksi->sisa_barang($data);
		break;

		case 'tbh_transaksi_klr':
			$kd_lokasi = $_SESSION['kd_lok'];
			
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));
			$jns_trans = $_POST['jenis_trans'];
			
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			$status = 0;
			$user_id = $_SESSION['username'];
			if ($jns_trans!="") 
			{
				$no_dok = $kd_lokasi.'.'.$purifier->purify($_POST['no_dok']);

				$data = array(
					"kd_lokasi" => $kd_lokasi,
					// "kd_lok_msk" => $kd_lok_msk,
					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"jns_trans" => $jns_trans,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"no_bukti" => $no_bukti,
					"status" => $status,
					"user_id" => $user_id

				);
				echo "transa ident";
				print_r($data);
				$Transaksi->transaksi_keluar_ident($data);
			}
			else{
				$no_dok = $purifier->purify($_POST['no_dok_item']);
				$data = array(
					"kd_lokasi" => $kd_lokasi,
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
				echo "kosong terpilih";
				print_r($data);
				
				$Transaksi->trnsaksi_keluar($data);
			}


			//========= Log History =========//
			$kd_lokasi = $_SESSION['kd_lok'];
			
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $kd_lokasi.$purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));
			
			$jns_trans = $_POST['jenis_trans'];
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
			$Transaksi->loghistory_keluar($datalog);
			//========= Log History =========//
		break;

		case 'tbh_transaksi_msk':
			$kd_lokasi = $_SESSION['kd_lok'];
			
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));
			
			$jns_trans = $_POST['jenis_trans'];
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			$status = 0;
			$user_id = $_SESSION['username'];
			if ($jns_trans!="") 
			{
				$no_dok = $kd_lokasi.'.'.$purifier->purify($_POST['no_dok']);
				$data = array(
					"kd_lokasi" => $kd_lokasi,
					// "kd_lok_msk" => $kd_lok_msk,
					"nm_satker" => $nm_satker,
					"thn_ang" => $thn_ang,
					"jns_trans" => $jns_trans,
					"no_dok" => $no_dok,
					"tgl_dok" => $tgl_dok,
					"tgl_buku" => $tgl_buku,
					"no_bukti" => $no_bukti,
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
				$Transaksi->transaksi_masuk_ident($data);
			}
			else{
				$no_dok = $purifier->purify($_POST['no_dok_item']);
				$data = array(
					"kd_lokasi" => $kd_lokasi,
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
				$Transaksi->transaksi_masuk($data);
			}

			//========= Log History =========//
			$kd_lokasi = $_SESSION['kd_lok'];
			
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));
			
			$jns_trans = $_POST['jenis_trans'];
			$kd_brg = $purifier->purify($_POST['kd_brg']);
			// $nm_brg = $purifier->purify($_POST['nm_brg']);
			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);
			
			$user_id = $_SESSION['username'];
			$tanggal = date("Y-m-d h:i:sa");
			$datalog = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_lok_msk" => $kd_lok_msk,
				"nm_satker" => $nm_satker,
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
				"aksi" => "T-transaksi masuk",
		    	"harga_sat" => $hrg_sat,
		    	"jns_trans" => $jns_trans,
				"keterangan" => $keterangan,
				
				"user_id" => $user_id,
		    	"tanggal" => $tanggal
		    );
			$Transaksi->loghistory_masuk($datalog);
			//========= Log History =========//

		break;		

		case 'ubah_transaksi_msk':
			$kd_lokasi = $_SESSION['kd_lok'];
			$kd_trans = $purifier->purify($_POST['kd_trans']);
			$kd_lok_msk = $_SESSION['kd_lok'];
			$nm_satker = $_SESSION['nama_satker'];
			$thn_ang = $_SESSION['thn_ang'];
			$no_dok = $purifier->purify($_POST['no_dok']);
			$no_bukti = $purifier->purify($_POST['no_bukti']);
			$tgl_dok = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_dok']));
			$tgl_buku = $Transaksi->konversi_tanggal($purifier->purify($_POST['tgl_buku']));

			// $jns_trans = $_POST['jenis_trans'];

			$kuantitas = $purifier->purify($_POST['jml_msk']);
			$keterangan = $purifier->purify($_POST['keterangan']);
			$hrg_sat = $purifier->purify($_POST['rph_sat']);

			$status = 0;
			$user_id = $_SESSION['username'];
			
			
			$data = array(
				"kd_lokasi" => $kd_lokasi,
				"kd_trans" => $kd_trans,
				"kd_lok_msk" => $kd_lok_msk,
				"nm_satker" => $nm_satker,
				"thn_ang" => $thn_ang,
				"no_dok" => $no_dok,
				"tgl_dok" => $tgl_dok,
				"tgl_buku" => $tgl_buku,
				"no_bukti" => $no_bukti,
				"kuantitas" => $kuantitas,
				"keterangan" => $keterangan,
		    	"harga_sat" => $hrg_sat,


				"keterangan" => $keterangan,
				"status" => $status,
				"user_id" => $user_id
			);
			
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
				"aksi" => "H-transaksi keluar",
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