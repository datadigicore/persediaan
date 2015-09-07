<?php
include('../../utility/mysql_db.php');
class modelOpsik extends mysql_db
{

    function konversi_tanggal($tgl)
    {
        $data_tgl = explode("-",$tgl);
        $array = array($data_tgl[2],$data_tgl[1],$data_tgl[0]);
        $tanggal = implode("/", $array );
        return $tanggal;
    }
    public function baca_persediaan_masuk($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $query = "select kd_brg, nm_brg FROM transaksi_masuk where kd_lokasi = '$kd_lokasi' and status_hapus=0  and thn_ang = '$thn_ang' and status=0 GROUP BY kd_brg ORDER BY nm_brg ASC ";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Barang --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_brg']."</option>";
        }   
    }

    public function hitung_harga($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $kd_brg = $kd_brg;

        $query = "SELECT sum(qty_akhir*harga_sat)/sum(qty) as subtotal, 
                         sum(qty_akhir*harga_sat)%sum(qty) as sisabagi 
                         from transaksi_masuk
                         where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and kd_brg='$kd_brg'";
    }

    public function tbh_opname($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lokasi'];
        $nm_satker = $data['nm_satker'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $kd_brg = $data['kd_brg'];


        $kuantitas = $data['kuantitas'];


        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];

        $query_perk = "SELECT kd_sskel, nm_sskel, kd_perk, nm_perk, nm_brg, satuan from transaksi_masuk where kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' ";
        $result_perk = $this->query($query_perk);
        $data_perk = $this->fetch_array($result_perk);
        $kd_sskel = $data_perk['kd_sskel'];
        $nm_sskel = $data_perk['nm_sskel'];
        $kd_perk = $data_perk['kd_perk'];
        $nm_perk = $data_perk['nm_perk'];
        $nm_brg = $data_perk['nm_brg'];
        $satuan = $data_perk['satuan'];


        $query_hrg = "SELECT sum(qty_akhir) as qty, sum(qty_akhir*harga_sat)/sum(qty) as harga, 
                         sum(qty_akhir*harga_sat)%sum(qty) as sisabagi 
                         from transaksi_masuk
                         where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and kd_brg='$kd_brg'";
        $result_hrg = $this->query($query_hrg);
        $data_hrg = $this->fetch_array($result_hrg);
        $hrg_sat = floor($data_hrg['harga']);
        $sisabagi = $data_hrg['sisabagi'];

        $total_harga = ($kuantitas*$hrg_sat)+$sisabagi;



// Memasukan Data Transaksi Masuk ke tabel Transaksi Masuk        
        $query = "Insert into opname
                    set kd_lokasi='$kd_lokasi',
                    kd_lok_msk='$kd_lok_msk',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='$jns_trans',
                    kd_sskel='$kd_sskel',
                    nm_sskel='$nm_sskel',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    satuan='$satuan',
                    qty='$kuantitas',
                    harga_sat='$harga_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status='$status',
                    tgl_update=CURDATE(),
                    user_id='$user_id'";   
        $result = $this->query($query);

        $update_brg = "update transaksi_masuk set status=1 where kd_lokasi='$kd_lokasi' and kd_brg='$kd_brg'";
        $result_upd = $this->query($update_brg);

        $update_brg_klr = "update transaksi_keluar set status=1, status_hapus = 1, status_edit=1 where kd_lokasi='$kd_lokasi' and kd_brg='$kd_brg'";
        $result_upd_klr = $this->query($update_brg_klr);
        
// Mendapatkan ID transaksi masuk dan disimpan ke variabel id_trans             
        // $query_id = "select id from opname WHERE kd_brg='$kd_brg' and qty='$kuantitas' and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' order by ID DESC";
        // $result_id = $this->query($query_id);
        // $row_id = $this->fetch_array($result_id);
        // $id_trans = $row_id['id'];

// Memasukkan Data Transaksi Masuk ke Tabel Transaksi Full
        // $query_full = "Insert into transaksi_full
        //                 set kd_lokasi='$kd_lokasi',
        //                 id_trans='$id_trans',
        //                 kd_lok_msk='$kd_lok_msk',
        //                 nm_satker='$nm_satker',
        //                 thn_ang='$thn_ang',
        //                 no_dok='$no_dok',
        //                 tgl_dok='$tgl_dok',
        //                 tgl_buku='$tgl_buku',
        //                 no_bukti='$no_bukti',
        //                 jns_trans='$jns_trans',
        //                 kd_sskel='$kd_sskel',
        //                 nm_sskel='$nm_sskel',
        //                 kd_brg='$kd_brg',
        //                 nm_brg='$nm_brg',
        //                 kd_perk='$kd_perk',
        //                 nm_perk='$nm_perk',
        //                 satuan='$satuan',
        //                 qty='$kuantitas',
        //                 harga_sat='$harga_sat',
        //                 total_harga='$total_harga',
        //                 keterangan='$keterangan',
        //                 status='$status',
        //                 tgl_update=CURDATE(),
        //                 user_id='$user_id'";
                   
            // $result2 = $this->query($query_full);       
            return $result;
            // return $result2;
    }   

}
?>