<?php
include('../../utility/mysql_db.php');
class modelTransaksi extends mysql_db
{
	
	public function transaksi_masuk($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lok_msk'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $kd_brg = $data['kd_brg'];

        $kuantitas = $data['kuantitas'];
        $harga_sat = $data['harga_sat'];
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];
        
        for($i=0; $i<$kuantitas; $i++)
        {
            $query = "Insert into transaksi
                    set kd_lokasi='$kd_lokasi',
                    kd_lok_msk='$kd_lok_msk',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='$jns_trans',
                    kd_brg='$kd_brg',
                    qty=1,
                    harga_sat='$harga_sat',
                    keterangan='$keterangan',
                    status='$status',
                    user_id='$user_id'";
            $result = $this->query($query);
        }
            return $result;
    }


    public function bacadok($data)
    {
        $query = "select * from trans_klr";
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


	public function ubahtransklr($data)
	{
		$kd_lokasi = $data['kd_lokasi'];
		$kd_lok_klr = $data['kd_lok_klr'];
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
		$query = "update brg
					set kd_lokasi='$kd_lokasi',
        			kd_lok_klr='$kd_lok_klr',
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
                    rph_sat='$rph_sat' 
						where kd_kbrg='$kd_kbrg'";
		$result = $this->query($query);
		return $result;
	}
	
	public function hapustransklr($data)
	{
		$kd_lokasi = $data['kd_lokasi'];
		$kd_lok_klr = $data['kd_lok_klr'];
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
		$query = "delete from brg
					 where kd_kbrg='$kd_kbrg'";
		$result = $this->query($query);
		return $result;
	}
}
?>