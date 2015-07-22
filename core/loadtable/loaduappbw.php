<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'uappbw';
 
// Primary Key table
$primaryKey = 'kd_uappbw';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'kd_uapb', 'dt' => 0 ),
    array( 'db' => 'kd_uappb', 'dt' => 1 ),
    array( 'db' => 'kd_uappbw', 'dt' => 2 ),
    array( 'db' => 'nm_uappbw', 'dt' => 3 )
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
); 
