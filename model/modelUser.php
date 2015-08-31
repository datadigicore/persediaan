<?php
include('../../utility/mysql_db.php');
class modelUser extends mysql_db
{
    public function bacaunitsatker()
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
    public function bacadata($data)
    {
        $sql1="select kodesektor from satker
                    where kode = '$data'";
        $sql2="select kodesatker from satker
                    where kode = '$data'";
        $sql3="select kodeunit from satker
                    where kode = '$data'";
        $result1 = $this->query($sql1);
        $result2 = $this->query($sql2);
        $result3 = $this->query($sql3);
        $sektor = mysqli_fetch_assoc($result1);
        $satker = mysqli_fetch_assoc($result2);
        $unit = mysqli_fetch_assoc($result3);
        $kodesektor = $sektor["kodesektor"];
        $kodesatker = $satker["kodesatker"];
        $kodeunit = $unit["kodeunit"];
        $sql4="select namasatker from satker
                    where kodesektor = '$kodesektor' and
                        kodesatker is null and
                        kodeunit is null and
                        gudang is null";
        $sql5="select namasatker from satker
                    where kodesektor = '$kodesektor' and
                        kodesatker = '$kodesatker' and
                        kodeunit is null and
                        gudang is null";
        $sql6="select namasatker from satker
                    where kodesektor = '$kodesektor' and
                        kodesatker = '$kodesatker' and
                        kodeunit = '$kodeunit' and
                        gudang is null";
        $result4 = $this->query($sql4);
        $result5 = $this->query($sql5);
        $result6 = $this->query($sql6);
        $ursektor = mysqli_fetch_assoc($result4);
        $ursatker = mysqli_fetch_assoc($result5);
        $urunit = mysqli_fetch_assoc($result6);
        echo json_encode(array("kdsektor"=>$sektor["kodesektor"],"kdsatker"=>$sektor["kodesektor"].$satker["kodesatker"],"kdunit"=>$sektor["kodesektor"].$satker["kodesatker"].$unit["kodeunit"],"ursektor"=>$ursektor["namasatker"],"ursatker"=>$ursatker["namasatker"],"urunit"=>$urunit["namasatker"]));
    }
	public function tambahuser($data)
	{

		$user_name = $data['user_name'];
		$user_pass = $data['user_pass'];
        $user_email = $data['user_email'];
        $kd_satker= $data['kd_lokasi'];
        $nm_satker= $data['nm_satker'];
		$kd_lokasi = str_replace(array('.'), '' , $data['kd_lokasi']);
		$user_level = 2;
		$query = "Insert into user
        			set user_name='$user_name',
                    user_pass='$user_pass',
                    user_email='$user_email',
                    kd_lokasi='$kd_lokasi',
        			nm_satker='$nm_satker',
                    user_level='$user_level'";         
        $result = $this->query($query);
		return $result;
	}

    public function ubahuser($data)
    {

        $user_name = $data['user_name'];
        $user_pass = $data['user_pass'];
        $user_email = $data['user_email'];
        $user_level = $data['user_level'];
        $query = "update user
                    set user_id='$user_id',
                    user_name='$user_name',
                    user_pass='$user_pass',
                    user_level='$user_level'";
        $result = $this->query($query);
        return $result;
    }   
    
    public function hapususer($data)
    {

        $query = "delete from user where user_id='$data'";
        $result = $this->query($query);
        return $result;
    }
}
?>