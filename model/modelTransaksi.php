<?php
include('../../utility/mysql_db.php');
class modelTransaksi extends mysql_db
{

    public function hapus_transfer_barang($data){
        $id             =$data['id'];
        $kd_brg         =$data['kd_brg'];
        $thn_ang        =$data['thn_ang'];
        
        $listItemMasuk  = "SELECT id FROM transaksi_masuk WHERE transfer_id=$id AND kd_brg='$kd_brg' and qty_akhir=qty ";
        $listItemKeluar = "SELECT id FROM transaksi_keluar WHERE transfer_id=$id AND kd_brg='$kd_brg' ";
        // echo "<pre>";
        // print_r($listItemMasuk);
        $res_listItemMasuk = $this->query($listItemMasuk);
        if(empty($res_listItemMasuk->num_rows)){
            echo json_encode("Transfer tidak dapat dihapus : Barang Telah dikeluarkan oleh SKPD / Bagian Penerima");
            exit;
        }
        $this->query("BEGIN");
        foreach ($res_listItemMasuk as $key => $value) {
            $submit = array(
                'id' => $value['id'],
                'user_id' => $data['user_id'],
                'thn_ang' => $data['thn_ang']
            );
            // print_r($submit);
            $this->hapus_transaksi_masuk($submit);
        }
        // print_r($listItemKeluar);
        $res_listItemKeluar = $this->query($listItemKeluar);
        foreach ($res_listItemKeluar as $key => $value) {
            $submit = array(
                'id' => $value['id'],
                'user_id' => $data['user_id'],
                'thn_ang' => $data['thn_ang']
            );
            // print_r($submit);
            $this->hapus_transaksi_keluar($submit);
        }
        $this->query("UPDATE transfer set status=4  WHERE id=$id ");
        $this->query("COMMIT");
        echo json_encode("Transfer Berhasil Dibatalkan");

    }
    public function hapus_dokumen_masuk($no_dok){
        $sql="DELETE from transaksi_masuk  where no_dok='$no_dok' and qty=0 and nilai_kontrak=0";
        $this->query($sql);
    }
    public function clear_log_temp_import($table){
        $clearTable = "DELETE FROM $table WHERE user_id = '$_SESSION[username]'";
        $this->query($clearTable);
    }
    public function check_error_message($jenis){
        if ($jenis == 'keluar') {
            $table = 'temp_import_keluar';
        }
        elseif($jenis=='transfer') {
            $table = 'temp_import_transfer';
        }
        else {
            $table = 'temp_import_masuk';
        }
        $sql="SELECT count(error_message) as data from $table where error_message IS NOT NULL";
        $res=$this->query($sql);
        $data=$this->fetch_assoc($res);
        echo $data['data'];
    }
    public function add_temp_item_trans_masuk(){
        $sql="INSERT INTO transaksi_masuk (keterangan, jns_trans, kd_lokasi, kd_ruang, nm_satker, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk, satuan, qty, qty_akhir, harga_sat, total_harga, kode_rekening, nama_rekening, nilai_kontrak, ket_rek, tgl_update, user_id)
              SELECT keterangan, jns_trans, kd_lokasi, kd_ruang, nm_satker, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk, satuan, qty, qty_akhir, harga_sat, total_harga, kode_rekening, nama_rekening, nilai_kontrak, ket_rek, tgl_update, user_id from temp_import_masuk where user_id = '$_SESSION[username]'";
        $res=$this->query($sql);
        if ($res) {
            $this->create_log_import('I-Transaksi Masuk');
            $this->clear_log_temp_import('temp_import_masuk');
            return true;
        }
    }

    public function add_temp_item_trans_keluar(){
        $sql="SELECT * from temp_import_keluar where user_id = '$_SESSION[username]'";
        $res=$this->query($sql);
        $this->query('BEGIN');
        while ($row=$this->fetch_assoc($res)){
            $row['ruang_asal'] = $row['kd_ruang'];
            $row['status'] = 0;
            $this->import_transaksi_keluar($row);
        }
        $this->clear_log_temp_import('temp_import_keluar');
        $this->query('COMMIT');
        return true;
    }

    public function add_temp_item_trans_transfer(){
        $sql="INSERT INTO transfer (kd_lokasi, kd_ruang, kd_lok_msk, kd_ruang_msk, nm_satker, nm_ruang, nm_satker_msk, nm_ruang_msk, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk, satuan, qty, jns_trans, keterangan,status, tgl_update, user_id)
              SELECT kd_lokasi, kd_ruang, kd_lok_msk, kd_ruang_msk, nm_satker, nm_ruang, nm_satker_msk, nm_ruang_msk, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk, satuan, qty, jns_trans, keterangan, 1 , tgl_update, user_id from temp_import_transfer where user_id = '$_SESSION[username]'";
        $res=$this->query($sql);
        if ($res) {
            $this->create_log_import('I-Transaksi Transfer');
            $this->clear_log_temp_import('temp_import_transfer');
            return true;
        }
    }

    public function create_log_import($data){
        $sql="INSERT INTO log_trans_masuk (kd_lokasi, nm_satker, thn_ang, user_id, aksi, no_dok, tgl_dok, tgl_buku, no_bukti, kd_brg, nm_brg, spesifikasi, qty, harga_sat, total_harga, jns_trans, keterangan, tgl_update)
              SELECT kd_lokasi, nm_satker, thn_ang, user_id, '$data', no_dok, tgl_dok, tgl_buku, no_bukti, kd_brg, nm_brg, spesifikasi, qty, harga_sat, total_harga, jns_trans, keterangan, tgl_update from temp_import_masuk where user_id = '$_SESSION[username]'";
        $res=$this->query($sql);
    }
    public function hapus_dokumen_keluar($no_dok){
        $sql="DELETE from transaksi_keluar  where no_dok='$no_dok' and qty=0 ";
        $this->query($sql);
    }

    public function get_transfer_detail($data){
        $sql="SELECT id, kd_lokasi, kd_ruang, nm_satker, kd_lok_msk, kd_ruang_msk, no_dok, thn_ang, kd_brg, qty, satuan from transfer where id='$data' ";
        $res=$this->query($sql);
        return $this->fetch_array($res);
    }

    public function update_data_rekening($data){
        $id              = $data['id'];
        $nilai_baru      = $data['nilai_baru'];
        $keterangan_baru = $data['keterangan_baru'];

        $sql = "UPDATE transaksi_masuk set
                    nilai_kontrak='$nilai_baru',
                    ket_rek= '$keterangan_baru'
                WHERE id= '$id' ";

        $this->query($sql);

    }

    public function update_data_rekening_barang($data){
        $id              = $data['id'];
        $nilai_baru      = explode("-",$data['kd_rek_brg_baru']);
        $kode_rekening                = $nilai_baru[0];
        $nama_rekening                = $nilai_baru[1];

        $sql = "UPDATE transaksi_masuk set
                    kode_rekening='$kode_rekening',
                    nama_rekening='$nama_rekening'
                WHERE id= '$id' ";
       // print_r($sql);
        return $this->query($sql);

    }
    public function baca_rekening(){
        $sql = "SELECT * from rekening where length(kode_rekening)>6 ";
        $result = $this->query($sql);
         echo '<option></option>';
        while($row=$this->fetch_assoc($result)){

          echo '<option value="'.$row['kode_rekening']."-".$row['nama_rekening'].'">'.$row['kode_rekening'].'  -  '.$row['nama_rekening']."</option>";
        }
    }
    public function cek_tahun_aktif($thn_ang){
        $sql = "SELECT status FROM thn_aktif where tahun='$thn_ang'";
        $hasil = $this->query($sql);
        $tahun = $this->fetch_array($hasil);
        echo json_encode(array("tahun"=>$tahun["status"]));

    }
    public function baca_semua_skpd($kdlokasi){
        $sql = "SELECT kode, NamaSatker FROM `satker` where length(kode)>10 and kode!='$kdlokasi' ";
        $result = $this->query($sql);
        while($row=$this->fetch_assoc($result)){
            echo '<option value="'.$row['kode'].'">'.$row["kode"]." - ".$row['NamaSatker']."</option>";
        }
    }
    public function baca_skpd($kdlokasi){
        $sql = "SELECT kode, NamaSatker FROM satker where kode='$kdlokasi' and kd_ruang is null";
        print_r($sql);
        $result = $this->query($sql);
        while($row=$this->fetch_assoc($result)){
            echo '<option value="'.$row['kode'].'-'.$row['NamaSatker'].'">'.$row["kode"]." - ".$row['NamaSatker']."</option>";
        }
    }

    public function baca_skpd_luar($kdlokasi){
        $sql = "SELECT kode, NamaSatker FROM satker where kode not like '$kdlokasi%' and Gudang is not null and kd_ruang is null order by kode asc";
        print_r($sql);
        $result = $this->query($sql);
        while($row=$this->fetch_assoc($result)){
            echo '<option value="'.$row['kode'].'-'.$row['NamaSatker'].'">'.$row["kode"]." - ".$row['NamaSatker']."</option>";
            // echo '<option value="'.$row['kode'].'">'.$row["kode"]." - ".$row['NamaSatker']."</option>";
        }
    }

