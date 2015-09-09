<?php
include('../../utility/mysql_db.php');
class modelKonfigurasi extends mysql_db
{
    public function bacathnaktif($data)
    {
        $query = "SELECT tahun FROM thn_aktif WHERE tahun = '$data' LIMIT 1;";
        $result = $this->query($query);
        $num = mysqli_num_rows($result);
        if($num == 0){
          $valid = "true";
        } else {
          $valid = "false";
        }
        echo $valid;
    }   
    public function bacatahun()
    {
        $query = "select tahun, status from thn_aktif
                        order by tahun asc";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Tahun --</option>';
        while ($row = $this->fetch_array($result))
        {
            if ($row['status'] != "Tidak Aktif") {
                echo '<option value="'.$row['tahun'].'">'.$row['tahun'].'&nbsp;&nbsp;'.$row['status'].'</option>';
            }
            else{
                echo '<option value="'.$row['tahun'].'">'.$row['tahun'].'</option>';
            }
        }   
    }
	public function tambahtahun($data)
	{
		$tahun = $data['thnaktif'];
		$keterangan = $data['keterangan'];
        $query = "Insert into thn_aktif
        			set tahun='$tahun',
                    keterangan='$keterangan'";
        $result = $this->query($query);
		return $result;
	}
    public function tambahtahunaktif($data)
    {
        $tahun = $data['thnaktif'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $query = "UPDATE thn_aktif
                    set status='Tidak Aktif'
                    where status='Aktif';";
        $query.= "INSERT into thn_aktif
                    set tahun='$tahun',
                    keterangan='$keterangan',
                    status='$status';";
        $result = $this->multi_query($query);
        return $result;
    }
    public function aktifkantahun($data)
    {
        $query = "UPDATE thn_aktif
                    set status='Tidak Aktif'
                    where status='Aktif';";
        $query.= "UPDATE thn_aktif
                    set status='Aktif'
                    where id='$data';";
        $result = $this->multi_query($query);
        return $result;
    }
    public function exportkonfig($data)
    {
        $thnawal = $data['thnawal'];
        $thntujuan = $data['thntujuan'];
        $query = "CREATE TEMPORARY TABLE temporary_table SELECT * FROM satker WHERE tahun = '$thnawal';";
        $query.= "UPDATE temporary_table SET tahun = '$thntujuan';";
        $query.= "INSERT INTO satker SELECT null, KodeSektor, KodeSatker, KodeUnit, Gudang, kode, NamaSatker, tahun FROM temporary_table;";
        $query.= "DROP TEMPORARY TABLE IF EXISTS temporary_table;";
        $result = $this->multi_query($query);
        return $result;
    }

    public function hapustahun($data)
    {
        $query = "delete from thn_aktif where id='$data'";
        $result = $this->query($query);
        return $result;
    }
}
?>
