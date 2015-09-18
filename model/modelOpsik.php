<?php
include('../../utility/mysql_db.php');
class modelOpsik extends mysql_db
{
        public function hapus_opname($data)
    {
        $id_masuk = $data['id'];
        $user_id = $data['user_id'];
        $query_hapus = "update opname set status_hapus=1  
                        where id= '$id_masuk' ";
        $result_hapus = $this->query($query_hapus);

        $update_status = "update transaksi_masuk set status=0  
                        where id= '$id_masuk' ";
        $result_hapus = $this->query($query_hapus);
    }

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
        $query = "select kd_brg, nm_brg FROM transaksi_masuk where kd_lokasi = '$kd_lokasi' and status_hapus=0 and qty>0  and thn_ang = '$thn_ang' and status=0 GROUP BY kd_brg ORDER BY nm_brg ASC ";
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


        $query_hrg = "SELECT sum(qty_akhir) as qty, sum(qty_akhir*harga_sat)/sum(qty_akhir) as harga, 
                         sum(qty_akhir*harga_sat)%sum(qty_akhir) as sisabagi
                         from transaksi_masuk
                         where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and kd_brg='$kd_brg' and status=0 and status_hapus=0";
        $result_hrg = $this->query($query_hrg);
        $data_hrg = $this->fetch_array($result_hrg);
        $hrg_sat = floor($data_hrg['harga']);
        $sisabagi = $data_hrg['sisabagi'];
        
        $total_harga = ($kuantitas*$hrg_sat)+$sisabagi;



// Memasukan Data Transaksi Masuk ke tabel Transaksi Masuk        
        $query = "Insert into opname
                    set 
                    kd_lokasi='$kd_lokasi',
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
                    harga_sat='$hrg_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status=0,
                    tgl_update=CURDATE(),
                    user_id='$user_id'";   
        $result = $this->query($query);  

