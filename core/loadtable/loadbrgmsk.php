<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
// baca data session


// Table yang di load
$table = 'view_brg';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'no_dok', 'dt' => 1 ),
    array( 'db' => 'kd_brg', 'dt' => 2 ),
    array( 'db' => 'nm_brg', 'dt' => 3 ),
    array( 'db' => 'masuk', 'dt' => 4 ),
    array( 'db' => 'saldo', 'dt' => 5 ),

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
