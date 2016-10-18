<?php
include('../../utility/mysql_db.php');
class modelOpsik extends mysql_db
{

    public function sisa_barang($data)
    {
        $kd_lokasi = $data['kd_lokasi'].$_SESSION['kd_ruang'];
        $kd_brg = $data['kd_brg'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'].$_SESSION['kd_ruang'];

        $query_tgl = "select tgl_dok from opname where concat(no_dok,IFNULL(kd_ruang,''))='$no_dok' limit 1 ";  
        $result_tgl = $this->query($query_tgl);
        $tgl_brg = $this->fetch_array($result_tgl);
        $tgl_dok = $tgl_brg['tgl_dok'];

        //and tgl_dok<='$tgl_dok'

        $query = "select sum(qty_akhir) as sisa,satuan from transaksi_masuk  where kd_brg = '$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_lokasi' and thn_ang='$thn_ang'";  
        $result = $this->query($query);
        $sisa_brg = $this->fetch_array($result);

        $saldo = $sisa_brg["sisa"];

        if(empty($saldo))
        {
            $saldo = 0;
        }
        
        echo json_encode(array("sisa"=>$saldo, "satuan"=>$sisa_brg["satuan"]));
      
        
    }

    public function hapus_opname($data)
    {
        $id_opname = $data['id'];
        $user_id = $data['user_id'];
        $this->query("BEGIN");
        
                        

        //mnghapus hasil opname di transaksi masuk
        $query_msk = "select * from transaksi_masuk WHERE id_opname='$id_opname' and jns_trans='P01' ";
        $result_msk = $this->query($query_msk);
        if (mysqli_num_rows($result_msk) != 0)
        {
            while($row_id = $this->fetch_array($result_msk)){
                $id_brg = $row_id['id'];
                $kd_lokasi=$row_id['kd_lokasi'];
                $kd_ruang=$row_id['kd_ruang'];
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



            // $query_hps_klr = "delete from transaksi_keluar where id_opname='$id_opname' and jns_trans='P01' ";
            // $result_hps = $this->query($query_hps_klr);

            //Memasukkan Data Ke Transaksi Full

                $query_full = "Insert into transaksi_full
                    set 
                    kd_lokasi='$kd_lokasi',
                    kd_ruang='$kd_ruang',
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
                    $this->query($query_full);

                    $result_brg_klr = $this->query("select * from transaksi_keluar where id_masuk='$id_brg'");
                    if (mysqli_num_rows($result_brg_klr) != 0)
                    {
                        while($brg_klr = $this->fetch_array($result_brg_klr)){
                    
                            $qty_klr = abs($brg_klr['qty']);
                            $ket = 'Hapus Opname Selisih Lebih: '.$row['keterangan'];
                            $id_trans = $row['id'];
                            $harga_klr = abs($brg_klr['harga_sat']);
                            $total_harga_klr = abs($brg_klr['total_harga']);

                            $query_full = "Insert into transaksi_full
                                            set 
                                            kd_lokasi='$kd_lokasi',
                                            kd_ruang='$kd_ruang',
                                            kd_lok_msk='',
                                            id_opname='$id_opname',
                                            id_masuk='$id_trans',
                                            nm_satker='$nm_satker',
                                            thn_ang='$thn_ang',
                                            no_dok='$no_dok',
                                            tgl_dok='$tgl_dok',
                                            tgl_buku='$tgl_buku',
                                            no_bukti='$no_bukti',
                                            jns_trans='P01-K',
                                            kd_sskel='$kd_sskel',
                                            nm_sskel='$nm_sskel',
                                            kd_brg='kd_brg',
                                            nm_brg='$nm_brg',
                                            kd_perk='$kd_perk',
                                            nm_perk='$nm_perk',
                                            satuan='$satuan',
                                            qty='$qty_klr',
                                            harga_sat='$harga_klr',
                                            total_harga='$total_harga_klr',
                                            keterangan='$ket',
                                            status='0',
                                            tgl_update=NOW(),
                                            user_id='$user_id'";   
                                        $result_full = $this->query($query_full);

                        }
                        $this->query("delete from transaksi_keluar where id_masuk='$id_brg' ");   
                    }   


            }




            $query_hps_msk = "delete from transaksi_masuk where id_opname='$id_opname' and jns_trans='P01' ";
            $this->query($query_hps_msk);

            $query_ubah_msk = "update transaksi_masuk set status=0, id_opname=null where  id_opname='$id_opname' and status=1 ";
            $this->query($query_ubah_msk);

            $query_ubah_klr = "update transaksi_keluar set status=0, id_opname=0 where  id_opname='$id_opname' and status=1 ";
            $this->query($query_ubah_klr);
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
                    jns_trans='P01-K',
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




        }

     }


        $query_hapus = "delete from opname where id= '$id_opname' ";
        $this->query($query_hapus);
        $query_hps_msk = "delete from transaksi_keluar where id_opname='$id_opname' and jns_trans='P01' ";
        $result_hps_klr = $this->query($query_hps_msk);


        $query_ubah_msk = "update transaksi_masuk set status=0, id_opname=null where  id_opname='$id_opname' and status=1 ";
        $result_msk = $this->query($query_ubah_msk);
            
        $query_ubah_klr = "update transaksi_keluar set status=0, id_opname=0 where  id_opname='$id_opname' and status=1 ";
        $result_klr = $this->query($query_ubah_klr);

        // $query_hapus_full = "update transaksi_full set id_opname=0 where id_opname='id_opname' ";
        // $this->query($query_hapus_full);


        $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='P01-H',
                        aksi='HAPUS - Opname',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        
                        
                        qty='$qty',
                        
                        harga_sat='$harga_sat',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        tgl_update=NOW(),
                        user_id='$user_id'";   
        $this->query($query_log);
        $this->query("COMMIT");

    }


