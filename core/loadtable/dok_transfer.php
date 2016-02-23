<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'].$_SESSION['kd_ruang'];
$thn_ang=$_SESSION['thn_ang'];
// Table yang di load
$table = 'transaksi_keluar';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'no_dok', 'dt' => 1),
    array( 'db' => 'nm_satker_msk', 'dt' => 2),
    array( 'db' => 'tgl_dok', 'dt' => 3, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 4, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'keterangan', 'dt' => 5 ),
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
if (substr_count($str,".") == 0) {
    $where = "kd_lokasi like '$kd_satker.%.%.%' and thn_ang='$thn_ang' and jns_trans not like 'P%' and kd_lok_msk is not null group by no_dok";   
}
else if (substr_count($str,".") == 1) {
    $where = "kd_lokasi like '$kd_satker.%.%' and thn_ang='$thn_ang' and jns_trans not like 'P%' and kd_lok_msk is not null  group by no_dok";   
}
else if (substr_count($str,".") == 2) {
    $where = "kd_lokasi like '$kd_satker.%' and thn_ang='$thn_ang' and jns_trans not like 'P%' and kd_lok_msk is not null group by no_dok";
}
else{
    $where = "concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and jns_trans not like 'P%' and jns_trans='K06' group by no_dok"; 
}

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where)
); 
