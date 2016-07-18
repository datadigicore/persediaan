<?php
include('../../utility/mysql_db.php');
class modelTndtgn extends mysql_db
{
	public function tambahttd($data)
	{
		$kd_lokasi = $data['kd_lokasi'].$data['kd_ruang'];

		$kota = $data['kota'];
		$tanggal = $data['tanggal'];
		$nip = $data['nip'];
		$nama = $data['nama'];
		$jabatan = $data['jabatan'];
		$nip2 = $data['nip2'];
		$nama2 = $data['nama2'];
		$jabatan2 = $data['jabatan2'];
		$nama_kasubkeu = $data['nama_kasubkeu'];
		$nip_kasubkeu = $data['nip_kasubkeu'];
		$tgl_isi = $data['tgl_isi'];
		$tgl_setuju = $data['tgl_setuju'];
		$unit = $data['unit'];

		$query_cek = "SELECT kd_lokasi from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_lokasi' ";
		$result_cek = $this->query($query_cek);
		$cek= $this->fetch_array($result_cek);
		if($cek=="")
		{
			$query = "Insert into ttd
        			set kd_lokasi='$kd_lokasi',
        			    kota='$kota',
        			    tanggal='$tanggal',
        			    nip='$nip',
        				nama='$nama',
                    	jabatan='$jabatan',
                    	nip2='$nip2',
                    	nama2='$nama2',
                    	nama_kasubkeu='$nama_kasubkeu',
                    	nip_kasubkeu='$nip_kasubkeu',
                    	jabatan2='$jabatan2',

                    	unit='$unit'

                    	";
        	$result = $this->query($query);
			return $result;			
		}
		else 
		{
			$query_upd = "update ttd
        				set 
        				
        			    kota='$kota',
        			    tanggal='$tanggal',
        			    nip='$nip',
        				nama='$nama',
                    	jabatan='$jabatan',
                    	nip2='$nip2',
                    	nama2='$nama2',
                    	jabatan2='$jabatan2',
                    	nama_kasubkeu='$nama_kasubkeu',
                    	nip_kasubkeu='$nip_kasubkeu',
                    	unit='$unit' where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_lokasi'
                    	";
        	$result_upd = $this->query($query_upd);
			return $result_upd;	
		}

	}

	public function baca_data_pj($data)
	{
		$query = "select * from ttd where kd_lokasi='$data'";
        $result = $this->query($query);

        $data_pj = $this->fetch_array($result);

        echo json_encode(array("nip"=>$data_pj["nip"], "nama"=>$data_pj["nama"], "jabatan"=>$data_pj["jabatan"], "nip2"=>$data_pj["nip2"], "nama2"=>$data_pj["nama2"], "jabatan2"=>$data_pj["jabatan2"], "nama-kasubkeu"=>$data_pj["nama_kasubkeu"], "nip-kasubkeu"=>$data_pj["nip_kasubkeu"], "kota"=>$data_pj["kota"]));

	


	}	

	public function baca_data_awal($data)
	{
		$query = "select * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$data' order by kd_lokasi asc limit 1";
        $result = $this->query($query);

        $data_pj = $this->fetch_array($result);

        echo json_encode(array("nip"=>$data_pj["nip"], "nama"=>$data_pj["nama"], "jabatan"=>$data_pj["jabatan"], "nip2"=>$data_pj["nip2"], "nama2"=>$data_pj["nama2"], "jabatan2"=>$data_pj["jabatan2"], "namakasubkeu"=>$data_pj["nama_kasubkeu"], "nipkasubkeu"=>$data_pj["nip_kasubkeu"], "kota"=>$data_pj["kota"]));

	


}
}
?>