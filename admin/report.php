<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <?php include("../config/dbconf.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/datepicker.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue layout-boxed">
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
          </ul>

          <form action="../core/report/prosesreport" method="post" class="form-horizontal">
              <div class="tab-content">
                 <div class="box-body">
                    <label class="col-sm-2 control-label">Kode Satker</label>
                       <div class="col-sm-4">
                          <select name="satker" id="satker" class="form-control">
                          </select>
                        </div>
                  </div> 
                  <div class="tab-pane active" id="lap_persediaan">  
                      <input type="hidden" name="manage" id="manage" value="lap_persediaan">

                  </div>

                  <div class="tab-pane" id="rincian_persediaan">

                  </div>
              </div>
                    <div class="box-body radio">
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="tanggal" value="tanggal">S/d Tanggal</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="semester" value="semester">Semester</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="tahun" value="tahun" checked>Tahun <?php echo $_SESSION['thn_ang'];?></label>
                    </div>                                       
                    <div class="box-body" id="akhir"  style="display: none;">
                      <label class="col-sm-2 control-label">S/d Tanggal</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="">
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
                      <button type="submit" class="btn btn-default">Submit</button>
                  </div>
              </div>
          </form>
        </section>
      </div>
      <?php include("include/footer.php"); ?>
      <?php include("include/success.php"); ?>
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/bootstrap-datepicker.js" type="text/javascript"></script>

    <script type="text/javascript">
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
            break;

            case 'Rincian Persediaan':
              $("#manage").val("rincian");
            break;

            default:

            break;
          }
    });
});

      $("#satker").select2({
      placeholder: "-- Pilih Kode Item Barang --",
      ajax: {
        url: '../core/report/prosesreport',
        dataType: 'json',
        type: 'post',
        delay: 250,
        data: function (params) {
          return {
            manage:'baca_satker_admin',
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
