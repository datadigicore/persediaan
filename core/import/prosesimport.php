<?php
require_once __DIR__ . '/../../utility/PHPExcel/IOFactory.php';
require_once __DIR__ . '/../../utility/ExcelReader.php';
include('../../model/modelTransaksi.php');
include('../../config/purifier.php');
include('../../config/user.php');
$Transaksi = new modelTransaksi();
$path_upload = "/srv/www/htdocs/persediaan/dist/uploads/";
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
      if (empty($result)) {
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