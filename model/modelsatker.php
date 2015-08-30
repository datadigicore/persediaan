<?php
include('../../utility/mysql_db.php');
class modelSatker extends mysql_db
{
	public function bacasektor()
	{
		$query = "select kodesektor, namasatker from satker
						where kodesektor is not null and
							  kodesatker is null and
							  kodeunit is null and
							  gudang is null 
						order by kodesektor asc";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Sektor --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kodesektor'].'">'.$row['kodesektor'].' '.$row['namasatker']."</option>";
		}	
	}
	public function bacatable($data)
	{
		$query = "select satker_id, kodesektor, kodesatker, namasatker 
					from satker
        			where kodesektor = '$data' and 
        				  kodesatker is not null and
        				  kodeunit is null and
						  gudang is null";
        $result = $this->query($query);
        $button = '<div class="box-tools"><button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button><button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button></div>';
        while ($row = $this->fetch_assoc($result))
		{
			$rows[] = [$row['satker_id'],$row['kodesektor'],$row["kodesatker"],$row["namasatker"],$button];
		}
		echo json_encode($rows);		
	}
	public function tambahsatker($data)
	{
		$kodesektor = $data['kodesektor'];
		$kodesatker = $data['kodesatker'];
		$namasatker = $data['namasatker'];
		$query = "insert into satker
        			set kodesektor='$kodesektor',
        				kodesatker='$kodesatker',
                    	namasatker='$namasatker',
                    	kode='$kodesektor.$kodesatker'";
        $result = $this->query($query);
		return $result;
	}	
	public function ubahsatker($data)
	{
		$id = $data['id'];
		$kodesektor = $data['kodesektor'];
		$kodesatker = $data['kodesatker'];
		$namasatker = $data['namasatker'];
		$query = "update satker
        			set kodesektor='$kodesektor',
        				kodesatker='$kodesatker',
                    	namasatker='$namasatker',
                    	kode='$kodesektor.$kodesatker'
                    where satker_id='$id'";
        $result = $this->query($query);
        return $result;
	}	
	public function hapussatker($data)
	{
		$query = "delete from satker
        			where satker_id=$data";
        $result = $this->query($query);
		return $result;
	}
}
?>