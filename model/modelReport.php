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
        $query = "select kd_brg, nm_brg FROM transaksi_masuk where kd_lokasi like '$data%' and status_hapus=0  and kd_brg not like '' GROUP BY kd_brg ORDER BY nm_brg ASC ";
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
        $query = "select kode, NamaSatker from satker where kode like '{$kd_lokasi}%'";
        $result = $this->query($query);
        // echo '<option value="">-- Pilih Kode Satker --</option>';

        while ($row = $this->fetch_array($result))
        {
            $str = $row['kode'];
            if (substr_count($str,".") == 3) {
            echo '<option value="'.$row['kode'].'">'.$row['kode'].'        '.$row['NamaSatker']."</option>";
             }
        } 
    }

    public function buku_persediaan($data)
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

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where  kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
        $this->getsatker($kd_lokasi);
        
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">BUKU PERSEDIAAN</p>
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

                if($jenis=="tanggal") 
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC;";
                    $result = $this->query($sql);
                }
                elseif($jenis=="bulan")
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where month(tgl_dok)='$bulan' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where month(tgl_dok)='$bulan'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC";
                    $result = $this->query($sql);
                }
                else
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where year(tgl_dok)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where year(tgl_dok)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC";
                    $result = $this->query($sql);
                }

                $no=0;
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
                                <center><td  align="center">'.'0'.'</td></center>';
                    }
                    else 
                    {
                    
                    echo '<center><td  align="center">'.'0'.'</td></center>
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

                // $this->cetak_nama_pj($satker_asal);

                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output("buku_persediaan.pdf" ,'I');
                exit;
         }

    public function buku_persediaan_all($data)
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

        $list_brg = "SELECT kd_brg from transaksi_masuk where kd_lokasi='$kd_lokasi' group by kd_brg";
        $result_list = $this->query($list_brg);
        while($data=$this->fetch_assoc($result_list)) 
        {

        $kd_brg=$data['kd_brg'];
        if($kd_brg==""){
            continue;
        }
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where  kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
        $this->getsatker($kd_lokasi);
        
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">BUKU PERSEDIAAN</p>
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

                if($jenis=="tanggal") 
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC;";
                    $result = $this->query($sql);
                }
                elseif($jenis=="bulan")
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where month(tgl_dok)='$bulan' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where month(tgl_dok)='$bulan'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC";
                    $result = $this->query($sql);
                }
                else
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where year(tgl_dok)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where year(tgl_dok)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC";
                    $result = $this->query($sql);
                }

                $no=0;
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
                                <center><td  align="center">'.'0'.'</td></center>';
                    }
                    else 
                    {
                    
                    echo '<center><td  align="center">'.'0'.'</td></center>
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
                echo '<pagebreak />';
            }
                // $this->cetak_nama_pj($satker_asal);

                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output("buku_persediaan.pdf" ,'I');
                exit;
        }

    public function laporan_persediaan($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        $mpdf->setFooter('{PAGENO}');
        ob_start(); 

        $jenis = $data['jenis'];
        $bln_awal = $data['bln_awal'];
        $bln_akhir = $data['bln_akhir'];
        $tgl_akhir = $data['tgl_akhir'];

        $kd_brg = $data['kd_brg'];
        $thn_ang = $data['thn_ang'];
        $kd_lokasi = $data['kd_lokasi'];
        $date = $this->cek_periode($data);
        $satker_asal = $data['satker_asal'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
        $this->getsatker($kd_lokasi);
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN PERSEDIAAN BARANG</p>
              <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
              <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
              <br></br>  
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    
                    <td width="18%"><b>KODE</b></td>
                    <td width="50%"><b>URAIAN</b></td>
                    <td><b>NILAI</b></td>
                </tr>';

                if($jenis=="tanggal")
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(total_harga) as nilai from 
                         (SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_masuk
                          UNION ALL
                          SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_keluar)
                          transaksi 
                            where kd_sskel not like '' and tgl_dok <= '$tgl_akhir' and kd_lokasi like '{$kd_lokasi}%'  AND thn_ang='$thn_ang' AND status_hapus=0 GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                elseif($jenis=="semester")
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, 
                          sum(case when month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir' then total_harga else 0 end) as nilai,
                          sum(case when month(tgl_dok) < '$bln_awal' then total_harga else 0 end) as nilai0
                         from 
                         (SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_masuk
                          UNION ALL
                          SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_keluar)
                          transaksi 
                            where kd_sskel not like '' and kd_lokasi like '{$kd_lokasi}%'  AND thn_ang='$thn_ang' AND status_hapus=0 GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                else
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(total_harga) as nilai from 
                         (SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang from transaksi_masuk
                          UNION ALL
                          SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang from transaksi_keluar)
                          transaksi  
                          where kd_sskel not like '' and kd_lokasi like '{$kd_lokasi}%'  AND thn_ang='$thn_ang' AND status_hapus=0 GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                $no=0;
                $jumlah=0;
                $saldo=0;
                $prev_sskel=null;
                $prev_perk=null;
                while($data=$this->fetch_array($result))
                {
                    $no+=1;
                    if($prev_perk!=$data[kd_perk])
                    {
                        echo '
                        <tr style="font-size:45%;">
                                <td align="right" style="background-color:#DEDEDE; font-size:90%;"><b>'.$data[kd_perk].'</b></td>
                                <td colspan="2" align="left" style="background-color:#DEDEDE; font-size:90%;"><b>'.$data[nm_perk].'</b></td>
                              </tr> ';
                        $prev_perk=$data[kd_perk];
                    }                    

                    if($prev_sskel!=$data[kd_sskel])
                    {
                        echo '<tr >
                                <td align="right" style="font-size:90%;"><b>'.$data[kd_sskel].'</b></td>
                                <td colspan="2" align="left" style="font-size:90%;"><b>'.$data[nm_sskel].'</b></td>
                              </tr> ';
                        $prev_sskel=$data[kd_sskel];
                    }

                    echo '<tr>
                             <td  align="right" style="font-size:90%;">'.substr($data[kd_brg],10).'</td> 
                             <td  align="left" style="font-size:90%;">'.' -'.$data[nm_brg].'</td> 
                             <td align="right" style="font-size:90%;">'.number_format($data[nilai]+$data[nilai0],0,",",".").'</td> 
                        </tr>';

                    $saldo+=$data[nilai]+$data[nilai0];
                }
                echo '<tr>
                        <td colspan="2" style="font-size:90%;">JUMLAH</td>
                        <td align="right" style="font-size:90%;">'.number_format($saldo,0,",",".").'</td>
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

        echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
        $this->getsatker($kd_lokasi);
        $date = $this->cek_periode($data);
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN RINCIAN BARANG PERSEDIAAN</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                <br></br>

                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    <td rowspan="2" style="font-weight:bold;">KODE BARANG</td>
                    <td  width="30%" rowspan="2" style="font-weight:bold;" >URAIAN</td>
                    <td  width="20%" colspan="2" style="font-weight:bold;"  >NILAI S/D 31 DESEMBER '.$thn_ang_lalu.'</td>
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
                $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, 
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
                                    SELECT thn_ang,tgl_dok, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang,tgl_dok, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where kd_sskel not like '' and  kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                elseif($jenis=="tanggal")
                {
                $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, 
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty<0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty>=0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN total_harga else 0 end) + sum(case WHEN qty<0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN total_harga else 0 end) as nilai 
                                    FROM (
                                    SELECT thn_ang,tgl_dok, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang,tgl_dok, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where kd_sskel not like '' and  kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                else
                {
                $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, 
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and thn_ang='$thn_ang' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty<0 and thn_ang='$thn_ang' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty>=0 and thn_ang='$thn_ang' THEN total_harga else 0 end) + sum(case WHEN qty<0 and thn_ang='$thn_ang' THEN total_harga else 0 end) as nilai 
                                    FROM (
                                    SELECT thn_ang,kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang,kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where kd_sskel not like '' and  kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                $no=0;
                $total_thn_lalu=0;
                $total_akumulasi=0;
                $prev_sskel=null;
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
                    
                    if($prev_sskel!=$data[kd_sskel])
                    {
                        echo '<tr >
                                <td align="right" style="font-size:90%;"></td>
                                <td colspan="9" align="left" style="font-size:90%;"><b>'.$data[nm_sskel].'</b></td>
                              </tr> ';
                        $prev_sskel=$data[kd_sskel];
                    }

                    echo '<tr>
                             <td  align="center" style="font-size:90%;">'.$data[kd_brg].'</td> 
                             <td  align="left" style="font-size:90%;">'.$data[nm_brg].'</td> 
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

    public function neraca($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        $mpdf->setFooter('{PAGENO}');
        ob_start(); 
        $kd_lokasi = $data['kd_lokasi'];
        $kd_brg = $data['kd_brg'];
        $tgl_akhir = $data['tgl_akhir'];
        $thn_ang = $data['thn_ang'];
        $date = $this->cek_periode($data);
        $satker_asal = $data['satker_asal'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);

        echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
        $this->getsatker($kd_lokasi);
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN POSISI PERSEDIAAN DI NERACA</p>
                <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
                <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                <br></br>
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                        <td style="font-weight:bold;">KODE</td>
                        <td style="font-weight:bold;">URAIAN</td>
                        <td style="font-weight:bold;">NILAI</td>
                </tr>';

                $sql="SELECT kd_perk, nm_perk, sum(total_harga) as nilai FROM (
                                    SELECT tgl_dok, thn_ang, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT tgl_dok,thn_ang, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi where nm_perk not like '' and kd_lokasi like '{$kd_lokasi}%'  and thn_ang='$thn_ang' and status_hapus=0  and tgl_dok<='$tgl_akhir' GROUP BY kd_perk";
                $result = $this->query($sql);
                $no=0;
                $total=0;

                while($data=$this->fetch_assoc($result))
                {
                    $no+=1;
                    echo '<tr>
                             <td  align="center">'.$data[kd_perk].'</td> 
                             <td  align="left">'.$data[nm_perk].'</td> 
                             <td align="right">'.number_format($data[nilai],0,",",".").'</td> </tr>';
                    $total+=$data[nilai];
                }
                    
                    echo '<tr>
                            <td colspan="2">JUMLAH</td>  
                            <td align="right">'.number_format($total,0,",",".").'</td>  
                        </tr>
                        </table>';
                if($no>=6)
                {
                echo '<pagebreak />';
                }
                $this->cetak_nama_pj($satker_asal);
                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output("posisi_persediaan.pdf" ,'I');
                exit;
    }

    public function mutasi_prsedia($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start(); 
        $kd_lokasi = $data['kd_lokasi'];
        $kd_brg = $data['kd_brg'];
        $tgl_awal=$data['tgl_awal'];
        $tgl_akhir=$data['tgl_akhir'];
        $thn_ang = $data['thn_ang'];
        $thn_ang_lalu = intval($thn_ang)-1;
        $satker_asal = $data['satker_asal'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg'";
        $result_detail = $this->query($detail_brg);
        echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
        $this->getsatker($kd_lokasi);
        $date = $this->cek_periode($data);
        $brg = $this->fetch_array($result_detail);
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN MUTASI BARANG PERSEDIAAN</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                <br></br>
                <table style="text-align: center; width: 90%; " align="center">
                <tr>
                    
                </tr>                
                <tr>
                    
                </tr>               
                 <tr>
                    <td width="60%" align="left"></td>
                </tr>
                </table>
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    <td rowspan="2">KODE</td>
                    <td  width="30%" rowspan="2"  >URAIAN</td>
                    <td  width="13%" rowspan="2"  >NILAI S/D 31 DESEMBER '.$thn_ang_lalu.'</td>
                    <td colspan="2">MUTASI</td>
                    <td rowspan="2" width="13%">NILAI S/D '.$date.'</td>
                    <tr>
                        <td>Tambah</td>
                        <td>Kurang</td>
                    </tr> 
                </tr>';

                $sql="SELECT kd_perk,
                             nm_perk,
                             sum(case when year(tgl_dok)='$thn_ang_lalu' THEN total_harga else 0 end) as thn_lalu, 
                             sum(case when total_harga>=0 and thn_ang='$thn_ang' then total_harga else 0 end) as tambah, 
                             sum(case when total_harga<0 and thn_ang='$thn_ang' then total_harga else 0 end) as kurang 
                             FROM
                             (
                              SELECT tgl_dok, thn_ang, kd_perk, nm_perk, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                              UNION ALL
                              SELECT tgl_dok, thn_ang, kd_perk, nm_perk, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                             ) transaksi  
                              where kd_perk not like '' and kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'
                              GROUP BY kd_perk";
                $result = $this->query($sql);
                $no=0;
                $total=0;
                $saldo_akhir=0;
                $saldo_thn_lalu=0;
                $saldo_akumulasi=0;
                while($data=$this->fetch_assoc($result))
                {   
                    $saldo_akhir=$data[thn_lalu]+$data[tambah]+$data[kurang];
                    $saldo_thn_lalu+=$data[thn_lalu];
                    $saldo_akumulasi+=$saldo_akhir;
                    echo '<tr>
                             <td  align="center">'.$data[kd_perk].'</td> 
                             <td  align="left">'.$data[nm_perk].'</td> 
                             <td align="right">'.number_format($data[thn_lalu],0,",",".").'</td>
                             <td align="right">'.number_format($data[tambah],0,",",".").'</td> 
                             <td align="right">'.number_format(abs($data[kurang]),0,",",".").'</td> 
                             <td align="right">'.number_format($saldo_akhir,0,",",".").'</td> 
                           </tr>';
                    $total+=$data[nilai];
                }
                    
                    echo '<tr>
                            <td colspan="2">JUMLAH</td>  
                            <td align="right">'.number_format($saldo_thn_lalu,0,",",".").'</td>
                            <td colspan="2"></td>  
                            <td align="right">'.number_format($saldo_akumulasi,0,",",".").'</td>  
                        </tr>
                        </table>';
                if($no>=6)
                {
                echo '<pagebreak />';
                }
                $this->cetak_nama_pj($satker_asal);

                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output("mutasi_persediaan.pdf" ,'I');
                exit;
         }

    public function transaksi_persediaan($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start(); 

        $jenis = $data['jenis'];
        $kd_trans = $data['kd_trans'];
        $nm_trans = $data['nm_trans'];
        $bulan = $data['bulan'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];

        $kd_brg = $data['kd_brg'];
        $thn_ang = $data['thn_ang'];
        $kd_lokasi = $data['kd_lokasi'];


        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';
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

                if($jenis=="tanggal")
                {
                    $sql="SELECT 
                                        kd_sskel,
                                        nm_sskel, 
                                        kd_brg, 
                                        nm_brg, 
                                        kd_perk, 
                                        nm_perk, 
                                        sum(qty) as qty, 
                                        sum(total_harga) as harga 
                                        from (
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                                        UNION ALL
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                                        ) transaksi
                                        where 
                                            tgl_dok >= '$tgl_awal' and 
                                            tgl_dok <= '$tgl_akhir' and 
                                            kd_lokasi like '{$kd_lokasi}%'  AND 
                                            thn_ang='$thn_ang' and
                                            status_hapus = 0 and
                                            jns_trans='$kd_trans' 
                                        GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                elseif($jenis=="bulan")
                {
                    $sql="SELECT 
                                        kd_sskel, 
                                        nm_sskel, 
                                        kd_brg, 
                                        nm_brg, 
                                        kd_perk, 
                                        nm_perk, 
                                        sum(qty) as qty, 
                                        sum(total_harga) as harga 
                                        from (
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                                        UNION ALL
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                                        ) transaksi
                                        where 
                                            month(tgl_dok)='$bulan' and 
                                            kd_lokasi like '{$kd_lokasi}%'  AND 
                                            thn_ang='$thn_ang' AND
                                            status_hapus = 0 and
                                            jns_trans='$kd_trans' 
                                        GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                else
                {   
                    
                    $sql="SELECT 
                                        kd_sskel, 
                                        nm_sskel, 
                                        kd_brg, 
                                        nm_brg, 
                                        kd_perk, 
                                        nm_perk, 
                                        sum(qty) as qty, 
                                        sum(total_harga) as harga 
                                        from (
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                                        UNION ALL
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                                        ) transaksi 
                                        where 
                                            thn_ang='$thn_ang' and
                                            kd_lokasi like '{$kd_lokasi}%'  and
                                            status_hapus = 0 and
                                            jns_trans='$kd_trans'
                                        GROUP BY kd_brg
                                        ";
                    $result = $this->query($sql);

                }
  

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
                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output($nama_dokumen.".pdf" ,'I');
                exit;
    }



    public function buku_persediaan_excel($data)
    {
        
        // $mpdf->setFooter('{PAGENO}');
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=buku-persediaan.xls");
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

        $jenis = $data['jenis'];
        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bulan = $data['bulan'];
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $satker_asal = $data['satker_asal'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where  kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        
        $this->getsatker($kd_lokasi);
        
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:130%">BUKU PERSEDIAAN</p>
                <br></br>
                <table style="text-align: center; width: 100%; font-size:110%;" align="right" >
                <tr>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td align="left" colspan="2"><b>Kode Barang</b>:'.$kd_brg.'</td>
                </tr>                
                <tr>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td align="right"></td>
                    <td align="left" colspan="2"><b>Nama Barang</b>:'.$brg['nm_brg'].'</td>
                </tr>                
                <tr>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td width="75%" align="right"></td>
                    <td  align="right"></td>
                    <td align="left" colspan="2"><b>Satuan</b>:'.$brg['satuan'].'</td>
                </tr>
                </table>
                <table style="text-align:center; table-layout: fixed; white-space: nowrap; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:100%;" border=1 align="center">
                <tr >
                    <td rowspan="2" style="font-weight:bold; text-align:center; font-size:110%" >NO</td>
                    <td  rowspan="2" style="font-weight:bold; text-align:center; font-size:110%">TANGGAL</td>
                    <td width="18%" rowspan="2" style="font-weight:bold; text-align:center; font-size:110%">URAIAN</td>
                    <td rowspan="2" style="font-weight:bold; text-align:center; font-size:110%">MASUK</td>
                    <td rowspan="2" style="font-weight:bold; text-align:center; font-size:110%">HARGA BELI</td>
                    <td  rowspan="2" style="font-weight:bold; text-align:center; font-size:110%">KELUAR</td>
                    <td colspan="2" style="font-weight:bold; text-align:center; font-size:110%">SALDO</td>
                    <tr>
                        <td style="font-weight:bold; width:10px; text-align:center; font-size:110%">JUMLAH</td>
                        <td style="font-weight:bold; font-size:110%">NILAI</td>
                    </tr>
                </tr>';

                if($jenis=="tanggal") 
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC;";
                    $result = $this->query($sql);
                }
                elseif($jenis=="bulan")
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where month(tgl_dok)='$bulan' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where month(tgl_dok)='$bulan'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC";
                    $result = $this->query($sql);
                }
                else
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where year(tgl_dok)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where year(tgl_dok)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC";
                    $result = $this->query($sql);
                }

                $no=0;
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
                                <center><td  align="right">'.$data[harga_sat].'</td></center>
                                <center><td  align="center">'.'0'.'</td></center>';
                    }
                    else 
                    {
                    
                    echo '<center><td  align="center">'.'0'.'</td></center>
                                <center><td  align="right">'.abs($data[harga_sat]).'</td></center>
                                <center><td  align="center">'.abs($data[qty]).'</td></center>';
                    }

                    $saldo +=$data[qty]*abs($data[harga_sat]);
                    $jumlah+=$data[qty];
                    echo '<td>'.$jumlah.'</td>
                    <center><td align="right">'.$saldo.'</td></center>
                    </tr>';
                }

                echo '</table>';

                // $this->cetak_nama_pj($satker_asal);


         }



public function buku_persediaan_all_excel($data)
    {
        
        // $mpdf->setFooter('{PAGENO}');
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=tutorialweb-export.xls");
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
                    <x:Name>general_report</x:Name>
                    <x:WorksheetOptions>
                    <x:Print>
                    <x:ValidPrinterInfo/>
                    </x:Print>
                    </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                    </xml><![endif]-->'; 
        $jenis = $data['jenis'];
        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bulan = $data['bulan'];
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];
        $satker_asal = $data['satker_asal'];

        $list_brg = "SELECT kd_brg from transaksi_masuk where kd_lokasi='$kd_lokasi' group by kd_brg";
        $result_list = $this->query($list_brg);
        while($data=$this->fetch_assoc($result_list)) 
        {

        $kd_brg=$data['kd_brg'];
        if($kd_brg==""){
            continue;
        }
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where  kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        
        $this->getsatker($kd_lokasi);
        
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">BUKU PERSEDIAAN</p>
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

                if($jenis=="tanggal") 
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC;";
                    $result = $this->query($sql);
                }
                elseif($jenis=="bulan")
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where month(tgl_dok)='$bulan' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where month(tgl_dok)='$bulan'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC";
                    $result = $this->query($sql);
                }
                else
                {
                    $sql="SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where year(tgl_dok)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'   
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     
                                     union all 
                                     SELECT tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where year(tgl_dok)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi like '{$kd_lokasi}%'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_dok ASC";
                    $result = $this->query($sql);
                }

                $no=0;
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
                                <center><td  align="right">'.$data[harga_sat].'</td></center>
                                <center><td  align="center">'.'0'.'</td></center>';
                    }
                    else 
                    {
                    
                    echo '<center><td  align="center">'.'0'.'</td></center>
                                <center><td  align="right">'.abs($data[harga_sat]).'</td></center>
                                <center><td  align="center">'.abs($data[qty]).'</td></center>';
                    }

                    $saldo +=$data[qty]*abs($data[harga_sat]);
                    $jumlah+=$data[qty];
                    echo '<td>'.$jumlah.'</td>
                    <center><td align="right">'.$saldo.'</td></center>
                    </tr>';
                }

                echo '</table>';
                echo '<pagebreak />';
            }
                // $this->cetak_nama_pj($satker_asal);


        }

