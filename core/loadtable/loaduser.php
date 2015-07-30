<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'user';
 
// Primary Key table
$primaryKey = 'user_id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'user_id', 'dt' => 0 ),
    array( 'db' => 'user_email', 'dt' => 1 ),
    array( 'db' => 'kd_lokasi', 'dt' => 2 ),
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
