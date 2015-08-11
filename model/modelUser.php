<?php
include('../../utility/mysql_db.php');
class modelUser extends mysql_db
{
    public function bacauakpb()
    {
        $query = "select * from satker
                    where kd_uapb is not null and
                          kd_uappbe1 is not null and
                          kd_uappbw is not null and
                          kd_uakpb is not null and
                          kd_uapkpb is not null and
                          jk is not null";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Satker--</option>';
        while ($row = $this->fetch_array($result))
        {
            // $replace = str_replace(array('.', ','), '' , $row['kode']);
            echo '<option value="'.$row['kode'].'">'.$row['kode'].' '.$row['nm_satker']."</option>";
        }
    }
    public function bacadata($data)
    {
        $sql1="select kd_uapb from satker
                    where kode = '$data'";
        $sql2="select kd_uappbe1 from satker
                    where kode = '$data'";
        $sql3="select kd_uappbw from satker
                    where kode = '$data'";
        $sql4="select jk from satker
                    where kode = '$data'";
        $result1 = $this->query($sql1);
        $result2 = $this->query($sql2);
        $result3 = $this->query($sql3);
        $result4 = $this->query($sql4);
        $uapb = mysqli_fetch_assoc($result1);
        $uappbe = mysqli_fetch_assoc($result2);
        $uappbw = mysqli_fetch_assoc($result3);
        $kdjk = mysqli_fetch_assoc($result4);
        $kodeuapb = $uapb["kd_uapb"];
        $kodeuappbe = $uappbe["kd_uappbe1"];
        $kodeuappbw = $uappbw["kd_uappbw"];
        $sql5="select nm_satker from satker
                    where kd_uapb = '$kodeuapb' and
                        kd_uappbe1 is null and
                        kd_uappbw is null and
                        kd_uakpb is null";
        $sql6="select nm_satker from satker
                    where kd_uapb = '$kodeuapb' and
                        kd_uappbe1 = '$kodeuappbe' and
                        kd_uappbw is null and
                        kd_uakpb is null";
        $sql7="select nm_satker from satker
                    where kd_uapb = '$kodeuapb' and
                        kd_uappbe1 = '$kodeuappbe' and
                        kd_uappbw = '$kodeuappbw' and
                        kd_uakpb is null";
        $result5 = $this->query($sql5);
        $result6 = $this->query($sql6);
        $result7 = $this->query($sql7);
        $uruapb = mysqli_fetch_assoc($result5);
        $uruappbe = mysqli_fetch_assoc($result6);
        $uruappbw = mysqli_fetch_assoc($result7);
        echo json_encode(array("kduapb"=>$uapb["kd_uapb"],"kduappbe"=>$uappbe["kd_uappbe1"],"kduappbw"=>$uappbw["kd_uappbw"],"kdjk"=>$kdjk["jk"],"uruapb"=>$uruapb["nm_satker"],"uruappbe"=>$uruappbe["nm_satker"],"uruappbw"=>$uruappbw["nm_satker"]));
    }
	public function tambahuser($data)
	{

		$user_name = $data['user_name'];
		$user_pass = $data['user_pass'];
        $user_email = $data['user_email'];
		$kd_lokasi = str_replace(array('.'), '' , $data['kd_lokasi']);
		$user_level = 2;
		$query = "Insert into user
        			set user_name='$user_name',
                    user_pass='$user_pass',
                    user_email='$user_email',
        			kd_lokasi='$kd_lokasi',
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

        $user_name = $data['user_name'];
        $user_pass = $data['user_pass'];
        $user_email = $data['user_email'];
        $user_level = $data['user_level'];
        $query = "delete from user
                    where user_id='$user_id'";
        $result = $this->query($query);
        return $result;
    }

    public function bacaUser()
    {
        $query = "select * from user";
        $result = $this->query($query);
        echo '<option value="">-- Pilih User Id --</option>';
        while ($row = $this->fetch_array($result))
        {
            // echo '<option value="'.$row['user_id'].'">'.$row['user_name'].' '.$row['user_pass'].' '.$row['user_level']"</option>";
        }   
    }
    public function bacatable($data)
    {
        $query = "select * from user
                    where user_id = '$data'";
        $result = $this->query($query);
        while ($row = $this->fetch_assoc($result))
        {
            // $rows[] = [$row['user_id'],$row["user_name"],$row["user_pass"],$row["user_level"]];
        }
        echo json_encode($rows);
    }
}
?>