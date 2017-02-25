<?php
include('../../model/modelUser.php');
include('../../config/purifier.php');
include('../../config/admin.php');
$User = new modelUser();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readsatker':
			$User->bacaunitsatker();
		break;
		case 'readdata':
			$kdunitgudang = $purifier->purify($_POST['kdunitgudang']);
			$User->bacadata($kdunitgudang);
		break;
		case 'adduser':
			$user_name = $purifier->purify($_POST['username']);
			$user_pass = $purifier->purify(md5($_POST['password']));
			$email = $purifier->purify($_POST['email']);
			$kdgudang = $purifier->purify($_POST['kdunitgudang']);
			$kodeSubUPB = $purifier->purify($_POST['kodeSubUPB']);
			$urgudang = $purifier->purify($_POST['urgudangh']);
			$tahun = $purifier->purify($_POST['tahun']);
			$data = array(
				"user_name" => $user_name,
				"user_pass" => $user_pass,
				"user_email" => $email,
		    	"kd_satker" => $kdgudang,
		    	"kodeSubUPB" => $kodeSubUPB,
		    	"nm_satker" => $urgudang,
		    	"tahun" => $tahun
		    );
			$User->tambahuser($data);
		break;
		case 'upduser':
			$data = $purifier->purifyArray($_POST);
			$User->ubahuser($data);
		break;
		case 'deluser':
			$id = $purifier->purify($_POST['id']);
			$User->hapususer($id);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>