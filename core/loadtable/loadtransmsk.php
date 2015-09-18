<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'];
$thn_ang=$_SESSION['thn_ang'];
// Table yang di load
$table = 'transaksi_masuk';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'jns_trans', 'dt' => 1 ),
    array( 'db' => 'no_dok', 'dt' => 2 ),
    array( 'db' => 'no_bukti', 'dt' => 3 ),
    array( 'db' => 'tgl_dok', 'dt' => 4, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 5, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    // array( 'db' => 'nm_brg', 'dt' => 5 ),
    // array( 'db' => 'qty', 'dt' => 6 ),
    // array( 'db' => 'harga_sat', 'dt' => 7 ),
    // array( 'db' => 'total_harga', 'dt' => 8 ),
    // array( 'db' => 'keterangan', 'dt' => 9 ),

    
    
    

);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$where = "kd_lokasi='$kd_satker' and status_hapus=0 and thn_ang='$thn_ang'  group by no_dok";
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
