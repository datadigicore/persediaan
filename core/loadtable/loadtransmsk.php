<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'];
$thn_ang=$_SESSION['thn_ang'];
// Table yang di load
$table = 'transaksi_masuk';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'jns_trans', 'dt' => 1,'formatter' => function($d,$row){if($d=="M01"){return "Saldo Awal";}elseif($d=="M02"){return "Pembelian";}elseif($d=="M03"){return "Hibah Masuk";}elseif($d=="M04"){return "Perolehan Lainnya";}} ),
    array( 'db' => 'no_dok', 'dt' => 2 ),
    array( 'db' => 'no_bukti', 'dt' => 3 ),
    array( 'db' => 'tgl_dok', 'dt' => 4, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 5, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'keterangan', 'dt' => 6 ),
    // array( 'db' => 'nm_brg', 'dt' => 5 ),
    // array( 'db' => 'qty', 'dt' => 6 ),
    // array( 'db' => 'harga_sat', 'dt' => 7 ),
    // array( 'db' => 'total_harga', 'dt' => 8 ),
    // array( 'db' => 'keterangan', 'dt' => 9 ),

    
    
    

);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
if (substr_count($str,".") == 0) {
    $where = "kd_lokasi like '$kd_satker.%.%.%'  and thn_ang='$thn_ang'  and jns_trans not in ('P01','P02','M01I')  group by no_dok";   
}
else if (substr_count($str,".") == 1) {
    $where = "kd_lokasi like '$kd_satker.%.%'  and thn_ang='$thn_ang'  and jns_trans not in ('P01','P02','M01I')  group by no_dok";   
}
else if (substr_count($str,".") == 2) {
    $where = "kd_lokasi like '$kd_satker.%'  and thn_ang='$thn_ang'  and jns_trans not in ('P01','P02','M01I')  group by no_dok";
}
else{
    $where = "kd_lokasi='$kd_satker'  and thn_ang='$thn_ang' and jns_trans not in ('P01','P02','M01I')  group by no_dok";
}
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
