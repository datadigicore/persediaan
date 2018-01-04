<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
if ($_SESSION['level'] == 1 AND isset($_GET['kd_sat'])) {
    $kd_satker = $_GET['kd_sat'];
}
else {
    $kd_satker = $_SESSION['kd_lok'];
}
$kd_ruang=$_SESSION['kd_ruang'];
$thn_ang=$_SESSION['thn_ang'];

$table = 'temp_import_transfer';
$primaryKey = 'id';

// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'no_dok', 'dt' => 1 ),
    array( 'db' => 'nm_brg', 'dt' => 2 ),
    array( 'db' => 'qty', 'dt' => 3 ),
    array( 'db' => 'satuan', 'dt' => 4 ),
    array( 'db' => 'error_message', 'dt' => 5 )
);

if($kd_ruang!="") $query_ruang="and kd_ruang='$kd_ruang' ";
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
$where = "thn_ang='$thn_ang'";

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
);
