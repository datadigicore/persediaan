<?php
include('../../utility/mysql_db.php');
class modelUapb extends mysql_db
{
	public function tambahuapb($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$nm_uapb = $data['nm_uapb'];
		$query = "Insert into uapb
        			set kd_uapb='$kd_uapb',
                    	nm_uapb='$nm_uapb'";
        $result = $this->query($query);
		return $result;
	}	
	public function ubahuapb($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$nm_uapb = $data['nm_uapb'];
		$query = "update uapb
        			set kd_uapb='$kd_uapb',
                    	nm_uapb='$nm_uapb'
                    where kd_uapb='$kd_uapb'";
        print_r($query);
        $result = $this->query($query);
		return $result;
	}	
	public function hapusuapb($data)
	{
		$query = "delete from uapb where kd_uapb='$data'";
        $result = $this->query($query);
		return $result;
	}
}
?>