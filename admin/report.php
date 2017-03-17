<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <?php include("../config/dbconf.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/datepicker.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Laporan SKPD
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-file-text-o"></i>Laporan SKPD</a></li>
          </ol>
        </section>
        <section class="content">


                  <ul class="nav nav-tabs">
              <li><a href="#lap_persediaan" data-toggle="tab">Laporan Persediaan<i class="fa"></i></a></li>
              <li><a href="#rincian_persediaan" data-toggle="tab">Rincian Persediaan<i class="fa"></i></a></li>
              <li><a href="#neraca" data-toggle="tab">Posisi Persediaan<i class="fa"></i></a></li>
              <li><a href="#mutasi" data-toggle="tab">Mutasi Persediaan<i class="fa"></i></a></li>
              <li><a href="#ba_opname" data-toggle="tab">Berita Acara Stock Opname<i class="fa"></i></a></li>
              <li><a href="#belanjaPerKategori" data-toggle="tab">Belanja Persediaan Per-Kategori<i class="fa"></i></a></li>
              <li><a href="#belanjaPerDokumen" data-toggle="tab">Belanja Persediaan Per-Dokumen<i class="fa"></i></a></li>
              <li><a href="#belanjaPerKategori2" data-toggle="tab">Belanja Persediaan Per-Rekening(2)<i class="fa"></i></a></li>
              <li><a href="#terima_brg" data-toggle="tab">Buku Penerimaan Barang Per UPB<i class="fa"></i></a></li>
              <li><a href="#keluar_brg" data-toggle="tab">Buku Pengeluaran Barang Per UPB<i class="fa"></i></a></li>
              <li><a href="#buku_pakai_habis" data-toggle="tab">Buku Barang Pakai Habis Per UPB<i class="fa"></i></a></li>
              <li><a href="#terima_keluar_brg" data-toggle="tab">Penerimaan & pengeluaran Barang Pakai Habis Per UPB<i class="fa"></i></a></li>

          </ul>


          

          <form action="../core/report/prosesreport" method="post" class="form-horizontal" >
              <div class="tab-content">
                  <div class="tab-pane active" id="lap_persediaan">  
                      <input type="hidden" name="manage" id="manage" value="lap_persediaan">

                  </div>

                  <div class="tab-pane" id="rincian_persediaan">
                    <div class="box-body radio" >
                        <label class="col-sm-2 control-label"><input type="radio" name="lingkup" id="kota" value="kota" >Kota</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="lingkup" id="skpd" value="skpd" >SKPD</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="lingkup" id="upb" value="upb" checked>UPB</label>
                    </div> 
                  </div>

                  <div class="tab-pane" id="neraca">
                    <div class="box-body radio" >
                        <label class="col-sm-2 control-label"><input type="radio" name="lingkup" id="kota" value="kota" >Kota</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="lingkup" id="skpd" value="skpd" >SKPD</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="lingkup" id="upb" value="upb" checked>UPB</label>
                    </div>
                  </div>

                  <div class="tab-pane" id="mutasi">

                  </div>
                    
                  <div class="tab-pane" id="ba_opname">
                    <div class="box-body" id="bln"  >
                        <label class="col-sm-2 control-label">Jenis Laporan</label>
                        <div class="col-sm-4">
                          <select name="scope" id="scope" class="form-control">
                            <option value="1">Detail (Uraian Jumlah, dan Total Harga Per Barang)</option>
                            <option value="2">Group Per Barang (Uraian Jumlah Barang)</option>
                          </select>
                        </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="terima_brg">
                  </div>

                  <div class="tab-pane" id="keluar_brg">
                  </div>

                  <div class="tab-pane" id="buku_pakai_habis">
                  </div>

                  <div class="tab-pane" id="terima_keluar_brg">
                  </div>
                  <div class="tab-pane" id="belanjaPerKategori">
                  </div>
                  <div class="tab-pane" id="belanjaPerKategori2">
                  </div>
                  <div class="tab-pane" id="belanjaPerDokumen">
                  </div>

              </div>
                 <div class="box-body">
                    <label class="col-sm-2 control-label">Kode Satker</label>
                       <div class="col-sm-4">
                          <select name="satker" id="satker" class="form-control">
                          </select>
                        </div>
                  </div>
                  <div class="box-body">
                      <label class="col-sm-2 control-label">Kode Bagian / Sub-Unit </label>
                      <div class="col-sm-4">
                        <select name="kd_ruang" id="kd_ruang" class="form-control">
                        </select>
                      </div>
                    </div> 
                    <div class="box-body radio" style="display: none;">
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="tanggal" value="tanggal" checked>Tanggal</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="semester" value="semester">Semester</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="tahun" value="tahun" >Tahun <?php echo $_SESSION['thn_ang'];?></label>
                    </div>                                       
                    <!-- <div class="box-body" id="awal" >
                      <label class="col-sm-2 control-label">Tanggal Awal</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="">
                        </select>
                      </div>
                    </div> -->                     
                    <div class="box-body" id="akhir" >
                      <label class="col-sm-2 control-label">Tanggal Akhir</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="" >
                        </select>
                      </div>
                    </div>
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Tanggal Cetak Laporan</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_cetak" class="form-control" id="tgl_cetak" placeholder="" required>
                        </select>
                      </div>
                    </div>
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Format laporan</label>
                      <div class="col-sm-4">
                        <select name="format" id="format" class="form-control">
                          <option value="pdf">PDF</option>
                          <option value="excel">Excel</option>
                        </select>
                      </div>
                    </div>

                    <div class="box-body" id="bln"  style="display: none;">
                      <label class="col-sm-2 control-label">Semester</label>
                      <div class="col-sm-2">
                        <select name="smt" id="smt" class="form-control">
                          <option value="01-06">Semester 1</option>
                          <option value="07-12">Semester 2</option>
                        </select>
                      </div>
                    </div> 
 
              <div class="form-group" style="margin-top: 15px;">
                  <div class="col-xs-5 col-xs-offset-3">
                      <button type="submit" class="btn btn-default">Cetak</button>
                  </div>
              </div>
          </form>
        </div>
        </section>
      
      <?php include("include/footer.php"); ?>
      <?php include("include/success.php"); ?>
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/jquery.mask.js" ></script>
    <script src="../dist/js/bootstrap-datepicker.js" type="text/javascript"></script>

    <script type="text/javascript">
      $("li#laporan").addClass("active");
      var manage_val;
      $('#tgl_awal').datepicker({
          format: "dd-mm-yyyy"
      });         
      $('#tgl_akhir').datepicker({
            format: "dd-mm-yyyy"
        }); 
      $('#tgl_awal').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
      $('#tgl_akhir').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
      $("input[id=tanggal]").click(function()
        {

            $("#bln").hide();
            // $("#awal").show();
            $("#akhir").show();
            $('#tgl_akhir').prop('required',true);
        });
      $("input[id=semester]").click(function()
        {
            $("#bln").show();
            // $("#awal").hide();
            $("#akhir").hide();
            $('#tgl_akhir').removeAttr('required');
        });
      $("input[id=tahun]").click(function()
        {
            $("#bln").hide();
            // $("#awal").hide();
            $("#akhir").hide();
            $('#tgl_akhir').removeAttr('required');
        });
      $(document).ready(function(){
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
          var cT = $(e.target).text(); 
          switch(cT){
            case 'Laporan Persediaan':
              $("#manage").val("lap_persediaan");
              manage_val = 'baca_satker_admin';
            break;

            case 'Rincian Persediaan':
              $("#manage").val("rincian");
              manage_val = 'baca_satker_admin';
            break;            

            case 'Posisi Persediaan':
              $("#manage").val("neraca");
              manage_val = 'baca_satker_admin';
            break;

            case 'Mutasi Persediaan':
              $("#manage").val("mutasi");
              manage_val = 'baca_satker_admin';
            break;            

            case 'Berita Acara Stock Opname':
              $("#manage").val("ba_opname");
              manage_val = 'baca_upb_admin';
            break;            

            case 'Buku Penerimaan Barang Per UPB':
              $("#manage").val("l_terima_brg");
              manage_val = 'baca_upb_admin';
            break;            

            case 'Buku Pengeluaran Barang Per UPB':
              $("#manage").val("l_keluar_brg");
              manage_val = 'baca_upb_admin';
            break;            

            case 'Buku Barang Pakai Habis Per UPB':
              $("#manage").val("l_buku_bph");
              manage_val = 'baca_upb_admin';
            break;            
            case 'Penerimaan & pengeluaran Barang Pakai Habis Per UPB':
              $("#manage").val("l_pp_bph");
              manage_val = 'baca_upb_admin';
            break;            
            case 'Belanja Persediaan Per-Kategori':
              $("#manage").val("laporan_per_rekening");
              manage_val = 'baca_upb_admin';
            break;
            case 'Belanja Persediaan Per-Rekening(2)':
              $("#manage").val("laporan_per_rekening2");
              manage_val = 'baca_upb_admin';
            break;
            case 'Belanja Persediaan Per-Dokumen':
              $("#manage").val("rekap_per_dok");
              manage_val = 'baca_upb_admin';
            break;

            default:

            break;
          }
    });
});

$('#satker').change(function(){
  var kode_satker = $('#satker').val();

  $.ajax({
    type: "post",
    url: '../core/transaksi/prosestransaksi',
    data: {manage:'get_bidang_report',kode_satker:kode_satker,kode_ruang:""},
      success: function (output) {
          $('#kd_ruang').html(output);
    }
  });
});


      $("#satker").select2({
      placeholder: "-- Masukkan Kode Satker --",
      ajax: {
        url: '../core/report/prosesreport',
        dataType: 'json',
        type: 'post',
        delay: 250,
        data: function (params) {
          return {
            manage:manage_val,
            q: params.term, // search term
            page: params.page
          };
        },
        processResults: function (data, page) {
          return {
            results: data
          };
        },
        cache: true
      },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
      });
    </script>
  </body>
</html>
