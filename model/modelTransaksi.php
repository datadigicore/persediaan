<?php
include('../../utility/mysql_db.php');
class modelTransaksi extends mysql_db
{
    
    public function transaksi_masuk($data)
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
        $nm_brg = $data['nm_brg'];
        $satuan = $data['satuan'];
        $kuantitas = $data['kuantitas'];
        $harga_sat = $data['harga_sat'];
        $total_harga = $kuantitas*$harga_sat;
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];
   
// Memasukan Data Transaksi Masuk ke tabel Transaksi Masuk        
        $query = "Insert into transaksi_masuk
                    set kd_lokasi='$kd_lokasi',
                    kd_lok_msk='$kd_lok_msk',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='$jns_trans',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    satuan='$satuan',
                    qty='$kuantitas',
                    qty_akhir='$kuantitas',
                    harga_sat='$harga_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status='$status',
                    tgl_update=CURDATE(),
                    user_id='$user_id'";   
        $result = $this->query($query);
        
// Mendapatkan ID transaksi masuk dan disimpan ke variabel id_trans             
        $query_id = "select id from transaksi_masuk WHERE kd_brg='$kd_brg' and qty='$kuantitas' and user_id='$user_id' and no_dok='$no_dok' order by ID DESC";
        $result_id = $this->query($query_id);
        $row_id = $this->fetch_array($result_id);
        $id_trans = $row_id['id'];

