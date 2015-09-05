<?php
include('../../utility/mysql_db.php');
define('_MPDF_PATH','../../plugins/mPDF/');
require(_MPDF_PATH."mpdf.php");

class modelReport extends mysql_db
{
    public function buku_persediaan($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start(); 
        $jenis = $data['jenis'];
        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bulan = $data['bulan'];
        $kd_lokasi = $data['kd_lokasi'];
        $thn_ang = $data['thn_ang'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);

        $this->getsatker($kd_lokasi);
        
        echo ' <p align="center">BUKU PERSEDIAAN</p>
                <br></br>
                <table style="text-align: center; width: 100%; " align="left">
                <tr>
                    <td width="60%" align="left"></td>
                    <td align="left">Kode Barang :'.$kd_brg.'</td>
                </tr>                
                <tr>
                    <td width="60%" align="left"></td>
                    <td align="left">Nama Barang :'.$brg['nm_brg'].'</td>
                </tr>                
                <tr>
                    <td width="60%" align="left"></td>
                    <td align="left">Satuan :'.$brg['satuan'].'</td>
                </tr>
                </table>
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    <td rowspan="2" >No</td>
                    <td  rowspan="2">Tanggal</td>
                    <td width="18%" rowspan="2">Uraian</td>
                    <td rowspan="2" >Masuk</td>
                    <td rowspan="2" >Harga Beli</td>
                    <td  rowspan="2">Keluar</td>
                    <td colspan="2">Saldo</td>
                    <tr>
                        <td >Jumlah</td>
                        <td>Nilai</td>
                    </tr>
                </tr>';

                if($jenis=="tanggal") 
                {
                    $sql="SELECT tgl_buku, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi='$kd_lokasi'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_buku, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi='$kd_lokasi'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_buku ASC;";
                    $result = $this->query($sql);
                }
                elseif($jenis=="bulan")
                {
                    $sql="SELECT tgl_buku, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where month(tgl_buku)='$bulan' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi='$kd_lokasi'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     union all 
                                     SELECT tgl_buku, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where month(tgl_buku)='$bulan'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi='$kd_lokasi'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_buku ASC";
                    $result = $this->query($sql);
                }
                else
                {
                    $sql="SELECT tgl_buku, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where year(tgl_buku)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi='$kd_lokasi'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
                                     
                                     union all 
                                     SELECT tgl_buku, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where year(tgl_buku)='$thn_ang'  
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi='$kd_lokasi'  
                                     AND status_hapus=0
                                     AND thn_ang='$thn_ang'
 
                                     ORDER BY tgl_buku ASC";
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
                    <center><td  align="center">'.$data[tgl_buku].'</td></center>
                    <center><td  align="center">'.$data[keterangan].'</td></center>';
                    if($data[qty]>0) 
                    {
                        echo '<center><td  align="center">'.$data[qty].'</td></center> 
                                <center><td  align="right">'.number_format($data[harga_sat],0,",",".").'</td></center>
                                <center><td  align="center">'.'0'.'</td></center>';
                    }
                    else {
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
        ob_start(); 

        $jenis = $data['jenis'];
        $bln_awal = $data['bln_awal'];
        $bln_akhir = $data['bln_akhir'];
        $tgl_akhir = $data['tgl_akhir'];

        $kd_brg = $data['kd_brg'];
        $thn_ang = $data['thn_ang'];
        $kd_lokasi = $data['kd_lokasi'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        $this->getsatker($kd_lokasi);
        echo ' 
                <table style="text-align: center; width: 90%; " align="center">
                <tr>
                    <td>LAPORAN PERSEDIAAN BARANG</td>
                </tr>
                <tr>
                    
                </tr>
                <tr>
                    <td>TAHUN ANGGARAN : '.$thn_ang.'</td>
                </tr>
                <tr>

                </tr>                
                <tr>

                </tr>               
                 <tr>
                    <td width="60%" align="left"></td>
                </tr>
                <br></br>
                <br></br>
                </table>
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                    
                    <td width="18%"><b>KODE</b></td>
                    <td width="50%"><b>URAIAN</b></td>
                    <td><b>NILAI</b></td>
                </tr>';

                if($jenis=="tanggal")
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(total_harga) as nilai from transaksi_full where tgl_buku <= '$tgl_akhir' and kd_lokasi='$kd_lokasi' AND thn_ang='$thn_ang' GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                elseif($jenis=="semester")
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(total_harga) as nilai from transaksi_full where month(tgl_buku) >= '$bln_awal' and month(tgl_buku) <= '$bln_akhir' and kd_lokasi='$kd_lokasi' AND thn_ang='$thn_ang' GROUP BY kd_brg";
                    $result = $this->query($sql);
                }
                else
                {
                    $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(total_harga) as nilai from transaksi_full where kd_lokasi='$kd_lokasi' AND thn_ang='$thn_ang' GROUP BY kd_brg";
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
                        <tr >
                                <td align="right" ><b>'.$data[kd_perk].'</b></td>
                                <td colspan="2" align="left"><b>'.$data[nm_perk].'</b></td>
                              </tr> ';
                        $prev_perk=$data[kd_perk];
                    }                    

                    if($prev_sskel!=$data[kd_sskel])
                    {
                        echo '<tr >
                                <td align="right" ><b>'.$data[kd_sskel].'</b></td>
                                <td colspan="2" align="left"><b>'.$data[nm_sskel].'</b></td>
                              </tr> ';
                        $prev_sskel=$data[kd_sskel];
                    }

                    echo '<tr>
                             <td  align="right">'.substr($data[kd_brg],10).'</td> 
                             <td  align="left">'.$data[nm_brg].'</td> 
                             <td align="right">'.number_format($data[nilai],0,",",".").'</td> 
                        </tr>';
                    $saldo+=$data[nilai];
                }
                echo '<tr>
                        <td colspan="2">JUMLAH</td>
                        <td align="right">'.number_format($saldo,0,",",".").'</td>
                      </tr>';
                
                echo '</table>';
                $this->hitung_brg_rusak($kd_lokasi);
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
        $this->getsatker($kd_lokasi);
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo ' <p align="center">LAPORAN MUTASI BARANG PERSEDIAAN</p>
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
                    <td rowspan="2">KODE BARANG</td>
                    <td  width="30%" rowspan="2"  >URAIAN</td>
                    <td  width="20%" colspan="2"  >NILAI S/D 31 DESEMBER '.$thn_ang_lalu.'</td>
                    <td colspan="3">MUTASI</td>
                    <td colspan="2">NILAI</td>
                    <tr>
                        <td>JUMLAH</td>
                        <td>RUPIAH</td>
                        <td>Tambah</td>
                        <td>Kurang</td>
                        <td>Jumlah</td>
                        <td>JUMLAH</td>
                        <td>RUPIAH</td>
                    </tr>  
                </tr>';
                if($jenis=="semester")
                {
                $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, 
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and month(tgl_buku) >= '$bln_awal' and month(tgl_buku) <= '$bln_akhir' and thn_ang='$thn_ang' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty<0 and month(tgl_buku) >= '$bln_awal' and month(tgl_buku) <= '$bln_akhir' and thn_ang='$thn_ang' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty>=0 and month(tgl_buku) >= '$bln_awal' and month(tgl_buku) <= '$bln_akhir' and thn_ang='$thn_ang' THEN total_harga else 0 end) + 
                                    sum(case WHEN qty<0 and month(tgl_buku) >= '$bln_awal' and month(tgl_buku) <= '$bln_akhir' and thn_ang='$thn_ang' THEN total_harga else 0 end) as nilai 
                                    FROM transaksi
                                    where  kd_lokasi='$kd_lokasi' and thn_ang>='$thn_ang_lalu' and status_hapus=0
                                    GROUP by kd_brg";
                $result = $this->query($sql);
                }
                elseif($jenis=="tanggal")
                {
                $sql="SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, 
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN qty else 0 end) as brg_thn_lalu,  
                                    sum(case WHEN thn_ang='$thn_ang_lalu' THEN total_harga else 0 end) as hrg_thn_lalu,  
                                    sum(case WHEN qty>=0 and tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN qty else 0 end) as masuk, 
                                    sum(case WHEN qty<0 and tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN qty else 0 end) as keluar,
                                    sum(case WHEN qty>=0 and tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN total_harga else 0 end) + sum(case WHEN qty<0 and tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' THEN total_harga else 0 end) as nilai 
                                    FROM transaksi
                                    where  kd_lokasi='$kd_lokasi' and thn_ang>='$thn_ang_lalu' and status_hapus=0
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
                                    FROM transaksi
                                    where  kd_lokasi='$kd_lokasi' and thn_ang>='$thn_ang_lalu' and status_hapus=0
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
                    $jumlah = $data[masuk]+$data[keluar];
                    $jml_selisih = $data[brg_thn_lalu]+$data[masuk]+$data[keluar];
                    $hrg_selisih = $data[hrg_thn_lalu]+$data[nilai];
                    $total_thn_lalu+=$data[hrg_thn_lalu];
                    $total_akumulasi+=$hrg_selisih;
                    
                    if($prev_sskel!=$data[kd_sskel])
                    {
                        echo '<tr >
                                <td align="right" ></td>
                                <td colspan="9" align="left"><b>'.$data[nm_sskel].'</b></td>
                              </tr> ';
                        $prev_sskel=$data[kd_sskel];
                    }

                    echo '<tr>
                             <td  align="center">'.$data[kd_brg].'</td> 
                             <td  align="left">'.$data[nm_brg].'</td> 
                             <td  align="center">'.$data[brg_thn_lalu].'</td> 
                             <td  align="right">'.number_format($data[hrg_thn_lalu],0,",",".").'</td> 
                             <td align="center">'.$data[masuk].'</td> 
                             <td align="center">'.abs($data[keluar]).'</td> 
                             <td align="center">'.$jumlah.'</td> 
                             <td align="center">'.$jml_selisih.'</td> 
                             <td align="right">'.number_format($hrg_selisih,0,",",".").'</td> 
                        </tr>';
                }
                echo '<tr>
                            <td colspan="2">JUMLAH</td>  
                            <td colspan="2" align="right">'.number_format($total_thn_lalu,0,",",".").'</td> 
                            <td colspan="3"></td>  
                            <td colspan="2" align="right">'.number_format($total_akumulasi,0,",",".").'</td>  
                        </tr>';
                echo '</table>';
                $this->hitung_brg_rusak($kd_lokasi);
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
        ob_start(); 
        $kd_lokasi = $data['kd_lokasi'];
        $kd_brg = $data['kd_brg'];
        $tgl_akhir = $data['tgl_akhir'];
        $thn_ang = $data['thn_ang'];
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        $this->getsatker($kd_lokasi);
        echo ' <p align="center">LAPORAN POSISI PERSEDIAAN DI NERACA</p>
                <br></br>
                <table style="text-align: center; width: 90%; " align="center">
                <tr>
                    <td width="60%" align="left">UAKPB :'.''.'</td>
                </tr>                
                <tr>
                    <td width="60%" align="left">Kode UAKPB :'.''.'</td>
                </tr>               
                 <tr>
                    <td width="60%" align="left"></td>
                </tr>
                </table>
                <table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                <tr>
                        <td>KODE</td>
                        <td>URAIAN</td>
                        <td>NILAI</td>
                </tr>';

                $sql="SELECT kd_perk, nm_perk, sum(total_harga) as nilai FROM transaksi where kd_lokasi='$kd_lokasi' and thn_ang='$thn_ang' and status_hapus=0  and tgl_buku<='$tgl_akhir' GROUP BY kd_perk";
                $result = $this->query($sql);
                $no=0;
                $total=0;

                while($data=$this->fetch_assoc($result))
                {
                    $no+=1;
                    echo '<tr>
                             <td  align="center">'.$data[kd_perk].'</td> 
                             <td  align="left">'.$data[nm_perk].'</td> 
                             <td align="center">'.number_format($data[nilai],0,",",".").'</td> </tr>';
                    $total+=$data[nilai];
                }
                    
                    echo '<tr>
                            <td colspan="2">JUMLAH</td>  
                            <td>'.number_format($total,0,",",".").'</td>  
                        </tr>
                        </table>';

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
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo ' <p align="center">LAPORAN MUTASI BARANG PERSEDIAAN</p>
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
                    <td rowspan="2" width="13%">NILAI S/D 31 DESEMBER '.$thn_ang.'</td>
                    <tr>
                        <td>Tambah</td>
                        <td>Kurang</td>
                    </tr> 
                </tr>';

                $sql="SELECT kd_perk, nm_perk, sum(case when year(tgl_buku)='$thn_ang_lalu' THEN total_harga else 0 end) as thn_lalu, sum(case when total_harga>=0 and thn_ang='$thn_ang' then total_harga else 0 end) as tambah, sum(case when total_harga<0 and thn_ang='$thn_ang' then total_harga else 0 end) as kurang FROM transaksi where kd_lokasi='$kd_lokasi' and thn_ang>='$thn_ang_lalu' GROUP BY kd_perk";
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
                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output($nama_dokumen.".pdf" ,'I');
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

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi'";
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
                                        from transaksi_full 
                                        where 
                                            tgl_buku >= '$tgl_awal' and 
                                            tgl_buku <= '$tgl_akhir' and 
                                            kd_lokasi='$kd_lokasi' AND 
                                            thn_ang='$thn_ang' and
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
                                        from transaksi_full 
                                        where 
                                            month(tgl_buku)='$bulan' and 
                                            kd_lokasi='$kd_lokasi' AND 
                                            thn_ang='$thn_ang' AND
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
                                        from transaksi_full 
                                        where 
                                            thn_ang='$thn_ang' and
                                            kd_lokasi='$kd_lokasi' and
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

        echo '<table style="text-align: left; width: 50%; ">
                    <tr>
                        <td>Sektor</td>
                        <td>'.':  '.$nama_sektor.'</td>
                    </tr>                
                    <tr>
                        <td>Satker </td>
                        <td>'.':  '.$nama_satker.'</td>
                    </tr>                
                    <tr>
                        <td>Unit </td>
                        <td>'.':  '.$nama_unit.'</td>
                    </tr>                
                    </table>';



    }

    public function hitung_brg_rusak($kd_lokasi)
    {
        $query_rusak = "SELECT sum(total_harga) as saldo_rusak from transaksi_keluar where kd_lokasi='$kd_lokasi' and jns_trans='K03' and status_hapus=0";
        $result_rusak = $this->query($query_rusak);
        $data_rusak = $this->fetch_array($result_rusak);
        $saldo_rusak = 0 +$data_rusak['saldo_rusak'];        

        $query_usang = "SELECT sum(total_harga) as saldo_usang from transaksi_keluar where kd_lokasi='$kd_lokasi' and jns_trans='K02' and status_hapus=0";
        $result_usang = $this->query($query_usang);
        $data_usang = $this->fetch_array($result_usang);
        $saldo_usang = 0+$data_usang['saldo_usang'];
        echo '
        <tr><b>Keterangan :</b></tr><br>        
                    <tr>1. Persediaan Senilai Rp. '.abs($saldo_rusak).',- dalam kondisi rusak</tr> <br>               
                    <tr>2. Persediaan Senilai Rp. '.abs($saldo_usang).',- dalam kondisi usang</tr>                
             
                    ';


    }

}





?>