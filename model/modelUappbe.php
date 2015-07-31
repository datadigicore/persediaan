<?php
include('../../utility/mysql_db.php');
class modelUappbe extends mysql_db
{
	public function tambahuappbe($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$nm_uappbe1 = $data['nm_uappbe1'];
		$query = "insert into uappbe1
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
                    	nm_uappbe1='$nm_uappbe1'";
        $result = $this->query($query);
		return $result;
	}	
	public function ubahuappbe($data)
	{
		$id_uapb = $data['id_uapb'];
		$id_uappbe = $data['id_uappbe'];
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$nm_uappbe1 = $data['nm_uappbe1'];
		$query = "update uappbe1
        			set kd_uapb='$kd_uapb',
        				kd_uappbe1='$kd_uappbe1',
                    	nm_uappbe1='$nm_uappbe1' where kd_uapb='$id_uapb' and kd_uappbe1='$id_uappbe' ";
        $result = $this->query($query);
		return $result;
	}	
	public function hapusuappbe($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$query = "delete from uappbe1
        			where kd_uapb='$kd_uapb' and kd_uappbe1='$kd_uappbe1'";
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
	public function bacatable($data)
	{
		$query = "select * from uappbe1
        			where kd_uapb = '$data'";
        $result = $this->query($query);
        $button = '<div class="box-tools"><button class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button><button class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button></div>';
        while ($row = $this->fetch_assoc($result))
		{
			$rows[] = [$row['kd_uapb'],$row["kd_uappbe1"],$row["nm_uappbe1"],$button];
		}
		echo json_encode($rows);		
	}
}
?>