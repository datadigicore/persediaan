<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();
$user_id=$_SESSION['username'];
$kd_satker=$_SESSION['kd_lok'].$_SESSION['kd_ruang'];
$kd_ruang=$_SESSION['kd_ruang'];
$thn_ang=$_SESSION['thn_ang'];
// Table yang di load
$table = 'transaksi_masuk';
$query_ruang="";
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'jns_trans', 'dt' => 1,'formatter' => function($d,$row){if($d=="M01"){return "Saldo Awal";}elseif($d=="M02"){return "Pembelian";}elseif($d=="M03"){return "Hibah Masuk";}elseif($d=="M04"){return "Perolehan Lainnya";}elseif($d=="M06"){return "Transfer ";} elseif ($d=="M07"){ return "APBD"; }{
        # code...
    }} ),
    array( 'db' => 'no_dok', 'dt' => 2 ),
    array( 'db' => 'no_bukti', 'dt' => 3 ),
    array( 'db' => 'tgl_dok', 'dt' => 4, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'tgl_buku', 'dt' => 5, 'formatter' => function($d,$row){return date('d-m-Y',strtotime($d));}),
    array( 'db' => 'keterangan', 'dt' => 6 ),
    array( 'db' => 'jns_trans', 'dt' => 7,'formatter' => function($d,$row){if($d!="M06"){ return '<div class="row-fluid">'.
                                                                                                  '<button id="btntmbh" class="col-xs-6 btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah</button>'.
                                                                                                  '<button id="btnedt" class="col-xs-6 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'.
                                                                                                '</div>'; 
                                                                                        }
                                                                                        else{
                                                                                            return '<button id="btntmbh" class="col-xs-10 btn btn-info btn-flat btn-xs pull-center"><i class="fa fa-plus"></i> Lihat Item</button>';
                                                                                        }
                                                                                                 } 
        ),
);
 
// if($kd_ruang!=""){ $query_ruang="and kd_ruang='$kd_ruang'"; } else $query_ruang="and kd_ruang is null ";; 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();

$str = $kd_satker;
if (substr_count($str,".") == 0) {
    $where = "kd_lokasi like '$kd_satker.%.%.%'  and thn_ang='$thn_ang'  and jns_trans not in ('P01','P02','M01I')  group by no_dok";   
}
else if (substr_count($str,".") == 1) {
    $where = "kd_lokasi like '$kd_satker.%.%'  and thn_ang='$thn_ang'  and jns_trans not in ('P01','P02','M01I')  group by no_dok";   
}
else if (substr_count($str,".") == 2) {
    $where = "kd_lokasi like '$kd_satker.%'  and thn_ang='$thn_ang'  and jns_trans not in ('P01','P02','M01I')  group by no_dok";
}
else{
    $where = "concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker'  and thn_ang='$thn_ang' and jns_trans not in ('P01','P02','M01I')  group by no_dok";
}
 
// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
