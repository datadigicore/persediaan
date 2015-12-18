<?php
include('../../utility/mysql_db.php');
class modelKonfigurasi extends mysql_db
{

    public function baca_upb_admin($kd_lokasi)
    {
        $query = "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and char_length(kode)=11 order by kode asc";
        $result = $this->query($query);
        $json = array();
        while ($row = $this->fetch_array($result))
        {
            $dynamic = array(
                'id' => $row['kode'],
                'text' => $row['kode']." ".$row['NamaSatker']
            );
            array_push($json, $dynamic);
        }   
        echo json_encode($json);
    }   
    
    public function bacathnaktif($data)
    {
        $query = "SELECT tahun FROM thn_aktif WHERE tahun = '$data' LIMIT 1;";
        $result = $this->query($query);
        $num = mysqli_num_rows($result);
        if($num == 0){
          $valid = "true";
        } else {
          $valid = "false";
        }
        echo $valid;
    }   
    public function bacatahun()
    {
        $query = "select tahun, status from thn_aktif
                        order by tahun asc";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Tahun --</option>';
        while ($row = $this->fetch_array($result))
        {
            if ($row['status'] != "Tidak Aktif") {
                echo '<option value="'.$row['tahun'].'">'.$row['tahun'].'&nbsp;&nbsp;'.$row['status'].'</option>';
            }
            else{
                echo '<option value="'.$row['tahun'].'">'.$row['tahun'].'</option>';
            }
        }   
    }
	public function tambahtahun($data)
	{
		$tahun = $data['thnaktif'];
		$keterangan = $data['keterangan'];
        $query = "Insert into thn_aktif
        			set tahun='$tahun',
                    keterangan='$keterangan'";
        $result = $this->query($query);
		return $result;
	}
    public function tambahtahunaktif($data)
    {
        $tahun = $data['thnaktif'];
        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $query = "UPDATE thn_aktif
                    set status='Tidak Aktif'
                    where status='Aktif';";
        $query.= "INSERT into thn_aktif
                    set tahun='$tahun',
                    keterangan='$keterangan',
                    status='$status';";
        $result = $this->multi_query($query);
        return $result;
    }
    public function aktifkantahun($data)
    {
        $query = "UPDATE thn_aktif
                    set status='Tidak Aktif'
                    where status='Aktif';";
        $query.= "UPDATE thn_aktif
                    set status='Aktif'
                    where id='$data';";
        $result = $this->multi_query($query);
        return $result;
    }
    public function exportkonfig($data)
    {
        $thnawal = $data['thnawal'];
        $thntujuan = $data['thntujuan'];
        $query = "CREATE TEMPORARY TABLE temporary_table SELECT * FROM satker WHERE tahun = '$thnawal';";
        $query.= "UPDATE temporary_table SET tahun = '$thntujuan';";
        $query.= "INSERT INTO satker SELECT null, KodeSektor, KodeSatker, KodeUnit, Gudang, kode, NamaSatker, tahun FROM temporary_table;";
        $query.= "DROP TEMPORARY TABLE IF EXISTS temporary_table;";
        $result = $this->multi_query($query);
        return $result;
    }
    public function exportkonfig_user($data)
    {
        $thnawal = $data['thnawal'];
        $thntujuan = $data['thntujuan'];
        $query = "CREATE TEMPORARY TABLE temporary_table SELECT * FROM user WHERE tahun = '$thnawal';";
        $query1 = "UPDATE temporary_table SET tahun = '$thntujuan';";
        $query2 = "INSERT INTO user SELECT null, user_name, user_pass, user_email, user_level, kd_lokasi, nm_satker, tahun,tutup_tahun FROM temporary_table;";
        $query3 = "DROP TEMPORARY TABLE IF EXISTS temporary_table;";
        $this->query($query);
        $this->query($query1);
        $this->query($query2);
        $this->query($query3);
    } 
    public function hapustahun($data)
    {
        $query = "delete from thn_aktif where id='$data'";
        $result = $this->query($query);
        return $result;
    }

