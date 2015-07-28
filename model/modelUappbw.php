<?php
include('../../utility/mysql_db.php');
class modelUappbw extends mysql_db
{
	public function tambahuappbw($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$nm_uappbw = $data['nm_uappbw'];
		$query = "insert into uappbw
        			set kd_uapb='$kd_uapb',
        				kd_uappb='$kd_uappbe1',
        				kd_uappbw='$kd_uappbw',
                    	nm_uappbw='$nm_uappbw'";
        $result = $this->query($query);
		return $result;
	}	

	public function ubahuappbw($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$nm_uappbw = $data['nm_uappbw'];
		$query = "update uappbw
        			set kd_uapb='$kd_uapb',
        				kd_uappb='$kd_uappbe1',
        				kd_uappbw='$kd_uappbw',
                    	nm_uappbw='$nm_uappbw' where kd_uapb='$kd_uapb' and kd_uappb='$kd_uappbe1' ";
        $result = $this->query($query);
		return $result;
	}	

	public function hapusuappbw($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$nm_uappbw = $data['nm_uappbw'];
		$query = "delete from uappbw
        			where kd_uapb='$kd_uapb' and kd_uappb='$kd_uappbe1' ";
        $result = $this->query($query);
		return $result;
	}

	public function bacauapb()
	{
		$query = "select * from uapb";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode UAPB --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uapb'].' '.$row['nm_uapb']."</option>";
		}	
	}
	public function bacauappbe($data)
	{
		$query = "select kd_uappbe1, nm_uappbe1 from uappbe1
					where kd_uapb = '$data'";
		$result = $this->query($query);
		echo '<option value="">-- Pilih Kode UAPPB-E1 --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_uappbe1'].'">'.$row['kd_uappbe1'].' '.$row['nm_uappbe1']."</option>";
		}		
	}
	public function bacawilayah()
	{
		$query = 'select * from wilayah';
		$result = $this->query($query);
		echo '<option value="">-- Pilih Kode Wilayah --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_wil'].'">'.$row['kd_wil'].' '.$row['nm_wil']."</option>";
		}				
	}
}
?>