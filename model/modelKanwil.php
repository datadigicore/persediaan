<?php
include('../../utility/mysql_db.php');
class modelKanwil extends mysql_db
{
	public function tambahkanwil($data)
	{
		$kd_uapb = $data['kd_uapb'];
		$kd_uappbe1 = $data['kd_uappbe1'];
		$kd_kanwil = $data['kd_kanwil'];
		$nm_kanwil = $data['nm_kanwil'];
		$query = "Insert into kanwil
        			set kd_uapb='$kd_uapb',
        			kd_uappbe1='$kd_uappbe1',
        			kd_kanwil='$kd_kanwil',
                    nm_kanwil='$nm_kanwil'";
        $result = $this->query($query);
		return $result;
	}

    public function bacakanwil()
    {
        $query = "select * from kanwil";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode UAPB --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uappbe1'].' '.$row['kd_kanwil'].' '.$row['nm_kanwil']"</option>";
        }   
    }
    public function bacatable($data)
    {
        $query = "select * from kanwil
                    where kd_uapb = '$data'";
        $result = $this->query($query);
        while ($row = $this->fetch_assoc($result))
        {
            $rows[] = [$row['kd_uapb'],$row["kd_uappbe1"],$row["kd_kanwil"],$row["nm_kanwil"]];
        }
        echo json_encode($rows);        
    }
}
?>