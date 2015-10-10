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
            Tutup Tahun Persediaan
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
                  <h3 class="box-title">Detail Tutup Tahun Persediaan </h3>
                </div>  
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="addtransmsk" >
                   <input type="hidden" name="manage" value="tutup_tahun">  
                  <div class="box-body">
                      <p>
                        Proses tutup tahun dilakukan untuk menjumlahkan data-data persediaan tahun sebelumnya
                      </p>
                      <p>
                        Setelah proses tutup tahun, data-data persediaan tahun sebelumnya tidak dapat dibuka lagi.
                      </p>
                      <p>
                       Untuk melakukan proses tutup tahun, pilih kode satker yang akan dilakukan tutup tahun, kemudian klik proses.
                      </p>
                    </div>                   
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-8">
                        <select name="satker" id="satker" class="form-control">
                        </select>
                      </div>
                    </div> 
                    <div class="box-footer">
                      <!-- <button type="Reset" class="btn btn-default">Reset</button> -->
                      <button type="submit" class="btn btn-info pull-right">Proses</button>
                    </div>
                  </div>
                </form>
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
      $(".treeview").addClass("active");
      $("li#tutup_tahun").addClass("active");
       $.ajax({
          type: "post",
          url: '../core/report/prosesreport',
          data: {manage:'baca_satker'},
          success: function (output) {     
            $('#satker').html(output);
          }
       });

    $('form').on('submit', function() {



    });

    </script>
  </body>
</html>