    public function tbh_opname_ident($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_ruang = $data['kd_ruang'];
        $kd_lok_msk = $data['kd_lokasi'];
        $nm_satker = $data['nm_satker'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $keterangan = $data['keterangan'];
        $jns_trans = $data['jns_trans'];
        $status = $data['status'];
        $user_id = $data['user_id'];

         if($no_dok=="" || $kd_lokasi=="") exit;
        // Memasukan Data Transaksi Masuk ke tabel Transaksi Masuk        
        $query = "Insert into opname
                    set kd_lokasi='$kd_lokasi',
                    kd_ruang='$kd_ruang',
                    kd_lok_msk='$kd_lok_msk',
                    nm_satker='$nm_satker',
                    thn_ang='$thn_ang',
                    no_dok='$no_dok',
                    tgl_dok='$tgl_dok',
                    tgl_buku='$tgl_buku',
                    no_bukti='$no_bukti',
                    keterangan='$keterangan',
                    jns_trans='P01',
                    status=0,
                    tgl_update=CURDATE(),
                    user_id='$user_id'"; 

        $result = $this->query($query);
        return $result;
            
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
        $kd_lokasi = $data['kd_lokasi'].$_SESSION['kd_ruang'];
        $thn_ang = $data['thn_ang'];
        $query = "select kd_brg, nm_brg, spesifikasi FROM transaksi_masuk where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_lokasi' and qty>0  and thn_ang = '$thn_ang' and status=0 GROUP BY kd_brg ORDER BY nm_brg ASC ";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Barang --</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_brg'].' '.$row['spesifikasi']."</option>";
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


    public function bacaidentopsik($data)
    {
        $query = "select no_bukti, tgl_dok, tgl_buku, jns_trans, nm_satker, sum(total_harga) as total_harga from opname where no_dok = '$data' and status_hapus=0 group by no_dok";
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
    public function tbh_opname($data)
    {

        $nm_satker = $data['nm_satker'];
        $no_dok = $data['no_dok'].$_SESSION['kd_ruang'];
        $thn_ang = $data['thn_ang'];
        $kd_brg = $data['kd_brg'];
        $kuantitas = $data['kuantitas'];
        $keterangan = $data['keterangan'];
        
        $status = $data['status'];
        $user_id = $data['user_id'];
        $this->query("BEGIN");
        $query_dok = "select kd_lokasi, kd_lok_msk, kd_ruang, tgl_dok, tgl_buku, no_dok, no_bukti, keterangan, jns_trans, keterangan from opname where concat(no_dok,IFNULL(kd_ruang,''))='$no_dok'";
        $result_dok = $this->query($query_dok);
        if($this->num_rows($result_dok)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Menambah  Opname / Seluruh Item Telah Dihapus, buat Dokumen Baru!";
            exit();
        }
        $dok = $this->fetch_array($result_dok);

        $kd_lokasi = $dok['kd_lokasi'];
        $kd_satker = $dok['kd_lokasi'].$dok['kd_ruang'];
        $kd_ruang = $dok['kd_ruang'];
        $kd_lok_msk = $dok['kd_lok_msk'];
        $tgl_dok = $dok['tgl_dok'];
        $tgl_buku = $dok['tgl_buku'];
        $no_dok = $dok['no_dok'];
        $no_bukti = $dok['no_bukti'];
        $jns_trans = $dok['jns_trans'];
        // $keterangan = $dok['keterangan'];
        

        $query_perk = "SELECT kd_sskel, nm_sskel, kd_perk, nm_perk, nm_brg,spesifikasi, satuan from transaksi_masuk where kd_brg='$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' ";
        $result_perk = $this->query($query_perk);
        $data_perk = $this->fetch_array($result_perk);
        $kd_sskel = $data_perk['kd_sskel'];
        $nm_sskel = $data_perk['nm_sskel'];
        $kd_perk = $data_perk['kd_perk'];
        $nm_perk = $data_perk['nm_perk'];
        $nm_brg = $data_perk['nm_brg'];
        $spesifikasi = $data_perk['spesifikasi'];
        $satuan = $data_perk['satuan'];


        $query_hrg = "SELECT  harga_sat
                         from transaksi_masuk
                         where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and kd_brg='$kd_brg' and status_hapus=0 order by tgl_dok desc limit 1";
        $query_jml = "SELECT  sum(qty_akhir) as qty
                         from transaksi_masuk
                         where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and kd_brg='$kd_brg' and status_hapus=0 and qty_akhir>0 order by tgl_dok desc limit 1";
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
                    kd_ruang='$kd_ruang',
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
                    spesifikasi='$spesifikasi',
                    satuan='$satuan',
                    qty='$kuantitas',
                    harga_sat='$hrg_sat',
                    total_harga='$total_harga',
                    keterangan='$keterangan',
                    status=0,
                    tgl_update=CURDATE(),
                    user_id='$user_id'";   
        $result = $this->query($query); 
        $id_opname = $this->insert_id(); 
 
        $query_log = "Insert into log_trans_masuk
                        set 
                        kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        no_bukti='$no_bukti',
                        jns_trans='P01',
                        aksi='TAMBAH-Opname',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        qty='$kuantitas',
                        harga_sat='$hrg_sat',
                        total_harga='$total_harga',
                        keterangan='$keterangan',
                        tgl_update=NOW(),
                        user_id='$user_id'";   
            $result_log = $this->query($query_log);

        // $query_id = "select id from opname WHERE kd_brg='$kd_brg'  and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' order by ID DESC LIMIT 1";
        // $result_id = $this->query($query_id);
        // $row_id = $this->fetch_array($result_id);
        
          
        $jml_brg = $data_jml['qty'];
        $selisih = $kuantitas - $jml_brg;
        $selisih_kondisi = $selisih;
        $selisih_total_harga = ($selisih*$hrg_sat)+$sisabagi;
        if($selisih>0)
        {
            
                $qty_lebih = $selisih;
                $query_id = "select id, id_opname, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, kd_perk, nm_perk, qty, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang'  order by tgl_dok asc,id asc ";     
                $result_id = $this->query($query_id);
                while($row_id = $this->fetch_array($result_id))
                {
                    $id_trans_m = $row_id['id'];   
                    $qty_akhir = $row_id['qty'];      
                    $harga_sat = $row_id['harga_sat'];
                    if($qty_lebih<=$qty_akhir) 
                    {
                        $total_harga = $qty_lebih * $harga_sat;
                        $query_masuk = "Insert into transaksi_masuk
                                            set 
                                            kd_lokasi='$kd_lokasi',
                                            kd_ruang='$kd_ruang',
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
                                            spesifikasi='$spesifikasi',
                                            kd_perk='$kd_perk',
                                            nm_perk='$nm_perk',
                                            satuan='$satuan',
                                            qty='$qty_lebih',
                                            qty_akhir='$qty_lebih',
                                            harga_sat='$harga_sat',
                                            total_harga='$total_harga',
                                            keterangan='$keterangan',
                                            status='1',
                                            tgl_update=CURDATE(),
                                            user_id='$user_id'";   
                            $result_masuk = $this->query($query_masuk);
                                
                            $id_trans = $this->insert_id();
                                
                            $query_full = "Insert into transaksi_full
                                            set 
                                            kd_lokasi='$kd_lokasi',
                                            kd_ruang='$kd_ruang',
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
                                            spesifikasi='$spesifikasi',
                                            kd_perk='$kd_perk',
                                            nm_perk='$nm_perk',
                                            satuan='$satuan',
                                            qty='$qty_lebih',
                                            
                                            harga_sat='$harga_sat',
                                            total_harga='$total_harga',
                                            keterangan='$keterangan',
                                            status='1',
                                            tgl_update=NOW(),
                                            user_id='$user_id'";   
                                    $result_full = $this->query($query_full);
                                    $qty_lebih = 0;
                                    break;
                    }
                        $total_harga = $qty_akhir * $harga_sat;
                        $query_masuk = "Insert into transaksi_masuk
                                            set 
                                            kd_lokasi='$kd_lokasi',
                                            kd_ruang='$kd_ruang',
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
                                            spesifikasi='$spesifikasi',
                                            kd_perk='$kd_perk',
                                            nm_perk='$nm_perk',
                                            satuan='$satuan',
                                            qty='$qty_akhir',
                                            qty_akhir='$qty_akhir',
                                            harga_sat='$harga_sat',
                                            total_harga='$total_harga',
                                            keterangan='$keterangan',
                                            status='1',
                                            tgl_update=CURDATE(),
                                            user_id='$user_id'";   
                            $result_masuk = $this->query($query_masuk);
                                
                            $id_trans = $this->insert_id();
                                
                            $query_full = "Insert into transaksi_full
                                            set 
                                            kd_lokasi='$kd_lokasi',
                                            kd_ruang='$kd_ruang',
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
                                            spesifikasi='$spesifikasi',
                                            kd_perk='$kd_perk',
                                            nm_perk='$nm_perk',
                                            satuan='$satuan',
                                            qty='$qty_akhir',
                                            
                                            harga_sat='$harga_sat',
                                            total_harga='$total_harga',
                                            keterangan='$keterangan',
                                            status='1',
                                            tgl_update=NOW(),
                                            user_id='$user_id'";   
                                    $result_full = $this->query($query_full);
                                    $qty_lebih = $qty_lebih-$qty_akhir;
                                    continue;
                        }
                if($qty_lebih>0){
                    $total_harga = $qty_lebih * $harga_sat;
                        $query_masuk = "Insert into transaksi_masuk
                                            set 
                                            kd_lokasi='$kd_lokasi',
                                            kd_ruang='$kd_ruang',
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
                                            spesifikasi='$spesifikasi',
                                            kd_perk='$kd_perk',
                                            nm_perk='$nm_perk',
                                            satuan='$satuan',
                                            qty='$qty_lebih',
                                            qty_akhir='$qty_lebih',
                                            harga_sat='$harga_sat',
                                            total_harga='$total_harga',
                                            keterangan='$keterangan',
                                            status='1',
                                            tgl_update=CURDATE(),
                                            user_id='$user_id'";   
                            $result_masuk = $this->query($query_masuk);
                                
                            $id_trans = $this->insert_id();
                                
                            $query_full = "Insert into transaksi_full
                                            set 
                                            kd_lokasi='$kd_lokasi',
                                            kd_ruang='$kd_ruang',
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
                                            spesifikasi='$spesifikasi',
                                            kd_perk='$kd_perk',
                                            nm_perk='$nm_perk',
                                            satuan='$satuan',
                                            qty='$qty_lebih',
                                            
                                            harga_sat='$harga_sat',
                                            total_harga='$total_harga',
                                            keterangan='$keterangan',
                                            status='1',
                                            tgl_update=NOW(),
                                            user_id='$user_id'";   
                                    $result_full = $this->query($query_full);


                }
        }
        if($selisih<0) 
        {
            $selisih = -1 * $selisih;        
            while($selisih > 0)
            {   
                echo " kuantitas tersisa : ".$selisih;    
                $query_id = "select id, id_brg_trf,  id_opname, kd_ruang, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, kd_perk, nm_perk, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and qty_akhir>0 and thn_ang='$thn_ang' order by tgl_dok asc,id asc limit 1";     
                $result_id = $this->query($query_id);
                $row_id = $this->fetch_array($result_id);
                $id_trans_m = $row_id['id'];
                $kd_ruang = $row_id['kd_ruang'];
                $id_brg_trf = $row_id['id_brg_trf'];   
                $qty_akhir = $row_id['qty_akhir'];      
                $harga_sat = $row_id['harga_sat'];  
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
                                        set 
                                        kd_lokasi='$kd_lokasi',
                                        id_brg_trf='$id_brg_trf', 
                                        kd_ruang='$kd_ruang',
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
                                        spesifikasi='$spesifikasi',
                                        satuan='$satuan',
                                        qty=-1*'$selisih',
                                        harga_sat='$harga_sat',
                                        total_harga=-1*'$total_harga',
                                        keterangan='$keterangan',
                                        status=0,
                                        tgl_update=CURDATE(),
                                        user_id='$user_id'";   
                    $result_keluar = $this->query($query_keluar);
                    $id_transk = $this->insert_id();

                    $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $selisih where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and id='$id_trans_m'";
                    $result_upd_masuk = $this->query($query_upd_masuk);

                    // $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and user_id='$user_id' order by id DESC";
                    // $result_idk = $this->query($query_idk);
                    // $row_idk = $this->fetch_array($result_idk);
                    
                    $minus_qty = -$selisih;
                    $minus_hrg = -$harga_sat;
                    $minus_total = -$total_harga;
                    echo "id trans keluar : ".$id_transk;
                    echo '<br>';

                    $query_full = "Insert into transaksi_full
                                    set 
                                    kd_lokasi='$kd_lokasi',
                                    id_brg_trf='$id_brg_trf', 
                                    kd_ruang='$kd_ruang',
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
                    $selisih = 0;
                    break;
                }
                    
                    $query_id = "select id, id_brg_trf, id_opname,kd_ruang, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, kd_perk, nm_perk, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and qty_akhir>0 and thn_ang='$thn_ang' order by tgl_dok asc,id asc limit 1";     
                    $result_id = $this->query($query_id);
                    $row_id = $this->fetch_array($result_id);
                    $id_trans = $row_id['id'];
                    $kd_ruang = $row_id['kd_ruang'];
                    $id_brg_trf = $row_id['id_brg_trf'];    
                    $qty_akhir = $row_id['qty_akhir'];      
                    $harga_sat = $row_id['harga_sat'];   
                    $total_harga = $qty_akhir * $harga_sat; 
                    echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                    echo '<br>';

                    $query_keluar = "Insert into transaksi_keluar
                                    set 
                                    kd_lokasi='$kd_lokasi',
                                    id_brg_trf='$id_brg_trf', 
                                    kd_ruang='$kd_ruang',
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
                    $row_idk = $this->insert_id();

                    $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $qty_akhir where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and id='$id_trans'";
                    $result_upd_masuk = $this->query($query_upd_masuk);

                    // $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' order by id DESC";
                    // $result_idk = $this->query($query_idk);
                    
                   
                    $minus_qty = -$qty_akhir;
                    $minus_hrg = -$harga_sat;
                    $minus_total = -$total_harga;

                    $query_full = "Insert into transaksi_full
                                    set 
                                    kd_lokasi='$kd_lokasi',
                                    id_brg_trf='$id_brg_trf', 
                                    kd_ruang='$kd_ruang',
                                    id_trans='$id_transk',
                                    id_keluar='$row_idk',
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
                    $selisih = $selisih - $qty_akhir;
                               
            }  


        }
     

        $update_brg = "update transaksi_masuk set  status=1, id_opname='$id_opname' where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and kd_brg='$kd_brg' and status_hapus=0  and status=0 ";
        $result_upd = $this->query($update_brg);
        $update_brg_klr = "update transaksi_keluar set  status=1, id_opname='$id_opname' where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and kd_brg='$kd_brg' and status_hapus=0 and status=0 ";
        $result_upd_klr = $this->query($update_brg_klr);

  

            $query_hps_dok = "delete from opname where nm_brg is null and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' ";
            $result_hps_dok = $this->query($query_hps_dok); 

            $this->query("COMMIT");
    }   

}
?> 