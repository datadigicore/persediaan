<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();

// Table yang di load
$table = 'transfer';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'nm_satker', 'dt' => 1 ),
    array( 'db' => 'nm_satker_msk', 'dt' => 2 ),
    array( 'db' => 'no_dok', 'dt' => 3 ),
    array( 'db' => 'tgl_dok', 'dt' => 4 ),
    array( 'db' => 'nm_brg', 'dt' => 5 ),
    array( 'db' => 'spesifikasi', 'dt' => 6 ),
    array( 'db' => 'qty', 'dt' => 7, 'formatter' => function($d,$row){if(ceil($d)!=$d or floor($d)!=$d) {return number_format(abs($d),2,",",".");} else { return number_format(abs($d),0,",",".");} } ),
    array( 'db' => 'satuan', 'dt' => 8 ),
    
        array( 'db' => 'status', 'dt' => 9,'formatter' => function($d,$row){
            if($d==0){
             return 'Belum Diusulkan';
                
            }
            elseif($d==1)
            {
                    return '<div class="row-fluid">'.'<button id="btnkonfirm" class="btn btn-flat btn-success btn-xs"><i class="fa fa-remove"></i> Setujui Transfer</button>'. '</div>';  
            }
            elseif($d==2)
            {
                return 'Sudah Ditransfer';    
            }
            else
            {
                return 'Usulan Telah Ditolak';
            }
    }),  
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();
    $where = "status>0 and qty>0";


// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 