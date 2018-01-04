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

	public function add_kode_rek_akuntansi($data){
		$query = "INSERT INTO rekening SET kode_rekening ='$data[kode_rekening]', nama_rekening ='$data[nama_rekening]' ";
		$this->query($query);
	}

	public function addrekbarang($data)
	{
		$query = "INSERT INTO perk SET kd_perk = '$data[kdrekening]', nm_perk = '$data[nmrekening]'";
		$result = $this->query($query);
       	return $result;
	}

	public function tambahsubbrg($data)
	{
		$query = $this->query("select kd_perk, nm_perk,nm_sskel from persediaan where kd_sskel = '$data[kd_sskel]' ");
		$result = $this->fetch_assoc($query);
		$data['kd_perk'] = $result['kd_perk'];
		$data['nm_perk'] = $result['nm_perk'];
		$data['nm_sskel'] = $result['nm_sskel'];
		$query = $this->query("SELECT g FROM persediaan where kd_brg like '$data[kd_sskel].%' ORDER BY g DESC limit 1");
		$result = $this->fetch_assoc($query);
		$noreg = $result['g'];
		$data['g'] = $noreg+1;
		if ($data['g']<10) {
			$data['g'] = '0'.$data['g'];
		}
		$data['kd_brg']=$data['kd_sskel'].'.'.$data['g'];
		$pecahKode = explode('.', $data['kd_sskel']);
		$i = 0;
		foreach (range('a', 'f') as $char) {
			$data[$char] = $pecahKode[$i];
			$i++;
		}
		unset($i);
		$data['id'] = $data['kd_brg'];
		$query = "INSERT INTO persediaan SET ";
        foreach ($data as $key => $value) {
            $query .= $key." = '".$value."',";
        }
        $query  = substr($query,0,-1);
		$result = $this->query($query);
		return $data;
	}

	public function ubahjenisbrg($data)
	{
		$id = $data['id'];
		$kode_rekening = $data['kdbaru'];
		$kdlama= $data['kdlama'];
		$nm_brg = $data['nmbrg'];
		// $kd_brg = $data['kdbrg'];
		$spesifikasi = $data['spesifikasi'];
		$satuan = $data['satuan'];
		// $id = $_POST['id'];
		// $this->query("BEGIN");
		$hsl = $this->query("select kd_perk, nm_perk,nm_sskel from persediaan where kd_sskel = '$kode_rekening' ");
		$kd_rek = $this->fetch_array($hsl);
		$kd_perk = $kd_rek['kd_perk'];
		$nm_perk = $kd_rek['nm_perk'];
		$nm_sskel = $kd_rek['nm_sskel'];

		$hsl_noreg = $this->query("SELECT g FROM persediaan where kd_brg like '$kode_rekening%' ORDER BY g DESC limit 1");
		$data_noreg = $this->fetch_array($hsl_noreg);
		$noreg = $data_noreg['g'];
		$no_urut = $noreg+1;
		if($no_urut<10) $no_urut = '0'.$no_urut;
		$aksi = "Ubah Jenis dari Kode ".$kdlama;
		$kd_brg=$kode_rekening.'.'.$no_urut;

		$query_brg = "select kd_brg, nm_brg from persediaan where kd_brg='$kd_brg' limit 1";
		$result_brg = $this->query($query_brg);
		if($this->num_rows($result_brg)==1)
        {
        	exit();
        }


		$query_log = "Insert into log_persediaan
        			set idbrg='$id',
        			aksi = '$aksi',
        			nm_brg='$nm_brg',
        			kd_sskel='$kode_rekening',
        			kd_brg='$kd_brg',
        			nm_sskel='$nm_sskel',
                    spesifikasi='$spesifikasi',
                    satuan='$satuan'";
        echo $kdlama;
        $query1 = "UPDATE persediaan set kd_brg='$kd_brg', kd_perk='$kd_perk', nm_perk='$nm_perk', kd_sskel='$kode_rekening', nm_sskel='$nm_sskel' where id='$id' ";
        $query2 = "UPDATE transaksi_masuk set kd_brg='$kd_brg', kd_perk='$kd_perk', nm_perk='$nm_perk', kd_sskel='$kode_rekening', nm_sskel='$nm_sskel' where kd_brg='$kdlama' ";
        $query3 = "UPDATE transaksi_keluar set kd_brg='$kd_brg', kd_perk='$kd_perk', nm_perk='$nm_perk', kd_sskel='$kode_rekening', nm_sskel='$nm_sskel' where kd_brg='$kdlama' ";
        $query4 = "UPDATE transaksi_full set kd_brg='$kd_brg', kd_perk='$kd_perk', nm_perk='$nm_perk', kd_sskel='$kode_rekening', nm_sskel='$nm_sskel' where kd_brg='$kdlama' ";
        $query5 = "UPDATE opname set kd_brg='$kd_brg', kd_perk='$kd_perk', nm_perk='$nm_perk', kd_sskel='$kode_rekening', nm_sskel='$nm_sskel' where kd_brg='$kdlama' ";
        $query6 = "UPDATE log_trans_masuk set kd_brg='$kd_brg' where kd_brg='$kdlama' ";
        $query7 = "UPDATE log_slip set kd_brg='$kd_brg' where kd_brg='$kdlama' ";
        // echo $query2."<br>";
        // echo $query3."<br>";
        // echo $query4."<br>";
        // echo $query5."<br>";
        // echo $query6."<br>";
        // echo $query7."<br>";
        $this->query($query1);
        
        $this->query($query2);
        $this->query($query3);
        $this->query($query4);
        $this->query($query5);
        $this->query($query6);
        $this->query($query7);
        $this->query($query_log);
		
		// $this->query("COMMIT");

		// $this->query("DELETE from persediaan where id='$id' ");
	}
	public function ubahsubbrg($data)
	{
		$query = "UPDATE persediaan
        			SET";
        foreach ($data as $key => $value) {
        	if (!empty($value)) {
        		$query .= " ".$key." = '".$value."',";
        	}
        }
        $query  = substr($query,0,-1);
        $query .= " WHERE id = '$data[id]'";
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
		$query = "select kd_sskel, nm_sskel from persediaan where CONCAT(kd_brg,' ',nm_sskel) like '%$data%' group by kd_sskel order by kd_brg asc";
        $result = $this->query($query);
        $json = array();
        echo '<option value=""></option>';
        while ($row = $this->fetch_array($result))
        {
        	echo '<option value="'.$row['kd_sskel'].'">'.$row['kd_sskel'].' '.$row['nm_sskel']."</option>";
        }   
	}

	public function bacassatuan($data)
	{
		$query = "select satuan from satuan where satuan like '%$data%' group by satuan asc";
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
		$kd_brg = $data['idbrg'];
		$nm_brg = $data['nm_brg'];
		$jns_barang = $data['jns_barang'];
		$spesifikasi = $data['spesifikasi'];
		$satuan = $data['satuan'];
		$username = $_SESSION['username'];
		$thn_ang = $_SESSION['thn_ang'];
		$sql = "SELECT kd_brg from transaksi_masuk where kd_brg='$kd_brg' and thn_ang='$thn_ang' LIMIT 1";
		// echo $sql;
		$result = $this->query($sql);
		// echo $this->num_rows($result);
		if($this->num_rows($result)==1){
			echo json_encode(array("Barang Tidak Dapat Dihapus karena telah digunakan"));
		}
		else{
			$query = "delete from persediaan
					 where id='$id' ";
			$result = $this->query($query);
					$query = "Insert into log_persediaan
        			set
        			aksi='Hapus',
        			kd_brg='$kd_brg',
        			nm_brg='$nm_brg',
        			nm_sskel='$jns_barang',
        			spesifikasi='$spesifikasi',
                    satuan='$satuan'
                   
                     ";
        	$result = $this->query($query);
			echo json_encode(array("Barang Telah Dihapus"));
		}
	
		
	}

