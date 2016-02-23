<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'].$_SESSION['kd_ruang'];
$thn_ang=$_SESSION['thn_ang'];
$kd_ruang=$_SESSION['kd_ruang'];
// Table yang di load
$table = 'transaksi_keluar';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'jns_trans', 'dt' => 1,'formatter' => function($d,$row){if($d=="K01"){return "Habis Pakai";}elseif($d=="K02"){return "Transfer Keluar";}elseif($d=="K03"){return "Hibah Keluar";}elseif($d=="K04"){return "Usang";}else{return "Rusak";}} ),
    array( 'db' => 'no_dok', 'dt' => 2),
    array( 'db' => 'no_bukti', 'dt' => 3 ),
    array( 'db' => 'tgl_dok', 'dt' => 4, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 5, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'keterangan', 'dt' => 6 ),
);
if($kd_ruang!=""){ $query_ruang="and kd_ruang='$kd_ruang'"; } else $query_ruang="and (kd_ruang is null or kd_ruang='') ";
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
if (substr_count($str,".") == 0) {
    $where = "kd_lokasi like '$kd_satker.%.%.%' and status_hapus=0 and thn_ang='$thn_ang' and jns_trans not like 'P%'  group by no_dok";   
}
else if (substr_count($str,".") == 1) {
    $where = "kd_lokasi like '$kd_satker.%.%' and status_hapus=0 and thn_ang='$thn_ang' and jns_trans not like 'P%'  group by no_dok";   
}
else if (substr_count($str,".") == 2) {
    $where = "kd_lokasi like '$kd_satker.%' and status_hapus=0 and thn_ang='$thn_ang' and jns_trans not like 'P%'  group by no_dok";
}
else{
    $where = "concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and status_hapus=0 and thn_ang='$thn_ang' and jns_trans not  in('P01','K06')  group by no_dok"; 
}

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where)
); 