public function laporan_persediaan_excel($data)
    {
        
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=laporan_persediaan.xls");
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
                    <x:Name>general_report</x:Name>
                    <x:WorksheetOptions>
                    <x:Print>
                    <x:ValidPrinterInfo/>
                    </x:Print>
                    </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                    </xml><![endif]-->'; 
        

        $jenis = $data['jenis'];
        $bln_awal = $data['bln_awal'];
        $bln_akhir = $data['bln_akhir'];
        $tgl_akhir = $data['tgl_akhir'];

        $kd_brg = $data['kd_brg'];
        $thn_ang = $data['thn_ang'];
        $kd_lokasi = $data['kd_lokasi'];
        $date = $this->cek_periode($data);
        $satker_asal = $data['satker_asal'];

        // $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        // $result_detail = $this->query($detail_brg);
        // $brg = $this->fetch_array($result_detail);
        
        $this->getsatker($kd_lokasi);
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN PERSEDIAAN BARANG</p>
              <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
              <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
              <br></br>  
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    
                    <td  style="text-align: center;"><b>KODE</b></td>
                    <td  style="text-align: center;"><b>URAIAN</b></td>
                    <td  style="text-align: center;"><b>NILAI</b></td>
                </tr>';

                if($jenis=="tanggal")
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(total_harga) as nilai from 
                         (SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_masuk
                          UNION ALL
                          SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_keluar)
                          transaksi 
                            where kd_sskel not like '' and tgl_dok <= '$tgl_akhir' and kd_lokasi like '{$kd_lokasi}%'  AND thn_ang='$thn_ang' AND status_hapus=0 GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                elseif($jenis=="semester")
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, 
                          sum(case when month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir' then total_harga else 0 end) as nilai,
                          sum(case when month(tgl_dok) < '$bln_awal' then total_harga else 0 end) as nilai0
                         from 
                         (SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_masuk
                          UNION ALL
                          SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang,tgl_dok from transaksi_keluar)
                          transaksi 
                            where kd_sskel not like '' and kd_lokasi like '{$kd_lokasi}%'  AND thn_ang='$thn_ang' AND status_hapus=0 GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                else
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(total_harga) as nilai from 
                         (SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang from transaksi_masuk
                          UNION ALL
                          SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, total_harga,status_hapus,kd_lokasi,thn_ang from transaksi_keluar)
                          transaksi  
                          where kd_sskel not like '' and kd_lokasi like '{$kd_lokasi}%'  AND thn_ang='$thn_ang' AND status_hapus=0 GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                $no=0;
                $jumlah=0;
                $saldo=0;
                $prev_sskel=null;
                $prev_perk=null;
                while($data=$this->fetch_array($result))
                {
                    $no+=1;
                    if($prev_perk!=$data[kd_perk])
                    {
                        echo '
                        <tr style="font-size:45%;">
                                <td align="right" style="background-color:#DEDEDE; font-size:90%;"><b>'.$data[kd_perk].'</b></td>
                                <td colspan="2" align="left" style="background-color:#DEDEDE; font-size:90%;"><b>'.$data[nm_perk].'</b></td>
                              </tr> ';
                        $prev_perk=$data[kd_perk];
                    }                    

                    if($prev_sskel!=$data[kd_sskel])
                    {
                        echo '<tr >
                                <td align="right" style="font-size:90%;"><b>'.$data[kd_sskel].'</b></td>
                                <td colspan="2" align="left" style="font-size:90%;"><b>'.$data[nm_sskel].'</b></td>
                              </tr> ';
                        $prev_sskel=$data[kd_sskel];
                    }
                    $tot = $data[nilai]+$data[nilai0];
                    echo '<tr>
                             <td  align="right" style="font-size:90%;">'.substr($data[kd_brg],10).'</td> 
                             <td  align="left" style="font-size:90%;">'.' -'.$data[nm_brg].'</td> 
                             <td align="right" style="font-size:90%;">'.$tot.'</td> 
                        </tr>';

                    $saldo+=$data[nilai]+$data[nilai0];
                }
                echo '<tr>
                        <td colspan="2" style="font-size:90%;">JUMLAH</td>
                        <td align="right" style="font-size:90%;">'.$saldo.'</td>
                      </tr>';
                
                echo '</table>';
                if($no>=6)
                {
                echo '<pagebreak />';
                }
                $this->cetak_nama_pj($satker_asal);
    }


public function rincian_persediaan_excel($data)
    {
        
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=rincian_persediaan.xls");
        echo ' <html xmlns:o="urn:schemas-microsoft-com:office:office"
                    xmlns:x="urn:schemas-microsoft-com:office:excel"
                    xmlns="http://www.w3.org/TR/REC-html40">
                    <head>
                    <title>JIRA Issue Navigator for Excel (All)</title>
                    <META HTTP-EQUIV="Content-Type" Content="application/vnd.ms-excel; charset=utf-8">
                    <style>
                    @page
                    { mso-page-orientation:landscape;  margin:.25in .25in .5in .20in; mso-header-margin:.5in; mso-footer-margin:.25in; mso-footer-data:"&R&P of &N"; mso-horizontal-page-align:center;}
                    </style>
                    <!--[if gte mso 9]><xml>
                    <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                    <x:Name>general_report</x:Name>
                    <x:WorksheetOptions>
                    <x:Print>
                    <x:ValidPrinterInfo/>
                    </x:Print>
                    </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                    </xml><![endif]-->'; 
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

        
        $this->getsatker($kd_lokasi);
        $date = $this->cek_periode($data);
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN RINCIAN BARANG PERSEDIAAN</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                <br></br>

                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    <td rowspan="2" style="font-weight:bold; font-size:110%; text-align: center;">KODE BARANG</td>
                    <td  width="30%" rowspan="2" style="font-weight:bold; font-size:95%; text-align: center;" >URAIAN</td>
                    <td  width="20%" colspan="2" style="font-weight:bold; font-size:95%; text-align: center;"  >NILAI S/D 31 DESEMBER '.$thn_ang_lalu.'</td>
                    <td colspan="3" style="font-weight:bold; font-size:95%; text-align: center;">MUTASI</td>
                    <td colspan="2" style="font-weight:bold; font-size:95%; text-align: center;">NILAI</td>
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
                $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, 
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
                                    SELECT thn_ang,tgl_dok, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang,tgl_dok, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where kd_sskel not like '' and  kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                elseif($jenis=="tanggal")
                {
                $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, 
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty<0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty>=0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN total_harga else 0 end) + sum(case WHEN qty<0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN total_harga else 0 end) as nilai 
                                    FROM (
                                    SELECT thn_ang,tgl_dok, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang,tgl_dok, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where kd_sskel not like '' and  kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                else
                {
                $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, 
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and thn_ang='$thn_ang' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty<0 and thn_ang='$thn_ang' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty>=0 and thn_ang='$thn_ang' THEN total_harga else 0 end) + sum(case WHEN qty<0 and thn_ang='$thn_ang' THEN total_harga else 0 end) as nilai 
                                    FROM (
                                    SELECT thn_ang,kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT thn_ang,kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi
                                    where kd_sskel not like '' and  kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                $no=0;
                $total_thn_lalu=0;
                $total_akumulasi=0;
                $prev_sskel=null;
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
                    
                    if($prev_sskel!=$data[kd_sskel])
                    {
                        echo '<tr >
                                <td align="right" style="font-size:90%;"></td>
                                <td colspan="9" align="left" style="font-size:90%;"><b>'.$data[nm_sskel].'</b></td>
                              </tr> ';
                        $prev_sskel=$data[kd_sskel];
                    }

                    echo '<tr>
                             <td  align="center" style="font-size:90%;">'.substr($data[kd_brg],10).'</td> 
                             <td  align="left" style="font-size:90%;">'.$data[nm_brg].'</td> 
                             <td  align="center" style="font-size:90%;">'.$data[brg_thn_lalu].'</td> 
                             <td  align="right" style="font-size:90%;">'.$data[hrg_thn_lalu].'</td> 
                             <td align="center" style="font-size:90%;">'.$jml_msk.'</td> 
                             <td align="center" style="font-size:90%;">'.abs($jml_klr).'</td> 
                             <td align="center" style="font-size:90%;">'.$jumlah.'</td> 
                             <td align="center" style="font-size:90%;">'.$jml_selisih.'</td> 
                             <td align="right" style="font-size:90%;">'.$hrg_selisih.'</td> 
                        </tr>';
                }
                echo '<tr>
                            <td colspan="2">JUMLAH</td>  
                            <td colspan="2" align="right">'.$total_thn_lalu.'</td> 
                            <td colspan="3"></td>  
                            <td colspan="2" align="right">'.$total_akumulasi.'</td>  
                        </tr>';
                echo '</table>';
                if($no>=6)
                {
                echo '<pagebreak />';
                }
                $this->cetak_nama_pj($satker_asal);


         }

   public function neraca_excel($data)
    {
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=neraca.xls");
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
                    <x:Name>general_report</x:Name>
                    <x:WorksheetOptions>
                    <x:Print>
                    <x:ValidPrinterInfo/>
                    </x:Print>
                    </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                    </xml><![endif]-->';     
        
        $kd_lokasi = $data['kd_lokasi'];
        $kd_brg = $data['kd_brg'];
        $tgl_akhir = $data['tgl_akhir'];
        $thn_ang = $data['thn_ang'];
        $date = $this->cek_periode($data);
        $satker_asal = $data['satker_asal'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);

        
        $this->getsatker($kd_lokasi);
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN POSISI PERSEDIAAN DI NERACA</p>
                <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
                <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                <br></br>
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                        <td style="font-weight:bold; font-size:110%; text-align:center;">KODE</td>
                        <td style="font-weight:bold; font-size:110%; text-align:center;">URAIAN</td>
                        <td style="font-weight:bold; font-size:110%; text-align:center;">NILAI</td>
                </tr>';

                $sql="SELECT kd_perk, nm_perk, sum(total_harga) as nilai FROM (
                                    SELECT tgl_dok, thn_ang, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_masuk
                                    UNION ALL
                                    SELECT tgl_dok,thn_ang, kd_perk, nm_perk,qty, total_harga,status_hapus,kd_lokasi from transaksi_keluar
                                    ) transaksi where nm_perk not like '' and kd_lokasi like '{$kd_lokasi}%'  and thn_ang='$thn_ang' and status_hapus=0  and tgl_dok<='$tgl_akhir' GROUP BY kd_perk";
                $result = $this->query($sql);
                $no=0;
                $total=0;

                while($data=$this->fetch_assoc($result))
                {
                    $no+=1;
                    echo '<tr>
                             <td  align="center">'.$data[kd_perk].'</td> 
                             <td  align="left">'.$data[nm_perk].'</td> 
                             <td align="right">'.$data[nilai].'</td> </tr>';
                    $total+=$data[nilai];
                }
                    
                    echo '<tr>
                            <td colspan="2" style="font-weight:bold; text-align:center;">JUMLAH</td>  
                            <td align="right">'.$total.'</td>  
                        </tr>
                        </table>';
                if($no>=6)
                {
                echo '<pagebreak />';
                }
                $this->cetak_nama_pj($satker_asal);

}

public function mutasi_prsedia_excel($data)
    {
        
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=mutasi.xls");
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
                    <x:Name>general_report</x:Name>
                    <x:WorksheetOptions>
                    <x:Print>
                    <x:ValidPrinterInfo/>
                    </x:Print>
                    </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                    </xml><![endif]-->'; 
        $kd_lokasi = $data['kd_lokasi'];
        $kd_brg = $data['kd_brg'];
        $tgl_awal=$data['tgl_awal'];
        $tgl_akhir=$data['tgl_akhir'];
        $thn_ang = $data['thn_ang'];
        $thn_ang_lalu = intval($thn_ang)-1;
        $satker_asal = $data['satker_asal'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg'";
        $result_detail = $this->query($detail_brg);
        
        $this->getsatker($kd_lokasi);
        $date = $this->cek_periode($data);
        $brg = $this->fetch_array($result_detail);
        echo ' <p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN MUTASI BARANG PERSEDIAAN</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
               <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p>
                <br></br>
                <table style="text-align: center; width: 90%; " align="center">
                <tr>
                    
                </tr>                
                <tr>
                    
                </tr>               
                 <tr>
                    <td width="60%" align="left"></td>
                </tr>
                </table>
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    <td rowspan="2">KODE</td>
                    <td  width="30%" rowspan="2"  >URAIAN</td>
                    <td  width="13%" rowspan="2"  >NILAI S/D 31 DESEMBER '.$thn_ang_lalu.'</td>
                    <td colspan="2">MUTASI</td>
                    <td rowspan="2" width="13%">NILAI S/D '.$date.'</td>
                    <tr>
                        <td>Tambah</td>
                        <td>Kurang</td>
                    </tr> 
                </tr>';

                $sql="SELECT kd_perk,
                             nm_perk,
                             sum(case when year(tgl_dok)='$thn_ang_lalu' THEN total_harga else 0 end) as thn_lalu, 
                             sum(case when total_harga>=0 and thn_ang='$thn_ang' then total_harga else 0 end) as tambah, 
                             sum(case when total_harga<0 and thn_ang='$thn_ang' then total_harga else 0 end) as kurang 
                             FROM
                             (
                              SELECT tgl_dok, thn_ang, kd_perk, nm_perk, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                              UNION ALL
                              SELECT tgl_dok, thn_ang, kd_perk, nm_perk, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                             ) transaksi  
                              where kd_perk not like '' and kd_lokasi like '{$kd_lokasi}%'  and thn_ang>='$thn_ang_lalu' and status_hapus=0 and tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'
                              GROUP BY kd_perk";
                $result = $this->query($sql);
                $no=0;
                $total=0;
                $saldo_akhir=0;
                $saldo_thn_lalu=0;
                $saldo_akumulasi=0;
                while($data=$this->fetch_assoc($result))
                {   
                    $saldo_akhir=$data[thn_lalu]+$data[tambah]+$data[kurang];
                    $saldo_thn_lalu+=$data[thn_lalu];
                    $saldo_akumulasi+=$saldo_akhir;
                    echo '<tr>
                             <td  align="center">'.$data[kd_perk].'</td> 
                             <td  align="left">'.$data[nm_perk].'</td> 
                             <td align="right">'.$data[thn_lalu].'</td>
                             <td align="right">'.$data[tambah].'</td> 
                             <td align="right">'.abs($data[kurang]).'</td> 
                             <td align="right">'.$saldo_akhir.'</td> 
                           </tr>';
                    $total+=$data[nilai];
                }
                    
                    echo '<tr>
                            <td colspan="2">JUMLAH</td>  
                            <td align="right">'.$saldo_thn_lalu.'</td>
                            <td colspan="2"></td>  
                            <td align="right">'.$saldo_akumulasi.'</td>  
                        </tr>
                        </table>';
                if($no>=6)
                {
                echo '<pagebreak />';
                }
                $this->cetak_nama_pj($satker_asal);


         }


public function transaksi_persediaan_excel($data)
    {
        
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=daftar-transaksi.xls");
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
                    <x:Name>general_report</x:Name>
                    <x:WorksheetOptions>
                    <x:Print>
                    <x:ValidPrinterInfo/>
                    </x:Print>
                    </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                    </x:ExcelWorkbook>
                    </xml><![endif]-->';         

        $jenis = $data['jenis'];
        $kd_trans = $data['kd_trans'];
        $nm_trans = $data['nm_trans'];
        $bulan = $data['bulan'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];

        $kd_brg = $data['kd_brg'];
        $thn_ang = $data['thn_ang'];
        $kd_lokasi = $data['kd_lokasi'];


        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi like '{$kd_lokasi}%' ";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        
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

                if($jenis=="tanggal")
                {
                    $sql="SELECT 
                                        kd_sskel,
                                        nm_sskel, 
                                        kd_brg, 
                                        nm_brg, 
                                        kd_perk, 
                                        nm_perk, 
                                        sum(qty) as qty, 
                                        sum(total_harga) as harga 
                                        from (
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                                        UNION ALL
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                                        ) transaksi
                                        where 
                                            tgl_dok >= '$tgl_awal' and 
                                            tgl_dok <= '$tgl_akhir' and 
                                            kd_lokasi like '{$kd_lokasi}%'  AND 
                                            thn_ang='$thn_ang' and
                                            status_hapus = 0 and
                                            jns_trans='$kd_trans' 
                                        GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                elseif($jenis=="bulan")
                {
                    $sql="SELECT 
                                        kd_sskel, 
                                        nm_sskel, 
                                        kd_brg, 
                                        nm_brg, 
                                        kd_perk, 
                                        nm_perk, 
                                        sum(qty) as qty, 
                                        sum(total_harga) as harga 
                                        from (
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                                        UNION ALL
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                                        ) transaksi
                                        where 
                                            month(tgl_dok)='$bulan' and 
                                            kd_lokasi like '{$kd_lokasi}%'  AND 
                                            thn_ang='$thn_ang' AND
                                            status_hapus = 0 and
                                            jns_trans='$kd_trans' 
                                        GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                else
                {   
                    
                    $sql="SELECT 
                                        kd_sskel, 
                                        nm_sskel, 
                                        kd_brg, 
                                        nm_brg, 
                                        kd_perk, 
                                        nm_perk, 
                                        sum(qty) as qty, 
                                        sum(total_harga) as harga 
                                        from (
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_masuk
                                        UNION ALL
                                        SELECT tgl_dok, thn_ang, kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, qty, jns_trans, total_harga, status_hapus, kd_lokasi from transaksi_keluar
                                        ) transaksi 
                                        where 
                                            thn_ang='$thn_ang' and
                                            kd_lokasi like '{$kd_lokasi}%'  and
                                            status_hapus = 0 and
                                            jns_trans='$kd_trans'
                                        GROUP BY kd_brg
                                        ";
                    $result = $this->query($sql);

                }
  

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
                             <td align="center">'.$data[qty].'</td> 
                             <td align="center">'.$data[harga].'</td> 
                        </tr>';
                    $saldo+=$data[harga];
                }
                echo '<tr>
                        <td colspan="3">JUMLAH</td>
                        <td>'.$saldo.'</td>
                      </tr>';
                echo '</table>';

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
        echo '<table style="text-align: left; width: 50%; font-size:85% ">';
        if($detil[0]!="")
        {
        echo '
                    <tr>
                        <td>Sektor</td>
                        <td colspan="2">'.':  '.$nama_sektor.'</td>
                    </tr>';
        }
        if($detil[1]!="")
        {
        echo  ' 
                    <tr>
                        <td>Satker </td>
                        <td colspan="2">'.':  '.$nama_satker.'</td>
                    </tr>'; 
        }
        if($detil[2]!="")
        {               
        echo  '<tr>
                        <td>Unit </td>
                        <td colspan="2">'.':  '.$nama_unit.'</td>
                    </tr>';
        }
        if($detil[3]!="")
        { 
        echo            '<tr>
                        <td>Gudang </td>
                        <td colspan="2">'.':  '.$nama_gudang.'</td>
                    </tr>
                    <p></p>';
        }
        echo '</table>';
        echo '<br></br>';


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


        echo '
              <br></br>
              <table style="text-align: center; width: 100%; font-size:80% "  >
              <tr>
                <td style="text-align: center;"> Kuasa Pengguna Barang, </td>
                <td style="text-align: center;"> Petugas Pengelola Persediaan, </td>
              </tr>

              <tr>
                <td style="text-align: center;">'.$pj['jabatan'].'</td>
                <td style="text-align: center;">'.$pj['jabatan2'].'</td>
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
                <td style="text-align: center;">'.$pj['nip'].'</td>
                <td style="text-align: center;">'.$pj['nip2'].'</td>
              </tr>
              
              </table>';


    }

}





?>