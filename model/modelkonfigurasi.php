<?php
include('../../utility/mysql_db.php');
class modelKonfigurasi extends mysql_db
{
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

    public function ubahuserpass($data)
    {
        $id = $data['id'];
        $user_name = $data['user_name'];
        $user_pass = $data['user_pass'];
        $user_email = $data['user_email'];
        $kd_lokasi = $data['kd_lokasi'];
        $nm_lokasi = $data['nm_lokasi'];
        $query = "update user
                    set user_name='$user_name',
                    user_pass='$user_pass',
                    user_email='$user_email',
                    kd_lokasi='$kd_lokasi',
                    nm_satker='$nm_lokasi'
                    where user_id='$id'";
        $result = $this->query($query);
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
