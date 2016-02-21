<?php
include('../../model/modelUpb.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$upb = new modelUpb();
if (empty($_POST['manage'])) {
  echo "Error Data Tidak Tersedia";
}
else
{
  $manage = $_POST['manage'];
  switch ($manage)
  {
    case 'createsubbag':
      $row      = explode('.', $_POST['kdupb']);
      $data     = array(
        "kodesektor" => $row[0],
        "kodesatker" => $row[1],
        "kodeunit"   => $row[2],
        "kodeupb"    => $row[3],
        "kdsubbag"   => $purifier->purify($_POST['kdsubbag']),
        "nmsubbag"   => $purifier->purify($_POST['nmsubbag']),
        "tahun"      => $_SESSION['thn_ang']
      );
      $upb->tambahsubbag($data);
    break;
    case 'readupb':
      $tahun = $_SESSION['thn_ang'];
      $upb->bacaunit($tahun);
    break;
    case 'updatesubbag':
      $upb->ubahunit($purifier->purifyArray($_POST));
    break;
    case 'deletesubbag':
      $upb->hapusunit($_POST['id']);
    break;
    default:
      echo "Error Data Tidak Tersedia";
    break;
  }
}

?>