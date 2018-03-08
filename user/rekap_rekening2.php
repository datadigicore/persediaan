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
            Cetak Laporan
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i></a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Laporan Belanja Persediaan Per Rekening</h3>
                </div>  
                <form action="../core/report/prosesreport" method="post" class="form-horizontal" id="addtransmsk">
                   <input type="hidden" name="manage" value="laporan_per_rekening2">
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

                    <div class="box-body">
                      <label class="col-sm-2 control-label">Sampai Dengan Tanggal</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="" required>
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
                          <!-- <option value="pdf">PDF</option> -->
                          <option value="excel">Excel</option>
                        </select>
                      </div>
                    </div><!-- 
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Uraian Per Dokumen</label>
                      <div class="col-sm-4"> 
                        <div class="checkbox">
                          <label><input type="checkbox" name="rinci_per_dok" value="1"></label>
                        </div>
                      </div>
                    </div> -->
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
              </div>
            </section>
          </div>
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
    var table;
      $(function () {
        $(".treeview").addClass("");
        $("li#neraca").addClass("");
        $('#tgl_awal').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_akhir').datepicker({
          format: "dd-mm-yyyy"
        });             
        $('#tgl_cetak').datepicker({
          format: "dd-mm-yyyy"
        });            
        $("li#rekap_rekening2").addClass("");

      });
      $.ajax({
          type: "post",
          url: '../core/report/prosesreport',
          data: {manage:'baca_satker'},
          success: function (output) {     
            $('#satker').html(output);
          }
       });
      function getBidang(kd_satker,kd_ruang){
          $.ajax({
              type: "post",
              url: '../core/transaksi/prosestransaksi',
              data: {manage:'get_bidang_report',kode_satker:kd_satker,kode_ruang:kd_ruang},
              success: function (output) {
                $('#kd_ruang').html(output);
              }
          });
        }

        $('#satker').change(function(){
          kd_satker = $('#satker').val();
          getBidang(kd_satker,'');
        });

        getBidang("<?php echo $_SESSION['kd_lok']; ?>","<?php echo $_SESSION['kd_ruang'] ?>");
      $('form').on('submit', function() {
        if(document.getElementById("satker").value=="")
        {
          alert("Kode Satker Belum Dipilih");
          return false;
        }
        else
        {
          return true;
        }
    });
    </script>
  </body>
</html>
