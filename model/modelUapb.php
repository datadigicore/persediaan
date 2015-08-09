<?php
include('../../utility/mysql_db.php');
class modelUapb extends mysql_db
{
	public function tambahuapb($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$nm_uapb = $data['nm_uapb'];
		$query = "Insert into satker
        			set kd_uapb='$kd_uapb',
                    	nm_satker='$nm_uapb',
                    	kode='$kd_uapb'";
        $result = $this->query($query);
		return $result;
	}	
	public function ubahuapb($data)
	{
		$id = $data['id'];
		$kd_uapb = $data['kd_uapb'];
		$nm_uapb = $data['nm_uapb'];
		$query = "update satker
        			set kd_uapb='$kd_uapb',
                    	nm_satker='$nm_uapb',
                    	kode='$kd_uapb' 
                    where id='$id'";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusuapb($data)
	{
		$query = "delete from satker where id='$data'";
        $result = $this->query($query);
		return $result;
	}
}
?>