<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'rekening';
 
// Primary Key table
$primaryKey = 'kode_rekening';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'kode_rekening', 'dt' => 0 ),
    array( 'db' => 'kode_rekening', 'dt' => 1 ),
    array( 'db' => 'nama_rekening', 'dt' => 2 ),
    array( 'db' => 'tahun', 'dt' => 3 )
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns)
); 
