<?php
include('../../model/modelUser.php');
include('../../config/purifier.php');
$User = new modelUser();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'adduser':
			$user_name = $purifier->purify($_POST['user_name']);
			$user_pass = $purifier->purify(md5($_POST['user_pass']));
			$email = $purifier->purify($_POST['email']);
			$kd_lokasi = $purifier->purify($_POST['kduakpb']);
			$data = array(
				"user_name" => $user_name,
				"user_pass" => $user_pass,
				"user_email" => $email,
		    	"kd_lokasi" => $kd_lokasi
		    );
			$User->tambahuser($data);
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}
?>