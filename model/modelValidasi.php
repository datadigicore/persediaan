<?php
include('../../utility/mysql_db.php');
class modelValidasi extends mysql_db
{
	public function cek_dok_masuk($data)
	{
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        // $kd_brg = $data['kd_brg'];
        // $tgl_dok = $data['tgl_dok'];
        $no_dok = $data['no_dok'];
        $nm_tabel = $data['nm_tabel'];

        $query ="select spesifikasi, nm_brg, status from ".$nm_tabel." where no_dok='$no_dok' and thn_ang = '$thn_ang' order by status desc limit 1";
        $hasil = $this->query($query);
        $row_brg = $this->fetch_array($hasil);
        echo json_encode(array("st_op"=>$row_brg["status"],"nm_brg"=>$row_brg["nm_brg"],"spesifikasi"=>$row_brg["spesifikasi"]));
	}	

    public function cek_tutup_tahun($data){
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];

        

        $query ="select  status_ambil from transaksi_masuk where kd_lokasi = '$kd_lokasi' and thn_ang = '$thn_ang' order by status_ambil desc limit 1";
        $hasil = $this->query($query);
        $row_brg = $this->fetch_array($hasil);
        echo json_encode(array("id"=>$row_brg["id"],"kd_brg"=>$row_brg["kd_brg"],"nm_brg"=>$row_brg["nm_brg"],"st_op"=>$row_brg["status_ambil"], "spesifikasi"=>$row_brg["spesifikasi"]));
    }

}
?>