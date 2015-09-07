<?php
include('../../utility/mysql_db.php');
class modelUnit extends mysql_db
{
	public function bacasatker($data)
	{
		$query = "select kodesektor, namasatker from satker
						where kodesektor is not null and
							  kodesatker is null and
							  kodeunit is null and
							  gudang is null and 
							  tahun is null or
							  tahun = '$data' and 
							  CHAR_LENGTH(kode) = 2
						order by kodesektor asc";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Satker --</option>';
        while ($row = $this->fetch_array($result))
		{
			if (!empty($row)) {
				// echo '<option value="'.$row['kodesektor'].'" disabled>'.$row['kodesektor'].'. '.$row['namasatker']."</option>";
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
					echo '<option value="'.$row2['kodesektor'].'.'.$row2['kodesatker'].'">'.$row2['kodesektor'].'.'.$row2['kodesatker'].' '.$row2['namasatker']."</option>";
				}
				echo '</optgroup>';
			}
		}	
	}
	public function tambahunit($data)
	{
		$kodesektor = $data['kd_sektor'];
		$kodesatker = $data['kd_satker'];
		$kodeunit = $data['kd_unit'];
		$namaunit = $data['nm_unit'];
		$tahun = $data['tahun'];
		$query = "insert into satker
        			set kodesektor='$kodesektor',
        				kodesatker='$kodesatker',
        				kodeunit='$kodeunit',
                    	namasatker='$namaunit',
                    	tahun='$tahun',
                    	kode='$kodesektor.$kodesatker.$kodeunit'";
        $result = $this->query($query);
		return $result;
	}	
	public function ubahunit($data)
	{
		$id = $data['id'];
		$kodesektor = $data['kd_sektor'];
		$kodesatker = $data['kd_satker'];
		$kodeunit = substr($data['kd_unit'], -2);
		$kode = $data['kd_unit'];
		$namaunit = $data['nm_unit'];
		$query = "update satker
        			set kodesektor='$kodesektor',
        				kodesatker='$kodesatker',
        				kodeunit='$kodeunit',
                    	namasatker='$namaunit',
                    	kode='$kodesektor.$kodesatker.$kodeunit'
                    where satker_id='$id'";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusunit($data)
	{
		$id = $data['id'];
		$idunit = $data['idunit'];
		$query = "delete from satker where satker_id='$id';";
		$query.= "delete from satker where kode like '$idunit.%';";
		$result = $this->multi_query($query);
		return $result;
	}
}
?>