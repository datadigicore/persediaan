<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
if ($_SESSION['level'] == 1 AND isset($_GET['kd_sat'])) {
    $kd_satker = $_GET['kd_sat'];
}
else {
    $kd_satker = $_SESSION['kd_lok'];
}
$kd_ruang=$_SESSION['kd_ruang'];
$thn_ang=$_SESSION['thn_ang'];
$query_ruang="";
$no_dok = $_GET['no_dok'];
// echo $no_dok;
// Table yang di load
$table = 'transaksi_masuk';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id',           
           'dt' => 0 ),
    array( 'db' => 'kode_rekening',
           'dt' => 1 ),
    array( 'db' => 'nama_rekening',
           'dt' => 2 ),
    array( 'db' => 'nilai_kontrak',
           'dt' => 3,
           'formatter' => function($d,$row){
                                return number_format($d,2,",",".");
                            } 
    ),
    array( 'db' => 'ket_rek',      
           'dt' => 4 ),
    array( 'db' => 'status',       
           'dt' => 5,
           'formatter' => function($d,$row){
                            return '<div class="row-fluid">'.
                                        '<button id="hapus_rek" class="btn btn-flat btn-danger btn-xs col-xs-12"><i class="fa fa-remove"></i> Hapus</button>'.
                                        '<button id="edit_rek" class="btn btn-success btn-xs btn-flat col-xs-12"><i class="fa fa-edit"></i> Edit</button>'.
                                    '</div>';  
}
            ),
);

// if($kd_ruang!="") $query_ruang="and kd_ruang='$kd_ruang' "; 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
// if (substr_count($str,".") == 0) {
//     $where = "kd_lokasi like '$kd_satker.%.%.%' and status_hapus=0 and thn_ang='$thn_ang' and no_dok = '$no_dok' and qty>0";
// }
// else if (substr_count($str,".") == 1) {
//     $where = "kd_lokasi like '$kd_satker.%.%' and status_hapus=0 and thn_ang='$thn_ang' and no_dok = '$no_dok' and qty>0";
// }
// else if (substr_count($str,".") == 2) {
//     $where = "kd_lokasi like '$kd_satker.%' and status_hapus=0 and thn_ang='$thn_ang' and no_dok = '$no_dok' and qty>0";
// }
// else{
//     $where = "kd_lokasi='$kd_satker'  and thn_ang='$thn_ang' and no_dok = '$no_dok' and kode_rekening!='' and kd_brg='' ".$query_ruang." ";
// }

$where = "thn_ang='$thn_ang' and no_dok = '$no_dok' and nilai_kontrak>0 and kd_brg='' ".$query_ruang." ";
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
