<?php
include('../../utility/mysql_db.php');
class modelUakpb extends mysql_db
{
	public function tambahuakpb($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$kd_uakpb = $data['kd_uakpb'];
		$kd_uapkpb = $data['kd_uapkpb'];
		$jk = $data['jk'];
		$nm_uakpb = $data['nm_uakpb'];
		$kd_lokasi = $data['kd_lokasi'];
		
		$query = "insert into uakpb
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
        				kd_uappbw='$kd_uappbw',
        				kd_uakpb='$kd_uakpb',
        				kd_uapkpb='$kd_uapkpb',
        				jk='$jk',
        				nm_uakpb='$nm_uakpb',
                    	kd_lokasi='$kd_lokasi'";
        $result = $this->query($query);
		return $result;
	} 	

	public function ubahuakpb($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$kd_uakpb = $data['kd_uakpb'];
		$kd_uapkpb = $data['kd_uapkpb'];
		$jk = $data['jk'];
		$nm_uakpb = $data['nm_uakpb'];
		$kd_lokasi = $data['kd_lokasi'];
		
		$query = "update uakpb
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
        				kd_uappbw='$kd_uappbw',
        				kd_uakpb='$kd_uakpb',
        				kd_uapkpb='$kd_uapkpb',
        				jk='$jk',
        				nm_uakpb='$nm_uakpb',
                    	kd_lokasi='$kd_lokasi' 
                    where kd_uapb='$kd_uapb' and
        					kd_uappbe1='$kd_uappbe1' and
        					kd_uappbw='$kd_uappbw' and
        					kd_uakpb='$kd_uakpb' and kd_lokasi='$kd_lokasi' ";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusuakpb($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$kd_uakpb = $data['kd_uakpb'];
		$kd_uapkpb = $data['kd_uapkpb'];
		$jk = $data['jk'];
		$nm_uakpb = $data['nm_uakpb'];
		$kd_lokasi = $data['kd_lokasi'];
		
		$query = "delete from uakpb
   
                    where kd_uapb='$kd_uapb' and
        					kd_uappbe1='$kd_uappbe1' and
        					kd_uappbw='$kd_uappbw' and
        					kd_uakpb='$kd_uakpb' and kd_lokasi='$kd_lokasi' ";
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

	public function bacauakpb()
	{
		$query = "select * from uakpb";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode UAKPB --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_lokasi'].'">'.$row['kd_lokasi'].' '.$row['nm_uakpb']."</option>";
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