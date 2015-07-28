<?php
include('../../utility/mysql_db.php');
class modelTransMsk extends mysql_db
{
	public function tambahtransmsk($data)
	{
		$kd_lokasi = $data['kd_lokasi'];
		$kd_lok_msk = $data['kd_lok_msk'];
		$thn_ang = $data['thn_ang'];
		$no_dok = $data['no_dok'];
		$tgl_dok = $data['tgl_dok'];
		$tgl_buku = $data['tgl_buku'];
		$kd_brg = $data['kd_brg'];
		$kuantitas = $data['kuantitas'];
		$keterangan = $data['keterangan'];
		$asal = $data['asal'];
		$no_bukti = $data['no_bukti'];
		$jns_trans = $data['jns_trans'];
		$rph_sat = $data['rph_sat'];
		$query = "Insert into sedia_msk
        			set kd_lokasi='$kd_lokasi',
        			kd_lok_msk='$kd_lok_msk',
        			thn_ang='$thn_ang',
        			no_dok='$no_dok',
        			tgl_dok='$tgl_dok',
        			tgl_buku='$tgl_buku',
        			kd_brg='$kd_brg',
        			kuantitas='$kuantitas',
        			keterangan='$keterangan',
        			asal='$asal',
        			no_bukti='$no_bukti',
        			jns_trans='$jns_trans',
                    rph_sat='$rph_sat'";
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
}
?>