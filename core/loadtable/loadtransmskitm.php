<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
if ($_SESSION['level']==1) {
    $kd_satker = $_GET['kd_sat'];
}
else {
    $kd_satker = $_SESSION['kd_lok'];
}
$kd_ruang=trim($_SESSION['kd_ruang']);
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
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'no_dok', 'dt' => 1 ),
    array( 'db' => 'kd_brg', 'dt' => 2
        ,
        'formatter' => function($d,$row){
            return "<b>$d </b>"."<br>(".$row[13]." ".$row[12].")";
         } 
     ),
    array( 'db' => 'nm_brg', 'dt' => 3 ),
    array( 'db' => 'spesifikasi', 'dt' => 4 ),
    array( 'db' => 'qty', 'dt' => 5, 'formatter' => function($d,$row){if(ceil($d)!=$d or floor($d)!=$d) {return number_format($d,2,",",".");} else { return number_format($d,0,",",".");} } ),
    array( 'db' => 'satuan', 'dt' => 6 ),
    array( 'db' => 'harga_sat', 'dt' => 7, 'formatter' => function($d,$row){return number_format($d,2,",",".");} ),
    array( 'db' => 'total_harga', 'dt' => 8, 'formatter' => function($d,$row){return number_format($d,2,",",".");}),

    array( 'db' => 'untuk', 'dt' => 9 ),
    array( 'db' => 'qty_akhir', 'dt' => 10, 'formatter' => function($d,$row){if(ceil($d)!=$d or floor($d)!=$d) {return number_format($d,2,",",".");} else { return number_format($d,0,",",".");} }  ),
    array( 'db' => 'jns_trans', 'dt' => 11,'formatter' => function($d,$row){if($d=="M07"){ return '<div class="row-fluid">'.'<button id="btnhps" class="btn btn-flat btn-danger btn-xs col-xs-12"><i class="fa fa-remove"></i> Hapus</button>'.'<button id="btnedt" class="btn btn-success btn-xs btn-flat col-xs-12"><i class="fa fa-edit"></i> Edit</button>'.'<button id="edit_rek_brg" class="btn btn-primary btn-xs btn-flat col-xs-12"><i class="fa fa-edit"></i>Ubah Rekening</button>'.
            '</div>';
    }
    elseif($d!="M06"){
        return '<div class="row-fluid">'.'<button id="btnhps" class="btn btn-flat btn-danger btn-xs col-xs-12"><i class="fa fa-remove"></i> Hapus</button>'.'<button id="btnedt" class="btn btn-success btn-xs btn-flat col-xs-12"><i class="fa fa-edit"></i> Edit</button>
            </div>';

    }
    else{
        return '-';
    }
             }  ),
    array( 'db' => 'nama_rekening', 'dt' => 12 ),
    array( 'db' => 'kode_rekening', 'dt' => 13 ),
    array( 'db' => 'kd_brg', 'dt' => 14 )
    // array( 'db' => 'total_harga', 'dt' => 8 ),
    // array( 'db' => 'keterangan', 'dt' => 9 ),





);

if($kd_ruang!="") $query_ruang="and kd_ruang='$kd_ruang' ";
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
//     $where = "kd_lokasi='$kd_satker' and status_hapus=0 and thn_ang='$thn_ang' and no_dok = '$no_dok' and qty>0 ".$query_ruang." ";
// }
$where = "no_dok = '$no_dok' and qty>0 ".$query_ruang;
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
);
