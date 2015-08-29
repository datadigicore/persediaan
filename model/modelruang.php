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
							echo '<option value="'.$row3['kodesatker'].'.'.$row3['kodeunit'].'">&nbsp;&nbsp;'.$row3['kodesatker'].'.'.$row3['kodeunit'].' '.$row3['namasatker']."</option>";
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
		$kodesektor = $data['kd_sektor'];
		$kodesatker = $data['kd_satker'];
		$kodeunit = $data['kd_unit'];
		$koderuang = $data['kd_ruang'];
		$kodegudang = $data['kd_gudang'];
		$jk = $data['jk'];
		$namaruang = $data['nm_ruang'];
		$kodelokasi = $data['kd_lokasi'];
		$query = "update satker
        			set kd_sektor='$kodesektor',
        				kd_satker='$kodesatker',
        				kd_unit='$kodeunit',
        				kd_ruang='$koderuang',
        				kd_gudang='$kodegudang',
        				jk='$jk',
        				nm_satker='$namaruang',
                    	kd_jk='$kodelokasi' 
                    where id='$id'";
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