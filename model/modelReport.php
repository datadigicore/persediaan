<?php
include('../../utility/mysql_db.php');
include '../../utility/optbs/tbs_class.php';
include '../../utility/optbs/tbs_plugin_opentbs.php';
include '../../utility/PHPExcel/IOFactory.php';
define('_MPDF_PATH','../../plugins/mPDF/');
require(_MPDF_PATH."mpdf.php");
session_start();

class modelReport extends mysql_db
{

    public function baca_nomor_dok($data){
        $kd_lokasi  = $data['kd_lokasi'];
        $kd_ruang   = $data['kd_ruang'];
        $thn_ang    = $data['thn_ang'];
        $cond_ruang;
        if($kd_ruang!=''){
            $cond_ruang = " and kd_ruang = '$kd_ruang' ";
        }

        $sql  = "select no_dok from transaksi_keluar where kd_lokasi='$kd_lokasi' ".$cond_ruang." GROUP BY no_dok asc ";
        // echo $sql;
        $result = $this->query($sql);
        echo '<option value="">-- Pilih Nomor Dokumen --</option>';
        foreach ($result as $value) {
         echo '<option value="'.$value['no_dok'].'">'.$value['no_dok']."</option>";
     }
 }
 public function save_excel(){
    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
    $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template); 
    if ($save_as==='') { 
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
        exit(); 
    } 
    else { 
        $TBS->Show(OPENTBS_FILE, $output_file_name);  
        exit("File [$output_file_name] has been created."); 
    } 
}

public function bacabrg($data)
{
    $kd_ruang = trim($data['kd_ruang']);
    $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $thn_ang = $data['thn_ang'];
    $query_satker = " kd_lokasi like '$kd_lokasi%' ";
    if($kd_ruang!='') $query_satker = " concat(kd_lokasi, IFNULL(kd_ruang,''))='$kd_lokasi' ";
    $query = "select kd_brg, nm_brg,spesifikasi FROM transaksi_masuk where ".$query_satker." and thn_ang='$thn_ang' and kd_brg not like '' GROUP BY kd_brg ORDER BY nm_brg ASC ";
        // echo $query;
    $result = $this->query($query);
    echo '<option value="">-- Pilih Kode Barang --</option>';
    echo '<option value="all">Semua Barang</option>';

    while ($row = $this->fetch_array($result))
    {
        echo '<option value="'.$row['kd_brg'].'">'.$row['kd_brg'].' '.$row['nm_brg']." ".$row['spesifikasi']."</option>";
    }   
}

public function baca_satker($kd_lokasi)
{
    $query = "select kode, NamaSatker from satker where kode like '{$kd_lokasi}%' and kd_ruang is null order by kode asc";
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
    $query = "SELECT kode, NamaSatker FROM satker where concat(kode,' ',NamaSatker) like '%$kd_lokasi%'  order by kode asc";
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
    $query = "SELECT kode, NamaSatker FROM satker where  concat(kode,' ',NamaSatker) like '%$kd_lokasi%' and char_length(kode)=11  and kd_ruang is null  order by kode asc";
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

    $query = "select kode, NamaSatker from satker where kode like '$kd_lokasi%' and char_length(kode)=11  and kd_ruang is null order by kode asc";
    $result = $this->query($query);
    $json = array();
    echo '<option value="">-- Pilih Kode Satker --</option>';
    while ($row = $this->fetch_array($result))
    {
            // $str = $row['kode'];
            // if (substr_count($str,".") == 3) {
        echo '<option value="'.$row['kode'].'">'.$row['kode'].'        '.$row['NamaSatker']."</option>";
             // }
    } 
}

public function query_brg($kd_brg,$kd_lokasi){
    $kd_lokasi.=$_SESSION['kd_ruang'];
    $where = "";
    if($kd_brg!=="all"){
        $where = " and kd_brg='$kd_brg' ";
    }
    $list_brg = "SELECT kd_brg from transaksi_masuk where concat(kd_lokasi,IFNULL(kd_ruang,'')='$kd_lokasi') ".$where." group by kd_brg order by nm_brg asc";
    $kode = $this->query($list_brg);
    return $kode;
}

