<?php

#This code provided by:
#Yohanes Christomas Daimler(yohanes.christomas@gmail.com)
#Gunadarma University
//Mendapatkan Data Sesi Username dan kode satker
session_start();

// Table yang di load
$table = 'transfer';
$thn_ang = $_SESSION['thn_ang'];
// Primary Key table
$primaryKey = 'id';
 
// Load Data berdasarkan nama table nya
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'nm_satker', 'dt' => 1 ),
    array( 'db' => 'nm_satker_msk', 'dt' => 2 ),
    array( 'db' => 'no_dok', 'dt' => 3 ),
    array( 'db' => 'tgl_dok', 'dt' => 4 ),
    array( 'db' => 'nm_brg', 'dt' => 5 ),
    array( 'db' => 'spesifikasi', 'dt' => 6 ),
    array( 'db' => 'qty', 'dt' => 7, 'formatter' => function($d,$row){if(ceil($d)!=$d or floor($d)!=$d) {return number_format(abs($d),2,",",".");} else { return number_format(abs($d),0,",",".");} } ),
    array( 'db' => 'satuan', 'dt' => 8 ),
    
        array( 'db' => 'status', 'dt' => 9,'formatter' => function($d,$row){
                    if($d==0){
           if($_SESSION['level']==2 && $row['jns_trans']=="K07"){  
                return  '<div class="row-fluid">'.'<button id="btnbatal" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Batalkan Transfer</button>'. '</div>'.
                    '<div class="row-fluid">'.'<button id="btnusul" class="btn btn-flat btn-warning btn-xs"><i class="fa fa-level-up"></i> Usulkan Transfer</button>'. '</div>';
                    
            }
            elseif($_SESSION['level']==2 && $row['jns_trans']=="K06"){  
                return  '<div class="row-fluid">'.'<button id="btnkonfirm" class="btn btn-flat btn-success btn-xs"><i class="fa fa-check"></i> Eksekusi Transfer</button>'. '</div>';
                    
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
                return  '<div class="row-fluid">'.'<button id="btnkonfirm" class="btn btn-flat btn-success btn-xs"><i class="fa fa-check"></i> Eksekusi Transfer</button>'. '</div>';
            }
            
        }
        elseif($d==2)
        {
            return 'Sudah Ditransfer'.'<div class="row-fluid">'.'<button id="hapus_transfer" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> hapus Transfer</button>'. '</div>';;    
        }
        else
        {
            return 'Usulan Ditolak';
        }
    }),
    array( 'db' => 'kd_brg', 'dt' => 10 ),  
);
 
// Settingan Koneksi Datatable
require('../../config/dbconf.php');
$config = new config();
$sql_details = $config->sql_details();
    $where = "status>0 and qty>0 and status!=4 and thn_ang='$thn_ang' ";


// Pengaturan Output Server Side Processing
require( '../../config/ssp.class.php' );
echo json_encode(
    SSP::simplewhere($_GET, $sql_details, $table, $primaryKey, $columns, $where )
); 
