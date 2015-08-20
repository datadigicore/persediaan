<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
session_start();
$user_id=$_SESSION['username'];
// Table yang di load
$table = 'transaksi_masuk';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'no_dok', 'dt' => 1 ),
    array( 'db' => 'tgl_buku', 'dt' => 2 ),
    array( 'db' => 'nm_brg', 'dt' => 3 ),
    array( 'db' => 'qty', 'dt' => 4 ),
    array( 'db' => 'harga_sat', 'dt' => 5 ),
    array( 'db' => 'total_harga', 'dt' => 6 ),
    array( 'db' => 'keterangan', 'dt' => 7 ),
    array( 'db' => 'user_id', 'dt' => 9 ),

);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$where = "user_id = '$user_id'";
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
