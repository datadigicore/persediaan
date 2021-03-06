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
$table = 'transfer';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'no_dok', 'dt' => 1),
    array( 'db' => 'nm_satker', 'dt' => 2, 'formatter' => function($d,$row){return "$row[7] $d";}),
    array( 'db' => 'nm_satker_msk', 'dt' => 3, 'formatter' => function($d,$row){return "$row[8] $d";}),
    array( 'db' => 'tgl_dok', 'dt' => 4, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 5, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'keterangan', 'dt' => 6 ),
    array( 'db' => 'nm_ruang', 'dt' => 7 ),
    array( 'db' => 'nm_ruang_msk', 'dt' => 8 ),
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
if ($_SESSION['level'] == 1) {
    $where = " thn_ang='$thn_ang' group by no_dok";
}
else{
    $where = "concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and jns_trans not like 'P%' and jns_trans in ('K06','K07') group by no_dok"; 
}

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where)
); 
