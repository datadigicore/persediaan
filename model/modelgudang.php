<?php
include('../../utility/mysql_db.php');
class modelGudang extends mysql_db
{
	public function bacaunit($data)
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
	public function tambahgudang($data)
	{
		$kodesektor = $data['kodesektor'];
		$kodesatker = $data['kodesatker'];
		$kodeunit = $data['kodeunit'];
		$gudang = $data['gudang'];
		$namagudang = $data['namagudang'];
		$tahun = $data['tahun'];
		$query = "insert into satker
        			set kodesektor='$kodesektor',
        				kodesatker='$kodesatker',
        				kodeunit='$kodeunit',
        				gudang='$gudang',
        				namasatker='$namagudang',
        				tahun='$tahun',
                    	kode='$kodesektor.$kodesatker.$kodeunit.$gudang'";
        $result = $this->query($query);
		return $result;
	} 	
	public function ubahgudang($data)
	{
		$id = $data['id'];
		$kodesektor = $data['kodesektor'];
		$kodesatker = $data['kodesatker'];
		$kodeunit = $data['kodeunit'];
		$kodegudang = $data['kodegudang'];
		$namagudang = $data['namagudang'];
		$query = "update satker
        			set kodesektor='$kodesektor',
        				kodesatker='$kodesatker',
        				kodeunit='$kodeunit',
        				gudang='$kodegudang',
        				namasatker='$namagudang',
        				kode='$kodesektor.$kodesatker.$kodeunit.$kodegudang'
                    where satker_id='$id'";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusgudang($data)
	{
		$query = "delete from satker where satker_id='$data'";
        $result = $this->query($query);
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