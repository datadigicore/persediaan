<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'];

// Table yang di load
$table = 'persediaan';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'kd_brg', 'dt' => 1 ),
    array( 'db' => 'kd_brg', 'dt' => 2 ),
    array( 'db' => 'nm_brg', 'dt' => 3 ),
    array( 'db' => 'satuan', 'dt' => 4 ),
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
if (substr_count($str,".") == 1) {
    $where = "kd_lokasi like '$kd_satker.%.%'";
}
else if (substr_count($str,".") == 2) {
    $where = "kd_lokasi like '$kd_satker.%'";
}
else{
    $where = "kd_lokasi='$kd_satker'";
} 


// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where)
); 
