<?php
include('../../utility/mysql_db.php');
class modelUakpb extends mysql_db
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
		$query = "select y.kd_uapb, y.kd_uappb, x.nm_uappbe1
					from (select kd_uapb, kd_uappbe1, nm_uappbe1 from uappbe1 where kd_uapb = '$data') as x
					inner join (SELECT kd_uapb, kd_uappb FROM uappbw WHERE kd_uapb = '$data') as y
					where x.kd_uappbe1 = y.kd_uappb";
		$result = $this->query($query);
		echo '<option value="">-- Pilih Kode UAPPB-E1 --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_uappb'].'">'.$row['kd_uappb'].' '.$row['nm_uappbe1']."</option>";
		}				
	}
	public function bacauappbw($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe = $data['kd_uappbe'];
		$query = "select kd_uappbw, nm_uappbw
					from uappbw
					where kd_uapb = '$kd_uapb' and kd_uappb = '$kd_uappbe'";
		$result = $this->query($query);
		echo '<option value="">-- Pilih Kode UAPPB-Wilayah --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_uappbw'].'">'.$row['kd_uappbw'].' '.$row['nm_uappbw']."</option>";
		}
	}
}
?>