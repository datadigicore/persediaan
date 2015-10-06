<?php
include('../../utility/mysql_db.php');
class modelOpsik extends mysql_db
{
    public function hapus_opname($data)
    {
        $id_opname = $data['id'];
        $user_id = $data['user_id'];

        $query_t_full = "select * from transaksi_full where id_opname='$id_opname' and jns_trans='P02' and id_masuk is not null ";
        $result_t_full = $this->query($query_t_full);
        while ($row_id = $this->fetch_array($result_t_full))
            { 
                $id_masuk = $row_id['id_masuk'];
                $kd_lokasi=$row_id['kd_lokasi'];
                $nm_satker = $row_id['nm_satker'];
                $thn_ang = $row_id['thn_ang'];
                $no_dok = $row_id['no_dok'];
                $tgl_dok = $row_id['tgl_dok'];
                $tgl_buku = $row_id['tgl_buku'];
                $no_bukti = $row_id['no_bukti'];

                $kd_sskel = $row_id['kd_sskel'];
                $nm_sskel = $row_id['nm_sskel'];
                $kd_perk = $row_id['kd_perk'];
                $nm_perk = $row_id['nm_perk'];
                $satuan = $row_id['satuan'];

                $kd_brg = $row_id['kd_brg'];
                $nm_brg = $row_id['nm_brg'];
                $harga_sat = $row_id['harga_sat'];
                $total_harga = $row_id['total_harga'];
                $keterangan = 'Hapus Refresh OP Msk : '.$row_id['keterangan'];


                $query_hrg_masuk = "update transaksi_masuk  set harga_sat=harga_sat-'$harga_sat', total_harga = total_harga-'$total_harga'  where  id='$id_masuk'";
                $result_hrg_masuk = $this->query($query_hrg_masuk);
                $query_full = "Insert into transaksi_full
                            set 
                            kd_lokasi='$kd_lokasi',
                            kd_lok_msk='',
                            id_opname='$id_opname',
                            id_masuk='$id_masuk',
                            nm_satker='$nm_satker',
                            thn_ang='$thn_ang',
                            no_dok='$no_dok',
                            tgl_dok='$tgl_dok',
                            tgl_buku='$tgl_buku',
                            no_bukti='$no_bukti',
                            jns_trans='H03',
                            kd_sskel='$kd_sskel',
                            nm_sskel='$nm_sskel',
                            kd_brg='$kd_brg',
                            nm_brg='$nm_brg',
                            kd_perk='$kd_perk',
                            nm_perk='$nm_perk',
                            satuan='$satuan',
                            qty='0',
                            
                            harga_sat=-1*'$harga_sat',
                            total_harga=-1*'$total_harga',
                            keterangan='$keterangan',
                            status='0',
                            tgl_update=NOW(),
                            user_id='$user_id'";   
                        $result_full = $this->query($query_full);  



            }
            
            $query_t_full_klr = "select * from transaksi_full where id_opname='$id_opname' and jns_trans='P02' and id_keluar is not null ";
                    $result_t_full_klr = $this->query($query_t_full_klr);
                    while ($row_id = $this->fetch_array($result_t_full_klr))
                        { 
                            $id_keluar = $row_id['id_keluar'];
                            $kd_lokasi=$row_id['kd_lokasi'];
                            $nm_satker = $row_id['nm_satker'];
                            $thn_ang = $row_id['thn_ang'];
                            $no_dok = $row_id['no_dok'];
                            $tgl_dok = $row_id['tgl_dok'];
                            $tgl_buku = $row_id['tgl_buku'];
                            $no_bukti = $row_id['no_bukti'];

                            $kd_sskel = $row_id['kd_sskel'];
                            $nm_sskel = $row_id['nm_sskel'];
                            $kd_perk = $row_id['kd_perk'];
                            $nm_perk = $row_id['nm_perk'];
                            $satuan = $row_id['satuan'];

                            $kd_brg = $row_id['kd_brg'];
                            $nm_brg = $row_id['nm_brg'];
                            $harga_sat = $row_id['harga_sat'];
                            $total_harga = $row_id['total_harga'];
                            $keterangan = 'Hapus Refresh OP Klr : '.$row_id['keterangan'];


                            $query_hrg_keluar = "update transaksi_keluar  set harga_sat=harga_sat-'$harga_sat', total_harga = total_harga-'$total_harga'  where  id='$id_keluar'";
                            $result_hrg_keluar = $this->query($query_hrg_keluar);
                            
                            $query_full = "Insert into transaksi_full
                                        set 
                                        kd_lokasi='$kd_lokasi',
                                        kd_lok_msk='',
                                        id_opname='$id_opname',
                                        id_keluar='$id_keluar',
                                        nm_satker='$nm_satker',
                                        thn_ang='$thn_ang',
                                        no_dok='$no_dok',
                                        tgl_dok='$tgl_dok',
                                        tgl_buku='$tgl_buku',
                                        no_bukti='$no_bukti',
                                        jns_trans='H03',
                                        kd_sskel='$kd_sskel',
                                        nm_sskel='$nm_sskel',
                                        kd_brg='$kd_brg',
                                        nm_brg='$nm_brg',
                                        kd_perk='$kd_perk',
                                        nm_perk='$nm_perk',
                                        satuan='$satuan',
                                        qty='0',
                                        
                                        harga_sat=-1*'$harga_sat',
                                        total_harga=-1*'$total_harga',
                                        keterangan='$keterangan',
                                        status='0',
                                        tgl_update=NOW(),
                                        user_id='$user_id'";   
                                    $result_full = $this->query($query_full);  



                        }

        //mnghapus hasil opname di transaksi masuk
        $query_msk = "select * from transaksi_masuk WHERE id_opname='$id_opname' and jns_trans='P01' ";
        $result_msk = $this->query($query_msk);
        $row_id = $this->fetch_array($result_msk);
        if (mysqli_num_rows($result_msk) != 0)
        {
           
            $kd_lokasi=$row_id['kd_lokasi'];
            $nm_satker = $row_id['nm_satker'];
            $thn_ang = $row_id['thn_ang'];
            $no_dok = $row_id['no_dok'];
            $tgl_dok = $row_id['tgl_dok'];
            $tgl_buku = $row_id['tgl_buku'];
            $no_bukti = $row_id['no_bukti'];

            $kd_sskel = $row_id['kd_sskel'];
            $nm_sskel = $row_id['nm_sskel'];
            $kd_perk = $row_id['kd_perk'];
            $nm_perk = $row_id['nm_perk'];
            $satuan = $row_id['satuan'];

            $kd_brg = $row_id['kd_brg'];
            $nm_brg = $row_id['nm_brg'];
            $keterangan = 'Hapus Opname : '.$row_id['keterangan'];
            $id_trans = $row_id['id'];
            $qty_awal = -1 * $row_id['qty'];
            $harga_sat = $row_id['harga_sat'];
            $total_harga = -1 * $row_id['total_harga'];

            echo "Masuk kesini";
            $query_hps_msk = "delete from transaksi_masuk where id_opname='$id_opname' and jns_trans='P01' ";
            $result_hps_msk = $this->query($query_hps_msk);

            $query_ubah_msk = "update transaksi_masuk set status=0, id_opname=null where  id_opname='$id_opname' and status=1 ";
            $result_ubah = $this->query($query_ubah_msk);

            $query_ubah_klr = "update transaksi_keluar set status=0, id_opname=0 where  id_opname='$id_opname' and status=1 ";
            $result_ubah_klr = $this->query($query_ubah_klr);



            // $query_hps_klr = "delete from transaksi_keluar where id_opname='$id_opname' and jns_trans='P01' ";
            // $result_hps = $this->query($query_hps_klr);

            //Memasukkan Data Ke Transaksi Full

                $query_full = "Insert into transaksi_full
                    set 
                    kd_lokasi='$kd_lokasi',
                    kd_lok_msk='',
                    id_opname='$id_opname',
                    id_masuk='$id_trans',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='P01-H',
                    kd_sskel='$kd_sskel',
                    nm_sskel='$nm_sskel',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    satuan='$satuan',
                    qty='$qty_awal',
                    
                    harga_sat='$harga_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status='0',
                    tgl_update=NOW(),
                    user_id='$user_id'";   
                $result_full = $this->query($query_full);   



        }        
        else
        {
        $query_klr = "select * from transaksi_keluar WHERE id_opname='$id_opname' and jns_trans='P01' ";
        $result_klr = $this->query($query_klr);
        if (mysqli_num_rows($result_klr) != 0)
        {

            while ($row = $this->fetch_array($result_klr))
            { 
                $id_masuk = $row['id_masuk'];
                $qty = abs($row['qty']);

                $kd_lokasi = $row['kd_lokasi'];
                $nm_satker = $row['nm_satker'];
                $thn_ang = $row['thn_ang'];
                $no_dok = $row['no_dok'];
                $tgl_dok = $row['tgl_dok'];
                $tgl_buku = $row['tgl_buku'];
                $no_bukti = $row['no_bukti'];

                $kd_sskel = $row['kd_sskel'];
                $nm_sskel = $row['nm_sskel'];
                $kd_perk = $row['kd_perk'];
                $nm_perk = $row['nm_perk'];
                $satuan = $row['satuan'];

                $kd_brg = $row['kd_brg'];
                $nm_brg = $row['nm_brg'];
                $keterangan = 'Hapus Opname : '.$row['keterangan'];
                $id_trans = $row['id'];
                $harga_sat = $row['harga_sat'];
                $total_harga = abs($row['total_harga']);

                echo 'Id Masuk : '.$id_masuk;
                echo 'qtyk : '.$qty;


                $query_upd_masuk = "update transaksi_masuk  set qty_akhir = qty_akhir + '$qty'  where  id='$id_masuk'";
                $result_upd_masuk = $this->query($query_upd_masuk);

                $query_full = "Insert into transaksi_full
                    set 
                    kd_lokasi='$kd_lokasi',
                    kd_lok_msk='',
                    id_opname='$id_opname',
                    id_masuk='$id_trans',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='P01-H',
                    kd_sskel='$kd_sskel',
                    nm_sskel='$nm_sskel',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    satuan='$satuan',
                    qty='$qty',
                    
                    harga_sat='$harga_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status='0',
                    tgl_update=NOW(),
                    user_id='$user_id'";   
                $result_full = $this->query($query_full);

                //Memasukkan Data Hapus Opname ke Tabel Transaksi Full   
            }
            $query_hps_msk = "delete from transaksi_keluar where id_opname='$id_opname' and jns_trans='P01' ";
            $result_hps_klr = $this->query($query_hps_msk);


            $query_ubah_msk = "update transaksi_masuk set status=0, id_opname=null where  id_opname='$id_opname' and status=1 ";
            $result_msk = $this->query($query_ubah_msk);
            
            $query_ubah_klr = "update transaksi_keluar set status=0, id_opname=0 where  id_opname='$id_opname' and status=1 ";
            $result_klr = $this->query($query_ubah_klr);



        }
     }

        $query_hapus = "delete from opname where id= '$id_opname' ";
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
        $query = "select kd_brg, nm_brg FROM transaksi_full where kd_lokasi like '$kd_lokasi%' and status_hapus=0 and qty>0  and thn_ang = '$thn_ang' and status=0 GROUP BY kd_brg ORDER BY nm_brg ASC ";
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

        $query_perk = "SELECT kd_sskel, nm_sskel, kd_perk, nm_perk, nm_brg, satuan from transaksi_masuk where kd_brg='$kd_brg' and kd_lokasi = '$kd_lokasi' ";
        $result_perk = $this->query($query_perk);
        $data_perk = $this->fetch_array($result_perk);
        $kd_sskel = $data_perk['kd_sskel'];
        $nm_sskel = $data_perk['nm_sskel'];
        $kd_perk = $data_perk['kd_perk'];
        $nm_perk = $data_perk['nm_perk'];
        $nm_brg = $data_perk['nm_brg'];
        $satuan = $data_perk['satuan'];


        $query_hrg = "SELECT  harga_sat
                         from transaksi_masuk
                         where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and kd_brg='$kd_brg' and status_hapus=0 and qty_akhir>0 order by tgl_dok desc limit 1";
        $query_jml = "SELECT  sum(qty_akhir) as qty
                         from transaksi_masuk
                         where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and kd_brg='$kd_brg' and status_hapus=0 and qty_akhir>0 order by tgl_dok desc limit 1";
        $result_hrg = $this->query($query_hrg);
        $result_jml = $this->query($query_jml);
        $data_hrg = $this->fetch_array($result_hrg);
        $data_jml = $this->fetch_array($result_jml);

        $hrg_sat = $data_hrg['harga_sat'];
       
        $total_harga = $kuantitas*$hrg_sat;



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
                    jns_trans='P01',
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
        
        $query_id = "select id from opname WHERE kd_brg='$kd_brg'  and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' order by ID DESC LIMIT 1";
        $result_id = $this->query($query_id);
        $row_id = $this->fetch_array($result_id);
        $id_opname = $row_id['id'];
          
        $jml_brg = $data_jml['qty'];
        $selisih = $kuantitas - $jml_brg;
        $selisih_total_harga = ($selisih*$hrg_sat)+$sisabagi;
        if($selisih>0)
        {
            $query_masuk = "Insert into transaksi_masuk
                    set 
                    kd_lokasi='$kd_lokasi',
                    kd_lok_msk='',
                    id_opname='$id_opname',
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
                    id_opname='$id_opname',
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
                    tgl_update=NOW(),
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
                $harga_sat = $hrg_sat; 
                $total_harga = $selisih*$harga_sat;  

                $kd_sskel = $row_id['kd_sskel'];
                $nm_sskel = $row_id['nm_sskel'];
                $kd_perk = $row_id['kd_perk'];
                $nm_perk = $row_id['nm_perk'];

                echo "ID transaksi masuk : ".$id_trans_m.' '.$qty_akhir.' '.$hrg_sat;
                echo '<br>';

                
                if($selisih<$qty_akhir)
                {
                    echo "terbukti sisa kuantitas : ".$selisih.' dengan qy akhir : '.$qty_akhir;
                    echo '<br>';

                    $query_keluar = "Insert into transaksi_keluar
                                        set kd_lokasi='$kd_lokasi',
                                        id_masuk = '$id_trans_m',
                                        kd_lok_msk='$kd_lok_msk',
                                        id_opname='$id_opname',
                                        nm_satker='$nm_satker',
                                        thn_ang='$thn_ang',
                                        no_dok='$no_dok',
                                        tgl_dok='$tgl_dok',
                                        tgl_buku='$tgl_buku',
                                        no_bukti='$no_bukti',
                                        jns_trans='P01',
                                        kd_sskel='$kd_sskel',
                                        nm_sskel='$nm_sskel',
                                        kd_perk='$kd_perk',
                                        nm_perk='$nm_perk',                                    
                                        kd_brg='$kd_brg',
                                        nm_brg='$nm_brg',
                                        satuan='$satuan',
                                        qty=-1*'$selisih',
                                        harga_sat='$hrg_sat',
                                        total_harga=-1*'$total_harga',
                                        keterangan='$keterangan',
                                        status=0,
                                        tgl_update=CURDATE(),
                                        user_id='$user_id'";   
                    $result_keluar = $this->query($query_keluar);

                    $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $selisih where kd_lokasi='$kd_lokasi' and id='$id_trans_m'";
                    $result_upd_masuk = $this->query($query_upd_masuk);

                    $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and user_id='$user_id' order by id DESC";
                    $result_idk = $this->query($query_idk);
                    $row_idk = $this->fetch_array($result_idk);
                    $id_transk = $row_idk['id'];
                    $minus_qty = -$selisih;
                    $minus_hrg = -$hrg_sat;
                    $minus_total = -$total_harga;
                    echo "id trans keluar : ".$id_transk;
                    echo '<br>';

                    $query_full = "Insert into transaksi_full
                                    set kd_lokasi='$kd_lokasi',
                                    id_keluar='$id_transk',
                                    kd_lok_msk='$kd_lok_msk',
                                    id_opname='$id_opname',
                                    nm_satker='$nm_satker',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='$no_bukti',
                                    jns_trans='P01',
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
                                    tgl_update=NOW(),
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
                    $harga_sat = $hrg_sat; 
                    $total_harga = $qty_akhir * $hrg_sat;
                    echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                    echo '<br>';

                    $query_keluar = "Insert into transaksi_keluar
                                    set 
                                    kd_lokasi='$kd_lokasi',
                                    id_masuk = '$id_trans',
                                    id_opname='$id_opname',
                                    kd_lok_msk='$kd_lok_msk',
                                    nm_satker='$nm_satker',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='$no_bukti',
                                    jns_trans='P01',
                                    kd_sskel='$kd_sskel',
                                    nm_sskel='$nm_sskel',
                                    kd_perk='$kd_perk',
                                    nm_perk='$nm_perk',
                                    kd_brg='$kd_brg',
                                    nm_brg='$nm_brg',
                                    satuan='$satuan',
                                    qty=-1*'$qty_akhir',
                                    harga_sat='$hrg_sat',
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
                    $minus_hrg = -$hrg_sat;
                    $minus_total = -$total_harga;

                    $query_full = "Insert into transaksi_full
                                    set kd_lokasi='$kd_lokasi',
                                    id_trans='$id_transk',
                                    id_keluar='$id_transk',
                                    id_opname='$id_opname',
                                    kd_lok_msk='$kd_lok_msk',
                                    nm_satker='$nm_satker',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='$no_bukti',
                                    jns_trans='P01',
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
                                    tgl_update=NOW(),
                                    user_id='$user_id'"; 
                    $result_full = $this->query($query_full);
                    $selisih = $selisih - $qty_akhir;
                               
            }  


        }
     

        $update_brg = "update transaksi_masuk set  status=1, id_opname='$id_opname' where kd_lokasi='$kd_lokasi' and kd_brg='$kd_brg' and status_hapus=0  and status=0 ";
        $result_upd = $this->query($update_brg);
        $update_brg_klr = "update transaksi_keluar set  status=1, id_opname='$id_opname' where kd_lokasi='$kd_lokasi' and kd_brg='$kd_brg' and status_hapus=0 and status=0 ";
        $result_upd_klr = $this->query($update_brg_klr);

        //Mengubah Harga2 Transaksi Masuk Berdasarkan Harga Pembelian Terakhir
        $query = "SELECT * FROM transaksi_masuk where kd_lokasi='$kd_lokasi' and kd_brg='$kd_brg' and status_hapus=0 and status=1 and id_opname='$id_opname'  ";
        $result = $this->query($query);

        while ($data_msk = $this->fetch_array($result))
        {
            $id = $data_msk['id'];  
            $qty_lama = $data_msk['qty'];
            $hrg_lama = $data_msk['harga_sat'];
            $total_hrg_lama = $data_msk['total_harga'];

            $thn_ang=$data_msk['thn_ang'];
            $no_dok=$data_msk['no_dok'];
            $tgl_dok=$data_msk['tgl_dok'];
            $tgl_buku=$data_msk['tgl_buku'];
            $keterangan = "Refresh : ".$data_msk['keterangan'];

            $total_hrg_baru = $qty_lama * $hrg_sat;
            $selisih_harga = $hrg_sat-$hrg_lama;
            $selisih_subtotal = $total_hrg_baru-$total_hrg_lama;

            $update_harga = "update transaksi_masuk set harga_sat='$hrg_sat', total_harga='$total_hrg_baru' where id='$id' ";
            $resuly_upd_hrg = $this->query($update_harga);

                    $query_full = "Insert into transaksi_full
                    set 
                    kd_lokasi='$kd_lokasi',
                    kd_lok_msk='',
                    id_opname='$id_opname',
                    id_masuk='$id',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='P02',
                    kd_sskel='$kd_sskel',
                    nm_sskel='$nm_sskel',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    satuan='$satuan',
                    qty='0',
                    
                    harga_sat='$selisih_harga',
                    total_harga='$selisih_subtotal',
                    keterangan='$keterangan',
                    status='1',
                    tgl_update=NOW(),
                    user_id='$user_id'";   
            $result_full = $this->query($query_full);


        
        }

        //Mengubah Harga2 Transaksi Keluar Berdasarkan Harga Pembelian Terakhir
        $query = "SELECT * FROM transaksi_keluar where kd_lokasi='$kd_lokasi' and kd_brg='$kd_brg' and status_hapus=0 and status=1 and id_opname='$id_opname'  ";
        $result = $this->query($query);

        while ($data_msk = $this->fetch_array($result))
        {
            $id = $data_msk['id'];  
            $qty_lama = $data_msk['qty'];
            $hrg_lama = $data_msk['harga_sat'];
            $total_hrg_lama = $data_msk['total_harga'];

            $thn_ang=$data_msk['thn_ang'];
            $no_dok=$data_msk['no_dok'];
            $tgl_dok=$data_msk['tgl_dok'];
            $tgl_buku=$data_msk['tgl_buku'];
            $keterangan = "Refresh : ".$data_msk['keterangan'];

            $total_hrg_baru = $qty_lama * $hrg_sat;
            $selisih_harga = $hrg_sat-$hrg_lama;
            $selisih_subtotal = $total_hrg_baru-$total_hrg_lama;

            $update_harga = "update transaksi_keluar set harga_sat='$hrg_sat', total_harga='$total_hrg_baru' where id='$id' ";
            $resuly_upd_hrg = $this->query($update_harga);
                    $query_full = "Insert into transaksi_full
                    set 
                    kd_lokasi='$kd_lokasi',
                    kd_lok_msk='',
                    id_opname='$id_opname',
                    id_keluar='$id',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    jns_trans='P02',
                    kd_sskel='$kd_sskel',
                    nm_sskel='$nm_sskel',
                    kd_brg='$kd_brg',
                    nm_brg='$nm_brg',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    satuan='$satuan',
                    qty='0',
                    
                    harga_sat='$selisih_harga',
                    total_harga='$selisih_subtotal',
                    keterangan='$keterangan',
                    status='1',
                    tgl_update=NOW(),
                    user_id='$user_id'";   
            $result_full = $this->query($query_full);
        
        }





    }   

}
?> 