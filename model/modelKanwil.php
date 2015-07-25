<?php
include('../../utility/mysql_db.php');
class modelKanwil extends mysql_db
{
	public function tambahkanwil($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_kanwil = $data['kd_kanwil'];
		$nm_kanwil = $data['nm_kanwil'];
		$query = "Insert into kanwil
        			set kd_uapb='$kd_uapb',
        			kd_uappbe1='$kd_uappbe1',
        			kd_kanwil='$kd_kanwil',
                    nm_kanwil='$nm_kanwil'";
        $result = $this->query($query);
		return $result;
	}
}
?>