    public function refresh($kd_lokasi, $thn_ang, $user_id)
    {
            $this->query("BEGIN");
            // MEMBUAT TABEL TEMPORER TRANSAKSI KELUAR UNTUK MENYIMPAN HASIL PENGELUARAN BARANG SECARA FIFO
            // $sql = "CREATE TEMPORARY TABLE transaksi_fullTemp SELECT * FROM transaksi_full where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and id_keluar is null and jns_trans not like 'K%'  ";
            $sql = "DELETE FROM transaksi_full where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and id_keluar is not null ";
            $result = $this->query($sql);

            $sql = "DELETE FROM transaksi_full where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and jns_trans in ('P02-K','P01-K') ";
            $result = $this->query($sql);
             
            // MENGEMBALIKKAN NILAI SALDO AWAL SEPERTI SEMUA, DIISI PENUH
            $sql = "UPDATE transaksi_masuk set qty_akhir = qty where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' ";
            $result = $this->query($sql);


            // MEMBUAT TABEL TEMPORER TRANSAKSI FULL
            $sql = "CREATE TEMPORARY TABLE transaksi_keluarTemp SELECT * FROM transaksi_keluar where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' limit 0 ";
            $result = $this->query($sql);
     

            $sql = "SELECT id_opname, kd_lokasi, nm_satker, no_dok, no_bukti, tgl_dok, tgl_buku, jns_trans, kd_brg, nm_brg, sum(qty) as qty, harga_sat,keterangan, status FROM transaksi_keluar where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' group by no_dok, kd_brg order by tgl_dok asc";
            $result = $this->query($sql);

            while($data = $this->fetch_array($result))
            {
                $kd_lokasi =  $data['kd_lokasi'];
                $nm_satker =  $data['nm_satker'];
                $id_opname = $data['id_opname']; 
                $no_dok = $data['no_dok'];
                $no_bukti = $data['no_bukti'];
                $tgl_dok =  $data['tgl_dok'];
                $tgl_buku =  $data['tgl_buku'];
                $kd_brg =   $data['kd_brg'];
                $nm_brg =   $data['nm_brg'];
                $keterangan =   $data['keterangan'];
                $kuantitas=  -1 * $data['qty'];
                $jns_trans = $data['jns_trans'];
                $status = $data['status'];

                echo "realnya: ".$kuantitas;

                while($kuantitas > 0)
                {   
                        echo " kuantitas tersisa : ".$kuantitas; 
                        $query_id = "select id, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, kd_perk, nm_perk, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and qty_akhir>0 and thn_ang='$thn_ang' and status_edit=0 order by tgl_dok asc, id asc limit 1";     
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
                        $nm_brg = $row_id['nm_brg'];
                        $spesifikasi = $row_id['spesifikasi'];
                        $satuan = $row_id['satuan'];

                        echo "ID transaksi masuk : ".$id_trans_m.' '.$qty_akhir.' '.$harga_sat;
                        echo '<br>';

                        $minus_qty = -$kuantitas;
                        if($kuantitas<=$qty_akhir)
                        {
                            
                            echo "terbukti sisa kuantitas : ".$kuantitas.' dengan qy akhir : '.$qty_akhir;
                            echo '<br>';

                            $query_keluar = "Insert into transaksi_keluarTemp
                                                set kd_lokasi='$kd_lokasi',
                                                id_masuk = '$id_trans_m',
                                                id_opname = '$id_opname',
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
                                                harga_sat='$harga_sat',
                                                total_harga=-1*'$total_harga',
                                                keterangan='$keterangan',
                                                status='$status',
                                                tgl_update=CURDATE(),
                                                user_id='$user_id'";   
                            $result_keluar = $this->query($query_keluar);
                            $id_transk = $this->insert_id();
                            
                            
                            $minus_hrg = -$harga_sat;
                            $minus_total = -$total_harga;
                            echo "id trans keluar ucuw: ".$id_transk;
                            echo '<br>';
                          

                            $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $kuantitas where kd_lokasi='$kd_lokasi' and id='$id_trans_m'";
                            $result_upd_masuk = $this->query($query_upd_masuk);

                            $query_full = "Insert into transaksi_full
                                            set kd_lokasi='$kd_lokasi',
                                            id_keluar='$id_transk',
                                            id_opname='$id_opname',
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
                        $minus_qty = -$qty_akhir;
                            $query_id = "select id, kd_brg, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and qty_akhir>0 and thn_ang='$thn_ang' and status_edit=0 order by tgl_dok asc, id asc limit 1"; 
                            $result_id = $this->query($query_id);
                            $row_id = $this->fetch_array($result_id);
                            $id_trans = $row_id['id'];   
                            $qty_akhir = $row_id['qty_akhir'];      
                               
                            $harga_sat = $row_id['harga_sat']; 
                            $total_harga = $qty_akhir * $harga_sat;
                            echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                            echo '<br> masuk kondisi else';

                            $query_keluar = "Insert into transaksi_keluarTemp
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
                                            qty='$minus_qty',
                                            harga_sat='$harga_sat',
                                            total_harga=-1*'$total_harga',
                                            keterangan='$keterangan',
                                            status=0,
                                            tgl_update=CURDATE(),
                                            user_id='$user_id'"; 
                            $result_keluar = $this->query($query_keluar);
                            $id_transk = $this->insert_id($result_k);


                            $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $qty_akhir where kd_lokasi='$kd_lokasi' and id='$id_trans'";
                            $result_upd_masuk = $this->query($query_upd_masuk);

                      
                            
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
                                          
                        }
                
                          

            }

            $query = "DELETE from transaksi_keluar where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' ";
            $result = $this->query($query);

            $query = "INSERT INTO transaksi_keluar(id_masuk, id_opname, kd_lokasi, kd_lok_msk, nm_satker, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel,nm_sskel,kd_brg,nm_brg,spesifikasi,kd_perk,nm_perk,satuan, qty,harga_sat,total_harga,jns_trans,keterangan,untuk,status,status_edit,status_hapus,status_ambil,tgl_update,user_id) select id_masuk, id_opname,   kd_lokasi, kd_lok_msk, nm_satker, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel,nm_sskel,kd_brg,nm_brg,spesifikasi,kd_perk,nm_perk,satuan, qty,harga_sat,total_harga,jns_trans,keterangan,untuk,status,status_edit,status_hapus,status_ambil,tgl_update,user_id from transaksi_keluarTemp ";
            $result = $this->query($query);

            $this->query("UPDATE log_slip set status=0 where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' ");

            $query_log = "Insert into log_trans_masuk
                                    set 
                                    kd_lokasi='$kd_lokasi',
                                    nm_satker='$nm_satker',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='',
                                    jns_trans='R',
                                    aksi='REFRESH',
                                    kd_brg='$kd_brg',
                                    nm_brg='$nm_brg',
                                    qty=0,
                                    harga_sat=0,
                                    total_harga=0,
                                    keterangan='REFRESH TRANSAKSI KELUAR',
                                    tgl_update=NOW(),
                                    user_id='$user_id'";    
            $result_log = $this->query($query_log);
            $this->query("COMMIT");

    }


}
?>
