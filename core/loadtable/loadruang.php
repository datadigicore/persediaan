<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'satker';
 
// Primary Key table
$primaryKey = 'satker_id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'satker_id', 'dt' => 0 ),
    array( 'db' => 'kodesektor', 'dt' => 1 ),
    array( 'db' => 'kodesatker', 'dt' => 2 ),
	array( 'db' => 'kodeunit', 'dt' => 3 ),
	array( 'db' => 'gudang', 'dt' => 4 ),
	array( 'db' => 'kd_ruang', 'dt' => 5 ),
    array( 'db' => 'namasatker', 'dt' => 6 )
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

// Kondisi Where
$where = '	kodesektor is not null and
			kodesatker is not null and
			kodeunit is not null and
			gudang is not null and
			kd_ruang is not null' ;

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
