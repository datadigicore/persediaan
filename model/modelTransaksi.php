<?php
include('../../utility/mysql_db.php');
class modelTransaksi extends mysql_db
{
    public function cek_tahun_aktif($thn_ang){
        $sql = "SELECT status FROM thn_aktif where tahun='$thn_ang'";
        $hasil = $this->query($sql);
        $tahun = $this->fetch_array($hasil);
        echo json_encode(array("tahun"=>$tahun["status"]));

    }

    public function cek_saldo_awal($data){
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];

        $query = "select no_dok, tgl_dok, jns_trans  from transaksi_masuk where kd_lokasi='$kd_lokasi' and thn_ang = '$thn_ang' and jns_trans in ('M01', 'M01I') ";
        $hasil = $this->query($query);
       
        $row_brg = $this->fetch_array($hasil);
        echo json_encode(array("saldo"=>$row_brg["jns_trans"]));
    }

    public function cek_status_opname($data){
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $kd_brg = $data['kd_brg'];
        $tgl_dok = $data['tgl_dok'];

        $query ="select nm_brg,spesifikasi, status from opname where kd_lokasi = '$kd_lokasi' and tgl_dok > '$tgl_dok' and kd_brg = '$kd_brg' and thn_ang = '$thn_ang' order by tgl_dok ASC limit 1";
        $hasil = $this->query($query);
        $row_brg = $this->fetch_array($hasil);
        echo json_encode(array("st_op"=>$row_brg["status"],"nm_brg"=>$row_brg["nm_brg"], "spesifikasi"=>$row_brg["spesifikasi"]));
    }


    public function tutup_tahun($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang_now = $data['thn_ang'];
        $user_id = $data['user_id'];
        $thn_ang_lalu = $thn_ang_now-1;
        $no_dok = "";
        $tgl_dok = "";
        $tgl_buku = "";
        $no_bukti = "";
        $nm_satker = "";
        $this->query("BEGIN");
        $query = "select kd_lokasi, nm_satker, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, jns_trans, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, sum(qty_akhir) as qty_akhir, harga_sat, keterangan, untuk, kd_perk, nm_perk   from transaksi_masuk where kd_lokasi='$kd_lokasi' and qty_akhir>0 and status_ambil=0 and thn_ang = '$thn_ang_lalu' group by kd_brg, harga_sat";
        $hasil = $this->query($query);

        while ($data = $this->fetch_array($hasil))
                {

                    $kd_lokasi = $data['kd_lokasi'];
                    $nm_satker = $data['nm_satker'];
                    $no_dok = $kd_lokasi.".SA".$thn_ang_now;
                    $tgl_dok = $thn_ang_now."-01-01";
                    $tgl_buku = $thn_ang_now."-01-01";
                    $no_bukti = $data['no_bukti'];
                    $jns_trans = $data['jns_trans'];
                    $kd_sskel = $data['kd_sskel'];
                    $nm_sskel = $data['nm_sskel'];
                    $kd_brg = $data['kd_brg'];
                    $nm_brg = $data['nm_brg'];
                    $qty_awal = $data['qty_akhir'];
                    $harga_sat = $data['harga_sat'];
                    $total_harga = $qty_awal*$harga_sat;
                    $satuan = $data['satuan'];
                    $keterangan = $data['keterangan'];
                    $spesifikasi = $data['spesifikasi'];
                    $untuk = $data['untuk'];
                    $kd_perk = $data['kd_perk'];
                    $nm_perk = $data['nm_perk'];

                    $query = "Insert into transaksi_masuk
                            set kd_lokasi='$kd_lokasi',
             
                            nm_satker='$nm_satker',
                            thn_ang='$thn_ang_now',
                            no_dok='$no_dok',
                            tgl_dok='$tgl_dok',
                            tgl_buku='$tgl_buku',
                            no_bukti='$no_bukti',
                            jns_trans='M01I',
                            kd_sskel='$kd_sskel',
                            nm_sskel='$nm_sskel',
                            kd_brg='$kd_brg',
                            nm_brg='$nm_brg',
                            spesifikasi='$spesifikasi',
                            kd_perk='$kd_perk',
                            nm_perk='$nm_perk',
                            satuan='$satuan',
                            qty='$qty_awal',
                            qty_akhir='$qty_awal',
                            harga_sat='$harga_sat',
                            total_harga='$total_harga',
                            keterangan='Saldo Awal',
                            status=0,
                            tgl_update=CURDATE(),
                            user_id='$user_id'";   
                $result = $this->query($query);
                
        // Mendapatkan ID transaksi masuk dan disimpan ke variabel id_trans             
                $query_id = "select id from transaksi_masuk WHERE kd_brg='$kd_brg' and qty='$qty_awal' and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' and user_id='$user_id' order by ID DESC";
                $result_id = $this->query($query_id);
                $row_id = $this->fetch_array($result_id);
                $id_trans = $row_id['id'];

        // Memasukkan Data Transaksi Masuk ke Tabel Transaksi Full
                $query_full = "Insert into transaksi_full
                                set kd_lokasi='$kd_lokasi',
                                id_masuk='$id_trans',
                                kd_lok_msk='$kd_lokasi',
                                nm_satker='$nm_satker',
                                thn_ang='$thn_ang_now',
                                no_dok='$no_dok',
                                tgl_dok='$tgl_dok',
                                tgl_buku='$tgl_buku',
                                no_bukti='$no_bukti',
                                jns_trans='M01I',
                                kd_sskel='$kd_sskel',
                                nm_sskel='$nm_sskel',
                                kd_brg='$kd_brg',
                                nm_brg='$nm_brg',
                                spesifikasi='$spesifikasi',
                                kd_perk='$kd_perk',
                                nm_perk='$nm_perk',
                                satuan='$satuan',
                                qty='$qty_awal',
                                harga_sat='$harga_sat',
                                total_harga='$total_harga',
                                keterangan='Saldo Awal',
                                status=0,
                                tgl_update=NOW(),
                                user_id='$user_id'";
                           
                    $result2 = $this->query($query_full);
                }



                    $query_ttp_msk = "UPDATE transaksi_masuk set status_ambil=1 where thn_ang = '$thn_ang_lalu' and kd_lokasi='$kd_lokasi' ";
                    $query_ttp_klr = "UPDATE transaksi_keluar set status_ambil=1 where thn_ang = '$thn_ang_lalu' and kd_lokasi='$kd_lokasi' ";
                    $query_set_user = "UPDATE user set tutup_tahun='Y' where tahun = '$thn_ang_now' and kd_lokasi='$kd_lokasi' and tutup_tahun is null ";

                    $result_ttp_msk = $this->query($query_ttp_msk);
                    $result_ttp_klr = $this->query($query_ttp_klr);
                    $result_set_user = $this->query($query_set_user);

                    $this->query("UPDATE opname set status_ambil=1 where thn_ang = '$thn_ang_lalu' and kd_lokasi='$kd_lokasi' ");

                $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang_now',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='I',
                        aksi='IMPORT-SALDO AWAL',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        qty=0,
                        harga_sat=0,
                        total_harga=0,
                        keterangan='$keterangan',
                        tgl_update=NOW(),
                        user_id='$user_id'";   
                $this->query($query_log);
                $this->query("COMMIT");


    }
    
    public function transaksi_masuk($data)
    {
        // $kd_lokasi = $data['kd_lokasi'];
        
        $nm_satker = $data['nm_satker'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];

        $query_dok = "select kd_lokasi, tgl_dok, tgl_buku, no_bukti, jns_trans, keterangan from transaksi_masuk where no_dok='$no_dok' ";
        $result_dok = $this->query($query_dok);
        if($this->num_rows($result_dok)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Menambah Barang Setelah Opname / Seluruh Item Telah Dihapus, buat Dokumen Baru!";
            exit();
        }
        $dok = $this->fetch_array($result_dok);

        $kd_lokasi = $dok['kd_lokasi'];
        $kd_lok_msk = $dok['kd_lokasi'];
        $tgl_dok = $dok['tgl_dok'];
        $tgl_buku = $dok['tgl_buku'];
        $no_bukti = $dok['no_bukti'];
        $jns_trans = $dok['jns_trans'];
        $keterangan = $dok['keterangan'];
        

        $kd_brg = $data['kd_brg'];
        
        
        $kuantitas = $data['kuantitas'];
        $harga_sat = $data['harga_sat'];
        $total_harga = $kuantitas*$harga_sat;
        
        
        $status = $data['status'];
        $user_id = $data['user_id'];

        $query_perk = "SELECT nm_sskel, kd_perk, nm_perk, nm_brg, spesifikasi, satuan from persediaan where kd_brg='$kd_brg' ";
        $result_perk = $this->query($query_perk);
        $data_perk = $this->fetch_array($result_perk);
        $kd_sskel = $data['kd_brg'];
        $nm_sskel = $data_perk['nm_sskel'];
        $kd_perk = $data_perk['kd_perk'];
        $nm_perk = $data_perk['nm_perk'];
        $nm_brg = $data_perk['nm_brg'];
        $spesifikasi = $data_perk['spesifikasi'];
        $satuan = $data['satuan'];

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
                    spesifikasi='$spesifikasi',
                    kd_perk='$kd_perk',
                    nm_perk='$nm_perk',
                    satuan='$satuan',
                    qty='$kuantitas',
                    qty_akhir='$kuantitas',
                    harga_sat='$harga_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status=0,
                    tgl_update=CURDATE(),
                    user_id='$user_id'";   
        $result = $this->query($query);
        
// Mendapatkan ID transaksi masuk dan disimpan ke variabel id_trans             
        // $query_id = "select id from transaksi_masuk WHERE kd_brg='$kd_brg' and qty='$kuantitas' and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' and user_id='$user_id' order by ID DESC";
        // $result_id = $this->query($query_id);
        // $row_id = $this->fetch_array($result_id);
        $id_trans = $this->insert_id();

// Memasukkan Data Transaksi Masuk ke Tabel Transaksi Full
        $query_full = "Insert into transaksi_full
                        set kd_lokasi='$kd_lokasi',
                        id_masuk='$id_trans',
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
                        spesifikasi='$spesifikasi',
                        kd_perk='$kd_perk',
                        nm_perk='$nm_perk',
                        satuan='$satuan',
                        qty='$kuantitas',
                        harga_sat='$harga_sat',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        status=0,
                        tgl_update=NOW(),
                        user_id='$user_id'";
                   
            $result2 = $this->query($query_full);
            
            $query_hps = "delete from transaksi_masuk where total_harga is null and kd_lokasi='$kd_lokasi' ";
            $result_hps = $this->query($query_hps); 

            $query_hps_full = "delete from transaksi_full where kd_brg like '' and kd_lokasi='$kd_lokasi' ";
            $result_hps_full = $this->query($query_hps_full);       
            return $result;
            return $result2;

            
            
    }       

    public function transaksi_masuk_ident($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lokasi'];
        $nm_satker = $data['nm_satker'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $jns_trans = $data['jns_trans'];
        // $kd_brg = $data['kd_brg'];
        // $nm_brg = $data['nm_brg'];
        // $satuan = $data['satuan'];
        // $kuantitas = $data['kuantitas'];
        // $harga_sat = $data['harga_sat'];
        // $total_harga = $kuantitas*$harga_sat;
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];

        // $query_perk = "SELECT nm_sskel, kd_perk, nm_perk from persediaan where kd_brg='$kd_brg' and kd_lokasi like '$kd_lokasi%' ";
        
        // $result_perk = $this->query($query_perk);
        // $data_perk = $this->fetch_array($result_perk);
        // $kd_sskel = $data_perk['kd_brg'];
        // $nm_sskel = $data_perk['nm_sskel'];
        // $kd_perk = $data_perk['kd_perk'];
        // $nm_perk = $data_perk['nm_perk'];

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
                    keterangan='$keterangan',
                    status=0,
                    tgl_update=CURDATE(),
                    user_id='$user_id'"; 
        // $query = "Insert into transaksi_masuk
        //             set kd_lokasi='$kd_lokasi',
        //             kd_lok_msk='$kd_lok_msk',
        //             nm_satker='$nm_satker',
        //             thn_ang='$thn_ang',
        //             no_dok='$no_dok',
        //             tgl_dok='$tgl_dok',
        //             tgl_buku='$tgl_buku',
        //             no_bukti='$no_bukti',
        //             jns_trans='$jns_trans',
        //             kd_sskel='$kd_sskel',
        //             nm_sskel='$nm_sskel',
        //             kd_brg='$kd_brg',
        //             nm_brg='$nm_brg',
        //             kd_perk='$kd_perk',
        //             nm_perk='$nm_perk',
        //             satuan='$satuan',
        //             qty='$kuantitas',
        //             qty_akhir='$kuantitas',
        //             harga_sat='$harga_sat',
        //             total_harga='$total_harga',
        //             keterangan='$keterangan',
        //             status=0,
        //             tgl_update=CURDATE(),
        //             user_id='$user_id'";   
        $result = $this->query($query);
        
// Mendapatkan ID transaksi masuk dan disimpan ke variabel id_trans             
        $query_id = "select id from transaksi_masuk WHERE kd_brg='$kd_brg' and qty='$kuantitas' and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' order by ID DESC";
        $result_id = $this->query($query_id);
        $row_id = $this->fetch_array($result_id);
        $id_trans = $row_id['id'];

// Memasukkan Data Transaksi Masuk ke Tabel Transaksi Full
        $query_full = "Insert into transaksi_full
                        set kd_lokasi='$kd_lokasi',
                        id_masuk='$id_trans',
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
                        status=0,
                        tgl_update=NOW(),
                        user_id='$user_id'";
                   
            $result2 = $this->query($query_full);       
            return $result;
            return $result2;
    }    

    public function transaksi_keluar_ident($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lokasi'];
        $nm_satker = $data['nm_satker'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];

        $status = $data['status'];
        $user_id = $data['user_id'];

        // $query_perk = "SELECT nm_sskel, kd_perk, nm_perk from persediaan where kd_brg='$kd_brg' ";
        
        // $result_perk = $this->query($query_perk);
        // $data_perk = $this->fetch_array($result_perk);
        // $kd_sskel = $data_perk['kd_brg'];
        // $nm_sskel = $data_perk['nm_sskel'];
        // $kd_perk = $data_perk['kd_perk'];
        // $nm_perk = $data_perk['nm_perk'];

// Memasukan Data Transaksi Masuk ke tabel Transaksi Keluar       
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
                    keterangan='$keterangan',

                    status=0,
                    tgl_update=CURDATE(),
                    user_id='$user_id'"; 
  
        $result = $this->query($query);
        
      
            return $result;
            
    }


    public function trnsaksi_keluar($data)
    {
        // $kd_lokasi = $data['kd_lokasi'];
        
        $nm_satker = $data['nm_satker'];

        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $this->query("BEGIN");
        $query_dok = "select kd_lokasi, tgl_dok, tgl_buku, no_bukti, jns_trans, keterangan from transaksi_keluar where no_dok='$no_dok'";
        $result_dok = $this->query($query_dok);
        if($this->num_rows($result_dok)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Menambah Barang Setelah Opname / Seluruh Item Telah Dihapus, buat Dokumen Baru!";
            exit();
        }
        $dok = $this->fetch_array($result_dok);

        $kd_lokasi = $dok['kd_lokasi'];
        $kd_lok_msk = $dok['kd_lokasi'];
        $tgl_dok = $dok['tgl_dok'];
        $tgl_buku = $dok['tgl_buku'];
        $no_bukti = $dok['no_bukti'];
        $jns_trans = $dok['jns_trans'];
        $keterangan = $dok['keterangan'];
        
        $kd_brg = $data['kd_brg'];

        
        $satuan = $data['satuan'];
        $kuantitas = $data['kuantitas'];
        $harga_sat = $data['harga_sat'];
        
       
        
        $status = $data['status'];
        $user_id = $data['user_id'];


        while($kuantitas > 0)
        {   
            echo " kuantitas tersisa : ".$kuantitas; 
            $query_id = "select id, id_opname, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, kd_perk, nm_perk, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and qty_akhir>0 and thn_ang='$thn_ang' and status_edit=0 order by tgl_dok asc,id asc limit 1";     
            $result_id = $this->query($query_id);
            $row_id = $this->fetch_array($result_id);
            $id_trans_m = $row_id['id'];   
            $id_opname = $row_id['id_opname'];   
            $qty_akhir = $row_id['qty_akhir'];      
            $harga_sat = $row_id['harga_sat']; 
            $total_harga = $kuantitas*$harga_sat;  

            $kd_sskel = $row_id['kd_sskel'];
            $nm_sskel = $row_id['nm_sskel'];
            $kd_perk = $row_id['kd_perk'];
            $nm_perk = $row_id['nm_perk'];
            $nm_brg = $row_id['nm_brg'];
            $spesifikasi = $row_id['spesifikasi'];
            // $satuan = $row_id['satuan'];

            echo "ID transaksi masuk : ".$id_trans_m.' '.$qty_akhir.' '.$harga_sat;
            echo '<br>';

            
            if($kuantitas<$qty_akhir)
            {
                echo "terbukti sisa kuantitas : ".$kuantitas.' dengan qy akhir : '.$qty_akhir;
                echo '<br>';

                $query_keluar = "Insert into transaksi_keluar
                                    set kd_lokasi='$kd_lokasi',
                                    id_masuk = '$id_trans_m',
                                    id_opname = '$id_opname',
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
                                    spesifikasi='$spesifikasi',
                                    satuan='$satuan',
                                    qty=-1*'$kuantitas',
                                    harga_sat='$harga_sat',
                                    total_harga=-1*'$total_harga',
                                    keterangan='$keterangan',
                                    status=0,
                                    tgl_update=CURDATE(),
                                    user_id='$user_id'";   
                $result_keluar = $this->query($query_keluar);
                $id_transk = $this->insert_id();

                $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        aksi='TAMBAH-Keluar',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        
                        
                        qty=-1*'$kuantitas',
                        
                        harga_sat='$harga_sat',
                        total_harga=-1*'$total_harga',
                        keterangan='$keterangan',
                        tgl_update=NOW(),
                        user_id='$user_id'";   
                $result_log = $this->query($query_log);

                $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $kuantitas where kd_lokasi='$kd_lokasi' and id='$id_trans_m'";
                $result_upd_masuk = $this->query($query_upd_masuk);

                // $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and user_id='$user_id' and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' order by id DESC";
                // $result_idk = $this->query($query_idk);
                // $row_idk = $this->fetch_array($result_idk);
                
                $minus_qty = -$kuantitas;
                $minus_hrg = -$harga_sat;
                $minus_total = -$total_harga;
                echo "id trans keluar : ".$id_transk;
                echo '<br>';

                $query_full = "Insert into transaksi_full
                                set kd_lokasi='$kd_lokasi',
                                id_keluar='$id_transk',
                                id_opname='$id_opname',
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
                                spesifikasi='$spesifikasi',
                                satuan='$satuan',
                                qty='$minus_qty',
                                harga_sat='$minus_hrg',
                                total_harga='$minus_total',
                                keterangan='$keterangan',
                                status=0,
                                tgl_update=NOW(),
                                user_id='$user_id'"; 
                $result_trans_full = $this->query($query_full);
                $kuantitas = 0;
                break;
            }
            // else
            // {
                $query_id = "select id, id_opname, kd_brg, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and qty_akhir>0 and thn_ang='$thn_ang' and status_edit=0 order by tgl_dok asc, id asc limit 1"; 
                $result_id = $this->query($query_id);
                $row_id = $this->fetch_array($result_id);
                $id_trans = $row_id['id'];   
                $qty_akhir = $row_id['qty_akhir'];      
                $id_opname = $row_id['id_opname'];      
                $harga_sat = $row_id['harga_sat']; 
                $total_harga = $qty_akhir * $harga_sat;
                echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                echo '<br>';

                $query_keluar = "Insert into transaksi_keluar
                                set 
                                kd_lokasi='$kd_lokasi',
                                id_masuk = '$id_trans',
                                id_opname = '$id_opname',
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
                                spesifikasi='$spesifikasi',
                                satuan='$satuan',
                                qty=-1*'$qty_akhir',
                                harga_sat='$harga_sat',
                                total_harga=-1*'$total_harga',
                                keterangan='$keterangan',
                                status=0,
                                tgl_update=CURDATE(),
                                user_id='$user_id'"; 
                $result_keluar = $this->query($query_keluar);
                $id_transk = $this->insert_id();
                $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        aksi='TAMBAH-KELUAR',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        qty=-1*'$qty_akhir',
                        harga_sat='$harga_sat',
                        total_harga=-1*'$total_harga',
                        keterangan='$keterangan',
                        tgl_update=NOW(),
                        user_id='$user_id'";   
                $result_log = $this->query($query_log);
                $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $qty_akhir where kd_lokasi='$kd_lokasi' and id='$id_trans'";
                $result_upd_masuk = $this->query($query_upd_masuk);

                // $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and user_id='$user_id' and no_dok='$no_dok' order by id DESC";
                // $result_idk = $this->query($query_idk);
                // $row_idk = $this->fetch_array($result_idk);
               

                $minus_qty = -$qty_akhir;
                $minus_hrg = -$harga_sat;
                $minus_total = -$total_harga;

                $query_full = "Insert into transaksi_full
                                set kd_lokasi='$kd_lokasi',
                                id_trans='$id_transk',
                                id_opname='$id_opname',
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
                                spesifikasi='$spesifikasi',
                                satuan='$satuan',
                                qty='$minus_qty',
                                harga_sat='$minus_hrg',
                                total_harga='$minus_total',
                                keterangan='$keterangan',
                                status=0,
                                tgl_update=NOW(),
                                user_id='$user_id'"; 
                $result_full = $this->query($query_full);
                $kuantitas = $kuantitas - $qty_akhir;
                              
            // }
            

        }               
            $query_hps = "delete from transaksi_keluar where kd_brg like '' and kd_lokasi='$kd_lokasi' ";
            $result_hps = $this->query($query_hps);  

            $query_hps_full = "delete from transaksi_full where kd_brg like '' and kd_lokasi='$kd_lokasi' ";
            $result_hps_full = $this->query($query_hps_full);
            $this->query("COMMIT");   

    }

   
    public function ubah_dok_masuk($data){

        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $tgl_dok= $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_dok = $data['no_dok'];
        $no_bukti = $data['no_bukti'];
        $no_dok_lama = $data['no_dok_lama'];
        $keterangan = $data['keterangan'];
        $user_id = $data['user_id'];

        $query = "SELECT * from transaksi_masuk where no_dok = '$no_dok_lama' and kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang' and status='0' and status_ambil='0' ";
        $result = $this->query($query);
        if($this->num_rows($result)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Mengedit Barang yang telah diopname / telah Import Saldo Awal";
            exit();
        }

        while($dok = $this->fetch_array($result)){
                $kd_lokasi = $dok['kd_lokasi'];
                $nm_satker = $dok['nm_satker'];
                $thn_ang = $dok['thn_ang'];
                $tgl_dok_lama = $dok['tgl_dok'];
                $tgl_buku_lama = $dok['tgl_buku'];
                $jns_trans= $dok['jns_trans'];
                $kd_brg = $dok['kd_brg'];
                $nm_brg = $dok['nm_brg'];
                $keterangan_lama = $dok['keterangan'];
                $koreksi = 'Koreksi ';

                if($no_dok!==$no_dok_lama){
                    $koreksi .= 'no_dok '.$no_dok_lama.', ';
                }
                if($tgl_dok!==$tgl_dok_lama){
                    $koreksi .= 'tgl_dok '.$tgl_dok_lama.', ';
                }
                if($tgl_buku!==$tgl_dok_lama){
                            $koreksi .= 'tgl_buku '.$tgl_dok_lama.', ';
                }
                if($keterangan!==$keterangan_lama){
                            $koreksi .= 'ket. '.$keterangan_lama.', ';
                }

        }

        $query_log = "Insert into log_trans_masuk
                                set 
                                kd_lokasi='$kd_lokasi',
                                nm_satker='$nm_satker',
                                thn_ang='$thn_ang',
                                no_dok='$no_dok',
                                tgl_dok='$tgl_dok',
                                tgl_buku='$tgl_buku',
                                no_bukti='$no_bukti',
                                jns_trans='$jns_trans',
                                aksi='$koreksi',
                                kd_brg='$kd_brg',
                                nm_brg='$nm_brg',
                                
                                
                                qty='0',
                                
                                harga_sat='0',
                                total_harga='0',
                                keterangan='$keterangan',
                                tgl_update=NOW(),
                                user_id='$user_id'";   
        $result_log = $this->query($query_log);


        $query = "UPDATE transaksi_masuk set no_dok = '$no_dok', no_bukti='$no_bukti', tgl_dok='$tgl_dok', tgl_buku = '$tgl_buku', keterangan = '$keterangan' 
                        where no_dok = '$no_dok_lama' and kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang' ";
                        $result = $this->query($query);

    }

    public function ubah_dok_keluar($data){

        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $tgl_dok= $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_dok = $data['no_dok'];
        $no_dok_lama = $data['no_dok_lama'];
        $keterangan = $data['keterangan'];

        $query = "SELECT * from transaksi_keluar where no_dok = '$no_dok_lama' and kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang' and status='0' and status_ambil='0' ";
        $result = $this->query($query);
        if($this->num_rows($result)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Mengubah data yang telah diopname / telah Import Saldo Awal";
            exit();
        }
        while($dok = $this->fetch_array($result)){
                $kd_lokasi = $dok['kd_lokasi'];
                $nm_satker = $dok['nm_satker'];
                $thn_ang = $dok['thn_ang'];
                $tgl_dok_lama = $dok['tgl_dok'];
                $tgl_buku_lama = $dok['tgl_buku'];
                $jns_trans= $dok['jns_trans'];
                $kd_brg = $dok['kd_brg'];
                $nm_brg = $dok['nm_brg'];
                $keterangan_lama = $dok['keterangan'];
                $koreksi = 'Koreksi Dok Keluar';

                if($no_dok!==$no_dok_lama){
                    $koreksi .= 'no_dok '.$no_dok_lama.', ';
                }
                if($tgl_dok!==$tgl_dok_lama){
                    $koreksi .= 'tgl_dok '.$tgl_dok_lama.', ';
                }
                if($tgl_buku!==$tgl_dok_lama){
                            $koreksi .= 'tgl_buku '.$tgl_dok_lama.', ';
                }
                if($keterangan!==$keterangan_lama){
                            $koreksi .= 'ket. '.$keterangan_lama.', ';
                }

        }

        $query_log = "Insert into log_trans_masuk
                                set 
                                kd_lokasi='$kd_lokasi',
                                nm_satker='$nm_satker',
                                thn_ang='$thn_ang',
                                no_dok='$no_dok',
                                tgl_dok='$tgl_dok',
                                tgl_buku='$tgl_buku',
                                no_bukti='$no_bukti',
                                jns_trans='$jns_trans',
                                aksi='$koreksi',
                                kd_brg='$kd_brg',
                                nm_brg='$nm_brg',
                                
                                
                                qty='0',
                                
                                harga_sat='0',
                                total_harga='0',
                                keterangan='$keterangan',
                                tgl_update=NOW(),
                                user_id='$user_id'";   
        $result_log = $this->query($query_log);


        $query = "UPDATE transaksi_keluar set no_dok = '$no_dok', tgl_dok='$tgl_dok', tgl_buku = '$tgl_buku', keterangan = '$keterangan' 
                        where no_dok = '$no_dok_lama' and kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang' ";
                        $result = $this->query($query);

    }

    public function ubah_transaksi_masuk($data)
    {
        $kd_trans = $data['kd_trans']; // id transaksi masuk
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lokasi'];
        
        $thn_ang = $data['thn_ang'];
        $kuantitas = $data['kuantitas'];
        $harga_baru = $data['harga_sat'];
        $this->query("BEGIN");
        $query_qty_awal ="SELECT  id,nm_satker, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_perk, nm_perk,jns_trans, kd_brg, nm_brg, spesifikasi, satuan, qty,qty_akhir, harga_sat, total_harga from transaksi_masuk where id='$kd_trans' and status='0' and status_ambil='0' ";
        $result_qty_awal = $this->query($query_qty_awal);
        if($this->num_rows($result_qty_awal)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Mengedit Barang yang telah diopname / telah Import Saldo Awal";
            exit();
        }
        $row_qty = $this->fetch_array($result_qty_awal);
       
        $no_dok = $row_qty['no_dok'];
        $tgl_dok = $row_qty['tgl_dok'];
        $tgl_buku = $row_qty['tgl_buku'];
        $no_bukti = $row_qty['no_bukti'];

        $id_trans = $row_qty['id'];
        $nm_satker = $row_qty['nm_satker'];
        $kd_sskel = $row_qty['kd_sskel'];
        $nm_sskel = $row_qty['nm_sskel'];
        $kd_perk = $row_qty['kd_perk'];
        $nm_perk = $row_qty['nm_perk'];
        $kd_brg = $row_qty['kd_brg'];
        $nm_brg = $row_qty['nm_brg'];
        $spesifikasi = $row_qty['spesifikasi'];
        $satuan = $row_qty['satuan'];
        $jns_trans = $row_qty['jns_trans'].'-U';


        $qty = $row_qty['qty'];
        $jml_awal = $row_qty['qty']; 
        $harga = $row_qty['harga_sat'];
        
        $selisih_qty = $kuantitas - $qty;

        $harga_sat = $data['harga_sat'];
        $selisih_hrg = $harga_baru - $harga;

        $total_harga_baru = $kuantitas*$harga_baru;
        $total_harga = $row_qty['total_harga'];
        $selisih_tot_hrga = $selisih_qty * $selisih_hrg;
        $selisih_subtotal = $total_harga_baru - $total_harga;
       
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];


        echo 'harga yang lama : '.$harga.'<br>';
        echo 'harga yang baru : '.$harga_baru.'<br>';
        echo 'Kuantias yang Lama : '.$qty.'<br>';
        echo 'Kuantias yang Baru : '.$kuantitas.'<br>';
        echo 'Selisih qty : '.$selisih_qty.'<br>';
        echo 'Selisih qty akhir : '.$row_qty['qty_akhir']+$selisih_qty.'<br>';
        echo 'Selisih subtotal : '.$selisih_tot_hrga.'<br>';
        echo 'Selisih harga : '.$selisih_hrg.'<br>';

        $query_ubah = "update transaksi_masuk 
                        set 
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        qty='$kuantitas', 
                        qty_akhir = qty_akhir + '$selisih_qty',
                        harga_sat='$harga_sat',
                        total_harga='$total_harga_baru', 
                        tgl_update=CURDATE() 
                        where id= '$kd_trans' ";
        $query_full = "Insert into transaksi_full
                        set 
                        id_masuk='$kd_trans',
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
                        kd_perk='$kd_perk',
                        nm_perk='$nm_perk',                                    
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        spesifikasi='$spesifikasi',
                        satuan='$satuan',
                        qty='$selisih_qty',
                        harga_sat='$harga_baru',
                        total_harga='$selisih_subtotal',
                        keterangan='Koreksi Transaksi Masuk',
                        status=0,
                        tgl_update=NOW(),
                        user_id='$user_id'";
            $result = $this->query($query_ubah);       
            $result2 = $this->query($query_full);       


            $query = "select * from transaksi_keluar where id_masuk='$kd_trans'  ";
                    $result = $this->query($query);
                    while ($row_id = $this->fetch_array($result))
                        {
                            $id = $row_id['id']; 
                            $id_masuk = $row_id['id_masuk']; 
                            $id_opname = $row_id['id_opname']; 
                            $kd_lokasi=$row_id['kd_lokasi'];
                            $nm_satker = $row_id['nm_satker'];
                            $thn_ang = $row_id['thn_ang'];
                            $no_dok = $row_id['no_dok'];
                            $tgl_dok = $row_id['tgl_dok'];
                            $tgl_buku = $row_id['tgl_buku'];
                            $no_bukti = $row_id['no_bukti'];
                            $jns_trans = $row_id['jns_trans'].'-U';

                            $kd_sskel = $row_id['kd_sskel'];
                            $nm_sskel = $row_id['nm_sskel'];
                            $kd_perk = $row_id['kd_perk'];
                            $nm_perk = $row_id['nm_perk'];
                            $satuan = $row_id['satuan'];

                            $kd_brg = $row_id['kd_brg'];
                            $nm_brg = $row_id['nm_brg'];
                            $qty = $row_id['qty'];


                            $harga_sat = $row_id['harga_sat'];
                            $total_harga = $row_id['total_harga'];
                            $keterangan = 'Ubah Harga Keluar: '.$row_id['keterangan'];

                            $query = "select harga_sat from transaksi_masuk where id='$id_masuk' ";
                            $data_harga = $this->fetch_array($this->query($query));
                            $harga_baru = $data_harga['harga_sat'];
                            $subtotal_baru = $qty * $harga_baru;
                            $selisih_subtotal = $subtotal_baru - $total_harga;

                            echo ' ID KELUAR : '.$id."<br>";
                            echo ' total_hrg_lama : '.$total_harga."<br>";
                            echo ' total_hrg_baru '.$subtotal_baru."<br>";
                            echo ' SELISIH subtotal '.$selisih_subtotal;

                            $query_hrg_keluar = "update transaksi_keluar  set harga_sat='$harga_baru', total_harga='$subtotal_baru'  where  id='$id'  ";
                            $result_hrg_keluar = $this->query($query_hrg_keluar);
                            
                        
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
                                        jns_trans='$jns_trans',
                                        kd_sskel='$kd_sskel',
                                        nm_sskel='$nm_sskel',
                                        kd_brg='$kd_brg',
                                        nm_brg='$nm_brg',
                                        spesifikasi='$spesifikasi',
                                        kd_perk='$kd_perk',
                                        nm_perk='$nm_perk',
                                        satuan='$satuan',
                                        qty='0',
                                        
                                        harga_sat=-1*'$harga_baru',
                                        total_harga='$selisih_subtotal',
                                        keterangan='$keterangan',
                                        status='0',
                                        tgl_update=NOW(),
                                        user_id='$user_id'";   
                                    $result_full = $this->query($query_full);  



                        }
                                        $koreksi = 'Koreksi ';

                if($qty!==$kuantitas){
                    $koreksi .= 'qty '.$jml_awal.', ';
                }
                if($harga!==$harga_baru){
                    $koreksi .= 'Harga Rp. '.$harga.', ';
                }

                                $query_log = "Insert into log_trans_masuk
                                set 
                                kd_lokasi='$kd_lokasi',
                                nm_satker='$nm_satker',
                                thn_ang='$thn_ang',
                                no_dok='$no_dok',
                                tgl_dok='$tgl_dok',
                                tgl_buku='$tgl_buku',
                                no_bukti='$no_bukti',
                                jns_trans='M0-U',
                                aksi='$koreksi',
                                kd_brg='$kd_brg',
                                nm_brg='$nm_brg',
                                qty='$kuantitas',
                                harga_sat='$harga_baru',
                                total_harga='$subtotal_baru',
                                keterangan='$keterangan',
                                tgl_update=NOW(),
                                user_id='$user_id'";   
                            $this->query($query_log);
                            $this->query("COMMIT");
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
                    status=0,
                    tgl_update=CURDATE(),
                    user_id='$user_id'";
            $result = $this->query($query);       
            return $result;
    }       


    public function hapus_transaksi_masuk($data)
    {
        $id_masuk = $data['id'];
        $thn_ang = $data['thn_ang'];

        $query_id = "select id,  kd_sskel, nm_sskel, kd_perk, nm_perk, kd_brg, satuan,  kd_lokasi, nm_satker, thn_ang, no_dok, jns_trans, tgl_dok, tgl_buku, no_bukti,kd_brg, nm_brg, qty, harga_sat, total_harga  from transaksi_masuk WHERE id='$id_masuk' and status='0' and status_ambil='0' and qty_akhir=qty ";
        $result_id = $this->query($query_id);
        if($this->num_rows($result_id)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Menghapus Barang yang telah diopname / telah Import Saldo Awal";
            exit();
        }
        $row_id = $this->fetch_array($result_id);
        $kd_lokasi=$row_id['kd_lokasi'];
        $nm_satker = $row_id['nm_satker'];
        
        $no_dok = $row_id['no_dok'];
        $tgl_dok = $row_id['tgl_dok'];
        $tgl_buku = $row_id['tgl_buku'];
        $no_bukti = $row_id['no_bukti'];
        $jns_trans = $row_id['jns_trans'].'-H';

        $kd_sskel = $row_id['kd_sskel'];
        $nm_sskel = $row_id['nm_sskel'];
        $kd_perk = $row_id['kd_perk'];
        $nm_perk = $row_id['nm_perk'];
        $satuan = $row_id['satuan'];

        $kd_brg = $row_id['kd_brg'];
        $nm_brg = $row_id['nm_brg'];
        $keterangan = $row_id['keterangan'];
        $id_trans = $row_id['id'];
        $qty_awal = $row_id['qty'];
        $harga_sat = $row_id['harga_sat'];
        $total_harga = $row_id['total_harga'];

        $user_id = $data['user_id'];
        $query_ubah = "delete from transaksi_masuk where id= '$id_masuk' ";

        $query_full = "Insert into transaksi_full
                        set 
                        kd_lokasi='$kd_lokasi',
                        kd_lok_msk='$kd_lok_msk',
                        nm_satker='$nm_satker',
                        id_masuk='$id_trans',
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
                        qty= -1 * '$qty_awal',
                        harga_sat= -1 * '$harga_sat',
                        total_harga= -1 * '$total_harga',
                        keterangan='Hapus Transaksi Masuk',
                        status=0,
                        tgl_update=NOW(),
                        user_id='$user_id'";
            $result2 = $this->query($query_full);  
            $result = $this->query($query_ubah);     
            return $result;
            return $result2;
    }

    public function hapus_transaksi_keluar($data)
    {
        $id = $data['id'];
        $user_id = $data['user_id'];
        $thn_ang = $data['thn_ang'];

        $query_id = "select id, id_masuk, kd_lokasi, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_perk, nm_perk, kd_brg, satuan, kd_brg, nm_brg, qty, harga_sat, total_harga  from transaksi_keluar WHERE id='$id' and status='0' and status_ambil='0' ";
        $result_id = $this->query($query_id);
        if($this->num_rows($result_id)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Menghapus Barang yang telah diopname / telah Import Saldo Awal";
            exit();
        }
        $row_id = $this->fetch_array($result_id);
        $id_trans = $row_id['id'];

        $kd_lokasi=$row_id['kd_lokasi'];
        $nm_satker = $row_id['nm_satker'];

        $kd_sskel = $row_id['kd_sskel'];
        $nm_sskel = $row_id['nm_sskel'];
        $kd_perk = $row_id['kd_perk'];
        $nm_perk = $row_id['nm_perk'];
        $satuan = $row_id['satuan'];

        
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


        $query_upd_masuk = "update transaksi_masuk 
                                set qty_akhir = qty_akhir + '$qty'
                                 where  id='$id_masuk'";
        $result_upd_masuk = $this->query($query_upd_masuk);

        $query_full = "Insert into transaksi_full
                        set
                        id_keluar='$id_trans', 
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
                        kd_sskel='$kd_sskel',
                        nm_sskel='$nm_sskel',
                        kd_perk='$kd_perk',
                        nm_perk='$nm_perk', 
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        satuan='$satuan',
                        qty= '$qty',
                        harga_sat= '$harga_sat',
                        total_harga= '$total_harga',
                        keterangan='Hapus Transaksi Keluar',
                        status=0,
                        tgl_update=CURDATE(),
                        user_id='$user_id'";
                  
            $result2 = $this->query($query_full);    

            $query_ubah_keluar = "delete from transaksi_keluar where id= '$id' ";
            $result = $this->query($query_ubah_keluar); 
   
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
                    status=0,
                    tgl_update=CURDATE(),
                    user_id='$user_id'";
            $result = $this->query($query);       
            return $result;
    }   


  
    public function bacabrg($data)
    {
        $query = "select kd_brg, nm_brg, spesifikasi from persediaan where CONCAT(kd_brg,' ',nm_brg,' ',spesifikasi) like '%$data%'";
        $result = $this->query($query);
        $json = array();
        while ($row = $this->fetch_array($result))
        {
            $dynamic = array(
                'id' => $row['kd_brg'],
                'text' => $row['kd_brg']." ".$row['nm_brg']." ".$row['spesifikasi']
            );
            array_push($json, $dynamic);
        }   
        echo json_encode($json);
    }    

    public function bacanodok($data)
    {
        $nodok = $data['no_dok'];
        $kdlokasi = $data['kd_lokasi'];
        $thnang = $data['thn_ang'];
        $query = "select no_dok from transaksi_masuk where no_dok like '$nodok%' and status_hapus=0 and thn_ang='$thnang' and kd_lokasi like '$kdlokasi%' and jns_trans not like 'P01' group by no_dok";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Nomor Dokumen --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['no_dok'].'">'.$row['no_dok']."</option>";
        }   
    }    

    public function bacasatkerdok($data)
    {
        $nodok = $data['no_dok'];
        $kdlokasi = $data['kd_lokasi'];
        $thnang = $data['thn_ang'];
        $query = "select kode, NamaSatker from satker where kode like '$kdlokasi%'";
        $result = $this->query($query);
        while ($row = $this->fetch_array($result))
        {
            $str = $row['kode'];
            if (substr_count($str,".") == 3) {
                echo '<option value="'.$row['kode'].'">'.$row['kode'].'  -  '.$row['NamaSatker']."</option>";
            }
        }   
    }

    public function bacasatkerdoks($data)
    {
        $nodok = $data['no_dok'];
        $kdlokasi = $data['kd_lokasi'];
        $thnang = $data['thn_ang'];
        $query = "select kode from satker where kode like '$kdlokasi%'";
        $result = $this->query($query);
        while ($row = $this->fetch_array($result))
        {
            $str = $row['kode'];
            if (substr_count($str,".") == 3) {
                echo $row['kode'];
            }
        }   
    }        

    public function bacanodok_klr($data)
    {
        $nodok = $data['no_dok'];
        $kdlokasi = $data['kd_lokasi'];
        $thnang = $data['thn_ang'];
        $query = "select no_dok from transaksi_keluar where no_dok like '$nodok%' and status_hapus=0 and thn_ang='$thnang'  and kd_lokasi like '$kdlokasi%' and jns_trans not like 'P01'  group by no_dok";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Nomor Dokumen --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['no_dok'].'">'.$row['no_dok']."</option>";
        }   
    }
    public function bacaidenttrans($data)
    {
        $query = "select no_bukti, tgl_dok, tgl_buku, jns_trans, nm_satker, sum(total_harga) as total_harga from transaksi_masuk where no_dok = '$data' and status_hapus=0 group by no_dok";
        $result = $this->query($query);
        if ($row = $this->fetch_assoc($result))
        {
            $datedok = date_create($row["tgl_dok"]);
            $datebuku = date_create($row["tgl_buku"]);
            $hslnobukti = $row["no_bukti"];
            $hsljenistrans = $row["jns_trans"];
            $hsltgldok = date_format($datedok,"d-m-Y");
            $hsltglbuku = date_format($datebuku,"d-m-Y");
            $hslsatker = $row["nm_satker"];
            $hsltottrans = $row["total_harga"];
            if($hsltottrans=="")
            {
                $hsltottrans=0;
            }
            echo json_encode(array("nobukti"=>$hslnobukti,"jenistrans"=>$hsljenistrans,"tgldok"=>$hsltgldok,"tglbuku"=>$hsltglbuku,"satker"=>$hslsatker,"total"=>$hsltottrans));
        }   
    }       

    public function bacaidenttrans_klr($data)
    {
        $query = "select no_bukti, tgl_dok, tgl_buku, jns_trans, nm_satker, sum(total_harga) as total_harga from transaksi_keluar where no_dok = '$data' and status_hapus=0 group by no_dok";
        $result = $this->query($query);
        if ($row = $this->fetch_assoc($result))
        {
            $datedok = date_create($row["tgl_dok"]);
            $datebuku = date_create($row["tgl_buku"]);
            $hslnobukti = $row["no_bukti"];
            $hsljenistrans = $row["jns_trans"];
            $hsltgldok = date_format($datedok,"d-m-Y");
            $hsltglbuku = date_format($datebuku,"d-m-Y");
            $hslsatker = $row["nm_satker"];
            $hsltottrans = $row["total_harga"];
            if($hsltottrans=="")
            {
                $hsltottrans=0;
            }
            else
            {
                $hsltottrans = abs($row["total_harga"]);
            }
            echo json_encode(array("nobukti"=>$hslnobukti,"jenistrans"=>$hsljenistrans,"tgldok"=>$hsltgldok,"tglbuku"=>$hsltglbuku,"satker"=>$hslsatker,"total"=>$hsltottrans));
        }   
    }    

    public function baca_persediaan_masuk($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $str = $kd_lokasi;

        $query = "select kd_brg, nm_brg, spesifikasi FROM transaksi_masuk where kd_lokasi = '$kd_lokasi'  and thn_ang = '$thn_ang' and kd_brg!='' GROUP BY kd_brg ORDER BY nm_brg ASC ";

        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Barang --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_brg'].' '.$row['spesifikasi']."</option>";
        }   
    }


    public function baca_detil_trans($data)
    {
        $kd_brg = $data['kd_brg'];
        $kd_lokasi = $data['kd_lokasi'];
        $query_brg = "select * from persediaan where kd_brg = '$kd_brg' ";
        $result_brg = $this->query($query_brg);
        $row_brg = $this->fetch_array($result_brg);
        // echo '<input type="hidden" name="nm_brg" value="'.$row_brg['nm_brg'].'">';
        // echo '<input type="hidden" name="satuan" value="'.$row_brg['satuan'].'">';      
        // echo $row_brg['nm_brg'].'  '.$row_brg['satuan'];
        echo json_encode(array("satuan"=>$row_brg["satuan"]));
    }

    public function harga_terakhir($data)
    {

        $query = "select  nm_brg, harga_sat FROM transaksi_masuk where kd_brg = '$data' and qty_akhir>0 and status_hapus=0 and status_edit=0 GROUP by kd_brg, nm_brg, tgl_buku ASC LIMIT 1";
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
        $thn_ang = $data['thn_ang'];
        $query = "select sum(qty_akhir) as sisa,satuan from transaksi_masuk  where kd_brg = '$kd_brg' and kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang'";  
        $result = $this->query($query);
        $sisa_brg = $this->fetch_array($result);

       $query_brg = "select satuan from persediaan where kd_brg = '$kd_brg' ";
        $result_brg = $this->query($query_brg);
        $row_brg = $this->fetch_array($result_brg);

        echo json_encode(array("sisa"=>$sisa_brg["sisa"], "satuan"=>$row_brg["satuan"]));

        // if(!empty($sisa_brg["sisa"]))
        // {
        //     echo json_encode(array("sisa"=>$sisa_brg["sisa"], "satuan"=>$sisa_brg["satuan"]));
        // }
        // else
        // {
        //     echo json_encode(array("sisa"=>"0", "satuan"=>$sisa_brg["satuan"]));
        // }       
        
    }

   public function cek_brg_keluar($data)
   {

       $kd_lokasi = $data['kd_lokasi'];
       $id_masuk = $data['id_masuk'];
       $query_cek = "SELECT status from transaksi_keluar where id='$id_masuk' and status_hapus=0";
       $result = $this->query($query_cek);
       $cek= $this->fetch_array($result);
       $status = $cek["status"];
   
       echo json_encode(array("st_op"=>$status));
    }   

    public function cek_brg_masuk($data)
    {

       $kd_lokasi = $data['kd_lokasi'];
       $id_masuk = $data['id_masuk'];


       $query_cek = "SELECT tgl_dok,qty,satuan,status from transaksi_keluar where kd_lokasi like '$kd_lokasi%' and id_masuk='$id_masuk' and status_hapus=0";
       $result = $this->query($query_cek);
       $cek= $this->fetch_array($result);
       $jumlah = $cek["qty"];

       $query_cek_opname = "SELECT status from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and id='$id_masuk'";
       $result_cek_opname = $this->query($query_cek_opname);
       $cek_opname= $this->fetch_array($result_cek_opname);
       $status = $cek_opname["status"];
   
       echo json_encode(array("tgl_dok"=>$cek["tgl_dok"], "qty"=>$jumlah,"satuan"=>$cek["satuan"],"st_op"=>$status,"id"=>$id_masuk));
    }
    
    public function loghistory_masuk($datalog)
    {
        $kd_lokasi = $datalog['kd_lokasi'];
        $nm_satker = $datalog['nm_satker'];
        $thn_ang = $datalog['thn_ang'];
        $user_id = $datalog['user_id'];
        $aksi = $datalog['aksi'];
        $no_dok = $datalog['no_dok'];

        $kd_brg = $datalog['kd_brg'];
        $nm_brg = $datalog['nm_brg'];
        $qty = $datalog['kuantitas'];
        $kuantitas = $datalog['kuantitas'];
        $harga_sat = $datalog['harga_sat'];
        $total_harga = $kuantitas*$harga_sat;
       
        $keterangan = $datalog['keterangan'];
        $tanggal = $datalog['tanggal'];

        $query_dok = "select tgl_dok, tgl_buku, no_bukti, jns_trans from transaksi_masuk where no_dok='$no_dok'";
        $result_dok = $this->query($query_dok);
        $dok = $this->fetch_array($result_dok);

        $tgl_dok = $dok['tgl_dok'];
        $tgl_buku = $dok['tgl_buku'];
        $no_bukti = $dok['no_bukti'];
        $jns_trans = $dok['jns_trans'];
        
        $query_perk = "SELECT nm_sskel, kd_perk, nm_perk, nm_brg from persediaan where kd_brg='$kd_brg' ";
        $result_perk = $this->query($query_perk);
        $data_perk = $this->fetch_array($result_perk);
        $kd_sskel = $data_perk['kd_brg'];
        $nm_sskel = $data_perk['nm_sskel'];
        $kd_perk = $data_perk['kd_perk'];
        $nm_perk = $data_perk['nm_perk'];
        $nm_brg = $data_perk['nm_brg'];
       
        $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        aksi='$aksi',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        
                        
                        qty='$kuantitas',
                        
                        harga_sat='$harga_sat',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        tgl_update='$tanggal',
                        user_id='$user_id'";   
        $result_log = $this->query($query_log);

        $query_hps = "delete from log_trans_masuk where kd_brg='' ";
        $result_hps = $this->query($query_hps);
        return $result_hps;
        // print_r($query_log);
        // $var = mysql_insert_id();
        // print_r($var);
        // return $result_log;
    }
    public function loghistory_keluar($datalog)
    {
        $kd_lokasi = $datalog['kd_lokasi'];
        $nm_satker = $datalog['nm_satker'];
        $thn_ang = $datalog['thn_ang'];
        $user_id = $datalog['user_id'];
        $aksi = $datalog['aksi'];
        $no_dok = $datalog['no_dok'];
        $tgl_dok = $datalog['tgl_dok'];
        $tgl_buku = $datalog['tgl_buku'];
        $no_bukti = $datalog['no_bukti'];
        $jns_trans = $datalog['jns_trans'];

        $kd_brg = $datalog['kd_brg'];
        $query_dok = "select nm_brg from persediaan where kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' ";
        $result_dok = $this->query($query_dok);
        $dok = $this->fetch_array($result_dok);

        $nm_brg = $dok['nm_brg'];
        $qty = $datalog['kuantitas'];
        $kuantitas = $datalog['kuantitas'];
        $harga_sat = $datalog['harga_sat'];
        $total_harga = $kuantitas*$harga_sat;
        
        $keterangan = $datalog['keterangan'];
        $tanggal = $datalog['tanggal'];
       
        $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        aksi='$aksi',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        
                        
                        qty='$kuantitas',
                        
                        harga_sat='$harga_sat',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        tgl_update='$tanggal',
                        user_id='$user_id'";   
        $result_log = $this->query($query_log);
        // print_r($query_log);
        // $var = mysql_insert_id();
        // print_r($var);
        // return $result_log;
    }

    public function loghistory_masuk_uh($data)
    {
        $id = $data['id'];
        $query = "select * from transaksi_masuk where id='$id'";
        $result = $this->query($query);
        $detail = $this->fetch_array($result);

        $kd_lokasi = $detail['kd_lokasi'];
        $nm_satker = $detail['nm_satker'];
        $thn_ang = $detail['thn_ang'];
        $no_dok = $detail['no_dok'];
        $tgl_dok = $detail['tgl_dok'];        
        $no_bukti = $detail['no_bukti'];
        $tgl_buku = $detail['tgl_buku'];
        $jns_trans = $detail['jns_trans'];
        $aksi = $data['aksi'];
        $kd_brg = $detail['kd_brg'];
        $nm_brg = $detail['nm_brg'];
        $qty = $detail['qty'];
        $harga_sat = $detail['harga_sat'];
        $total_harga = $detail['total_harga'];
        $keterangan = $detail['keterangan'];
        $tanggal = $data['tanggal'];
        $user_id = $data['user_id'];

                $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        aksi='$aksi',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        
                        
                        qty='$qty',
                        
                        harga_sat='$harga_sat',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        tgl_update='$tanggal',
                        user_id='$user_id'";   
        $result_log = $this->query($query_log);


    }

    public function loghistory_keluar_uh($data)
    {
        $id = $data['id'];
        $query = "select * from transaksi_keluar where id='$id'";
        $result = $this->query($query);
        $detail = $this->fetch_array($result);

        $kd_lokasi = $detail['kd_lokasi'];
        $nm_satker = $detail['nm_satker'];
        $thn_ang = $detail['thn_ang'];
        $no_dok = $detail['no_dok'];
        $tgl_dok = $detail['tgl_dok'];        
        $no_bukti = $detail['no_bukti'];
        $tgl_buku = $detail['tgl_buku'];
        $jns_trans = $detail['jns_trans'];
        $aksi = $data['aksi'];
        $kd_brg = $detail['kd_brg'];
        $nm_brg = $detail['nm_brg'];
        $qty = $detail['qty'];
        $harga_sat = $detail['harga_sat'];
        $total_harga = $detail['total_harga'];
        $keterangan = $detail['keterangan'];
        $tanggal = $data['tanggal'];
        $user_id = $data['user_id'];

                $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='$jns_trans',
                        aksi='$aksi',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        
                        
                        qty='$qty',
                        
                        harga_sat='$harga_sat',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        tgl_update='$tanggal',
                        user_id='$user_id'";   
        $result_log = $this->query($query_log);


    }

    public function konversi_tanggal($tgl)
    {
        $data_tgl = explode("-",$tgl);
        $array = array($data_tgl[2],$data_tgl[1],$data_tgl[0]);
        $tanggal = implode("/", $array );
        return $tanggal;
    }
}
?>