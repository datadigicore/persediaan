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
          <div class="row">
            <section class="col-lg-4 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Jenis Laporan</h3>
                </div>
                <div class="box-body">
                  <button id="lp" class="btn btn-default btn-flat col-sm-12" style="margin:4px auto; text-align:left">Laporan Persediaan</button>
                  <button id="rp" class="btn btn-default btn-flat col-sm-12" style="margin:4px auto; text-align:left">Rincian persediaan</button>
                  <button id="pp" class="btn btn-default btn-flat col-sm-12" style="margin:4px auto; text-align:left">Posisi Persediaan</button>
                  <button id="mp" class="btn btn-default btn-flat col-sm-12" style="margin:4px auto; text-align:left">Mutasi Persediaan</button>
                </div>                   
              </div>
            </section>
            <section class="col-lg-8 connectedSortable">
              <div id="content" class="box box-info">
                <div class="box-header with-border">
                  <h3 id="judul" class="box-title">Laporan Persediaan </h3>
                </div>
                <?php include("read/lap_persediaan.php"); ?>
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
    <script src="read/zscript.js" type="text/javascript"></script>
    <script type="text/javascript">
      var change;
      $("li#laporan").addClass("active");
      $("#lp").css({"border-left":"4px solid #00c0ef"})
      loadScript("read/lap_persediaan.js", changeScript);
      function changeButton(change){
        setActive(change);
        $("#addtransmsk").remove();
        $("#judul").text(change[0]);
        $.ajax({
          url: 'read/'+change[1],
          success: function(html) {
            $("#content").append(html);
          }
        });
      };
      $("#lp").click(function(){
        data = ["Laporan Persediaan","lap_persediaan"];
        changeButton(data);
        loadScript("read/"+data[1]+".js", changeScript);
      });
      $("#rp").click(function(){
        data = ["Rincian Persediaan","rincian_persediaan"];
        changeButton(data);
        loadScript("read/"+data[1]+".js", changeScript);
      });
      $("#pp").click(function(){
        data = ["Posisi Persediaan","neraca"];
        changeButton(data);
        loadScript("read/"+data[1]+".js", changeScript);
      });
      $("#mp").click(function(){
        data = ["Mutasi Persediaan","mutasi_prsedia"];
        changeButton(data);
        loadScript("read/"+data[1]+".js", changeScript);
      });
    </script>
  </body>
</html>
