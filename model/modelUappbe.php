<?php
include('../../utility/mysql_db.php');
class modelUappbe extends mysql_db
{
	public function tambahuappbe($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$nm_uappbe1 = $data['nm_uappbe1'];
		$query = "insert into satker
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
                    	nm_satker='$nm_uappbe1',
                    	kode='$kd_uapb.$kd_uappbe1'";
        $result = $this->query($query);
		return $result;
	}	
	public function ubahuappbe($data)
	{
		$id = $data['id'];
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$nm_uappbe1 = $data['nm_uappbe1'];
		$query = "update satker
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
                    	nm_satker='$nm_uappbe1',
                    	kode='$kd_uapb.$kd_uappbe1'
                    where id='$id'";
        $result = $this->query($query);
        return $result;
	}	
	public function hapusuappbe($data)
	{
		$query = "delete from satker
        			where id=$data";
        $result = $this->query($query);
		return $result;
	}
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
	public function bacatable($data)
	{
		$query = "select id, kd_uapb, kd_uappbe1, nm_satker 
					from satker
        			where kd_uapb = '$data' and 
        				  kd_uappbe1 is not null and
        				  kd_uappbw is null and
						  kd_uakpb is null";
        $result = $this->query($query);
        $button = '<div class="box-tools"><button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button><button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button></div>';
        while ($row = $this->fetch_assoc($result))
		{
			$rows[] = [$row['id'],$row['kd_uapb'],$row["kd_uappbe1"],$row["nm_satker"],$button];
		}
		echo json_encode($rows);		
	}
}
?>