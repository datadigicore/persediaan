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
    array( 'db' => 'kd_lokasi', 'dt' => 1 ),
    array( 'db' => 'nm_satker', 'dt' => 2 ),
    array( 'db' => 'kd_ruang', 'dt' => 3 ),
    array( 'db' => 'jns_trans', 'dt' => 4, 'field' => 'jns_trans', 'as' => 'jns_trans',
        'formatter' => function($d,$row){
            if($d=="M01"){
                return "Saldo Awal";}
            elseif($d=="M02"){
                return "Pembelian";}
            elseif($d=="M03"){
                return "Hibah Masuk";}
            elseif($d=="M04"){
                return "Perolehan Lainnya";}
            elseif($d=="M06"){
                return "Transfer ";}
            elseif ($d=="M07"){
                return "APBD"; }
            elseif ($d=="M08"){
                return "Bantuan Pem. Pusat"; }
            elseif ($d=="M09"){
                return "Bantuan Pem. Prov."; }
            elseif ($d=="M10"){
                return "BOS"; }
            elseif ($d=="M11"){
                return "BLUD"; }
            elseif ($d=="M12"){
                return "Lainnya"; }
                {
        # code...
    }} ),
    array( 'db' => 'no_dok', 'dt' => 5 ),
    array( 'db' => 'tgl_dok', 'dt' => 6, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 7, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'keterangan', 'dt' => 8 ),





);

// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();


    $where = "thn_ang='$thn_ang' and jns_trans not in ('P01','P02','M01I')  group by no_dok";


// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
);
