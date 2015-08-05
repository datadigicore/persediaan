<?php
include('../../utility/mysql_db.php');
class modelTransMsk extends mysql_db
{
	public function tambahbrgmsk($data)
	{
        $no_dok = $data['no_dok'];
		$kd_brg = $data['kd_brg'];
		$kuantitas = $data['kuantitas'];
		$keterangan = $data['keterangan'];
		$rph_sat = $data['rph_sat'];
        $user_id = $data['user_id'];

		$query = "Insert into barang_msk 
        			set no_dok='$no_dok', 
                    kd_brg='$kd_brg',
        			kuantitas='$kuantitas',
                    rph_sat='$rph_sat',
                    user_id='$user_id'";
        $result = $this->query($query);
		return $result;
	}

    public function tambahdokumen($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lok_msk'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $user_id = $data['user_id'];

        $query = "Insert into trans_msk
                    set kd_lokasi='$kd_lokasi',
                    kd_lok_msk='$kd_lok_msk',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='$jns_trans',
                    keterangan='$keterangan',
                    user_id='$user_id'";
        $result = $this->query($query);
        return $result;
    }


    public function bacatable($data)
    {
        $query = "select * from sedia_msk
                    where kd_uapb = '$data'";
        $result = $this->query($query);
        while ($row = $this->fetch_assoc($result))
        {
            // $rows[] = [$row['kd_lokasi'],$row["kd_lok_msk"],$row["thn_ang"],$row["no_dok"],$row["tgl_dok"],$row["tgl_buku"],$row["kd_brg"],$row["kuantitas"],$row["keterangan"],$row["asal"],$row["no_bukti"],$row["jns_trans"],$row["rph_sat"]];
        }
        echo json_encode($rows);
    }

    public function bacadok($data)
    {
        $query = "select * from trans_msk";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Dokumen --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['no_dok'].'">'.$row['no_dok'].' '.$row['tgl_dok']."</option>";
        }   
    }    

    public function bacabrg($data)
    {
        $query = "select * from brg";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Barang --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_brg']."</option>";
        }   
    }    

    public function bacauakpb($data)
    {
        $query = "select * from uakpb";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Barang --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_lokasi'].'">'.$row['kd_lokasi'].' '.$row['nm_uakpb']."</option>";
        }   
    }
}
?>