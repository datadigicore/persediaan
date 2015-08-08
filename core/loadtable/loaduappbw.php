<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'satker';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'kd_uapb', 'dt' => 0 ),
    array( 'db' => 'kd_uappbe1', 'dt' => 1 ),
    array( 'db' => 'kd_uappbw', 'dt' => 2 ),
    array( 'db' => 'nm_satker', 'dt' => 3 )
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

// Kondisi Where
$where = '	kd_uapb is not null and
			kd_uappbe1 is not null and
			kd_uappbw is not null and
			kd_uakpb is null' ; 

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
