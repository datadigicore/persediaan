<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'uapb';
 
// Primary Key table
$primaryKey = 'kd_uapb';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'kd_uapb', 'dt' => 0 ),
    array( 'db' => 'nm_uapb', 'dt' => 1 ),
);
 
// Settingan Koneksi Datatable
require('connection.php');
 
// Pengaturan Output Server Side Processing
require( 'ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
); 
