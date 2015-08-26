<?php
include('../../utility/mysql_db.php');
class modelSektor extends mysql_db
{
	public function tambahsektor($data)
	{
		$kodesektor = $data['kd_sektor'];
		$namasektor = $data['nm_sektor'];
		$tahun = $data['tahun'];
		$query = "Insert into satker
        			set kodesektor='$kodesektor',
                    	namasatker='$namasektor',
                    	tahun='$tahun',
                    	kode='$kodesektor'";
        $result = $this->query($query);
		return $result;
	}	
	public function ubahsektor($data)
	{
		$id = $data['id'];
		$kodesektor = $data['kd_sektor'];
		$namasektor = $data['nm_sektor'];
		$query = "update satker
        			set kodesektor='$kodesektor',
                    	namasatker='$namasektor',
                    	kode='$kodesektor' 
                    where satker_id='$id'";
        $result = $this->query($query);
		return $result;
	}	
	public function hapussektor($data)
	{
		$query = "delete from satker where satker_id='$data'";
        $result = $this->query($query);
		return $result;
	}
}
?>