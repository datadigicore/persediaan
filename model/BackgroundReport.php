<?php
include('../config/dbconf.php');
include('../utility/mysql_db.php');
include '../utility/optbs/tbs_class.php';
include '../utility/optbs/tbs_plugin_opentbs.php';
define('_MPDF_PATH','../plugins/mPDF/');
require(_MPDF_PATH."mpdf.php");

$db = new mysql_db();
$nama_laporan;
$kd_ruang    = str_replace(" ", "", $data['kd_ruang']);
$kd_lokasi   = $data['kd_lokasi'].$kd_ruang;
$nm_satker;
$nama_file;
$tgl_akhir   = $data['tgl_akhir'];
$thn_ang     = $data['thn_ang'];
switch ($nama_laporan) {
  case 'l_barang_keluar':
        $kd_brg      = $data['kd_brg'];
        $TBS = new clsTinyButStrong;  
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            $template = './utility/optbs/template/buku_pengeluaran_barang.xlsx';
            $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
            $no=1;
            $rekap = array();
            $identitas_pejabat = array();

            // $identitas_pejabat = array();
            $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$satker_asal' ";
            $result_pj = $this->query($query);
            
            $sql="SELECT id, tgl_buku, no_dok, tgl_dok, concat(nm_brg,' ',spesifikasi) as nm_brg, qty, harga_sat,total_harga, tgl_buku, keterangan 
            FROM transaksi_keluar 
            where tgl_dok <= '$tgl_akhir'  
            and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_lokasi%'
            AND thn_ang='$thn_ang'
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
    break;
  
  default:
    # code...
    break;
}

?>
