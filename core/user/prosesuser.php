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
			$kdunitsat = $purifier->purify($_POST['kdunitsat']);
			$User->bacadata($kdunitsat);
		break;
		case 'adduser':
			$user_name = $purifier->purify($_POST['username']);
			$user_pass = $purifier->purify(md5($_POST['password']));
			$email = $purifier->purify($_POST['email']);
			$kdunitsat = $purifier->purify($_POST['kdunitsat']);
			$urunitsat = $purifier->purify($_POST['urunith']);
			$data = array(
				"user_name" => $user_name,
				"user_pass" => $user_pass,
				"user_email" => $email,
		    	"kd_lokasi" => $kdunitsat,
		    	"nm_satker" => $urunitsat
		    );
			$User->tambahuser($data);
		break;
		case 'ubahuser':
			$user_name = $purifier->purify($_POST['username']);
			$user_pass = $purifier->purify(md5($_POST['password']));
			$email = $purifier->purify($_POST['email']);
			$kd_lokasi = $purifier->purify($_POST['kdsatker']);
			$data = array(
				"user_name" => $user_name,
				"user_pass" => $user_pass,
				"user_email" => $email,
		    	"kd_lokasi" => $kd_lokasi
		    );
			$User->tambahuser($data);
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