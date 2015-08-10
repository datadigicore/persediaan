<?php
include('../../utility/mysql_db.php');
class modelUappbw extends mysql_db
{
	public function bacauapb()
	{
		$query = "select kd_uapb, nm_satker from satker
						where kd_uapb is not null and
							  kd_uappbe1 is null and
							  kd_uappbw is null and
							  kd_uakpb is null 
						order by kd_uapb asc";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode UAPB --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uapb'].' '.$row['nm_satker']."</option>";
		}	
	}
	public function bacauappbe($data)
	{
		$query = "select kd_uappbe1, nm_satker from satker
					where kd_uapb = '$data' and
						kd_uappbe1 is not null and
						kd_uappbw is null and
						kd_uakpb is null 
					order by kd_uappbe1 asc";
		$result = $this->query($query);
		echo '<option value="">-- Pilih Kode UAPPB-E1 --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_uappbe1'].'">'.$row['kd_uappbe1'].' '.$row['nm_satker']."</option>";
		}		
	}
	public function bacawilayah()
	{
		$query = 'select kd_wil, nm_wil from wilayah order by kd_wil asc';
		$result = $this->query($query);
		echo '<option value="">-- Pilih Kode Wilayah --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_wil'].'">'.$row['kd_wil'].' '.$row['nm_wil']."</option>";
		}				
	}
	public function tambahuappbw($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$nm_uappbw = $data['nm_uappbw'];
		$query = "insert into satker
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
        				kd_uappbw='$kd_uappbw',
                    	nm_satker='$nm_uappbw',
                    	kode='$kd_uapb.$kd_uappbe1.$kd_uappbw'";
        $result = $this->query($query);
		return $result;
	}	
	public function ubahuappbw($data)
	{
		$id = $data['id'];
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$nm_uappbw = $data['nm_uappbw'];
		$query = "update satker
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
        				kd_uappbw='$kd_uappbw',
                    	nm_satker='$nm_uappbw',
                    	kode='$kd_uapb.$kd_uappbe1.$kd_uappbw'
                    where id='$id'";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusuappbw($data)
	{
		$query = "delete from satker where id='$data'";
        $result = $this->query($query);
		return $result;
	}
}
?>