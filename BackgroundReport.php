<?php
include('config/filepath.php');
include('utility/mysql_db.php');
include 'utility/optbs/tbs_class.php';
include 'utility/optbs/tbs_plugin_opentbs.php';


$db = new mysql_db();
$nama_laporan = $argv[1];
$kd_lokasi   = $argv[2];
$kd_ruang   = $argv[3];
$nm_satker;
$nama_file;
$tgl_akhir   = $argv[4];
$thn_ang     = $argv[5];
$tgl_cetak   = $argv[6];
$kd_satker = $kd_lokasi.$kd_ruang;

$time = date('h-i');
if($nama_laporan=="l_keluar_brg") {
$filename = "Buku_Pengeluaran_Barang-$kd_satker-$time.xlsx"; 
//  

$sql = "INSERT INTO laporan SET 
          kd_lokasi = '$kd_satker',
          nm_satker = '-',
          thn_ang = $thn_ang,
          nama_laporan = 'Buku Pengeluaran Barang',
          tanggal = '".date('Y-m-d')."',
          nama_file = '$filename',
          status = 1
";
$res_insert = $db->query($sql);
$id = $db->insert_id($res_insert);
            $TBS = new clsTinyButStrong;  
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            $template = $base_path.'/utility/optbs/template/buku_pengeluaran_barang.xlsx';
            $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); 
            $no=1;
            $rekap = array();
            $identitas_pejabat = array();

            // $identitas_pejabat = array();
            $query = "SELECT * from ttd where concat(kd_lokasi,IFNULL(kd_ruang,''))='$kd_satker' ";

            $result_pj = $db->query($query);

            $sql="SELECT id, tgl_buku, no_dok, tgl_dok, concat(nm_brg,' ',spesifikasi) as nm_brg, qty, harga_sat,total_harga, tgl_buku, keterangan 
            FROM transaksi_keluar 
            where tgl_dok <= '$tgl_akhir'  
            and concat(kd_lokasi,IFNULL(kd_ruang,'')) like '$kd_satker%'
            AND thn_ang='$thn_ang'
            ORDER BY tgl_dok ASC, no_dok ASC";
            $res = $db->query($sql);
            echo $sql;
            $sql = "SELECT NamaSatker from satker where kode= '$kd_lokasi' ";
            $res_satker = $db->query($sql);
            $data_sakter = $db->fetch_array($res_satker);
            $total=0;
            foreach ($res as $value) {
                $total +=  abs($value['total_harga']);
                $rekap[] = array(
                    'no' => $no,
                    'tgl_dok' => $db->tgl_buku_sedia($value['tgl_dok']),
                    'tgl_buku' => $db->tgl_buku_sedia($value['tgl_buku']),
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

                $TBS->Show(OPENTBS_FILE, $path_laporan.$filename); 
                $sql = "UPDATE laporan set status=2 WHERE id=$id";
                $db->query($sql); 
                exit(""); 
            
    }


?>
