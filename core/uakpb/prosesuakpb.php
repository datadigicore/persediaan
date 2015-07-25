<?php
include('../../model/modelUakpb.php');
include('../../config/purifier.php');
$Uakpb = new modelUakpb();
if (empty($_POST['manage'])) {
	echo "Error Data Tidak Tersedia";
}
else
{
	$manage = $_POST['manage'];
	switch ($manage)
	{
		case 'readuapb':
			$Uakpb->bacauapb();
		break;
		case 'readuappbe':
			$kduapb = $purifier->purify($_POST["kduapb"]);
			$Uakpb->bacauappbe($kduapb);
		break;
		case 'readuappbw':
			$kduapb = $purifier->purify($_POST["kduapb"]);
			$kduappbe = $purifier->purify($_POST["kduappbe"]);
			$data = array(
				'kd_uapb' => $kduapb,
				'kd_uappbe' => $kduappbe,
			);
			$Uakpb->bacauappbw($data);		
		break;
		case 'adduakpb':
			$kodeuapb = $purifier->purify($_POST['kodeuapb']);
			$kodeuappbe1 = $purifier->purify($_POST['kodeuappbe1']);
			$kodeuappbw = $purifier->purify($_POST['kodeuappbw']);
			$kodeuakpb = $purifier->purify($_POST['kodeuakpb']);
			$kodeuapkpb = $purifier->purify($_POST['kodeuapkpb']);
			$kodejk = $purifier->purify($_POST['kodejk']);
			$uraianuakpb = $purifier->purify($_POST['uraianuakpb']);

			$sql="insert into uakpb  values ('$kodeuapb','$kodeuappbe1','$kodeuappbw','$kodeuakpb','$kodeuapkpb','$kodejk','$uraianuakpb','asasasas')";
			if ($connect->query($sql) === TRUE)
			{
			    echo "Data Berhasil Ditambahkan";
			}
			else
			{
			    echo "Error: " . $sql . "<br>" . $connect->error;
			}
		break;
		default:
			echo "Error Data Tidak Tersedia";
		break;
	}
}

?>