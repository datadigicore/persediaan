<?php
  include ('../config/filepath.php');
  $filepath = $path_laporan.$_GET['file'];
  $namafile_web="$base_path"."file_laporan/".$_GET['file'];
  
if(!empty($_GET['file'])){
    $fileName = basename($_GET['file']);
    $filePath = "$base_path"."file_laporan/".$fileName;
    if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        
        // Read the file
        readfile($filePath);
        exit;
    }else{
        echo 'The file does not exist.';
    }
}
?>