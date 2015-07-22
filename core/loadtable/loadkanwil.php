<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'kanwil';
 
// Primary Key table
$primaryKey = 'kd_kanwil';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'kd_uapb', 'dt' => 0 ),
    array( 'db' => 'kd_uappbe1', 'dt' => 1 ),
    array( 'db' => 'kd_kanwil', 'dt' => 2 ),
    array( 'db' => 'nm_kanwil', 'dt' => 3 )
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
); 
