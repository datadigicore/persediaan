<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University

// Table yang di load
$table = 'log_selisip';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'kd_upb', 'dt' => 1 ),
    array( 'db' => 'nm_upb', 'dt' => 2 ),
    array( 'db' => 'tgl_input', 'dt' => 3 ),
    array( 'db' => 'thn_aktif', 'dt' => 4 ),
    array( 'db' => 'status', 'dt' => 5, 'formatter' => function($d,$row){ 
        if($d==1){
            return '<button id="btnrefresh" class="btn btn-flat btn-success btn-xs"><i class="fa fa-refresh"></i> Refresh</button>';
        }
        elseif($d==2) {
            return '<button id="btnwarning" class="btn btn-flat btn-warning btn-xs"><i class="fa fa-remove"></i> Warning</button>';
        }
        else{
        }
    })
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