        $jml_brg = $data_hrg['qty'];     
        $selisih = $kuantitas - $jml_brg;
        $selisih_total_harga = ($selisih*$hrg_sat)+$sisabagi;
        if($selisih>0)
        {
            $query_masuk = "Insert into transaksi_masuk
                    set 
                    kd_lokasi='$kd_lokasi',
                    kd_lok_msk='',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='P01',
                    kd_sskel='$kd_sskel',
                    nm_sskel='$nm_sskel',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    satuan='$satuan',
                    qty='$selisih',
                    qty_akhir='$selisih',
                    harga_sat='$hrg_sat',
                    total_harga='$selisih_total_harga',
                    keterangan='$keterangan',
                    status='1',
                    tgl_update=CURDATE(),
                    user_id='$user_id'";   
            $result_masuk = $this->query($query_masuk);
        
        $query_id = "select id from transaksi_masuk WHERE kd_brg='$kd_brg' and qty='$selisih' and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' order by ID DESC LIMIT 1";
        $result_id = $this->query($query_id);
        $row_id = $this->fetch_array($result_id);
        $id_trans = $row_id['id'];
        
            $query_full = "Insert into transaksi_full
                    set 
                    kd_lokasi='$kd_lokasi',
                    kd_lok_msk='',
                    id_masuk='$id_trans',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='P01',
                    kd_sskel='$kd_sskel',
                    nm_sskel='$nm_sskel',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    satuan='$satuan',
                    qty='$selisih',
                    
                    harga_sat='$hrg_sat',
                    total_harga='$selisih_total_harga',
                    keterangan='$keterangan',
                    status='1',
                    tgl_update=CURDATE(),
                    user_id='$user_id'";   
            $result_full = $this->query($query_full);
        }
        if($selisih<0) 
        {
            $selisih = -1 * $selisih;        
            while($selisih > 0)
            {   
                echo " kuantitas tersisa : ".$selisih; 
                $query_id = "select id, kd_sskel, nm_sskel, kd_brg, kd_perk, nm_perk, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and qty_akhir>0 and status_hapus=0 and status_edit=0 order by tgl_dok asc limit 1";     
                $result_id = $this->query($query_id);
                $row_id = $this->fetch_array($result_id);
                $id_trans_m = $row_id['id'];   
                $qty_akhir = $row_id['qty_akhir'];      
                $harga_sat = $row_id['harga_sat']; 
                $total_harga = $selisih*$harga_sat;  

                $kd_sskel = $row_id['kd_sskel'];
                $nm_sskel = $row_id['nm_sskel'];
                $kd_perk = $row_id['kd_perk'];
                $nm_perk = $row_id['nm_perk'];

                echo "ID transaksi masuk : ".$id_trans_m.' '.$qty_akhir.' '.$harga_sat;
                echo '<br>';

                
                if($selisih<$qty_akhir)
                {
                    echo "terbukti sisa kuantitas : ".$selisih.' dengan qy akhir : '.$qty_akhir;
                    echo '<br>';

                    $query_keluar = "Insert into transaksi_keluar
                                        set kd_lokasi='$kd_lokasi',
                                        id_masuk = '$id_trans_m',
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
                                        kd_perk='$kd_perk',
                                        nm_perk='$nm_perk',                                    
                                        kd_brg='$kd_brg',
                                        nm_brg='$nm_brg',
                                        satuan='$satuan',
                                        qty=-1*'$selisih',
                                        harga_sat='$harga_sat',
                                        total_harga=-1*'$total_harga',
                                        keterangan='$keterangan',
                                        status=0,
                                        tgl_update=CURDATE(),
                                        user_id='$user_id'";   
                    $result_keluar = $this->query($query_keluar);

                    $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $selisih where user_id='$user_id' and id='$id_trans_m'";
                    $result_upd_masuk = $this->query($query_upd_masuk);

                    $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and user_id='$user_id' order by id DESC";
                    $result_idk = $this->query($query_idk);
                    $row_idk = $this->fetch_array($result_idk);
                    $id_transk = $row_idk['id'];
                    $minus_qty = -$selisih;
                    $minus_hrg = -$harga_sat;
                    $minus_total = -$total_harga;
                    echo "id trans keluar : ".$id_transk;
                    echo '<br>';

                    $query_full = "Insert into transaksi_full
                                    set kd_lokasi='$kd_lokasi',
                                    id_keluar='$id_transk',
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
                                    kd_perk='$kd_perk',
                                    nm_perk='$nm_perk',
                                    kd_brg='$kd_brg',
                                    nm_brg='$nm_brg',
                                    satuan='$satuan',
                                    qty='$minus_qty',
                                    harga_sat='$minus_hrg',
                                    total_harga='$minus_total',
                                    keterangan='$keterangan',
                                    status=0,
                                    tgl_update=CURDATE(),
                                    user_id='$user_id'"; 
                    $result_trans_full = $this->query($query_full);
                    $selisih = 0;
                    break;
                }
                    $query_id = "select id,kd_brg,qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and qty_akhir>0 and status_hapus=0 and status_edit=0 order by tgl_dok asc limit 1"; 
                    $result_id = $this->query($query_id);
                    $row_id = $this->fetch_array($result_id);
                    $id_trans = $row_id['id'];   
                    $qty_akhir = $row_id['qty_akhir'];      
                    $harga_sat = $row_id['harga_sat']; 
                    $total_harga = $qty_akhir * $harga_sat;
                    echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                    echo '<br>';

                    $query_keluar = "Insert into transaksi_keluar
                                    set 
                                    kd_lokasi='$kd_lokasi',
                                    id_masuk = '$id_trans',
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
                                    kd_perk='$kd_perk',
                                    nm_perk='$nm_perk',
                                    kd_brg='$kd_brg',
                                    nm_brg='$nm_brg',
                                    satuan='$satuan',
                                    qty=-1*'$qty_akhir',
                                    harga_sat='$harga_sat',
                                    total_harga=-1*'$total_harga',
                                    keterangan='$keterangan',
                                    status=0,
                                    tgl_update=CURDATE(),
                                    user_id='$user_id'"; 
                    $result_keluar = $this->query($query_keluar);

                    $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $qty_akhir where kd_lokasi='$kd_lokasi' and id='$id_trans'";
                    $result_upd_masuk = $this->query($query_upd_masuk);

                    $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' order by id DESC";
                    $result_idk = $this->query($query_idk);
                    $row_idk = $this->fetch_array($result_idk);
                    $id_transk = $row_idk['id'];

                    $minus_qty = -$qty_akhir;
                    $minus_hrg = -$harga_sat;
                    $minus_total = -$total_harga;

                    $query_full = "Insert into transaksi_full
                                    set kd_lokasi='$kd_lokasi',
                                    id_trans='$id_transk',
                                    id_keluar='$id_transk',
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
                                    kd_perk='$kd_perk',
                                    nm_perk='$nm_perk',
                                    kd_brg='$kd_brg',
                                    nm_brg='$nm_brg',
                                    satuan='$satuan',
                                    qty='$minus_qty',
                                    harga_sat='$minus_hrg',
                                    total_harga='$minus_total',
                                    keterangan='$keterangan',
                                    status=0,
                                    tgl_update=CURDATE(),
                                    user_id='$user_id'"; 
                    $result_full = $this->query($query_full);
                    $selisih = $selisih - $qty_akhir;
                               
            }  


        }
     

        $update_brg = "update transaksi_masuk set  status=1 where kd_lokasi='$kd_lokasi' and kd_brg='$kd_brg' and status_hapus=0 ";
        $result_upd = $this->query($update_brg);
        $update_brg_klr = "update transaksi_keluar set  status=1 where kd_lokasi='$kd_lokasi' and kd_brg='$kd_brg' and status_hapus=0 ";
        $result_upd_klr = $this->query($update_brg_klr);




    }   

}
?>