public function rekap_per_dok($data){

    $kd_lokasi          = $data['kd_lokasi']; 
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $satker_asal        = $data['satker_asal'];
    $thn_ang            = $data['thn_ang'];
    $lingkup            = $data['lingkup'];
    $tgl_awal           = $data['tgl_awal'];
    $tgl_akhir          = $data['tgl_akhir'];
    $jenis              = $data['format'];
    $rinci_per_dok      = $data['rinci_per_dok'];
    $date               = $this->cek_periode($data);
        // ob_start();
    $this->getsatker($kd_lokasi);
    $sql        = "SELECT kd_lokasi, nm_satker, no_dok, kd_perk, nilai_kontrak, nm_perk, kode_rekening, nama_rekening, jns_trans, nm_brg, qty,satuan, harga_sat, total_harga, nilai_kontrak, ket_rek, jns_trans 
    FROM transaksi_masuk   
    WHERE concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$kd_lokasi' 
        AND jns_trans!='M01' 
        AND IFNULL(kd_ruang,'')='$kd_ruang' 
        AND thn_ang='$thn_ang' 
        AND tgl_dok<='$tgl_akhir'   
        AND no_dok!='' 
        AND total_harga+nilai_kontrak > 0
    ORDER BY no_dok asc";

    $result     = $this->query($sql);
    $no                     =1;
    $rek_persediaan         ="";
    $rek_keuangan           ="";
    $nilai_rek_persediaan   =0;
    $nilai_non_persediaan   =0;
    $grand_total_persediaan   =0;
    $grand_total_nonpersediaan   =0;
    $flagDok                ="";
    $rekap = array();
    $rekap2 = array();
    $dataPerSKPD = array();

    echo "<pre>";
    foreach ($result as $key => $value) {
        // print_r($value);
        // $dataPerSKPD["$value[kd_lokasi]"]['nm_satker'] = $value['nm_satker'];

            $dataPerSKPD[$value['no_dok']]['rek_belanja']
                               [$value['kode_rekening']]['nama_rekening'] = $value['nama_rekening'];
            $dataPerSKPD[$value['no_dok']]['rek_belanja']
                               [$value['kode_rekening']]['nilai_kontrak'] += $value['nilai_kontrak'];
            $dataPerSKPD[$value['no_dok']]['rek_belanja']
                               [$value['kode_rekening']]['total_harga'] += $value['total_harga']; 
            switch ($value['jns_trans']) {
                case  "M07":
                    $dataPerSKPD[$value['no_dok']]['rek_belanja']
                                       [$value['kode_rekening']]['sumber_dana'] = "APBD";
                    break;
                case  "M10":
                    $dataPerSKPD[$value['no_dok']]['rek_belanja']
                                       [$value['kode_rekening']]['sumber_dana'] = "BOS";
                    break;
                case  "M11":
                    $dataPerSKPD[$value['no_dok']]['rek_belanja']
                                       [$value['kode_rekening']]['sumber_dana'] = "BLUD";
                break;
                case  "M12":
                    $dataPerSKPD[$value['no_dok']]['rek_belanja']
                                       [$value['kode_rekening']]['sumber_dana'] = "Lainnya";
                break;
                default:
                    $dataPerSKPD[$value['no_dok']]['rek_belanja']
                                       [$value['kode_rekening']]['sumber_dana'] = "Bantuan Pemprov / Pusat";
                break;
            }
            $dataPerSKPD[$value['no_dok']]['rek_belanja'][$value['kode_rekening']]['rek_persediaan'][$value['kd_perk']]['total_harga'] += $value['total_harga']; 
            $dataPerSKPD[$value['no_dok']]['rek_belanja'][$value['kode_rekening']]['rek_persediaan'][$value['kd_perk']]['nm_perk'] = $value['nm_perk']; 
            $dataPerSKPD[$value['no_dok']]['rek_belanja'][$value['kode_rekening']]['rek_persediaan'][$value['kd_perk']]['barang'][] = $value;

            $nilai_rek_persediaan   +=$value['total_harga'];
            $nilai_non_persediaan   +=$value['nilai_kontrak'];
  
    }
    // print_r($dataPerSKPD);
    // exit;


    if($jenis=="excel"){

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator($_SESSION['nm_satker'])
                  ->setLastModifiedBy("")
                  ->setTitle("LAPORAN SALDO REKENING PERSEDIAAN");
        $border = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $default_border = array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          );

              $horizontal = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  )
              );
              $vertical = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  )
              );
              $left = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  )
              );
              $right = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                  )
              );
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);


        $objPHPExcel->getActiveSheet()->getStyle('A12:L12')->getAlignment()->setWrapText(true); 



        $sheet = $objPHPExcel->getActiveSheet()->setTitle("Lap. Saldo Persediaan");
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A5:B5');
        $sheet->mergeCells('A6:B6');
        $sheet->mergeCells('A7:B7');
        $sheet->mergeCells('A8:B8');
        $sheet->mergeCells('A9:B9');
        $sheet->mergeCells('A10:B10');

        $sheet->getStyle("A12:L12")->applyFromArray($border);
        $objPHPExcel->getActiveSheet()->getRowDimension("12")->setRowHeight(40);

        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->applyFromArray($horizontal);    
        $sheet->getStyle('A1:A3')->applyFromArray($vertical);
        $sheet->getStyle('A12:L12')->applyFromArray($horizontal);    
        $sheet->getStyle('A12:L12')->applyFromArray($vertical);
        $skpd = $this->getsatker($kd_lokasi);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',"LAPORAN BELANJA PERSEDIAAN PER DOKUMEN" )
                ->setCellValue('A2',"PERIODE ".$date)
                ->setCellValue('A3',"TAHUN ANGGARAN ".$thn_ang )
                ->setCellValue('A5',"Provinsi" )
                ->setCellValue('A6',"Kabupaten / Kota" )
                ->setCellValue('A7',"Bidang" )
                ->setCellValue('A8',"Unit Organisasi" )
                ->setCellValue('A9',"Sub Unit Organisasi" )
                ->setCellValue('A10',"UPB" )                
                ->setCellValue('C5',": Jawa Tengah" )
                ->setCellValue('C6',": Kota Pekalongan" )
                ->setCellValue('C7',": ".$skpd['nama_sektor'] )
                ->setCellValue('C8',": ".$skpd['nama_satker'] )
                ->setCellValue('C9',": ".$skpd['nama_unit'] )
                ->setCellValue('C10',": ".$skpd['nama_gudang'] )                
                ->setCellValue('A12',"NO" )
                ->setCellValue('B12',"NOMOR DOKUMEN" )
                ->setCellValue('C12',"REKENING BELANJA" )
                ->setCellValue('D12',"URAIAN REK. BELANJA" )
                ->setCellValue('E12',"REKENING PERSEDIAAN" )
                ->setCellValue('F12',"URAIAN REK. PERSEDIAAN" )
                ->setCellValue('G12',"NAMA BARANG" )
                ->setCellValue('H12',"JUMLAH" )
                ->setCellValue('I12',"HARGA SATUAN" )
                ->setCellValue('J12',"TOTAL HARGA" )
                ->setCellValue('K12',"NON PERSEDIAAN" )
                ->setCellValue('L12',"KETERANGAN" )
                ;
        $rows = 13;
        $nomor=1;
        $sheet->getStyle('I:K')->getNumberFormat()->setFormatCode('#,##0.00');
        foreach ($dataPerSKPD as $key => $value) {
            foreach ($value['rek_belanja'] as $key2 => $value2) {
                foreach ($value2['rek_persediaan'] as $key3 => $value3) {
                    foreach ($value3['barang'] as $key4 => $value4) {
                    $objPHPExcel->setActiveSheetIndex(0)              
                        ->setCellValue("A$rows",$nomor)
                        ->setCellValue("B$rows",$key)
                        ->setCellValue("C$rows",$key2)
                        ->setCellValue("D$rows",$value2['nama_rekening'])
                        ->setCellValue("E$rows",$key3)
                        ->setCellValue("F$rows",$value3['nm_perk'])
                        ->setCellValue("G$rows",$value4['nm_brg'])
                        ->setCellValue("H$rows","$value4[qty] $value4[satuan]")
                        ->setCellValue("I$rows",$value4['harga_sat'])
                        ->setCellValue("J$rows",$value4['total_harga'])
                        ->setCellValue("K$rows",$value2['nilai_kontrak'])
                        ->setCellValue("L$rows",$value4['keterangan'])
                        ;   
                        
                        $objPHPExcel->getActiveSheet()->getStyle("B$rows")->getAlignment()->setWrapText(true); 
                        $sheet->getStyle("A$rows:L$rows")->applyFromArray($border);
                        $sheet->getStyle("B$rows")->applyFromArray($left);
                        $sheet->getStyle("D$rows")->applyFromArray($left);
                        $sheet->getStyle("F$rows:G$rows")->applyFromArray($left);
                        $sheet->getStyle("B$rows:C$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("A$rows:L$rows")->applyFromArray($vertical);
                        $sheet->getStyle("E$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("A$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("I$rows:K$rows")->applyFromArray($right);
                        $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(40);

                        $objPHPExcel->getActiveSheet()->getStyle("D$rows:H$rows")->getAlignment()->setWrapText(true);     
                    $nomor++;
                    $rows++; 
                    } 
                    $sheet->mergeCells("A$rows:I$rows");
                    $objPHPExcel->setActiveSheetIndex(0)              
                        ->setCellValue("A$rows","SUBTOTAL")
                        ->setCellValue("J$rows",$value3['total_harga'])
                        ;

                        $sheet->getStyle("A$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("A$rows")->applyFromArray($vertical);
                        $sheet->getStyle("A$rows:L$rows")->applyFromArray($border);

                    $rows++; 
                } 
            }
        }

        $total_rek = $apbd+$bos+$blud+$bpp+$lainnya;
        $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows","GRAND TOTAL")
                    ->setCellValue("J$rows",$nilai_rek_persediaan)
                    ->setCellValue("K$rows",$nilai_non_persediaan)
                    ;     
                $sheet->getStyle("A$rows:K$rows")->applyFromArray($border);
                $sheet->getStyle("C$rows")->applyFromArray($left);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($horizontal);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($vertical);
                $sheet->getStyle("I$rows:K$rows")->applyFromArray($right);

                $sheet->mergeCells("A$rows:I$rows");
        // echo "ini excel";
        Header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LAPORAN REKENING BELANJA PERSEDIAAN.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');


        exit;
    }



}

public function laporan_belanja_persediaan($data){ 
    $kd_ruang           = trim($data['kd_ruang']);
    $kd_lokasi          = $data['kd_lokasi'].$kd_ruang;
    $satker_asal        = $data['satker_asal'];
    $thn_ang            = $data['thn_ang'];
    $lingkup            = $data['lingkup'];
    $tgl_awal           = $data['tgl_awal'];
    $tgl_akhir          = $data['tgl_akhir'];
    $tgl_cetak          = $data['tgl_cetak'];
    $jenis              = $data['format'];
    $rinci_per_dok      = $data['rinci_per_dok'];
    $date               = $this->cek_periode($data);

    // $sql        = "SELECT kd_lokasi,nm_satker,no_dok, kd_perk, sum(nilai_kontrak) as nilai_kontrak, nm_perk, kode_rekening, nama_rekening, jns_trans, sum(total_harga) as total_harga, sum(nilai_kontrak)+sum(total_harga) as grand_total from transaksi_masuk   where concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' and jns_trans='M07' and IFNULL(kd_ruang,'')='$kd_ruang' and thn_ang='$thn_ang' and tgl_dok<='$tgl_akhir' and kd_perk IS NOT NULL  group by kd_lokasi,kd_perk,kode_rekening   order by kd_lokasi, kode_rekening,kd_perk asc";

    $sql    = "SELECT kd_lokasi, nm_satker, kd_perk,nm_perk, total_harga,kode_rekening,nama_rekening, nilai_kontrak, jns_trans 
        FROM transaksi_masuk   
        WHERE concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' 
        AND thn_ang='$thn_ang' 
        AND tgl_dok>'$tgl_dok' 
        AND jns_trans!='M01'
        AND total_harga+nilai_kontrak > 0
        order by kd_lokasi asc, kode_rekening asc, kd_perk asc, jns_trans asc ";

        // exit;
    $result                 = $this->query($sql);
    $no                     =1;
    $rek_persediaan         ="";
    $rek_keuangan           ="";
    $nilai_rek_persediaan   =0;
    $nilai_non_persediaan   =0;
    $total                  =0;
    $apbd  = 0;
    $bpusat = 0;
    $bprov = 0;
    $bos = 0;
    $blud = 0;
    $lainnya = 0;
    $dataPerSKPD = array();
    echo "<pre>";
    foreach ($result as $key => $value) {
        // print_r($value);
            // $dataPerSKPD[$value['kd_lokasi']]['nm_satker'] = $value['nm_satker'];
        $dataPerSKPD["$value[kd_lokasi]"]['nm_satker'] = $value['nm_satker'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['nama_rekening'] = $value['nama_rekening'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['nilai_kontrak'] += $value['nilai_kontrak'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['total_harga'] += $value['total_harga'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['grand_total'] += ($value['total_harga']+$value['nilai_kontrak']);


      $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['total_harga'] += $value['total_harga'];
      $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['nm_perk'] = $value['nm_perk'];
      if($value['jns_trans']=="M07"){
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['apbd'] += $value['total_harga'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bos'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['blud'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bpusat'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bprov'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['sumber_dana'] = "APBD";
        $apbd    += $val['total_harga'];

    }
    elseif($value['jns_trans']=="M08"){
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['apbd'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bos'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['blud'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bpusat'] += $value['total_harga'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bprov'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['sumber_dana'] = "Bantuan Pemerintah Pusat";

        $bpusat     += $val['total_harga'];
    }
    elseif($value['jns_trans']=="M09"){
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['apbd'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bos'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['blud'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bprov'] += $value['total_harga'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bpusat'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['sumber_dana'] = "Bantuan Pemerintah Provinsi";

        $bprov      += $val['total_harga'];
    }
    elseif($value['jns_trans']=="M10"){
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['apbd'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bos'] += $value['total_harga'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['blud'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bprov'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bpusat'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['sumber_dana'] = "BOS";
        $bos     += $val['total_harga'];
    }

    elseif($value['jns_trans']=="M11"){
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['apbd'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bos'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['blud'] += $value['total_harga'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bprov'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bpusat'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['sumber_dana'] = "BLUD";
        $blud    += $val['total_harga'];
    }

    elseif($value['jns_trans']=="M12"){
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['apbd'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bos'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['blud'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bprov'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['bpusat'] += 0;
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['data'][$value['kd_perk']]['lainnya'] += $val['total_harga'];
        $dataPerSKPD["$value[kd_lokasi]"]['data'][$value['jns_trans']]['kode_rekening'][$value['kode_rekening']]['sumber_dana'] = "Lainnya";
         $lainnya += $val['total_harga'];
    }
    else{

    }

        $nilai_rek_persediaan   +=$value['total_harga'];
        $nilai_non_persediaan   +=$value['nilai_kontrak'];
        $total                  += ($value['nilai_kontrak']+$value['total_harga']);
    }

    // echo "<pre>";
    //     print_r($dataPerSKPD);
    //     exit;
    if($jenis=="excel"){

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator($_SESSION['nm_satker'])
                  ->setLastModifiedBy("")
                  ->setTitle("LAPORAN SALDO REKENING PERSEDIAAN");
        $border = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $default_border = array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          );

              $horizontal = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  )
              );
              $vertical = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  )
              );
              $left = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  )
              );
              $right = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                  )
              );
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);


        $objPHPExcel->getActiveSheet()->getStyle('A12:H12')->getAlignment()->setWrapText(true); 



        $sheet = $objPHPExcel->getActiveSheet()->setTitle("Lap. Saldo Persediaan");
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A5:B5');
        $sheet->mergeCells('A6:B6');
        $sheet->mergeCells('A7:B7');
        $sheet->mergeCells('A8:B8');
        $sheet->mergeCells('A9:B9');
        $sheet->mergeCells('A10:B10');

        $sheet->getStyle("A12:H12")->applyFromArray($border);
        $objPHPExcel->getActiveSheet()->getRowDimension("12")->setRowHeight(30);

        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->applyFromArray($horizontal);    
        $sheet->getStyle('A1:A3')->applyFromArray($vertical);
        $sheet->getStyle('A12:H12')->applyFromArray($horizontal);    
        $sheet->getStyle('A12:H12')->applyFromArray($vertical);
        $skpd = $this->getsatker($kd_lokasi);
        $sheet->getStyle('G:H')->getNumberFormat()->setFormatCode('#,##0.00');
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',"LAPORAN REKENING BELANJA PERSEDIAAN" )
                ->setCellValue('A2',"PERIODE ".$date)
                ->setCellValue('A3',"TAHUN ANGGARAN ".$thn_ang )
                ->setCellValue('A5',"Provinsi" )
                ->setCellValue('A6',"Kabupaten / Kota" )
                ->setCellValue('A7',"Bidang" )
                ->setCellValue('A8',"Unit Organisasi" )
                ->setCellValue('A9',"Sub Unit Organisasi" )
                ->setCellValue('A10',"UPB" )                
                ->setCellValue('C5',": Jawa Tengah" )
                ->setCellValue('C6',": Kota Pekalongan" )
                ->setCellValue('C7',": ".$skpd['nama_sektor'] )
                ->setCellValue('C8',": ".$skpd['nama_satker'] )
                ->setCellValue('C9',": ".$skpd['nama_unit'] )
                ->setCellValue('C10',": ".$skpd['nama_gudang'] )                
                ->setCellValue('A12',"NO" )
                ->setCellValue('B12',"SUMBER DANA" )
                ->setCellValue('C12',"REKENING BELANJA" )
                ->setCellValue('D12',"URAIAN REK. BELANJA" )
                ->setCellValue('E12',"REKENING PERSEDIAAN" )
                ->setCellValue('F12',"URAIAN REK. PERSEDIAAN" )
                ->setCellValue('G12',"NILAI PERSEDIAAN" )
                ->setCellValue('H12',"NILAI NON PERSEDIAAN" )
                ;
        $rows = 13;
        $nomor=1;
        foreach ($dataPerSKPD as $key => $value) {
            $detilSatker = explode("-", $key);
            $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows",$value['nm_satker']);
            $sheet->mergeCells("A$rows:H$rows");
            $sheet->getStyle("A$rows:H$rows")->applyFromArray($border);
            $sheet->getStyle("A$rows:H$rows")->applyFromArray($left);
            $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(20);


            $rows++;
            foreach ($value['data'] as $key2 => $value2) {
                foreach ($value2['kode_rekening'] as $key4 => $value4) {
                    foreach ($value4['data'] as $key3 => $value3) {
                      $total_rek = $value3['apbd']+$value3['bos']+$value3['blud']+$value3['bpusat']+$value3['bprov']+$value3['lainnya'];
                      $objPHPExcel->setActiveSheetIndex(0)              
                        ->setCellValue("A$rows",$nomor)
                        ->setCellValue("B$rows",$value4['sumber_dana'])
                        ->setCellValue("C$rows",$key4)
                        ->setCellValue("D$rows",$value4['nama_rekening'])
                        ->setCellValue("E$rows",$key3)
                        ->setCellValue("F$rows",$value3['nm_perk'])
                        ->setCellValue("G$rows",$value3['total_harga'])
                        ->setCellValue("H$rows",$value2['nilai_kontrak'])
                        ;   
                        $sheet->getStyle("A$rows:H$rows")->applyFromArray($border);
                        $sheet->getStyle("D$rows")->applyFromArray($left);
                        $sheet->getStyle("F$rows")->applyFromArray($left);
                        $sheet->getStyle("B$rows:C$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("A$rows:H$rows")->applyFromArray($vertical);
                        $sheet->getStyle("E$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("A$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("G$rows:H$rows")->applyFromArray($right);
                        $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(40);

                        $objPHPExcel->getActiveSheet()->getStyle("D$rows:H$rows")->getAlignment()->setWrapText(true); 


                      $nomor++;
                      $rows++;
                    }

                    $sheet->mergeCells("A$rows:F$rows"); 
                    $objPHPExcel->setActiveSheetIndex(0)             
                        ->setCellValue("A$rows","SUBTOTAL")
                        ->setCellValue("G$rows",$value4['total_harga'])
                        ->setCellValue("H$rows",$value4['nilai_kontrak'])
                        ;   
                        $sheet->getStyle("A$rows:H$rows")->applyFromArray($border);
                        $sheet->getStyle("D$rows")->applyFromArray($left);
                        $sheet->getStyle("F$rows")->applyFromArray($left);
                        $sheet->getStyle("B$rows:C$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("A$rows:H$rows")->applyFromArray($vertical);
                        $sheet->getStyle("E$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("A$rows")->applyFromArray($horizontal);
                        $sheet->getStyle("G$rows:H$rows")->applyFromArray($right);
                        $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(30);
                        $sheet->getStyle("A$rows:H$rows")->getFont()->setBold(true);
                        $objPHPExcel->getActiveSheet()->getStyle("D$rows:H$rows")->getAlignment()->setWrapText(true); 

                    $rows++;
            }
         }
        }
        $total_rek = $apbd+$bos+$blud+$bpusat+$bprov+$lainnya;
        $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows","GRAND TOTAL")
                    ->setCellValue("G$rows",number_format($nilai_rek_persediaan,2,",","."))
                    ->setCellValue("H$rows",number_format($nilai_non_persediaan,2,",","."))
                    ;     
                $sheet->getStyle("A$rows:H$rows")->applyFromArray($border);
                $sheet->getStyle("C$rows")->applyFromArray($left);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($horizontal);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($vertical);
                $sheet->getStyle("G$rows:H$rows")->applyFromArray($right);
                $sheet->getStyle("A$rows:H$rows")->getFont()->setBold(true);
                $sheet->mergeCells("A$rows:F$rows");
        // echo "ini excel";
        Header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LAPORAN REKENING BELANJA PERSEDIAAN.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
    }
    else{
        ob_start();
        $this->getsatker($kd_lokasi);
        echo'<p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN POSISI PERSEDIAAN DI NERACA PER REKENING</p>
            <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
            <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p><br></br>';
        echo '<table style="border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1>
                <thead style="display: table-header-group;">
                    <tr>
                        <th width="3%"><b>NO</b></th>
                        <th width="5%"><b>REK. BELANJA</b></th>
                        <th ><b>URAIAN REK. BELANJA</b></th>
                        <th width="7%"><b>REK. PERSEDIAAN</b></th>
                        <th ><b>URAIAN REK. PERSEDIAAN</b></th>
                        <th><b>NILAI PERSEDIAAN</b></th>
                        <th><b>NILAI NON PERSEDIAAN</b></th>
                        <th><b>TOTAL</b></td>
                    </tr>
                </thead>';
        $no=1;
    // print_r($dataPerSKPD);
    // exit;
        foreach ($dataPerSKPD as $kode => $satker) {
            $skpd = explode("-",$kode);
            echo ' <tr style="background-color:#EFEFEF;">
            <td style="text-align:left; font-weight:bold" colspan="8">'.$skpd[1].'</td>
            </tr>';
            foreach ($satker as $kode => $rek) {
                echo '<tr>
                <td style="text-align:center">'.$no.'</td>
                <td style="text-align:center;">'.$kode.'</td>
                <td style="text-align:left;">'.$rek['nama_rekening'].'</td>
                <td style="text-align:right"></td>    
                <td style="text-align:right"></td>    
                <td style="text-align:right"></td>    
                <td style="text-align:right">'.number_format($rek['nilai_kontrak'],2,",",".").'</td>
                <td style="text-align:right">'.number_format($rek['nilai_kontrak'],2,",",".").'</td>
                </tr>';
                $no++;
                foreach ($rek['data'] as $key => $val) {
                    echo '<tr>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center;">'.$val['kd_perk'].'</td>
                    <td style="text-align:left;"  >'.$val['nm_perk'].'</td>
                    <td style="text-align:right">'.number_format($val['total_harga'],2,",",".").'</td>
                    <td style="text-align:right">0</td>    
                    <td style="text-align:right">'.number_format($val['total_harga'],2,",",".").'</td>
                    </tr>';
                }
                echo '<tr>
                <td style="text-align:center; font-weight:bold" colspan="5">'."SUBTOTAL".'</td>
                <td style="text-align:right; font-weight:bold">'.number_format($rek['total_harga'],2,",",".").'</td>    
                <td style="text-align:right; font-weight:bold">'.number_format($rek['nilai_kontrak'],2,",",".").'</td>
                <td style="text-align:right; font-weight:bold">'.number_format($rek['grand_total'],2,",",".").'</td>
                </tr>';
            }
        }
            echo "</table>";
            $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
            $html = ob_get_contents(); 
            ob_end_clean();
            $mpdf=new mPDF('utf-8', 'A4-L');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("rekap_per_rekening2.pdf" ,'I');
            exit;
    }


}

public function rekap_opname_mutasi($data)
{
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $satker_asal = $data['satker_asal'];
    $tgl_cetak = $data['tgl_cetak'];
    $thn_ang = $data['thn_ang'];
    $lingkup = $data['lingkup'];
    $tgl_dok = $data['tgl_rekap'];
    $date = $this->cek_periode($data);
    $skpd_criteria = $this->filter_query($kd_lokasi);

    $sql    = "SELECT kd_lokasi, nm_satker,kd_brg, kd_perk,nm_perk, jns_trans, qty, qty_akhir, harga_sat 
                FROM transaksi_masuk   
                WHERE $skpd_criteria
                    thn_ang='$thn_ang' 
                AND tgl_dok<='$tgl_dok' 
                AND total_harga>0 
                ORDER BY kd_lokasi ASC, kd_perk ASC, kd_brg ASC";
    $query_brg = "SELECT * FROM persediaan WHERE e is NULL and d is NOT NULL";
    $res_query_brg = $this->query($query_brg);
    $data_kel=array();
    foreach ($res_query_brg as $key => $value) {
        $data_kel[$value['id']]['nm_perk'] = $value['nm_perk'];
    }

    $no      =1;
    $saldo_awal    =0;
    $penerimaan      =0;
    $pengeluaran    =0;
    $saldo_akhir     =0;
    $lainnya =0;
    $result  = $this->query($sql);
    $dataPerSKPD  = array();
    $dataFinal= array();

    $count = 0;


    foreach ($result as $val) {
        $jumlah_masuk = $val['qty']*$val['harga_sat'];
        $jumlah_keluar = ($val['qty']-$val['qty_akhir'])*$val['harga_sat'];
        $kode = explode(".", $val['kd_brg']);
        $skel = "$kode[0].$kode[1].$kode[2].$kode[3]";
        $sskel = "$kode[0].$kode[1].$kode[2].$kode[3].$kode[4]";
        $dataFinal["$val[kd_lokasi]"]['nm_satker'] = $val['nm_satker'];
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['nm_perk'] = $data_kel[$skel]['nm_perk'];
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['data']["$val[kd_perk]"]['nm_perk'] = $val['nm_perk'];
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['data']["$val[kd_perk]"]['kd_perk'] = $val['kd_perk'];
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['data']["$val[kd_perk]"]['kd_sskel'] = $sskel;

        if($val['jns_trans']=="M01"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["saldo_awal"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['data']["$val[kd_perk]"]["saldo_awal"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["saldo_awal"] += $jumlah_masuk;
            $saldo_awal +=$jumlah_masuk;
        }
        else{
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["penerimaan"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['data']["$val[kd_perk]"]["penerimaan"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["penerimaan"] += $jumlah_masuk;
            $penerimaan +=$jumlah_masuk;

        }
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]["pengeluaran"] += $jumlah_keluar;
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['data']["$val[kd_perk]"]["pengeluaran"] += $jumlah_keluar;
        $saldo_akhir = $saldo_awal+$jumlah_masuk-$jumlah_keluar;
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['data']["$val[kd_perk]"]["saldo_akhir"] += $saldo_akhir;
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]["saldo_akhir"] += ($val['qty']*$val['harga_sat']) -($val['qty']-$val['qty_akhir'])*$val['harga_sat'];
        
        
        $dataFinal["$val[kd_lokasi]"]["pengeluaran"] += $jumlah_keluar;
        $dataFinal["$val[kd_lokasi]"]["saldo_akhir"] = $dataFinal["$val[kd_lokasi]"]["saldo_awal"]+$dataFinal["$val[kd_lokasi]"]["penerimaan"]-$dataFinal["$val[kd_lokasi]"]["pengeluaran"];
        $pengeluaran +=$jumlah_keluar;
        


       }
        
        $saldo_akhir = $saldo_awal+$penerimaan-$pengeluaran;
       //  echo "<pre>";
       // print_r($dataFinal);
       // exit;
    $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator($_SESSION['nm_satker'])
                  ->setLastModifiedBy("")
                  ->setTitle("LAPORAN SALDO REKENING PERSEDIAAN");
        $border = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $default_border = array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          );

              $horizontal = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  )
              );
              $vertical = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  )
              );
              $left = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  )
              );
              $right = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                  )
              );
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);


        $objPHPExcel->getActiveSheet()->getStyle('A:L')->getAlignment()->setWrapText(true); 



        $sheet = $objPHPExcel->getActiveSheet()->setTitle("Lap. Saldo Persediaan");
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A5:B5');
        $sheet->mergeCells('A6:B6');
        $sheet->mergeCells('A7:B7');
        $sheet->mergeCells('A8:B8');
        $sheet->mergeCells('A9:B9');
        $sheet->mergeCells('A10:B10');

        $sheet->getStyle("A12:G12")->applyFromArray($border);
        $objPHPExcel->getActiveSheet()->getRowDimension("12")->setRowHeight(40);

        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->applyFromArray($horizontal);    
        $sheet->getStyle('A1:A3')->applyFromArray($vertical);
        $sheet->getStyle('A12:I12')->applyFromArray($horizontal);    
        $sheet->getStyle('A12:I12')->applyFromArray($vertical);
        $skpd = $this->getsatker($kd_lokasi);
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',"REKAPITULASI STOK OPNAME" )
                ->setCellValue('A2',"PERIODE ".$date)
                ->setCellValue('A3',"TAHUN ANGGARAN ".$thn_ang )
                ->setCellValue('A5',"Provinsi" )
                ->setCellValue('A6',"Kabupaten / Kota" )
                ->setCellValue('A7',"Bidang" )
                ->setCellValue('A8',"Unit Organisasi" )
                ->setCellValue('A9',"Sub Unit Organisasi" )
                ->setCellValue('A10',"UPB" )                
                ->setCellValue('C5',": Jawa Tengah" )
                ->setCellValue('C6',": Kota Pekalongan" )
                ->setCellValue('C7',": ".$skpd['nama_sektor'] )
                ->setCellValue('C8',": ".$skpd['nama_satker'] )
                ->setCellValue('C9',": ".$skpd['nama_unit'] )
                ->setCellValue('C10',": ".$skpd['nama_gudang'] )                
                ->setCellValue('A12',"NO" )
                ->setCellValue('B12',"REKENING" )
                ->setCellValue('C12',"URAIAN" )
                ->setCellValue('D12',"SALDO AWAL" )
                ->setCellValue('E12',"PENERIMAAN" )
                ->setCellValue('F12',"PENGELUARAN" )
                ->setCellValue('G12',"SALDO AKHIR" )
                ;
                $sheet->getStyle('D:G')->getNumberFormat()->setFormatCode('#,##0.00');

        $rows = 13;
        $nomor=1;
        foreach ($dataFinal as $key => $value) {
            $detilSatker = explode("-", $key);
            $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows",$value['nm_satker']);
            $sheet->mergeCells("A$rows:F$rows");
            $sheet->getStyle("A$rows:G$rows")->applyFromArray($border);
            $sheet->getStyle("A$rows:G$rows")->applyFromArray($left);
            $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(20);


            $rows++;
            foreach ($value['data'] as $key2 => $value2) {
              $total_rek = $value2['apbd']+$value2['bos']+$value2['blud']+$value2['bpp']+$value2['lainnya'];
              $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows",$nomor)
                ->setCellValue("B$rows",$key2)
                ->setCellValue("C$rows",$value2['nm_perk'])
                ->setCellValue("D$rows",$value2['saldo_awal'])
                ->setCellValue("E$rows",$value2['penerimaan'])
                ->setCellValue("F$rows",$value2['pengeluaran'])
                ->setCellValue("G$rows",$value2['saldo_akhir'])
                ;   
                $sheet->getStyle("A$rows:G$rows")->applyFromArray($border);
                $sheet->getStyle("B$rows")->applyFromArray($left);
                $sheet->getStyle("A$rows")->applyFromArray($horizontal);
                $sheet->getStyle("A$rows:G$rows")->applyFromArray($vertical);
                $sheet->getStyle("D$rows:G$rows")->applyFromArray($right);
                $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(40);

                $objPHPExcel->getActiveSheet()->getStyle("B$rows")->getAlignment()->setWrapText(true); 
                $sheet->getStyle("A$rows:G$rows")->getFont()->setBold(true);

              // $nomor++;
              $rows++;
              foreach ($value2['data'] as $key3 => $value3) {
                $objPHPExcel->setActiveSheetIndex(0)              
                    ->setCellValue("A$rows",$nomor)
                    ->setCellValue("B$rows",$value3['kd_sskel'])
                    ->setCellValue("C$rows",$value3['nm_perk'])
                    ->setCellValue("D$rows",$value3['saldo_awal'])
                    ->setCellValue("E$rows",$value3['penerimaan'])
                    ->setCellValue("F$rows",$value3['pengeluaran'])
                    ->setCellValue("G$rows",$value3['saldo_akhir'])
                    ;   
                    $sheet->getStyle("A$rows:G$rows")->applyFromArray($border);
                    $sheet->getStyle("B$rows")->applyFromArray($left);
                    $sheet->getStyle("A$rows")->applyFromArray($horizontal);
                    $sheet->getStyle("A$rows:G$rows")->applyFromArray($vertical);
                    $sheet->getStyle("D$rows:G$rows")->applyFromArray($right);
                    $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(40);

                $objPHPExcel->getActiveSheet()->getStyle("B$rows")->getAlignment()->setWrapText(true); 
              $nomor++;
              $rows++;
              }

          }
            $sheet->mergeCells("A$rows:C$rows");
            if(count($dataFinal)>1){
                $objPHPExcel->setActiveSheetIndex(0)              
                    ->setCellValue("A$rows","SUBTOTAL")
                    ->setCellValue("D$rows",$value['saldo_awal'])
                    ->setCellValue("E$rows",$value['penerimaan'])
                    ->setCellValue("F$rows",$value['pengeluaran'])
                    ->setCellValue("G$rows",$value['saldo_akhir'])
                    ;   

                    $sheet->getStyle("A$rows:G$rows")->applyFromArray($border);
                    $sheet->getStyle("B$rows")->applyFromArray($left);
                    $sheet->getStyle("A$rows:B$rows")->applyFromArray($horizontal);
                    $sheet->getStyle("A$rows:G$rows")->applyFromArray($vertical);
                    $sheet->getStyle("D$rows:G$rows")->applyFromArray($right);
                    $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(40);

                    $objPHPExcel->getActiveSheet()->getStyle("B$rows")->getAlignment()->setWrapText(true); 
                  $rows++;
            }
                  
        }
        $total_rek = $apbd+$bos+$blud+$bpp+$lainnya;
        $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows","GRAND TOTAL")
                ->setCellValue("D$rows",$saldo_awal)
                ->setCellValue("E$rows",$penerimaan)
                ->setCellValue("F$rows",$pengeluaran)
                ->setCellValue("G$rows",$saldo_akhir)
                ;   

                $sheet->getStyle("A$rows:G$rows")->applyFromArray($border);
                $sheet->getStyle("B$rows")->applyFromArray($left);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($horizontal);
                $sheet->getStyle("A$rows:G$rows")->applyFromArray($vertical);
                $sheet->getStyle("D$rows:G$rows")->applyFromArray($right);
                $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(40);

                $sheet->getStyle("A$rows:G$rows")->getFont()->setBold(true);

                $sheet->mergeCells("A$rows:C$rows");

        Header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LAPORAN POSISI PERSEDIAAN PER REKENING.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
}
public function rekap_opname_sumber($data)
{
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $satker_asal = $data['satker_asal'];
    $tgl_cetak = $data['tgl_cetak'];
    $thn_ang = $data['thn_ang'];
    $lingkup = $data['lingkup'];
    $tgl_dok = $data['tgl_rekap'];
    $date = $this->cek_periode($data);
    
    $query_brg = "SELECT * FROM persediaan WHERE e is NULL and d is NOT NULL";
    $res_query_brg = $this->query($query_brg);
    $data_kel=array();
    foreach ($res_query_brg as $key => $value) {
        $data_kel[$value['id']]['nm_perk'] = $value['nm_perk'];
    }
    $skpd_criteria = $this->filter_query($kd_lokasi);
    $sql    = "SELECT kd_lokasi, nm_satker, kd_perk,nm_perk, jns_trans,kd_brg, qty, qty_akhir, harga_sat 
                FROM transaksi_masuk   
                WHERE $skpd_criteria
                 thn_ang='$thn_ang' 
                AND tgl_dok<='$tgl_dok' 
                AND total_harga>0 
                ORDER BY kd_lokasi ASC, kd_perk ASC, kd_brg ASC";
                // echo $sql;
    $no      =1;
    $saldo_awal=$apbd=$bpusat=$bprov=$bos=$blud=$lainnya=$pengeluaran=$saldo_akhir=
    $transfer =0;
    $result  = $this->query($sql);
    $dataPerSKPD  = array();
    $dataFinal= array();

    $count = 0;
    // echo "<pre>";

    foreach ($result as $val) {
        $kode = explode(".", $val['kd_brg']);

        $skel = "$kode[0].$kode[1].$kode[2].$kode[3]";
        $sskel = "$kode[0].$kode[1].$kode[2].$kode[3].$kode[4]";
        $jumlah_masuk = $val['qty']*$val['harga_sat'];
        $jumlah_keluar = ($val['qty']-$val['qty_akhir'])*$val['harga_sat'];

        $dataFinal["$val[kd_lokasi]"]['nm_satker'] = $val['nm_satker'];
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['nm_perk'] = $data_kel[$skel]['nm_perk'];
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["nm_perk"] = $val['nm_perk'];
        // $dataFinal["$val[kd_lokasi]"]['data'][$skel]['nm_perk'] = $val['nm_perk'];

        if($val['jns_trans']=="M01"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["saldo_awal"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["saldo_awal"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["saldo_awal"] += $jumlah_masuk;
            $saldo_awal +=$jumlah_masuk;
        }
        elseif($val['jns_trans']=="M07"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["apbd"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["apbd"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["apbd"] += $jumlah_masuk;
            $apbd +=$jumlah_masuk;
        }
        elseif($val['jns_trans']=="M08"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["bpusat"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["bpusat"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["bpusat"] += $jumlah_masuk;
            $bpusat +=$jumlah_masuk;
        }
        elseif($val['jns_trans']=="M09"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["bprov"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["bprov"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["bprov"] += $jumlah_masuk;
            $bprov +=$jumlah_masuk;
        }
        elseif($val['jns_trans']=="M10"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["bos"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["bos"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["bos"] += $jumlah_masuk;
            $bos +=$jumlah_masuk;
        }
        elseif($val['jns_trans']=="M11"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["blud"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["blud"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["blud"] += $jumlah_masuk;
            $blud +=$jumlah_masuk;
        }
        elseif($val['jns_trans']=="M12"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["lainnya"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["lainnya"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["lainnya"] += $jumlah_masuk;
            $lainnya +=$jumlah_masuk;
        }
        elseif($val['jns_trans']=="M06"){
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["transfer"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["transfer"] += $jumlah_masuk;
            $dataFinal["$val[kd_lokasi]"]["transfer"] += $jumlah_masuk;
            $transfer +=$jumlah_masuk;
        }
        else{
           

        }
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]["pengeluaran"] += $jumlah_keluar;
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["pengeluaran"] += $jumlah_keluar;
        $saldo_akhir = $saldo_awal+$apbd+$blud+$bos+$bprov+$bpusat-$jumlah_keluar;
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]["saldo_akhir"] = 
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["saldo_awal"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["apbd"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["bpusat"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["bprov"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["bos"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["blud"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["transfer"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["lainnya"]-
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]["pengeluaran"];
        ;
        $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["saldo_akhir"] = 
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["saldo_awal"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["apbd"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["bpusat"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["bprov"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["bos"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["blud"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["transfer"]+
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["lainnya"]-
            $dataFinal["$val[kd_lokasi]"]['data'][$skel]['sskel'][$sskel]["pengeluaran"];
        ;
        
        
        $dataFinal["$val[kd_lokasi]"]["pengeluaran"] += $jumlah_keluar;
        $dataFinal["$val[kd_lokasi]"]["saldo_akhir"] = 
            $dataFinal["$val[kd_lokasi]"]["saldo_awal"]+
            $dataFinal["$val[kd_lokasi]"]["apbd"]+
            $dataFinal["$val[kd_lokasi]"]["bpusat"]+
            $dataFinal["$val[kd_lokasi]"]["bprov"]+
            $dataFinal["$val[kd_lokasi]"]["bos"]+
            $dataFinal["$val[kd_lokasi]"]["blud"]+
            $dataFinal["$val[kd_lokasi]"]["transfer"]+
            $dataFinal["$val[kd_lokasi]"]["lainnya"]-
            $dataFinal["$val[kd_lokasi]"]["pengeluaran"];
        
        $pengeluaran+=$jumlah_keluar;

       }
       // echo "<pre>"
       //         print_r($dataFinal);
       //  exit;
        $saldo_akhir = $saldo_awal+$penerimaan-$pengeluaran;
       
    $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator($_SESSION['nm_satker'])
                  ->setLastModifiedBy("")
                  ->setTitle("LAPORAN SALDO REKENING PERSEDIAAN");
        $border = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $default_border = array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          );

              $horizontal = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  )
              );
              $vertical = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  )
              );
              $left = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  )
              );
              $right = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                  )
              );
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(18);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(18);


        $objPHPExcel->getActiveSheet()->getStyle('A:M')->getAlignment()->setWrapText(true); 



        $sheet = $objPHPExcel->getActiveSheet()->setTitle("Rekap Persediaan");
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A5:B5');
        $sheet->mergeCells('A6:B6');
        $sheet->mergeCells('A7:B7');
        $sheet->mergeCells('A8:B8');
        $sheet->mergeCells('A9:B9');
        $sheet->mergeCells('A10:B10');

        $sheet->getStyle("A12:M12")->applyFromArray($border);
        $objPHPExcel->getActiveSheet()->getRowDimension("12")->setRowHeight(30);

        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->applyFromArray($horizontal);    
        $sheet->getStyle('A1:A3')->applyFromArray($vertical);
        $sheet->getStyle('A12:M12')->applyFromArray($horizontal);    
        $sheet->getStyle('A12:M12')->applyFromArray($vertical);
        $skpd = $this->getsatker($kd_lokasi);
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',"REKAPITULASI STOK OPNAME" )
                ->setCellValue('A2',"PERIODE ".$date)
                ->setCellValue('A3',"TAHUN ANGGARAN ".$thn_ang )
                ->setCellValue('A5',"Provinsi" )
                ->setCellValue('A6',"Kabupaten / Kota" )
                ->setCellValue('A7',"Bidang" )
                ->setCellValue('A8',"Unit Organisasi" )
                ->setCellValue('A9',"Sub Unit Organisasi" )
                ->setCellValue('A10',"UPB" )                
                ->setCellValue('C5',": Jawa Tengah" )
                ->setCellValue('C6',": Kota Pekalongan" )
                ->setCellValue('C7',": ".$skpd['nama_sektor'] )
                ->setCellValue('C8',": ".$skpd['nama_satker'] )
                ->setCellValue('C9',": ".$skpd['nama_unit'] )
                ->setCellValue('C10',": ".$skpd['nama_gudang'] )                
                ->setCellValue('A12',"NO" )
                ->setCellValue('B12',"REKENING" )
                ->setCellValue('C12',"URAIAN" )
                ->setCellValue('D12',"SALDO AWAL" )
                ->setCellValue('E12',"PENERIMAAN APBD")
                ->setCellValue('F12',"BOS")
                ->setCellValue('G12',"PENERIMAAN BLUD")
                ->setCellValue('H12',"PENERIMAAN PROV")
                ->setCellValue('I12',"PENERIMAAN PUSAT")
                ->setCellValue('J12',"PENERIMAAN TRANSFER")
                ->setCellValue('K12',"LAINNYA")
                ->setCellValue('L12',"PENGELUARAN")
                ->setCellValue('M12',"SALDO AKHIR" )
                ;
                $sheet->getStyle('D:M')->getNumberFormat()->setFormatCode('#,##0.00');

        $rows = 13;
        $nomor=1;
        foreach ($dataFinal as $key => $value) {
            $detilSatker = explode("-", $key);
            $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows",$value['nm_satker']);
            $sheet->mergeCells("A$rows:L$rows");
            $sheet->getStyle("A$rows:M$rows")->applyFromArray($border);
            $sheet->getStyle("A$rows:M$rows")->applyFromArray($left);
            $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(20);


            $rows++;
            foreach ($value['data'] as $key2 => $value2) {
              $total_rek = $value2['apbd']+$value2['bos']+$value2['blud']+$value2['bpp']+$value2['lainnya'];
              $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("B$rows",$key2)
                ->setCellValue("C$rows",$value2['nm_perk'])
                ->setCellValue("D$rows",$value2['saldo_awal'])
                ->setCellValue("E$rows",$value2['apbd'])
                ->setCellValue("F$rows",$value2['bos'])
                ->setCellValue("G$rows",$value2['blud'])
                ->setCellValue("H$rows",$value2['bprov'])
                ->setCellValue("I$rows",$value2['bpusat'])
                ->setCellValue("J$rows",$value2['transfer'])
                ->setCellValue("K$rows",$value2['lainnya'])
                ->setCellValue("L$rows",$value2['pengeluaran'])
                ->setCellValue("M$rows",$value2['saldo_akhir'])
                ;   
                $sheet->getStyle("A$rows:M$rows")->applyFromArray($border);
                $sheet->getStyle("C$rows")->applyFromArray($left);
                $sheet->getStyle("A$rows")->applyFromArray($horizontal);
                $sheet->getStyle("A$rows:M$rows")->applyFromArray($vertical);
                $sheet->getStyle("D$rows:M$rows")->applyFromArray($right);
                $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(30);

                $objPHPExcel->getActiveSheet()->getStyle("B$rows")->getAlignment()->setWrapText(true); 
                $objPHPExcel->getActiveSheet()->getStyle("A$rows:M$rows")->getFont()->setBold( true );

              $rows++;
              foreach ($value2['sskel'] as $key3 => $value3) {
                $total_rek = $value2['apbd']+$value2['bos']+$value2['blud']+$value2['bpp']+$value2['lainnya'];
                  $objPHPExcel->setActiveSheetIndex(0)              
                    ->setCellValue("A$rows",$nomor)
                    ->setCellValue("B$rows",$key3)
                    ->setCellValue("C$rows",$value3['nm_perk'])
                    ->setCellValue("D$rows",$value3['saldo_awal'])
                    ->setCellValue("E$rows",$value3['apbd'])
                    ->setCellValue("F$rows",$value3['bos'])
                    ->setCellValue("G$rows",$value3['blud'])
                    ->setCellValue("H$rows",$value3['bprov'])
                    ->setCellValue("I$rows",$value3['bpusat'])
                    ->setCellValue("J$rows",$value3['transfer'])
                    ->setCellValue("K$rows",$value3['lainnya'])
                    ->setCellValue("L$rows",$value3['pengeluaran'])
                    ->setCellValue("M$rows",$value3['saldo_akhir'])
                    ;   
                    $sheet->getStyle("A$rows:M$rows")->applyFromArray($border);
                    $sheet->getStyle("C$rows")->applyFromArray($left);
                    $sheet->getStyle("A$rows")->applyFromArray($horizontal);
                    $sheet->getStyle("A$rows:M$rows")->applyFromArray($vertical);
                    $sheet->getStyle("D$rows:M$rows")->applyFromArray($right);
                    $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(30);

                    $objPHPExcel->getActiveSheet()->getStyle("B$rows")->getAlignment()->setWrapText(true); 
                  $nomor++;
                  $rows++;
              }

          }
            $saldo_akhir = $value['saldo_awal']+$value['apbd']+$value['blud']+$value['bprov']+$value['bpusat']+$value['transfer']+$value['lainnya']-$value['pengeluaran'];
              $sheet->mergeCells("A$rows:C$rows");
              if(count($dataFinal)>1){
                $formula = "=D$rows+E$rows+F$rows+G$rows+H$rows+I$rows+J$rows+K$rows-L$rows";
                $objPHPExcel->setActiveSheetIndex(0)              
                    ->setCellValue("A$rows","SUBTOTAL")
                    ->setCellValue("D$rows",$value['saldo_awal'])
                    ->setCellValue("E$rows",$value['apbd'])
                    ->setCellValue("F$rows",$value['bos'])
                    ->setCellValue("G$rows",$value['blud'])
                    ->setCellValue("H$rows",$value['bprov'])
                    ->setCellValue("I$rows",$value['bpusat'])
                    ->setCellValue("J$rows",$value['transfer'])
                    ->setCellValue("K$rows",$value['lainnya'])
                    ->setCellValue("L$rows",$value['pengeluaran'])
                    ->setCellValue("M$rows",$formula)
                    ;   

                    $sheet->getStyle("A$rows:M$rows")->applyFromArray($border);
                    $sheet->getStyle("B$rows")->applyFromArray($left);
                    $sheet->getStyle("A$rows:B$rows")->applyFromArray($horizontal);
                    $sheet->getStyle("A$rows:F$rows")->applyFromArray($vertical);
                    $sheet->getStyle("C$rows:F$rows")->applyFromArray($right);
                    $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(40);
                    $objPHPExcel->getActiveSheet()->getStyle("A$rows:M$rows")->getFont()->setBold( true );
                    $objPHPExcel->getActiveSheet()->getStyle("B$rows")->getAlignment()->setWrapText(true); 
                $rows++;

              } 
        }

        $saldo_akhir = $saldo_awal+$apbd+$bos+$blud+$bpusat+$bprov+$transfer+$lainnya-$pengeluaran;
        $sheet->mergeCells("A$rows:C$rows");
        $formula = "=D$rows+E$rows+F$rows+G$rows+H$rows+I$rows+J$rows+K$rows-L$rows";
        $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows","GRAND TOTAL")
                ->setCellValue("D$rows",$saldo_awal)
                ->setCellValue("E$rows",$apbd)
                ->setCellValue("F$rows",$bos)
                ->setCellValue("G$rows",$blud)
                ->setCellValue("H$rows",$bprov)
                ->setCellValue("I$rows",$bpusat)
                ->setCellValue("J$rows",$transfer)
                ->setCellValue("K$rows",$lainnya)
                ->setCellValue("L$rows",$pengeluaran)
                ->setCellValue("M$rows",$formula)
                ;   

                $sheet->getStyle("A$rows:M$rows")->applyFromArray($border);
                $sheet->getStyle("B$rows")->applyFromArray($left);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($horizontal);
                $sheet->getStyle("A$rows:F$rows")->applyFromArray($vertical);
                $sheet->getStyle("D$rows:M$rows")->applyFromArray($right);
                $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(30);
                $objPHPExcel->getActiveSheet()->getStyle("A$rows:M$rows")->getFont()->setBold( true );

        Header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LAPORAN POSISI PERSEDIAAN PER REKENING.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        
        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
}

public function laporan_per_rekening($data){

    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $satker_asal = $data['satker_asal'];
    $tgl_cetak = $data['tgl_cetak'];
    $thn_ang = $data['thn_ang'];
    $lingkup = $data['lingkup'];

    $date = $this->cek_periode($data);
    

    $sql    = "SELECT kd_lokasi, nm_satker, kd_perk,nm_perk, sum(total_harga) as total_harga, jns_trans from transaksi_masuk   where concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' and thn_ang='$thn_ang' and tgl_dok>'$tgl_dok' and total_harga>0  group by kd_perk, jns_trans, kd_lokasi order by kd_perk asc,kd_lokasi asc, jns_trans asc";
            // print_r($sql);
    $no      =1;
    $apbd    =0;
    $bp      =0;
    $blud    =0;
    $bos     =0;
    $lainnya =0;
    $result  = $this->query($sql);
    $dataPerSKPD  = array();
    $dataFinal= array();

    $count = 0;


    foreach ($result as $val) {
        $dataFinal["$val[kd_lokasi]"]['nm_satker'] = $val['nm_satker'];
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]['nm_perk'] = $val[nm_perk];
      if($val['jns_trans']=="M07"){
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["apbd"] += $val['total_harga'];
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["bos"] += 0;
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["blud"] += 0;
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["bpp"] += 0;
        $apbd    += $val['total_harga'];

    }
    elseif($val['jns_trans']=="M08"||$val['jns_trans']=="M09"){
        $dataFinal["$val[kd_lokasi]"]["$val[kd_perk]"]["apbd"] += 0;
        $dataFinal["$val[kd_lokasi]"]["$val[kd_perk]"]["bos"] += 0;
        $dataFinal["$val[kd_lokasi]"]["$val[kd_perk]"]["blud"] += 0;
        $dataFinal["$val[kd_lokasi]"]["$val[kd_perk]"]["bpp"] += $val['total_harga'];
        $bp      += $val['total_harga'];
    }
    elseif($val['jns_trans']=="M10"){
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["apbd"] += 0;
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["bos"] += $val['total_harga'];
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["blud"] += 0;
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["bpp"] += 0;
        $bos     += $val['total_harga'];
    }

    elseif($val['jns_trans']=="M11"){
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["apbd"] += 0;
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["bos"] += 0;
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["blud"] += $val['total_harga'];
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["bpp"] += 0;
        $blud    += $val['total_harga'];
    }

    elseif($val['jns_trans']=="M12"){
        $dataFinal["$val[kd_lokasi]"]['data']["$val[kd_perk]"]["lainnya"] += $val['total_harga'];
         $lainnya += $val['total_harga'];
    }
    else{

    }
       
        
        
       
}

    if($data['format']=='pdf'){
        ob_start();
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN POSISI PERSEDIAAN DI NERACA PER REKENING</p>
        <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$date.'</p>
        <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p><br></br>';
        $this->getsatker($kd_lokasi);


        echo '<table style="border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">
        <tr>
        <td style="text-align: center;" width="5%"><b>NO</b></td>
        <td style="text-align: center;" width="12%"><b>REKENING PERSEDIAAN</b></td>
        <td style="text-align: center;" style="align:left;"><b>URAIAN REK. PERSEDIAAN</b></td>
        <td style="text-align: center;" width="14%"><b>APBD</b></td>
        <td style="text-align: center;" width="14%"><b>BOS</b></td>
        <td style="text-align: center;" width="14%"><b>BLUD</b></td>
        <td style="text-align: center;" width="14%"><b>Bantuan Pem.Pusat / Prov.</b></td>
        <td style="text-align: center;" width="14%"><b>Lainnya</b></td>
        <td style="text-align: center;" width="14%"><b>Total</b></td>
        </tr>';
        $no=1;
        foreach ($dataFinal as $key => $value) {
            $detilSatker = explode("-", $key);
            echo "<tr>
            <td colspan='9' style='background-color:#EFEFEF;'><b>$value[nm_satker]</b></td>
            </tr>";
            foreach ($value['data'] as $key2 => $value2) {
              $total_rek = $value2['apbd']+$value2['bos']+$value2['blud']+$value2['bpp']+$value2['lainnya'];
              echo '<tr>
              <td style="text-align: center;">'.$no.'</td>
              <td style="text-align:center;">'.$key2.'</td>
              <td style="align:left;">'.$value2['nm_perk'].'</td>
              <td style="text-align: right;">'.number_format($value2['apbd'],2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($value2['bos'],2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($value2['blud'],2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($value2['bpp'],2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($value2['lainnya'],2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($total_rek,2,",",".").'</td>    
              </tr>';
              $no++;
          }
        }
        $total_rek = $apbd+$bos+$blud+$bpp+$lainnya;

            echo '<tr>
              <td style="text-align: center;" colspan="3">TOTAL</td>
              <td style="text-align: right;">'.number_format($apbd,2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($bos,2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($blud,2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($bp,2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($lainnya,2,",",".").'</td>    
              <td style="text-align: right;">'.number_format($total_rek,2,",",".").'</td>    
              </tr>';


        echo "</table>";
                    // exit;
        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new mPDF('utf-8', 'A4-L');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("rekap_per_rekening.pdf" ,'I');

    }
    else{
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator($_SESSION['nm_satker'])
                  ->setLastModifiedBy("")
                  ->setTitle("LAPORAN SALDO REKENING PERSEDIAAN");
        $border = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              )
          );
        $default_border = array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          );

              $horizontal = array(
                  'alignment' => array(
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                  )
              );
              $vertical = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                  )
              );
              $left = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                  )
              );
              $right = array(
                  'alignment' => array(
                      'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                  )
              );
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);


        $objPHPExcel->getActiveSheet()->getStyle('A:L')->getAlignment()->setWrapText(true); 



        $sheet = $objPHPExcel->getActiveSheet()->setTitle("Lap. Saldo Persediaan");
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A5:B5');
        $sheet->mergeCells('A6:B6');
        $sheet->mergeCells('A7:B7');
        $sheet->mergeCells('A8:B8');
        $sheet->mergeCells('A9:B9');
        $sheet->mergeCells('A10:B10');

        $sheet->getStyle("A12:I12")->applyFromArray($border);
        $objPHPExcel->getActiveSheet()->getRowDimension("12")->setRowHeight(40);

        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->applyFromArray($horizontal);    
        $sheet->getStyle('A1:A3')->applyFromArray($vertical);
        $sheet->getStyle('A12:I12')->applyFromArray($horizontal);    
        $sheet->getStyle('A12:I12')->applyFromArray($vertical);
        $skpd = $this->getsatker($kd_lokasi);
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1',"LAPORAN SALDO REKENING PERSEDIAAN" )
                ->setCellValue('A2',"PERIODE ".$date)
                ->setCellValue('A3',"TAHUN ANGGARAN ".$thn_ang )
                ->setCellValue('A5',"Provinsi" )
                ->setCellValue('A6',"Kabupaten / Kota" )
                ->setCellValue('A7',"Bidang" )
                ->setCellValue('A8',"Unit Organisasi" )
                ->setCellValue('A9',"Sub Unit Organisasi" )
                ->setCellValue('A10',"UPB" )                
                ->setCellValue('C5',": Jawa Tengah" )
                ->setCellValue('C6',": Kota Pekalongan" )
                ->setCellValue('C7',": ".$skpd['nama_sektor'] )
                ->setCellValue('C8',": ".$skpd['nama_satker'] )
                ->setCellValue('C9',": ".$skpd['nama_unit'] )
                ->setCellValue('C10',": ".$skpd['nama_gudang'] )                
                ->setCellValue('A12',"NO" )
                ->setCellValue('B12',"REKENING" )
                ->setCellValue('C12',"URAIAN" )
                ->setCellValue('D12',"APBD" )
                ->setCellValue('E12',"BOS" )
                ->setCellValue('F12',"BLUD" )
                ->setCellValue('G12',"BANTUAN PEMPROV / PUSAT." )
                ->setCellValue('H12',"LAINNYA" )
                ->setCellValue('I12',"TOTAL" )
                ;
        $rows = 13;
        $nomor=1;
        foreach ($dataFinal as $key => $value) {
            $detilSatker = explode("-", $key);
            $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows",$value['nm_satker']);
            $sheet->mergeCells("A$rows:I$rows");
            $sheet->getStyle("A$rows:I$rows")->applyFromArray($border);
            $sheet->getStyle("A$rows:I$rows")->applyFromArray($left);
            $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(20);


            $rows++;
            foreach ($value['data'] as $key2 => $value2) {
              $total_rek = $value2['apbd']+$value2['bos']+$value2['blud']+$value2['bpp']+$value2['lainnya'];
              $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows",$nomor)
                ->setCellValue("B$rows",$key2)
                ->setCellValue("C$rows",$value2['nm_perk'])
                ->setCellValue("D$rows",number_format($value2['apbd'],2,",","."))
                ->setCellValue("E$rows",number_format($value2['bos'],2,",","."))
                ->setCellValue("F$rows",number_format($value2['blud'],2,",","."))
                ->setCellValue("G$rows",number_format($value2['bpp'],2,",","."))
                ->setCellValue("H$rows",number_format($value2['lainnya'],2,",","."))
                ->setCellValue("I$rows",number_format($total_rek,2,",","."))
                ;   
                $sheet->getStyle("A$rows:I$rows")->applyFromArray($border);
                $sheet->getStyle("C$rows")->applyFromArray($left);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($horizontal);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($vertical);
                $sheet->getStyle("D$rows:I$rows")->applyFromArray($right);
                $objPHPExcel->getActiveSheet()->getRowDimension("$rows")->setRowHeight(40);

                $objPHPExcel->getActiveSheet()->getStyle("D$rows:I$rows")->getAlignment()->setWrapText(true); 


              $nomor++;
              $rows++;

          }
        }
        $total_rek = $apbd+$bos+$blud+$bpp+$lainnya;
        $objPHPExcel->setActiveSheetIndex(0)              
                ->setCellValue("A$rows","TOTAL")
                ->setCellValue("D$rows",number_format($apbd,2,",","."))
                ->setCellValue("E$rows",number_format($bos,2,",","."))
                ->setCellValue("F$rows",number_format($blud,2,",","."))
                ->setCellValue("G$rows",number_format($bp,2,",","."))
                ->setCellValue("H$rows",number_format($lainnya,2,",","."))  
                ->setCellValue("I$rows",number_format($total_rek,2,",","."));   
                $sheet->getStyle("A$rows:I$rows")->applyFromArray($border);
                $sheet->getStyle("C$rows")->applyFromArray($left);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($horizontal);
                $sheet->getStyle("A$rows:B$rows")->applyFromArray($vertical);
                $sheet->getStyle("D$rows:I$rows")->applyFromArray($right);

                $sheet->mergeCells("A$rows:C$rows");

        Header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LAPORAN POSISI PERSEDIAAN PER REKENING.xlsx"');
        header('Cache-Control: max-age=0');


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
   
    }

    




}

public function surat_permintaan_barang($data){
    $no_dok = $data['no_dok']; 
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $thn_ang = $data['thn_ang'];

    $sql = "select kd_lokasi, kd_ruang, tgl_dok, kd_brg, nm_brg, qty, satuan, keterangan from transaksi_keluar where no_dok = '$no_dok' and thn_ang='$thn_ang' ";
    $res = $this->query($sql);
        // $arr_date = $this->fetch_array($res);
    $rekap = array();
    $no= 1;
    foreach ($res as $value) {
        $tgl_dok = $value['tgl_dok'];
        $kd_lokasi = $value['kd_lokasi'].$value['kd_ruang'];
        $kd_brg = $value['kd_brg'];
        $sql_out = " select sum(qty) as jumlah from transaksi_keluar where concat(kd_lokasi, IFNULL(kd_ruang,''))= '$kd_lokasi' and kd_brg = '$kd_brg' and thn_ang = '$thn_ang' and tgl_dok<='$tgl_dok' and no_dok!= '$no_dok' ";
        $res_out=$this->query($sql_out);
        $data_out = $this->fetch_array($res_out);
        $sql_in = " select sum(qty) as jumlah from transaksi_masuk where concat(kd_lokasi, IFNULL(kd_ruang,''))= '$kd_lokasi' and kd_brg = '$kd_brg' and thn_ang = '$thn_ang' and tgl_dok<='$tgl_dok'";
        $res_in=$this->query($sql_in);
        $data_in = $this->fetch_array($res_in);
        $sisa_barang = $data_in['jumlah'] + $data_out['jumlah'];
        $rekap[]=array(
            'no' => $no,
            'nama_barang' => $value['nm_brg'],
            'qty' => abs($value['qty'])." ".$value['satuan'],
            'sisa' => $sisa_barang." ".$value['satuan'],
            'keterangan' => $value['keterangan']
        ); 
        $no++;
    }

            // $this->excel_export($html,"Penerimaan_brg");
    $TBS = new clsTinyButStrong;  
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
    $template = '../../utility/optbs/template/surat_permintaan_barang.xlsx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $TBS->MergeBlock('a', $rekap);

    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
    $output_file_name = "surat_permintaan_barang.xlsx"; 
    if ($save_as==='') { 
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
        exit(); 
    } 
    else { 
        $TBS->Show(OPENTBS_FILE, $output_file_name);  
        exit("File [$output_file_name] has been created."); 
    } 

} 

public function surat_penyaluran_barang($data){
    $no_dok = $data['no_dok']; 
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $thn_ang = $data['thn_ang'];

    $sql = "select kd_lokasi, kd_ruang, tgl_dok, kd_brg, nm_brg, qty,harga_sat,total_harga, satuan, keterangan from transaksi_keluar where no_dok = '$no_dok' and thn_ang='$thn_ang' ";
    $res = $this->query($sql);
        // $arr_date = $this->fetch_array($res);
    $rekap = array();
    $no= 1;
    $identitas[] = array('no_dok'=>$no_dok);
    foreach ($res as $value) {
        $tgl_dok = $value['tgl_dok'];
        $kd_lokasi = $value['kd_lokasi'].$value['kd_ruang'];
        $kd_brg = $value['kd_brg'];
        $sql_out = " select sum(qty) as jumlah from transaksi_keluar where no_dok= '$no_dok' ";
        $res_out = $this->query($sql_out);
        $rekap[]=array(
            'no' => $no,
            'nama_barang' => $value['nm_brg'],
            'jumlah' => abs($value['qty'])." ".$value['satuan'],
            'harga_sat' => number_format($value['harga_sat'],2,",","."),
            'total_harga' => number_format(abs($value['total_harga']),2,",","."),
            'keterangan' => $value['keterangan']
        ); 
    }

            // $this->excel_export($html,"Penerimaan_brg");
    $TBS = new clsTinyButStrong;  
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
    $template = '../../utility/optbs/template/surat_penyaluran_barang.xlsx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $TBS->MergeBlock('a', $rekap);
    $TBS->MergeBlock('c',$identitas);

    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
    $output_file_name = "surat_permintaan_barang.xlsx"; 
    if ($save_as==='') { 
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
        exit(); 
    } 
    else { 
        $TBS->Show(OPENTBS_FILE, $output_file_name);  
        exit("File [$output_file_name] has been created."); 
    } 

} 

public function bukti_pengambilan_barang($data){
    $no_dok = $data['no_dok']; 
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $thn_ang = $data['thn_ang'];

    $sql = "select kd_lokasi, kd_ruang, tgl_dok, kd_brg, nm_brg, qty,harga_sat,total_harga, satuan, keterangan from transaksi_keluar where no_dok = '$no_dok' and thn_ang='$thn_ang' ";
    $res = $this->query($sql);
        // $arr_date = $this->fetch_array($res);
    $rekap = array();
    $no= 1;
    $identitas[] = array('no_dok'=>$no_dok);
    foreach ($res as $value) {
        $tgl_dok = $value['tgl_dok'];
        $kd_lokasi = $value['kd_lokasi'].$value['kd_ruang'];
        $kd_brg = $value['kd_brg'];
        $sql_out = " select sum(qty) as jumlah from transaksi_keluar where no_dok= '$no_dok' ";
        $res_out = $this->query($sql_out);
        $rekap[]=array(
            'no' => $no,
            'tanggal' => $value['tgl_dok'],
            'kd_brg' => $value['kd_brg'],
            'nama_barang' => $value['nm_brg'],
            'qty' => abs($value['qty']),
            'satuan' => $value['satuan'],
            'harga_sat' => number_format($value['harga_sat'],2,",","."),
            'total_harga' => number_format(abs($value['total_harga']),2,",","."),
            'keterangan' => $value['keterangan']
        );
        $no++; 
    }

            // $this->excel_export($html,"Penerimaan_brg");
    $TBS = new clsTinyButStrong;  
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
    $template = '../../utility/optbs/template/bukti_pengambilan_barang.xlsx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 

    $TBS->MergeBlock('a', $rekap);
    $TBS->MergeBlock('c',$identitas);

    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
    $output_file_name = "bukti_pengambilan_barang.xlsx"; 
    if ($save_as==='') { 
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
        exit(); 
    } 
    else { 
        $TBS->Show(OPENTBS_FILE, $output_file_name);  
        exit("File [$output_file_name] has been created."); 
    } 

} 

public function buku_persediaan($data)
{

        // $mpdf->setFooter('{PAGENO}');
    ob_start(); 
    $jenis = $data['jenis'];
    $kd_brg = $data['kd_brg']; 
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $satker_asal = $data['kd_lokasi'];
    $format = $data['format'];

    $hasil = $this->query_brg($kd_brg,$kd_lokasi);
    while($kode_brg=$this->fetch_array($hasil)) 
    {
        $this->cetak_header($data,"buku_persediaan",$kd_lokasi,$kode_brg['kd_brg'],"");
        $this->get_query($data,"buku_persediaan",$kd_lokasi,$kode_brg['kd_brg'],"","");
        echo '<pagebreak />';
            // $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
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
        $tgl_cetak = $data['tgl_cetak'];
        $thn_ang_lalu = intval($thn_ang)-1;
        $kd_brg = $data['kd_brg']; 
        $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
        $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
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
            <td  align="right" style="font-size:90%;">'.number_format($data[hrg_thn_lalu],2,",",".").'</td> 
            <td align="center" style="font-size:90%;">'.$jml_msk.'</td> 
            <td align="center" style="font-size:90%;">'.abs($jml_klr).'</td> 
            <td align="center" style="font-size:90%;">'.$jumlah.'</td> 
            <td align="center" style="font-size:90%;">'.$jml_selisih.'</td> 
            <td align="right" style="font-size:90%;">'.number_format($hrg_selisih,2,",",".").'</td> 
            </tr>';
        }
        echo '<tr>
        <td colspan="2">JUMLAH</td>  
        <td colspan="2" align="right">'.number_format($total_thn_lalu,2,",",".").'</td> 
        <td colspan="3"></td>  
        <td colspan="2" align="right">'.number_format($total_akumulasi,2,",",".").'</td>  
        </tr>';
        echo '</table>';
        if($no>=6)
        {
            echo '<pagebreak />';
        }
        $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);

                // $this->hitung_brg_rusak($kd_lokasi);
                $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                ob_end_clean();
                //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                $mpdf->WriteHTML(utf8_encode($html));
                $mpdf->Output($nama_dokumen.".pdf" ,'I');
                exit;
            }

            public function query_bidang($lingkup,$kd_lokasi) {
                if($lingkup=="upb") {
                    return "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and char_length(kode)=11 and kd_ruang is null order by kode asc";
                }
                else if($lingkup=="skpd"){
                    return "SELECT kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and char_length(kode)=5 order by kode asc";
                }
                else if($lingkup=="kota"){
                    return "SELECT kd_lokasi from user where kd_lokasi is null limit 1";
                }
                else {
                    return "SELECT CONCAT(kode,IFNULL(kd_ruang,'')) kode, NamaSatker FROM satker where concat(kode,IFNULL(kd_ruang,'')) like '$kd_lokasi%' and char_length(kode)=11 order by kode asc";
                }
            } 
            public function rincian_persediaan2($data_lp)
            {
                echo "<pre>";
                $mpdf=new mPDF('utf-8', 'A4-L');
                ob_start();
                // print_r($data_lp);
                $kd_brg = $data_lp['kd_brg'];
                $format = $data_lp['format'];
                $kd_lokasi = $data_lp['kd_lokasi'];
                $satker_asal = $data_lp['satker_asal'];
                $lingkup = $data_lp['lingkup'];
                $tgl_cetak = $data_lp['tgl_cetak'];
                $no_urut = 0;
                $this->cetak_header($data_lp,"rincian_persediaan2",$kd_lokasi,"",$no);
                $query = $this->query_bidang($lingkup,$kd_lokasi);
                $result = $this->query($query);
                $date_cond = $this->dateRange($data_lp);
                $sql= "SELECT kd_lokasi,
                nm_satker,
                kd_perk, nm_perk, harga_sat,
                sum(CASE WHEN jns_trans = 'M01' THEN qty ELSE 0 END) as saldo_awal, 
                sum(CASE WHEN jns_trans != 'M01' THEN qty ELSE 0 END) as jml_msk, 
                sum(CASE WHEN jns_trans != 'M01' THEN qty_akhir ELSE 0 END) as sisa
                FROM transaksi_masuk where concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
                and thn_ang='$data_lp[thn_ang]' 
                and kd_perk IS not null 
                and kd_perk!=''   
                and tgl_dok <= '$data_lp[tgl_akhir]' 
                GROUP by kd_lokasi, kd_perk";

                $query = "SELECT kd_lokasi, nm_satker, kd_perk, nm_perk, harga_sat, 
                            qty, qty_akhir, jns_trans  
                          FROM transaksi_masuk 
                          WHERE
                            concat(kd_lokasi,IFNULL(kd_ruang,'')) LIKE '$kd_lokasi%'  AND 
                            thn_ang='$data_lp[thn_ang]' AND 
                            tgl_dok <= '$data_lp[tgl_akhir]' AND
                            kd_perk IS NOT NULL AND
                            kd_perk!='' 
                        ORDER BY kd_lokasi asc, kd_perk asc, jns_trans ASC";
                // echo $query;
                $data = array();
                // echo "<pre>";
                // print_r($data_lp);
                // echo $sql;
                // exit;
                $dataPerSKPD = array();
                $jml_klr =0;
                $nilai_klr =0;
                $jml_msk =0;
                $nilai_msk =0;
                $saldo_awal =0;
                $nilai_saldo_awal =0;
                $sisa =0;
                $nilai_sisa =0;
                $dtMutasi = $this->query($query);

                $data_final = array();

                    foreach ($dtMutasi as $key2 => $isi) {
                        $key = $isi['kd_lokasi'];
                        // print_r($isi);
                        $data_final[$key]['nm_satker'] = $isi['nm_satker'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['kd_perk'] = $isi['kd_perk'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['nm_perk'] = $isi['nm_perk'];

                        if($isi['jns_trans']=="M01"){


                             $data_final[$key]['data']["$isi[kd_perk]"]['saldo_awal'] += $isi['qty'];
                             $data_final[$key]['data']["$isi[kd_perk]"]['nilai_saldo_awal'] += ($isi['qty']*$isi['harga_sat']);

                             $saldo_awal += $isi['qty'];
                             $nilai_saldo_awal += ($isi['qty']*$isi['harga_sat']);


                            $data_final[$key]['saldo_awal'] += $isi['qty'];
                            $data_final[$key]['nilai_saldo_awal'] += ($isi['qty']*$isi['harga_sat']);
                        }
                        else{

                            $data_final[$key]['data']["$isi[kd_perk]"]['jml_msk'] += $isi['qty'];
                            $data_final[$key]['data']["$isi[kd_perk]"]['nilai_msk'] += ($isi['qty']*$isi['harga_sat']);


                            $jml_msk += $isi['qty'];
                            $nilai_msk += ($isi['qty']*$isi['harga_sat']);


                            $data_final[$key]['jml_msk'] +=$isi['qty'];
                            $data_final[$key]['nilai_msk'] += ($isi['qty']*$isi['harga_sat']);
                        }
                        
                        $data_final[$key]['data']["$isi[kd_perk]"]['sisa'] += $isi['qty_akhir'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['nilai_sisa'] += ($isi['qty_akhir']*$isi['harga_sat']);                        
                        $data_final[$key]['data']["$isi[kd_perk]"]['jml_klr'] += ($isi['qty'] - $isi['qty_akhir']);
                        $data_final[$key]['data']["$isi[kd_perk]"]['nilai_klr'] += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);

                        $jml_klr    += ($isi['qty'] - $isi['qty_akhir']);
                        $nilai_klr  += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);

                        $data_final[$key]['jml_klr'] += ($isi['qty'] - $isi['qty_akhir']);
                        $data_final[$key]['nilai_klr'] += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);
                        $data_final[$key]['sisa'] =  $data_final[$key]['saldo_awal'] + $data_final[$key]['jml_msk'] - $data_final[$key]['jml_klr'];
                        $data_final[$key]['nilai_sisa'] =  $data_final[$key]['nilai_saldo_awal'] + $data_final[$key]['nilai_msk'] - $data_final[$key]['nilai_klr'];
                    }

                $nilai_sisa  = ($nilai_msk+$nilai_saldo_awal)-$nilai_klr;
                $sisa        = ($jml_msk+$saldo_awal)-$jml_klr;


                echo '<tr>
                <td colspan="3" style="font-weight:bold; background-color:#EFEFEF;"></td>
                <td align="center"  style="font-size:90%; background-color:#EFEFEF; "><b>'.$saldo_awal.'</b></td>
                <td align="right"  style="font-size:90%; background-color:#EFEFEF; "><b>'.number_format($nilai_saldo_awal,2,",",".").'</b></td>
                <td align="center"  style="font-size:90%; background-color:#EFEFEF; "><b>'.$jml_msk.'</b></td>
                <td align="center"  style="font-size:90%; background-color:#EFEFEF; "><b>'.$jml_klr.'</b></td>
                <td align="center"  style="font-size:90%; background-color:#EFEFEF; "><b>'.$sisa.'</b></td>
                <td align="right"  style="font-size:90%; background-color:#EFEFEF; "><b>'.number_format($nilai_sisa,2,",",".").'</b>
                </tr>';
                $no_urut_satker=1;
                foreach ($data_final as $key => $value) {
                    echo '<tr>
                    <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut_satker.'</td>
                    <td colspan="2" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$value['nm_satker'].'</td>
                    <td align="center"  style="font-size:90%; background-color:#EFEFEF; "><b>'.$value['saldo_awal'].'</b></td>
                    <td align="right"  style="font-size:90%; background-color:#EFEFEF; "><b>'.number_format($value['nilai_saldo_awal'],2,",",".").'</b></td>
                    <td align="center"  style="font-size:90%; background-color:#EFEFEF; "><b>'.$value['jml_msk'].'</b></td>
                    <td align="center"  style="font-size:90%; background-color:#EFEFEF; "><b>'.$value['jml_klr'].'</b></td>
                    <td align="center"  style="font-size:90%; background-color:#EFEFEF; "><b>'.$value['sisa'].'</b></td>
                    <td align="right"  style="font-size:90%; background-color:#EFEFEF; "><b>'.number_format($value['nilai_sisa'],2,",",".").'</b>
                    </tr>';
                    $no_urut_satker++;
                    foreach ($value['data'] as $key2 => $value2) {
                        echo '  <tr>
                        <td align="right" style="font-size:90%; "></td>
                        <td align="right" style="font-size:90%; ">'.$value2['kd_perk'].'</td>
                        <td align="left" style="font-size:90%; ">'.$value2['nm_perk'].'</td>
                        <td align="center"  style="font-size:90%; "><b>'.$value2['saldo_awal'].'</b></td>
                        <td align="right"  style="font-size:90%; "><b>'.number_format($value2['nilai_saldo_awal'],2,",",".").'</b></td>
                        <td align="center"  style="font-size:90%; "><b>'.$value2['jml_msk'].'</b></td>
                        <td align="center"  style="font-size:90%; "><b>'.$value2['jml_klr'].'</b></td>
                        <td align="center"  style="font-size:90%; "><b>'.$value2['sisa'].'</b></td>
                        <td align="right"  style="font-size:90%; "><b>'.number_format($value2['nilai_sisa'],2,",",".").'</b></td>
                        </tr>';
                    }
                }


                
                // while($kdsatker=$this->fetch_assoc($result))
                // { 
                //   $no_urut++;
                //   $kd_lokasi2=$kdsatker['kode'];
                //   $nm_satker=$kdsatker['NamaSatker'];

                //   $this->get_query($data_lp,"rincian_persediaan2",$kd_lokasi2,"",$nm_satker,$no_urut);


                // }
                echo '</table>';
                // exit;
                $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
                $html = ob_get_contents();
                ob_end_clean();
                // echo $html;
                // exit;
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

            public function laporan_persediaan($data_lp)
            {
                $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
                $kd_lokasi = $data_lp['kd_lokasi'].$kd_ruang;
                $satker_asal = $data_lp['satker_asal'];
                $format = $data_lp['format'];
                $tgl_cetak = $data_lp['tgl_cetak'];
                $lingkup = $data_lp['lingkup'];
                ob_start(); 
                $this->cetak_header($data_lp,"laporan_persediaan",$kd_lokasi,"",$no);

                $query = $this->query_bidang($lingkup,$kd_lokasi);
                $result = $this->query($query);
                $sql = "SELECT kd_lokasi, nm_satker, kd_perk, nm_perk, harga_sat, 
                            qty, qty_akhir, jns_trans  
                          FROM transaksi_masuk 
                          WHERE
                            concat(kd_lokasi,IFNULL(kd_ruang,'')) LIKE '$kd_lokasi%'  AND 
                            thn_ang='$data_lp[thn_ang]' AND 
                            tgl_dok <= '$data_lp[tgl_akhir]' AND
                            kd_perk IS NOT NULL AND
                            kd_perk!='' 
                        ORDER BY kd_lokasi asc, kd_perk asc, jns_trans ASC";
                $data = array();
                $jml_klr =0;
                $nilai_klr =0;
                $jml_msk =0;
                $nilai_msk =0;
                $saldo_awal =0;
                $nilai_saldo_awal =0;
                $sisa =0;
                $nilai_sisa =0;
                $dataPerSKPD = array();
                $dtMutasi = $this->query($sql);
                $data_final = array();
                    foreach ($dtMutasi as $key2 => $isi) {
                        $key = $isi['kd_lokasi'];
                        // print_r($isi);
                        $data_final[$key]['nm_satker'] = $isi['nm_satker'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['kd_perk'] = $isi['kd_perk'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['nm_perk'] = $isi['nm_perk'];

                        if($isi['jns_trans']=="M01"){


                             $data_final[$key]['data']["$isi[kd_perk]"]['saldo_awal'] += $isi['qty'];
                             $data_final[$key]['data']["$isi[kd_perk]"]['nilai_saldo_awal'] += ($isi['qty']*$isi['harga_sat']);

                             $saldo_awal += $isi['qty'];
                             $nilai_saldo_awal += ($isi['qty']*$isi['harga_sat']);


                            $data_final[$key]['saldo_awal'] += $isi['qty'];
                            $data_final[$key]['nilai_saldo_awal'] += ($isi['qty']*$isi['harga_sat']);
                        }
                        else{

                            $data_final[$key]['data']["$isi[kd_perk]"]['jml_msk'] += $isi['qty'];
                            $data_final[$key]['data']["$isi[kd_perk]"]['nilai_msk'] += ($isi['qty']*$isi['harga_sat']);


                            $jml_msk += $isi['qty'];
                            $nilai_msk += ($isi['qty']*$isi['harga_sat']);


                            $data_final[$key]['jml_msk'] +=$isi['qty'];
                            $data_final[$key]['nilai_msk'] += ($isi['qty']*$isi['harga_sat']);
                        }
                        
                        $data_final[$key]['data']["$isi[kd_perk]"]['sisa'] += $isi['qty_akhir'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['nilai_sisa'] += ($isi['qty_akhir']*$isi['harga_sat']);                        
                        $data_final[$key]['data']["$isi[kd_perk]"]['jml_klr'] += ($isi['qty'] - $isi['qty_akhir']);
                        $data_final[$key]['data']["$isi[kd_perk]"]['nilai_klr'] += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);

                        $jml_klr    += ($isi['qty'] - $isi['qty_akhir']);
                        $nilai_klr  += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);

                        $data_final[$key]['jml_klr'] += ($isi['qty'] - $isi['qty_akhir']);
                        $data_final[$key]['nilai_klr'] += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);
                        $data_final[$key]['sisa'] =  $data_final[$key]['saldo_awal'] + $data_final[$key]['jml_msk'] - $data_final[$key]['jml_klr'];
                        $data_final[$key]['nilai_sisa'] =  $data_final[$key]['nilai_saldo_awal'] + $data_final[$key]['nilai_msk'] - $data_final[$key]['nilai_klr'];
                    }
                $nilai_sisa  = ($nilai_msk+$nilai_saldo_awal)-$nilai_klr;
                $sisa        = ($jml_msk+$saldo_awal)-$jml_klr;

                $no_urut_satker=1;

                echo '<tr>
                <td colspan="3" style="font-weight:bold; background-color:#EFEFEF;"></td>
                <td align="right"  style="font-size:90%; background-color:#EFEFEF; "><b>'.number_format($nilai_sisa,2,",",".").'</b>
                </tr>';
                foreach ($data_final as $key => $value) {
                    echo '<tr>
                    <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut_satker.'</td>
                    <td colspan="2" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$value['nm_satker'].'</td>
                    <td  align="right"  style="font-size:90%; background-color:#EFEFEF; "><b>'.number_format($value['nilai_sisa'],2,",",".").'</b>
                    </tr>';
                    $no_urut_satker++;
                    foreach ($value['data'] as $key2 => $value2) {
                        echo '  <tr>
                        <td align="right" style="font-size:90%; "></td>
                        <td align="right" style="font-size:90%; ">'.$value2['kd_perk'].'</td>
                        <td align="left" style="font-size:90%; ">'.$value2['nm_perk'].'</td>
                        <td align="right"  style="font-size:90%; "><b>'.number_format($value2['nilai_sisa'],2,",",".").'</b></td>
                        </tr>';
                    }
                }         

                echo '</table>';
                $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        if($format=="excel"){
            $this->excel_export($html,"Neraca");
        }
        else {
            $mpdf=new mPDF('utf-8', 'A4');
            $mpdf->setFooter('{PAGENO}');
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("Neraca.pdf" ,'I');
            exit;
        }

    }
    public function neraca($data_lp)
    {
        $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
        $kd_lokasi = $data_lp['kd_lokasi'].$kd_ruang;
        $satker_asal = $data_lp['satker_asal'];
        $format = $data_lp['format'];
        $tgl_cetak = $data_lp['tgl_cetak'];
        $lingkup = $data_lp['lingkup'];
        ob_start(); 
        $this->cetak_header($data_lp,"neraca",$kd_lokasi,"",$no);

        $query = $this->query_bidang($lingkup,$kd_lokasi);
        $result = $this->query($query);
        $sql = "SELECT kd_lokasi, nm_satker, kd_perk, nm_perk, harga_sat, 
                            qty, qty_akhir, jns_trans  
                          FROM transaksi_masuk 
                          WHERE
                            concat(kd_lokasi,IFNULL(kd_ruang,'')) LIKE '$kd_lokasi%'  AND 
                            thn_ang='$data_lp[thn_ang]' AND 
                            tgl_dok <= '$data_lp[tgl_akhir]' AND
                            kd_perk IS NOT NULL AND
                            kd_perk!='' 
                        ORDER BY kd_lokasi asc, kd_perk asc, jns_trans ASC";
        $data = array();
        $jml_klr =0;
        $nilai_klr =0;
        $jml_msk =0;
        $nilai_msk =0;
        $saldo_awal =0;
        $nilai_saldo_awal =0;
        $sisa =0;
        $nilai_sisa =0;
        $dataPerSKPD = array();
        $dtMutasi = $this->query($sql);
        $data_final = array();
                    foreach ($dtMutasi as $key2 => $isi) {
                        $key = $isi['kd_lokasi'];
                        // print_r($isi);
                        $data_final[$key]['nm_satker'] = $isi['nm_satker'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['kd_perk'] = $isi['kd_perk'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['nm_perk'] = $isi['nm_perk'];

                        if($isi['jns_trans']=="M01"){


                             $data_final[$key]['data']["$isi[kd_perk]"]['saldo_awal'] += $isi['qty'];
                             $data_final[$key]['data']["$isi[kd_perk]"]['nilai_saldo_awal'] += ($isi['qty']*$isi['harga_sat']);

                             $saldo_awal += $isi['qty'];
                             $nilai_saldo_awal += ($isi['qty']*$isi['harga_sat']);


                            $data_final[$key]['saldo_awal'] += $isi['qty'];
                            $data_final[$key]['nilai_saldo_awal'] += ($isi['qty']*$isi['harga_sat']);
                        }
                        else{

                            $data_final[$key]['data']["$isi[kd_perk]"]['jml_msk'] += $isi['qty'];
                            $data_final[$key]['data']["$isi[kd_perk]"]['nilai_msk'] += ($isi['qty']*$isi['harga_sat']);


                            $jml_msk += $isi['qty'];
                            $nilai_msk += ($isi['qty']*$isi['harga_sat']);


                            $data_final[$key]['jml_msk'] +=$isi['qty'];
                            $data_final[$key]['nilai_msk'] += ($isi['qty']*$isi['harga_sat']);
                        }
                        
                        $data_final[$key]['data']["$isi[kd_perk]"]['sisa'] += $isi['qty_akhir'];
                        $data_final[$key]['data']["$isi[kd_perk]"]['nilai_sisa'] += ($isi['qty_akhir']*$isi['harga_sat']);                        
                        $data_final[$key]['data']["$isi[kd_perk]"]['jml_klr'] += ($isi['qty'] - $isi['qty_akhir']);
                        $data_final[$key]['data']["$isi[kd_perk]"]['nilai_klr'] += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);

                        $jml_klr    += ($isi['qty'] - $isi['qty_akhir']);
                        $nilai_klr  += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);

                        $data_final[$key]['jml_klr'] += ($isi['qty'] - $isi['qty_akhir']);
                        $data_final[$key]['nilai_klr'] += (($isi['qty'] - $isi['qty_akhir'])*$isi['harga_sat']);
                        $data_final[$key]['sisa'] =  $data_final[$key]['saldo_awal'] + $data_final[$key]['jml_msk'] - $data_final[$key]['jml_klr'];
                        $data_final[$key]['nilai_sisa'] =  $data_final[$key]['nilai_saldo_awal'] + $data_final[$key]['nilai_msk'] - $data_final[$key]['nilai_klr'];
                    }
                $nilai_sisa  = ($nilai_msk+$nilai_saldo_awal)-$nilai_klr;
                $sisa        = ($jml_msk+$saldo_awal)-$jml_klr;
        $no_urut_satker=1;

        echo '<tr>
        <td colspan="3" style="font-weight:bold; background-color:#EFEFEF;"></td>
        <td align="right"  style="font-size:90%; background-color:#EFEFEF; "><b>'.number_format($nilai_sisa,2,",",".").'</b>
        </tr>';
        foreach ($data_final as $key => $value) {
            echo '<tr>
            <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut_satker.'</td>
            <td colspan="2" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$value['nm_satker'].'</td>
            <td  align="right"  style="font-size:90%; background-color:#EFEFEF; "><b>'.number_format($value['nilai_sisa'],2,",",".").'</b>
            </tr>';
            $no_urut_satker++;
            foreach ($value['data'] as $key2 => $value2) {
                echo '  <tr>
                <td align="right" style="font-size:90%; "></td>
                <td align="right" style="font-size:90%; ">'.$value2['kd_perk'].'</td>
                <td align="left" style="font-size:90%; ">'.$value2['nm_perk'].'</td>
                <td align="right"  style="font-size:90%; "><b>'.number_format($value2['nilai_sisa'],2,",",".").'</b></td>
                </tr>';
            }
        }         

        echo '</table>';
        $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
        $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
        ob_end_clean();
        if($format=="excel"){
            $this->excel_export($html,"Neraca");
        }
        else {
            $mpdf=new mPDF('utf-8', 'A4');
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
        $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
        $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
        $format = $data['format'];
        $satker_asal = $data['satker_asal'];
        $this->cetak_header($data_lp,"mutasi_persediaan",$kd_lokasi,"",$no);

        $query = "SELECT concat(kode, IFNULL(kd_ruang,'')) kode, NamaSatker FROM satker where kode like '$kd_lokasi%' and Gudang IS NOT NULL order by kode asc";
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

      $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);

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
                $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
                $kd_lokasi = $data['kd_lokasi'].$kd_ruang;

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
        $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
        $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
        $satker_asal = $data['kd_lokasi'];
        $format = $data['format'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $tgl_cetak = $data['tgl_cetak'];
        $thn_ang = $data['thn_ang'];

        
        if($format=="excel") {
            // $this->excel_export($html,"Penerimaan_brg");
            $TBS = new clsTinyButStrong;  
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            $template = '../../utility/optbs/template/buku_penerimaan_barang.xlsx';
            $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
            $no=1;
            $rekap = array();
            $identitas_pejabat = array();

            // $identitas_pejabat = array();
            $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$satker_asal' ";
            $result_pj = $this->query($query);
            
            $sql="SELECT id, tgl_buku, no_bukti, tgl_dok, concat(nm_brg,' ',spesifikasi) as nm_brg, qty, harga_sat,total_harga, tgl_buku, keterangan 
            FROM transaksi_masuk 
            where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'  
            and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'   
            AND thn_ang='$thn_ang'
            ORDER BY tgl_dok ASC,id asc";
            $res = $this->query($sql);
            $sql = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
            $res_satker = $this->query($sql);
            $data_sakter = $this->fetch_array($res_satker);
            foreach ($res as $value) {
                $rekap[] = array(
                    'no' => $no,
                    'tgl_dok' => $this->konversi_tanggal($value['tgl_dok']),
                    'tgl_buku' => $value['tgl_buku'],
                    'no_bukti' => $value['no_bukti'],
                    'nm_brg' => $value['nm_brg'],
                    'qty' => $value['qty'],
                    'harga_sat' => $value['harga_sat'],
                    'total_harga' => $value['total_harga'],
                    'keterangan' => $value['keterangan']
                );
                $no++;
            }
            
            foreach ($result_pj as $pj) {
                $identitas_pejabat[]  = 
                array('nama_atasan' => $pj['nama'], 
                  'nip_atasan' => $pj['nip'], 
                  'nama_skpd' => $data_sakter['NamaSatker'], 
                  'tanggal_cetak' => $tgl_cetak, 
                  'nama_penyimpan_barang' => $pj['nama2'], 
                  'nip_penyimpan_barang' => $pj['nip2']
              );

            }
            // print_r($identitas_pejabat);
            $TBS->MergeBlock('a', $rekap);
            $TBS->MergeBlock('b', $identitas_pejabat);

            $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
            $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
            $output_file_name = str_replace('.', 'Buku Penerimaan Barang'.$save_as.'.', $template); 
            if ($save_as==='') { 
                $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
                exit(); 
            } 
            else { 
                $TBS->Show(OPENTBS_FILE, $output_file_name);  
                exit("File [$output_file_name] has been created."); 
            } 
        }
        else {
            $this->cetak_header($data,"penerimaan_brg",$kd_lokasi,"","");
            $this->get_query($data,"penerimaan_brg",$kd_lokasi,"",$nm_satker,"");
            $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
            ob_end_clean();
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
        
        $jenis       = $data['jenis'];
        $kd_brg      = $data['kd_brg'];
        $tgl_awal    = $data['tgl_awal'];
        $tgl_akhir   = $data['tgl_akhir'];
        $bulan       = $data['bulan'];
        $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
        $kd_lokasi   = $data['kd_lokasi'].$kd_ruang;
        $thn_ang     = $data['thn_ang'];
        $satker_asal = $data['kd_lokasi'];
        $format      = $data['format'];

        
        
        if($format=="excel") {
            $TBS = new clsTinyButStrong;  
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            $template = '../../utility/optbs/template/buku_pengeluaran_barang.xlsx';
            $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
            $no=1;
            $rekap = array();
            $identitas_pejabat = array();

            // $identitas_pejabat = array();
            $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$satker_asal' ";
            $result_pj = $this->query($query);
            
            $sql="SELECT id, tgl_buku, no_dok, tgl_dok, concat(nm_brg,' ',spesifikasi) as nm_brg, qty, harga_sat,total_harga, tgl_buku, keterangan 
            FROM transaksi_keluar 
            where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'  
            and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'
            AND thn_ang='$thn_ang'
            AND kd_brg!=''
            ORDER BY tgl_dok ASC, no_dok ASC";
            $res = $this->query($sql);
            $sql = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
            $res_satker = $this->query($sql);
            $data_sakter = $this->fetch_array($res_satker);
            $total=0;
            foreach ($res as $value) {
                $total +=  abs($value['total_harga']);
                $rekap[] = array(
                    'no' => $no,
                    'tgl_dok' => $this->konversi_tanggal($value['tgl_dok']),
                    'tgl_buku' => $value['tgl_buku'],
                    'no_dok' => substr($value['no_dok'],14),
                    'nm_brg' => $value['nm_brg'],
                    'qty' => abs($value['qty']),
                    'harga_sat' => abs($value['harga_sat']),
                    'total_harga' => abs($value['total_harga']),
                    'keterangan' => $value['keterangan']
                );
                $no++;
            }
            
            foreach ($result_pj as $pj) {
                $identitas_pejabat[]  = 
                array('nama_atasan' => $pj['nama'], 
                  'nip_atasan' => $pj['nip'], 
                  'nama_skpd' => $data_sakter['NamaSatker'], 
                  'tanggal_cetak' => $tgl_cetak, 
                  'nama_penyimpan_barang' => $pj['nama2'], 
                  'nip_penyimpan_barang' => $pj['nip2'],
                  'grand_total' =>$total
              );

            }
            // print_r($identitas_pejabat);
            $TBS->MergeBlock('a', $rekap);
            $TBS->MergeBlock('b', $identitas_pejabat);

            $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
            $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
            $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template); 
            if ($save_as==='') { 
                $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
                exit(); 
            } 
            else { 
                $TBS->Show(OPENTBS_FILE, $output_file_name);  
                exit("File [$output_file_name] has been created."); 
            } 
        }
        else{
            ob_start(); 
            $this->cetak_header($data,"pengeluaran_brg",$kd_lokasi,"","");
            $this->get_query($data,"pengeluaran_brg",$kd_lokasi,"",$nm_satker,"");
            $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
            
        }

        if($format=="pdf") { 
            $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
            ob_end_clean();
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
        $tgl_cetak = $data['tgl_cetak'];
        $bulan = $data['bulan']; 
        $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
        $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
        $thn_ang = $data['thn_ang'];
        $satker_asal = $data['kd_lokasi'];
        $format = $data['format'];
        
        $this->cetak_header($data,"buku_brg_pakai_habis",$kd_lokasi,"","");
        $this->get_query($data,"buku_brg_pakai_habis",$kd_lokasi,"",$nm_satker,"");       
        $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);

        $html = ob_get_contents(); 
        ob_end_clean();
        if($format=="excel") {

            $TBS = new clsTinyButStrong;  
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            $template = '../../utility/optbs/template/buku_barang_pakai_habis.xlsx';
            $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
            $no=1;
            $rekap = array();
            $identitas_pejabat = array();

            // $identitas_pejabat = array();
            $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$satker_asal' ";
            $result_pj = $this->query($query);
            
            $sql="SELECT id, tgl_buku, no_bukti, tgl_dok, nm_sskel, nm_brg,  spesifikasi, qty,satuan , harga_sat,total_harga, keterangan 
            FROM transaksi_masuk 
            where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
            and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' 
            AND thn_ang='$thn_ang'
            union all
            SELECT id, tgl_buku, no_bukti, tgl_dok, nm_sskel, nm_brg, spesifikasi,  qty,satuan , harga_sat,total_harga, keterangan 
            FROM transaksi_keluar 
            where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
            and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
            AND thn_ang='$thn_ang'

            ORDER BY tgl_dok ASC,id asc, nm_brg asc";
            $res = $this->query($sql);
            $sql = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
            $res_satker = $this->query($sql);
            $data_sakter = $this->fetch_array($res_satker);                

            foreach ($res as $value) {
                if($value['qty']>0){
                    $rekap[] = array(
                        'no' => $no,
                        'tanggal_diterima' => $this->konversi_tanggal($value['tgl_dok']),
                        'nama_barang' => $value['nm_brg'],
                        'merk' => $value['spesifikasi'],
                        'tahun_pembuatan' => '',
                        'jumlah_diterima' => $value['qty'].' '.$value['satuan'],
                        'tanggal_dokumen' => $this->konversi_tanggal($value['tgl_dok']),
                        'tanggal_dan_harga' => $this->konversi_tanggal($value['tgl_dok']).' / Rp. '.number_format($value['harga_sat'],2,",","."),
                        'nomor_bap' => $value['no_bukti'],
                        'tanggal_keluar' => '',
                        'untuk' => '',
                        'jumlah_keluar' => '',
                        'tanggal_penyerahan' => '',
                        'keterangan' => '',

                    );
                }
                else{
                  $rekap[] = array(
                    'no' => $no,
                    'tanggal_diterima' => '',
                    'nama_barang' => $value['nm_brg'],
                    'merk' => $value['spesifikasi'],
                    'tahun_pembuatan' => '',
                    'jumlah_diterima' => '',
                    'tanggal_dokumen' => '',
                    'tanggal_dan_harga' => '',
                    'nomor_bap' => '',
                    'tanggal_keluar' => $this->konversi_tanggal($value['tgl_dok']),
                    'untuk' => $value['keterangan'],
                    'jumlah_keluar' => abs($value['qty']),
                    'tanggal_penyerahan' => $this->konversi_tanggal($value['tgl_dok']).' / '.$value['no_bukti'],
                    'keterangan' => ''
                );

              }
              $no++;
          }

          foreach ($result_pj as $pj) {
            $identitas_pejabat[]  = 
            array('nama_atasan' => $pj['nama'], 
              'nip_atasan' => $pj['nip'], 
              'nama_skpd' => $data_sakter['NamaSatker'], 
              'tanggal_cetak' => $tgl_cetak, 
              'nama_penyimpan_barang' => $pj['nama2'], 
              'nip_penyimpan_barang' => $pj['nip2']
          );

        }
            // print_r($identitas_pejabat);
        $TBS->MergeBlock('a', $rekap);
        $TBS->MergeBlock('b', $identitas_pejabat);

        $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
        $output_file_name = str_replace('.',"Buku Barang pakai Habis".$save_as.'.', $template); 
        if ($save_as==='') { 
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
            exit(); 
        } 
        else { 
            $TBS->Show(OPENTBS_FILE, $output_file_name);  
            exit("File [$output_file_name] has been created."); 
        } 
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
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $satker_asal = $data['satker_asal'];
    $format = $data['format'];
    $tgl_awal = $data['tgl_awal'];
    $tgl_akhir = $data['tgl_akhir'];
    $tgl_cetak = $data['tgl_cetak'];
    $thn_ang = $data['thn_ang'];

    $hasil = $this->query_brg($kd_brg,$kd_lokasi);
    while($kode_brg=$this->fetch_array($hasil)) 
    {
        $this->cetak_header($data,"kartu_brg",$kd_lokasi,$kode_brg['kd_brg'],"");
        $this->get_query($data,"kartu_brg",$kd_lokasi,$kode_brg['kd_brg'],$nm_satker,"");
        $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
        echo '<pagebreak />';
    }

    $html = ob_get_contents(); 
    ob_end_clean();
    if($format=="excel") {


        $TBS = new clsTinyButStrong;  
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
        $template = '../../utility/optbs/template/kartu_barang.xlsx';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
        $no=1;
        $rekap = array();
        $identitas_pejabat = array();
        $detil_barang = array();

            // $identitas_pejabat = array();
        $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$satker_asal' ";
        $result_pj = $this->query($query);

        $sql="SELECT id, tgl_buku, no_bukti, tgl_dok, kd_brg, nm_brg,  spesifikasi, qty,satuan , keterangan 
        FROM transaksi_masuk 
        where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'
        AND kd_brg='$kd_brg'  
        and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' 
        AND thn_ang='$thn_ang'
        union all
        SELECT id, tgl_buku, no_bukti, tgl_dok,kd_brg, nm_brg, spesifikasi,  qty,satuan, keterangan 
        FROM transaksi_keluar 
        where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'
        AND kd_brg='$kd_brg'  
        and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
        AND thn_ang='$thn_ang'

        ORDER BY tgl_dok ASC,id asc, nm_brg asc";
        $res = $this->query($sql);
        $sql = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
        $res_satker = $this->query($sql);
        $data_sakter = $this->fetch_array($res_satker);                

        foreach ($res as $value) {
            if($value['qty']>0){
                $akumulasi_brg+=$value['qty'];
                $rekap[] = array(
                    'no' => $no,
                    'tanggal' => $this->konversi_tanggal($value['tgl_dok']),
                    'jumlah_masuk' => $value['qty'],
                    'jumlah_keluar' => '',
                    'sisa' => $akumulasi_brg,
                    'keterangan' => $value['keterangan'],

                );
            }
            else{
                $akumulasi_brg-=$value['qty'];
                $rekap[] = array(
                    'no' => $no,
                    'tanggal' => $this->konversi_tanggal($value['tgl_dok']),
                    'jumlah_masuk' => '',
                    'jumlah_keluar' => abs($value['qty']),
                    'sisa' => $akumulasi_brg,
                    'keterangan' => $value['keterangan'],

                );

            }
            $no++;
        }

        foreach ($res as $value) {
            $detil_barang[]  = 
            array('nama_brg' => $value['nm_brg'], 
              'spesifikasi_brg' => $value['spesifikasi'], 
              'satuan' => $value['satuan'],
              'kd_brg' => $value['kd_brg']
          );

        }
        foreach ($result_pj as $pj) {
            $identitas_pejabat[]  = 
            array('nama_atasan' => $pj['nama'], 
              'nip_atasan' => $pj['nip'], 
              'nama_skpd' => $data_sakter['NamaSatker'], 
              'tanggal_cetak' => $tgl_cetak, 
              'nama_penyimpan_barang' => $pj['nama2'], 
              'nip_penyimpan_barang' => $pj['nip2']
          );

        }
            // echo "<pre>";
            // print_r($identitas_pejabat);
            // echo "<pre>";
            // print_r($detil_barang);
            // echo "<pre>";
            // print_r($rekap);
        $TBS->MergeBlock('a', $rekap);
        $TBS->MergeBlock('b', $identitas_pejabat);
        $TBS->MergeBlock('c', $detil_barang);

        $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
        $output_file_name = str_replace('.',"Kartu Barang".$save_as.'.', $template); 
        if ($save_as==='') { 
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
            exit(); 
        } 
        else { 
            $TBS->Show(OPENTBS_FILE, $output_file_name);  
            exit("File [$output_file_name] has been created."); 
        } 
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
    $tgl_cetak = $data['tgl_cetak'];
    $bulan = $data['bulan']; 
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $thn_ang = $data['thn_ang'];
    $satker_asal = $data['satker_asal'];

    $hasil = $this->query_brg($kd_brg,$kd_lokasi);
    if($data['format']=="excel"){
        $TBS = new clsTinyButStrong;  
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
        $template = '../../utility/optbs/template/kartu_persediaan_barang.xlsx';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
        $no=1;
        $rekap = array();
        $akumulasi_brg=0;
        $akumulasi_hrg=0;
        $identitas_pejabat = array();
        $detil_barang = array();

            // $identitas_pejabat = array();
        $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$satker_asal' ";
        $result_pj = $this->query($query);

        $sql="SELECT id, tgl_buku, no_bukti, tgl_dok, kd_brg, nm_brg,  spesifikasi, qty,satuan , harga_sat, keterangan 
        FROM transaksi_masuk 
        where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'
        AND kd_brg='$kd_brg'  
        and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' 
        AND thn_ang='$thn_ang'
        union all
        SELECT id, tgl_buku, no_bukti, tgl_dok,kd_brg, nm_brg, spesifikasi,  qty,satuan, harga_sat, keterangan 
        FROM transaksi_keluar 
        where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'
        AND kd_brg='$kd_brg'  
        and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
        AND thn_ang='$thn_ang'

        ORDER BY tgl_dok ASC,id asc, nm_brg asc";
        $res = $this->query($sql);
        $sql = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
        $res_satker = $this->query($sql);
        $data_sakter = $this->fetch_array($res_satker);                

        foreach ($res as $value) {
            if($value['qty']>0){
                $akumulasi_brg+=$value['qty'];
                $akumulasi_hrg+=$value['qty']*$value['harga_sat'];
                $rekap[] = array(
                    'no' => $no,
                    'no_dok' => $value['no_bukti'],
                    'tanggal' => $this->konversi_tanggal($value['tgl_dok']),
                    'harga_sat' => $value['harga_sat'],
                    'jumlah_masuk' => $value['qty'],
                    'jumlah_keluar' => '',
                    'total_harga_masuk' => $value['qty']*$value['harga_sat'],
                    'total_harga_keluar' => '',
                    'sisa' => $akumulasi_brg,
                    'sisa_harga' => $akumulasi_hrg,
                    'keterangan' => $value['keterangan'],

                );
            }
            else{
                $akumulasi_brg-=$value['qty'];
                $akumulasi_hrg-=$value['qty']*$value['harga_sat'];
                $rekap[] = array(
                    'no' => $no,
                    'no_dok' => $value['no_bukti'],
                    'tanggal' => $this->konversi_tanggal($value['tgl_dok']),
                    'harga_sat' => $value['harga_sat'],
                    'jumlah_masuk' => '',
                    'jumlah_keluar' => abs($value['qty']),
                    'total_harga_masuk' => '',
                    'total_harga_keluar' => abs($value['qty'])*$value['harga_sat'],
                    'sisa' => $akumulasi_brg,
                    'sisa_harga' => $akumulasi_hrg,
                    'keterangan' => $value['keterangan'],
                );

            }
            $no++;
        }

        foreach ($res as $value) {
            $detil_barang[]  = 
            array('nama_brg' => $value['nm_brg'], 
              'spesifikasi' => $value['spesifikasi'], 
              'satuan' => $value['satuan'],
              'kd_brg' => $value['kd_brg']
          );

        }
        foreach ($result_pj as $pj) {
            $identitas_pejabat[]  = 
            array('nama_atasan' => $pj['nama'], 
              'nip_atasan' => $pj['nip'], 
              'nama_skpd' => $data_sakter['NamaSatker'], 
              'tanggal_cetak' => $tgl_cetak, 
              'nama_penyimpan_barang' => $pj['nama2'], 
              'nip_penyimpan_barang' => $pj['nip2']
          );

        }
            // echo "<pre>";
            // print_r($identitas_pejabat);
            // echo "<pre>";
            // print_r($detil_barang);
            // echo "<pre>";
            // print_r($rekap);
        $TBS->MergeBlock('a', $rekap);
        $TBS->MergeBlock('b', $identitas_pejabat);
        $TBS->MergeBlock('c', $detil_barang);

        $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
        $output_file_name = str_replace('.',"Kartu Barang".$save_as.'.', $template); 
        if ($save_as==='') { 
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
            exit(); 
        } 
        else { 
            $TBS->Show(OPENTBS_FILE, $output_file_name);  
            exit("File [$output_file_name] has been created."); 
        }
    }
    else{    
        while($kode_brg=$this->fetch_array($hasil)) 
        {
            $this->cetak_header($data,"kartu_p_brg",$kd_lokasi,$kode_brg['kd_brg'],"");
            $this->get_query($data,"kartu_p_brg",$kd_lokasi,$kode_brg['kd_brg'],$nm_satker,"");
            echo '<pagebreak />';  
        }

        $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);

                    $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
                    ob_end_clean();
                    //Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
                    $mpdf->WriteHTML(utf8_encode($html));
                    $mpdf->Output("buku_persediaan.pdf" ,'I');
                    exit;
                }
            }

            public function l_pp_bph($data)
            {



                $jenis = $data['jenis'];
                $thn_ang = $data['thn_ang']; 
                $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
                $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
                $thn_ang = $data['thn_ang'];
                $bln_awal = $data['bln_awal'];
                $bln_akhir = $data['bln_akhir'];
                $tgl_cetak = $data['tgl_cetak'];
                $date = $this->cek_periode($data);
                $satker_asal = $data['satker_asal'];


                if($data['format']=="excel"){
                    $TBS = new clsTinyButStrong;  
                    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
                    $template = '../../utility/optbs/template/laporan_semester_barang_pakai_habis.xlsx';
                    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
                    $no=1;
                    $rekap = array();
                    $identitas_pejabat = array();

            // $identitas_pejabat = array();
                    $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$satker_asal' ";
                    $result_pj = $this->query($query);

                    $sql="SELECT id, tgl_buku, no_bukti, tgl_dok, nm_sskel, concat(nm_brg,' ',spesifikasi) as nm_brg, qty, satuan, untuk, harga_sat,total_harga, keterangan 
                    FROM transaksi_masuk 
                    where month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir'
                    and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
                    AND thn_ang='$thn_ang'
                    union all
                    SELECT id, tgl_buku, no_bukti, tgl_dok, nm_sskel, concat(nm_brg,' ',spesifikasi) as nm_brg,  qty, satuan, untuk, harga_sat,total_harga, keterangan 
                    FROM transaksi_keluar 
                    where month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir'
                    and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
                    AND thn_ang='$thn_ang'

                    ORDER BY tgl_dok ASC,id asc, nm_brg asc;";
                    $res = $this->query($sql);
                    $sql2 = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
                    $res_satker = $this->query($sql2);
                    $data_sakter = $this->fetch_array($res_satker);                


                    foreach ($res as $value) {
                        if($value['qty']>0){
                            $rekap[] = array(
                                'no_masuk' => $no,
                                'no_keluar' => '',
                                'tanggal_diterima' => $this->konversi_tanggal($value['tgl_dok']),
                                'nama_barang' => $value['nm_brg'],
                                'no_bap' => $value['no_bukti'],
                                'jumlah_diterima' => $value['qty'].' '.$value['satuan'],
                                'tanggal_dokumen' => $this->konversi_tanggal($value['tgl_dok']),
                                'harga_satuan_masuk' => number_format($value['harga_sat'],2,",","."),
                                'harga_satuan_keluar' => '',
                                'no_bon' => '',
                                'tanggal_bon' => '',
                                'tanggal_keluar' => '',
                                'untuk' => '',
                                'jumlah_keluar' => '',
                                'jumlah_harga_masuk' => number_format(abs($value['harga_sat']),2,",","."),
                                'jumlah_harga_keluar' => '',
                                'dari' => $value['keterangan'],
                                'untuk' => '',

                            );
                        }
                        else{
                          $rekap[] = array(
                            'no_masuk' => '',
                            'no_keluar' => $no,
                            'tanggal_diterima' => '',
                            'nama_barang' => $value['nm_brg'],
                            'no_bap' => '',
                            'jumlah_diterima' => '',
                            'tanggal_dokumen' => '',
                            'harga_satuan_masuk' => '',
                            'harga_satuan_keluar' => number_format(abs($value['harga_sat']),2,",","."),
                            'no_bon' => '',
                            'tanggal_bon' => $this->konversi_tanggal($value['tgl_dok']),
                            'tanggal_keluar' => $this->konversi_tanggal($value['tgl_dok']),
                            'untuk' => $value['keterangan'],
                            'jumlah_keluar' => abs($value['qty']),
                            'jumlah_harga_masuk' => '',
                            'jumlah_harga_keluar' => number_format(abs($value['harga_sat']),2,",","."),
                            'dari' => '',
                            'untuk' => $value['keterangan'],
                        );

                      }
                      $no++;
                  }

                  foreach ($result_pj as $pj) {
                    $identitas_pejabat[]  = 
                    array('nama_atasan' => $pj['nama'], 
                      'nip_atasan' => $pj['nip'], 
                      'nama_skpd' => $data_sakter['NamaSatker'], 
                      'tanggal_cetak' => $tgl_cetak, 
                      'nama_penyimpan_barang' => $pj['nama2'], 
                      'nip_penyimpan_barang' => $pj['nip2']
                  );

                }
            // echo "<pre>";
            // print_r($rekap);
                $TBS->MergeBlock('a', $rekap);
                $TBS->MergeBlock('b', $identitas_pejabat);

                $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
                $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
                $output_file_name = "Laporan Semester Barang pakai Habis.xlsx"; 
                if ($save_as==='') { 
                    $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
                    exit(); 
                } 
                else { 
                    $TBS->Show(OPENTBS_FILE, $output_file_name);  
                    exit("File [$output_file_name] has been created."); 
                } 

            }
            else{          
                ob_start(); 
                $this->cetak_header($data,"pp_brg_pakai_habis",$kd_lokasi,"","");
                $this->get_query($data,"pp_brg_pakai_habis",$kd_lokasi,"",$nm_satker,"");
                $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
                $mpdf=new mPDF('utf-8', 'A4-L');
            $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
            ob_end_clean(); 
            $mpdf->WriteHTML(utf8_encode($html));
            $mpdf->Output("pp_bph.pdf" ,'I');
            exit;
        }

    }



    public function ba_opname_group($data){
        $smt                 ="";
        $jenis               = $data['format'];
        $thn_ang             = $data['thn_ang']; 
        $kd_ruang            = str_replace(" ", "", $data['kd_ruang']);
        $kd_lokasi           = $data['kd_lokasi'].$kd_ruang;
        $bln_awal            = $data['bln_awal'];
        $bln_akhir           = $data['bln_akhir'];
        $tgl_akhir           = $data['tgl_akhir'];
        $tgl_cetak           = $data['tgl_cetak'];
        $date                = $this->cek_periode($data);
        $satker_asal         = $data['satker_asal'];
        $baca_ruang          ="";
        $prev_sskel          ="";
        $subtotal_masuk      = 0;
        $subtotal_keluar     = 0;
        $subtotal_saldo_awal = 0;
        $subtotal_sisa       = 0;
        $semester            = array();
        $rekap               = array();
        // if($_SESSION['kd_ruang']!=''){
        //     $kode_bagian=$_SESSION['kd_ruang'];
        //     $baca_ruang=" and kd_ruang='$kode_bagian' ";
        // }
        $query = "SELECT kd_perk, nm_perk, satuan, harga_sat, concat(nm_brg,' ',IFNULL(spesifikasi,'')) as nm_brg,jns_trans, 
        sum(qty) qty, sum(qty_akhir) qty_akhir 
        FROM transaksi_masuk 
        WHERE 
        concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$kd_lokasi'  AND 
        thn_ang='$thn_ang' AND 
        tgl_dok <= '$tgl_akhir' AND
        IFNULL(kd_brg,'')!=''
        GROUP BY kd_brg, jns_trans 
        ORDER BY kd_perk asc, nm_brg asc, jns_trans asc";
                    // echo $query;
        $result = $this->query($query);
        $query = "SELECT * from ttd where kd_lokasi='$kd_lokasi' ".$baca_ruang;

        $result_pj = $this->query($query);
                    // echo $query;
        // if($data['semester']=="06"){ 
        //     $smt="I"; 
        //     $semester[]= array('semester' =>$smt);
        // } 
        // else{ 
        //     $smt="II";
        //     $semester[]= array('semester' =>$smt); 
        // }
        $semester[]= array('tanggal' =>$data['tgl_rekap']);
        $grandTotal_saldoAwal   = 0;
        $grandTotal_penerimaan  = 0;
        $grandTotal_pengeluaran = 0;
        $grandTotal_sisa        = 0;
        $no=1;
        foreach ($result as $value) {
           if($prev_sskel!=$value['nm_perk']){
            if($no>1){
                $rekap[] = array(
                    'subtotal_saldo_awal' => $subtotal_saldo_awal,
                    'subtotal_masuk'      => $subtotal_masuk,
                    'subtotal_keluar'     => $subtotal_keluar,
                    'subtotal_sisa'       => $subtotal_sisa,
                    'cetak_subtotal'      => 1,
                    'cetak_header'        => 2,
                    'jumlah_saldo_awal'   => 2,
                    'jumlah_diterima'     => 2,
                    'counter'             => ""
                );
                $subtotal_saldo_awal = 0;
                $subtotal_keluar    = 0;
                $subtotal_masuk  = 0;
                $subtotal_sisa    = 0;

            }

            $rekap[] = array(
                'jenis_barang'            => $value['nm_perk'],
                'cetak_header'            => 1,
                'cetak_subtotal'          => 0,
                'counter'                 => ""
            );
            if($value[jns_trans]=="M01"){
                $grandTotal_saldoAwal = $grandTotal_saldoAwal + ($value[qty]*$value[harga_sat]);
                $grandTotal_pengeluaran  = $grandTotal_pengeluaran + (($value[qty]-$value[qty_akhir])*$value[harga_sat]);
                $rekap[] = array(
                    'no'                      => $no,                        
                    'jns_trans'               => $value[jns_trans],
                    'nm_brg'                  => $value['nm_brg'],
                    'kd_brg'                  => $value['kd_brg'],
                    'jenis_barang'            => $value['nm_perk'],
                    'satuan'                  => $value['satuan'],
                    'jumlah_saldo_awal'       => $value[qty],
                    'qty'                     => $value[qty],
                    'jumlah_diterima'         => 0,
                    'jumlah_keluar'           => $value[qty]-$value[qty_akhir],
                    'sisa_barang'             => $value[qty_akhir],
                    'counter'                 => "",
                    'harga_satuan_saldo_awal' => $value[harga_sat],
                    'harga_satuan'            => $value[harga_sat],
                    'harga_satuan_masuk'      => 0,
                    'harga_satuan_keluar'     => $value[harga_sat],

                    'total_harga_saldo_awal'  => $value[qty]*$value[harga_sat],
                    'total_harga'             => $value[qty]*$value[harga_sat],
                    'total_harga_masuk'       => 0,
                    'total_harga_keluar'      => ($value[qty]-$value[qty_akhir])*$value[harga_sat],
                    'total_harga_sisa'        => $value[qty_akhir]*$value[harga_sat],
                    'cetak_header'            => 0
                );
                $subtotal_saldo_awal    += $value[qty]*$value[harga_sat];
                $subtotal_keluar        += ($value[qty]-$value[qty_akhir])*$value[harga_sat];

            }
            else{
                $grandTotal_penerimaan  = $grandTotal_penerimaan + ($value[qty]*$value[harga_sat]);
                $grandTotal_pengeluaran  = $grandTotal_pengeluaran + (($value[qty]-$value[qty_akhir])*$value[harga_sat]);
                $rekap[] = array(
                    'no'                      => $no,
                    'jns_trans'               => $value[jns_trans],
                    'nm_brg'                  => $value['nm_brg'],
                    'kd_brg'                  => $value['kd_brg'],
                    'jenis_barang'            => $value['nm_perk'],
                    'satuan'                  => $value['satuan'],
                    'jumlah_saldo_awal'       => 0,
                    'jumlah_diterima'         => $value[qty],                        
                    'qty'                     => $value[qty],
                    'jumlah_keluar'           => $value[qty]-$value[qty_akhir],
                    'sisa_barang'             => $value[qty_akhir],
                    'counter'                 => "",
                    'harga_satuan_saldo_awal' => 0,
                    'harga_satuan_masuk'      => $value[harga_sat],
                    'harga_satuan'            => $value[harga_sat],
                    'harga_satuan_keluar'     => $value[harga_sat],

                    'total_harga_saldo_awal'  => 0,
                    'total_harga_masuk'       => $value[qty]*$value[harga_sat],
                    'total_harga'             => $value[qty]*$value[harga_sat],
                    'total_harga_keluar'      => ($value[qty]-$value[qty_akhir])*$value[harga_sat],
                    'total_harga_sisa'        => $value[qty_akhir]*$value[harga_sat],
                    'cetak_header'            => 0
                );
                $subtotal_masuk += $value[qty]*$value[harga_sat];
                $subtotal_keluar += ($value[qty]-$value[qty_akhir])*$value[harga_sat];
                $subtotal_sisa += $value[qty_akhir]*$value[harga_sat];
            }
            $prev_sskel=$value['nm_perk'];
        }
        elseif($value[jns_trans]=="M01"){
            $grandTotal_saldoAwal = $grandTotal_saldoAwal + ($value[qty]*$value[harga_sat]);
            $grandTotal_pengeluaran  = $grandTotal_pengeluaran + (($value[qty]-$value[qty_akhir])*$value[harga_sat]);
            $rekap[] = array(
                'no'                      => $no,                        
                'jns_trans'               => $value[jns_trans],
                'nm_brg'                  => $value['nm_brg'],
                'kd_brg'                  => $value['kd_brg'],
                'jenis_barang'            => $value['nm_perk'],
                'satuan'                  => $value['satuan'],
                'jumlah_saldo_awal'       => $value[qty],                        
                'qty'                     => $value[qty],
                'jumlah_diterima'         => 0,
                'jumlah_keluar'           => $value[qty]-$value[qty_akhir],
                'sisa_barang'             => $value[qty_akhir],
                'counter'                 => "",
                'harga_satuan_saldo_awal' => $value[harga_sat],
                'harga_satuan'            => $value[harga_sat],
                'harga_satuan_masuk'      => 0,
                'harga_satuan_keluar'     => $value[harga_sat],

                'total_harga_saldo_awal'  => $value[qty]*$value[harga_sat],
                'total_harga'             => $value[qty]*$value[harga_sat],
                'total_harga_masuk'       => 0,
                'total_harga_keluar'      => ($value[qty]-$value[qty_akhir])*$value[harga_sat],
                'total_harga_sisa'        => $value[qty_akhir]*$value[harga_sat],
                'cetak_header'            => 0
            );
            $subtotal_saldo_awal    += $value[qty]*$value[harga_sat];
            $subtotal_keluar        += ($value[qty]-$value[qty_akhir])*$value[harga_sat];
            $subtotal_sisa          += $value[qty_akhir]*$value[harga_sat];

        }
        else{
           $grandTotal_penerimaan   = $grandTotal_penerimaan + ($value[qty]*$value[harga_sat]);
           $grandTotal_pengeluaran  = $grandTotal_pengeluaran + (($value[qty]-$value[qty_akhir])*$value[harga_sat]);
           $rekap[] = array(
            'no'                      => $no,
            'jns_trans'               => $value[jns_trans],
            'nm_brg'                  => $value['nm_brg'],
            'kd_brg'                  => $value['kd_brg'],
            'jenis_barang'            => $value['nm_perk'],
            'satuan'                  => $value['satuan'],
            'qty'                     => $value[qty],
            'jumlah_saldo_awal'       => 0,
            'jumlah_diterima'         => $value[qty],
            'jumlah_keluar'           => $value[qty]-$value[qty_akhir],
            'sisa_barang'             => $value[qty_akhir],
            'counter'                 => "",
            'harga_satuan_saldo_awal' => 0,
            'harga_satuan_masuk'      => $value[harga_sat],
            'harga_satuan'      => $value[harga_sat],
            'harga_satuan_keluar'     => $value[harga_sat],

            'total_harga_saldo_awal'  => 0,
            'total_harga_masuk'       => $value[qty]*$value[harga_sat],
            'total_harga'             => $value[qty]*$value[harga_sat],
            'total_harga_keluar'      => ($value[qty]-$value[qty_akhir])*$value[harga_sat],
            'total_harga_sisa'        => $value[qty_akhir]*$value[harga_sat],
            'cetak_header'            => 0
        );
           $subtotal_masuk   += $value[qty]*$value[harga_sat];
           $subtotal_keluar += ($value[qty]-$value[qty_akhir])*
           $value[harga_sat];
           $subtotal_sisa   += $value[qty_akhir]*$value[harga_sat];

       }
       $no++;
   }

   $grandTotal_sisa =  $grandTotal_saldoAwal  + 
   $grandTotal_penerimaan - 
   $grandTotal_pengeluaran;
   $rekap[] = array(
    'subtotal_saldo_awal' => $subtotal_saldo_awal,
    'subtotal_masuk'      => $subtotal_masuk,
    'subtotal_keluar'     => $subtotal_keluar,
    'subtotal_sisa'       => $subtotal_sisa,
    'cetak_subtotal'      => 1,
    'cetak_header'        => 2,
    'jumlah_saldo_awal'   => 2,
    'jumlah_diterima'     => 2,
    'counter'             => ""
);
   $grandTotal[]=array(
    'grandTotal_saldoAwal' => $grandTotal_saldoAwal,
    'grandTotal_penerimaan' => $grandTotal_penerimaan,
    'grandTotal_pengeluaran' => $grandTotal_pengeluaran,
    'grandTotal_sisa' => $grandTotal_sisa
);
            // echo "<pre>";
            // print_r($rekap);
            // exit;
   if($jenis=="excel"){
    $TBS = new clsTinyButStrong;  
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
    $template = '../../utility/optbs/template/berita_acara_stock_opname_group.xlsx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
    $no=1;
    $identitas_pejabat = array();


    $sql = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
    $res_satker = $this->query($sql);
    $data_sakter = $this->fetch_array($res_satker);


    foreach ($result_pj as $pj) {
        $identitas_pejabat[]  = 
        array('nama_atasan' => $pj['nama'], 
          'nip_atasan' => $pj['nip'], 
          'nama_skpd' => $data_sakter['NamaSatker'], 
          'tanggal_cetak' => $tgl_cetak, 
          'nama_penyimpan_barang' => $pj['nama2'], 
          'nip_penyimpan_barang' => $pj['nip2']
      );

    }

    $TBS->MergeBlock('a', $rekap);
    $TBS->MergeBlock('b', $identitas_pejabat);
    $TBS->MergeBlock('c', $semester);
    $TBS->MergeBlock('d', $grandTotal);

    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
    $output_file_name = "berita_acara_stock_opname_group.xlsx"; 
    if ($save_as==='') { 
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
        exit(); 
    } 
    else { 
        $TBS->Show(OPENTBS_FILE, $output_file_name);  
        exit("File [$output_file_name] has been created."); 
    } 
}
else{


    ob_start();
        // echo "<pre>";
        // print_r($rekap);
    $this->getupb($kd_lokasi);
    echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:1em; "  align="center">
    <tr>
    <td rowspan="3" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
    <td style= "vertical-align: bottom;">LAMPIRAN BERITA ACARA</td>

    </tr>
    <tr>
    <td style= "vertical-align: bottom;">STOK OPNAME PERSEDIAAN</td>
    </tr>
    <tr>
    <td style= "vertical-align: bottom;">PER TANGGAL : '.$data['tgl_rekap'].'</td>
    </tr>

    </table>
    <p></p>
    ';   
    echo '<table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:0.75em;" border=1 >
    <tr>
    <th align="center">NO</th>
    <th width="23%">JENIS BARANG</th>
    <th>SATUAN</th>
    <th>SALDO AWAL</th>
    <th>JUMLAH PENERIMAAN/<br></br>PENGADAAN BARANG</th>
    <th>JUMLAH PENGELUARAN BARANG</th>
    <th>SALDO AKHIR / SISA</th>
    </tr>
    ';
    foreach ($rekap as $key => $value) {
        if($value['cetak_header']==1){
            echo "<tr>
            <td colspan='7' style='text-align:left; font-weight:bold'>$value[jenis_barang]</td>
            </tr>";

        }
        elseif ($value['cetak_subtotal']==1) {
                // echo '<tr>
                //         <td colspan=5>TOTAL</td>
                //         <td style"text-align:right">'.number_format($value[subtotal_saldo_awal],2,",",".").'</td>
                //         <td colspan=2></td>
                //         <td style"text-align:right">'.number_format($value[subtotal_masuk],2,",",".").'</td>
                //          <td colspan=2></td>
                //         <td style"text-align:right">'.number_format($value[subtotal_keluar],2,",",".").'</td>
                //          <td colspan=2></td>
                //         <td style"text-align:right">'.number_format($value[subtotal_sisa],2,",",".").'</td>
                //         </tr>';
        }
        else{
            echo "<tr>
            <td>$value[no]</td>
            <td style='text-align:left'>$value[nm_brg]</td>
            <td>$value[satuan]</td>
            <td>$value[jumlah_saldo_awal]</td>                        
            <td>".number_format($value[jumlah_diterima],2,",",".")."</td>                        
            <td>".number_format($value[jumlah_keluar],2,",",".")."</td>                        
            <td>".number_format($value[sisa_barang],2,",",".")."</td> 
            </tr>";
        }

    }
        // echo '<tr>
        //                 <td colspan=5>GRAND TOTAL</td>
        //                 <td style"text-align:right">'.number_format($grandTotal[0][grandTotal_saldoAwal],2,",",".").'</td>
        //                 <td colspan=2></td>
        //                 <td style"text-align:right">'.number_format($grandTotal[0][grandTotal_penerimaan],2,",",".").'</td>
        //                  <td colspan=2></td>
        //                 <td style"text-align:right">'.number_format($grandTotal[0][grandTotal_pengeluaran],2,",",".").'</td>
        //                  <td colspan=2></td>
        //                 <td style"text-align:right">'.number_format($grandTotal[0][grandTotal_sisa],2,",",".").'</td>
        //                 </tr>';
    echo '</table>';
    $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
          // exit;
    $mpdf=new mPDF('utf-8', 'A4');
    $html = ob_get_contents();
    ob_end_clean(); 
    $mpdf->WriteHTML(utf8_encode($html));
    $mpdf->Output("BA_OPNAME" ,'I');
    exit;

}
}

public function ba_opname($data){
    $smt="";
    $jenis = $data['format'];
    $thn_ang = $data['thn_ang']; 
    $kd_ruang = str_replace(" ", "", $data['kd_ruang']);
    $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $bln_awal = $data['bln_awal'];
    $bln_akhir = $data['bln_akhir'];
    $tgl_akhir = $data['tgl_akhir'];
    $tgl_cetak = $data['tgl_cetak'];
    $date = $this->cek_periode($data);
    $satker_asal = $data['satker_asal'];
    $baca_ruang="";
    $prev_sskel="";
    $subtotal_masuk = 0;
    $subtotal_keluar = 0;
    $subtotal_saldo_awal = 0;
    $subtotal_sisa = 0;
    $semester = array();
    $rekap = array();
        // if($_SESSION['kd_ruang']!=''){
        //     $kode_bagian=$_SESSION['kd_ruang'];
        //     $baca_ruang=" and kd_ruang='$kode_bagian' ";
        // }
    $query = "SELECT kd_brg, kd_perk, nm_perk, satuan, harga_sat, concat(nm_brg,' ',IFNULL(spesifikasi,'')) as nm_brg,jns_trans, 
    qty, qty_akhir 
    from transaksi_masuk 
    where 
    concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$kd_lokasi'  AND 
    thn_ang='$thn_ang' AND 
    tgl_dok <= '$tgl_akhir' AND
    IFNULL(kd_brg,'')!=''
    order BY kd_perk asc, nm_brg asc, jns_trans asc";
                    // echo $query;
    $result = $this->query($query);
    $query = "SELECT * from ttd where kd_lokasi='$kd_lokasi' ".$baca_ruang;

    $result_pj = $this->query($query);
                    // echo $query;
        // if($data['semester']=="06"){ 
        //     $smt="I"; 
        //     $semester[]= array('semester' =>$smt);
        // } 
        // else{ 
        //     $smt="II";
        //     $semester[]= array('semester' =>$smt); 
        // }

    $semester[]= array('tanggal' =>$data['tgl_rekap']); 
    $grandTotal_saldoAwal   = 0;
    $grandTotal_penerimaan  = 0;
    $grandTotal_pengeluaran = 0;
    $grandTotal_sisa        = 0;
    $no=1;
    foreach ($result as $value) {
       if($prev_sskel!=$value['kd_perk']){
        if($no>1){
            $rekap[] = array(
                'subtotal_saldo_awal' => $subtotal_saldo_awal,
                'subtotal_masuk'      => $subtotal_masuk,
                'subtotal_keluar'     => $subtotal_keluar,
                'subtotal_sisa'       => $subtotal_sisa,
                'cetak_subtotal'      => 1,
                'cetak_header'        => 2,
                'jumlah_saldo_awal'   => 2,
                'jumlah_diterima'     => 2,
                'counter'             => ""
            );
            $subtotal_saldo_awal = 0;
            $subtotal_keluar    = 0;
            $subtotal_masuk  = 0;
            $subtotal_sisa    = 0;

        }

        $rekap[] = array(
            'jenis_barang'            => $value['nm_perk'],
            'cetak_header'            => 1,
            'cetak_subtotal'          => 0,
            'counter'                 => ""
        );
        if($value[jns_trans]=="M01"){
            $grandTotal_saldoAwal = $grandTotal_saldoAwal + ($value[qty]*$value[harga_sat]);
            $grandTotal_pengeluaran  = $grandTotal_pengeluaran + (($value[qty]-$value[qty_akhir])*$value[harga_sat]);
            $rekap[] = array(
                'no'                      => $no,                        
                'jns_trans'               => $value[jns_trans],
                'nm_brg'                  => $value['nm_brg'],
                'kd_brg'                  => $value['kd_brg'],
                'jenis_barang'            => $value['nm_perk'],
                'satuan'                  => $value['satuan'],
                'jumlah_saldo_awal'       => $value[qty],
                'qty'                     => $value[qty],
                'jumlah_diterima'         => 0,
                'jumlah_keluar'           => $value[qty]-$value[qty_akhir],
                'sisa_barang'             => $value[qty_akhir],
                'counter'                 => "",
                'harga_satuan_saldo_awal' => $value[harga_sat],
                'harga_satuan'            => $value[harga_sat],
                'harga_satuan_masuk'      => 0,
                'harga_satuan_keluar'     => $value[harga_sat],

                'total_harga_saldo_awal'  => $value[qty]*$value[harga_sat],
                'total_harga'             => $value[qty]*$value[harga_sat],
                'total_harga_masuk'       => 0,
                'total_harga_keluar'      => ($value[qty]-$value[qty_akhir])*$value[harga_sat],
                'total_harga_sisa'        => $value[qty_akhir]*$value[harga_sat],
                'cetak_header'            => 0
            );
            $subtotal_saldo_awal    += $value[qty]*$value[harga_sat];
            $subtotal_keluar        += ($value[qty]-$value[qty_akhir])*$value[harga_sat];

        }
        else{
            $grandTotal_penerimaan  = $grandTotal_penerimaan + ($value[qty]*$value[harga_sat]);
            $grandTotal_pengeluaran  = $grandTotal_pengeluaran + (($value[qty]-$value[qty_akhir])*$value[harga_sat]);
            $rekap[] = array(
                'no'                      => $no,
                'jns_trans'               => $value[jns_trans],
                'nm_brg'                  => $value['nm_brg'],
                'kd_brg'                  => $value['kd_brg'],
                'jenis_barang'            => $value['nm_perk'],
                'satuan'                  => $value['satuan'],
                'jumlah_saldo_awal'       => 0,
                'jumlah_diterima'         => $value[qty],                        
                'qty'                     => $value[qty],
                'jumlah_keluar'           => $value[qty]-$value[qty_akhir],
                'sisa_barang'             => $value[qty_akhir],
                'counter'                 => "",
                'harga_satuan_saldo_awal' => 0,
                'harga_satuan_masuk'      => $value[harga_sat],
                'harga_satuan'            => $value[harga_sat],
                'harga_satuan_keluar'     => $value[harga_sat],

                'total_harga_saldo_awal'  => 0,
                'total_harga_masuk'       => $value[qty]*$value[harga_sat],
                'total_harga'             => $value[qty]*$value[harga_sat],
                'total_harga_keluar'      => ($value[qty]-$value[qty_akhir])*$value[harga_sat],
                'total_harga_sisa'        => $value[qty_akhir]*$value[harga_sat],
                'cetak_header'            => 0
            );
            $subtotal_masuk += $value[qty]*$value[harga_sat];
            $subtotal_keluar += ($value[qty]-$value[qty_akhir])*$value[harga_sat];
            $subtotal_sisa += $value[qty_akhir]*$value[harga_sat];
        }
        $prev_sskel=$value['kd_perk'];
    }
    elseif($value[jns_trans]=="M01"){
        $grandTotal_saldoAwal = $grandTotal_saldoAwal + ($value[qty]*$value[harga_sat]);
        $grandTotal_pengeluaran  = $grandTotal_pengeluaran + (($value[qty]-$value[qty_akhir])*$value[harga_sat]);
        $rekap[] = array(
            'no'                      => $no,                        
            'jns_trans'               => $value[jns_trans],
            'nm_brg'                  => $value['nm_brg'],
            'kd_brg'                  => $value['kd_brg'],
            'jenis_barang'            => $value['nm_perk'],
            'satuan'                  => $value['satuan'],
            'jumlah_saldo_awal'       => $value[qty],                        
            'qty'                     => $value[qty],
            'jumlah_diterima'         => 0,
            'jumlah_keluar'           => $value[qty]-$value[qty_akhir],
            'sisa_barang'             => $value[qty_akhir],
            'counter'                 => "",
            'harga_satuan_saldo_awal' => $value[harga_sat],
            'harga_satuan'            => $value[harga_sat],
            'harga_satuan_masuk'      => 0,
            'harga_satuan_keluar'     => $value[harga_sat],

            'total_harga_saldo_awal'  => $value[qty]*$value[harga_sat],
            'total_harga'             => $value[qty]*$value[harga_sat],
            'total_harga_masuk'       => 0,
            'total_harga_keluar'      => ($value[qty]-$value[qty_akhir])*$value[harga_sat],
            'total_harga_sisa'        => $value[qty_akhir]*$value[harga_sat],
            'cetak_header'            => 0
        );
        $subtotal_saldo_awal    += $value[qty]*$value[harga_sat];
        $subtotal_keluar        += ($value[qty]-$value[qty_akhir])*$value[harga_sat];
        $subtotal_sisa          += $value[qty_akhir]*$value[harga_sat];

    }
    else{
       $grandTotal_penerimaan   = $grandTotal_penerimaan + ($value[qty]*$value[harga_sat]);
       $grandTotal_pengeluaran  = $grandTotal_pengeluaran + (($value[qty]-$value[qty_akhir])*$value[harga_sat]);
       $rekap[] = array(
        'no'                      => $no,
        'jns_trans'               => $value[jns_trans],
        'nm_brg'                  => $value['nm_brg'],
        'kd_brg'                  => $value['kd_brg'],
        'jenis_barang'            => $value['nm_perk'],
        'satuan'                  => $value['satuan'],
        'qty'                     => $value[qty],
        'jumlah_saldo_awal'       => 0,
        'jumlah_diterima'         => $value[qty],
        'jumlah_keluar'           => $value[qty]-$value[qty_akhir],
        'sisa_barang'             => $value[qty_akhir],
        'counter'                 => "",
        'harga_satuan_saldo_awal' => 0,
        'harga_satuan_masuk'      => $value[harga_sat],
        'harga_satuan'      => $value[harga_sat],
        'harga_satuan_keluar'     => $value[harga_sat],

        'total_harga_saldo_awal'  => 0,
        'total_harga_masuk'       => $value[qty]*$value[harga_sat],
        'total_harga'             => $value[qty]*$value[harga_sat],
        'total_harga_keluar'      => ($value[qty]-$value[qty_akhir])*$value[harga_sat],
        'total_harga_sisa'        => $value[qty_akhir]*$value[harga_sat],
        'cetak_header'            => 0
    );
       $subtotal_masuk   += $value[qty]*$value[harga_sat];
       $subtotal_keluar += ($value[qty]-$value[qty_akhir])*
       $value[harga_sat];
       $subtotal_sisa   += $value[qty_akhir]*$value[harga_sat];

   }
   $no++;
}

$grandTotal_sisa =  $grandTotal_saldoAwal  + 
$grandTotal_penerimaan - 
$grandTotal_pengeluaran;
$rekap[] = array(
    'subtotal_saldo_awal' => $subtotal_saldo_awal,
    'subtotal_masuk'      => $subtotal_masuk,
    'subtotal_keluar'     => $subtotal_keluar,
    'subtotal_sisa'       => $subtotal_sisa,
    'cetak_subtotal'      => 1,
    'cetak_header'        => 2,
    'jumlah_saldo_awal'   => 2,
    'jumlah_diterima'     => 2,
    'counter'             => ""
);
$grandTotal[]=array(
    'grandTotal_saldoAwal' => $grandTotal_saldoAwal,
    'grandTotal_penerimaan' => $grandTotal_penerimaan,
    'grandTotal_pengeluaran' => $grandTotal_pengeluaran,
    'grandTotal_sisa' => $grandTotal_sisa
);
            // echo "<pre>";
            // print_r($rekap);
            // exit;
if($jenis=="excel"){
    $TBS = new clsTinyButStrong;  
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
    $template = '../../utility/optbs/template/berita_acara_stock_opname.xlsx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
    $no=1;
    $identitas_pejabat = array();


    $sql = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
    $res_satker = $this->query($sql);
    $data_sakter = $this->fetch_array($res_satker);


    foreach ($result_pj as $pj) {
        $identitas_pejabat[]  = 
        array('nama_atasan' => $pj['nama'], 
          'nip_atasan' => $pj['nip'], 
          'nama_skpd' => $data_sakter['NamaSatker'], 
          'tanggal_cetak' => $tgl_cetak, 
          'nama_penyimpan_barang' => $pj['nama2'], 
          'nip_penyimpan_barang' => $pj['nip2']
      );

    }

    $TBS->MergeBlock('a', $rekap);
    $TBS->MergeBlock('b', $identitas_pejabat);
    $TBS->MergeBlock('c', $semester);
    $TBS->MergeBlock('d', $grandTotal);

    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : ''; 
    $output_file_name = "berita_acara_stock_opname.xlsx"; 
    if ($save_as==='') { 
        $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
        exit(); 
    } 
    else { 
        $TBS->Show(OPENTBS_FILE, $output_file_name);  
        exit("File [$output_file_name] has been created."); 
    } 
}
else{


    ob_start();
        // echo "<pre>";
        // print_r($rekap);
    $this->getupb($kd_lokasi);
    echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.9em; "  align="center">
    <tr>
    <td rowspan="3" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
    <td style= "vertical-align: bottom;">LAMPIRAN BERITA ACARA</td>

    </tr>
    <tr>
    <td style= "vertical-align: bottom;">STOK OPNAME PERSEDIAAN</td>
    </tr>
    <tr>
    <td style= "vertical-align: bottom;">PER TANGGAL : '.$data['tgl_rekap'].'</td>
    </tr>

    </table>
    <p></p>
    ';   
    echo '<table style="text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border=1 >
    <tr>
    <th rowspan="2" align="center">NO</th>
    <th rowspan="2" width="23%">JENIS BARANG</th>
    <th rowspan="2">SATUAN</th>
    <th colspan="3">SALDO AWAL</th>
    <th colspan="3">JUMLAH PENERIMAAN/PENGADAAN BARANG</th>
    <th colspan="3">JUMLAH PENGELUARAN BARANG</th>
    <th colspan="3">SALDO AKHIR / SISA</th>
    </tr>
    <tr>
    <td>Banyaknya</td>
    <td>Harga Satuan</td>
    <td>Jumlah Harga</td>
    <td>Banyaknya</td>
    <td>Harga Satuan</td>
    <td>Jumlah Harga</td>
    <td>Banyaknya</td>
    <td>Harga Satuan</td>
    <td>Jumlah Harga</td>
    <td>Banyaknya</td>
    <td>Harga Satuan</td>
    <td>Jumlah Harga</td>
    </tr>
    ';
    foreach ($rekap as $key => $value) {
        if($value['cetak_header']==1){
            echo "<tr>
            <td colspan='15' style='text-align:left; font-weight:bold'>$value[jenis_barang]</td>
            </tr>";

        }
        elseif ($value['cetak_subtotal']==1) {
            echo '<tr>
            <td colspan=5>TOTAL</td>
            <td style"text-align:right">'.number_format($value[subtotal_saldo_awal],2,",",".").'</td>
            <td colspan=2></td>
            <td style"text-align:right">'.number_format($value[subtotal_masuk],2,",",".").'</td>
            <td colspan=2></td>
            <td style"text-align:right">'.number_format($value[subtotal_keluar],2,",",".").'</td>
            <td colspan=2></td>
            <td style"text-align:right">'.number_format($value[subtotal_sisa],2,",",".").'</td>
            </tr>';
        }
        else{
            echo "<tr>
            <td>$value[no]</td>
            <td style='text-align:left'>$value[nm_brg]</td>
            <td>$value[satuan]</td>
            <td>$value[jumlah_saldo_awal]</td>
            <td style='text-align:right'>".number_format($value[harga_satuan_saldo_awal],2,",",".")."</td>
            <td style='text-align:right'>".number_format($value[total_harga_saldo_awal],2,",",".")."</td>
            <td>".number_format($value[jumlah_diterima],2,",",".")."</td>
            <td style='text-align:right'>".number_format($value[harga_satuan_masuk],2,",",".")."</td>
            <td style='text-align:right'>".number_format($value[total_harga_masuk],2,",",".")."</td>
            <td>".number_format($value[jumlah_keluar],2,",",".")."</td>
            <td style='text-align:right'>".number_format($value[harga_satuan_keluar],2,",",".")."</td>
            <td style='text-align:right'>".number_format($value[total_harga_keluar],2,",",".")."</td>
            <td>".number_format($value[sisa_barang],2,",",".")."</td>
            <td style='text-align:right'>".number_format($value[harga_satuan],2,",",".")."</td>
            <td style='text-align:right'>".number_format($value[total_harga_sisa],2,",",".")."</td>
            </tr>";
        }

    }
    echo '<tr>
    <td colspan=5>GRAND TOTAL</td>
    <td style"text-align:right">'.number_format($grandTotal[0][grandTotal_saldoAwal],2,",",".").'</td>
    <td colspan=2></td>
    <td style"text-align:right">'.number_format($grandTotal[0][grandTotal_penerimaan],2,",",".").'</td>
    <td colspan=2></td>
    <td style"text-align:right">'.number_format($grandTotal[0][grandTotal_pengeluaran],2,",",".").'</td>
    <td colspan=2></td>
    <td style"text-align:right">'.number_format($grandTotal[0][grandTotal_sisa],2,",",".").'</td>
    </tr>';
    echo '</table>';
    $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);
          // exit;
    $mpdf=new mPDF('utf-8', 'A4');
    $html = ob_get_contents();
    ob_end_clean(); 
    $mpdf->WriteHTML(utf8_encode($html));
    $mpdf->Output("BA_OPNAME" ,'I');
    exit;

}
}

public function cetak_header($data,$nm_lap,$kd_lokasi,$kd_brg, $inc){
            // $kd_lokasi = $data['kd_lokasi'].$kd_ruang;
    $thn_ang = $data['thn_ang'];

    if($nm_lap=="buku_persediaan"){
        $detail_brg = "SELECT nm_sskel, kd_brg, nm_brg, satuan,spesifikasi from transaksi_masuk where  kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' ";;
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
      <td colspan="2" style="font-weight:bold;">MUTASI</td>
      <td colspan="2" style="font-weight:bold;">NILAI</td>
      <tr>
      <td width="7%">JUMLAH</td>
      <td width="10%">RUPIAH</td>
      <td style="font-size:90%; ">TAMBAH</td>
      <td style="font-size:90%;">KURANG</td>

      <td style="font-size:90%;">JUMLAH</td>
      <td width="10%" style="font-size:90%;">RUPIAH</td>
      </tr> 
      </tr>';
  }
  elseif($nm_lap=="neraca"){
              //echo '<img src="../../dist/img/pekalongan.png" alt="Pekalongan"  width="30%" height="8%" /><br></br>';

    $date = $this->cek_periode($data);
    echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">LAPORAN POSISI PERSEDIAAN DI NERACA</p>
    <p align="center" style="margin:0px; padding:0px; font-weight:bold;">UNTUK PERIODE YANG BERAKHIR PADA '.$this->konversi_tanggal($date).'</p>
    <p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN ANGGARAN '.$thn_ang.'</p><br></br>';
    $this->getsatker($kd_lokasi);
    echo '
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
   $this->getupb($kd_lokasi);
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
    $this->getupb($kd_lokasi);

    echo '   
    <table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:90% " border=1 align="center">
    <tr >
    <td >No</td>
    <td >Tanggal</td>

    <td width="5%" >Nomor Urut</td>
    <td width="5%" >Nomor Dokumen</td>
    <td width="25%" >Nama Barang</td>
    <td >Banyaknya</td>
    <td >Harga Satuan</td>
    <td >Jumlah Harga</td>
    <td >Untuk</td>
    <td >Tanggal Penyerahan</td>
    <td >Ket</td>
    </tr>';
    $this->label_nomor(11);
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
    $this->getupb($kd_lokasi);               

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
    $detail_brg = "SELECT nm_sskel, kd_brg, nm_brg, satuan,spesifikasi from transaksi_masuk where  kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' ";;
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

    $this->getupb($kd_lokasi);

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
    $this->getupb($kd_lokasi);
    $detail_brg = "SELECT nm_sskel, kd_brg, nm_brg, satuan,spesifikasi from transaksi_masuk where  kd_brg='$kd_brg' and kd_lokasi='$kd_lokasi' ";
                    // print_r($detail_brg);
    $result_detail = $this->query($detail_brg);
    $brg = $this->fetch_array($result_detail);
    echo '        <table style=" width: 100%; font-size:90%;"  >               

    <tr>
    <td align="left">Nama Barang</td>
    <td align="left">:'.$brg['nm_brg'].'</td>
    <td width="30%"></td>

    <td align="right">Kartu No</td>
    <td align="left">: '.$brg['kd_brg'].'</td>
    </tr>                
    <tr>

    <td align="left">Satuan </td>
    <td align="left">:'.$brg['satuan'].'</td>
    <td width="30%"></td>

    <td align="right">Spesifikasi </td>
    <td align="left">:'.$brg['spesifikasi'].'</td>
    </tr>
    </table>';
    echo    '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-size:90% " border=1 align="center">
    <tr>
    <td rowspan="2">No</td>
    <td rowspan="2" width="30%">No./Tgl Surat Dasar Penerimaan / Pengeluaran</td>
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
    if($data['semester']=="06"){ $smt="I"; } else{ $smt="II"; }
    echo '<table style=" text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%; font-weight:bold; font-size:0.9em; "  align="center">
    <tr>
    <td rowspan="2" width="5%"><img src="../../dist/img/pekalongan2.png" alt="Pekalongan" height="8%" /></td>
    <td style= "vertical-align: bottom;">LAPORAN SEMESTER TENTANG PENERIMAAN DAN PENGELUARAN BARANG PAKAI HABIS</td>
    </tr>
    <tr>
    <td style= "vertical-align: top;">SEMESTER '.$smt.' TAHUN '.$thn_ang.'</td>
    </tr>

    </table>
    ';   
    $this->getupb($kd_lokasi);
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

public function dateRange($data)
{
    $kriteria = "";
    if($data['jenis']=="semester"){
        $kriteria = "and month(tgl_dok) >= '$data[bln_awal]' and month(tgl_dok) <= '$data[bln_akhir]' ";
    }
    elseif($data['jenis']=="tanggal"){
        $kriteria = "AND tgl_dok <= '$data[tgl_akhir]' ";
    }        
    elseif($data['jenis']=="bulan"){
        $kriteria = "and month(tgl_dok)='$bulan'";
    }
    else{
        $kriteria = "";
    }
    return $kriteria;
}

public function get_query($data,$nm_lap,$kd_lokasi,$kd_brg,$nm_satker,$no_urut){


    $jenis = $data['jenis'];

    $tgl_awal = $data['tgl_awal'];
    $tgl_akhir = $data['tgl_akhir'];
    $tgl_cetak = $data['tgl_cetak'];
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
        $kriteria = "and tgl_dok >= '$tgl_awal' AND tgl_dok <= '$tgl_akhir' ";
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
        $sql= "SELECT kd_perk, nm_perk from transaksi_masuk kd_lokasi where concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  and thn_ang='$thn_ang' 
        GROUP by kd_brg";
    }   
    elseif($nm_lap=="rincian_persediaan2"){

      $kriteria1 = substr($sblm_kriteria, 5);
      $sql= "SELECT kd_perk, nm_perk from transaksi_masuk where concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  and thn_ang='$thn_ang' 
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
      SELECT tgl_dok, thn_ang, kd_perk, nm_perk, jns_trans, total_harga, status_hapus, kd_lokasi,kd_ruang from transaksi_masuk
      UNION ALL
      SELECT tgl_dok, thn_ang, kd_perk, nm_perk, jns_trans, total_harga, status_hapus, kd_lokasi,kd_ruang from transaksi_keluar
      ) transaksi  
      where kd_perk not like '' 
      AND concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_lokasi'  
      AND thn_ang='$thn_ang' 
      AND tgl_dok BETWEEN '$tgl_awal' 
      AND '$tgl_akhir'
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
      $sql="SELECT id, tgl_buku, no_bukti, tgl_dok, concat(nm_brg,' ',IFNULL(spesifikasi,'')) as nm_brg, qty, harga_sat,total_harga, tgl_buku, keterangan 
      FROM transaksi_masuk 
      where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'  
      and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'   
      AND thn_ang='$thn_ang'
      ORDER BY tgl_dok ASC,id asc";


  }
  elseif($nm_lap=="pengeluaran_brg"){
      $sql="SELECT id, tgl_buku, no_dok, tgl_dok,concat(nm_brg,' ',spesifikasi) as nm_brg, qty, harga_sat,total_harga, tgl_buku, keterangan 
      FROM transaksi_keluar 
      where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir'  
      and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'
      AND thn_ang='$thn_ang'
      ORDER BY no_dok, tgl_dok ASC,id asc";

  }
  elseif($nm_lap=="buku_brg_pakai_habis"){
      $sql="SELECT id, tgl_buku, no_bukti, tgl_dok, nm_sskel, nm_brg,  spesifikasi, qty, satuan, harga_sat,total_harga, keterangan 
      FROM transaksi_masuk 
      where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
      and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' 
      AND thn_ang='$thn_ang'
      union all
      SELECT id, tgl_buku, no_bukti, tgl_dok, nm_sskel, nm_brg, spesifikasi,  qty, satuan, harga_sat,total_harga, keterangan 
      FROM transaksi_keluar 
      where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
      and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
      AND thn_ang='$thn_ang'

      ORDER BY tgl_dok ASC,id asc, nm_brg asc;";


  }
  elseif($nm_lap=="kartu_brg"){
    $sql="SELECT id, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
    FROM transaksi_masuk 
    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
    AND kd_brg='$kd_brg' 
    and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' 
    AND thn_ang='$thn_ang'
    union all 
    SELECT id, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
    FROM transaksi_keluar 
    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
    AND kd_brg='$kd_brg' 
    and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
    AND thn_ang='$thn_ang'
    ORDER BY tgl_dok ASC,id asc;";

}   
elseif($nm_lap=="kartu_p_brg"){
    $sql="SELECT id,no_bukti, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
    FROM transaksi_masuk 
    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
    AND kd_brg='$kd_brg' 
    and kd_lokasi ='$kd_lokasi'   
    AND thn_ang='$thn_ang'
    union all 
    SELECT id, no_bukti, tgl_dok, keterangan,qty,harga_sat,kd_lokasi,kd_brg 
    FROM transaksi_keluar 
    where tgl_dok BETWEEN '$tgl_awal' AND '$tgl_akhir' 
    AND kd_brg='$kd_brg' 
    and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'   
    AND thn_ang='$thn_ang'
    ORDER BY tgl_dok ASC,id asc;";

}
elseif($nm_lap=="pp_brg_pakai_habis"){
  $sql="SELECT id, tgl_buku, no_bukti, tgl_dok, nm_sskel, nm_brg,  spesifikasi, qty, satuan, untuk, harga_sat,total_harga, keterangan 
  FROM transaksi_masuk 
  where month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir'
  and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
  AND thn_ang='$thn_ang'
  union all
  SELECT id, tgl_buku, no_bukti, tgl_dok, nm_sskel, nm_brg, spesifikasi,  qty, satuan, untuk, harga_sat,total_harga, keterangan 
  FROM transaksi_keluar 
  where month(tgl_dok) >= '$bln_awal' and month(tgl_dok) <= '$bln_akhir'
  and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'  
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
            <center><td  align="right">'.number_format($data[harga_sat],2,",",".").'</td></center>
            <center><td  align="center">'.'</td></center>';
        }
        else 
        {

            echo '<center><td  align="center">'.'</td></center>
            <center><td  align="right">'.number_format(abs($data[harga_sat]),2,",",".").'</td></center>
            <center><td  align="center">'.abs($data[qty]).'</td></center>';
        }

        $saldo +=$data[qty]*abs($data[harga_sat]);
        $jumlah+=$data[qty];
        echo '<td>'.$jumlah.'</td>
        <center><td align="right">'.number_format($saldo,2,",",".").'</td></center>
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
    if($saldo!==0){
        echo '<tr>

        <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut.'</td>
        <td colspan="3" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$nm_satker.'</td>
        </tr>';

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
                <td align="right" style="font-size:90%; "></td>
                <td align="right" style="font-size:90%; "><b>'.substr($data[kd_perk],0, 5).'</b></td>';
                if(substr($data[kd_perk],0, 5)=="11701"){
                    echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Bahan Pakai Habis".'</b></td>';
                }
                elseif(substr($data[kd_perk],0, 5)=="11702"){
                    echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Bahan / Material".'</b></td>';
                }
                else{
                    echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Brang Lainnya".'</b></td>';
                }
                echo '

                <td  align="right" style="font-size:90%; ;">'.number_format($this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"saldo",$kd_lokasi),2,",",".").'</td>

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
    if($qty_msk!==0||$qty_SA!==0){
        echo '<tr>
        <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.$no_urut.'</td>
        <td colspan="8" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$nm_satker.'</td>
        </tr>';
        echo '  <tr>
        <td align="right" style="font-size:90%; "></td>
        <td align="right" style="font-size:90%; "><b>117</b></td>
        <td align="left" style="font-size:90%; "><b>Persediaan</b></td>
        <td align="center"  style="font-size:90%; "><b>'.$qty_SA.'</b></td>
        <td align="center"  style="font-size:90%; "><b>'.number_format($hrg_SA,2,",",".").'</b></td>
        <td align="center"  style="font-size:90%; "><b>'.$qty_msk.'</b></td>
        <td align="center"  style="font-size:90%; "><b>'.$qty_klr.'</b></td>

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
                    echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Bahan Pakai Habis".'</b></td>';
                }
                elseif(substr($data[kd_perk],0, 5)=="11702"){
                    echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Bahan / Material".'</b></td>';
                }
                else{
                    echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Brang Lainnya".'</b></td>';
                }
                echo    '<td align="center"  style="font-size:90%; "><b>'.$qty_SA.'</b></td>
                <td align="center"  style="font-size:90%; "><b>'.number_format($hrg_SA,2,",",".").'</b></td>
                <td align="center"  style="font-size:90%; "><b>'.$qty_msk.'</b></td>
                <td align="center"  style="font-size:90%; "><b>'.$qty_klr.'</b></td>

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
                <td  align="left" style=" font-size:90%;">'."&nbsp;&nbsp;&nbsp;&nbsp;-".$data[nm_perk].'</td>
                <td align="right"  style="font-size:90%; ">'.$qty_SA.'</td>
                <td align="right"  style="font-size:90%; ">'.number_format($hrg_SA,2,",",".").'</td>
                <td align="right"  style="font-size:90%; ">'.$qty_msk.'</td>
                <td align="right"  style="font-size:90%; ">'.$qty_klr.'</td>

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
    if($saldo>0){
        echo '<tr>

        <td colspan style="font-weight:bold; background-color:#EFEFEF;">'.''.'</td>
        <td colspan="3" align="left" style="font-weight:bold; background-color:#EFEFEF;">'.$nm_satker.'</td>
        </tr>';
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
                if($kd_rek!=substr($data[kd_perk],0, 5))
                {
                    echo '<tr>
                    <td align="right" style="font-size:90%; "></td>
                    <td align="right" style="font-size:90%; "><b>'.substr($data[kd_perk],0, 5).'</b></td>';
                    if(substr($data[kd_perk],0, 5)=="11701"){
                        echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Bahan Pakai Habis".'</b></td>';
                    }
                    elseif(substr($data[kd_perk],0, 5)=="11702"){
                        echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Bahan / Material".'</b></td>';
                    }
                    else{
                        echo '<td align="left" style="font-size:90%; "><b>'."&nbsp;&nbsp;Persediaan Brang Lainnya".'</b></td>';
                    }
                    echo '

                    <td  align="right" style="font-size:90%; ;">'.number_format($this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"saldo",$kd_lokasi),2,",",".").'</td>

                    ';
                    $kd_rek=substr($data[kd_perk],0, 5);
                }
                            // echo '<tr>
                            //         <td></td>
                            //         <td align="right" style="font-size:90%; ">'.substr($data[kd_perk],0, 5).'</td>
                            //         <td  align="left" style="font-size:90%; ">'.$data[nm_perk].'</td>
                            //         <td  align="right" style="font-size:90%; ;">'.number_format($this->sum_persedia($data_lp,substr($data[kd_perk],0, 5),"saldo",$kd_lokasi),2,",",".").'</td>
                            //         <tr>
                            //        ';
                            // $kd_rek=substr($data[kd_perk],0, 5);
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
    if($saldo>0){
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
    }
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
    $header = 7;

    while($data=$this->fetch_assoc($result))
    {
        $no+=1;
        $saldo+=$data[total_harga];
        echo'<tr >
        <center><td style="height:25px"  align="center">'.$no.'</td></center>
        <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
        <center><td  align="center">'.'-'.'</td></center>
        <center><td  align="left">'.$data[no_bukti].'</td></center>
        <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
        <center><td  align="left">'.$data[nm_brg].'</td></center>
        <center><td  align="center">'.$data[qty].'</td></center>
        <center><td  style="text-align:right">'.number_format($data[harga_sat],2,",",".").'</td></center>
        <center><td  style="text-align:right">'.number_format(abs($data[total_harga]),2,",",".").'</td></center>

        <center><td  align="left">'.$data[no_bukti].'</td></center>
        <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
        <center><td  align="left">'.$data[keterangan].'</td></center>';

        echo '</tr>';

    }
    echo '<tr>
    <td colspan="8" style="align:center; font-weight:bold">TOTAL</td>
    <td style="text-align:right">'.number_format($saldo,2,",",".").'</td>
    <td></td>
    <td></td>
    <td></td>
    </tr>';

    echo '</table>';
    $line_acc = $header+$no;
    if($line_acc>=20) echo '<pagebreak />';
    $this->cetak_nama_pj($kd_lokasi,$tgl_cetak);


}
elseif($nm_lap=="pengeluaran_brg"){
    $no=0;
    $jumlah=0;
    $saldo=0;
    $header = 7;
    while($data=$this->fetch_assoc($result))
    {
        if($data[qty]==0) continue;
        $no+=1;
        $saldo+=abs($data[total_harga]);
        echo'<tr>
        <center><td  align="center">'.$no.'</td></center>
        <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
        <center><td  align="center">'.$no.'</td></center>
        <center><td  align="center">'.substr($data[no_dok],14).'</td></center>
        <center><td  align="left">'.$data[nm_brg].'</td></center>
        <center><td  align="center">'.abs($data[qty]).'</td></center>
        <center><td  style="text-align:right">'.number_format($data[harga_sat],2,",",".").'</td></center>
        <center><td  style="text-align:right">'.number_format(abs($data[total_harga]),2,",",".").'</td></center>
        <center><td  align="center">'.$data[keterangan].'</td></center>

        <center><td  align="center">'.$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
        <center><td  align="center">'.''.'</td></center>';
        echo '</tr>';
    }
    echo '<tr>
    <td colspan="7" style="align:center; font-weight:bold">TOTAL</td>
    <td style="text-align:right">'.number_format($saldo,2,",",".").'</td>
    <td></td>
    <td></td>
    <td></td>
    </tr>'; 

    echo '</table>';
    $line_acc = $header + $no;
    if($line_acc>=20) echo '<pagebreak />';   

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
            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.$data[nm_brg].'</td></center>
            <center><td  align="center">'.$data[spesifikasi].'</td></center>
            <center><td  align="center">'.''.'</td></center>
            <center><td  align="center">'.$data[qty].' '.$data[satuan].'</td></center>
            <center><td  align="center">'.number_format($data[harga_sat],2,",",".").'</td></center>
            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.$data[no_bukti].'</td></center>
            <td>'.''.'</td>
            <td>'.''.'</td>
            <td>'.''.'</td>
            <td>'.''.'</td>
            <td>'.''.'</td>
            </tr>';
        }
        else
        {
            echo '<tr>
            <center><td  align="center">'.$no.'</td></center>
            <center><td  align="center">'.''.'</td></center>
            <center><td  align="center">'.$data[nm_brg].'</td></center>
            <center><td  align="center">'.$data[spesifikasi].'</td></center>
            <td>'.''.'</td>
            <td>'.''.'</td>
            <td>'.''.'</td>
            <td>'.''.'</td>
            <td>'.''.'</td>
            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.''.'</td></center>
            <center><td  align="center">'.abs($data[qty]).' '.$data[satuan].'</td></center>
            <center><td  align="center">'.$data[no_bukti].'</td></center>
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
        <center><td  align="center">'.''.'</td></center>
        <center><td  align="center">'.$sisa.'</td></center>
        <center><td  align="center">'.$data[keterangan].'</td></center>';
    }
    else 
    {                
        echo '<center><td  align="center">'.''.'</td></center>
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
        <center><td  align="center">'.$data[no_bukti]." / ".$this->tgl_buku_sedia($data[tgl_dok]).'</td></center>
        <center><td  align="center">'.$data[keterangan].'</td></center>

        ';
        if($data[qty]>0) 
        {
            echo '<center><td  align="center">'.$data[qty].'</td></center> 
            <center><td  align="center">'.''.'</td></center>
            <center><td  align="center">'.$sisa.'</td></center>
            <center><td  align="center">'.number_format($data[harga_sat],2,",",".").'</td></center>
            <center><td  align="center">'.number_format($subtotal,2,",",".").'</td></center>
            <center><td  align="center">'.''.'</td></center>
            <center><td  align="center">'.number_format($saldo,2,",",".").'</td></center>
            <center><td  align="center">'.''.'</td></center>';
        }
        else 
        {

            echo '  <center><td  align="center">'.''.'</td></center>
            <center><td  align="center">'.abs($data[qty]).'</td></center>
            <center><td  align="center">'.$sisa.'</td></center>
            <center><td  align="center">'.$data[harga_sat].'</td></center>
            <center><td  align="center">'.''.'</td></center>
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
    $header = 7;

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
            echo '  <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.$data[keterangan].'</td></center>
            <center><td  align="center">'.$data[no_bukti].'</td></center> 
            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.''.'</td></center>
            <center><td  align="center">'.''.'</td></center>
            <center><td  align="center">'.$data[qty].'</td></center>
            <center><td  align="center">'.$data[nm_brg].' '.$data[spesifikasi].'</td></center>
            <center><td  align="center">'.number_format($data[harga_sat],2,",",".").'</td></center>
            <center><td  align="center">'.$data[no_bukti].'</td></center>
            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.''.'</td></center>
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
            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.$data[no_bukti].'</td></center>
            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.$data[keterangan].'</td></center>
            <center><td  align="center">'.abs($data[qty]).'</td></center>
            <center><td  align="center">'.$data[nm_brg].'</td></center>
            <center><td  align="center">'.number_format($data[harga_sat],2,",",".").'</td></center>
            <center><td  align="center">'.$subtotal.'</td></center>
            <center><td  align="center">'.$this->konversi_tanggal($data[tgl_dok]).'</td></center>
            <center><td  align="center">'.''.'</td></center>
            ';

        }
        echo  '</tr>';
    }

    echo   '</table>';
    $line_acc = $header + $no;
    if($line_acc>=23) echo '<pagebreak />';

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
public function getupb($kd_lokasi){
    $query_upb = "SELECT NamaSatker from satker where kode='$kd_lokasi'";
    $result_upb = $this->query($query_upb);
    $data_upb = $this->fetch_array($result_upb);
    $nama_upb = $data_upb['NamaSatker'];
    echo '<table style="text-align: left; width: 70%; font-size:80%;" >';
    echo  '<tr>
    <td style="font-weight:bold">SKPD</td>
    <td>'.':  '.$nama_upb.'</td>
    </tr>';
    echo  '<tr>
    <td style="font-weight:bold">Provinsi</td>
    <td>'.':  '.'PROVINSI JAWA TENGAH'.'</td>
    </tr>';
    echo  ' 
    <tr>
    <td style="font-weight:bold">Kabupaten / Kota</td>
    <td>'.':  '.' '.'KOTA PEKALONGAN'.'</td>
    </tr>'; 

    echo '</table>';
    echo '<br></br>';

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
    $nama_satker = $data_satker['NamaSatker'];

    $result_unit = $this->query($query_unit);
    $data_unit = $this->fetch_array($result_unit);
    $nama_unit = $data_unit['NamaSatker'];

    $result_gudang = $this->query($query_gudang);
    $data_gudang = $this->fetch_array($result_gudang);
    $nama_gudang = $data_gudang['NamaSatker'];

    if($_POST['format']=="excel"){
        $data = array( 'nama_sektor'=>$nama_sektor,
                       'nama_satker'=>$nama_satker,
                       'nama_unit'  =>$nama_unit,
                       'nama_gudang'=>$nama_gudang
                );
        return $data;
    }
    else{


    echo '<table style="text-align: left; width: 70%; font-size:80%;" >';
    echo  '<tr>
    <td style="font-weight:bold">Provinsi</td>
    <td>'.':  '.'PROVINSI JAWA TENGAH'.'</td>
    </tr>';
    echo  ' 
    <tr>
    <td style="font-weight:bold">Kabupaten / Kota</td>
    <td>'.':  '.' '.'KOTA PEKALONGAN'.'</td>
    </tr>'; 
    if($detil[0]!="")
    {
        echo '
        <tr>
        <td style="font-weight:bold">Bidang</td>
        <td >'.':  '.$nama_sektor.'</td>
        </tr>';
    }
    if($detil[1]!="")
    {
        echo  ' 
        <tr>
        <td style="font-weight:bold">Unit Organisasi</td>
        <td >'.':  '.' '.$nama_satker.'</td>
        </tr>'; 
    }
    if($detil[2]!="")
    {               
        echo  ' 
        <tr>
        <td style="font-weight:bold">Sub Unit Organisasi</td>
        <td >'.':  '.' '.$nama_unit.'</td>
        </tr>'; 
    }
    if($detil[3]!="")
    { 
        echo            '<tr>
        <td style="font-weight:bold">UPB</td>
        <td >'.':  '.$nama_gudang.'</td>
        </tr>
        <p></p>';
    }
    echo '</table>';
    echo '<br></br>';
    }

}

public function sum_persedia($data,$kode,$nilai,$kd_lokasi)
{

    $thn_ang = $data['thn_ang'];
    $jenis = $data['jenis'];
    $tgl_awal = $data['tgl_awal'];
    $tgl_akhir = $data['tgl_akhir'];
    $tgl_cetak = $data['tgl_cetak'];
    $bulan = $data['bulan'];
    $bln_awal = $data['bln_awal'];
    $bln_akhir = $data['bln_akhir'];


    if($kode=="117"&&$nilai=="qty_SA")
    {
        $nm_kolom = " sum(qty) ";
        $nm_tabel = " transaksi_masuk ";
        $jns_trans= " and jns_trans like 'M01%' ";
        $kd_perk  = "";

    }
    elseif($kode=="117"&&$nilai=="hrg_SA")
    {
        $nm_kolom = " sum(total_harga) ";
        $nm_tabel = " transaksi_masuk";
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
        $nm_tabel = " transaksi_masuk";
        $jns_trans= " and jns_trans like 'M01%' ";
        $kd_perk  = " and kd_perk like '11701%' ";
        $sql = "SELECT sum(qty) as jml from transaksi_full where kd_lokasi like '$kd_lokasi%' and jns_trans like 'M01%' and thn_ang='$thn_ang' and kd_perk like '11701%'   ";
    }
    elseif($kode=="11701" && $nilai=="hrg_SA")
    {
        $nm_kolom = " sum(total_harga) ";
        $nm_tabel = " transaksi_masuk ";
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
        $jns_trans= "";
        $kd_perk  = " and kd_perk like '11701%' ";
        $sql = "SELECT sum(qty_akhir*harga_sat) as jml from transaksi_masuk where kd_lokasi like '$kd_lokasi%' and thn_ang='$thn_ang' and kd_perk like '11701%' ";
    }
    elseif($kode!=="11701" && $nilai=="qty_SA")
    {
        $nm_kolom = " sum(qty) ";
        $nm_tabel = " transaksi_masuk";
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
        $kriteria = "and tgl_dok >= '$tgl_awal' AND tgl_dok <= '$tgl_akhir' ";
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

    $sql = "SELECT ".$nm_kolom." as jml from ".$nm_tabel." where concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%' and thn_ang='$thn_ang' ".$jns_trans." ".$kd_perk." ".$kriteria;

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
    $tgl_cetak = $data['tgl_cetak'];
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

public function filter_query($str){
    $skpd_criteria = "";   
    if ($str=="") {
        $skpd_criteria = "";   
    }
    else if (substr_count($str,".") == 0 and substr_count($str,".") <=2) {
        $skpd_criteria = "concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$str%'  and";   
    }
    else{
        $skpd_criteria = "concat(kd_lokasi,IFNULL(kd_ruang,'')) = '$str'  and"; 
    }
    return $skpd_criteria;
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

public function sqlDate($tgl)
{

    $data_tgl = explode("-",$tgl);
    $tanggal = "$data_tgl[2]-$data_tgl[1]-$data_tgl[0]";
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

public function cetak_nama_pj($satker_asal,$tgl_cetak="")
{
    $kode_satker = $satker_asal;
    $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kode_satker' ";
    $result = $this->query($query);
    $pj = $this->fetch_array($result);
    if(count($pj)>0){
        $jabatan_1="An Pengguna / Kuasa Pengguna Barang";
        $jabatan_1b="Pejabat Penatausahaan Pengguna Barang";
        $jabatan_2="Pengurus Barang";
        $jabatan_3="Pembantu Pengurus Barang";
        $atasan_PB = $pj['nama'];
        $nip_atasan_PB = $pj['nip'];
        $penyimpan_brg = $pj['nama2'];
        $nip_penyimpan_brg = $pj['nip2'];
        $nama_kasubkeu = $pj['nama_kasubkeu'];
        $nip_kasubkeu = $pj['nip_kasubkeu'];
    }
    else {
        $jabatan_1="SETDA,";
        $jabatan_1b="";
        $jabatan_2="PENYIMPAN BARANG DAERAH";
        $atasan_PB = "";
        $nip_atasan_PB = "";
        $penyimpan_brg = "";
        $nip_penyimpan_brg = "";
    }

    echo '<br></br>
    <table style="text-align: center; width: 100%; font-size:84% "  >
    <tr>
    <td style="text-align: center;"></td>
    <td style="text-align: center;"></td>
    <td style="text-align: left;"> '.'Kota Pekalongan,'.$tgl_cetak.'</td>
    </tr>
    <tr>
    <td style="text-align: left;">Mengetahui</td>
    <td style="text-align: left;"></td>
    </tr>            
    <tr>
    <td style="text-align: left;">'.$jabatan_1.'</td>
    <td style="text-align: left;">'.$jabatan_2.'</td>
    <td style="text-align: left;">'.$jabatan_3.'</td>
    </tr>
    <tr>
    <td style="text-align: left;">'.$jabatan_1b.'</td>
    <td></td>
    </tr>
    <tr>
    <td><br></br><br></br><br></br><br></br></td>
    <td><br></br><br></br><br></br><br></br></td>
    </tr>
    <tr>
    <td style="text-align: left">'.$atasan_PB.'</td>
    <td style="text-align: left">'.'..........................................................'.'</td>

    <td style="text-align: left">'.$penyimpan_brg.'</td>
    </tr>              

    <tr>
    <td style="text-align: left;">NIP'." ".$nip_atasan_PB.'</td>
    <td style="text-align: left;">NIP'." ".'..................................................'.'</td>
    <td style="text-align: left;">NIP'." ".$nip_penyimpan_brg.'</td>
    </tr>
    </table>';


}



}





?>
