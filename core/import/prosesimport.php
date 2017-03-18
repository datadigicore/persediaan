<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
require_once __DIR__ . '/../../utility/ExcelReader.php';
include('../../model/modelTransaksi.php');
include('../../config/purifier.php');
// include('../../config/user.php');
session_start();
$Transaksi = new modelTransaksi();
$path_upload = "/srv/www/htdocs/persediaan2016/dist/uploads/";
// $path_upload = "/var/www/html/persediaan/dist/uploads/";
// $path_upload = "C:/xampp/htdocs/persediaan/dist/uploads/";
if (empty($_POST['manage'])) {
  echo "Error Data Tidak Tersedia";
}
else
{
  $manage = $_POST['manage'];
  switch ($manage)
  {
    case 'cekTransaksi':
      $result = $Transaksi->cekAllTrans($_SESSION['kd_lok']);
      if (empty($result) && $_SESSION['kd_lok'] == '08.01.01.01') {
        echo '<li id="file_import"><a href="importSaldoAwal"><i class="fa fa-file-excel-o"></i> <span>Import File Saldo Awal</span></a></li>';
      }
    break;
    case 'create':
      $result = $Transaksi->cekAllTrans($_SESSION['kd_lok']);
      if (empty($result)) {
        if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
          $path = $_FILES['fileimport']['name'];
          $ext  = pathinfo($path, PATHINFO_EXTENSION);
          if($ext != 'xls' && $ext != 'xlsx') {
            echo "Kesalahan File yang di Upload Tidak Sesuai";
            header('location:../../user/importSaldoAwal');
          }
          else {
            $time        = time();
            $target_dir  = $path_upload;
            $target_name = basename(date("Ymd-His-\O\P\N\A\M\E.",$time).$ext);
            $target_file = $target_dir . $target_name;
            $response    = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
            if($response) {
              try {
                $objPHPExcel = PHPExcel_IOFactory::load($target_file);
              }
              catch(Exception $e) {
                die('Kesalahan! Gagal dalam mengupload file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
              }
              $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,FALSE,TRUE);
              $data_insert    = array(
                "tanggal"    => date("Y-m-d H:i:s",$time),
                "filename"   => $path,
                "filesave"   => $target_name
              );
              $Transaksi->importSaldoAwal($allDataInSheet);
              header('location:../../user/trans_masuk');
            }
          }
        }
        else {
          header('location:../../user/importSaldoAwal');
        }
      }
      else {
        header('location:../../user/importSaldoAwal');
      }
    break;
    case 'importBarang':
      if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
        $path = $_FILES['fileimport']['name'];
        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        if($ext != 'xls' && $ext != 'xlsx') {
          echo "Kesalahan File yang di Upload Tidak Sesuai";
          header('location:../../admin/subkelbar');
        }
        else {
          $time        = time();
          $target_dir  = $path_upload;
          $target_name = basename(date("Ymd-His-\I\M\P\O\R\T.",$time).$ext);
          $target_file = $target_dir . $target_name;
          $response    = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
          // die();
          if($response) {
            try {
              $objPHPExcel = PHPExcel_IOFactory::load($target_file);
            }
            catch(Exception $e) {
              die('Kesalahan! Gagal dalam mengupload file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,FALSE,TRUE);
            $Transaksi->importBarang($allDataInSheet);
            header('location:../../admin/subkelbar');
          }
        }
      }
      else {
        header('location:../../admin/subkelbar');
      }
    break;
    case 'importTransMasuk':
      if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
        $path = $_FILES['fileimport']['name'];
        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        if($ext != 'xls' && $ext != 'xlsx') {
          echo "Kesalahan File yang di Upload Tidak Sesuai";
          header('location:../../user/trans_masuk');
        }
        else {
          $time        = time();
          $target_dir  = $path_upload;
          $target_name = basename(date("Ymd-His-\T\R\A\N\S\M\A\S\U\K.",$time).$ext);
          $target_file = $target_dir . $target_name;
          $response    = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
          if($response) {
            try {
              $objPHPExcel = PHPExcel_IOFactory::load($target_file);
            }
            catch(Exception $e) {
              die('Kesalahan! Gagal dalam mengupload file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,FALSE,TRUE);
            if (count($allDataInSheet[10]) == 15) {
              $Transaksi->temporaryImportTransMasuk($allDataInSheet);
              header('location:../../admin/temp_import_masuk');
            }
            else {
              $Transaksi->importTransMasuk($allDataInSheet);
              header('location:../../admin/temp_import_masuk');
            }
          }
        }
      }
      else {
        header('location:../../admin/trans_masuk');
      }
    break;
    case 'importTransKeluar':
      if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
        $path = $_FILES['fileimport']['name'];
        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        if($ext != 'xls' && $ext != 'xlsx') {
          echo "Kesalahan File yang di Upload Tidak Sesuai";
          header('location:../../user/trans_masuk');
        }
        else {
          $time        = time();
          $target_dir  = $path_upload;
          $target_name = basename(date("Ymd-His-\T\R\A\N\S\M\A\S\U\K.",$time).$ext);
          $target_file = $target_dir . $target_name;
          $response    = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
          if($response) {
            try {
              $objPHPExcel = PHPExcel_IOFactory::load($target_file);
            }
            catch(Exception $e) {
              die('Kesalahan! Gagal dalam mengupload file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,FALSE,TRUE);
            if (count($allDataInSheet[10]) == 11) {
              $Transaksi->temporaryImportTransKeluar($allDataInSheet);
              header('location:../../admin/temp_import_keluar');
            }
            else {
              $Transaksi->importTransKeluar($allDataInSheet);
              header('location:../../admin/temp_import_keluar');
            }
          }
        }
      }
      else {
        header('location:../../admin/trans_keluar');
      }
    break;
    case 'importTransTransfer':
      if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
        $path = $_FILES['fileimport']['name'];
        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        if($ext != 'xls' && $ext != 'xlsx') {
          echo "Kesalahan File yang di Upload Tidak Sesuai";
          header('location:../../admin/transfer');
        }
        else {
          $time        = time();
          $target_dir  = $path_upload;
          $target_name = basename(date("Ymd-His-\T\R\A\N\S\F\E\R.",$time).$ext);
          $target_file = $target_dir . $target_name;
          $response    = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
          if($response) {
            try {
              $objPHPExcel = PHPExcel_IOFactory::load($target_file);
            }
            catch(Exception $e) {
              die('Kesalahan! Gagal dalam mengupload file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,FALSE,TRUE);
            if (count($allDataInSheet[10]) == 11) {
              $Transaksi->temporaryImportTransTransfer($allDataInSheet);
              header('location:../../admin/temp_import_transfer');
            }
            else {
              $Transaksi->importTransTransfer($allDataInSheet);
              header('location:../../admin/temp_import_transfer');
            }
          }
        }
      }
      else {
        header('location:../../admin/transfer');
      }
    break;
    case 'importRekening':
      if(isset($_POST) && !empty($_FILES['fileimport']['name'])) {
        $path = $_FILES['fileimport']['name'];
        $ext  = pathinfo($path, PATHINFO_EXTENSION);
        if($ext != 'xls' && $ext != 'xlsx') {
          echo "Kesalahan File yang di Upload Tidak Sesuai";
          header('location:../../admin/subkelbar');
        }
        else {
          $time        = time();
          $target_dir  = $path_upload;
          $target_name = basename(date("Ymd-His-\R\E\K\E\N\I\N\G.",$time).$ext);
          $target_file = $target_dir . $target_name;
          $response    = move_uploaded_file($_FILES['fileimport']['tmp_name'],$target_file);
          if($response) {
            try {
              $objPHPExcel = PHPExcel_IOFactory::load($target_file);
            }
            catch(Exception $e) {
              die('Kesalahan! Gagal dalam mengupload file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,FALSE,TRUE);
            $Transaksi->importRekening($allDataInSheet);
            header('location:../../admin/koderek');
          }
        }
      }
      else {
        header('location:../../admin/koderek');
      }
    break;
    case 'read':
      $tahun = $_SESSION['thn_ang'];
      $Transaksi->bacaunit($tahun);
    break;
    case 'update':
      $Transaksi->ubahunit($purifier->purifyArray($_POST));
    break;
    case 'delete':
      $Transaksi->hapusunit($_POST['id']);
    break;
    default:
      echo "Error Data Tidak Tersedia";
    break;
  }
}

?>
