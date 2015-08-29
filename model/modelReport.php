<?php
include('../../utility/mysql_db.php');
define('_MPDF_PATH','../../plugins/MPDF57/');
require(_MPDF_PATH."mpdf.php");
$host="localhost"; 
$user="root";
$password=""; 
$database="persediaan_v3";
mysql_connect($host,$user,$password);
mysql_select_db($database);


class modelReport extends mysql_db
{
    public function buku_persediaan($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start(); 

        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $kd_lokasi = $data['kd_lokasi'];

        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        
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
                <table style="text-align: center; width: 100%; border=1" border=1 align="center">
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


                $sql=mysql_query("SELECT tgl_buku, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                    FROM transaksi_masuk 
                                    where tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi='$kd_lokasi'  
                                     AND status_hapus=0
                                     union all 
                                     SELECT tgl_buku, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
                                     FROM transaksi_keluar 
                                     where tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' 
                                     AND kd_brg='$kd_brg' 
                                     and kd_lokasi='$kd_lokasi'  
                                     AND status_hapus=0
                                     ORDER BY tgl_buku ASC;");
                $no=0;
                $jumlah=0;
                $saldo=0;
                while($data=mysql_fetch_assoc($sql))
                {
                    $no+=1;
                    echo'<tr>
                    <center><td  align="center">'.$no.'</td></center>
                    <center><td  align="center">'.$data[tgl_buku].'</td></center>
                    <center><td  align="center">'.$data[keterangan].'</td></center>';
                    if($data[qty]>0) 
                    {
                        echo '<center><td  align="center">'.$data[qty].'</td></center> 
                                <center><td  align="center">'.$data[harga_sat].'</td></center>
                                <center><td  align="center">'.'0'.'</td></center>';
                    }
                    else {
                    echo '<center><td  align="center">'.'0'.'</td></center>
                                <center><td  align="center">'.abs($data[harga_sat]).'</td></center>
                                <center><td  align="center">'.abs($data[qty]).'</td></center>';
                    }
                    $saldo +=$data[qty]*abs($data[harga_sat]);
                    $jumlah+=$data[qty];
                    echo '<td>'.$jumlah.'</td>
                    <center><td align="center">'.$saldo.'</td></center>
                    </tr>';
                }
                echo '</table>';
                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output($nama_dokumen.".pdf" ,'I');
                exit;
         }

    public function laporan_persediaan($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start(); 
        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $kd_lokasi = $data['kd_lokasi'];
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
        echo ' 
                <table style="text-align: center; width: 90%; " align="center">
                <tr>
                    <td>LAPORAN PERSEDIAAN BARANG</td>
                </tr>
                <tr>
                    <td>UNTUK PERIODE YANG BERAKHIR TANGGAL '.date("d-m-Y",strtotime($tgl_akhir)).'</td>
                </tr>
                <tr>
                    <td>TAHUN ANGGARAN : '.substr($tgl_akhir,0,4).'</td>
                </tr>
                <tr>

                </tr>                
                <tr>

                </tr>               
                 <tr>
                    <td width="60%" align="left"></td>
                </tr>
                </table>
                <table style="text-align: center; width: 90%; border=1" border=1 align="center">
                <tr>
                    
                    <td width="18%"><b>KODE</b></td>
                    <td width="50%"><b>URAIAN</b></td>
                    <td><b>NILAI</b></td>
                </tr>';


                $sql=mysql_query("SELECT kd_sskel, nm_sskel, kd_brg, nm_brg, kd_perk, nm_perk, sum(total_harga) as nilai from transaksi_full where tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' and kd_lokasi='$kd_lokasi' GROUP BY kd_brg");
                $no=0;
                $jumlah=0;
                $saldo=0;
                $prev_sskel=null;
                $prev_perk=null;
                while($data=mysql_fetch_assoc($sql))
                {
                    $no+=1;
                    if($prev_perk!=$data[nm_sskel])
                    {
                        echo '
                        <tr >
                                <td align="right" ><b>'.$data[kd_perk].'</b></td>
                                <td colspan="2" align="left"><b>'.$data[nm_perk].'</b></td>
                              </tr> ';
                    }                    

                    if($prev_sskel!=$data[nm_sskel])
                    {
                        echo '<tr >
                                <td align="right" ><b>'.$data[kd_sskel].'</b></td>
                                <td colspan="2" align="left"><b>'.$data[nm_sskel].'</b></td>
                              </tr> ';
                    }

                    echo '<tr>
                             <td  align="right">'.substr($data[kd_brg],10).'</td> 
                             <td  align="left">'.$data[nm_brg].'</td> 
                             <td align="center">'.number_format($data[nilai]).'</td> 
                        </tr>';
                    $saldo+=$data[nilai];
                }
                echo '<tr>
                        <td colspan="2">JUMLAH</td>
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

    public function mutasi_persediaan($data)
    {
        $mpdf=new mPDF('utf-8', 'A4-L');
        ob_start(); 
        $kd_brg = $data['kd_brg'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $kd_lokasi = $data['kd_lokasi'];
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
                <table style="text-align: center; width: 90%; border=1" border=1 align="center">
                <tr>
                    <td rowspan="2">KODE BARANG</td>
                    <td  width="50%" rowspan="2"  >URAIAN</td>
                    <td colspan="3">MUTASI</td>
                    <td colspan="2">NILAI</td>
                    <tr>
                        <td>Tambah</td>
                        <td>Kurang</td>
                        <td>Jumlah</td>
                        <td>JUMLAH</td>
                        <td>RUPIAH</td>
                    </tr>  
                </tr>';

                $sql=mysql_query("SELECT kd_brg, nm_brg, sum(case WHEN jns_trans like 'M%' THEN qty else 0 end) as masuk, sum(case WHEN jns_trans like 'K%' THEN qty else 0 end) as keluar,
                                    sum(case WHEN jns_trans like 'M%' THEN qty else 0 end) + sum(case WHEN jns_trans like 'K%' THEN qty else 0 end) as jumlah, sum(case WHEN jns_trans like 'M%' THEN total_harga else 0 end) + sum(case WHEN jns_trans like 'K%' THEN total_harga else 0 end) as nilai 
                                    FROM transaksi
                                    where tgl_buku BETWEEN '$tgl_awal' AND '$tgl_akhir' and kd_lokasi='$kd_lokasi'
                                    GROUP by kd_brg");
                // $sql=mysql_query("SELECT kd_brg, nm_brg, 
                //                     sum(case when qty > 0 then qty else 0) as masuk,
                //                     sum(case when qty < 0 then qty else 0) as keluar,
                //                     sum(total_harga) as nilai
                //                     FROM transaksi_full
                //                      where  kd_lokasi='$kd_lokasi'
                //                      GROUP by kd_brg");
                $no=0;
                while($data=mysql_fetch_assoc($sql))
                {
                    $no+=1;
                    echo '<tr>
                             <td  align="center">'.$data[kd_brg].'</td> 
                             <td  align="left">'.$data[nm_brg].'</td> 
                             <td align="center">'.$data[masuk].'</td> 
                             <td align="center">'.abs($data[keluar]).'</td> 
                             <td align="center">'.$data[jumlah].'</td> 
                             <td align="center">'.$data[jumlah].'</td> 
                             <td align="center">'.$data[nilai].'</td> 
                        </tr>';
                }
                echo '</table>';
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
        $kd_brg = $data['kd_brg'];
        $detail_brg = "SELECT nm_brg, satuan,kd_lokasi from persediaan where kd_brg='$kd_brg'";
        $result_detail = $this->query($detail_brg);
        $brg = $this->fetch_array($result_detail);
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
                <table style="text-align: center; width: 90%; border=1" border=1 align="center">
                <tr>
                        <td>KODE</td>
                        <td>URAIAN</td>
                        <td>NILAI</td>
                </tr>';

                $sql=mysql_query("SELECT kd_perk, nm_perk, sum(total_harga) as nilai FROM transaksi GROUP BY kd_perk");
                $no=0;
                $total=0;
                while($data=mysql_fetch_assoc($sql))
                {
                    $no+=1;
                    echo '<tr>
                             <td  align="center">'.$data[kd_perk].'</td> 
                             <td  align="left">'.$data[nm_perk].'</td> 
                             <td align="center">'.$data[nilai].'</td> </tr>';
                    $total+=$data[nilai];
                }
                    
                    echo '<tr>
                            <td colspan="2">JUMLAH</td>  
                            <td>'.$total.'</td>  
                        </tr>
                        </table>';
                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output($nama_dokumen.".pdf" ,'I');
                exit;
         }
}





?>