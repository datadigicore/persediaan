<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'brg';
 
// Primary Key table
$primaryKey = 'kd_brg';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'kd_kbrg', 'dt' => 0 ),
    array( 'db' => 'kd_jbrg', 'dt' => 1 ),
	array( 'db' => 'nm_brg', 'dt' => 2 ),
    array( 'db' => 'satuan', 'dt' => 3 )
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
); 