public function delrekbarang($data)
	{
		$query = "delete from perk
					 where id='$data'";
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
	
	public function updrekbarang($data){
		$query = "UPDATE perk
				  SET 
	    			kd_perk='$data[kd_perk]',
	    			nm_perk='$data[nm_perk]'
				  WHERE id='$data[id]'";
		$result = $this->query($query);

		$query = "UPDATE transaksi_masuk
				  SET 	
	    			nm_perk='$data[nm_perk]'
				  WHERE kd_perk='$data[kd_perk]' ";
				  
		$result = $this->query($query);

		$query = "UPDATE transaksi_keluar
				  SET 	
	    			nm_perk='$data[nm_perk]'
				  WHERE kd_perk='$data[kd_perk]' ";

		$result = $this->query($query);

		$query = "UPDATE transaksi_full
				  SET 	
	    			nm_perk='$data[nm_perk]'
				  WHERE kd_perk='$data[kd_perk]' ";

		$result = $this->query($query);

		return $result;
	}

	public function upd_kode_rekening($data){
		$query = "UPDATE rekening
				  SET 
	    			nama_rekening='$data[ur_rek_baru]'
				  WHERE 
	    			kode_rekening='$data[kode_rek]' ";
		$result = $this->query($query);

		$query = "UPDATE transaksi_masuk
				  SET 	
	    			nama_rekening='$data[ur_rek_baru]'
				  WHERE kode_rekening='$data[kode_rek]' ";
		$result = $this->query($query);

		$query = "UPDATE transaksi_keluar
				  SET 	
	    			nama_rekening='$data[ur_rek_baru]'
				  WHERE kode_rekening='$data[kode_rek]' ";		  
		$result = $this->query($query);

		$query = "UPDATE transaksi_full
				  SET 	
	    			nama_rekening='$data[ur_rek_baru]'
				  WHERE kode_rekening='$data[kode_rek]' ";		  
		$result = $this->query($query);

		return $result;
	}

}
?>