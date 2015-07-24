<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'uakpb';
 
// Primary Key table
$primaryKey = 'kd_uakpb';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'kd_uapb', 'dt' => 0 ),
    array( 'db' => 'kd_uappbe1', 'dt' => 1 ),
	array( 'db' => 'kd_uappbw', 'dt' => 2 ),
	array( 'db' => 'kd_uakpb', 'dt' => 3 ),
    array( 'db' => 'kd_uapkpb', 'dt' => 4 ),
    array( 'db' => 'jk', 'dt' => 5 ),
    array( 'db' => 'nm_uakpb', 'dt' => 6 ),
   
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
