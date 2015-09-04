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


	public function ubahbrg($data)
	{
		$kd_kbrg = $data['kd_kbrg'];
		$kd_jbrg = $data['kd_jbrg'];
		$nm_brg = $data['nm_brg'];
		$satuan = $data['satuan'];
		$kd_perk = $data['kd_perk'];
		$kd_lokasi = $data['kd_lokasi'];
		$query = "update brg
					set kd_kbrg='$kd_kbrg',
        			kd_jbrg='$kd_jbrg',
        			nm_brg='$nm_brg',
                    satuan='$satuan',
                    kd_perk='$kd_perk',
                    kd_lokasi='$kd_lokasi' 
						where kd_kbrg='$kd_kbrg'";
		$result = $this->query($query);
		return $result;
	}
	
public function hapusbrg($data)
	{
		$kd_kbrg = $data['kd_kbrg'];
		$kd_jbrg = $data['kd_jbrg'];
		$nm_brg = $data['nm_brg'];
		$satuan = $data['satuan'];
		$kd_perk = $data['kd_perk'];
		$kd_lokasi = $data['kd_lokasi'];
		$query = "delete from brg
					 where kd_kbrg='$kd_kbrg'";
		$result = $this->query($query);
		return $result;
	}

}
?>