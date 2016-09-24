<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$user_level=$_SESSION['level'];
$kd_satker=$_SESSION['kd_lok'];
$thn_ang=$_SESSION['thn_ang'];
$kd_ruang=$_SESSION['kd_ruang'];
$query_ruang="";
$no_dok = urldecode($_GET['no_dok']);
// Table yang di load
$table = 'transfer';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'no_dok', 'dt' => 1 ),
    array( 'db' => 'kd_brg', 'dt' => 2, ),
    array( 'db' => 'nm_brg', 'dt' => 3 ),
    array( 'db' => 'spesifikasi', 'dt' => 4 ),
    array( 'db' => 'qty', 'dt' => 5, 'formatter' => function($d,$row){if(ceil($d)!=$d or floor($d)!=$d) {return number_format(abs($d),2,",",".");} else { return number_format(abs($d),0,",",".");} } ),
    array( 'db' => 'satuan', 'dt' => 6 ),
    array( 'db' => 'harga_sat', 'dt' => 7, 'formatter' => function($d,$row){return number_format($d,2,",",".");} ),
    array( 'db' => 'total_harga', 'dt' => 8, 'formatter' => function($d,$row){if(ceil($d)!=$d or floor($d)!=$d) {return number_format(abs($d),2,",",".");} else { return number_format(abs($d),0,",",".");} } ),
    array( 'db' => 'keterangan', 'dt' => 9 ),
    array( 'db' => 'status', 'dt' => 10,'formatter' => function($d,$row){
        if($d==0){
           if($_SESSION['level']==2){  
                return  '<div class="row-fluid">'.'<button id="btnbatal" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Batalkan Transfer</button>'. '</div>'.
                    '<div class="row-fluid">'.'<button id="btnusul" class="btn btn-flat btn-warning btn-xs"><i class="fa fa-level-up"></i> Usulkan Transfer</button>'. '</div>';
                    
            }
            else{
                return 'Belum Diusulkan';
            } 
        }
        elseif($d==1)
        {
            if($_SESSION['level']==2){
                return 'Telah Diajukan';  
            }
            else{
                return '<div class="row-fluid">'.'<button id="btnkonfirm" class="btn btn-flat btn-success btn-xs"><i class="fa fa-remove"></i> Konfirmasi Transfer</button>'. '</div>';
            }
            
        }
        elseif($d==2)
        {
            return 'Sudah Ditransfer';    
        }
        else
        {
            return 'Usulan Ditolak';
        }
    }),
        array( 'db' => 'kd_lokasi', 'dt' => 11 ),
        array( 'db' => 'kd_lok_msk', 'dt' => 12 ),
        array( 'db' => 'kd_ruang_msk', 'dt' => 13 ),
        array( 'db' => 'nm_satker', 'dt' => 14 ),
        array( 'db' => 'nm_satker_msk', 'dt' => 15 ),
        array( 'db' => 'kd_brg', 'dt' => 16 ),
        array( 'db' => 'nm_brg', 'dt' => 17 ),
        array( 'db' => 'satuan', 'dt' => 18 ),
        array( 'db' => 'qty', 'dt' => 19 ),
        array( 'db' => 'jns_trans', 'dt' => 20 ),
    
    
    

);
 if($kd_ruang!="") $query_ruang="and kd_ruang='$kd_ruang' "; 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
if (substr_count($str,".") == 0) {
    $where = "kd_lokasi like '$kd_satker.%.%.%' and thn_ang='$thn_ang' and no_dok = '$no_dok' ";
}
else if (substr_count($str,".") == 1) {
    $where = "kd_lokasi like '$kd_satker.%.%' and thn_ang='$thn_ang' and no_dok = '$no_dok' ";
}
else if (substr_count($str,".") == 2) {
    $where = "kd_lokasi like '$kd_satker.%' and thn_ang='$thn_ang' and no_dok = '$no_dok' ";
}
else{
    $where = "kd_lokasi='$kd_satker' and thn_ang='$thn_ang' and no_dok = '$no_dok' ".$query_ruang." and qty>0";
}
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
