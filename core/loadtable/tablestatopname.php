<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'opname';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'kd_lokasi', 'dt' => 1 ),
    array( 'db' => 'nm_satker', 'dt' => 2 ),
    array( 'db' => 'thn_ang', 'dt' => 3 ),
    array( 'db' => 'nm_brg', 'dt' => 4 ),
    array( 'db' => 'spesifikasi', 'dt' => 5 ),
    array( 'db' => 'qty', 'dt' => 6 ),
    array( 'db' => 'satuan', 'dt' => 7 ),
    array( 'db' => 'keterangan', 'dt' => 8 ),
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

// Pengaturan Output Server Side Processing
require('../../config/ssp.class.php');
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
); 
