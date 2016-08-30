<?php
include('../../model/modelReport.php');
define('_MPDF_PATH','../../plugins/mPDF/');
require(_MPDF_PATH."mpdf.php");
session_start();

class modelReportLanjut extends modelReport
{
    public function lapooran_per_rekening($data){
        
        $kd_lokasi = $data_lp['kd_lokasi'];
        $satker_asal = $data_lp['satker_asal'];
        $format = $data_lp['format'];
        $lingkup = $data_lp['lingkup'];

        $date = $this->cek_periode($data);
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN POSISI PERSEDIAAN DI NERACA PER REKENING</p>
            <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
            <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p><br></br>';
        $this->getsatker($kd_lokasi);
        echo '<table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 align="center">
                      <tr>
                          <td width="5%"><b>NO</b></td>
                          <td width="10%"><b>REK. PERSEDIAAN</b></td>
                          <td ><b>URAIAN REK. PERSEDIAAN</b></td>
                          <td width="10%"><b>REK. BELANJA</b></td>
                          <td ><b>URAIAN REK. BELANJA</b></td>
                          <td><b>NILAI PERSEDIAN</b></td>
                          <td><b>NILAI NON PERSEDIAN</b></td>
                      </tr>';
        $sql    = "SELECT kd_perk, nm_perk, kode_rekening, nama_rekening, total_harga from transaksi masuk   where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' and thn_ang='$thn_ang' and tgl_dok>'$tgl_dok'";
        $no=1;
        $result = $this->query($sql);
        foreach ($variable as $val) {
            echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$val['kd_perk'].'</td>
                    <td>'.$val['nm_perk'].'</td>
                    <td>'.$val['kode_rekening'].'</td>
                    <td>'.$val['nama_rekening'].'</td>
                    <td>'.$val['total_harga'].'</td>    
                    <td>'.'0'.'</td>
                   </tr>';
        }
    }
}





?>