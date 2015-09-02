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
                   <input type="hidden" name="manage" value="rincian">  
                    <div class="box-body radio">
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="tanggal" value="tanggal">S/d Tanggal</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="semester" value="semester">Semester</label>
                        <label class="col-sm-2 control-label"><input type="radio" name="jenis" id="tahun" value="tahun" checked>Tahun <?php echo $_SESSION['thn_ang'];?></label>
                    </div>                   
                    <div class="box-body" id="awal">
                      <label class="col-sm-2 control-label">Tanggal Awal</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="">
                        </select>
                      </div>
                    </div>   
                    <div class="box-body" id="akhir">
                      <label class="col-sm-2 control-label">Tanggal AKhir</label>
                      <div class="col-sm-4">
                        <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="">
                        </select>
                      </div>
                    </div> 
                    <div class="box-body" id="bln">
                      <label class="col-sm-2 control-label">Semester</label>
                      <div class="col-sm-2">
                        <select name="smt" id="smt" class="form-control">
                          <option value="01-06">Semester 1</option>
                          <option value="07-12">Semester 2</option>
                        </select>
                      </div>
                    </div>
                  <div class="box-footer">
                    <!-- <button type="Reset" class="btn btn-default">Reset</button> -->
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div> 
                </form>
              </div>
              <div class="box box-info">
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
        $("li#mutasi_sedia").addClass("active");
        $("#bln").hide();
        // $("#awal").hide();
        $("#akhir").hide();
        $("li#buku_brg").addClass("active");
        $('#tgl_awal').datepicker({
          format: "yyyy/mm/dd"
        });         
        $('#tgl_akhir').datepicker({
          format: "yyyy/mm/dd"
        });             
       
        $("#bln").hide();
        $("#awal").hide();
        $("#akhir").hide();
        
        $("input[id=tanggal]").click(function()
        {

            $("#bln").hide();
            $("#awal").show();
            $("#akhir").show();
        });

        $("input[id=semester]").click(function()
        {
            $("#bln").show();
            $("#awal").hide();
            $("#akhir").hide();
        });

        $("input[id=tahun]").click(function()
        {
            $("#bln").hide();
            $("#awal").hide();
            $("#akhir").hide();
        });

      });

    </script>
  </body>
</html>
