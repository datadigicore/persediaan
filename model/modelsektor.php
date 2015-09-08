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
		$id = $data['id'];
		$idsektor = $data['idsektor'];
		$query = "delete from satker where satker_id='$id';";
		$query.= "delete from satker where kode like '$idsektor.%';";
        $result = $this->multi_query($query);
		return $result;
	}

	public function loghistory($data)
	{
		$kodesektor = $data['kd_sektor'];
		$namasektor = $data['nm_sektor'];
		$username = $data['username'];
		$tanggal = $data['tanggal'];
		$aksi = $data['aksi'];
		$tahun = $data['tahun'];
		$query = "INSERT into log_history
        			set username='$username',
                    	aksi='$aksi',
                    	ket_kdsatker='$kodesektor',
                    	ket_nmsatker='$namasektor',
                    	keterangan='Tahun Anggaran $tahun',
                    	thnanggaran='$tahun',
                    	tanggal='$tanggal'";
        $result = $this->query($query);
		return $result;
	}	
}
?>