<?php
include('../../utility/mysql_db.php');
class modelRuang extends mysql_db
{
	public function bacaunit()
	{
		$query = "select kodesektor, namasatker from satker
						where kodesektor is not null and
							  kodesatker is null and
							  kodeunit is null and
							  gudang is null 
						order by kodesektor asc";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Unit --</option>';
        while ($row = $this->fetch_array($result))
		{
			if (!empty($row)) {
				echo '<optgroup label="'.$row['kodesektor'].' '.$row['namasatker'].'">';
				$query2 = "select kodesatker, namasatker from satker
						where kodesektor ='$row[kodesektor]' and
							  kodesatker is not null and
							  kodeunit is null and
							  gudang is null 
						order by kodesektor asc";
        		$result2 = $this->query($query2);
        		while ($row2 = $this->fetch_array($result2))
				{
					if (!empty($row2)) {
						echo '<optgroup label="&nbsp;&nbsp;'.$row2['kodesatker'].' '.$row2['namasatker'].'">';
						$query3 = "select kodesatker, kodeunit, namasatker from satker
								where kodesektor is not null and
									  kodesatker ='$row2[kodesatker]' and
									  kodeunit is not null and
									  gudang is null 
								order by kodesektor asc";
		        		$result3 = $this->query($query3);
		        		while ($row3 = $this->fetch_array($result3))
						{
							echo '<option value="'.$row3['kodeunit'].'">&nbsp;&nbsp;'.$row3['kodesatker'].'.'.$row3['kodeunit'].' '.$row3['namasatker']."</option>";
						}
						echo '</optgroup>';
					}
				}
				echo '</optgroup>';
			}
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
	public function bacauappbw($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe = $data['kd_uappbe'];
		$query = "select kd_uappbw, nm_satker from satker
					where kd_uapb = '$kd_uapb' and
						  kd_uappbe1 = '$kd_uappbe' and
						  kd_uappbw is not null and
						  kd_uakpb is null";
		$result = $this->query($query);
		echo '<option value="">-- Pilih Kode UAPPB-Wilayah --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_uappbw'].'">'.$row['kd_uappbw'].' '.$row['nm_satker']."</option>";
		}
	}
	public function tambahuakpb($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$kd_uakpb = $data['kd_uakpb'];
		$kd_uapkpb = $data['kd_uapkpb'];
		$jk = $data['jk'];
		$nm_uakpb = $data['nm_uakpb'];
		$query = "insert into satker
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
        				kd_uappbw='$kd_uappbw',
        				kd_uakpb='$kd_uakpb',
        				kd_uapkpb='$kd_uapkpb',
        				jk='$jk',
        				nm_satker='$nm_uakpb',
                    	kode='$kd_uapb.$kd_uappbe1.$kd_uappbw.$kd_uakpb.$kd_uapkpb.$jk'";
        $result = $this->query($query);
		return $result;
	} 	
	public function ubahuakpb($data)
	{
		$id = $data['id'];
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_uappbw = $data['kd_uappbw'];
		$kd_uakpb = $data['kd_uakpb'];
		$kd_uapkpb = $data['kd_uapkpb'];
		$jk = $data['jk'];
		$nm_uakpb = $data['nm_uakpb'];
		$kd_lokasi = $data['kd_lokasi'];
		$query = "update satker
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
        				kd_uappbw='$kd_uappbw',
        				kd_uakpb='$kd_uakpb',
        				kd_uapkpb='$kd_uapkpb',
        				jk='$jk',
        				nm_satker='$nm_uakpb',
                    	kd_jk='$kd_lokasi' 
                    where id='$id'";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusuakpb($data)
	{
		$query = "delete from satker where id='$data'";
        $result = $this->query($query);
		return $result;
	}
}
?>