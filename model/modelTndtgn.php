<?php
include('../../utility/mysql_db.php');
class modelTndtgn extends mysql_db
{
	public function tambahttd($data)
	{
		$kd_lokasi = $data['kd_lokasi'];
		$kota = $data['kota'];
		$tanggal = $data['tanggal'];
		$nip = $data['nip'];
		$nama = $data['nama'];
		$jabatan = $data['jabatan'];
		$nip2 = $data['nip2'];
		$nama2 = $data['nama2'];
		$jabatan2 = $data['jabatan2'];
		$tgl_isi = $data['tgl_isi'];
		$tgl_setuju = $data['tgl_setuju'];
		$unit = $data['unit'];
		$query = "Insert into ttd
        			set kd_lokasi='$kd_lokasi',
        			    kota='$kota',
        			    tanggal='$tanggal',
        			    nip='$nip',
        				nama='$nama',
                    	jabatan='$jabatan',
                    	nip2='$nip2',
                    	nama2='$nama2',
                    	jabatan2='$jabatan2',
                    	tgl_isi='$tgl_isi',                   	
                    	tgl_setuju='$tgl_setuju',
                    	unit='$unit'";
        $result = $this->query($query);
		return $result;
	}
}
?>