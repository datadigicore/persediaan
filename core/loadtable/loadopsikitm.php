<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'];
$thn_ang=$_SESSION['thn_ang'];

$no_dok = urldecode($_GET['no_dok']);
// Table yang di load
$table = 'opname';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'kd_lokasi', 'dt' => 1 ),
    array( 'db' => 'nm_satker', 'dt' => 2 ),
    array( 'db' => 'no_dok', 'dt' => 3 ),
    array( 'db' => 'kd_brg', 'dt' => 4),
    array( 'db' => 'nm_brg', 'dt' => 5 ),
    array( 'db' => 'spesifikasi', 'dt' => 6 ),
    array( 'db' => 'qty', 'dt' => 7 ),
    array( 'db' => 'harga_sat', 'dt' => 8, 'formatter' => function($d,$row){return number_format($d,0,",",".");} ),
    array( 'db' => 'total_harga', 'dt' => 9, 'formatter' => function($d,$row){return number_format($d,0,",",".");}),
    array( 'db' => 'keterangan', 'dt' => 10 ),
    array( 'db' => 'status_ambil', 'dt' => 11, 'formatter' => function($d,$row){ if($d==0) return '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>';}),
   

);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
if (substr_count($str,".") == 0) {
    $where = "kd_lokasi like '$kd_satker.%.%.%' and status_hapus=0 and thn_ang='$thn_ang' and no_dok = '$no_dok' and kd_brg !=''  ";
}
else if (substr_count($str,".") == 1) {
    $where = "kd_lokasi like '$kd_satker.%.%' and status_hapus=0 and thn_ang='$thn_ang' and no_dok = '$no_dok' and kd_brg !=''  ";
}
else if (substr_count($str,".") == 2) {
    $where = "kd_lokasi like '$kd_satker.%' and status_hapus=0 and thn_ang='$thn_ang' and no_dok = '$no_dok' and kd_brg !=''   ";
}
else{
    $where = "kd_lokasi='$kd_satker' and status_hapus=0 and thn_ang='$thn_ang' and no_dok = '$no_dok' and kd_brg !=''  ";
}
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
