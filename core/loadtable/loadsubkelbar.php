<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'persediaan';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'kd_brg', 'dt' => 1 ),
    array( 'db' => 'nm_sskel', 'dt' => 2 ),
    array( 'db' => 'nm_brg', 'dt' => 3 ),
    array( 'db' => 'spesifikasi', 'dt' => 4 ),
    array( 'db' => 'satuan', 'dt' => 5 ),
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, "char_length(kd_brg)>17 ")
); 
