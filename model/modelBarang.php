<?php
include('../../utility/mysql_db.php');
class modelBarang extends mysql_db
{
	public function tambahbrg($data)
	{
		$kd_kbrg = $data['kd_kbrg'];
		$kd_jbrg = $data['kd_jbrg'];
		$kd_brg = $data['kd_brg'];
		$nm_brg = $data['nm_brg'];
		$satuan = $data['satuan'];
		$kd_lokasi = $data['kd_lokasi'];
		$nm_satker = $data['nm_satker'];
		$user_id = $data['user_id'];

		$query = "SELECT nm_sskel,kd_perk from sskel where kd_brg='$kd_kbrg' ";
        $result = $this->query($query);
        $data = $this->fetch_array($result);
        $nm_sskel = $data['nm_sskel'];
        $kd_perk = $data['kd_perk'];

		$query_perk = "SELECT nm_perk from perk where kd_perk='$kd_perk' ";
        $result_perk = $this->query($query_perk);
        $data_perk = $this->fetch_array($result_perk);
        $nm_perk = $data_perk['nm_perk'];


		$query = "Insert into persediaan
        			set kd_kbrg='$kd_kbrg',
        			kd_jbrg='$kd_jbrg',
        			kd_brg='$kd_brg',
        			nm_brg='$nm_brg',
                    satuan='$satuan',
                    nm_sskel='$nm_sskel',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    nm_satker='$nm_satker',
                    user_id='$user_id',
                    kd_lokasi='$kd_lokasi'";
        $result = $this->query($query);
		return $result;
	}

	public function loghistory($data)
	{		
		$kd_lokasi = $data['kd_lokasi'];
		$nm_satker = $data['nm_satker'];
		$user_id = $data['user_id'];
		$aksi = $data['aksi'];
		$kd_kbrg = $data['kd_kbrg'];
		$kd_jbrg = $data['kd_jbrg'];
		$kd_brg = $data['kd_brg'];
		$nm_brg = $data['nm_brg'];
		$satuan = $data['satuan'];
		$tanggal = $data['tanggal'];


		$query = "Insert into log_persediaan
        			set
        			kd_lokasi='$kd_lokasi',
        			nm_satker='$nm_satker',
        			user_id='$user_id', 
        			aksi='$aksi',
        			kd_kbrg='$kd_kbrg',
        			nm_sskel='$nm_sskel',
        			kd_jbrg='$kd_jbrg',
        			kd_brg='$kd_brg',
        			nm_brg='$nm_brg',
                    satuan='$satuan',
                    tgl_update='$tanggal'
                   
                     ";
        $result = $this->query($query);
		return $result;
	}


	public function bacasskel()
	{
		$query = "select * from sskel group by nm_sskel asc";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Sub-sub Kelompok Barang --</option>';
		while ($row = $this->fetch_array($result))
		{
			echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_sskel']."</option>";
		}	
	}


	public function ubah_barang($data)
	{
		$id = $data['id'];
		$kd_kbrg = $data['kd_kbrg'];
		$kd_jbrg = $data['kd_jbrg'];
		$kd_brg = $data['kd_brg'];
		$nm_brg = $data['nm_brg'];
		$satuan = $data['satuan'];
		$kd_lokasi = $data['kd_lokasi'];
		$query = "update persediaan
					set 
        			kd_jbrg='$kd_jbrg',
        			kd_brg='$kd_brg',
        			nm_brg='$nm_brg',
                    satuan='$satuan',
                    kd_lokasi='$kd_lokasi' 
						where id='$id'";
		$result = $this->query($query);
		return $result;
	}
	
public function hapusbarang($data)
	{
		$id = $data['id'];
	
		$query = "delete from persediaan
					 where id='$id'";
		$result = $this->query($query);
		return $result;
	}

public function cek_barang($data)
{

	$kd_lokasi = $data['kd_lokasi'];
	$kd_brg = $data['kd_brg'];
	$query = "select kd_brg from transaksi_masuk where kd_brg='$kd_brg' and kd_lokasi ='$kd_lokasi' ";
	$result = $this->query($query);
	$data = $this->fetch_array($result);
	$kdbrg = $data['kd_brg'];

	echo json_encode(array("kdbrg"=>$data));

}

}
?>