    public function baca_bidang($kdlokasi){
        $sql = "SELECT kd_ruang,kode, NamaSatker FROM `satker` where kode='$kdlokasi' ";
        $result = $this->query($sql);
        while($row=$this->fetch_assoc($result)){
            $kode_ruang = $row['kd_ruang'];
            if($kode_ruang="") $kode_ruang="";
           echo '<option value="'.$row['kd_ruang']."-".$row['NamaSatker'].'">'.$row['kd_ruang'].'  -  '.$row['NamaSatker']."</option>";
        }
    }
    public function cekAllTrans($data){
        $query = "select * from transaksi_masuk where kd_lokasi='$data'";
        $hasil = $this->query($query);
        $result = $this->fetch_array($hasil);
        return $result;
    }
    public function importSaldoAwal($data){
        $arrayCount     = count($data);
        $USERNAME       = $_SESSION['username'];
        $KODELOKASI     = $_SESSION['kd_lok'];
        $NAMASATKER     = $_SESSION['nama_satker'];
        $NOMORBUKTI     = trim($data[2]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A");
        $NOMORDOKUMEN   = $KODELOKASI.' - '.$NOMORBUKTI;
        $TANGGALDOKUMEN = date('Y').'-01-01';
        $DATENOW        = date('Y-m-d H:i:s');
        $JENISTRANSAKSI = 'M01';
        $KETERANGAN     = "HASIL OPNAME ";
        $KETERANGAN     .= date('Y')-1;
        $string1 = "INSERT INTO transaksi_full (kd_lokasi, nm_satker, thn_ang, no_dok, no_bukti, tgl_dok, tgl_buku, kd_brg, kd_sskel, nm_sskel, kd_perk, nm_perk, nm_brg, spesifikasi, satuan, qty, harga_sat, total_harga, jns_trans, user_id, status, tgl_update, keterangan) VALUES ";
        $string2 = "INSERT INTO transaksi_masuk (kd_lokasi, nm_satker, thn_ang, no_dok, no_bukti, tgl_dok, tgl_buku, kd_brg, kd_sskel, nm_sskel, kd_perk, nm_perk, nm_brg, spesifikasi, satuan, qty, qty_akhir, harga_sat, total_harga, jns_trans, user_id, status, tgl_update, keterangan) VALUES ";
        for ($i=2; $i < $arrayCount; $i++) {
        if (trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A")!="") {
            $KDLOK = $KODELOKASI;
            $NMSAT = $NAMASATKER;
            $THANG = date('Y');
            $NODOK = $NOMORDOKUMEN;
            $NOBKT = $NOMORBUKTI;
            $TGDOK = $TANGGALDOKUMEN;
            $TGBUK = $DATENOW;
            $KDBAR = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            if ($KDBAR != '') {
                $query  ="select kd_sskel, nm_sskel, kd_perk, nm_perk from persediaan where kd_brg = '$KDBAR'";
                $result = $this->query($query);
                $object = $this->fetch_object($result);
                $KDSSK  = $object->kd_sskel;
                $NMSSK  = $object->nm_sskel;
                $KDPRK  = $object->kd_perk;
                $NMPRK  = $object->nm_perk;
            }
            if($NMPRK=='') continue;
            $NMBAR = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $SPESI = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $JNSAT = trim($data[$i]["E"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $JMBAR = trim($data[$i]["F"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $JMAKH = $JMBAR;
            $HRSAT = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $TOTHR = $JMBAR*$HRSAT;
            $JNTRN = $JENISTRANSAKSI;
            $USRNM = $USERNAME;
            $STATS = 0;
            $TGLUP = $DATENOW;
            $KTRGN = $KETERANGAN;
            $string1 .= "('".$KDLOK."','".$NMSAT."','".$THANG."','".$NODOK."','".$NOBKT."','".$TGDOK."','".$TGBUK."','".$KDBAR."','".$KDSSK."','".$NMSSK."','".$KDPRK."','".$NMPRK."','".$NMBAR."','".$SPESI."','".$JNSAT."','".$JMBAR."','".$HRSAT."','".$TOTHR."','".$JNTRN."','".$USRNM."','".$STATS."','".$TGLUP."','".$KTRGN."'),";
            $string2 .= "('".$KDLOK."','".$NMSAT."','".$THANG."','".$NODOK."','".$NOBKT."','".$TGDOK."','".$TGBUK."','".$KDBAR."','".$KDSSK."','".$NMSSK."','".$KDPRK."','".$NMPRK."','".$NMBAR."','".$SPESI."','".$JNSAT."','".$JMBAR."','".$JMAKH."','".$HRSAT."','".$TOTHR."','".$JNTRN."','".$USRNM."','".$STATS."','".$TGLUP."','".$KTRGN."'),";
          }
        }
        $query1  = substr($string1,0,-1);
        $query2  = substr($string2,0,-1);
        $result  = $this->query($query1);
        $results = $this->query($query2);
        return $results;
    }

    public function importBarang($data){
        error_reporting(0);
        $kodeperk    = "";$namaperk    = "";$kodesubkel  = "";$namasubkel  = "";
        $values      = "";$spesifikasi = "";$satuan      = "";$namabarang  = "";
        $fullname    = "";
        $arrayCount = count($data);
        $replace = "REPLACE INTO persediaan (id, a, b, c, d, e, f, g, kd_perk, nm_perk, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan) VALUES ";
        for ($i=2; $i <= $arrayCount; $i++) {
          if (trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A")!="") {
            $kodebarang  = str_replace("'", "", $data[$i]["B"]);
            $break       = explode('.', str_replace("'", "", $data[$i]["B"]));
            $spesifikasi = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $spesifikasi = str_replace("'", "", $spesifikasi);
            $satuan      = trim($data[$i]["E"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $satuan      = str_replace("'", "", $satuan);
            if (!empty($satuan)) {
                $unikSatuan[] = $satuan;
            }
            for ($j=0; $j < 7 ; $j++) {
                if (!empty($break[$j])) {
                    if (count($break) == 5) {
                        $kodesubkel  = "";
                        $namasubkel  = "";
                        $spesifikasi = "";
                        $satuan      = "";
                        $namabarang  = "";
                        $fullname    = "";
                        $namaperk    = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                        $namaperk    = str_replace("'", "", $namaperk);
                        $kodeperk    = ltrim($break[0], '0').ltrim($break[1], '0').ltrim($break[2], '0').$break[3].$break[4];
                        $unikPerk[$kodeperk]  = $namaperk;
                    }
                    else if (count($break) == 6) {
                        $spesifikasi = "";
                        $satuan      = "";
                        $namabarang  = "";
                        $fullname    = "";
                        $namasubkel = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                        $namasubkel = str_replace("'", "", $namasubkel);
                        $kodesubkel = $break[0].".".$break[1].".".$break[2].".".$break[3].".".$break[4].".".$break[5];
                    }
                    else if (count($break) == 7) {
                        $namabarang = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                        $namabarang = str_replace("'", "", $namabarang);
                        $fullname   = $namabarang." ".$spesifikasi;
                    }
                }
            }
            $values .= "('".$kodebarang."','".$break[0]."','".$break[1]."','".$break[2]."','".$break[3]."','".$break[4]."','".$break[5]."','".$break[6]."','".$kodeperk."','".$namaperk."','".$kodesubkel."','".$namasubkel."','".$kodebarang."','".$fullname."','".$spesifikasi."','".$satuan."'),";
          }
        }
        $insertPerk = "INSERT INTO perk (kd_perk,nm_perk) VALUES ";
        foreach (array_unique($unikPerk) as $key => $value) {
            $valuePerk .= "('".$key."','".$value."'),";
        }
        $queryPerk  = $insertPerk.$valuePerk;
        $queryPerk  = substr($queryPerk,0,-1);
        $this->query($queryPerk);
        $insertSatuan = "INSERT INTO satuan (satuan) VALUES ";
        foreach (array_unique($unikSatuan) as $key => $value) {
            $valueSatuan .= "('".$value."'),";
        }
        $querySatuan  = $insertSatuan.$valueSatuan;
        $querySatuan  = substr($querySatuan,0,-1);
        $this->query($querySatuan);
        $query  = str_replace("''", "NULL", $replace.$values);
        $query  = substr($query,0,-1);
        $result = $this->query($query);
        return $result;
    }

    public function importTransMasuk($data){
        error_reporting(0);
        $this->clear_log_temp_import('temp_import_masuk');
        $error_message = array();
        $value['kd_lokasi'] = $data[1][B];
        $value['kd_ruang'] = $data[2][B];
        $cekkdlokasi        = "SELECT NamaSatker FROM satker WHERE kode = '$value[kd_lokasi]'";
        $result             = $this->query($cekkdlokasi);
        if ($result == true) {
            $assocResult        = $this->fetch_assoc($result);
            $value['nm_satker'] = $assocResult['NamaSatker'];
            $value['user_id']   = $_SESSION['username'];
            $value['thn_ang']   = $_SESSION['thn_ang'];
            $value['no_dok']    = $data[1][B].' - '.$data[3][B];
            $cekNoDok            = "SELECT no_dok FROM transaksi_masuk WHERE no_dok = '$value[no_dok]' AND thn_ang = '$value[thn_ang]' LIMIT 1";
            $resultCekNoDok      = $this->query($cekNoDok);
            if (!empty($resultCekNoDok->num_rows)) {
                array_push($error_message, "Nomor Dokumen Telah Digunakan");
            }
            $tgldok             = split('-', $data[5][B]);
            $value['tgl_dok']   = $tgldok[2].'-'.$tgldok[1].'-'.$tgldok[0];
            $tglbuku            = split('-', $data[6][B]);
            $value['tgl_buku']  = $tglbuku[2].'-'.$tglbuku[1].'-'.$tglbuku[0];
            $value['no_bukti']  = $data[3][B];
            $value['jns_trans'] = $data[4][B];
            if ($value['tgl_dok'] > $value['tgl_buku']) {
                echo "Melebihi";
            }
            $value['keterangan']    = $data[7][B];
            $arrayCount             = count($data);
            for ($i=10; $i <= $arrayCount; $i++) {
                $value['kd_brg'] = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $cekbarang       = "SELECT kd_brg, nm_brg, kd_perk, nm_perk, kd_sskel, nm_sskel, spesifikasi, satuan FROM persediaan WHERE kd_brg = '$value[kd_brg]' LIMIT 1";
                $result          = $this->query($cekbarang);
                if (!empty($result->num_rows)) {
                    $arrayResult = $this->fetch_assoc($result);
                    $value['nm_brg'] = $arrayResult['nm_brg'];
                    $value['kd_perk'] = $arrayResult['kd_perk'];
                    $value['nm_perk'] = $arrayResult['nm_perk'];
                    $value['kd_sskel'] = $arrayResult['kd_sskel'];
                    $value['nm_sskel'] = $arrayResult['nm_sskel'];
                    $value['spesifikasi'] = $arrayResult['spesifikasi'];
                }
                else {
                    if (empty($data[$i]["G"]) && empty($value['kd_brg'])) {
                        array_push($error_message, "Kode Barang Tidak Ada");
                    }
                    $value['nm_brg'] = NULL;
                    $value['kd_perk'] = NULL;
                    $value['nm_perk'] = NULL;
                    $value['kd_sskel'] = NULL;
                    $value['nm_sskel'] = NULL;
                    $value['spesifikasi'] = NULL;
                }
                $value['qty'] = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['qty_akhir'] = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['satuan'] = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $cekSatuan            = "SELECT satuan FROM satuan WHERE satuan = '$value[satuan]' LIMIT 1";
                $resultSatuan         = $this->query($cekSatuan);
                if (!empty($value['kd_brg']) && empty($resultSatuan->num_rows)) {
                    array_push($error_message, "Satuan $value[satuan] Tidak Ada");
                }
                $value['harga_sat'] = trim($data[$i]["E"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['total_harga'] = $value['qty']*$value['harga_sat'];
                if (!empty($data[$i]["F"])) {
                    $value['kode_rekening'] = trim($data[$i]["F"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                    $rekeningCheck          = "SELECT nama_rekening FROM rekening WHERE kode_rekening = '$value[kode_rekening]' AND tahun = '$value[thn_ang]' LIMIT 1";
                    $rekeningQuery          = $this->query($rekeningCheck);
                    $rekeningResult         = $this->fetch_assoc($rekeningQuery);
                    $value['nama_rekening'] = $rekeningResult['nama_rekening'];
                }
                if (!empty($data[$i]["G"])) {
                    $value['nilai_kontrak'] = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                    $value['ket_rek']       = trim($data[$i]["H"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                }
                else {
                    $value['nilai_kontrak'] = 0;
                    $value['ket_rek'] = NULL;
                }
                if (!empty(array_filter($error_message))) {
                    array_push($error_message, "Cek Row Excel No $i");
                }
                $value['error_message'] = implode(', ', $error_message);
                $replace = "INSERT INTO temp_import_masuk (kd_lokasi, kd_ruang, nm_satker, user_id, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, jns_trans, keterangan, kd_brg, nm_brg, kd_perk, nm_perk, kd_sskel, nm_sskel, spesifikasi, qty, qty_akhir, satuan, harga_sat, total_harga, nilai_kontrak, ket_rek, kode_rekening, nama_rekening, error_message, tgl_update) VALUES ";
                $values .= "('".$value['kd_lokasi']."','".$value['kd_ruang']."','".$value['nm_satker']."','".$value['user_id']."','".$value['thn_ang']."','".$value['no_dok']."','".$value['tgl_dok']."','".$value['tgl_buku']."','".$value['no_bukti']."','".$value['jns_trans']."','".$value['keterangan']."','".$value['kd_brg']."','".$value['nm_brg']."','".$value['kd_perk']."','".$value['nm_perk']."','".$value['kd_sskel']."','".$value['nm_sskel']."','".$value['spesifikasi']."','".$value['qty']."','".$value['qty_akhir']."','".$value['satuan']."','".$value['harga_sat']."','".$value['total_harga']."','".$value['nilai_kontrak']."','".$value['ket_rek']."','".$value['kode_rekening']."','".$value['nama_rekening']."','".$value['error_message']."',NOW()),";
                $error_message = array();
            }
            $query  = str_replace("''", "NULL", $replace.$values);
            $query  = substr($query,0,-1);
            $result = $this->query($query);
        }
        else {
            return "Kode Barang Tidak Tersedia";
        }
    }

    public function temporaryImportTransMasuk($data){
        error_reporting(0);
        $this->clear_log_temp_import('temp_import_masuk');
        $value['user_id'] = $_SESSION['username'];
        $value['thn_ang'] = $_SESSION['thn_ang'];
        $arrayCount       = count($data);
        for ($i=10; $i <= $arrayCount; $i++) {
            $error_message = array();
            if (!empty($data[$i]["A"]) && !empty($data[$i]["B"]) && !empty($data[$i]["D"])) {
                $value['jns_trans']  = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['kd_lokasi']  = $data[$i]["B"];
                $cekkdlokasi         = "SELECT NamaSatker FROM satker WHERE kode = '$value[kd_lokasi]'";
                $result              = $this->query($cekkdlokasi);
                if (empty($result->num_rows)) {
                    array_push($error_message, "Kode Lokasi Tidak Ada");
                }
                $assocResult         = $this->fetch_assoc($result);
                $value['nm_satker']  = $assocResult['NamaSatker'];
                if ($value['tgl_dok'] > $value['tgl_buku']) {
                    array_push($error_message, "Tanggal Buku Melebihi Tanggal Dokumen");
                }
                $value['no_dok']     = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A").' - '.trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $cekNoDok            = "SELECT no_dok FROM transaksi_masuk WHERE no_dok = '$value[no_dok]' AND thn_ang = '$value[thn_ang]' LIMIT 1";
                $resultCekNoDok      = $this->query($cekNoDok);
                if (!empty($resultCekNoDok->num_rows)) {
                    array_push($error_message, "Nomor Dokumen Telah Digunakan");
                }
                $value['kd_ruang']   = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['no_bukti']   = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $tgldok              = split('-', $data[$i]["E"]);
                $value['tgl_dok']    = $tgldok[2].'-'.$tgldok[1].'-'.$tgldok[0];
                $tglbuku             = split('-', $data[$i]["F"]);
                $value['tgl_buku']   = $tglbuku[2].'-'.$tglbuku[1].'-'.$tglbuku[0];
            }
            $value['keterangan'] = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $value['kd_brg']     = trim($data[$i]["H"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $cekbarang           = "SELECT kd_brg, nm_brg, kd_perk, nm_perk, kd_sskel, nm_sskel, spesifikasi, satuan FROM persediaan WHERE kd_brg = '$value[kd_brg]' LIMIT 1";
            $result              = $this->query($cekbarang);
            if (!empty($result->num_rows) && !empty($value['kd_brg'])) {
                $arrayResult = $this->fetch_assoc($result);
                $value['nm_brg'] = $arrayResult['nm_brg'];
                $value['kd_perk'] = $arrayResult['kd_perk'];
                $value['nm_perk'] = $arrayResult['nm_perk'];
                $value['kd_sskel'] = $arrayResult['kd_sskel'];
                $value['nm_sskel'] = $arrayResult['nm_sskel'];
                $value['spesifikasi'] = $arrayResult['spesifikasi'];
            }
            else {
                if (empty($data[$i]["N"]) && empty($value['kd_brg'])) {
                    array_push($error_message, "Kode Barang Tidak Ada");
                }
                $value['nm_brg'] = NULL;
                $value['kd_perk'] = NULL;
                $value['nm_perk'] = NULL;
                $value['kd_sskel'] = NULL;
                $value['nm_sskel'] = NULL;
                $value['spesifikasi'] = NULL;
            }
            $value['qty']         = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $value['qty_akhir']   = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $value['satuan']      = trim($data[$i]["K"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $cekSatuan            = "SELECT satuan FROM satuan WHERE satuan = '$value[satuan]' LIMIT 1";
            $resultSatuan         = $this->query($cekSatuan);
            if (!empty($value['kd_brg']) && empty($resultSatuan->num_rows)) {
                array_push($error_message, "Satuan $value[satuan] Tidak Ada");
            }
            $value['harga_sat']   = trim($data[$i]["L"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $value['total_harga'] = $value['qty']*$value['harga_sat'];
            if (!empty($data[$i]["M"])) {
                $value['kode_rekening'] = trim($data[$i]["M"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $rekeningCheck          = "SELECT nama_rekening FROM rekening WHERE kode_rekening = '$value[kode_rekening]' AND tahun = '$value[thn_ang]' LIMIT 1";
                $rekeningQuery          = $this->query($rekeningCheck);
                $rekeningResult         = $this->fetch_assoc($rekeningQuery);
                $value['nama_rekening'] = $rekeningResult['nama_rekening'];
            }
            if (!empty($data[$i]["N"])) {
                $value['nilai_kontrak'] = trim($data[$i]["N"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['ket_rek']       = trim($data[$i]["O"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            }
            else {
                $value['nilai_kontrak'] = 0;
                $value['ket_rek'] = NULL;
            }
            if (!empty(array_filter($error_message))) {
                array_push($error_message, "Cek Row Excel No $i");
            }
            $value['error_message'] = implode(', ', $error_message);
            $replace = "INSERT INTO temp_import_masuk (kd_lokasi, kd_ruang, nm_satker, user_id, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, jns_trans, keterangan, kd_brg, nm_brg, kd_perk, nm_perk, kd_sskel, nm_sskel, spesifikasi, qty, qty_akhir, satuan, harga_sat, total_harga, nilai_kontrak, ket_rek, kode_rekening, nama_rekening, error_message, tgl_update) VALUES ";
            $values .= "('".$value['kd_lokasi']."','".$value['kd_ruang']."','".$value['nm_satker']."','".$value['user_id']."','".$value['thn_ang']."','".$value['no_dok']."','".$value['tgl_dok']."','".$value['tgl_buku']."','".$value['no_bukti']."','".$value['jns_trans']."','".$value['keterangan']."','".$value['kd_brg']."','".$value['nm_brg']."','".$value['kd_perk']."','".$value['nm_perk']."','".$value['kd_sskel']."','".$value['nm_sskel']."','".$value['spesifikasi']."','".$value['qty']."','".$value['qty_akhir']."','".$value['satuan']."','".$value['harga_sat']."','".$value['total_harga']."','".$value['nilai_kontrak']."','".$value['ket_rek']."','".$value['kode_rekening']."','".$value['nama_rekening']."','".$value['error_message']."',NOW()),";
        }
        $query  = str_replace("''", "NULL", $replace.$values);
        $query  = substr($query,0,-1);
        $result = $this->query($query);
    }

    public function importTransTransfer($data){
        error_reporting(0);
        $this->clear_log_temp_import('temp_import_transfer');
        $error_message = array();
        $value['kd_lokasi'] = $data[1][B];
        $value['kd_ruang'] = $data[2][B];
        $value['kd_lok_msk']   = $data[1][D];
        $value['kd_ruang_msk'] = $data[2][D];
        $cekkdlokasi        = "SELECT NamaSatker FROM satker WHERE kode = '$value[kd_lokasi]'";
        $result             = $this->query($cekkdlokasi);
        if ($result == true) {

            $cekkdruang             = "SELECT NamaSatker FROM satker WHERE kode = '$value[kd_lokasi]' and kd_ruang='$value[kd_ruang]' ";
            $cekkdsatkermsk          = "SELECT NamaSatker FROM satker WHERE kode = '$value[kd_lok_msk]' and (kd_ruang IS NULL or kd_ruang='') ";
            $cekkdruangmsk          = "SELECT NamaSatker FROM satker WHERE kode = '$value[kd_lok_msk]' and kd_ruang='$value[kd_ruang_msk]' ";
            $resultkdruang          = $this->query($cekkdruang);
            $resultkdsatkermsk       = $this->query($cekkdsatkermsk);
            $resultkdruangmsk       = $this->query($cekkdruangmsk);

            $assocResult            = $this->fetch_assoc($result);
            $assocRuangResult       = $this->fetch_assoc($resultkdruang);

            $assocMskResult         = $this->fetch_assoc($resultkdsatkermsk);
            $assocRuangMskResult    = $this->fetch_assoc($resultkdruangmsk);
            $value['nm_satker']     = $assocResult['NamaSatker'];
            $value['nm_ruang']      = $assocRuangResult['NamaSatker'];
            $value['nm_satker_msk'] = $assocMskResult['NamaSatker'];
            $value['nm_ruang_msk']  = $assocRuangMskResult['NamaSatker'];
            $value['user_id']       = $_SESSION['username'];
            $value['thn_ang']       = $_SESSION['thn_ang'];
            $value['no_dok']        = $data[1][B].' - '.$data[3][B];

            $cekNoDok            = "SELECT no_dok FROM transfer WHERE no_dok = '$value[no_dok]' AND thn_ang = '$value[thn_ang]' LIMIT 1";
            $resultCekNoDok      = $this->query($cekNoDok);
            if (!empty($resultCekNoDok->num_rows)) {
                array_push($error_message, "Nomor Dokumen Telah Digunakan");
            }
            $tgldok             = split('-', $data[5][B]);
            $value['tgl_dok']   = $tgldok[2].'-'.$tgldok[1].'-'.$tgldok[0];
            $tglbuku            = split('-', $data[6][B]);
            $value['tgl_buku']  = $tglbuku[2].'-'.$tglbuku[1].'-'.$tglbuku[0];
            $value['no_bukti']  = $data[3][B];
            $value['jns_trans'] = $data[4][B];
            if ($value['tgl_dok'] > $value['tgl_buku']) {
                echo "Melebihi";
            }
            $value['keterangan']    = $data[7][B];
            $arrayCount             = count($data);
            for ($i=10; $i <= $arrayCount; $i++) {
                $value['kd_brg'] = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $cekbarang       = "SELECT kd_brg, nm_brg, kd_perk, nm_perk, kd_sskel, nm_sskel, spesifikasi, satuan FROM persediaan WHERE kd_brg = '$value[kd_brg]' LIMIT 1";
                $result          = $this->query($cekbarang);
                if (!empty($result->num_rows)) {
                    $arrayResult = $this->fetch_assoc($result);
                    $value['nm_brg'] = $arrayResult['nm_brg'];
                    $value['kd_perk'] = $arrayResult['kd_perk'];
                    $value['nm_perk'] = $arrayResult['nm_perk'];
                    $value['kd_sskel'] = $arrayResult['kd_sskel'];
                    $value['nm_sskel'] = $arrayResult['nm_sskel'];
                    $value['spesifikasi'] = $arrayResult['spesifikasi'];
                }
                else {
                    if (empty($data[$i]["G"]) && empty($value['kd_brg'])) {
                        array_push($error_message, "Kode Barang Tidak Ada");
                    }
                    $value['nm_brg'] = NULL;
                    $value['kd_perk'] = NULL;
                    $value['nm_perk'] = NULL;
                    $value['kd_sskel'] = NULL;
                    $value['nm_sskel'] = NULL;
                    $value['spesifikasi'] = NULL;
                }
                $value['qty'] = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['qty_akhir'] = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['satuan'] = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $cekSatuan            = "SELECT satuan FROM satuan WHERE satuan = '$value[satuan]' LIMIT 1";
                $resultSatuan         = $this->query($cekSatuan);
                if (!empty($value['kd_brg']) && empty($resultSatuan->num_rows)) {
                    array_push($error_message, "Satuan $value[satuan] Tidak Ada");
                }
                if (!empty(array_filter($error_message))) {
                    array_push($error_message, "Cek Row Excel No $i");
                }
                $value['error_message'] = implode(', ', $error_message);
                $replace = "INSERT INTO temp_import_transfer (keterangan, jns_trans, kd_lokasi, kd_ruang, kd_lok_msk, kd_ruang_msk, nm_satker, nm_ruang, nm_satker_msk, nm_ruang_msk, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk, satuan, qty, tgl_update, user_id, error_message) VALUES ";
                $values .= "('".$value['keterangan']."','".$value['jns_trans']."','".$value['kd_lokasi']."','".$value['kd_ruang']."','".$value['kd_lok_msk']."','".$value['kd_ruang_msk']."','".$value['nm_satker']."','".$value['nm_ruang']."','".$value['nm_satker_msk']."','".$value['nm_ruang_msk']."','".$value['thn_ang']."','".$value['no_dok']."','".$value['tgl_dok']."','".$value['tgl_buku']."','".$value['no_bukti']."','".$value['kd_sskel']."','".$value['nm_sskel']."','".$value['kd_brg']."','".$value['nm_brg']."','".$value['spesifikasi']."','".$value['kd_perk']."','".$value['nm_perk']."','".$value['satuan']."','".$value['qty']."',NOW(),'".$value['user_id']."','".$value['error_message']."'),";
                $error_message = array();
            }
            $query  = str_replace("''", "NULL", $replace.$values);
            $query  = substr($query,0,-1);
            $result = $this->query($query);
        }
        else {
            return "Kode Barang Tidak Tersedia";
        }
    }
    public function importTransKeluar($data){
        error_reporting(0);
        $this->clear_log_temp_import('temp_import_keluar');
        $error_message = array();
        $value['kd_lokasi'] = $data[1][B];
        $value['kd_ruang'] = $data[2][B];
        $cekkdlokasi        = "SELECT NamaSatker FROM satker WHERE kode = '$value[kd_lokasi]'";
        $result             = $this->query($cekkdlokasi);
        if ($result == true) {
            $assocResult        = $this->fetch_assoc($result);
            $value['nm_satker'] = $assocResult['NamaSatker'];
            $value['user_id']   = $_SESSION['username'];
            $value['thn_ang']   = $_SESSION['thn_ang'];
            $value['no_dok']    = $data[1][B].' - '.$data[3][B];
            $cekNoDok            = "SELECT no_dok FROM transaksi_keluar WHERE no_dok = '$value[no_dok]' AND thn_ang = '$value[thn_ang]' LIMIT 1";
            $resultCekNoDok      = $this->query($cekNoDok);
            if (!empty($resultCekNoDok->num_rows)) {
                array_push($error_message, "Nomor Dokumen Telah Digunakan");
            }
            $tgldok             = split('-', $data[5][B]);
            $value['tgl_dok']   = $tgldok[2].'-'.$tgldok[1].'-'.$tgldok[0];
            $tglbuku            = split('-', $data[6][B]);
            $value['tgl_buku']  = $tglbuku[2].'-'.$tglbuku[1].'-'.$tglbuku[0];
            $value['no_bukti']  = $data[3][B];
            $value['jns_trans'] = $data[4][B];
            if ($value['tgl_dok'] > $value['tgl_buku']) {
                echo "Melebihi";
            }
            $value['keterangan']    = $data[7][B];
            $arrayCount             = count($data);
            for ($i=10; $i <= $arrayCount; $i++) {
                $value['kd_brg'] = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $cekbarang       = "SELECT kd_brg, nm_brg, kd_perk, nm_perk, kd_sskel, nm_sskel, spesifikasi, satuan FROM persediaan WHERE kd_brg = '$value[kd_brg]' LIMIT 1";
                $result          = $this->query($cekbarang);
                if (!empty($result->num_rows)) {
                    $arrayResult = $this->fetch_assoc($result);
                    $value['nm_brg'] = $arrayResult['nm_brg'];
                    $value['kd_perk'] = $arrayResult['kd_perk'];
                    $value['nm_perk'] = $arrayResult['nm_perk'];
                    $value['kd_sskel'] = $arrayResult['kd_sskel'];
                    $value['nm_sskel'] = $arrayResult['nm_sskel'];
                    $value['spesifikasi'] = $arrayResult['spesifikasi'];
                }
                else {
                    if (empty($data[$i]["G"]) && empty($value['kd_brg'])) {
                        array_push($error_message, "Kode Barang Tidak Ada");
                    }
                    $value['nm_brg'] = NULL;
                    $value['kd_perk'] = NULL;
                    $value['nm_perk'] = NULL;
                    $value['kd_sskel'] = NULL;
                    $value['nm_sskel'] = NULL;
                    $value['spesifikasi'] = NULL;
                }
                $value['qty'] = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['qty_akhir'] = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['satuan'] = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $cekSatuan            = "SELECT satuan FROM satuan WHERE satuan = '$value[satuan]' LIMIT 1";
                $resultSatuan         = $this->query($cekSatuan);
                if (!empty($value['kd_brg']) && empty($resultSatuan->num_rows)) {
                    array_push($error_message, "Satuan $value[satuan] Tidak Ada");
                }
                if (!empty(array_filter($error_message))) {
                    array_push($error_message, "Cek Row Excel No $i");
                }
                $value['error_message'] = implode(', ', $error_message);
                $replace = "INSERT INTO temp_import_keluar (keterangan, jns_trans, kd_lokasi, kd_ruang, nm_satker, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk, satuan, qty, tgl_update, user_id, error_message) VALUES ";
                $values .= "('".$value['keterangan']."','".$value['jns_trans']."','".$value['kd_lokasi']."','".$value['kd_ruang']."','".$value['nm_satker']."','".$value['thn_ang']."','".$value['no_dok']."','".$value['tgl_dok']."','".$value['tgl_buku']."','".$value['no_bukti']."','".$value['kd_sskel']."','".$value['nm_sskel']."','".$value['kd_brg']."','".$value['nm_brg']."','".$value['spesifikasi']."','".$value['kd_perk']."','".$value['nm_perk']."','".$value['satuan']."','".$value['qty']."',NOW(),'".$value['user_id']."','".$value['error_message']."'),";
                $error_message = array();
            }
            $query  = str_replace("''", "NULL", $replace.$values);
            $query  = substr($query,0,-1);
            $result = $this->query($query);
        }
        else {
            return "Kode Barang Tidak Tersedia";
        }
    }

    public function temporaryImportTransKeluar($data){
        error_reporting(0);
        $this->clear_log_temp_import('temp_import_keluar');
        $value['user_id'] = $_SESSION['username'];
        $value['thn_ang'] = $_SESSION['thn_ang'];
        $arrayCount       = count($data);
        for ($i=10; $i <= $arrayCount; $i++) {
            $error_message = array();
            if (!empty($data[$i]["A"]) && !empty($data[$i]["B"]) && !empty($data[$i]["D"])) {
                $value['jns_trans']  = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['kd_lokasi']  = $data[$i]["B"];
                $cekkdlokasi         = "SELECT NamaSatker FROM satker WHERE kode = '$value[kd_lokasi]'";
                $result              = $this->query($cekkdlokasi);
                if (empty($result->num_rows)) {
                    array_push($error_message, "Kode Lokasi Tidak Ada");
                }
                $assocResult         = $this->fetch_assoc($result);
                $value['nm_satker']  = $assocResult['NamaSatker'];
                if ($value['tgl_dok'] > $value['tgl_buku']) {
                    array_push($error_message, "Tanggal Buku Melebihi Tanggal Dokumen");
                }
                $value['no_dok']     = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A").' - '.trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $cekNoDok            = "SELECT no_dok FROM transaksi_masuk WHERE no_dok = '$value[no_dok]' AND thn_ang = '$value[thn_ang]' LIMIT 1";
                $resultCekNoDok      = $this->query($cekNoDok);
                if (!empty($resultCekNoDok->num_rows)) {
                    array_push($error_message, "Nomor Dokumen Telah Digunakan");
                }
                $value['kd_ruang']   = trim($data[$i]["C"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['no_bukti']   = trim($data[$i]["D"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $tgldok              = split('-', $data[$i]["E"]);
                $value['tgl_dok']    = $tgldok[2].'-'.$tgldok[1].'-'.$tgldok[0];
                $tglbuku             = split('-', $data[$i]["F"]);
                $value['tgl_buku']   = $tglbuku[2].'-'.$tglbuku[1].'-'.$tglbuku[0];
            }
            $value['keterangan'] = trim($data[$i]["G"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $value['kd_brg']     = trim($data[$i]["H"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $cekbarang           = "SELECT kd_brg, nm_brg, kd_perk, nm_perk, kd_sskel, nm_sskel, spesifikasi, satuan FROM persediaan WHERE kd_brg = '$value[kd_brg]' LIMIT 1";
            $result              = $this->query($cekbarang);
            if (!empty($result->num_rows) && !empty($value['kd_brg'])) {
                $arrayResult = $this->fetch_assoc($result);
                $value['nm_brg'] = $arrayResult['nm_brg'];
                $value['kd_perk'] = $arrayResult['kd_perk'];
                $value['nm_perk'] = $arrayResult['nm_perk'];
                $value['kd_sskel'] = $arrayResult['kd_sskel'];
                $value['nm_sskel'] = $arrayResult['nm_sskel'];
                $value['spesifikasi'] = $arrayResult['spesifikasi'];
            }
            else {
                if (empty($data[$i]["N"]) && empty($value['kd_brg'])) {
                    array_push($error_message, "Kode Barang Tidak Ada");
                }
                $value['nm_brg'] = NULL;
                $value['kd_perk'] = NULL;
                $value['nm_perk'] = NULL;
                $value['kd_sskel'] = NULL;
                $value['nm_sskel'] = NULL;
                $value['spesifikasi'] = NULL;
            }
            $value['qty']         = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $value['qty_akhir']   = trim($data[$i]["J"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $value['satuan']      = trim($data[$i]["K"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $cekSatuan            = "SELECT satuan FROM satuan WHERE satuan = '$value[satuan]' LIMIT 1";
            $resultSatuan         = $this->query($cekSatuan);
            if (!empty($value['kd_brg']) && empty($resultSatuan->num_rows)) {
                array_push($error_message, "Satuan $value[satuan] Tidak Ada");
            }
            $value['harga_sat']   = trim($data[$i]["L"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $value['total_harga'] = $value['qty']*$value['harga_sat'];
            if (!empty($data[$i]["M"])) {
                $value['kode_rekening'] = trim($data[$i]["M"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $rekeningCheck          = "SELECT nama_rekening FROM rekening WHERE kode_rekening = '$value[kode_rekening]' AND tahun = '$value[thn_ang]' LIMIT 1";
                $rekeningQuery          = $this->query($rekeningCheck);
                $rekeningResult         = $this->fetch_assoc($rekeningQuery);
                $value['nama_rekening'] = $rekeningResult['nama_rekening'];
            }
            if (!empty($data[$i]["N"])) {
                $value['nilai_kontrak'] = trim($data[$i]["N"]," \t\n\r\0\x0B\xA0\x0D\x0A");
                $value['ket_rek']       = trim($data[$i]["O"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            }
            else {
                $value['nilai_kontrak'] = 0;
                $value['ket_rek'] = NULL;
            }
            if (!empty(array_filter($error_message))) {
                array_push($error_message, "Cek Row Excel No $i");
            }
            $value['error_message'] = implode(', ', $error_message);
            $replace = "INSERT INTO temp_import_masuk (kd_lokasi, kd_ruang, nm_satker, user_id, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, jns_trans, keterangan, kd_brg, nm_brg, kd_perk, nm_perk, kd_sskel, nm_sskel, spesifikasi, qty, qty_akhir, satuan, harga_sat, total_harga, nilai_kontrak, ket_rek, kode_rekening, nama_rekening, error_message, tgl_update) VALUES ";
            $values .= "('".$value['kd_lokasi']."','".$value['kd_ruang']."','".$value['nm_satker']."','".$value['user_id']."','".$value['thn_ang']."','".$value['no_dok']."','".$value['tgl_dok']."','".$value['tgl_buku']."','".$value['no_bukti']."','".$value['jns_trans']."','".$value['keterangan']."','".$value['kd_brg']."','".$value['nm_brg']."','".$value['kd_perk']."','".$value['nm_perk']."','".$value['kd_sskel']."','".$value['nm_sskel']."','".$value['spesifikasi']."','".$value['qty']."','".$value['qty_akhir']."','".$value['satuan']."','".$value['harga_sat']."','".$value['total_harga']."','".$value['nilai_kontrak']."','".$value['ket_rek']."','".$value['kode_rekening']."','".$value['nama_rekening']."','".$value['error_message']."',NOW()),";
        }
        $query  = str_replace("''", "NULL", $replace.$values);
        $query  = substr($query,0,-1);
        $result = $this->query($query);
    }


    public function importRekening($data){
        $values     = "";
        $arrayCount = count($data);
        $tahun      = date("Y");
        $replace    = "REPLACE INTO rekening (kode_rekening, nama_rekening, tahun) VALUES ";
        for ($i=2; $i <= $arrayCount; $i++) {
          if (is_numeric(trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A")) && trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A")!="") {
            $koderek  = trim($data[$i]["A"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $namarek  = trim($data[$i]["B"]," \t\n\r\0\x0B\xA0\x0D\x0A");
            $namarek  = str_replace("'", "", $namarek);
            if (substr($koderek, 0, 3) == "522" || substr($koderek, 0, 3) == "523") {
                $values .= "('".$koderek."','".$namarek."','".$tahun."'),";
            }
          }
        }
        $query  = substr($replace.$values,0,-1);
        $result = $this->query($query);
        return $result;
    }

    public function cek_saldo_awal($data){
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $kd_satker = $kd_lokasi.$data['kd_ruang'];

        $query = "select no_dok, tgl_dok, jns_trans  from transaksi_masuk where concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$kd_satker' and thn_ang = '$thn_ang' and jns_trans in ('M01', 'M01I') ";
        // print_r($query);
        $hasil = $this->query($query);

        $row_brg = $this->fetch_array($hasil);
        echo json_encode(array("saldo"=>$row_brg["jns_trans"]));
    }

    public function cek_status_opname($data){
        $kd_lokasi = $data['kd_lokasi'];
        $kd_ruang = $data['kd_ruang'];
        $thn_ang = $data['thn_ang'];
        $kd_brg = $data['kd_brg'];
        $tgl_dok = $data['tgl_dok'];
        $kd_satker=$kd_lokasi.$kd_ruang;

        $query ="select nm_brg,spesifikasi, status from opname where concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$kd_satker' and tgl_dok > '$tgl_dok' and kd_brg = '$kd_brg' and thn_ang = '$thn_ang' order by tgl_dok ASC limit 1";
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
        $query = "select kd_lokasi, nm_satker, thn_ang, no_dok, tgl_dok, tgl_buku, no_bukti, jns_trans, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, sum(qty_akhir) as qty_akhir, harga_sat, keterangan, untuk, kd_perk, nm_perk   from transaksi_masuk where kd_lokasi='$kd_lokasi' and qty_akhir>0 and status_ambil=0 and thn_ang = '$thn_ang_lalu' and status=1 group by kd_brg, harga_sat";
        $result_read = $this->query($query);
        if($this->num_rows($result_read)==0)
        {
            $this->query("ROLLBACK");
            echo "Lakukan Opname Dahulu sebelum Import Saldo Awal";
            exit();
        }
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
        $nm_ruang = $_SESSION['nm_ruang'];
        $ket_brg = $data['ket_brg'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $kode_rek =$data['kode_rek'];
        $nama_rek =$data['nama_rek'];
        $nilai_kontrak =$data['nilai_kontrak'];
        // $nilai_kontrak =0;
        $ket_non_persediaan =$data['ket_non_persediaan'];


        $query_dok = "select kd_lokasi,kd_ruang, tgl_dok, tgl_buku, no_bukti, jns_trans, keterangan,nilai_kontrak from transaksi_masuk where no_dok='$no_dok' and status_ambil=0 ";
        $result_dok = $this->query($query_dok);
        if($this->num_rows($result_dok)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Menambah Barang Setelah Opname / Seluruh Item Telah Dihapus, buat Dokumen Baru!";
            exit();
        }
        $dok = $this->fetch_array($result_dok);

        $kd_satker = $dok['kd_lokasi'].$dok['kd_ruang'];

        $kd_lokasi = $dok['kd_lokasi'];
        $kd_ruang = $dok['kd_ruang'];
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

        $query_op ="select * from transaksi_masuk where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and kd_brg='$kd_brg' and tgl_dok>'$tgl_dok' and status=1 order by tgl_dok asc limit 1";
        $hasil_op = $this->query($query_op);
        if($this->num_rows($hasil_op)==1)
        {
            exit();
        }


        $cek_slip = "select tgl_dok from transaksi_keluar where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and kd_brg='$kd_brg' and tgl_dok>='$tgl_dok' order by tgl_dok asc limit 1";
        $result_slip = $this->query($cek_slip);
        $data_slip = $this->fetch_array($result_slip);
        if($this->num_rows($result_slip)==1)
        {
            $tgl_slip = $data_slip['tgl_dok'];
            $insert_slip = "INSERT INTO log_slip
                 set    kd_lokasi='$kd_lokasi',
                        kd_ruang='$kd_ruang',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        user_id='$user_id',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        spesifikasi='$spesifikasi',
                        satuan='$satuan',
                        qty='$kuantitas',
                        harga_sat='$harga_sat',
                        tgl_slip='$tgl_slip',
                        status=1,
                        tgl_update=NOW()
                        ";
                $this->query($insert_slip);
                echo "TERDAPAT TERSELIP";



        }

// Memasukan Data Transaksi Masuk ke tabel Transaksi Masuk
        $query = "Insert into transaksi_masuk
                    set kd_lokasi='$kd_lokasi',
                    kd_ruang='$kd_ruang',
                    nm_satker='$nm_satker',
                    nm_ruang='$nm_ruang',
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
                    untuk='$ket_brg',
                    kode_rekening='$kode_rek',
                    nama_rekening='$nama_rek',
                    nilai_kontrak='$nilai_kontrak',
                    ket_rek='$ket_non_persediaan',
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
                        set
                        kd_lokasi='$kd_lokasi',
                        kd_ruang='$kd_ruang',
                        id_masuk='$id_trans',
                        nm_satker='$nm_satker',
                        nm_ruang='$nm_ruang',
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

            $query_hps = "delete from transaksi_masuk where total_harga is null and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' ";
            $result_hps = $this->query($query_hps);

            $query_hps_full = "delete from transaksi_full where kd_brg like '' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' ";
            $result_hps_full = $this->query($query_hps_full);
            return $result;
            return $result2;
            echo json_encode(array("pesan"=>"Data Berhasil Ditambahkan"));


    }

    public function transaksi_masuk_ident($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $nilai_kontrak = $data['nilai_kontrak'];
        $kd_ruang = $data['kd_ruang'];
        $kd_lok_msk = $data['kd_lokasi'];
        $nm_satker = $data['nm_satker'];
        $nm_ruang = $_SESSION['nm_ruang'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $jns_trans = $data['jns_trans'];

        $keterangan = $data['keterangan'];
        $status = $data['status'];
        $user_id = $data['user_id'];

       if($no_dok=="" || $kd_lokasi=="") exit;
// Memasukan Data Transaksi Masuk ke tabel Transaksi Masuk
        $query = "Insert into transaksi_masuk
                    set kd_lokasi='$kd_lokasi',
                    kd_ruang='$kd_ruang',
                    nm_satker='$nm_satker',
                    nm_ruang='$nm_ruang',
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
                        nm_ruang='$nm_ruang',
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

    public function usulkan_transfer($data){
        return $this->query("UPDATE transfer set status=1 where id='$data' ");
    }

    public function hapus_usulan_transfer($data){
        return $this->query("DELETE FROM transfer where id='$data' ");
    }

    public function hapus_transfer($data){
        return $this->query("UPDATE transfer set status=3 where id='$data' ");
    }

  public function tbh_transfer($data,$jenis)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_satker = $data['kd_lokasi'].$data['ruang_asal'];
        $kd_lok_msk = $data['kd_lok_msk'];
        $kd_ruang_msk = $data['kd_ruang'];
        $ruang_asal= $data['ruang_asal'];
        $nm_satker = $data['nm_satker'];
        $nm_satker_msk = $data['nm_satker_msk'];
        $nm_satker_msk = $data['nm_satker_msk'];
        $nm_ruang_msk = $data['nm_ruang'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $tgl_dok = $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_bukti = $data['no_bukti'];
        $jns_trans = $data['jns_trans'];
        $keterangan = $data['keterangan'];

        $status = $data['status'];
        $user_id = $data['user_id'];

        if($jenis==1){
            $query = "Insert into transfer
                        set
                        kd_lokasi='$kd_lokasi',
                        kd_ruang='$ruang_asal',
                        kd_lok_msk='$kd_lok_msk',
                        kd_ruang_msk='$kd_ruang_msk',
                        nm_satker='$nm_satker',
                        nm_satker_msk='$nm_satker_msk',
                        nm_ruang_msk='$nm_ruang_msk',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        jns_trans='$jns_trans',
                        keterangan='$keterangan',

                        status=0,
                        tgl_update=CURDATE(),
                        user_id='$user_id'";

            $result = $this->query($query);
            return $result;
        }
        else{
            $query_dok = "select id, kd_lokasi, kd_ruang, kd_lok_msk, kd_ruang_msk, nm_satker_msk, nm_ruang_msk, tgl_dok, tgl_buku, jns_trans, keterangan from transfer where no_dok='$no_dok' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' LIMIT 1";
            // print_r($query_dok);
            $result_dok = $this->query($query_dok);
            if($this->num_rows($result_dok)==0)
            {
                $this->query("ROLLBACK");
                echo "Tidak Dapat Menambah Barang Setelah Opname / Seluruh Item Telah Dihapus, buat Dokumen Baru!";
                exit();
            }
            $dok           = $this->fetch_array($result_dok);
            
            $transfer_id    = $dok['id'];
            $kd_lok_msk    = $dok['kd_lok_msk'];
            $nm_ruang_msk  = $dok['nm_ruang_msk'];
            $kd_ruang      = $dok['kd_ruang'];
            $kd_ruang_msk  = $dok['kd_ruang_msk'];
            $nm_satker_msk = $dok['nm_satker_msk'];
            // if($kd_lok_msk!="") echo "Satker Tujuan : ".$kd_lok_msk;
            
            $kd_satker  = $dok['kd_lokasi'].$dok['kd_ruang'];
            $kd_lokasi  = $dok['kd_lokasi'];
            $tgl_dok    = $dok['tgl_dok'];
            $tgl_buku   = $dok['tgl_buku'];
            $jns_trans  = $dok['jns_trans'];
            $keterangan = $dok['keterangan'];
            $kd_brg     = $data['kd_brg'];
            
            $kuantitas  = $data['kuantitas'];
            $harga_sat  = $data['harga_sat'];
            $query_id = "select id,id_brg_trf, id_opname, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, kd_perk, nm_perk, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and qty_akhir>0 and thn_ang='$thn_ang' order by tgl_dok asc, id asc limit 1";
            $res_id = $this->query($query_id);
            $row_id = $this->fetch_array($res_id);

            $kd_sskel = $row_id['kd_sskel'];
            $nm_sskel = $row_id['nm_sskel'];
            $kd_perk = $row_id['kd_perk'];
            $nm_perk = $row_id['nm_perk'];
            $nm_brg = $row_id['nm_brg'];
            $spesifikasi = $row_id['spesifikasi'];
            $satuan = $row_id['satuan'];

            $query = "Insert into transfer
                        set
                        kd_lokasi='$kd_lokasi',
                        kd_ruang='$ruang_asal',
                        kd_lok_msk='$kd_lok_msk',
                        kd_ruang_msk='$kd_ruang_msk',
                        nm_ruang_msk='$nm_ruang_msk',
                        nm_satker='$nm_satker',
                        nm_satker_msk='$nm_satker_msk',
                        thn_ang='$thn_ang',
                        no_dok='$no_dok',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        jns_trans='$jns_trans',
                        keterangan='$keterangan',
                        kd_sskel = '$kd_sskel',
                        nm_sskel = '$nm_sskel',
                        kd_perk = '$kd_perk',
                        nm_perk = '$nm_perk',
                        kd_brg = '$kd_brg',
                        nm_brg = '$nm_brg',
                        spesifikasi = '$spesifikasi',
                        qty = '$kuantitas',
                        satuan = '$satuan',
                        status=0,
                        tgl_update=CURDATE(),
                        user_id='$user_id'";

            $result = $this->query($query);
            $this->query("DELETE from transfer where no_dok='$no_dok' and kd_brg='' ");


        }

    }




    public function transaksi_keluar_ident($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_lok_msk = $data['kd_lok_msk'];
        $ruang_asal= $data['ruang_asal'];
        $kd_ruang = $data['kd_ruang'];
        $nm_ruang = $data['nm_ruang'];
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

        if($no_dok=="" || $kd_lokasi=="") exit;

        // $query_perk = "SELECT nm_sskel, kd_perk, nm_perk from persediaan where kd_brg='$kd_brg' ";

        // $result_perk = $this->query($query_perk);
        // $data_perk = $this->fetch_array($result_perk);
        // $kd_sskel = $data_perk['kd_brg'];
        // $nm_sskel = $data_perk['nm_sskel'];
        // $kd_perk = $data_perk['kd_perk'];
        // $nm_perk = $data_perk['nm_perk'];

// Memasukan Data Transaksi Masuk ke tabel Transaksi Keluar
        $query = "Insert into transaksi_keluar
                    set
                    kd_lokasi='$kd_lokasi',
                    kd_ruang='$ruang_asal',
                    kd_lok_msk='$kd_lok_msk',
                    kd_ruang_msk='$kd_ruang',
                    nm_satker='$nm_satker',
                    nm_satker_msk='$nm_ruang',
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

    public function import_transaksi_keluar($data)
    {
        error_reporting(0);
        $kd_lokasi = $data['kd_lokasi'];
        $kd_satker = $data['kd_lokasi'].$data['ruang_asal'];
        $nm_satker = $data['nm_satker'];
        $ruang_asal=$data['ruang_asal'];
        $kd_ruang  =$data['ruang_asal'];
        $thn_ang   = $data['thn_ang'];

        $no_dok    = $data['no_dok'];
        $tgl_dok   = $data['tgl_dok'];
        $tgl_buku  = $data['tgl_buku'];
        $arr_dok   = explode("-", $data['no_dok']);
        $no_bukti  = $arr_dok[1];
        $jns_trans = $data['jns_trans'];
        $keterangan= $data['keterangan'];

        $kd_brg    = $data['kd_brg'];


        $satuan    = $data['satuan'];
        $kuantitas = $data['qty'];
        $status    = $data['status'];
        $user_id   = $data['user_id'];


        // echo "<pre>";
        while($kuantitas > 0)
        {
            // echo " kuantitas tersisa : ".$kuantitas;
            $query_id = "SELECT id,id_brg_trf,
                                id_opname,
                                kd_sskel,
                                nm_sskel,
                                kd_brg,
                                nm_brg,
                                spesifikasi,
                                satuan,
                                kd_perk,
                                nm_perk,
                                qty_akhir,
                                harga_sat
                        FROM  transaksi_masuk
                        WHERE kd_brg='$kd_brg'
                              and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker'
                              and qty_akhir>0
                              and thn_ang='$thn_ang' order by tgl_dok asc, id asc limit 1";

            // echo "Pencarian Barang : ".$query_id."<br>";

            $result_id  = $this->query($query_id);
            $row_id     = $this->fetch_array($result_id);
            $id_trans_m = $row_id['id'];
            $id_brg_trf = $row_id['id_brg_trf'];
            $id_opname  = $row_id['id_opname'];
            $qty_akhir  = $row_id['qty_akhir'];
            $harga_sat  = $row_id['harga_sat'];
            $total_harga= $kuantitas*$harga_sat;

            $kd_sskel   = $row_id['kd_sskel'];
            $nm_sskel   = $row_id['nm_sskel'];
            $kd_perk    = $row_id['kd_perk'];
            $nm_perk    = $row_id['nm_perk'];
            $nm_brg     = $row_id['nm_brg'];
            $spesifikasi= $row_id['spesifikasi'];

            // echo "ID transaksi masuk : ".$id_trans_m.' '.$qty_akhir.' '.$harga_sat;
            // echo '<br>';

            if($kuantitas<$qty_akhir)
            {
                // echo "terbukti sisa kuantitas : ".$kuantitas.' dengan qy akhir : '.$qty_akhir;
                // echo '<br>';

                $query_keluar = "Insert into transaksi_keluar
                                    set
                                    id_brg_trf   ='$id_brg_trf',
                                    kd_lokasi    ='$kd_lokasi',
                                    kd_ruang     ='$kd_ruang',
                                    kd_lok_msk   ='$kd_lok_msk',
                                    kd_ruang_msk ='$kd_ruang_msk',
                                    nm_satker_msk='$nm_satker_msk',
                                    id_masuk     = '$id_trans_m',
                                    id_opname    = '$id_opname',
                                    nm_satker    ='$nm_satker',
                                    thn_ang      ='$thn_ang',
                                    no_dok       ='$no_dok',
                                    tgl_dok      ='$tgl_dok',
                                    tgl_buku     ='$tgl_buku',
                                    no_bukti     ='$no_bukti',
                                    jns_trans    ='$jns_trans',
                                    kd_sskel     ='$kd_sskel',
                                    nm_sskel     ='$nm_sskel',
                                    kd_perk      ='$kd_perk',
                                    nm_perk      ='$nm_perk',
                                    kd_brg       ='$kd_brg',
                                    nm_brg       ='$nm_brg',
                                    spesifikasi  ='$spesifikasi',
                                    satuan       ='$satuan',
                                    qty          =-1*'$kuantitas',
                                    harga_sat    ='$harga_sat',
                                    total_harga  =-1*'$total_harga',
                                    keterangan   ='$keterangan',
                                    status       =0,
                                    tgl_update   =CURDATE(),
                                    user_id      ='$user_id'";

                // echo "Insert Barang keluar if qty<qty_akhir : ".$query_keluar."<br>";


                $result_keluar = $this->query($query_keluar);
                $id_transk = $this->insert_id();

                $query_log = "Insert into log_trans_masuk
                        set
                        kd_lokasi  ='$kd_lokasi',
                        nm_satker  ='$nm_satker',
                        thn_ang    ='$thn_ang',
                        no_dok     ='$no_dok',
                        tgl_dok    ='$tgl_dok',
                        tgl_buku   ='$tgl_buku',
                        no_bukti   ='$no_bukti',
                        jns_trans  ='$jns_trans',
                        aksi       ='I-Transaksi Keluar',
                        kd_brg     ='$kd_brg',
                        nm_brg     ='$nm_brg',


                        qty        =-1*'$kuantitas',

                        harga_sat  ='$harga_sat',
                        total_harga=-1*'$total_harga',
                        keterangan ='$keterangan',
                        tgl_update =NOW(),
                        user_id    ='$user_id'";
                $result_log      = $this->query($query_log);

                $query_upd_masuk = "UPDATE transaksi_masuk
                                    SET qty_akhir = qty_akhir - $kuantitas
                                    WHERE id='$id_trans_m'  ";
                $result_upd_masuk= $this->query($query_upd_masuk);



                $minus_qty  = -$kuantitas;
                $minus_hrg  = -$harga_sat;
                $minus_total= -$total_harga;
                // echo "id trans keluar : ".$id_transk;
                // echo '<br>';
                $query_full = "Insert into transaksi_full
                                set
                                id_brg_trf   ='$id_trans_m',
                                kd_lokasi    ='$kd_lokasi',
                                kd_ruang     ='$kd_ruang',
                                id_keluar    ='$id_transk',
                                id_opname    ='$id_opname',
                                kd_lok_msk   ='$kd_lok_msk',
                                kd_ruang_msk ='$kd_ruang_msk',
                                nm_satker    ='$nm_satker',
                                nm_satker_msk='$nm_satker_msk',
                                thn_ang      ='$thn_ang',
                                no_dok       ='$no_dok',
                                tgl_dok      ='$tgl_dok',
                                tgl_buku     ='$tgl_buku',
                                no_bukti     ='$no_bukti',
                                jns_trans    ='$jns_trans',
                                kd_sskel     ='$kd_sskel',
                                nm_sskel     ='$nm_sskel',
                                kd_perk      ='$kd_perk',
                                nm_perk      ='$nm_perk',
                                kd_brg       ='$kd_brg',
                                nm_brg       ='$nm_brg',
                                spesifikasi  ='$spesifikasi',
                                satuan       ='$satuan',
                                qty          ='$minus_qty',
                                harga_sat    ='$minus_hrg',
                                total_harga  ='$minus_total',
                                keterangan   ='$keterangan',
                                status       =0,
                                tgl_update   =NOW(),
                                user_id      ='$user_id'";


                $result_trans_full = $this->query($query_full);

                $kuantitas = 0;
                break;
            }

                $query_id      = "select id,id_brg_trf, id_opname, kd_brg, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and qty_akhir>0 and thn_ang='$thn_ang'  order by tgl_dok asc, id asc limit 1";
                // echo "Cari Ref. Barang if qty>qty_akhir : ".$query_id."<br>";
                $result_id     = $this->query($query_id);
                if($this->num_rows($result_id)==0){
                     $query = "select sum(qty_akhir) as sisa,satuan from transaksi_masuk  where kd_brg = '$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and tgl_dok<='$tgl_dok' and thn_ang='$thn_ang' ";
                    $result_id     = $this->query($query);
                    echo "Jumlah Barang yang dikeluarkan sebesar $kuantitas $satuan pada kode Barang $kd_brg Melebihi Sisa barang yang tersimpan didalam sistem sebesar 0 ";
                    exit;
                }
                $row_id        = $this->fetch_array($result_id);
                $id_trans      = $row_id['id'];
                $id_brg_trf    = $row_id['id_brg_trf'];
                $qty_akhir     = $row_id['qty_akhir'];
                $id_opname     = $row_id['id_opname'];
                $harga_sat     = $row_id['harga_sat'];
                $total_harga   = $qty_akhir * $harga_sat;

                // echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                // echo '<br>';

                $query_keluar  = "Insert into transaksi_keluar
                                set
                                id_brg_trf   ='$id_brg_trf',
                                kd_lok_msk   ='$kd_lok_msk',
                                kd_ruang_msk ='$kd_ruang_msk',
                                nm_satker_msk='$nm_satker_msk',
                                kd_lokasi    ='$kd_lokasi',
                                kd_ruang     ='$kd_ruang',
                                id_masuk     = '$id_trans',
                                id_opname    = '$id_opname',
                                nm_satker    ='$nm_satker',
                                thn_ang      ='$thn_ang',
                                no_dok       ='$no_dok',
                                tgl_dok      ='$tgl_dok',
                                tgl_buku     ='$tgl_buku',
                                no_bukti     ='$no_bukti',
                                jns_trans    ='$jns_trans',
                                kd_sskel     ='$kd_sskel',
                                nm_sskel     ='$nm_sskel',
                                kd_perk      ='$kd_perk',
                                nm_perk      ='$nm_perk',
                                kd_brg       ='$kd_brg',
                                nm_brg       ='$nm_brg',
                                spesifikasi  ='$spesifikasi',
                                satuan       ='$satuan',
                                qty          =-1*'$qty_akhir',
                                harga_sat    ='$harga_sat',
                                total_harga  =-1*'$total_harga',
                                keterangan   ='$keterangan',
                                status       =0,
                                tgl_update   =CURDATE(),
                                user_id      ='$user_id'";

                // echo "Insert Barang keluar if qty>qty_akhir : ".$query_keluar."<br>";
                $result_keluar = $this->query($query_keluar);
                $id_transk = $this->insert_id();
                $query_log = "Insert into log_trans_masuk
                                set
                                kd_lokasi  ='$kd_lokasi',
                                nm_satker  ='$nm_satker',
                                thn_ang    ='$thn_ang',
                                no_dok     ='$no_dok',
                                tgl_dok    ='$tgl_dok',
                                tgl_buku   ='$tgl_buku',
                                no_bukti   ='$no_bukti',
                                jns_trans  ='$jns_trans',
                                aksi       ='I-Transaksi Keluar',
                                kd_brg     ='$kd_brg',
                                nm_brg     ='$nm_brg',
                                qty        =-1*'$qty_akhir',
                                harga_sat  ='$harga_sat',
                                total_harga=-1*'$total_harga',
                                keterangan ='$keterangan',
                                tgl_update =NOW(),
                                user_id    ='$user_id'";
                $result_log = $this->query($query_log);
                $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $qty_akhir where id='$id_trans'  ";
                $result_upd_masuk = $this->query($query_upd_masuk);

                $minus_qty = -$qty_akhir;
                $minus_hrg = -$harga_sat;
                $minus_total = -$total_harga;
                if($kd_lok_msk!="") $keterangan = "Transfer ke ".$nm_satker_msk;
                $query_full = "Insert into transaksi_full
                                set
                                kd_lokasi    ='$kd_lokasi',
                                kd_ruang     ='$kd_ruang',
                                id_trans     ='$id_transk',
                                id_opname    ='$id_opname',
                                id_keluar    ='$id_transk',
                                kd_lok_msk   ='$kd_lok_msk',
                                nm_satker    ='$nm_satker',
                                nm_satker_msk='$nm_satker_msk',
                                thn_ang      ='$thn_ang',
                                no_dok       ='$no_dok',
                                tgl_dok      ='$tgl_dok',
                                tgl_buku     ='$tgl_buku',
                                no_bukti     ='$no_bukti',
                                jns_trans    ='$jns_trans',
                                kd_sskel     ='$kd_sskel',
                                nm_sskel     ='$nm_sskel',
                                kd_perk      ='$kd_perk',
                                nm_perk      ='$nm_perk',
                                kd_brg       ='$kd_brg',
                                nm_brg       ='$nm_brg',
                                spesifikasi  ='$spesifikasi',
                                satuan       ='$satuan',
                                qty          ='$minus_qty',
                                harga_sat    ='$minus_hrg',
                                total_harga  ='$minus_total',
                                keterangan   ='$keterangan',
                                status       =0,
                                tgl_update   =NOW(),
                                user_id      ='$user_id'";
                if($kd_lok_msk!="") $keterangan = "Transfer dari ".$nm_satker;

                $result_full   = $this->query($query_full);
                $kuantitas     = $kuantitas - $qty_akhir;

        }
    }

    public function trnsaksi_keluar($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $transfer_id = $data['id_brg_transfer'];
        $kd_satker = $data['kd_lokasi'].$data['ruang_asal'];
        $nm_satker = $data['nm_satker'];
        $nm_ruang = $_SESSION['nm_ruang'];
        // $kd_ruang = $data['kd_ruang'];
        $q_ruang="";
        $nama_tabel;
        $ruang_asal=$data['ruang_asal'];
        if($ruang_asal!=""){
            $q_ruang = " and kd_ruang='$ruang_asal' ";
        }
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        if($data['trf']>0){
            $nama_tabel="transfer";
        }
        else{
            $nama_tabel="transaksi_keluar";
        }
        $this->query("BEGIN");
        $query_dok = "select kd_lokasi, kd_ruang, kd_lok_msk, kd_ruang_msk, nm_satker_msk, nm_ruang_msk, tgl_dok, tgl_buku, jns_trans, keterangan from ".$nama_tabel." where no_dok='$no_dok' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' LIMIT 1";
        // print_r($query_dok);
        $result_dok = $this->query($query_dok);
        if($this->num_rows($result_dok)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Menambah Barang Setelah Opname / Seluruh Item Telah Dihapus, buat Dokumen Baru!";
            exit();
        }
        $dok = $this->fetch_array($result_dok);

        $kd_lok_msk = $dok['kd_lok_msk'];
        $kd_ruang = $dok['kd_ruang'];
        $kd_ruang_msk = $dok['kd_ruang_msk'];
        $nm_ruang_msk = $dok['nm_ruang_msk'];
        $nm_satker_msk = $dok['nm_satker_msk'];
        if($kd_lok_msk!="") echo "Satker Tujuan : ".$kd_lok_msk;

        $kd_satker = $dok['kd_lokasi'].$dok['kd_ruang'];

        $kd_lokasi = $dok['kd_lokasi'];
        $tgl_dok = $dok['tgl_dok'];
        $tgl_buku = $dok['tgl_buku'];
        $arr_dok  =explode("-", $dok['no_dok']);
        $no_bukti = $arr_dok[1];
        $jns_trans = $dok['jns_trans'];
        $keterangan = $dok['keterangan'];

        $kd_brg = $data['kd_brg'];


        $satuan = $data['satuan'];
        $kuantitas = $data['kuantitas'];
        $jmlDikeluarkan = $data['kuantitas'];
        // $harga_sat = $data['harga_sat'];
        $status = $data['status'];
        $user_id = $data['user_id'];

        $cek_slip = "select nm_brg, spesifikasi, tgl_dok from transaksi_keluar where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and kd_brg='$kd_brg' and tgl_dok>'$tgl_dok'  order by tgl_dok asc limit 1";
        $result_slip = $this->query($cek_slip);
        $data_slip = $this->fetch_array($result_slip);
        if($this->num_rows($result_slip)==1)
        {
            $tgl_slip = $data_slip['tgl_dok'];
            $nm_brg = $data_slip['nm_brg'];
            $spesifikasi = $data_slip['spesifikasi'];
            $insert_slip = "INSERT INTO log_slip
                 set    kd_lokasi='$kd_lokasi',
                        nm_satker='$nm_satker',
                        thn_ang='$thn_ang',
                        user_id='$user_id',
                        tgl_dok='$tgl_dok',
                        tgl_buku='$tgl_buku',
                        kd_brg='$kd_brg',
                        nm_brg='$nm_brg',
                        spesifikasi='$spesifikasi',
                        satuan='$satuan',
                        qty='$kuantitas',
                        harga_sat='$harga_sat',
                        tgl_slip='$tgl_slip',
                        status=1,
                        tgl_update=NOW()
                        ";
                $this->query($insert_slip);
                echo "TERDAPAT TERSELIP";

        }


        while($kuantitas > 0)
        {
            // echo " kuantitas tersisa : ".$kuantitas;
            $query_id = "select id,id_brg_trf, id_opname, kd_sskel, nm_sskel, kd_brg, nm_brg, spesifikasi, satuan, kd_perk, nm_perk, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and qty_akhir>0 and thn_ang='$thn_ang' order by tgl_dok asc, id asc limit 1";
            $result_id = $this->query($query_id);
            $row_id = $this->fetch_array($result_id);
            $id_trans_m = $row_id['id'];
            $id_brg_trf = $row_id['id_brg_trf'];
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
            if($kd_lok_msk!="") $keterangan = "Transfer ke ".$nm_satker_msk;

            if($kuantitas<$qty_akhir)
            {
                // echo "terbukti sisa kuantitas : ".$kuantitas.' dengan qy akhir : '.$qty_akhir;
                // echo '<br>';

                $query_keluar = "Insert into transaksi_keluar
                                    set
                                    id_brg_trf='$id_brg_trf',
                                    transfer_id='$transfer_id',
                                    kd_lokasi='$kd_lokasi',
                                    kd_ruang='$kd_ruang',
                                    kd_lok_msk='$kd_lok_msk',
                                    kd_ruang_msk='$kd_ruang_msk',
                                    nm_satker_msk='$nm_satker_msk',
                                    nm_ruang_msk='$nm_ruang_msk',
                                    id_masuk = '$id_trans_m',
                                    id_opname = '$id_opname',
                                    nm_satker='$nm_satker',
                                    nm_ruang='$nm_ruang',
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

                    if($kd_lok_msk!="") $keterangan = "Transfer dari ".$nm_satker;
                    $query_trf = "Insert into transaksi_masuk
                                    set
                                    id_brg_trf='$id_trans_m',
                                    transfer_id='$transfer_id',
                                    kd_lokasi='$kd_lok_msk',
                                    kd_lok_msk='$kd_lokasi',
                                    kd_ruang='$kd_ruang_msk',
                                    kd_ruang_msk='$kd_ruang',
                                    nm_satker='$nm_satker_msk',
                                    nm_satker_msk='$nm_satker',
                                    nm_ruang_msk='$nm_ruang_msk',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='$no_bukti',
                                    jns_trans='M06',
                                    kd_sskel='$kd_sskel',
                                    nm_sskel='$nm_sskel',
                                    kd_perk='$kd_perk',
                                    nm_perk='$nm_perk',
                                    kd_brg='$kd_brg',
                                    nm_brg='$nm_brg',
                                    spesifikasi='$spesifikasi',
                                    satuan='$satuan',
                                    qty='$kuantitas',
                                    qty_akhir='$kuantitas',
                                    harga_sat='$harga_sat',
                                    total_harga='$total_harga',
                                    keterangan='$keterangan',
                                    status=0,
                                    tgl_update=CURDATE(),
                                    user_id='$user_id'";
                $result_keluar = $this->query($query_keluar);
                if($kd_lok_msk!="") $this->query($query_trf);
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

                $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $kuantitas where id='$id_trans_m'  ";
                $result_upd_masuk = $this->query($query_upd_masuk);

                // $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and user_id='$user_id' and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' order by id DESC";
                // $result_idk = $this->query($query_idk);
                // $row_idk = $this->fetch_array($result_idk);

                $minus_qty = -$kuantitas;
                $minus_hrg = -$harga_sat;
                $minus_total = -$total_harga;
                echo "id trans keluar : ".$id_transk;
                echo '<br>';
                if($kd_lok_msk!="") $keterangan = "Transfer ke ".$nm_satker_msk;
                $query_full = "Insert into transaksi_full
                                set
                                id_brg_trf='$id_trans_m',
                                kd_lokasi='$kd_lokasi',
                                kd_ruang='$kd_ruang',
                                id_keluar='$id_transk',
                                id_opname='$id_opname',
                                kd_lok_msk='$kd_lok_msk',
                                kd_ruang_msk='$kd_ruang_msk',
                                nm_satker='$nm_satker',
                                nm_satker_msk='$nm_satker_msk',
                                nm_ruang_msk='$nm_ruang_msk',
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
                if($kd_lok_msk!="") $keterangan = "Transfer dari ".$nm_satker;
                $query_full_trf = "Insert into transaksi_full
                                    set
                                    id_masuk='$id_trans',
                                    id_brg_trf='$id_trans_m',
                                    transfer_id='$transfer_id',
                                    kd_lokasi='$kd_lok_msk',
                                    kd_lok_msk='$kd_lokasi',
                                    kd_ruang='$kd_ruang_msk',
                                    kd_ruang_msk='$kd_ruang',
                                    nm_satker='$nm_satker_msk',
                                    nm_ruang_msk='$nm_ruang_msk',
                                    nm_satker_msk='$nm_satker',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='$no_bukti',
                                    jns_trans='M06',
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
                $result_trans_full = $this->query($query_full);
                if($kd_lok_msk!="") $this->query($query_full_trf);
                $kuantitas = 0;
                break;
            }
            // else
            // {
                $query_id = "select id,id_brg_trf, id_opname, kd_brg, qty_akhir, harga_sat from transaksi_masuk WHERE kd_brg='$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and qty_akhir>0 and thn_ang='$thn_ang'  order by tgl_dok asc, id asc limit 1";
                $result_id = $this->query($query_id);
                if($this->num_rows($result_id)==0){
                     $query = "select sum(qty_akhir) as sisa,satuan from transaksi_masuk  where kd_brg = '$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and tgl_dok<='$tgl_dok' and thn_ang='$thn_ang' ";
                    $result_id     = $this->query($query);
                    $sisa = $jmlDikeluarkan - $kuantitas;
                    echo "Jumlah Barang yang dikeluarkan sebesar $kuantitas $satuan pada kode Barang $kd_brg Melebihi Sisa barang yang tersimpan didalam sistem sebesar $sisa ";
                    exit;
                }
                $row_id = $this->fetch_array($result_id);
                $id_trans = $row_id['id'];
                $id_brg_trf = $row_id['id_brg_trf'];
                $qty_akhir = $row_id['qty_akhir'];
                $id_opname = $row_id['id_opname'];
                $harga_sat = $row_id['harga_sat'];
                $total_harga = $qty_akhir * $harga_sat;
                echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                echo '<br>';
                if($kd_lok_msk!="") $keterangan = "Transfer ke ".$nm_satker_msk;
                $query_keluar = "Insert into transaksi_keluar
                                set
                                id_brg_trf='$id_brg_trf',
                                transfer_id='$transfer_id',
                                kd_lok_msk='$kd_lok_msk',
                                kd_ruang_msk='$kd_ruang_msk',
                                nm_satker_msk='$nm_satker_msk',
                                nm_ruang_msk='$nm_ruang_msk',
                                kd_lokasi='$kd_lokasi',
                                kd_ruang='$kd_ruang',
                                id_masuk = '$id_trans',
                                id_opname = '$id_opname',
                                nm_satker='$nm_satker',
                                nm_ruang='$nm_ruang',
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
                if($kd_lok_msk!="") $keterangan = "Transfer dari ".$nm_satker;
                $query_trf = "Insert into transaksi_masuk
                                    set
                                    id_brg_trf='$id_trans_m',
                                    transfer_id='$transfer_id',
                                    kd_lokasi='$kd_lok_msk',
                                    kd_lok_msk='$kd_lokasi',
                                    kd_ruang='$kd_ruang_msk',
                                    kd_ruang_msk='$kd_ruang',
                                    nm_satker='$nm_satker_msk',
                                    nm_ruang_msk='$nm_ruang_msk',
                                    nm_satker_msk='$nm_satker',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='$no_bukti',
                                    jns_trans='M06',
                                    kd_sskel='$kd_sskel',
                                    nm_sskel='$nm_sskel',
                                    kd_perk='$kd_perk',
                                    nm_perk='$nm_perk',
                                    kd_brg='$kd_brg',
                                    nm_brg='$nm_brg',
                                    spesifikasi='$spesifikasi',
                                    satuan='$satuan',
                                    qty='$qty_akhir',
                                    qty_akhir='$qty_akhir',
                                    harga_sat='$harga_sat',
                                    total_harga='$total_harga',
                                    keterangan='$keterangan',
                                    status=0,
                                    tgl_update=CURDATE(),
                                    user_id='$user_id'";

                $result_keluar = $this->query($query_keluar);
                if($kd_lok_msk!="") $this->query($query_trf);
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
                $query_upd_masuk = "update transaksi_masuk set qty_akhir = qty_akhir - $qty_akhir where id='$id_trans'  ";
                $result_upd_masuk = $this->query($query_upd_masuk);

                // $query_idk = "select id from transaksi_keluar WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and user_id='$user_id' and no_dok='$no_dok' order by id DESC";
                // $result_idk = $this->query($query_idk);
                // $row_idk = $this->fetch_array($result_idk);


                $minus_qty = -$qty_akhir;
                $minus_hrg = -$harga_sat;
                $minus_total = -$total_harga;
                if($kd_lok_msk!="") $keterangan = "Transfer ke ".$nm_satker_msk;
                $query_full = "Insert into transaksi_full
                                set
                                kd_lokasi='$kd_lokasi',
                                kd_ruang='$kd_ruang',
                                id_trans='$id_transk',
                                id_opname='$id_opname',
                                id_keluar='$id_transk',
                                kd_lok_msk='$kd_lok_msk',
                                nm_satker='$nm_satker',
                                nm_satker_msk='$nm_satker_msk',
                                nm_ruang_msk='$nm_ruang_msk',
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
                if($kd_lok_msk!="") $keterangan = "Transfer dari ".$nm_satker;
                $query_full_trf = "Insert into transaksi_full
                                    set
                                    id_masuk='$id_trans',
                                    id_brg_trf='$id_trans_m',
                                    transfer_id='$transfer_id',
                                    kd_lokasi='$kd_lok_msk',
                                    kd_ruang_msk='$kd_ruang',
                                    kd_lok_msk='$kd_lokasi',
                                    kd_ruang='$kd_ruang_msk',
                                    nm_satker='$nm_satker_msk',
                                    nm_ruang_msk='$nm_ruang_msk',
                                    nm_satker_msk='$nm_satker',
                                    thn_ang='$thn_ang',
                                    no_dok='$no_dok',
                                    tgl_dok='$tgl_dok',
                                    tgl_buku='$tgl_buku',
                                    no_bukti='$no_bukti',
                                    jns_trans='M06',
                                    kd_sskel='$kd_sskel',
                                    nm_sskel='$nm_sskel',
                                    kd_brg='$kd_brg',
                                    nm_brg     ='$nm_brg',
                                    kd_perk    ='$kd_perk',
                                    nm_perk    ='$nm_perk',
                                    satuan     ='$satuan',
                                    qty        ='$qty_akhir',
                                    harga_sat  ='$harga_sat',
                                    total_harga='$total_harga',
                                    keterangan ='$keterangan',
                                    status=0,
                                    tgl_update=NOW(),
                                    user_id='$user_id'";
                $result_full = $this->query($query_full);
                if($kd_lok_msk!="") $this->query($query_full_trf);
                $kuantitas = $kuantitas - $qty_akhir;

            // }


        }
            $query_hps = "delete from ".$nama_tabel." where kd_brg like '' and no_dok='$no_dok' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' ";
            $result_hps = $this->query($query_hps);

            $query_hps_full = "delete from transaksi_full where kd_brg like '' and no_dok='$no_dok' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' ";
            $result_hps_full = $this->query($query_hps_full);
            $com = $this->query("COMMIT");
            if($this->num_rows($com)==0 and $data["trf"]>0){
                $id_trsf = $data["trf"];
                $this->query("UPDATE transfer set status=2 where id='$id_trsf' ");
            }

    }


    public function ubah_dok_masuk($data){

        $kd_lokasi = $data['kd_lokasi'];
        $kd_satker = $kd_lokasi.$data['kd_ruang'];
        $thn_ang = $data['thn_ang'];
        $tgl_dok= $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_dok = $data['no_dok'];
        $no_bukti = $data['no_bukti'];
        $no_dok_lama = $data['no_dok_lama'];
        $keterangan = $data['keterangan'];
        $user_id = $data['user_id'];

        $query = "SELECT * from transaksi_masuk where no_dok = '$no_dok_lama' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and status='0' and status_ambil='0' ";
        $result = $this->query($query);
        if($this->num_rows($result)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Mengedit Barang yang telah diopname / telah Import Saldo Awal";
            exit();
        }

        while($dok = $this->fetch_array($result)){
                $kd_lokasi = $dok['kd_lokasi'];
                $kd_ruang = $dok['kd_ruang'];
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
                        where no_dok = '$no_dok_lama' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' ";
                        $result = $this->query($query);

    }

    public function ubah_dok_keluar($data){

        $kd_lokasi = $data['kd_lokasi'];
        $kd_satker = $kd_lokasi.$data['kd_ruang'];
        $thn_ang = $data['thn_ang'];
        $tgl_dok= $data['tgl_dok'];
        $tgl_buku = $data['tgl_buku'];
        $no_dok = $data['no_dok'];
        $no_dok_lama = $data['no_dok_lama'];
        $keterangan = $data['keterangan'];

        $query = "SELECT * from transaksi_keluar where no_dok = '$no_dok_lama' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and status='0' and status_ambil='0' ";
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
                        where no_dok = '$no_dok_lama' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' ";
                        $result = $this->query($query);

    }

    public function ubah_transaksi_masuk($data)
    {
        $kd_trans = $data['kd_trans']; // id transaksi masuk

        $kd_lok_msk = $data['kd_lok_msk'];

        $kd_satker = $kd_lokasi.$data['kd_ruang'];

        $thn_ang = $data['thn_ang'];
        $kuantitas = $data['kuantitas'];
        $harga_baru = $data['harga_sat'];
        $this->query("BEGIN");
        $query_qty_awal ="SELECT  id,nm_satker, kd_lokasi, kd_ruang, no_dok, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_perk, nm_perk,jns_trans, kd_brg, nm_brg, spesifikasi, satuan, qty,qty_akhir, harga_sat, total_harga from transaksi_masuk where id='$kd_trans' ";
        $result_qty_awal = $this->query($query_qty_awal);
        if($this->num_rows($result_qty_awal)==0)
        {
            $this->query("ROLLBACK");
            echo "Tidak Dapat Mengedit Barang yang telah diopname / telah Import Saldo Awal";
            exit();
        }
        $row_qty = $this->fetch_array($result_qty_awal);

        $no_dok = $row_qty['no_dok'];
        $kd_lokasi = $row_qty['kd_lokasi'];
        $kd_ruang = $row_qty['kd_ruang'];
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
                        kd_ruang='$kd_ruang',
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
                            $kd_ruang=$row_id['kd_ruang'];
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
                                        kd_ruang='$kd_ruang',
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

                $query = "select * from transaksi_masuk where id_brg_trf='$kd_trans'  ";
                print($query);
                $result3 = $this->query($query);
                while ($row_id = $this->fetch_array($result3))
                        {
                            $id = $row_id['id'];
                            $id_masuk = $row_id['id_masuk'];
                            $id_opname = $row_id['id_opname'];
                            $kd_lokasi=$row_id['kd_lokasi'];
                            $kd_ruang=$row_id['kd_ruang'];
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
                            echo "<br>Ubah Data Transfer</br>";
                            $query = "select harga_sat from transaksi_masuk where id='$id_masuk' ";
                            $data_harga = $this->fetch_array($this->query($query));
                            $harga_baru = $data['harga_sat'];
                            $subtotal_baru = $qty * $harga_baru;
                            $selisih_subtotal = $subtotal_baru - $total_harga;

                            echo 'T ID KELUAR : '.$id."<br>";
                            echo 'T QTY : '.$qty."<br>";
                            echo 'T harga_sat : '.$harga_sat."<br>";
                            echo 'T total_hrg_lama : '.$total_harga."<br>";
                            echo 'T total_hrg_baru '.$subtotal_baru."<br>";
                            echo 'T SELISIH subtotal '.$selisih_subtotal;

                            $query_hrg_keluar = "update transaksi_masuk  set harga_sat='$harga_baru', total_harga='$subtotal_baru'  where  id='$id'  ";
                            $result_hrg_keluar = $this->query($query_hrg_keluar);


                            $query_full = "Insert into transaksi_full
                                        set
                                        kd_lokasi='$kd_lokasi',
                                        kd_lok_msk='',
                                        kd_ruang='$kd_ruang',
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

                $query = "select * from transaksi_keluar where id_brg_trf='$kd_trans'  ";
                $result4 = $this->query($query);
                while ($row_id = $this->fetch_array($result4))
                        {
                            $id = $row_id['id'];
                            $id_masuk = $row_id['id_masuk'];
                            $id_opname = $row_id['id_opname'];
                            $kd_lokasi=$row_id['kd_lokasi'];
                            $kd_ruang=$row_id['kd_ruang'];
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

                            $query = "select harga_sat from transaksi_keluar where id='$id_masuk' ";
                            $data_harga = $this->fetch_array($this->query($query));
                            $harga_baru = $data['harga_sat'];
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
                                        kd_ruang='$kd_ruang',
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

    public function hapus_rekening($id){
        $query = "delete from transaksi_masuk where id='$id' ";
        return $this->query($query);
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

        $query_id = "select id, id_masuk, kd_lokasi,kd_ruang,nm_satker, tgl_dok, tgl_buku, no_bukti, kd_sskel, nm_sskel, kd_perk, nm_perk, kd_brg, satuan, kd_brg, nm_brg, qty, harga_sat, total_harga  from transaksi_keluar WHERE id='$id' and status='0' and status_ambil='0' ";
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
        $kd_ruang=$row_id['kd_ruang'];
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
                        kd_ruang='$kd_ruang',
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
        $query = "select kd_brg, nm_brg, spesifikasi from persediaan where CONCAT(kd_brg,' ',nm_brg) like '%$data%' and char_length(kd_brg)>18 ";
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
        $query = "select kode, NamaSatker from satker where kode like '$kdlokasi%' and Kd_Ruang is null";
        $result = $this->query($query);
        while ($row = $this->fetch_array($result))
        {
            $str = $row['kode'];
            if (substr_count($str,".") == 3) {
                echo '<option value="'.$row['kode'].'">'.$row['kode'].'  -  '.$row['NamaSatker']."</option>";
            }
        }
    }

    public function get_bidang_report($data){
        $kode_satker = $data['kode_satker'].$data['kode_ruang'];
        $query = "select Kd_Ruang, kode, NamaSatker from satker where concat(kode,IFNULL(kd_ruang,'')) like '$kode_satker%' ";
        // echo $query;
        $result = $this->query($query);
        while ($row = $this->fetch_array($result))
        {
            if($row['Kd_Ruang']=="") $row['Kd_Ruang']=" ";
            echo '<option value="'.$row['Kd_Ruang'].'">'.$row['Kd_Ruang'].'  -  '.$row['NamaSatker']."</option>";

        }

    }

    public function baca_ruang($data)
    {
        // $satker = $data['no_dok'];
        $kd_satker = $data['kd_lokasi'];
        $thnang = $data['thn_ang'];
        $query = "select Kd_Ruang, kode, NamaSatker from satker where kode = '$kd_satker' and kd_ruang is not null";
        // echo $query;
        $result = $this->query($query);
        while ($row = $this->fetch_array($result))
        {
            $str = $row['kode'];

            // if (substr_count($str,".") == 3) {
                echo '<option value="'.$row['Kd_Ruang']."-".$row['NamaSatker'].'">'.$row['Kd_Ruang'].'  -  '.$row['NamaSatker']."</option>";
            // }
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
    public function bacaidenttrans($data,$kd_ruang,$thn_ang)
    {
        $query = "select no_bukti, tgl_dok, tgl_buku, jns_trans, nm_satker, keterangan, sum(total_harga) as total_harga from transaksi_masuk where no_dok = '$data' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_ruang' and thn_ang='$thn_ang' group by no_dok";
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
            $hslket = $row["keterangan"];
            if($hsltottrans=="")
            {
                $hsltottrans=0;
            }
            echo json_encode(array("nobukti"=>$hslnobukti,"jenistrans"=>$hsljenistrans,"tgldok"=>$hsltgldok,"tglbuku"=>$hsltglbuku,"satker"=>$hslsatker,"total"=>number_format($hsltottrans,2,",","."),"keterangan"=>$hslket));
        }
    }

    public function bacaidenttrans_klr($data,$kd_ruang,$jenis)
    {
        $nama_tbl   =   "";
        $kolom      =   "";
        if($jenis==1){
            $nama_tbl="transaksi_keluar";
            $kolom = "nm_satker_msk, no_bukti, tgl_dok, tgl_buku, jns_trans, nm_satker,keterangan, sum(total_harga) as total_harga";
        }
        else{
            $nama_tbl="transfer";
            $kolom = "nm_satker_msk, tgl_dok, tgl_buku, jns_trans, nm_satker,keterangan, sum(total_harga) as total_harga";
        }
        $query = "select ".$kolom." from ".$nama_tbl." where no_dok = '$data' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_ruang' and thn_ang=$_SESSION[thn_ang] group by no_dok";
        $result = $this->query($query);
        if ($row = $this->fetch_assoc($result))
        {
            $datedok = date_create($row["tgl_dok"]);
            $datebuku = date_create($row["tgl_buku"]);
            // $hslnobukti = $row["no_bukti"];
            $satkertujuan = $row["nm_satker_msk"];
            $hsljenistrans = $row["jns_trans"];
            $hsltgldok = date_format($datedok,"d-m-Y");
            $hsltglbuku = date_format($datebuku,"d-m-Y");
            $hslsatker = $row["nm_satker"];
            $hsltottrans = $row["total_harga"];
            $hslket = $row["keterangan"];
            if($hsltottrans=="")
            {
                $hsltottrans=0;
            }
            else
            {
                $hsltottrans = abs($row["total_harga"]);
            }
            echo json_encode(array("satkertujuan"=>$satkertujuan,"jenistrans"=>$hsljenistrans,"tgldok"=>$hsltgldok,"tglbuku"=>$hsltglbuku,"satker"=>$hslsatker,"total"=>number_format($hsltottrans,2,",","."),"keterangan"=>$hslket));
        }
    }

    public function readidenttempitem($data=null)
    {
        if (empty($data)) {
            $query = "SELECT * FROM temp_import_masuk WHERE user_id = '$_SESSION[username]' ORDER BY no_dok, nm_brg ASC LIMIT 1";
        }
        $result = $this->query($query);
        if ($row = $this->fetch_assoc($result))
        {
            $datedok = date_create($row["tgl_dok"]);
            $datebuku = date_create($row["tgl_buku"]);
            $keterangan = $row["keterangan"];
            $jenistrans = $row["jns_trans"];
            $satker = $row["nm_satker"];
            $kdruang = $row["kd_ruang"];
            $nodok = $row["no_dok"];
            $tgldok = date_format($datedok,"d-m-Y");
            $tglbuku = date_format($datebuku,"d-m-Y");
            echo json_encode(array("keterangan"=>$keterangan,"jenistrans"=>$jenistrans,"satker"=>$satker,"kdruang"=>$kdruang,"nodok"=>$nodok,"tgldok"=>$tgldok,"tglbuku"=>$tglbuku));
        }
    }

    public function readidenttempitemklr($data=null)
    {
        if (empty($data)) {
            $query = "SELECT * FROM temp_import_keluar WHERE user_id = '$_SESSION[username]' ORDER BY no_dok, nm_brg ASC LIMIT 1";
        }
        $result = $this->query($query);
        if ($row = $this->fetch_assoc($result))
        {
            $datedok = date_create($row["tgl_dok"]);
            $datebuku = date_create($row["tgl_buku"]);
            $keterangan = $row["keterangan"];
            $jenistrans = $row["jns_trans"];
            $satker = $row["nm_satker"];
            $kdruang = $row["kd_ruang"];
            $nodok = $row["no_dok"];
            $tgldok = date_format($datedok,"d-m-Y");
            $tglbuku = date_format($datebuku,"d-m-Y");
            echo json_encode(array("keterangan"=>$keterangan,"jenistrans"=>$jenistrans,"satker"=>$satker,"kdruang"=>$kdruang,"nodok"=>$nodok,"tgldok"=>$tgldok,"tglbuku"=>$tglbuku));
        }
    }

    public function baca_persediaan_masuk($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $kd_ruang = $data['kd_ruang'];
        $thn_ang = $data['thn_ang'];
        $str = $kd_lokasi;
        $q_ruang="";
        if($kd_ruang!=""){
            $q_ruang = " and kd_ruang='$kd_ruang' ";
        }
        $query = "select kd_brg, nm_brg, spesifikasi FROM transaksi_masuk where kd_lokasi = '$kd_lokasi'  and thn_ang = '$thn_ang' and kd_brg!='' ".$q_ruang." GROUP BY kd_brg ORDER BY nm_brg ASC ";

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
        $kd_satker = $data['kd_lokasi'].$data['kd_ruang'];
        $query_brg = "select satuan from persediaan where kd_brg = '$kd_brg' ";
        // $result_brg = $this->query($query_brg);
        $result_satker = $this->query("select * from transaksi_masuk where kd_brg = '$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' limit 1 ");

        if($this->num_rows($result_satker)==1)
        {
            $row_brg = $this->fetch_array($result_satker);
            echo '<option value="'.$row_brg['satuan'].'">'.$row_brg['satuan']."</option>";

        }
        else{
            $result_brg = $this->query("SELECT DISTINCT satuan from satuan");
            // $row_brg = $this->fetch_array($result_brg);
            // echo json_encode(array("satuan"=>$row_brg["satuan"]));
            echo '<option value="">'."Pilih Satuan"."</option>";
             while ($row_brg = $this->fetch_array($result_brg))
            {
                echo '<option value="'.$row_brg['satuan'].'">'.$row_brg['satuan']."</option>";
            }


        }
        // echo '<input type="hidden" name="nm_brg" value="'.$row_brg['nm_brg'].'">';
        // echo '<input type="hidden" name="satuan" value="'.$row_brg['satuan'].'">';
        // echo $row_brg['nm_brg'].'  '.$row_brg['satuan'];

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

    public function sisa_barang($data,$jenis)
    {
        $nama_tbl="";

        $kd_lokasi = $data['kd_lokasi'];
        $kd_ruang = trim($data['kd_ruang']);
        $kd_brg = $data['kd_brg'];
        $thn_ang = $data['thn_ang'];
        $no_dok = $data['no_dok'];
        $kd_satker = $kd_lokasi.$kd_ruang;
        $q_ruang;

        if($jenis==1){
            $nama_tbl="transaksi_keluar";
        }
        else{
            $nama_tbl="transfer";
        }

        if($kd_ruang!=""){ $q_ruang=" and kd_ruang='$kd_ruang' "; } else{ $q_ruang=" and (kd_ruang is null or kd_ruang='') "; }
        $query_tgl = "SELECT tgl_dok FROM ".$nama_tbl."  
                      WHERE 
                      no_dok='$no_dok' AND 
                      concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$kd_satker' AND 
                      thn_ang='$thn_ang'
                      limit 1 ";
        // print_r($query_tgl);
        $result_tgl = $this->query($query_tgl);
        $tgl_brg = $this->fetch_array($result_tgl);
        $tgl_dok = $tgl_brg['tgl_dok'];

        $query = "select sum(qty_akhir) as sisa,satuan from transaksi_masuk  where kd_brg = '$kd_brg' and concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$kd_satker' and tgl_dok<='$tgl_dok' and thn_ang='$thn_ang' ";
        // echo $query;
        $result = $this->query($query);
        $sisa_brg = $this->fetch_array($result);

        $saldo = $sisa_brg["sisa"];

        if(empty($saldo))
        {
            $saldo = 0;
        }




        echo json_encode(array("sisa"=>$saldo, "satuan"=>$sisa_brg["satuan"]));

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

        $query_perk = "SELECT kd_brg, nm_sskel, kd_perk, nm_perk, nm_brg from persediaan where kd_brg='$kd_brg' ";
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
