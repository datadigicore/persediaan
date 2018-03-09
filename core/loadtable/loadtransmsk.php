<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'].trim($_SESSION['kd_ruang']);
$kd_ruang=$_SESSION['kd_ruang'];
$thn_ang=$_SESSION['thn_ang'];
// Table yang di load
$table = 'transaksi_masuk';
$query_ruang="";
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0, 'field' => 'id', 'as' => 'id'  ),
    array( 'db' => 'nm_satker', 'dt' => 1, 'field' => 'nm_satker', 'as' => 'nm_satker'  ),
    array( 'db' => 'jns_trans', 'dt' => 2, 'field' => 'jns_trans', 'as' => 'jns_trans',
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
    array( 'db' => 'no_dok', 'dt' => 3,  'field' => 'no_dok', 'as' => 'no_dok' ),
    array( 'db' => 'no_bukti', 'dt' => 4,  'field' => 'no_bukti', 'as' => 'no_bukti' ),
    array( 'db' => 'tgl_dok', 'dt' => 5,  'field' => 'tgl_dok',  'as' => 'tgl_dok', 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 6,  'field' => 'tgl_buku',  'as' => 'tgl_buku', 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'keterangan', 'dt' => 7,  'field' => 'keterangan', 'as' => 'keterangan' ),
    array( 'db' => 'SUM(`total_harga`)', 'dt' => 8,  'field' => 'total_harga', 'as' => 'total_harga',
            'formatter'=> function($d,$row){
                return number_format($d,2,",",".");
            }),
    array( 'db' => 'SUM(`nilai_kontrak`)', 'dt' => 9,  'field' => 'nilai_kontrak', 'as' => 'nilai_kontrak',
            'formatter'=> function($d,$row){
                return number_format($d,2,",",".");
            }),
    array( 'db' => 'jns_trans', 'dt' => 10, 'field' => 'jns_trans', 'as' => 'jns_trans','formatter' => function($d,$row){
        if($row[7]==0){
            return '<div class="row-fluid">'.
                    '<button id="del_dok" class="col-xs-12 btn btn-danger btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Hapus Dokumen </button>'.
                    '<button id="btntmbh" class="col-xs-12 btn btn-primary btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah / Lihat Barang</button>'.
                    '<button id="btnedt" class="col-xs-12 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit Dokumen</button>';
        }

        if($d!="M06"){ 
            return '<div class="row-fluid">'.
                        '<button id="btntmbh" class="col-xs-12 btn btn-primary btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah / Lihat Barang</button>'.
                        '<button id="btnedt" class="col-xs-12 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit Dokumen</button>';
                        
            
        }
        else{
            return '<button id="btntmbh" class="col-xs-10 btn btn-info btn-flat btn-xs pull-center"><i class="fa fa-plus"></i> Lihat Item</button>';
        }
       
        return '</div>';
                            } 
        ),
);
 

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
    // $where = "concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_satker%'  and thn_ang='$thn_ang' and jns_trans not in ('P01','P02','M01I')  group by no_dok";
    $where = "$skpd_criteria thn_ang='$thn_ang' and jns_trans not in ('P01','P02','M01I')  group by no_dok";

 
// Pengaturan Output Server Side Processing
require( '../../config/ssp-join.php' );
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, " FROM `{$table}`", $where )
); 