// Memasukkan Data Transaksi Masuk ke Tabel Transaksi Full
        $query_full = "Insert into transaksi_full
                        set kd_lokasi='$kd_lokasi',
                        id_trans='$id_trans',
                        kd_lok_msk='$kd_lok_msk',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        satuan='$satuan',
                        qty='$kuantitas',
                        harga_sat='$harga_sat',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        status='$status',
                        tgl_update=CURDATE(),
                        user_id='$user_id'";
                   
            $result2 = $this->query($query_full);       
            return $result;
            return $result2;
    }      



    public function trnsaksi_keluar($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $kd_brg = $data['kd_brg'];
        $nm_brg = $data['nm_brg'];
        $satuan = $data['satuan'];
        $kuantitas = $data['kuantitas'];
        $harga_sat = $data['harga_sat'];
        
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];


        while($kuantitas > 0)
        {   
            echo " kuantitas tersisa : ".$kuantitas; 
            $query_id = "select id,kd_brg,qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and user_id='$user_id' and qty_akhir>0 order by tgl_buku asc limit 1";     
            $result_id = $this->query($query_id);
            $row_id = $this->fetch_array($result_id);
            $id_trans_m = $row_id['id'];   
            $qty_akhir = $row_id['qty_akhir'];      
            $harga_sat = $row_id['harga_sat']; 
            $total_harga = $kuantitas*$harga_sat;     
            echo "ID transaksi masuk : ".$id_trans_m.' '.$qty_akhir.' '.$harga_sat;
            echo '<br>';

            
            if($kuantitas<$qty_akhir)
            {
                echo "terbukti sisa kuantitas : ".$kuantitas.' dengan qy akhir : '.$qty_akhir;
                echo '<br>';

                $query_keluar = "Insert into transaksi_keluar
                                    set kd_lokasi='$kd_lokasi',
                                    id_masuk = '$id_trans_m',
                                    kd_lok_msk='$kd_lok_msk',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='$no_bukti',
                                    jns_trans='$jns_trans',
                                    kd_brg='$kd_brg',
                                    nm_brg='$nm_brg',
                                    satuan='$satuan',
                                    qty='$kuantitas',
                                    harga_sat='$harga_sat',
                                    total_harga='$total_harga',
                                    keterangan='$keterangan',
                                    status='$status',
                                    tgl_update=CURDATE(),
                                    user_id='$user_id'";   
                $result_keluar = $this->query($query_keluar);

                $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $kuantitas where user_id='$user_id' and id='$id_trans_m'";
                $result_upd_masuk = $this->query($query_upd_masuk);

                $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and user_id='$user_id' order by id DESC";
                $result_idk = $this->query($query_idk);
                $row_idk = $this->fetch_array($result_idk);
                $id_transk = $row_idk['id'];
                $minus_qty = -$kuantitas;
                $minus_hrg = -$harga_sat;
                $minus_total = -$total_harga;
                echo "id trans keluar : ".$id_transk;
                echo '<br>';

                $query_full = "Insert into transaksi_full
                                set kd_lokasi='$kd_lokasi',
                                id_trans='$id_transk',
                                kd_lok_msk='$kd_lok_msk',
                                thn_ang='$thn_ang',
                                no_dok='$no_dok',
                                tgl_dok='$tgl_dok',
                                tgl_buku='$tgl_buku',
                                no_bukti='$no_bukti',
                                jns_trans='$jns_trans',
                                kd_brg='$kd_brg',
                                nm_brg='$nm_brg',
                                satuan='$satuan',
                                qty='$minus_qty',
                                harga_sat='$minus_hrg',
                                total_harga='$minus_total',
                                keterangan='$keterangan',
                                status='$status',
                                tgl_update=CURDATE(),
                                user_id='$user_id'"; 
                $result_trans_full = $this->query($query_full);
                $kuantitas = 0;
                break;
            }
            // else
            // {
                $query_id = "select id,kd_brg,qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and user_id='$user_id' and qty_akhir>0 order by tgl_buku asc limit 1"; 
                $result_id = $this->query($query_id);
                $row_id = $this->fetch_array($result_id);
                $id_trans = $row_id['id'];   
                $qty_akhir = $row_id['qty_akhir'];      
                $harga_sat = $row_id['harga_sat']; 

                echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                echo '<br>';

                $query_keluar = "Insert into transaksi_keluar
                                set 
                                kd_lokasi='$kd_lokasi',
                                id_masuk = '$id_trans',
                                kd_lok_msk='$kd_lok_msk',
                                thn_ang='$thn_ang',
                                no_dok='$no_dok',
                                tgl_dok='$tgl_dok',
                                tgl_buku='$tgl_buku',
                                no_bukti='$no_bukti',
                                jns_trans='$jns_trans',
                                kd_brg='$kd_brg',
                                nm_brg='$nm_brg',
                                satuan='$satuan',
                                qty='$qty_akhir',
                                harga_sat='$harga_sat',
                                total_harga='$total_harga',
                                keterangan='$keterangan',
                                status='$status',
                                tgl_update=CURDATE(),
                                user_id='$user_id'"; 
                $result_keluar = $this->query($query_keluar);

                $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $qty_akhir where user_id='$user_id' and id='$id_trans'";
                $result_upd_masuk = $this->query($query_upd_masuk);

                $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and user_id='$user_id' order by id DESC";
                $result_idk = $this->query($query_idk);
                $row_idk = $this->fetch_array($result_idk);
                $id_transk = $row_idk['id'];

                $query_full = "Insert into transaksi_full
                                set kd_lokasi='$kd_lokasi',
                                id_trans='$id_transk',
                                kd_lok_msk='$kd_lok_msk',
                                thn_ang='$thn_ang',
                                no_dok='$no_dok',
                                tgl_dok='$tgl_dok',
                                tgl_buku='$tgl_buku',
                                no_bukti='$no_bukti',
                                jns_trans='$jns_trans',
                                kd_brg='$kd_brg',
                                nm_brg='$nm_brg',
                                satuan='$satuan',
                                qty='$qty_akhir',
                                harga_sat='$harga_sat',
                                total_harga='$total_harga',
                                keterangan='$keterangan',
                                status='$status',
                                tgl_update=CURDATE(),
                                user_id='$user_id'"; 
                $result_full = $this->query($query_full);
                $kuantitas = $kuantitas - $qty_akhir;
                              
            // }
            

        }               

    }

   


    public function ubah_transaksi_masuk($data)
    {
        $id = $data['id'];
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];

        $kd_brg = $data['kd_brg'];
        $nm_brg = $data['nm_brg'];
        $satuan = $data['satuan'];

        $kuantitas = $data['kuantitas'];
        $selisih_qty = $data['kuantitas'] - $data['qty_awal'];

        $harga_sat = $data['harga_sat'];
        $selisih_hrg = $data['harga_sat'] - $data['hrg_awal'];

        $total_harga = $kuantitas*$harga_sat;
        $selisih_tot_hrga = $selisih_qty * $selisih_hrg;
        
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];
        $query_ubah = "update transaksi_masuk 
                        set qty='$kuantitas', 
                        qty_akhir = qty_akhir + '$selisih_qty',
                        harga_sat='$harga_sat', 
                        tgl_update=CURDATE() 
                        where id= '$id' ";
        $query_full = "Insert into transaksi_full
                        set kd_lokasi='$kd_lokasi',
                        kd_lok_msk='$kd_lok_msk',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        satuan='$satuan',
                        qty='$selisih_qty',
                        harga_sat='$selisih_hrg',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        status='$status',
                        tgl_update=CURDATE(),
                        user_id='$user_id'";
            $result = $this->query($query_ubah);       
            $result2 = $this->query($query_full);       
            return $result;
            return $result2;
    }  

    public function transaksi_keluar($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $kd_brg = $data['kd_brg'];
        $nm_brg = $data['nm_brg'];
        $satuan = $data['satuan'];
        $kuantitas = $data['kuantitas'];
        $harga_sat = $data['harga_sat'];
        $total_harga = $kuantitas*$harga_sat;
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];
        
        $query = "Insert into transaksi_keluar
                    set kd_lokasi='$kd_lokasi',
                    kd_lok_msk='$kd_lok_msk',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='$jns_trans',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    satuan='$satuan',
                    qty='$kuantitas',
                    harga_sat='$harga_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status='$status',
                    tgl_update=CURDATE(),
                    user_id='$user_id'";
            $result = $this->query($query);       
            return $result;
    }       

    public function tbh_koreksi_masuk($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $kd_brg = $data['kd_brg'];
        $nm_brg = $data['nm_brg'];
        $satuan = $data['satuan'];
        $kuantitas = $data['kuantitas'];
        $harga_sat = $data['harga_sat'];
        $total_harga = $kuantitas*$harga_sat;
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];
        
        $query = "Insert into transaksi_masuk
                    set kd_lokasi='$kd_lokasi',
                    kd_lok_msk='$kd_lok_msk',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='$jns_trans',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    satuan='$satuan',
                    qty='$kuantitas',
                    harga_sat='$harga_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status='$status',
                    tgl_update=CURDATE(),
                    user_id='$user_id'";
            $result = $this->query($query);       
            return $result;
    }   

  
    public function bacabrg($data)
    {
        $query = "select * from persediaan where user_id='$data'";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Barang --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_brg']."</option>";
        }   
    }    

    public function baca_persediaan_masuk($data)
    {
        $query = "select kd_brg, nm_brg FROM transaksi_masuk where user_id = '$data' GROUP BY kd_brg ORDER BY nm_brg ASC ";
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

    public function baca_detil_trans($data)
    {
        $kd_brg = $data['kd_brg'];
        $no_dok = $data['no_dok'];
        $query_brg = "select * from persediaan where kd_brg = '$kd_brg'";
        $result_brg = $this->query($query_brg);
        $row_brg = $this->fetch_array($result_brg);
        echo '<input type="hidden" name="nm_brg" value="'.$row_brg['nm_brg'].'">';
        echo '<input type="hidden" name="satuan" value="'.$row_brg['satuan'].'">';      
        // echo $row_brg['nm_brg'].'  '.$row_brg['satuan'];
        // echo json_encode(array("harga_sat"=>$row_brg["harga_sat"]));
    }

    public function harga_terakhir($data)
    {

        $query = "select  nm_brg, harga_sat FROM transaksi_masuk where kd_brg = '$data'  GROUP by kd_brg, nm_brg, tgl_buku DESC LIMIT 1";
        $query_saldo = "select suma.a - sumb.b as saldo from (SELECT sum(qty) as a FROM transaksi_masuk WHERE kd_brg = '$data') as suma, (SELECT sum(qty) as b FROM transaksi_keluar WHERE kd_brg = '$data') as sumb";
        
        $result = $this->query($query);
        $result_saldo = $this->query($query_saldo);
        $row_harga = $this->fetch_array($result);
        $row_saldo = $this->fetch_array($result_saldo);

        echo json_encode(array("harga_sat"=>$row_harga["harga_sat"],"saldo"=>$row_saldo["saldo"]));
        
    }

    

}
?>