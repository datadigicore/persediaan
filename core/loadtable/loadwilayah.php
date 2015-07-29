<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'wilayah';
 
// Primary Key table
$primaryKey = 'kd_wil';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'kd_wil', 'dt' => 0 ),
    array( 'db' => 'nm_wil', 'dt' => 1 ),
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
); 
