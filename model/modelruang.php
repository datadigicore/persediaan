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
				$query2 = "select kodesektor, kodesatker, namasatker from satker
						where kodesektor ='$row[kodesektor]' and
							  kodesatker is not null and
							  kodeunit is null and
							  gudang is null 
						order by kodesektor asc";
        		$result2 = $this->query($query2);
        		while ($row2 = $this->fetch_array($result2))
				{
					if (!empty($row2)) {
						echo '<optgroup label="&nbsp;&nbsp;'.$row2['kodesektor'].'.'.$row2['kodesatker'].' '.$row2['namasatker'].'">';
						$query3 = "select kodesektor, kodesatker, kodeunit, namasatker from satker
								where kodesektor ='$row2[kodesektor]' and
									  kodesatker ='$row2[kodesatker]' and
									  kodeunit is not null and
									  gudang is null 
								order by kodesektor asc";
		        		$result3 = $this->query($query3);
		        		while ($row3 = $this->fetch_array($result3))
						{
							echo '<option value="'.$row3['kodesektor'].'.'.$row3['kodesatker'].'.'.$row3['kodeunit'].'">&nbsp;&nbsp;'.$row3['kodesektor'].'.'.$row3['kodesatker'].'.'.$row3['kodeunit'].' '.$row3['namasatker']."</option>";
						}
						echo '</optgroup>';
					}
				}
				echo '</optgroup>';
			}
		}
	}	
	public function tambahruang($data)
	{
		$kodesektor = $data['kodesektor'];
		$kodesatker = $data['kodesatker'];
		$kodeunit = $data['kodeunit'];
		$koderuang = $data['koderuang'];
		$gudang = $data['gudang'];
		$namaruang = $data['namaruang'];
		$query = "insert into satker
        			set kodesektor='$kodesektor',
        				kodesatker='$kodesatker',
        				kodeunit='$kodeunit',
        				kd_ruang='$koderuang',
        				gudang='$gudang',
        				namasatker='$namaruang',
                    	kode='$kodesatker.$kodeunit.$gudang'";
        $result = $this->query($query);
		return $result;
	} 	
	public function ubahruang($data)
	{
		$id = $data['id'];
		$kodesektor = $data['kodesektor'];
		$kodesatker = $data['kodesatker'];
		$kodeunit = $data['kodeunit'];
		$koderuang = $data['koderuang'];
		$kodegudang = $data['kodegudang'];
		$namaruang = $data['namaruang'];
		$query = "update satker
        			set kodesektor='$kodesektor',
        				kodesatker='$kodesatker',
        				kodeunit='$kodeunit',
        				kd_ruang='$koderuang',
        				gudang='$kodegudang',
        				namasatker='$namaruang',
        				kode='$kodesektor.$kodesatker.$kodeunit.$kodegudang'
                    where satker_id='$id'";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusruang($data)
	{
		$query = "delete from satker where satker_id='$data'";
        $result = $this->query($query);
		return $result;
	}
}
?>