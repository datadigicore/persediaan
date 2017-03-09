<?php
include('/var/www/html/persediaan/model/modelTransaksi.php');
session_start();
$Transaksi = new modelTransaksi();
$data = Array( 
	"kd_lokasi" => "07.02.01.01", 
	"ruang_asal"=> "03",
	"nm_satker" => "RSUD BENDAN - ATK",
	"thn_ang"   => 2016,
	"jns_trans" => "K01",
	"no_dok"    => "07.02.01.01 - PL1", 
	"tgl_dok"   => "2016-10-05",			
	"tgl_buku"  => "2016-10-05",			 
	"no_bukti"  => "PL1",			
	"status"    => 0, 
	"user_id"   => "ADMIN",
	"kd_brg"    => "01.01.07.01.01.01.69",
	"satuan"    => "LEMBAR",			 
	"kuantitas" => 3, 		
	"keterangan"=> "TESTING MODUL",
 );
echo "<pre>";
print_r($data);
$Transaksi->import_transaksi_keluar($data);
?>