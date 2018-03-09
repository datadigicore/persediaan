<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'].$_SESSION['kd_ruang'];
$thn_ang=$_SESSION['thn_ang'];
// Table yang di load
$table = 'opname';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ), 
    array( 'db' => 'kd_lokasi', 'dt' => 1 ), 
    array( 'db' => 'nm_satker', 'dt' => 2 ), 
    array( 'db' => 'no_dok', 'dt' => 3 ),
    array( 'db' => 'tgl_dok', 'dt' => 4 ),
    array( 'db' => 'keterangan', 'dt' => 5 ),
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();
$str = $kd_satker;
$skpd_criteria = "";
if ($str=="") {
    $skpd_criteria = "";   
}
else if (substr_count($str,".") == 0 and substr_count($str,".") <=2) {
    $skpd_criteria = "concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_satker%'  and";   
}
else{
    $skpd_criteria = "concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$kd_satker'  and"; 
}


    $where = "$skpd_criteria thn_ang='$thn_ang' group by no_dok ";

// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere( $_GET, $sql_details, $table, $primaryKey, $columns, $where)
); 
