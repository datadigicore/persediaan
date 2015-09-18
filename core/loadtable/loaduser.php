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
    array( 'db' => 'user_name', 'dt' => 1 ),
    array( 'db' => 'user_email', 'dt' => 2 ),
    array( 'db' => 'kd_lokasi', 'dt' => 3 ),
    array( 'db' => 'nm_satker', 'dt' => 4 ),
);

// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();
 
$where = 'user_name != "masteradmin" and user_name != "adminsimsedia" and user_name != "masteruser"' ;

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where)
); 
