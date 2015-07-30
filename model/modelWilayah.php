<?php
include('../../utility/mysql_db.php');
class modelWilayah extends mysql_db
{
	public function tambahwilayah($data)
	{
		$kd_wil = $data['kd_wil'];
		$nm_wil = $data['nm_wil'];
		$query = "Insert into wilayah
        			set kd_wil='$kd_wil',
                    	nm_wil='$nm_wil'";
        $result = $this->query($query);
		return $result;
	}	

	public function ubahwilayah($data)
	{
		$kd_wil = $data['kd_wil'];
		$nm_wil = $data['nm_wil'];
		$query = "update wilayah
        			set kd_wil='$kd_wil',
                    	nm_wil='$nm_wil' where kd_wil='$kd_wil'";
        $result = $this->query($query);
		return $result;
	}	

	public function hapuswilayah($data)
	{
		$query = "delete from wilayah where kd_wil='$data'";
        $result = $this->query($query);
		return $result;
	}
}
?>