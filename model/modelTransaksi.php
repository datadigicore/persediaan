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

        $query_perk = "SELECT kd_kbrg, nm_sskel, kd_perk, nm_perk from persediaan where kd_brg='$kd_brg' ";
        $result_perk = $this->query($query_perk);
        $data_perk = $this->fetch_array($result_perk);
        $kd_sskel = $data_perk['kd_kbrg'];
        $nm_sskel = $data_perk['nm_sskel'];
        $kd_perk = $data_perk['kd_perk'];
        $nm_perk = $data_perk['nm_perk'];

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
                    kd_sskel='$kd_sskel',
                    nm_sskel='$nm_sskel',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
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
                   
            $result2 = $this->query($query_full);       
            return $result;
            return $result2;
    }      



    public function trnsaksi_keluar($data)
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
        
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];


        while($kuantitas > 0)
        {   
            echo " kuantitas tersisa : ".$kuantitas; 
            $query_id = "select id, kd_sskel, nm_sskel, kd_brg, kd_perk, nm_perk, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and user_id='$user_id' and qty_akhir>0 order by tgl_buku asc limit 1";     
            $result_id = $this->query($query_id);
            $row_id = $this->fetch_array($result_id);
            $id_trans_m = $row_id['id'];   
            $qty_akhir = $row_id['qty_akhir'];      
            $harga_sat = $row_id['harga_sat']; 
            $total_harga = $kuantitas*$harga_sat;  

            $kd_sskel = $row_id['kd_sskel'];
            $nm_sskel = $row_id['nm_sskel'];
            $kd_perk = $row_id['kd_perk'];
            $nm_perk = $row_id['nm_perk'];

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
                                    qty=-1*'$kuantitas',
                                    harga_sat='$harga_sat',
                                    total_harga=-1*'$total_harga',
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

                $minus_qty = -$qty_akhir;
                $minus_hrg = -$harga_sat;
                $minus_total = -$total_harga;

                $query_full = "Insert into transaksi_full
                                set kd_lokasi='$kd_lokasi',
                                id_trans='$id_transk',
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
        
        $query = "Insert into transaksi_keluar
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
                    harga_sat='$harga_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status='$status',
                    tgl_update=CURDATE(),
                    user_id='$user_id'";
            $result = $this->query($query);       
            return $result;
    }       


    public function hapus_transaksi_masuk($data)
    {
        $id_masuk = $data['id'];

        $query_id = "select id, kd_lokasi, nm_satker, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti,kd_brg, nm_brg, qty, harga_sat, total_harga  from transaksi_masuk WHERE id='$id_masuk'";
        $result_id = $this->query($query_id);
        $row_id = $this->fetch_array($result_id);
        $kd_lokasi=$row_id['kd_lokasi'];
        $nm_satker = $row_id['nm_satker'];
        
        $no_dok = $row_id['no_dok'];
        $tgl_dok = $row_id['tgl_dok'];
        $tgl_buku = $row_id['tgl_buku'];
        $no_bukti = $row_id['no_bukti'];
        $kd_brg = $row_id['kd_brg'];
        $nm_brg = $row_id['nm_brg'];
        $keterangan = $row_id['keterangan'];
        $id_trans = $row_id['id'];
        $qty_awal = $row_id['qty'];
        $harga_sat = $row_id['harga_sat'];
        $total_harga = $row_id['total_harga'];

        $user_id = $data['user_id'];
        $query_ubah = "update transaksi_masuk set status_hapus=1  
                        where id= '$id_masuk' ";

        $query_full = "Insert into transaksi_full
                        set 
                        kd_lokasi='$kd_lokasi',
                        kd_lok_msk='$kd_lok_msk',
                        nm_satker='$nm_satker',
                        id_trans='$id_trans',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        satuan='$satuan',
                        qty= -1 * '$qty_awal',
                        harga_sat= -1 * '$harga_sat',
                        total_harga= -1 * '$total_harga',
                        keterangan='Hapus Transaksi Masuk',
                        status='$status',
                        tgl_update=CURDATE(),
                        user_id='$user_id'";
            $result = $this->query($query_ubah);       
            $result2 = $this->query($query_full);       
            return $result;
            return $result2;
    }

    public function hapus_transaksi_keluar($data)
    {
        $id = $data['id'];
        $user_id = $data['user_id'];

        $query_id = "select id, id_masuk, kd_lokasi, tgl_dok, tgl_buku, no_bukti, kd_brg, nm_brg, qty, harga_sat, total_harga  from transaksi_keluar WHERE id='$id'";
        $result_id = $this->query($query_id);
        $row_id = $this->fetch_array($result_id);
        $id_trans = $row_id['id'];

        $kd_lokasi=$row_id['kd_lokasi'];
        $nm_satker = $row_id['nm_satker'];
        
        $no_dok = $row_id['no_dok'];
        $tgl_dok = $row_id['tgl_dok'];
        $tgl_buku = $row_id['tgl_buku'];
        $no_bukti = $row_id['no_bukti'];
        $kd_brg = $row_id['kd_brg'];
        $nm_brg = $row_id['nm_brg'];
        $keterangan = $row_id['keterangan'];
        $id_trans = $row_id['id'];
        $qty_awal = $row_id['qty'];
        $harga_sat = $row_id['harga_sat'];
        $total_harga = abs($row_id['total_harga']);



        $qty = abs($row_id['qty']);
        $harga_sat = $row_id['harga_sat'];
        $total_harga = abs($row_id['total_harga']);
        $id_masuk = $row_id['id_masuk'];

        
        $query_ubah_keluar = "update transaksi_keluar set status_hapus=1  
                        where id= '$id' ";
        $result = $this->query($query_ubah_keluar); 

        $query_upd_masuk = "update transaksi_masuk 
                                set qty_akhir = qty_akhir + '$qty'
                                 where  id='$id_masuk'";

        $result_upd_masuk = $this->query($query_upd_masuk);

        $query_full = "Insert into transaksi_full
                        set 
                        kd_lokasi='$kd_lokasi',
                        kd_lok_msk='$kd_lok_msk',
                        nm_satker='$nm_satker',
                        id_trans='$id_trans',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='H01',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        satuan='$satuan',
                        qty= '$qty',
                        harga_sat= '$harga_sat',
                        total_harga= '$total_harga',
                        keterangan='Hapus Transaksi',
                        status='$status',
                        tgl_update=CURDATE(),
                        user_id='$user_id'";
                  
            $result2 = $this->query($query_full);       
            return $result;
            return $result2;
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
        $query = "select * from persediaan where kd_lokasi='$data'";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Barang --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_brg']."</option>";
        }   
    }    

    public function baca_persediaan_masuk($data)
    {
        $query = "select kd_brg, nm_brg FROM transaksi_masuk where kd_lokasi = '$data' GROUP BY kd_brg ORDER BY nm_brg ASC ";
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

        $query = "select  nm_brg, harga_sat FROM transaksi_masuk where kd_brg = '$data' and qty_akhir>0 GROUP by kd_brg, nm_brg, tgl_buku ASC LIMIT 1";
        $query_saldo = "select suma.a - sumb.b as saldo from (SELECT sum(qty) as a FROM transaksi_masuk WHERE kd_brg = '$data') as suma, (SELECT sum(qty) as b FROM transaksi_keluar WHERE kd_brg = '$data') as sumb";
        
        $result = $this->query($query);
        $result_saldo = $this->query($query_saldo);
        $row_harga = $this->fetch_array($result);
        $row_saldo = $this->fetch_array($result_saldo);

        echo json_encode(array("harga_sat"=>$row_harga["harga_sat"],"saldo"=>$row_saldo["saldo"]));
        
    }    

    public function sisa_barang($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_brg = $data['kd_brg'];
        $query = "select sum(qty_akhir) as sisa,satuan from transaksi_masuk  where kd_brg = '$kd_brg' and kd_lokasi='$kd_lokasi' and status_hapus=0";  
        $result = $this->query($query);
        $sisa_brg = $this->fetch_array($result);

        echo json_encode(array("sisa"=>$sisa_brg["sisa"], "satuan"=>$sisa_brg["satuan"]));

        // if(!empty($sisa_brg["sisa"]))
        // {
        //     echo json_encode(array("sisa"=>$sisa_brg["sisa"], "satuan"=>$sisa_brg["satuan"]));
        // }
        // else
        // {
        //     echo json_encode(array("sisa"=>"0", "satuan"=>$sisa_brg["satuan"]));
        // }


        
        
    }

    

}
?>