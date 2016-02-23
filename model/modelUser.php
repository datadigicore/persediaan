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
                echo '<option value="'.$row['kodesektor'].'">'.$row['kodesektor'].' '.$row['namasatker'].'</option>';
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
                        echo '<option value="'.$row2['kodesektor'].'.'.$row2['kodesatker'].'">&nbsp;&nbsp;'.$row2['kodesektor'].'.'.$row2['kodesatker'].' '.$row2['namasatker'].'</option>';
                        $query3 = "select kodesektor, kodesatker, kodeunit, namasatker from satker
                                where kodesektor ='$row2[kodesektor]' and
                                      kodesatker ='$row2[kodesatker]' and
                                      kodeunit is not null and
                                      gudang is null
                                order by kodesektor asc";
                        $result3 = $this->query($query3);
                        while ($row3 = $this->fetch_array($result3))
                        {
                            if (!empty($row3)) {
                                echo '<option value="'.$row3['kodesektor'].'.'.$row3['kodesatker'].'.'.$row3['kodeunit'].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$row3['kodesektor'].'.'.$row3['kodesatker'].'.'.$row3['kodeunit'].' '.$row3['namasatker'].'</option>';
                                $query4 = "select kodesektor, kodesatker, kodeunit, gudang, namasatker from satker
                                        where kodesektor ='$row3[kodesektor]' and
                                              kodesatker ='$row3[kodesatker]' and
                                              kodeunit ='$row3[kodeunit]' and
                                              gudang is not null
                                        order by kodesektor asc";
                                $result4 = $this->query($query4);
                                while ($row4 = $this->fetch_array($result4))
                                {
                                    echo '<option value="'.$row4['kodesektor'].'.'.$row4['kodesatker'].'.'.$row4['kodeunit'].'.'.$row4['gudang'].'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$row4['kodesektor'].'.'.$row4['kodesatker'].'.'.$row4['kodeunit'].'.'.$row4['gudang'].' '.$row4['namasatker']."</option>";
                                }
                            }
                        }
                    }
                }
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
        $sql4="select gudang from satker
                    where kode = '$data'";
        $result1 = $this->query($sql1);
        $result2 = $this->query($sql2);
        $result3 = $this->query($sql3);
        $result4 = $this->query($sql4);
        $sektor = mysqli_fetch_assoc($result1);
        $satker = mysqli_fetch_assoc($result2);
        $unit = mysqli_fetch_assoc($result3);
        $gudang = mysqli_fetch_assoc($result4);
        $kodesektor = $sektor["kodesektor"];
        $kodesatker = $satker["kodesatker"];
        $kodeunit = $unit["kodeunit"];
        $kodegudang = $gudang["gudang"];
        $sql5="select namasatker from satker
                    where kodesektor = '$kodesektor' and
                        kodesatker is null and
                        kodeunit is null and
                        gudang is null";
        $sql6="select namasatker from satker
                    where kodesektor = '$kodesektor' and
                        kodesatker = '$kodesatker' and
                        kodeunit is null and
                        gudang is null";
        $sql7="select namasatker from satker
                    where kodesektor = '$kodesektor' and
                        kodesatker = '$kodesatker' and
                        kodeunit = '$kodeunit' and
                        gudang is null";
        $sql8="select namasatker from satker
                    where kodesektor = '$kodesektor' and
                        kodesatker = '$kodesatker' and
                        kodeunit = '$kodeunit' and
                        gudang = '$kodegudang'";
        $result5 = $this->query($sql5);
        $result6 = $this->query($sql6);
        $result7 = $this->query($sql7);
        $result8 = $this->query($sql8);
        $ursektor = mysqli_fetch_assoc($result5);
        $ursatker = mysqli_fetch_assoc($result6);
        $urunit = mysqli_fetch_assoc($result7);
        $urgudang = mysqli_fetch_assoc($result8);
        echo json_encode(array("kdsektor"=>$sektor["kodesektor"],"kdsatker"=>$sektor["kodesektor"].'.'.$satker["kodesatker"],"kdunit"=>$sektor["kodesektor"].'.'.$satker["kodesatker"].'.'.$unit["kodeunit"],"kdgudang"=>$sektor["kodesektor"].'.'.$satker["kodesatker"].'.'.$unit["kodeunit"].'.'.$gudang["gudang"],"ursektor"=>$ursektor["namasatker"],"ursatker"=>$ursatker["namasatker"],"urunit"=>$urunit["namasatker"],"urgudang"=>$urgudang["namasatker"]));
    }
	public function tambahuser($data)
	{

		$user_name = $data['user_name'];
		$user_pass = $data['user_pass'];
        $user_email = $data['user_email'];
        $kd_satker= $data['kd_satker'];
        $nm_satker= $data['nm_satker'];
        $tahun= $data['tahun'];
		$user_level = 2;
		$query = "Insert into user
        			set user_name='$user_name',
                    user_pass='$user_pass',
                    user_email='$user_email',
                    kd_lokasi='$kd_satker',
                    nm_satker='$nm_satker',
        			tahun='$tahun',
                    user_level='$user_level'";
        $result = $this->query($query);
		return $result;
	}

    public function ubahuser($data)
    {
        $kd_lama = $data['kd_lama'];
        unset($data['kd_lama']);
        unset($data['manage']);
        unset($data['user_id']);
        $readNamaSatker   = "select namasatker from satker where kode = '$data[kd_lokasi]' and kd_ruang is null";
        $resultNamaSatker = $this->query($readNamaSatker);
        $object           = $this->fetch_object($resultNamaSatker);
        $checkTrans       = "select * from transaksi_full where kd_lokasi = '$data[kd_lokasi]'";
        $resultCheckTrans = $this->query($checkTrans);
        $objectCheckTrans = $this->fetch_object($resultCheckTrans);
        if (!empty($objectCheckTrans)) {
            echo "error";
        }
        else {
            if (isset($data['user_pass'])) {
                $data['user_pass'] = md5($data['user_pass']);
            }
            else if (isset($data['kd_lokasi'])) {
                $data['nm_satker'] = $object->namasatker;
                $arrayTransaksi = array('transaksi_full','transaksi_masuk','transaksi_keluar','opname','log_trans_masuk','log_slip','log_opname');
                for ($i=0; $i < count($arrayTransaksi); $i++) { 
                    $updateTransaksi = "UPDATE $arrayTransaksi[$i]
                        SET kd_lokasi    = '$data[kd_lokasi]',
                        nm_satker        = '$object->namasatker',
                        user_id          = '$data[user_name]',
                        no_dok           =  REPLACE(no_dok, '$kd_lama', '$data[kd_lokasi]')
                        WHERE kd_lokasi  = '$kd_lama'";
                    $resultTransaksi = $this->query($updateTransaksi);    
                }
            }
            foreach ($data as $key => $value) {
                $dataArray[] = $key."='".$value."',";
            }
            $newArray    = implode("", $dataArray);
            $resultArray = rtrim($newArray, ',');
            $query       = "update user
                            set $resultArray where kd_lokasi = '$kd_lama'";
            $result = $this->query($query);
            return $result;
        }
    }

    public function hapususer($data) {
        $query = "delete from user where user_id='$data'";
        $result = $this->query($query);
        return $result;
    }
}
?>
