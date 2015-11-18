<?php
include('../../utility/mysql_db.php');
class modelBarang extends mysql_db
{

	public function cek_kd_barang($data)
	{
		$kd_lokasi = $data['kd_lokasi'];
		$kd_brg = $data['kd_brg'];

		$query = "select kd_brg, nm_brg from persediaan where kd_brg='$kd_brg' ";
		$result = $this->query($query);
        $data = $this->fetch_array($result);
        $kd_brg = $data['kd_brg'];
        $nm_brg = $data['nm_brg'];

        echo json_encode(array("kd_brg"=>$kd_brg,"nm_brg"=>$nm_brg));


	}

	public function tambahsubbrg($data)
	{
		$kd_brg = $data['kdbrg'];
		$nm_brg = $data['nmbrg'];
		$spesifikasi = $data['spesifikasi'];
		$satuan = $data['satuan'];
		$query = "Insert into persediaan
        			set kd_brg='$kd_brg',
        			nm_brg='$nm_brg',
                    spesifikasi='$spesifikasi',
                    satuan='$satuan'";
        $result = $this->query($query);
		return $result;
	}
	public function ubahsubbrg($data)
	{
		$id = $data['id'];
		$kd_brg = $data['kdbrg'];
		$nm_brg = $data['nmbrg'];
		$spesifikasi = $data['spesifikasi'];
		$satuan = $data['satuan'];
		$query = "UPDATE persediaan
        			set kd_brg='$kd_brg',
        			nm_brg='$nm_brg',
                    spesifikasi='$spesifikasi',
                    satuan='$satuan'
                    where id = '$id'";
        $result = $this->query($query);
		return $result;
	}

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
        			nm_sskel='$nm_sskel',
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

	public function bacabarang($data)
	{
		$query = "select kd_brg, nm_brg from persediaan where CONCAT(kd_brg,' ',nm_brg) like '%$data%' and char_length(kd_brg)>14 order by kd_brg asc";
        $result = $this->query($query);
        $json = array();
        while ($row = $this->fetch_array($result))
        {
        	if ((substr_count($row['kd_brg'],".") >= 3 and (substr_count($row['kd_brg'],".") <= 5))) {
        		$dynamic = array(
	                'id' => $row['kd_brg'],
	                'text' => $row['kd_brg']." ".$row['nm_brg']
	            );
	            array_push($json, $dynamic);
        	}
            
        }   
        echo json_encode($json);
	}

	public function bacassatuan($data)
	{
		$query = "select satuan from persediaan where satuan like '%$data%' group by satuan asc";
        $result = $this->query($query);
        $json = array();
        while ($row = $this->fetch_array($result))
        {
        	if ($row['satuan'] != " " or $row['satuan'] != "" or $row['satuan'] != ";") {
        		$dynamic = array(
	                'id' => $row['satuan'],
	                'text' => $row['satuan']
	            );
	            array_push($json, $dynamic);
        	}
        }   
        echo json_encode($json);
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
	$query = "select kd_brg from transaksi_masuk where kd_brg='$kd_brg' and kd_lokasi like '$kd_lokasi%' ";
	$result = $this->query($query);
	$data = $this->fetch_array($result);
	$kdbrg = $data['kd_brg'];

	echo json_encode(array("kdbrg"=>$data));

}

}
?>