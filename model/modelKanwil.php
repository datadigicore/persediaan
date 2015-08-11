<?php
include('../../utility/mysql_db.php');
class modelKanwil extends mysql_db
{
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
    public function ubahkanwil($data)
    {
        $id = $data['id'];
        $kd_uapb = $data['kd_uapb'];
        $kd_uappbe1 = $data['kd_uappbe1'];
        $kd_kanwil = $data['kd_kanwil'];
        $nm_kanwil = $data['nm_kanwil'];
        $query = "update kanwil
                    set kd_uapb='$kd_uapb',
                        kd_uappbe1='$kd_uappbe1',
                        kd_kanwil='$kd_kanwil',
                        nm_kanwil='$nm_kanwil'
                    where id='$id'";
        $result = $this->query($query);
        return $result;
    }
    public function hapuskanwil($data)
    {
        $query = "delete from kanwil
                    where id='$data'";
        $result = $this->query($query);
        return $result;
    }
}
?>