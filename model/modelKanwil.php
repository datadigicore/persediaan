<?php
include('../../utility/mysql_db.php');
class modelKanwil extends mysql_db
{
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
    public function bacauappbe($data)
    {
        $query = "select kd_uappbe1, nm_uappbe1 from uappbe1
                    where kd_uapb = '$data'";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode UAPPB-E1 --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_uappbe1'].'">'.$row['kd_uappbe1'].' '.$row['nm_uappbe1']."</option>";
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
        $id_uapb = $data['id_uapb'];
        $id_uappbe1 = $data['id_uappbe1'];
        $id_kanwil = $data['id_kanwil'];
        $kd_uapb = $data['kd_uapb'];
        $kd_uappbe1 = $data['kd_uappbe1'];
        $kd_kanwil = $data['kd_kanwil'];
        $nm_kanwil = $data['nm_kanwil'];
        $query = "update kanwil
                    set kd_uapb='$kd_uapb',
                        kd_uappbe1='$kd_uappbe1',
                        kd_kanwil='$kd_kanwil',
                        nm_kanwil='$nm_kanwil'
                    where kd_uapb='$id_uapb' and
                          kd_uappbe1='$id_uappbe1' and
                          kd_kanwil='$id_kanwil'";
        $result = $this->query($query);
        return $result;
    }
    public function hapuskanwil($data)
    {
        $kd_uapb = $data['kd_uapb'];
        $kd_uappbe1 = $data['kd_uappbe1'];
        $kd_kanwil = $data['kd_kanwil'];
        $query = "delete from kanwil
                    where kd_uapb='$kd_uapb' and kd_uappbe1='$kd_uappbe1' and kd_kanwil='$kd_kanwil'";
        $result = $this->query($query);
        return $result;
    }

    // public function bacakanwil()
    // {
    //     $query = "select * from kanwil";
    //     $result = $this->query($query);
    //     echo '<option value="">-- Pilih Kode UAPB --</option>';
    //     while ($row = $this->fetch_array($result))
    //     {
    //         echo '<option value="'.$row['kd_uapb'].'">'.$row['kd_uappbe1'].' '.$row['kd_kanwil'].' '.$row['nm_kanwil']."</option>";
    //     }   
    // }    
    // public function bacawilayah()
    // {
    //     $query = "select * from wilayah";
    //     $result = $this->query($query);
    //     echo '<option value="">-- Pilih Kode Wilayah --</option>';
    //     while ($row = $this->fetch_array($result))
    //     {
    //         echo '<option value="'.$row['kd_wil'].'">'.$row['kd_wil'].' '.$row['nm_wil']."</option>";
    //     }   
    // }
    // public function bacatable($data)
    // {
    //     $query = "select * from kanwil
    //                 where kd_uapb = '$data'";
    //     $result = $this->query($query);
    //     while ($row = $this->fetch_assoc($result))
    //     {
    //         //$rows[] = [$row['kd_uapb'], $row["kd_uappbe1"], $row["kd_kanwil"], $row["nm_kanwil"] ];
    //     }
    //     echo json_encode($rows);        
    // }
}
?>