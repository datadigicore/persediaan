<?php
include('../../config/admin.php');
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
	array( 'db' => 'kd_ruang', 'dt' => 6,
        'formatter' => function( $d, $row ) {
            return $row[1].'.'.$row[2].'.'.$row[3].'.'.$row[4]/*.'-'.$row[5]*/;
        }
    ),
    array( 'db' => 'namasatker', 'dt' => 7 )
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();
$tahun = $_SESSION['thn_ang'];

// Kondisi Where
// $where = "	kodesektor is not null and
// 			kodesatker is not null and
// 			kodeunit is not null and
// 			gudang is not null and 
// 			tahun is null or
// 			tahun = '$tahun' and 
// 			CHAR_LENGTH(kode) = 11" ;
$where = "	kodesektor is not null and
			kodesatker is not null and
			kodeunit is not null and
			gudang is not null and
			kd_ruang is not null and
			CHAR_LENGTH(kode) = 11" ;

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
