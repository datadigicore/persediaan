<?php
include('../../utility/mysql_db.php');
define('_MPDF_PATH','../../plugins/mPDF/');
require(_MPDF_PATH."mpdf.php");

class modelReport extends mysql_db
{
    public function bacabrg($data)
    {
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $query = "select kd_brg, nm_brg FROM transaksi_masuk where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' and kd_brg not like '' GROUP BY kd_brg ORDER BY nm_brg ASC ";
        $result = $this->query($query);
        echo '<option value="">-- Pilih Kode Barang --</option>';
        echo '<option value="all">Semua Barang</option>';
        while ($row = $this->fetch_array($result))
        {
            echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_brg']."</option>";
        }   
    }

    public function baca_satker($kd_lokasi)
    {
        $query = "select kode, NamaSatker from satker where kode like '{$kd_lokasi}%' order by kode asc";
        $result = $this->query($query);
        // echo '<option value="">-- Pilih Kode Satker --</option>';

        while ($row = $this->fetch_array($result))
        {
            // $str = $row['kode'];
            // if (substr_count($str,".") == 3) {
            echo '<option value="'.$row['kode'].'">'.$row['kode'].'        '.$row['NamaSatker']."</option>";
             // }
        } 
    }

    public function baca_satker_admin($kd_lokasi)
    {
        $query = "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%'  order by kode asc";
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

    public function baca_upb_admin($kd_lokasi)
    {
        $query = "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and char_length(kode)=11  order by kode asc";
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

    public function baca_upb($kd_lokasi)
    {

        $query = "select kode, NamaSatker from satker where kode like '$kd_lokasi%' and char_length(kode)=11 order by kode asc";
        $result = $this->query($query);
        $json = array();
        while ($row = $this->fetch_array($result))
        {
            // $str = $row['kode'];
            // if (substr_count($str,".") == 3) {
            echo '<option value="'.$row['kode'].'">'.$row['kode'].'        '.$row['NamaSatker']."</option>";
             // }
        } 
    }

    public function query_brg($kd_brg,$kd_lokasi){
        $where = "";
        if($kd_brg!=="all"){
            $where = " and kd_brg='$kd_brg' ";
        }
        $list_brg = "SELECT kd_brg from transaksi_masuk where kd_lokasi='$kd_lokasi' ".$where." group by kd_brg";
        $kode = $this->query($list_brg);
        return $kode;
    }

    public function buku_persediaan($data)
    {
        
        // $mpdf->setFooter('{PAGENO}');
        ob_start(); 
        $jenis = $data['jenis'];
        $kd_brg = $data['kd_brg'];
        $kd_lokasi = $data['kd_lokasi'];
        $satker_asal = $data['kd_lokasi'];
        $format = $data['format'];

        $hasil = $this->query_brg($kd_brg,$kd_lokasi);
        while($kode_brg=$this->fetch_array($hasil)) 
        {
            $this->cetak_header($data,"buku_persediaan",$kd_lokasi,$kode_brg['kd_brg'],"");
            $this->get_query($data,"buku_persediaan",$kd_lokasi,$kode_brg['kd_brg'],"","");
            echo '<pagebreak />';
            // $this->cetak_nama_pj($satker_asal);
        }
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        if($format=="excel") 
        {
            $this->excel_export($html,"KartuPersediaan");
        }
        else {

            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("buku_persediaan.pdf" ,'I');
            exit;
            }
         }


    public function laporan_persediaan($data_lp)
    {
        
        ob_start(); 

        $format = $data_lp['format'];
        $thn_ang = $data_lp['thn_ang'];
        $kd_lokasi = $data_lp['kd_lokasi'];
        $date = $this->cek_periode($data_lp);
        $satker_asal = $data_lp['satker_asal'];
        $no_urut = 0;
        $this->cetak_header($data_lp,"laporan_persediaan",$kd_lokasi,"",$no);
        $query = "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and char_length(kode)=11 order by kode asc";
        $result = $this->query($query);
                
        while($kdsatker=$this->fetch_assoc($result))
        { 
          $no_urut++;
          $kd_lokasi2=$kdsatker['kode'];
          $nm_satker=$kdsatker['NamaSatker'];
          $this->get_query($data_lp,"laporan_persediaan",$kd_lokasi2,"",$nm_satker,$no_urut);
        }
        echo '</table>';            
        $this->cetak_nama_pj($satker_asal);

        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        if($format=="excel"){
            $this->excel_export($html,"Lap_persediaan");
        }
        else {

            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->setFooter('{PAGENO}');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("Lap_persediaan.pdf" ,'I');
            exit;
        }

    }    

    public function rincian_persediaan($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start();
        $thn_ang = $data['thn_ang'];
        $jenis = $data['jenis'];
        $bln_awal = $data['bln_awal'];
        $bln_akhir = $data['bln_akhir'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $thn_ang_lalu = intval($thn_ang)-1;
        $kd_brg = $data['kd_brg'];
        $kd_lokasi = $data['kd_lokasi'];
        $satker_asal = $data['satker_asal'];

        //echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
        $this->getsatker($kd_lokasi);
        $date = $this->cek_periode($data);

        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN RINCIAN BARANG PERSEDIAAN</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                <br></br>

                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    <td rowspan="2" style="font-weight:bold;">KODE BARANG</td>
                    <td  width="30%" rowspan="2" style="font-weight:bold;" >URAIAN</td>
                    <td  width="20%" colspan="2" style="font-weight:bold;"  >SALDO AWAL PER 1 JANUARI '.$thn_ang.'</td>
                    <td colspan="3" style="font-weight:bold;">MUTASI</td>
                    <td colspan="2" style="font-weight:bold;">NILAI</td>
                    <tr>
                        <td>JUMLAH</td>
                        <td>RUPIAH</td>
                        <td style="font-size:95%; ">TAMBAH</td>
                        <td style="font-size:95%;">KURANG</td>
                        <td style="font-size:95%;">JUMLAH</td>
                        <td style="font-size:95%;">JUMLAH</td>
                        <td style="font-size:95%;">RUPIAH</td>
                    </tr> 
                </tr>';
                if($jenis=="semester")
                {
                $sql="SELECT kd_perk, nm_perk, kd_brg, nm_brg, 
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir' and thn_ang='$thn_ang' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty>=0 and month(tgl_dok) < '$bln_awal' and thn_ang='$thn_ang' THEN qty else 0 end) as masuk0, 
                                    sum(case WHEN qty<0 and month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir' and thn_ang='$thn_ang' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty<0 and month(tgl_dok) < '$bln_awal'  and thn_ang='$thn_ang' THEN qty else 0 end) as keluar0,
                                    sum(case WHEN qty>=0 and month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir' and thn_ang='$thn_ang' THEN total_harga else 0 end) + 
                                    sum(case WHEN qty<0 and month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir' and thn_ang='$thn_ang' THEN total_harga else 0 end) as nilai, 
                                    sum(case WHEN qty>=0 and month(tgl_dok) < '$bln_awal' and thn_ang='$thn_ang' THEN total_harga else 0 end) + 
                                    sum(case WHEN qty<0 and month(tgl_dok) < '$bln_awal'  and thn_ang='$thn_ang' THEN total_harga else 0 end) as nilai0 
                                    FROM (
                                    SELECT thn_ang,tgl_dok,  kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang,tgl_dok,  kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where  kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                elseif($jenis=="tanggal")
                {
                $sql="SELECT kd_perk, nm_perk, kd_brg, nm_brg, 
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and tgl_dok >= '$tgl_awal' AND tgl_dok < '$tgl_akhir' and thn_ang='$thn_ang' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty>=0 and tgl_dok < '$tgl_awal' and thn_ang='$thn_ang' THEN qty else 0 end) as masuk0, 

                                    sum(case WHEN qty<0 and tgl_dok >= '$tgl_awal' AND tgl_dok < '$tgl_akhir' and thn_ang='$thn_ang' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty<0 and tgl_dok < '$tgl_awal' and thn_ang='$thn_ang' THEN qty else 0 end) as keluar0,

                                    sum(case WHEN qty>=0 and tgl_dok >= '$tgl_awal' AND tgl_dok < '$tgl_akhir' and thn_ang='$thn_ang' THEN total_harga else 0 end) + sum(case WHEN qty<0 and tgl_dok > '$tgl_awal' AND tgl_dok < '$tgl_akhir' and thn_ang='$thn_ang' THEN total_harga else 0 end) as nilai, 
                                    sum(case WHEN qty>=0 and tgl_dok < '$tgl_awal' and thn_ang='$thn_ang' THEN total_harga else 0 end) + sum(case WHEN qty<0 and tgl_dok < '$tgl_awal' and thn_ang='$thn_ang'  THEN total_harga else 0 end) as nilai0 

                                    FROM (
                                    SELECT thn_ang,tgl_dok, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang,tgl_dok, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where   kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                else
                {
                $sql="SELECT kd_perk, nm_perk, kd_brg, nm_brg, spesifikasi,
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and thn_ang='$thn_ang' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty<0 and thn_ang='$thn_ang' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty>=0 and thn_ang='$thn_ang' THEN total_harga else 0 end) + sum(case WHEN qty<0 and thn_ang='$thn_ang' THEN total_harga else 0 end) as nilai 
                                    FROM (
                                    SELECT thn_ang, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where  kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                $no=0;
                $total_thn_lalu=0;
                $total_akumulasi=0;
                $prev_sskel=null;
                $kd_rek=null;
                while($data=$this->fetch_assoc($result))
                {
                    $no+=1;
                    $jumlah = $data[masuk]+$data[keluar]+$data[masuk0]+$data[keluar0];
                    $jml_selisih = $data[brg_thn_lalu]+$data[masuk]+$data[keluar]+$data[masuk0]+$data[keluar0];
                    $hrg_selisih = $data[hrg_thn_lalu]+$data[nilai]+$data[nilai0];
                    $total_thn_lalu+=$data[hrg_thn_lalu];
                    $total_akumulasi+=$hrg_selisih;
                    $jml_msk = $data[masuk]+$data[masuk0];
                    $jml_klr = $data[keluar]+$data[keluar0];
                    
                    
                    if($kd_rek!=substr($data[kd_perk],0, 5))
                    {
                        echo '<tr>
                                <td align="right" style="font-size:90%; background-color:#DEDEDE;"><b>'.substr($data[kd_perk],0, 5).'</b></td>
                                <td align="left" colspan="8" style="font-size:90%; background-color:#DEDEDE;"><b>'.'Persediaan Bahan Pakai Habis'.'</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                </tr>
                               ';
                        $kd_rek=substr($data[kd_perk],0, 5);
                    }
                    if($prev_perk!=$data[kd_perk])
                    {
                        echo '
                        <tr style="font-size:45%;">
                                <td align="right" style="background-color:#DEDEDE; font-size:90%;"><b>'.$data[kd_perk].'</b></td>
                                <td colspan="8" align="left" style="background-color:#DEDEDE; font-size:90%;"><b>'.$data[nm_perk].'</b></td>
                              </tr> ';
                        $prev_perk=$data[kd_perk];
                    }                    

                    echo '<tr>
                             <td  align="center" style="font-size:90%;">'.$data[kd_brg].'</td> 
                             <td  align="left" style="font-size:90%;">'.$data[nm_brg].' '.$data[spesifikasi].'</td> 
                             <td  align="center" style="font-size:90%;">'.$data[brg_thn_lalu].'</td> 
                             <td  align="right" style="font-size:90%;">'.number_format($data[hrg_thn_lalu],0,",",".").'</td> 
                             <td align="center" style="font-size:90%;">'.$jml_msk.'</td> 
                             <td align="center" style="font-size:90%;">'.abs($jml_klr).'</td> 
                             <td align="center" style="font-size:90%;">'.$jumlah.'</td> 
                             <td align="center" style="font-size:90%;">'.$jml_selisih.'</td> 
                             <td align="right" style="font-size:90%;">'.number_format($hrg_selisih,0,",",".").'</td> 
                        </tr>';
                }
                echo '<tr>
                            <td colspan="2">JUMLAH</td>  
                            <td colspan="2" align="right">'.number_format($total_thn_lalu,0,",",".").'</td> 
                            <td colspan="3"></td>  
                            <td colspan="2" align="right">'.number_format($total_akumulasi,0,",",".").'</td>  
                        </tr>';
                echo '</table>';
                if($no>=6)
                {
                echo '<pagebreak />';
                }
                $this->cetak_nama_pj($satker_asal);

                // $this->hitung_brg_rusak($kd_lokasi);
                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output($nama_dokumen.".pdf" ,'I');
                exit;
         }

        public function rincian_persediaan2($data_lp)
        {
                $mpdf=new mPDF('utf-8', 'A4-L');
                ob_start();

                $kd_brg = $data_lp['kd_brg'];
                $format = $data_lp['format'];
                $kd_lokasi = $data_lp['kd_lokasi'];
                $satker_asal = $data_lp['satker_asal'];
                $no_urut = 0;
                $this->cetak_header($data_lp,"rincian_persediaan2",$kd_lokasi,"",$no);
                $query = "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and char_length(kode)=11 order by kode asc";
                $result = $this->query($query);
                
                while($kdsatker=$this->fetch_assoc($result))
                { 
                  $no_urut++;
                  $kd_lokasi2=$kdsatker['kode'];
                  $nm_satker=$kdsatker['NamaSatker'];
                 
                  $this->get_query($data_lp,"rincian_persediaan2",$kd_lokasi2,"",$nm_satker,$no_urut);
        

                }
                echo '</table>';
                   
                $this->cetak_nama_pj($satker_asal);
                $html = ob_get_contents();
                ob_end_clean();
                if($format=="excel"){
                    $this->excel_export($html,"Mutasi_persediaan");
                }
                else {

                    $mpdf=new mPDF('utf-8', 'A4-L');
                    $mpdf->setFooter('{PAGENO}');
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output("Mutasi_persediaan.pdf" ,'I');
                    exit;
                }

          }    

    public function neraca($data_lp)
    {
       
        $kd_lokasi = $data_lp['kd_lokasi'];
        $satker_asal = $data_lp['satker_asal'];
        $format = $data_lp['format'];
        ob_start(); 
        $this->cetak_header($data_lp,"neraca",$kd_lokasi,"",$no);
        $query = "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and char_length(kode)=11 order by kode asc";
        $result = $this->query($query);         
        while($kdsatker=$this->fetch_assoc($result))
        { 
            $no++;
            $kd_lokasi2=$kdsatker['kode'];
            $nm_satker=$kdsatker['NamaSatker'];
                 
            $this->get_query($data_lp,"neraca",$kd_lokasi2,"",$nm_satker,$no);
                  // echo '<pagebreak />'; 
        }
        echo '</table>';
        $this->cetak_nama_pj($satker_asal);
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        if($format=="excel"){
            $this->excel_export($html,"Neraca");
        }
        else {
            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->setFooter('{PAGENO}');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("Neraca.pdf" ,'I');
            exit;
        }

    }

    public function mutasi_prsedia($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start(); 
        $kd_lokasi = $data['kd_lokasi'];
        $format = $data['format'];
        $satker_asal = $data['satker_asal'];
        $this->cetak_header($data_lp,"mutasi_persediaan",$kd_lokasi,"",$no);

        $query = "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and char_length(kode)=11 order by kode asc";
        $result = $this->query($query);
        $no = 0;
                while($kdsatker=$this->fetch_assoc($result))
                { 
                  $no++;
                  $kd_lokasi2=$kdsatker['kode'];
                  $nm_satker=$kdsatker['NamaSatker'];
                 
                  $this->get_query($data,"mutasi_persediaan",$kd_lokasi2,"",$nm_satker,$no);
                  

                }
                echo '</table>';

                $this->cetak_nama_pj($satker_asal);

                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
        if($format=="excel") 
        {
            $this->excel_export($html,"Mutasi_Persediaan");
        }
        else {

            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("Mutasi_persediaan.pdf" ,'I');
            exit;
            }
         

         }

    public function transaksi_persediaan($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start(); 

        $jenis = $data['jenis'];
        $kd_trans = $data['kd_trans'];
        $nm_trans = $data['nm_trans'];
        $format = $data['format'];
        $thn_ang = $data['thn_ang'];
        $kd_lokasi = $data['kd_lokasi'];

        $this->cetak_header($data_lp,"transaksi_persediaan",$kd_lokasi,"",$no);
        $this->get_query($data,"transaksi_persediaan",$kd_lokasi,"",$nm_satker,"");
       
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        if($format=="excel") {
            $this->excel_export($html,"Transaksi_Persediaan");
        }
        else {
            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("Transaksi_persediaan.pdf" ,'I');
            exit;
        }
    }

    public function l_terima_brg($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        // $mpdf->setFooter('{PAGENO}');
        ob_start(); 
        $jenis = $data['jenis'];
        $kd_lokasi = $data['kd_lokasi'];
        $satker_asal = $data['kd_lokasi'];
        $format = $data['format'];

        $this->cetak_header($data,"penerimaan_brg",$kd_lokasi,"","");
        $this->get_query($data,"penerimaan_brg",$kd_lokasi,"",$nm_satker,"");
        $this->cetak_nama_pj($satker_asal);

        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        if($format=="excel") {
            $this->excel_export($html,"Penerimaan_brg");
        }
        else {
            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("Penerimaan_brg.pdf" ,'I');
            exit;
        }

    }

    public function l_keluar_brg($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        // $mpdf->setFooter('{PAGENO}');
        ob_start(); 
        $jenis = $data['jenis'];
        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bulan = $data['bulan'];
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $satker_asal = $data['kd_lokasi'];
        $format = $data['format'];

        $this->cetak_header($data,"pengeluaran_brg",$kd_lokasi,"","");
        $this->get_query($data,"pengeluaran_brg",$kd_lokasi,"",$nm_satker,"");
        $this->cetak_nama_pj($satker_asal);
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        if($format=="excel") {
            $this->excel_export($html,"Pengeluaran_brg");
        }
        else {
            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("Pengeluaran_brg.pdf" ,'I');
            exit;
        }                

    }


    public function buku_bph($data)
    {
        // $mpdf->setFooter('{PAGENO}');
        ob_start(); 
        $jenis = $data['jenis'];
        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bulan = $data['bulan'];
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $satker_asal = $data['kd_lokasi'];
        $format = $data['format'];
        
        $this->cetak_header($data,"buku_brg_pakai_habis",$kd_lokasi,"","");
        $this->get_query($data,"buku_brg_pakai_habis",$kd_lokasi,"",$nm_satker,"");       
        $this->cetak_nama_pj($satker_asal);

        $html = ob_get_contents(); 
        ob_end_clean();
        if($format=="excel") {
            $this->excel_export($html,"Buku_brg_pakai_hbs");
        }
        else {
            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("Buku_brg_pakai_hbs.pdf" ,'I');
            exit;
        }  
    }


   
    public function kartu_barang($data)
    {
        $mpdf=new mPDF('utf-8', 'A4');
        // $mpdf->setFooter('{PAGENO}');
        ob_start(); 
        $jenis = $data['jenis'];
        $kd_brg = $data['kd_brg'];
        $kd_lokasi = $data['kd_lokasi'];
        $satker_asal = $data['satker_asal'];
        $format = $data['format'];

        $hasil = $this->query_brg($kd_brg,$kd_lokasi);
        while($kode_brg=$this->fetch_array($hasil)) 
        {
            $this->cetak_header($data,"kartu_brg",$kd_lokasi,$kode_brg['kd_brg'],"");
            $this->get_query($data,"kartu_brg",$kd_lokasi,$kode_brg['kd_brg'],$nm_satker,"");
            echo '<pagebreak />';
        }
        $html = ob_get_contents(); 
        ob_end_clean();
        if($format=="excel") {
            $this->excel_export($html,"kartu_barang");
        }
        else {
            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("kartu_barang.pdf" ,'I');
            exit;
        }          
                
         }

    public function kartu_p_barang($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        // $mpdf->setFooter('{PAGENO}');
        ob_start(); 
        $jenis = $data['jenis'];
        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bulan = $data['bulan'];
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $satker_asal = $data['satker_asal'];
        
        $hasil = $this->query_brg($kd_brg,$kd_lokasi);
        while($kode_brg=$this->fetch_array($hasil)) 
        {
            $this->cetak_header($data,"kartu_p_brg",$kd_lokasi,$kode_brg['kd_brg'],"");
            $this->get_query($data,"kartu_p_brg",$kd_lokasi,$kode_brg['kd_brg'],$nm_satker,"");
            echo '<pagebreak />';  
        }

                $this->cetak_nama_pj($satker_asal);

                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output("buku_persediaan.pdf" ,'I');
                exit;
         }

    public function l_pp_bph($data)
    {

        

        $jenis = $data['jenis'];
        $thn_ang = $data['thn_ang'];
        $kd_lokasi = $data['kd_lokasi'];
        $date = $this->cek_periode($data);
        $satker_asal = $data['satker_asal'];

        ob_start(); 
        $this->cetak_header($data,"pp_brg_pakai_habis",$kd_lokasi,"","");
        $this->get_query($data,"pp_brg_pakai_habis",$kd_lokasi,"",$nm_satker,"");
        $mpdf=new mPDF('utf-8', 'A4-L');
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean(); 
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("pp_bph.pdf" ,'I');
        exit;

    }

    public function cetak_header($data,$nm_lap,$kd_lokasi,$kd_brg, $inc){
            // $kd_lokasi = $data['kd_lokasi'];
            $thn_ang = $data['thn_ang'];
            
            if($nm_lap=="buku_persediaan"){
                $detail_brg = "SELECT nm_brg, satuan from persediaan where  kd_brg like '$kd_brg' ";
                $result_detail = $this->query($detail_brg);
                $brg = $this->fetch_array($result_detail);
                //echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
                $this->getsatker($kd_lokasi);
                
                echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">KARTU PERSEDIAAN</p>
                        <br></br>
                        <table style="text-align: center; width: 100%; font-size:90%;" align="left" >
                        <tr>
                            <td width="75%" align="left"></td>
                            <td align="left">Kode Barang :'.$kd_brg.'</td>
                        </tr>                
                        <tr>
                            <td width="75%" align="left"></td>
                            <td align="left">Nama Barang :'.$brg['nm_brg'].'</td>
                        </tr>                
                        <tr>
                            <td width="75%" align="left"></td>
                            <td align="left">Satuan :'.$brg['satuan'].'</td>
                        </tr>
                        </table>
                        <table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:90% " border=1 align="center">
                        <tr >
                            <td rowspan="2" style="font-weight:bold;" >NO</td>
                            <td  rowspan="2" style="font-weight:bold;">TANGGAL</td>
                            <td width="18%" rowspan="2" style="font-weight:bold;">URAIAN</td>
                            <td rowspan="2" style="font-weight:bold;">MASUK</td>
                            <td rowspan="2" style="font-weight:bold;">HARGA BELI</td>
                            <td  rowspan="2" style="font-weight:bold;">KELUAR</td>
                            <td colspan="2" style="font-weight:bold;">SALDO</td>
                            <tr>
                                <td style="font-weight:bold;">JUMLAH</td>
                                <td style="font-weight:bold;">NILAI</td>
                            </tr>
                        </tr>';          
            }
            elseif($nm_lap=="laporan_persediaan"){
              //echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
              $this->getsatker($kd_lokasi);
              echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN PERSEDIAAN BARANG</p>
                    <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
                    <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                    <br></br>  
                      <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                      <tr>
                          
                          <td width="5%"><b>NO</b></td>
                          <td width="10%"><b>KODE REKENING</b></td>
                          <td width="50%"><b>URAIAN</b></td>
                          <td><b>NILAI</b></td>
                      </tr>';

          }   
          elseif($nm_lap=="rincian_persediaan2"){
    
              $date = $this->cek_periode($data);
            
              echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:1em; "  align="center">
                        <tr>
                            <td rowspan="3" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
                            <td width="100%" style= "vertical-align: bottom;">LAPORAN MUTASI PERSEDIAAN</td>
                        </tr>
                        <tr>
                            <td>UNTUK PERIODE YANG BERAKHIR PADA '.$date.'<td>
                        </tr>
                        <tr>
                            <td>TAHUN ANGGARAN : '.$thn_ang.'</td>
                        </tr>
                      </table>
                    ';
              $this->getsatker($kd_lokasi);
              echo '<table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; " border=1 align="center">';
              echo '<tr>
                            <td rowspan="2" style="font-weight:bold;">NO</td>
                            <td rowspan="2" style="font-weight:bold;">KODE</td>
                            <td  width="35%" rowspan="2" style="font-weight:bold;" >URAIAN</td>
                            <td  width="10%" colspan="2" style="font-weight:bold;"  >SALDO AWAL 1 JANUARI '.$thn_ang.'</td>
                            <td colspan="3" style="font-weight:bold;">MUTASI</td>
                            <td colspan="2" style="font-weight:bold;">NILAI</td>
                            <tr>
                                <td width="7%">JUMLAH</td>
                                <td width="10%">RUPIAH</td>
                                <td style="font-size:90%; ">TAMBAH</td>
                                <td style="font-size:90%;">KURANG</td>
                                <td style="font-size:90%;">JUMLAH</td>
                                <td style="font-size:90%;">JUMLAH</td>
                                <td width="10%" style="font-size:90%;">RUPIAH</td>
                            </tr> 
                        </tr>';
          }
          elseif($nm_lap=="neraca"){
              //echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
              $this->getsatker($kd_lokasi);
              $date = $this->cek_periode($data);
              echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN POSISI PERSEDIAAN DI NERACA</p>
                    <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
                    <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                    <br></br>  
                      <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                      <tr>
                          
                          <td width="5%"><b>NO</b></td>
                          <td width="10%"><b>KODE REKENING</b></td>
                          <td width="50%"><b>URAIAN</b></td>
                          <td><b>NILAI</b></td>
                      </tr>';

        }
        elseif($nm_lap=="mutasi_persediaan"){
                $date = $this->cek_periode($data);
                
                echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:1em; "  align="center">
                        <tr>
                            <td rowspan="3" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
                            <td width="100%" style= "vertical-align: bottom;">LAPORAN MUTASI PERSEDIAAN</td>
                        </tr>
                        <tr>
                            <td>UNTUK PERIODE YANG BERAKHIR PADA '.$date.'<td>
                        </tr>
                        <tr>
                            <td>TAHUN ANGGARAN : '.$thn_ang.'</td>
                        </tr>
                      </table>
                    ';
            $this->getsatker($kd_lokasi);
            echo  '<table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                    <tr>
                        <td rowspan="2" style="font-weight:bold;">NO</td>
                        <td rowspan="2">KODE</td>
                        <td  width="30%" rowspan="2"  >URAIAN</td>
                        <td  width="12%" rowspan="2"  >SALDO 1 JANUARI '.$thn_ang.'</td>
                        <td colspan="2">MUTASI</td>
                        <td rowspan="2" width="13%">NILAI S/D '.$date.'</td>
                        <tr>
                            <td>Tambah</td>
                            <td>Kurang</td>
                        </tr> 
                    </tr>';

        }
        elseif($nm_lap=="transaksi_persediaan"){
            //echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
            echo ' 
                    <table style="text-align: center; width: 90%; " align="center">
                    <tr>
                        <td>DAFTAR TRANSAKSI PERSEDIAAN</td>
                    </tr>
                    <tr>
                        
                    </tr>
                    <tr>
                        <td>TAHUN ANGGARAN : '.$thn_ang.'</td>
                    </tr>
                 
                     <tr>
                        <td width="90%" align="left">JENIS TRANSAKSI : '.$nm_trans.'</td>
                    </tr>

                    </table>
                    <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 90%;" border=1 align="center">
                    <tr>
                        <td width="18%"><b>KODE</b></td>
                        <td width="40%"><b>URAIAN</b></td>
                        <td><b>KUANTITAS</b></td>
                        <td><b>RUPIAH</b></td>
                    </tr>';

        }
        elseif($nm_lap=="penerimaan_brg"){
           echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.9em; "  align="center">
                    <tr>
                        <td rowspan="2" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
                        <td style= "vertical-align: centers;"></td>
                    </tr>
                    <tr>
                        <td style= "vertical-align: centers;">BUKU PENERIMAAN BARANG</td>
                    </tr>
                    </table>';
            $this->getsatker($kd_lokasi);
            echo '<table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:90%; " border=1 align="center">
                    <tr >
                        <td rowspan="2" >No</td>
                        <td rowspan="2" >Tanggal</td>
                        <td rowspan="2" >Dari</td>
                        <td colspan="2" >Dokumen Faktur</td>
                        <td rowspan="2" >Nama Barang</td>
                        <td rowspan="2" >Banyaknya</td>
                        <td rowspan="2" width="10%" >Harga Satuan</td>
                        <td rowspan="2" width="10%" >Jumlah Harga</td>
                        <td colspan="2" >B.A Penerimaan</td>
                        <td rowspan="2" >Ket</td>
                    </tr>
                    <tr>
                        <td>Nomor</td>
                        <td>Tanggal</td>
                        <td>Nomor</td>
                        <td>Tanggal</td>
                    </tr>';
                $this->label_nomor(12);

        }
        elseif($nm_lap=="pengeluaran_brg"){
            echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.9em; "  align="center">
                    <tr>
                        <td rowspan="2" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
                        <td style= "vertical-align: centers;"></td>
                    </tr>
                    <tr>
                        <td style= "vertical-align: centers;">BUKU PENGELUARAN BARANG</td>
                    </tr>

                    </table>

                    ';  
            $this->getsatker($kd_lokasi);
            
            echo '   
                    <table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:90% " border=1 align="center">
                    <tr >
                        <td >No</td>
                        <td >Tanggal</td>

                        <td width="5%" >Nomor Urut</td>
                        <td width="25%" >Nama Barang</td>
                        <td >Banyaknya</td>
                        <td >Harga Satuan</td>
                        <td >Jumlah Harga</td>
                        <td >Untuk</td>
                        <td >Tanggal Penyerahan</td>
                        <td >Ket</td>
                    </tr>';
            $this->label_nomor(10);
        }
        elseif($nm_lap=="buku_brg_pakai_habis"){   
            echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.9em; "  align="center">
                    <tr>
                        <td rowspan="2" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
                        <td style= "vertical-align: centers;"></td>
                    </tr>
                    <tr>
                        <td style= "vertical-align: centers;">BUKU BARANG PAKAI HABIS</td>
                    </tr>

                    </table>

                    ';   
            $this->getsatker($kd_lokasi);               
           
            echo  '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:90% " border=1 align="center">
                   <tr>
                        <td rowspan="2" colspan="9">PENERIMAAN</td>
                        <td rowspan="2" colspan="5">PENGELUARAN</td>
                         <tr>
                        
                    </tr>
                        </tr>


                        <tr>
                        <tr >
                            <td rowspan="2"  >No</td>
                            <td  rowspan="2" >Tanggal Diterima</td>
                            <td rowspan="2" >Jenis/Nama Barang</td>
                            <td rowspan="2" >Merk/Ukuran</td>
                            <td rowspan="2" >Tahun Pembuatan</td>
                            <td  rowspan="2" >Jumlah Satuan / Barang</td>
                            <td  rowspan="2" >Harga Satuan</td>
                            <td colspan="2"  >Berita Acara Pemeriksaan</td>
                            <td rowspan="2">Tanggal Dikeluarkan</td>
                            <td rowspan="2">Diserahkan Kepada</td>
                            <td rowspan="2">Jumlah Satuan/Barang</td>
                            <td rowspan="2">Tgl/No. Surat Penyerahan</td>
                            <td rowspan="2">Ket.</td>
                            <tr>
                                <td >Tanggal</td>
                                <td >Nomor</td>
                            </tr>';
                        $this->label_nomor(14);       
        }
        elseif($nm_lap=="kartu_brg"){
            $detail_brg = "SELECT nm_sskel, nm_brg, satuan,spesifikasi from persediaan where  kd_brg='$kd_brg' ";
            $result_detail = $this->query($detail_brg);
            $brg = $this->fetch_array($result_detail);
            echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.9em; "  align="center">
                    <tr>
                        <td rowspan="2" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="9%" /></td>
                        <td style= "vertical-align: centers;">KARTU BARANG</td>
                    </tr>
                    <tr>
                        <td style= "vertical-align: top;"> </td>
                    </tr>

                    </table>

                    ';   
        
            $this->getsatker($kd_lokasi);
            
            echo '  <table style="width: 100%; font-size:90%;"  >               
                    <tr>
                        <td align="left">Nama Barang :'.$brg['nm_brg'].'</td>
                    </tr>                
                    <tr>
                       
                        <td align="left">Satuan :'.$brg['satuan'].'</td>
                        <td align="right">Spesifikasi :'.$brg['spesifikasi'].'</td>
                    </tr>
                    </table>
                    <table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:90% " border=1 align="center">
                    <tr >
                        <td>NO</td>
                        <td>TANGGAL</td>
                        <td>MASUK</td>
                        <td>KELUAR</td>
                        <td>SISA</td>
                        <td>KETERANGAN</td>
                    </tr>';
                    $this->label_nomor(6);
        
        }       
        elseif($nm_lap=="kartu_p_brg"){
            echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.9em; "  align="center">
                            <tr>
                                <td rowspan="2" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
                                <td style= "vertical-align: centers;">KARTU PERSEDIAAN BARANG</td>
                            </tr>
                            <tr>
                                <td style= "vertical-align: top;"> </td>
                            </tr>

                            </table>

                            ';   
                    $this->getsatker($kd_lokasi);
                    $detail_brg = "SELECT nm_sskel, nm_brg, satuan,spesifikasi from persediaan where  kd_brg='$kd_brg' ";
                    $result_detail = $this->query($detail_brg);
                    $brg = $this->fetch_array($result_detail);
                    echo '        <table style=" width: 100%; font-size:90%;"  >               
                            <tr>
                                <td align="left">Gudang :'.'............'.'</td>
                            </tr>                   
                            <tr>
                                <td align="left">Nama Barang :'.$brg['nm_brg'].'</td>
                                <td align="right">Kartu No: '.'............'.'</td>
                            </tr>                
                            <tr>
                               
                                <td align="left">Satuan :'.$brg['satuan'].'</td>
                                <td align="right">Spesifikasi :'.$brg['spesifikasi'].'</td>
                            </tr>
                            </table>';
                        echo    '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:90% " border=1 align="center">
                                <tr>
                                    <td rowspan="2">No</td>
                                    <td rowspan="2" width="10%">No./Tgl Surat Dasar Penerimaan / Pengeluaran</td>
                                    <td rowspan="2" >Uraian</td>
                                    <td colspan="3" >Barang-barang</td>
                                    <td <td rowspan="2" >Uraian</td>>Harga Satuan</td>
                                    <td colspan="3" >Jumlah Harga Barang yg Diterima/Yang Dikeluarkan/Sisa</td>
                                    <td rowspan="2">Ket</td>
                                </tr>
                                <tr>
                                    <td>Masuk</td>
                                    <td>Keluar</td>
                                    <td>Sisa</td>
                                    <td>Bertambah</td>
                                    <td>Berkurang</td>
                                    <td>Sisa</td>
                                </tr>
                            ';
                            $this->label_nomor(11);
        
         
        }
        elseif($nm_lap=="pp_brg_pakai_habis"){
            echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.9em; "  align="center">
                <tr>
                    <td rowspan="2" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
                    <td style= "vertical-align: bottom;">LAPORAN SEMESTER TTG PENERIMAAN DAN PENGELUARAN BARANG PAKAI HABIS</td>
                </tr>
                <tr>
                    <td style= "vertical-align: top;">SEMESTER '.'..... TAHUN '.$thn_ang.'</td>
                </tr>

                </table>
                ';   
            $this->getsatker($kd_lokasi);
            echo '<table style="text-align:center;  white-space: nowrap; border-collapse: collapse; margin-left: word-break:break-all; auto; margin-right: auto; width: 100%; font-size:80%;" border=1 align="center" >
                        <tr>
                            <td rowspan="3" >NO</td>
                            <td rowspan="3">Terima tgl</td>
                            <td rowspan="3">Dari</td>
                            <td colspan="2">Dokumen Faktur</td>
                            <td colspan="2">Dasar Penerimaan</td>
                            <td rowspan="3">Banyaknya</td>
                            <td rowspan="3">Nama Barang</td>
                            <td rowspan="3">Harga Satuan</td>
                            <td colspan="2">Buku Penerimaan</td>
                            <td rowspan="3">Ket.</td>
                            <td rowspan="3">No.Urut</td>
                            <td rowspan="3">Terima Tgl</td>
                            <td colspan="2">Surat Bon</td>
                            <td rowspan="3">Untuk</td>
                            <td rowspan="3">Banyaknya</td>
                            <td rowspan="3">Nama Brg</td>
                            <td rowspan="3">Harga Satuan</td>
                            <td rowspan="3">Jumlah Harga</td>
                            <td rowspan="3">Tgl Penyerahan</td>
                            <td rowspan="3">Ket</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Nomor</td>
                            <td rowspan="2">Tgl</td>
                            <td rowspan="2">Jenis Surat</td>
                            <td rowspan="2">Nomor</td>
                            <td colspan="2">B.A./Srt Penerimaan</td>
                            <td rowspan="2">No</td>
                            <td rowspan="2">Tgl</td>
                        </tr>
                        <tr>
                            <td>Nomor</td>
                            <td>Tanggal</td>
                        </tr>';
           
                $this->label_nomor(24);

        }
        else{
                echo "masuk else";
            }       
        }

        public function get_query($data,$nm_lap,$kd_lokasi,$kd_brg,$nm_satker,$no_urut){
          
            
            $jenis = $data['jenis'];

            $tgl_awal = $data['tgl_awal'];
            $tgl_akhir = $data['tgl_akhir'];
            $bulan = $data['bulan'];

            $thn_ang = $data['thn_ang'];
            $bln_awal = $data['bln_awal'];
            $bln_akhir = $data['bln_akhir'];
            $kd_trans = $data['kd_trans'];

            if($jenis=="semester"){
            $kriteria = "and month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir' ";
            $sblm_kriteria = "and month(tgl_dok) < '$bln_awal' ";

            }
            elseif($jenis=="tanggal"){
                $kriteria = "and tgl_dok >= '$tgl_awal' AND tgl_dok < '$tgl_akhir' ";
                $sblm_kriteria = "and tgl_dok < '$tgl_awal' ";
            
            }        
            elseif($jenis=="bulan"){
                $kriteria = "and month(tgl_dok)='$bulan'";
                $sblm_kriteria = "and month(tgl_dok)<'$bulan'";
            
            }
            else{
                $kriteria = "";
                $sblm_kriteria = "";
            }
            // echo $kriteria."  ".$sblm_kriteria;

            if($nm_lap=="buku_persediaan"){
                $sql="SELECT id, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where kd_brg='$kd_brg' ".$kriteria." 
                                          and kd_lokasi like '{$kd_lokasi}%' 
                                          AND thn_ang='$thn_ang'
                                    union all 
                                    SELECT id, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_keluar 
                                    where kd_brg='$kd_brg' ".$kriteria." 
                                         and kd_lokasi like '{$kd_lokasi}%'
                                         AND thn_ang='$thn_ang'
                                    ORDER BY tgl_dok ASC,id asc;";
                
            }
            elseif($nm_lap=="laporan_persediaan"){
                // $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, 
                //                   sum(case when ".substr($kriteria, 4)." then total_harga else 0 end) as nilai,
                //                   sum(case when ".substr($sblm_kriteria, 4)." then total_harga else 0 end) as nilai0
                //                  from 
                //                  (SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_masuk
                //                   UNION ALL
                //                   SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_keluar)
                //                   transaksi 
                //                     where   kd_lokasi like '{$kd_lokasi}%'  AND thn_ang='$thn_ang' AND GROUP BY kd_brg";
            $sql= "SELECT kd_perk, nm_perk from transaksi_masuk kd_lokasi where kd_lokasi like '$kd_lokasi%'  and thn_ang='$thn_ang' 
                                  GROUP by kd_brg";
            }   
            elseif($nm_lap=="rincian_persediaan2"){

              $kriteria1 = substr($sblm_kriteria, 5);
                    // $sql="SELECT kd_perk, nm_perk, kd_brg, nm_brg, 
                    //         sum(case WHEN jns_trans='M01' THEN qty else 0 end) as brg_thn_lalu,  
                    //         sum(case WHEN jns_trans='M01' THEN total_harga else 0 end) as hrg_thn_lalu,  

                    //         sum(case WHEN qty>=0 ".$kriteria." and jns_trans!='M01'  THEN qty else 0 end) as masuk, 
                    //         sum(case WHEN qty>=0 ".$sblm_kriteria." and jns_trans!='M01' THEN qty else 0 end) as masuk0, 

                    //         sum(case WHEN qty<0  ".$kriteria." and jns_trans!='M01'  THEN qty else 0 end) as keluar,
                    //         sum(case WHEN qty<0  ".$sblm_kriteria." and jns_trans!='M01' THEN qty else 0 end) as keluar0,

                    //         sum(case WHEN qty>=0  ".$kriteria." and jns_trans!='M01'  THEN total_harga else 0 end) + 
                    //         sum(case WHEN qty<0  ".$kriteria." and jns_trans!='M01'  THEN total_harga else 0 end) as nilai, 

                    //         sum(case WHEN qty>=0 ".$sblm_kriteria." and jns_trans!='M01' THEN total_harga else 0 end) + 
                    //         sum(case WHEN qty<0  ".$sblm_kriteria." and jns_trans!='M01' THEN total_harga else 0 end) as nilai0 

                    //         FROM (
                    //                 SELECT thn_ang, jns_trans, tgl_dok, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                    //                 UNION ALL
                    //                 SELECT thn_ang,jns_trans, tgl_dok, kd_brg, nm_brg, spesifikasi, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                    //               ) transaksi
                    //               where   kd_lokasi like '$kd_lokasi%'  and thn_ang='$thn_ang' 
                    //               GROUP by kd_brg";
                        $sql= "SELECT kd_perk, nm_perk from transaksi_masuk where kd_lokasi like '$kd_lokasi%'  and thn_ang='$thn_ang' 
                                  GROUP by kd_brg";
            }
            elseif($nm_lap=="neraca"){
              $sql="SELECT kd_perk, nm_perk, sum(total_harga) as nilai FROM (
                            SELECT tgl_dok, thn_ang, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                UNION ALL
                            SELECT tgl_dok,thn_ang, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                            ) transaksi 
                  where nm_perk not like '' and kd_lokasi like '{$kd_lokasi}%'  and thn_ang='$thn_ang'  and tgl_dok<='$tgl_akhir' GROUP BY kd_perk";

            }
            elseif($nm_lap=="mutasi_persediaan"){
              $sql="SELECT kd_perk, nm_perk,
                             sum(case when jns_trans='M01' THEN total_harga else 0 end) as thn_lalu, 
                             sum(case when total_harga>=0 and jns_trans !='M01' then total_harga else 0 end) as tambah, 
                             sum(case when total_harga<0 and jns_trans !='M01' then total_harga else 0 end) as kurang 
                             FROM
                             (
                             SELECT tgl_dok, thn_ang, kd_perk, nm_perk, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                                UNION ALL
                             SELECT tgl_dok, thn_ang, kd_perk, nm_perk, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                             ) transaksi  
                              where kd_perk not like '' and kd_lokasi like '{$kd_lokasi}%'  and thn_ang='$thn_ang' and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'
                              GROUP BY kd_perk";
            }
            elseif($nm_lap=="transaksi_persediaan"){
              $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(qty) as qty,  sum(total_harga) as harga 
                            from (
                                  SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                                                ) transaksi
                                    where 
                                     kd_lokasi like '{$kd_lokasi}%' ".$kriteria." and
                                     thn_ang='$thn_ang' and
                                     jns_trans='$kd_trans' 
                                     GROUP BY kd_brg";

            }
            elseif($nm_lap=="penerimaan_brg"){
              $sql="SELECT id, tgl_buku, no_dok, tgl_dok, nm_brg, qty, harga_sat,total_harga, tgl_buku, keterangan 
                                FROM transaksi_masuk 
                                where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'  
                                      and kd_lokasi = '$kd_lokasi'   
                                      AND thn_ang='$thn_ang'
                                ORDER BY tgl_dok ASC,id asc";
                   

            }
            elseif($nm_lap=="pengeluaran_brg"){
              $sql="SELECT id, tgl_buku, no_dok, tgl_dok, nm_brg, qty, harga_sat,total_harga, tgl_buku, keterangan 
                                FROM transaksi_keluar 
                                where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'  
                                      and kd_lokasi = '$kd_lokasi'
                                      AND thn_ang='$thn_ang'
                                ORDER BY tgl_dok ASC,id asc";

            }
            elseif($nm_lap=="buku_brg_pakai_habis"){
              $sql="SELECT id, tgl_buku, no_dok, tgl_dok, nm_sskel, nm_brg,  spesifikasi, qty, satuan, harga_sat,total_harga, keterangan 
                                            FROM transaksi_masuk 
                                            where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                            and kd_lokasi = '$kd_lokasi' 
                                            AND thn_ang='$thn_ang'
                    union all
                    SELECT id, tgl_buku, no_dok, tgl_dok, nm_sskel, nm_brg, spesifikasi,  qty, satuan, harga_sat,total_harga, keterangan 
                                            FROM transaksi_keluar 
                                            where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                             and kd_lokasi = '$kd_lokasi'  
                                             AND thn_ang='$thn_ang'

                    ORDER BY tgl_dok ASC,id asc, nm_brg asc;";
                    

            }
            elseif($nm_lap=="kartu_brg"){
                    $sql="SELECT id, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                            FROM transaksi_masuk 
                                where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                    AND kd_brg='$kd_brg' 
                                    and kd_lokasi = '$kd_lokasi' 
                                    AND thn_ang='$thn_ang'
                                union all 
                            SELECT id, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                              FROM transaksi_keluar 
                                where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                    AND kd_brg='$kd_brg' 
                                    and kd_lokasi = '$kd_lokasi'  
                                    AND thn_ang='$thn_ang'
                            ORDER BY tgl_dok ASC,id asc;";

            }   
            elseif($nm_lap=="kartu_p_brg"){
                    $sql="SELECT id, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi ='$kd_lokasi'   
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT id, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi = '$kd_lokasi'   
                                     AND thn_ang='$thn_ang'
                                     ORDER BY tgl_dok ASC,id asc;";

            }
            elseif($nm_lap=="pp_brg_pakai_habis"){
                  $sql="SELECT id, tgl_buku, no_dok, tgl_dok, nm_sskel, nm_brg,  spesifikasi, qty, satuan, untuk, harga_sat,total_harga, keterangan 
                                                    FROM transaksi_masuk 
                                                    where month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir'
                                                     and kd_lokasi = '$kd_lokasi'  
                                                     AND thn_ang='$thn_ang'
                                                union all
                    SELECT id, tgl_buku, no_dok, tgl_dok, nm_sskel, nm_brg, spesifikasi,  qty, satuan, untuk, harga_sat,total_harga, keterangan 
                                                    FROM transaksi_keluar 
                                                    where month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir'
                                                     and kd_lokasi = '$kd_lokasi'  
                                                     AND thn_ang='$thn_ang'

                                                     ORDER BY tgl_dok ASC,id asc, nm_brg asc;";

            }
            else {
              
            }

            $result=$this->query($sql);
            $this->cetak_data($result, $nm_lap,$data,$kd_lokasi,$nm_satker,$no_urut);
            
        }

    public function cetak_data($result,$nm_lap,$data_lp,$kd_lokasi,$nm_satker,$no_urut){

            if($nm_lap=="buku_persediaan"){
                 $no = 0;
                 $jumlah=0;
                 $saldo=0;
                
                while($data=$this->fetch_assoc($result))
                {
                        $no+=1;
                        echo'<tr>
                        <center><td  align="center">'.$no.'</td></center>
                        <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
                        <center><td  align="center">'.$data[keterangan].'</td></center>';
                        if($data[qty]>0) 
                        {
                            echo '<center><td  align="center">'.$data[qty].'</td></center> 
                                    <center><td  align="right">'.number_format($data[harga_sat],0,",",".").'</td></center>
                                    <center><td  align="center">'.'</td></center>';
                        }
                    else 
                        {
                        
                        echo '<center><td  align="center">'.'</td></center>
                                    <center><td  align="right">'.number_format(abs($data[harga_sat]),0,",",".").'</td></center>
                                    <center><td  align="center">'.abs($data[qty]).'</td></center>';
                        }

                        $saldo +=$data[qty]*abs($data[harga_sat]);
                        $jumlah+=$data[qty];
                        echo '<td>'.$jumlah.'</td>
                        <center><td align="right">'.number_format($saldo,0,",",".").'</td></center>
                        </tr>';
                    }
                    echo '</table>';
                }
                elseif($nm_lap=="laporan_persediaan"){
                    $no=0;
                    $jumlah=0;
                    $saldo=0;
                    $prev_sskel=null;
                    $prev_perk=null;
                    $kd_rek=null;

                    $saldo = $this->sum_persedia($data_lp,"117","saldo",$kd_lokasi);
                    echo '<tr>

                          <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut.'</td>
                          <td colspan="3" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$nm_satker.'</td>
                          </tr>';
                    if($saldo!==0){
                                  echo '  <tr>
                                  
                          <td align="right" style="font-size:90%; "></td>
                          <td align="right" style="font-size:90%; "><b>117</b></td>
                          <td align="left" style="font-size:90%; "><b>Persediaan</b></td>
                          <td align="right"  style="font-size:90%; "><b>'.number_format($this->sum_persedia($data_lp,"117","saldo",$kd_lokasi),2,",",".").'</b></td>
                      </tr>';  
                    
           



                    while($data=$this->fetch_array($result))
                    {
                        $no+=1;
                        if($kd_rek!=substr($data[kd_perk],0, 5))
                        {
                            echo '<tr>
                                    <td></td>
                                    <td align="right" style="font-size:90%; ">'.substr($data[kd_perk],0, 5).'</td>
                                    <td  align="left" style="font-size:90%; ">'.$data[nm_perk].'</td>
                                    <td  align="right" style="font-size:90%; ;">'.number_format($this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"saldo",$kd_lokasi),2,",",".").'</td>
                                    <tr>
                                   ';
                            $kd_rek=substr($data[kd_perk],0, 5);
                        }
                        if($prev_perk!=$data[kd_perk])
                        {
                            echo '
                            <tr >
                                    <td align="right" style=" font-size:90%;"></td>
                                    <td align="right" style=" font-size:90%;">'.$data[kd_perk].'</td>
                                    <td  align="left" style=" font-size:90%;">'.$data[nm_perk].'</td>
                                    <td  align="right" style=" font-size:90%;">'.number_format($this->sum_persedia($data_lp,$data[kd_perk],"saldo",$kd_lokasi),2,",",".").'</b></td>
                                  </tr> ';
                            $prev_perk=$data[kd_perk];
                        }                    

                        // if($prev_sskel!=$data[kd_sskel])
                        // {
                            // echo '
                            //         <td align="right" style="font-size:90%;"><b>'.$data[kd_sskel].'</b></td>
                            //         <td colspan="2" align="left" style="font-size:90%;"><b>'.$data[nm_sskel].'</b></td>
                            //        ';
                            // $prev_sskel=$data[kd_sskel];
                        // }

                        // echo '<tr>
                        //          <td  align="right" style="font-size:90%;">'.$data[kd_brg].'</td> 
                        //          <td  align="left" style="font-size:90%;">'.' -'.$data[nm_brg].'</td> 
                        //          <td align="right" style="font-size:90%;">'.number_format($data[nilai]+$data[nilai0],2,",",".").'</td> 
                        //     </tr>';

                        $saldo+=$data[nilai]+$data[nilai0];
                    }
                    // echo '<tr>
                    //         <td colspan="2" style="font-size:90%;">JUMLAH</td>
                    //         <td align="right" style="font-size:90%;">'.number_format($saldo,2,",",".").'</td>
                    //       </tr>';
                    
                    // echo '</table>';
                    // if($no>=6)
                    // {
                    // echo '<pagebreak />';
                    // }
                }
           
        }       
        elseif($nm_lap=="rincian_persediaan2"){
          
            
            $total_thn_lalu=0;
            $total_akumulasi=0;
            $prev_sskel=null;
            $kd_rek=null;
            $skpd=null;

            $qty_SA = $this->sum_persedia($data_lp,"117","qty_SA",$kd_lokasi);
            $hrg_SA = $this->sum_persedia($data_lp,"117","hrg_SA",$kd_lokasi);
            $qty_msk = $this->sum_persedia($data_lp,"117","qty_msk",$kd_lokasi);
            $qty_klr = $this->sum_persedia($data_lp,"117","qty_klr",$kd_lokasi);
            $sisa = $qty_msk - $qty_klr;
            $sisa_acc = $sisa + $qty_SA;

            $saldo = $this->sum_persedia($data_lp,"117","saldo",$kd_lokasi);
            if($qty_msk!==0){
            echo '<tr>
                  <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut.'</td>
                  <td colspan="9" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$nm_satker.'</td>
                  </tr>';
            echo '  <tr>
                      <td align="right" style="font-size:90%; "></td>
                      <td align="right" style="font-size:90%; "><b>117</b></td>
                      <td align="left" style="font-size:90%; "><b>Persediaan</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.$qty_SA.'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.number_format($hrg_SA,2,",",".").'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.$qty_msk.'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.$qty_klr.'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.$sisa.'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.$sisa_acc.'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.number_format($saldo,2,",",".").'</b></td>
                    </tr>';
            while($data=$this->fetch_assoc($result))
            {
                            $no+=1;
                            $jumlah = $data[masuk]+$data[keluar]+$data[masuk0]+$data[keluar0];
                            $jml_selisih = $data[brg_thn_lalu]+$data[masuk]+$data[keluar]+$data[masuk0]+$data[keluar0];
                            $hrg_selisih = $data[hrg_thn_lalu]+$data[nilai]+$data[nilai0];
                            $total_thn_lalu+=$data[hrg_thn_lalu];
                            $total_akumulasi+=$hrg_selisih;
                            $jml_msk = $data[masuk]+$data[masuk0];
                            $jml_klr = $data[keluar]+$data[keluar0];

                        
                            if($kd_rek!=substr($data[kd_perk],0, 5))
                            {
                                $qty_SA = $this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"qty_SA",$kd_lokasi);
                                $hrg_SA = $this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"hrg_SA",$kd_lokasi);
                                $qty_msk = $this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"qty_msk",$kd_lokasi);
                                $qty_klr = $this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"qty_klr",$kd_lokasi);
                                $sisa = $qty_msk - $qty_klr;
                                $sisa_acc = $sisa + $qty_SA;
                                $saldo = $this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"saldo",$kd_lokasi);


                                echo '<tr>
                                        <td align="right" style="font-size:90%; "></td>
                                        <td align="right" style="font-size:90%; "><b>'.substr($data[kd_perk],0, 5).'</b></td>';
                                if(substr($data[kd_perk],0, 5)=="11701"){
                                        echo '<td align="left" style="font-size:90%; "><b>'."Persediaan Bahan Pakai Habis".'</b></td>';
                                    }
                                elseif(substr($data[kd_perk],0, 5)=="11702"){
                                    echo '<td align="left" style="font-size:90%; "><b>'."Persediaan Bahan / Material".'</b></td>';
                                }
                                else{
                                    echo '<td align="left" style="font-size:90%; "><b>'."Persediaan Brang Lainnya".'</b></td>';
                                }
                                echo    '<td align="center"  style="font-size:90%; "><b>'.$qty_SA.'</b></td>
                                        <td align="center"  style="font-size:90%; "><b>'.number_format($hrg_SA,2,",",".").'</b></td>
                                        <td align="center"  style="font-size:90%; "><b>'.$qty_msk.'</b></td>
                                        <td align="center"  style="font-size:90%; "><b>'.$qty_klr.'</b></td>
                                        <td align="center"  style="font-size:90%; "><b>'.$sisa.'</b></td>
                                        <td align="center"  style="font-size:90%; "><b>'.$sisa_acc.'</b></td>
                                        <td align="center"  style="font-size:90%; "><b>'.number_format($saldo,2,",",".").'</b></td>

                                        </tr>
                                       ';
                                $kd_rek=substr($data[kd_perk],0, 5);
                            }
                            if($prev_perk!=$data[kd_perk])
                            {
                                $qty_SA = $this->sum_persedia($data_lp,$data[kd_perk],"qty_SA",$kd_lokasi);
                                $hrg_SA = $this->sum_persedia($data_lp,$data[kd_perk],"hrg_SA",$kd_lokasi);
                                $qty_msk = $this->sum_persedia($data_lp,$data[kd_perk],"qty_msk",$kd_lokasi);
                                $qty_klr = $this->sum_persedia($data_lp,$data[kd_perk],"qty_klr",$kd_lokasi);
                                $sisa = $qty_msk - $qty_klr;
                                $sisa_acc = $sisa + $qty_SA;
                                $saldo = $this->sum_persedia($data_lp,$data[kd_perk],"saldo",$kd_lokasi);
                                echo '
                                <tr style="font-size:45%;">
                                        <td align="right" style="font-size:90%; "></td>
                                        <td align="right" style=" font-size:90%;">'.$data[kd_perk].'</td>
                                        <td  align="left" style=" font-size:90%;">'.$data[nm_perk].'</td>
                                        <td align="right"  style="font-size:90%; ">'.$qty_SA.'</td>
                                        <td align="right"  style="font-size:90%; ">'.number_format($hrg_SA,2,",",".").'</td>
                                        <td align="right"  style="font-size:90%; ">'.$qty_msk.'</td>
                                        <td align="right"  style="font-size:90%; ">'.$qty_klr.'</td>
                                        <td align="right"  style="font-size:90%; ">'.$sisa.'</td>
                                        <td align="right"  style="font-size:90%; ">'.$sisa_acc.'</td>
                                        <td align="right"  style="font-size:90%; ">'.number_format($saldo,2,",",".").'</td>
                                      </tr> ';
                                $prev_perk=$data[kd_perk];
                            }                    

                            // echo '<tr>
                            //          <td  align="center" style="font-size:90%;">'.$data[kd_brg].'</td> 
                            //          <td  align="left" style="font-size:90%;">'.$data[nm_brg].' '.$data[spesifikasi].'</td> 
                            //          <td  align="center" style="font-size:90%;">'.$data[brg_thn_lalu].'</td> 
                            //          <td  align="right" style="font-size:90%;">'.number_format($data[hrg_thn_lalu],2,",",".").'</td> 
                            //          <td align="center" style="font-size:90%;">'.$jml_msk.'</td> 
                            //          <td align="center" style="font-size:90%;">'.abs($jml_klr).'</td> 
                            //          <td align="center" style="font-size:90%;">'.$jumlah.'</td> 
                            //          <td align="center" style="font-size:90%;">'.$jml_selisih.'</td> 
                            //          <td align="right" style="font-size:90%;">'.number_format($hrg_selisih,2,",",".").'</td> 
                            //     </tr>';
                        }
                        // echo '<tr>
                        //             <td></td>
                        //             <td colspan="2">JUMLAH</td>  
                        //             <td colspan="2" align="right">'.number_format($this->sum_persedia($data_lp,"117","hrg_SA",$kd_lokasi),2,",",".").'</td> 
                        //             <td colspan="3"></td>  
                        //             <td colspan="2" align="right">'.number_format($this->sum_persedia($data_lp,"117","saldo",$kd_lokasi),2,",",".").'</td>  
                        //         </tr>';
                        // echo '</table>';
                        // if($no>=6)
                        // {
                        // echo '<pagebreak />';
                        // }
}
        }
        elseif($nm_lap=="neraca"){
                                $no=0;
                    $jumlah=0;
                    $saldo=0;
                    $prev_sskel=null;
                    $prev_perk=null;
                    $kd_rek=null;

                    $saldo = $this->sum_persedia($data_lp,"117","saldo",$kd_lokasi);
                    echo '<tr>

                          <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut.'</td>
                          <td colspan="3" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$nm_satker.'</td>
                          </tr>';
                    if($saldo!==0){
                                  echo '  <tr>
                                  
                          <td align="right" style="font-size:90%; "></td>
                          <td align="right" style="font-size:90%; "><b>117</b></td>
                          <td align="left" style="font-size:90%; "><b>Persediaan</b></td>
                          <td align="right"  style="font-size:90%; "><b>'.number_format($this->sum_persedia($data_lp,"117","saldo",$kd_lokasi),2,",",".").'</b></td>
                      </tr>';  
                    
           



                    while($data=$this->fetch_array($result))
                    {
                        $no+=1;
                        if($kd_rek!=substr($data[kd_perk],0, 5))
                        {
                            echo '<tr>
                                    <td></td>
                                    <td align="right" style="font-size:90%; ">'.substr($data[kd_perk],0, 5).'</td>
                                    <td  align="left" style="font-size:90%; ">'.$data[nm_perk].'</td>
                                    <td  align="right" style="font-size:90%; ;">'.number_format($this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"saldo",$kd_lokasi),2,",",".").'</td>
                                    <tr>
                                   ';
                            $kd_rek=substr($data[kd_perk],0, 5);
                        }
                        if($prev_perk!=$data[kd_perk])
                        {
                            echo '
                            <tr >
                                    <td align="right" style=" font-size:90%;"></td>
                                    <td align="right" style=" font-size:90%;">'.$data[kd_perk].'</td>
                                    <td  align="left" style=" font-size:90%;">'.$data[nm_perk].'</td>
                                    <td  align="right" style=" font-size:90%;">'.number_format($this->sum_persedia($data_lp,$data[kd_perk],"saldo",$kd_lokasi),2,",",".").'</b></td>
                                  </tr> ';
                            $prev_perk=$data[kd_perk];
                        }                    

                        // if($prev_sskel!=$data[kd_sskel])
                        // {
                            // echo '
                            //         <td align="right" style="font-size:90%;"><b>'.$data[kd_sskel].'</b></td>
                            //         <td colspan="2" align="left" style="font-size:90%;"><b>'.$data[nm_sskel].'</b></td>
                            //        ';
                            // $prev_sskel=$data[kd_sskel];
                        // }

                        // echo '<tr>
                        //          <td  align="right" style="font-size:90%;">'.$data[kd_brg].'</td> 
                        //          <td  align="left" style="font-size:90%;">'.' -'.$data[nm_brg].'</td> 
                        //          <td align="right" style="font-size:90%;">'.number_format($data[nilai]+$data[nilai0],2,",",".").'</td> 
                        //     </tr>';

                        $saldo+=$data[nilai]+$data[nilai0];
                    }
                    // echo '<tr>
                    //         <td colspan="2" style="font-size:90%;">JUMLAH</td>
                    //         <td align="right" style="font-size:90%;">'.number_format($saldo,2,",",".").'</td>
                    //       </tr>';
                    
                    // echo '</table>';
                    // if($no>=6)
                    // {
                    // echo '<pagebreak />';
                    // }
                }
        }
        elseif($nm_lap=="mutasi_persediaan"){
                $no=0;
                $total=0;
                $saldo_akhir=0;
                $saldo_thn_lalu=0;
                $saldo_akumulasi=0;
                $hrg_SA = number_format($this->sum_persedia($data_lp,"117","hrg_SA",$kd_lokasi),2,",",".");
                $saldo = number_format($this->sum_persedia($data_lp,"117","saldo",$kd_lokasi),2,",",".");
                echo '<tr>

                          <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut.'</td>
                          <td colspan="6" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$nm_satker.'</td>
                          </tr>';
                echo '  <tr>
                      <td align="right" style="font-size:90%; "></td>
                      <td align="center" style="font-size:90%; "><b>117</b></td>
                      <td align="left" style="font-size:90%; "><b>Persediaan</b></td>

                      <td align="center"  style="font-size:90%; "><b>'.$hrg_SA.'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.$qty_msk.'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.$qty_klr.'</b></td>
                      <td align="center"  style="font-size:90%; "><b>'.$saldo.'</b></td>
                    </tr>';
                while($data=$this->fetch_assoc($result))
                {   
                    $saldo_akhir=$data[thn_lalu]+$data[tambah]+$data[kurang];
                    $saldo_thn_lalu+=$data[thn_lalu];
                    $saldo_akumulasi+=$saldo_akhir;

                    echo '<tr>
                             <td  align="center"></td> 
                             <td  align="center">'.$data[kd_perk].'</td> 
                             <td  align="left">'.$data[nm_perk].'</td> 
                             <td align="right">'.number_format($data[thn_lalu],2,",",".").'</td>
                             <td align="right">'.number_format($data[tambah],2,",",".").'</td> 
                             <td align="right">'.number_format(abs($data[kurang]),2,",",".").'</td> 
                             <td align="right">'.number_format($saldo_akhir,2,",",".").'</td> 
                           </tr>';
                    $total+=$data[nilai];
                }
                    
                    // echo '<tr>
                    //         <td></td>
                    //         <td colspan="2">JUMLAH</td>  
                    //         <td align="right">'.number_format($saldo_thn_lalu,2,",",".").'</td>
                    //         <td colspan="2"></td>  
                    //         <td align="right">'.number_format($saldo_akumulasi,2,",",".").'</td>  
                    //     </tr>
                    //     ';
                if($no>=6)
                {
                echo '<pagebreak />';
                }
            
        }
        elseif($nm_lap=="transaksi_persediaan"){
                $no=0;
                $jumlah=0;
                $saldo=0;
                $prev_sskel=null;
                $prev_perk=null;
                while($data=$this->fetch_assoc($result))
                {
                    $no+=1;
                    if($prev_perk!=$data[nm_sskel])
                    {
                        echo '
                        <tr >
                                <td align="right" ><b>'.$data[kd_perk].'</b></td>
                                <td colspan="3" align="left"><b>'.$data[nm_perk].'</b></td>
                              </tr> ';
                    }                    

                    if($prev_sskel!=$data[nm_sskel])
                    {
                        echo '<tr >
                                <td align="right" ><b>'.$data[kd_sskel].'</b></td>
                                <td colspan="3" align="left"><b>'.$data[nm_sskel].'</b></td>
                              </tr> ';
                    }

                    echo '<tr>
                             <td  align="right">'.substr($data[kd_brg],10).'</td> 
                             <td  align="left">'.$data[nm_brg].'</td> 
                             <td align="center">'.number_format($data[qty]).'</td> 
                             <td align="center">'.number_format($data[harga]).'</td> 
                        </tr>';
                    $saldo+=$data[harga];
                }
                echo '<tr>
                        <td colspan="3">JUMLAH</td>
                        <td>'.number_format($saldo).'</td>
                      </tr>';
                echo '</table>';

        }
        elseif($nm_lap=="penerimaan_brg"){
                $no=0;
                $jumlah=0;
                $saldo=0;

                while($data=$this->fetch_assoc($result))
                {
                    $no+=1;
                    echo'<tr >
                    <center><td style="height:25px"  align="center">'.$no.'</td></center>
                    <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_buku]).'</td></center>
                    <center><td  align="center">'.'-'.'</td></center>
                    <center><td  align="left">'.$data[no_dok].'</td></center>
                    <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
                    <center><td  align="left">'.$data[nm_brg].'</td></center>
                    <center><td  align="center">'.$data[qty].'</td></center>
                    <center><td  align="right">'.$data[harga_sat].'</td></center>
                    <center><td  align="right">'.$data[total_harga].'</td></center>
                    
                    <center><td  align="left">'.$data[no_dok].'</td></center>
                    <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_buku]).'</td></center>
                    <center><td  align="left">'.$data[keterangan].'</td></center>';

                    echo '</tr>';
                }
                

                echo '</table>';
           

        }
        elseif($nm_lap=="pengeluaran_brg"){
                $no=0;
                $jumlah=0;
                $saldo=0;

                while($data=$this->fetch_assoc($result))
                {
                    $no+=1;
                    echo'<tr>
                    <center><td  align="center">'.$no.'</td></center>
                    <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_buku]).'</td></center>
                    <center><td  align="center">'.$no.'</td></center>
                    <center><td  align="left">'.$data[nm_brg].'</td></center>
                    <center><td  align="center">'.abs($data[qty]).'</td></center>
                    <center><td  align="center">'.$data[harga_sat].'</td></center>
                    <center><td  align="center">'.abs($data[total_harga]).'</td></center>
                    <center><td  align="center">'.$data[keterangan].'</td></center>
                    
                    <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_buku]).'</td></center>
                    <center><td  align="center">'.''.'</td></center>';
                    echo '</tr>';
                } 
                
                echo '</table>';   

        }
        elseif($nm_lap=="buku_brg_pakai_habis"){
            $no=0;
            $jumlah=0;
            $saldo=0;

            while($data=$this->fetch_assoc($result))
            {
                $no+=1;
                $qty = $data[qty];
                if($qty>0)
                {
                    echo'<tr>
                        <center><td  align="center">'.$no.'</td></center>
                        <center><td  align="center">'.$this->konversi_tanggal($data[tgl_buku]).'</td></center>
                        <center><td  align="center">'.$data[nm_brg].'</td></center>
                        <center><td  align="center">'.$data[spesifikasi].'</td></center>
                        <center><td  align="center">'.'-'.'</td></center>
                        <center><td  align="center">'.$data[qty].' '.$data[satuan].'</td></center>
                        <center><td  align="center">'.$data[harga_sat].'</td></center>
                        <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
                        <center><td  align="center">'.$data[no_dok].'</td></center>
                        <td>'.'-'.'</td>
                        <td>'.'-'.'</td>
                        <td>'.'-'.'</td>
                        <td>'.'-'.'</td>
                        <td>'.'-'.'</td>
                        </tr>';
                }
                else
                {
                    echo '<tr>
                            <center><td  align="center">'.$no.'</td></center>
                            <center><td  align="center">'.'-'.'</td></center>
                            <center><td  align="center">'.$data[nm_brg].'</td></center>
                            <center><td  align="center">'.$data[spesifikasi].'</td></center>
                            <td>'.'-'.'</td>
                            <td>'.'-'.'</td>
                            <td>'.'-'.'</td>
                            <td>'.'-'.'</td>
                            <td>'.'-'.'</td>
                            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_buku]).'</td></center>
                            <center><td  align="center">'.'-'.'</td></center>
                            <center><td  align="center">'.abs($data[qty]).' '.$data[satuan].'</td></center>
                            <center><td  align="center">'.$data[no_dok].'</td></center>
                            <center><td  align="center">'.$data[keterangan].'</td></center>
                         </tr>
                    ';

                }

                            
                         
                    }

                echo '</table>';
                    

                }
                elseif($nm_lap=="kartu_brg"){
                     while($data=$this->fetch_assoc($result))
                     {
                         $no+=1;
                         $sisa+=$data[qty];
                         echo'<tr>
                         <center><td  align="center">'.$no.'</td></center>
                         <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
                         ';
                         if($data[qty]>0) 
                         {
                            echo '<center><td  align="center">'.$data[qty].'</td></center> 
                            <center><td  align="center">'.'-'.'</td></center>
                            <center><td  align="center">'.$sisa.'</td></center>
                            <center><td  align="center">'.$data[keterangan].'</td></center>';
                         }
                         else 
                         {                
                            echo '<center><td  align="center">'.'-'.'</td></center>
                            <center><td  align="center">'.abs($data[qty]).'</td></center>
                            <center><td  align="center">'.$sisa.'</td></center>
                            <center><td  align="center">'.$data[keterangan].'</td></center>'; 
                         }
                     echo  '</tr>';
                     }

                     echo '</table>';           

                }       
                elseif($nm_lap=="kartu_p_brg"){
                    $no=0;
                    $jumlah=0;
                    $sisa=0;
                    $subtotal=0;

                    while($data=$this->fetch_assoc($result))
                    {
                        $no+=1;
                        $sisa+=$data[qty];
                        $subtotal =  abs($data[qty])*$data[harga_sat];
                        $saldo +=  ($data[qty]*$data[harga_sat]);
                        echo'<tr>
                        <center><td  align="center">'.$no.'</td></center>
                        <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
                        <center><td  align="center">'.$data[keterangan].'</td></center>

                        ';
                        if($data[qty]>0) 
                        {
                            echo '<center><td  align="center">'.$data[qty].'</td></center> 
                                    <center><td  align="center">'.'-'.'</td></center>
                                    <center><td  align="center">'.$sisa.'</td></center>
                                    <center><td  align="center">'.$data[harga_sat].'</td></center>
                                    <center><td  align="center">'.$subtotal.'</td></center>
                                    <center><td  align="center">'.'-'.'</td></center>
                                    <center><td  align="center">'.$saldo.'</td></center>
                                    <center><td  align="center">'.''.'</td></center>';
                        }
                        else 
                        {
                        
                            echo '  <center><td  align="center">'.'-'.'</td></center>
                                    <center><td  align="center">'.abs($data[qty]).'</td></center>
                                    <center><td  align="center">'.$sisa.'</td></center>
                                    <center><td  align="center">'.$data[harga_sat].'</td></center>
                                    <center><td  align="center">'.'-'.'</td></center>
                                    <center><td  align="center">'.$subtotal.'</td></center>
                                    <center><td  align="center">'.$saldo.'</td></center>
                                    <center><td  align="center">'.''.'</td></center>';
                                    
                        }

                        

                    echo  '</tr>';
                    }

                    echo '</table>';
        }
        elseif($nm_lap=="pp_brg_pakai_habis"){
            $no=0;
            $jumlah=0;
            $sisa=0;
            $subtotal=0;

            while($data=$this->fetch_assoc($result))
            {
                    $no+=1;
                    $sisa+=$data[qty];
                    $subtotal =  abs($data[qty])*$data[harga_sat];
                    $saldo +=  ($data[qty]*$data[harga_sat]);
                    echo'<tr>
                    <center><td  align="center">'.$no.'</td></center>


                    ';
                if($data[qty]>0) 
                {
                        echo '  <center><td  align="center">'.$this->konversi_tanggal($data[tgl_buku]).'</td></center>
                                <center><td  align="center">'.$data[untuk].'</td></center>
                                <center><td  align="center">'.$data[no_dok].'</td></center> 
                                <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
                                <center><td  align="center">'.'BAST'.'</td></center>
                                <center><td  align="center">'.'......'.'</td></center>
                                <center><td  align="center">'.$data[qty].'</td></center>
                                <center><td  align="center">'.$data[nm_brg].'</td></center>
                                <center><td  align="center">'.$data[harga_sat].'</td></center>
                                <center><td  align="center">'.'</td></center>
                                <center><td  align="center">'.$this->konversi_tanggal($data[tgl_buku]).'</td></center>
                                <center><td  align="center">'.$data[keterangan].'</td></center>
                                <center><td  align="center">'.$no.'</td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                ';
                }
                else 
                {
                    
                        echo '  
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center"></td></center>
                                <center><td  align="center">'.$no.'</td></center>
                                <center><td  align="center">'.$this->konversi_tanggal($data[tgl_buku]).'</td></center>
                                <center><td  align="center">'.'</td></center>
                                <center><td  align="center">'.$data[tgl_buku].'</td></center>
                                <center><td  align="center">'.$data[untuk].'</td></center>
                                <center><td  align="center">'.abs($data[qty]).'</td></center>
                                <center><td  align="center">'.$data[nm_brg].'</td></center>
                                <center><td  align="center">'.$data[harga_sat].'</td></center>
                                <center><td  align="center">'.$subtotal.'</td></center>
                                <center><td  align="center">'.$this->konversi_tanggal($data[tgl_buku]).'</td></center>
                                <center><td  align="center">'.$data[keterangan].'</td></center>
                                ';
                           
                }
                  echo  '</tr>';
                }

            echo   '</table>';

        }
        else {
            echo "masuk else";
        }


    

    }

    public function label_nomor($col){
             echo '<tr>';

                for($i=1; $i<=$col; $i++) {
                    echo '<td style ="font-weight:bold">'.$i.'</td>';
                    
                }
                echo '</tr>';

    }

        public function excel_export($html,$nama)
         {
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=".$nama.".xls");
                echo ' <html xmlns:o="urn:schemas-microsoft-com:office:office"
                    xmlns:x="urn:schemas-microsoft-com:office:excel"
                    xmlns="http://www.w3.org/TR/REC-html40">
                    <head>
                    <title>JIRA Issue Navigator for Excel (All)</title>
                    <META HTTP-EQUIV="Content-Type" Content="application/vnd.ms-excel; charset=utf-8">
                    <style>
                    @page
                    { mso-page-orientation:landscape; margin:.25in .25in .5in .20in; mso-header-margin:.5in; mso-footer-margin:.25in; mso-footer-data:"&R&P of &N"; mso-horizontal-page-align:center;}
                    </style>
                    <!--[if gte mso 9]><xml>
                    <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                    <x:Name>Buku Persediaan</x:Name>
                    <x:WorksheetOptions>
                    <x:Print>
                    <x:ValidPrinterInfo/>
                    </x:Print>
                    </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                    </xml><![endif]-->'; 
                echo $html;
         }

    public function getsatker($kd_lokasi)
    {
        $detil = explode(".", $kd_lokasi);
        $sektor = $detil[0];
        $satker = $detil[0].'.'.$detil[1];
        $unit = $detil[0].'.'.$detil[1].'.'.$detil[2];
        $gudang = $detil[0].'.'.$detil[1].'.'.$detil[2].'.'.$detil[3];

        $query_sektor = "SELECT NamaSatker from satker where kode='$sektor'";
        $query_satker = "select NamaSatker from satker where kode='$satker'";
        $query_unit = "select NamaSatker from satker where kode='$unit'";
        $query_gudang = "select NamaSatker from satker where kode='$gudang'";

        $result_sektor = $this->query($query_sektor);
        $data_sektor = $this->fetch_array($result_sektor);
        $nama_sektor = $data_sektor['NamaSatker'];

        $result_satker = $this->query($query_satker);
        $data_satker = $this->fetch_array($result_satker);
        $nama_satker = $data_sektor['NamaSatker'];

        $result_unit = $this->query($query_unit);
        $data_unit = $this->fetch_array($result_unit);
        $nama_unit = $data_unit['NamaSatker'];
        
        $result_gudang = $this->query($query_gudang);
        $data_gudang = $this->fetch_array($result_gudang);
        $nama_gudang = $data_unit['NamaSatker'];
        

        echo '<table style="text-align: left; width: 50%; font-size:85%; font-weight:bold;">';
        echo  '<tr>
                    <td>Provinsi</td>
                    <td colspan="2">'.':  '.'Jawa Tengah'.'</td>
               </tr>';
        echo  ' 
                    <tr>
                        <td>Kabupaten / Kota</td>
                        <td colspan="2">'.':  '.' '.'Kota Pekalongan'.'</td>
                    </tr>'; 
        if($detil[0]!="")
        {
        echo '
                    <tr>
                        <td>Bidang</td>
                        <td colspan="2">'.':  '.$nama_sektor.'</td>
                    </tr>';
        }
        if($detil[1]!="")
        {
        echo  ' 
                    <tr>
                        <td>Unit Organisasi</td>
                        <td colspan="2">'.':  '.' '.$nama_satker.'</td>
                    </tr>'; 
        }
        if($detil[2]!="")
        {               
        echo  ' 
                    <tr>
                        <td>Sub Unit Organisasi</td>
                        <td colspan="2">'.':  '.' '.$nama_unit.'</td>
                    </tr>'; 
        }
        if($detil[3]!="")
        { 
        echo            '<tr>
                        <td>UPB</td>
                        <td colspan="2">'.':  '.$nama_gudang.'</td>
                    </tr>
                    <p></p>';
        }
        echo '</table>';
        echo '<br></br>';


    }

    public function sum_persedia($data,$kode,$nilai,$kd_lokasi)
    {
        
        $thn_ang = $data['thn_ang'];
        $jenis = $data['jenis'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bulan = $data['bulan'];
        $bln_awal = $data['bln_awal'];
        $bln_akhir = $data['bln_akhir'];


        if($kode=="117"&&$nilai=="qty_SA")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_full ";
            $jns_trans= " and jns_trans like 'M01%' ";
            $kd_perk  = "";
            
        }
        elseif($kode=="117"&&$nilai=="hrg_SA")
        {
            $nm_kolom = " sum(total_harga) ";
            $nm_tabel = " transaksi_full";
            $jns_trans= " and jns_trans like 'M01%' ";
            $kd_perk  = "";
            
        }        
        elseif($kode=="117"&&$nilai=="qty_msk")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_masuk ";
            $jns_trans= " and jns_trans not like 'M01%' ";
            $kd_perk  = "";
            
        }
        elseif($kode=="117"&&$nilai=="qty_klr")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_keluar ";
            $jns_trans= "";
            $kd_perk  = "";
            $sql = "SELECT sum(qty) as jml from transaksi_keluar where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang'   ";
        }
        elseif($kode=="117"&&$nilai=="saldo")
        {
            $nm_kolom = " sum(qty_akhir*harga_sat) ";
            $nm_tabel = " transaksi_masuk";
            $jns_trans= "";
            $kd_perk  = "";
            $sql = "SELECT sum(qty_akhir*harga_sat) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' ";
        }

        elseif($kode=="11701" && $nilai=="qty_SA")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_full ";
            $jns_trans= " and jns_trans like 'M01%' ";
            $kd_perk  = " and kd_perk like '11701%' ";
            $sql = "SELECT sum(qty) as jml from transaksi_full where kd_lokasi like '$kd_lokasi%' and jns_trans like 'M01%' and thn_ang='$thn_ang' and kd_perk like '11701%'   ";
        }
        elseif($kode=="11701" && $nilai=="hrg_SA")
        {
            $nm_kolom = " sum(total_harga) ";
            $nm_tabel = " transaksi_full ";
            $jns_trans= " and jns_trans like 'M01%' ";
            $kd_perk  = " and kd_perk like '11701%' ";
            $sql = "SELECT sum(qty_akhir*harga_sat) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and jns_trans like 'M01%'  and thn_ang='$thn_ang' and kd_perk like '11701%'  ";
        }        
        elseif($kode=="11701" && $nilai=="qty_msk")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_masuk ";
            $jns_trans= " and jns_trans not like 'M01%' ";
            $kd_perk  = " and kd_perk like '11701%' ";
            $sql = "SELECT sum(qty) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' and kd_perk like '11701%'  and jns_trans not like 'M01%'    ";
        }
        elseif($kode=="11701" && $nilai=="qty_klr")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_keluar ";
            $jns_trans= " ";
            $kd_perk  = " and kd_perk like '11701%' ";
            $sql = "SELECT sum(qty) as jml from transaksi_keluar where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' and kd_perk like '11701%'   ";
        }
        elseif($kode=="11701" && $nilai=="saldo")
        {
            $nm_kolom = " sum(qty_akhir*harga_sat) ";
            $nm_tabel = " transaksi_masuk ";
            $jns_trans= " and jns_trans not like 'M01%' ";
            $kd_perk  = " and kd_perk like '11701%' ";
            $sql = "SELECT sum(qty_akhir*harga_sat) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' and kd_perk like '11701%' ";
        }
        elseif($kode!=="11701" && $nilai=="qty_SA")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_full ";
            $jns_trans= " and jns_trans like 'M01%' ";
            $kd_perk  = " and kd_perk like '$kode%' ";
            $sql = "SELECT sum(qty) as jml from transaksi_full where kd_lokasi like '$kd_lokasi%' and jns_trans like 'M01%'  and thn_ang='$thn_ang' and kd_perk like '$kode%'  ";
        }
        elseif($kode!=="11701" && $nilai=="hrg_SA")
        {
            $nm_kolom = " sum(total_harga) ";
            $nm_tabel = " transaksi_masuk ";
            $jns_trans= " and jns_trans like 'M01%' ";
            $kd_perk  = " and kd_perk like '$kode%' ";
            $sql = "SELECT sum(qty_akhir*harga_sat) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and jns_trans like 'M01%'  and thn_ang='$thn_ang' and kd_perk like '$kode%' ";
        }        
        elseif($kode!=="11701" && $nilai=="qty_msk")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_masuk ";
            $jns_trans= " and jns_trans not like 'M01%' ";
            $kd_perk  = " and kd_perk like '$kode%' ";
            $sql = "SELECT sum(qty) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' and kd_perk like '$kode%'  and jns_trans not like 'M01%'  ";
        }
        elseif($kode!=="11701" && $nilai=="qty_klr")
        {
            $nm_kolom = " sum(qty) ";
            $nm_tabel = " transaksi_keluar ";
            $jns_trans= " and jns_trans not like 'M01%' ";
            $kd_perk  = " and kd_perk like '$kode%' ";
            $sql = "SELECT sum(qty) as jml from transaksi_keluar where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' and kd_perk like '$kode%'  ";
        }
        elseif($kode!=="11701" && $nilai=="saldo")
        {
            $nm_kolom = " sum(qty_akhir*harga_sat) ";
            $nm_tabel = " transaksi_masuk ";
            $jns_trans= "";
            $kd_perk  = " and kd_perk like '$kode%' ";
            $sql = "SELECT sum(qty_akhir*harga_sat) as jml from transaksi_masuk where kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang' and kd_perk like '$kode%' ";
        }

        // elseif($kode=="11701")
        // {
        //     $sql = "SELECT sum(qty_akhir*harga_sat) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and kd_perk like '11701%'";
        // }
        else
        {
            // $sql = "SELECT sum(qty_akhir*harga_sat) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' and kd_perk like '$kode%'";
        }

        if($jenis=="semester"){
            $kriteria = "and month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir' ";
            $sblm_kriteria = "and month(tgl_dok) < '$bln_awal' ";
            $sql2 = "SELECT ".$nm_kolom." as jml from ".$nm_tabel." where kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang' ".$jns_trans." ".$kd_perk." ".$sblm_kriteria;
            
        }
        elseif($jenis=="tanggal"){
            $kriteria = "and tgl_dok >= '$tgl_awal' AND tgl_dok < '$tgl_akhir' ";
            $sblm_kriteria = "and tgl_dok < '$tgl_awal' ";
            $sql2 = "SELECT ".$nm_kolom." as jml from ".$nm_tabel." where kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang' ".$jns_trans." ".$kd_perk." ".$sblm_kriteria;
        
        }        
        elseif($jenis=="bulan"){
            $kriteria = "and month(tgl_dok)='$bulan'";
            $sblm_kriteria = "and month(tgl_dok)<'$bulan'";
            $sql2 = "SELECT ".$nm_kolom." as jml from ".$nm_tabel." where kd_lokasi = '$kd_lokasi' and thn_ang='$thn_ang' ".$jns_trans." ".$kd_perk." ".$sblm_kriteria;
        
        }
        else{
            $kriteria = "";
            $sblm_kriteria = "";
            $sql2="";
        }              
        
        if($sql2!==""){
            $result2 = $this->query($sql2);
            $array2 = $this->fetch_array($result2);
            $nilai2 = abs($array2['jml']);
        }
        else {
            $nilai2=0;
        }
        
        $sql = "SELECT ".$nm_kolom." as jml from ".$nm_tabel." where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' ".$jns_trans." ".$kd_perk." ".$kriteria;

        $result = $this->query($sql);
        $array = $this->fetch_array($result);
        $nilai = abs($array['jml']);

        $sum = $nilai+$nilai2;

        return $sum;

    }


    public function hitung_brg_rusak($kd_lokasi)
    {

        if($jenis=="tanggal") 
        {
            $tanggal=$this->cetak_tanggal($tgl_akhir);
            return $tanggal;
        }
        if($jenis=="semester" && $bln_akhir=="06")
        {
            return "31 JUNI ".$thn_ang;
        }

        if($jenis=="semester" && $bln_akhir=="12")
        {
            return "31 DESEMBER ".$thn_ang;
        }
        else        
        {
            return "31 DESEMBER ".$thn_ang;
        }


        $query_rusak = "SELECT sum(total_harga) as saldo_rusak from transaksi_keluar where kd_lokasi like '{$kd_lokasi}%'  and jns_trans='K03' and status_hapus=0";
        $result_rusak = $this->query($query_rusak);
        $data_rusak = $this->fetch_array($result_rusak);
        $saldo_rusak = 0 +$data_rusak['saldo_rusak'];        

        $query_usang = "SELECT sum(total_harga) as saldo_usang from transaksi_keluar where kd_lokasi like '{$kd_lokasi}%'  and jns_trans='K02' and status_hapus=0";
        $result_usang = $this->query($query_usang);
        $data_usang = $this->fetch_array($result_usang);
        $saldo_usang = 0+$data_usang['saldo_usang'];
        echo '
        <tr><b>Keterangan :</b></tr><br>        
                    <tr>1. Persediaan Senilai Rp. '.abs($saldo_rusak).',- dalam kondisi rusak</tr> <br>               
                    <tr>2. Persediaan Senilai Rp. '.abs($saldo_usang).',- dalam kondisi usang</tr>                
             
                    ';


    }

    public function cek_periode($data)
    {
        $jenis = $data['jenis'];
        $bulan = $data['bulan'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bln_awal = $data['bln_awal'];
        $bln_akhir = $data['bln_akhir'];
        $thn_ang = $data['thn_ang'];

        if($jenis=="tanggal") 
        {
            $tanggal=$this->cetak_tanggal($tgl_akhir);
            return $tanggal;
        }
        if($jenis=="semester" && $bln_akhir=="06")
        {
            return "31 JUNI ".$thn_ang;
        }

        if($jenis=="semester" && $bln_akhir=="12")
        {
            return "31 DESEMBER ".$thn_ang;
        }
        else        
        {
            return "31 DESEMBER ".$thn_ang;
        }

    }




    public function cetak_tanggal($tgl_akhir)
    {
        $data_tgl = explode("/", $tgl_akhir);
        if($data_tgl[1]=="01")
        {
            $bulan="JANUARI";
        }        

        if($data_tgl[1]=="02")
        {
            $bulan="FEBRUARI";
        }

        if($data_tgl[1]=="03")
        {
            $bulan="MARET";
        }
        if($data_tgl[1]=="04")
        {
            $bulan="APRIL";
        }
        if($data_tgl[1]=="05")
        {
            $bulan="MEI";
        }
        if($data_tgl[1]=="06")
        {
            $bulan="JUNI";
        }
        if($data_tgl[1]=="07")
        {
            $bulan="JULI";
        }
        if($data_tgl[1]=="08")
        {
            $bulan="AGUSTUS";
        }
        if($data_tgl[1]=="09")
        {
            $bulan="SEPTEMBER";
        }
        if($data_tgl[1]=="10")
        {
            $bulan="OKTOBER";
        }
        if($data_tgl[1]=="11")
        {
            $bulan="NOVEMBER";
        }
        if($data_tgl[1]=="12")
        {
            $bulan="DESEMBER";
        }
    $array = array($data_tgl[2],$bulan,$data_tgl[0]);
    $tanggal = implode(" ",$array);
    return $tanggal;


    }

    public function konversi_tanggal($tgl)
    {
        $data_tgl = explode("-",$tgl);
        $array = array($data_tgl[2],$data_tgl[1],$data_tgl[0]);
        $tanggal = implode("/", $array );
        return $tanggal;
    }    

    public function tgl_buku_sedia($tgl)
    {
        $data_tgl = explode("-",$tgl);
        $array = array($data_tgl[2],$data_tgl[1],$data_tgl[0]);
        $tanggal = implode(" / ", $array );
        return $tanggal;
    }

    public function cetak_nama_pj($satker_asal)
    {
        $query = "SELECT * from ttd where kd_lokasi='$satker_asal' ";
        $result = $this->query($query);
        $pj = $this->fetch_array($result);


        echo '<br></br>
              <table style="text-align: center; width: 100%; font-size:84% "  >
              <tr>
                <td style="text-align: center;"></td>
                <td style="text-align: center;"> '.$pj['kota'].',................................... </td>
              </tr>            
              <tr>
                <td style="text-align: center;"> ATASAN LANGSUNG, </td>
                <td style="text-align: center;"> PENYIMPAN BARANG, </td>
              </tr>
              <tr>
                <td><br></br> <br></br> <br></br></td>
                <td><br></br> <br></br> <br></br></td>
              </tr>
              <tr>
                <td style="text-align: center;">'.$pj['nama'].'</td>
                <td style="text-align: center;">'.$pj['nama2'].'</td>
              </tr>              

              <tr>
                <td style="text-align: center;">NIP'." ".$pj['nip'].'</td>
                <td style="text-align: center;">NIP'." ".$pj['nip2'].'</td>
              </tr>
              </table>';


    }

public function refresh($kd_lokasi, $thn_ang)
    {
        
        $sql = "CREATE TEMPORARY TABLE transaksi_fullTemp SELECT * FROM transaksi_masuk where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' ";
        $result = $this->query($sql);

        $sql = "UPDATE transaksi_fullTemp set qty_akhir = qty";
        $result = $this->query($sql);

        $sql = "CREATE TEMPORARY TABLE IF NOT EXISTS `transaksi_keluarTemp` (
                  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                  `id_masuk` int(11) DEFAULT NULL ,
                  `id_opname` int(11) DEFAULT NULL,
                  `kd_lokasi` varchar(20) NOT NULL,
                  `kd_lok_msk` varchar(20) DEFAULT NULL,
                  `nm_satker` varchar(40) DEFAULT NULL,
                  `thn_ang` year(4) DEFAULT NULL,
                  `no_dok` varchar(20) NOT NULL,
                  `tgl_dok` date NOT NULL,
                  `tgl_buku` date NOT NULL,
                  `no_bukti` varchar(20) NOT NULL,
                  `kd_sskel` varchar(15) DEFAULT NULL,
                  `nm_sskel` varchar(30) DEFAULT NULL,
                  `kd_brg` varchar(30) DEFAULT NULL,
                  `nm_brg` varchar(30) DEFAULT NULL,
                  `spesifikasi` varchar(30) DEFAULT NULL,
                  `kd_perk` varchar(7) DEFAULT NULL,
                  `nm_perk` varchar(20) DEFAULT NULL,
                  `satuan` varchar(10) DEFAULT NULL,
                  `qty` mediumint(9) NOT NULL,
                  `harga_sat` int(11) NOT NULL,
                  `total_harga` int(11) DEFAULT NULL,
                  `jns_trans` varchar(5) NOT NULL,
                  `keterangan` varchar(100) NOT NULL,
                  `status` tinyint(1) DEFAULT NULL,
                  `status_edit` tinyint(1) NOT NULL DEFAULT '0',
                  `status_hapus` tinyint(1) NOT NULL DEFAULT '0',
                  `status_ambil` tinyint(1) NOT NULL DEFAULT '0',
                  `tgl_update` date DEFAULT NULL,
                  `user_id` varchar(20) NOT NULL
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
                 ";
        $result = $this->query($sql);

        $sql = "SELECT tgl_dok, kd_brg, nm_brg, sum(qty) as qty, harga_sat FROM transaksi_keluar where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' group by no_dok, kd_brg";
        $result = $this->query($sql);

        while($data = $this->fetch_array($result))
        {
        $tgl_dok =  $data['tgl_dok'];
        $kd_brg =   $data['kd_brg'];
        $nm_brg =   $data['nm_brg'];
        $kuantitas=  abs($data['qty']);

        while($kuantitas > 0)
                {   
                    // echo " kuantitas tersisa : ".$kuantitas; 
                    $query_id = "select * from transaksi_fullTemp WHERE kd_brg='$kd_brg' and kd_lokasi like '21.01%' and qty_akhir>0 order by tgl_dok asc limit 1";     
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

                    // echo "ID transaksi masuk : ".$id_trans_m.' '.$qty_akhir.' '.$harga_sat;
                    // echo '<br>';

                    
                    if($kuantitas<$qty_akhir)
                    {
                        // echo "terbukti sisa kuantitas : ".$kuantitas.' dengan qy akhir : '.$qty_akhir;
                        // echo '<br>';

                        $query_keluar = "Insert into transaksi_keluarTemp
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

                        $query_upd_masuk = "update transaksi_fullTemp set qty_akhir = qty_akhir - $kuantitas where kd_lokasi like '21.01%' and id='$id_trans_m'";
                        $result_upd_masuk = $this->query($query_upd_masuk);

                        $query_idk = "select id from transaksi_keluarTemp WHERE kd_brg='$kd_brg' and user_id='$user_id' and kd_lokasi like '21.01%' and no_dok='$no_dok' order by id DESC";
                        $result_idk = $this->query($query_idk);
                        $row_idk = $this->fetch_array($result_idk);
                        $id_transk = $row_idk['id'];
                        $minus_qty = -$kuantitas;
                        $minus_hrg = -$harga_sat;
                        $minus_total = -$total_harga;
                        // echo "id trans keluar : ".$id_transk;
                        // echo '<br>';

                        $query_full = "Insert into transaksi_fullTemp
                                        set kd_lokasi='$kd_lokasi',
                                        
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
                        $query_id = "select * from transaksi_fullTemp WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and qty_akhir>0 order by tgl_dok asc limit 1";     
                        $result_id = $this->query($query_id);
                        $row_id = $this->fetch_array($result_id);
                        $id_trans = $row_id['id'];   
                        $qty_akhir = $row_id['qty_akhir'];      
                        $harga_sat = $row_id['harga_sat']; 
                        $total_harga = $qty_akhir * $harga_sat;
                        // echo $id_trans.' '.$qty_akhir.' '.$harga_sat;
                        // echo '<br>';

                        $query_keluar = "Insert into transaksi_keluarTemp
                                        set 
                                        kd_lokasi='$kd_lokasi',

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

                        $query_upd_masuk = "update transaksi_fullTemp set qty_akhir = qty_akhir - $qty_akhir where kd_lokasi = '$kd_lokasi' and id='$id_trans'";
                        $result_upd_masuk = $this->query($query_upd_masuk);

                        $query_idk = "select id from transaksi_keluarTemp WHERE kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' and no_dok='$no_dok' order by id DESC";
                        $result_idk = $this->query($query_idk);
                        $row_idk = $this->fetch_array($result_idk);
                        $id_transk = $row_idk['id'];

                        $minus_qty = -$qty_akhir;
                        $minus_hrg = -$harga_sat;
                        $minus_total = -$total_harga;

                        $query_full = "Insert into transaksi_fullTemp
                                        set kd_lokasi='$kd_lokasi',
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

        }


    }

}





?>