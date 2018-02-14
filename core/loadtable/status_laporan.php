<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$path = "/var/www/html/persediaan";  
$path_laporan = "/var/www/html/persediaan/file_laporan/";
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'].trim($_SESSION['kd_ruang']);
$kd_ruang=$_SESSION['kd_ruang'];
$thn_ang=$_SESSION['thn_ang'];
// Table yang di load
$table = 'laporan';
$query_ruang="";
// Primary Key table
$primaryKey = 'id';
require('../../config/dbconf.php');
require('../../config/filepath.php');
$config = new config();
$sql_details = $config->sql_details();
// id   kd_lokasi   nm_satker   thn_ang Nama Laporan    tanggal nama_file   status

$columns = array(
    array( 'db' => 'id', 'dt' => 0, 'field' => 'id', 'as' => 'id'  ),
    array( 'db' => 'kd_lokasi', 'dt' => 1, 'field' => 'kd_lokasi', 'as' => 'kd_lokasi'  ),
    array( 'db' => 'nm_satker', 'dt' => 2, 'field' => 'nm_satker', 'as' => 'nm_satker'  ),
    array( 'db' => 'nama_laporan', 'dt' => 3, 'field' => 'nama_laporan', 'as' => 'nama_laporan'  ),
    array( 'db' => 'tanggal', 'dt' => 4, 'field' => 'tanggal', 'as' => 'tanggal'  ),
    array( 'db' => 'nama_file', 'dt' => 5, 'field' => 'nama_file', 'as' => 'nama_file'  ),
    array( 'db' => 'status', 'dt' => 6, 'field' => 'status', 'as' => 'status',
        'formatter' => function($d,$row){
            if($d=="1"){
                return "Sedang Diproses";
            }
            else{
                return "<a class='btn btn-flat btn-xs btn-success' href='download?file=$row[5]'>Download</a>";
            }
           }   ),

);
 




    $where = "kd_lokasi like '$kd_satker%'  and thn_ang='$thn_ang'";

 
// Pengaturan Output Server Side Processing
require( '../../config/ssp-join.php' );
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, " FROM `{$table}`", $where )
); 
