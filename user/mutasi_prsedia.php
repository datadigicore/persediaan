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
                  <h3 class="box-title">Mutasi Persediaan </h3>
                </div>  
                <form action="../core/report/prosesreport" method="post" class="form-horizontal" id="addtransmsk">
                   <input type="hidden" name="manage" value="mutasi">
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-4">
                        <select name="satker" id="satker" class="form-control">
                        </select>
                      </div>
                    </div>

                    <div class="box-body" id="awal">
                      <label class="col-sm-2 control-label">Tanggal Awal</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="" >
                        </select>
                      </div>
                    </div>   
                    <div class="box-body" id="akhir">
                      <label class="col-sm-2 control-label">Tanggal Akhir</label>
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
                          <option value="pdf">PDF</option>
                          <option value="excel">Excel</option>
                        </select>
                      </div>
                    </div>  
                  <div class="box-footer">
                    <!-- <button type="Reset" class="btn btn-default">Reset</button> -->
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
        $("li#mutasi_prsedia").addClass("");
        $('#tgl_awal').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_akhir').datepicker({
          format: "dd-mm-yyyy"
        });             
      });

      $.ajax({
          type: "post",
          url: '../core/report/prosesreport',
          data: {manage:'baca_satker'},
          success: function (output) {     
            $('#satker').html(output);
          }
       });

      $('form').on('submit', function() {
        var D1a = document.getElementById("tgl_awal").value;
        var D2a = document.getElementById("tgl_akhir").value;

        var arrD1 = D1a.split("-");
        var arrD2 = D2a.split("-");

        var D1b = [arrD1[2],arrD1[1],arrD1[0]];
        var D2b = [arrD2[2],arrD2[1],arrD2[0]];

        var D1 = D1b.join("/");
        var D2 = D2b.join("/");

        if(document.getElementById("satker").value=="")
        {
            alert("Kode Satker Belum Dipilih");
            return false;
        }

      if( (new Date(D1).getTime() > new Date(D2).getTime()))
      {
        alert("Tanggal Awal Tidak Boleh Lebih Besar dari Tanggal Akhir");
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
