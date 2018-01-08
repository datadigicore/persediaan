<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=trim($_SESSION['kd_lok'].$_SESSION['kd_ruang']);
$thn_ang=$_SESSION['thn_ang'];
$kd_ruang=$_SESSION['kd_ruang'];
// Table yang di load
$table = 'transaksi_keluar';
 
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0, 'field' => 'id'  ),
    array( 'db' => 'jns_trans', 'dt' => 1, 'field' => 'jns_trans', 'formatter' => function($d,$row){if($d=="K01"){return "Habis Pakai";}elseif($d=="K02"){return "Transfer Keluar";}elseif($d=="K03"){return "Hibah Keluar";}elseif($d=="K04"){return "Usang";}else{return "Rusak";}} ),
    array( 'db' => 'no_dok', 'dt' => 2, 'field' => 'no_dok' ),
    array( 'db' => 'no_bukti', 'dt' => 3, 'field' => 'no_bukti' ),
    array( 'db' => 'tgl_dok', 'dt' => 4,'field' => 'tgl_dok' , 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 5,'field' => 'tgl_buku', 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'keterangan', 'dt' => 6, 'field' => 'keterangan' ),
    array( 'db' => 'SUM(`total_harga`)', 'dt' => 7, 'field' => 'total_harga', 'as' => 'total_harga', 'formatter' => function($d, $row){
            return number_format(abs($d), 2, ",",".");
    } ),

    array( 'db' => 'nm_satker', 'dt' => 8, 'field' => 'nm_satker' ),
    array( 'db' => 'SUM(`total_harga`)', 'dt' => 9, 'field' => 'total_harga', 'as' => 'total_harga', 'formatter' => function($d, $row){
            if($d==0){
                return '<div class="row-fluid">'.
                    '<button id="del_dok" class="col-xs-12 btn btn-danger btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Hapus Dokumen </button>'.
                    '<button id="btntmbh" class="col-xs-12 btn btn-primary btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah / Lihat Barang</button>'.
                    '<button id="btnedt" class="col-xs-12 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit Dokumen</button></div>';
            }
            elseif($row[1]!="K06" && $row[1]!="K07"){
                return '<div class="row-fluid">'.
                    '<button id="btntmbh" class="col-xs-12 btn btn-primary btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah / Lihat Barang</button>'.
                    '<button id="btnedt" class="col-xs-12 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit Dokumen</button></div>';
            }
            else{
                return "-";
            }

    } ),

);
if($kd_ruang!=""){ $query_ruang="and kd_ruang='$kd_ruang'"; } else $query_ruang="and (kd_ruang is null or kd_ruang='') ";
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

// $str = $kd_satker;
// if (substr_count($str,".") == 0) {
//     $where = "kd_lokasi like '$kd_satker.%.%.%' and status_hapus=0 and thn_ang='$thn_ang' and jns_trans not like 'P%'  group by no_dok";   
// }
// else if (substr_count($str,".") == 1) {
//     $where = "kd_lokasi like '$kd_satker.%.%' and status_hapus=0 and thn_ang='$thn_ang' and jns_trans not like 'P%'  group by no_dok";   
// }
// else if (substr_count($str,".") == 2) {
//     $where = "kd_lokasi like '$kd_satker.%' and status_hapus=0 and thn_ang='$thn_ang' and jns_trans not like 'P%'  group by no_dok";
// }
// else{
//     $where = "concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and status_hapus=0 and thn_ang='$thn_ang' and jns_trans not  in('P01','K06','K07')  group by no_dok"; 
// }
$where = "concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_satker%'  and thn_ang='$thn_ang' and jns_trans not in ('P01','K06','K07')  group by no_dok";
//echo $where;
// Pengaturan Output Server Side Processing
require( '../../config/ssp-join.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, "FROM {$table}", $where)
); 
