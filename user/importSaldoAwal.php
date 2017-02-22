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
            Import Saldo Awal
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
                </div>  
                <form action="../core/import/prosesimport" method="post" class="form-horizontal" enctype="multipart/form-data">
                   <input type="hidden" name="manage" value="create">  
                    <div class="box-body">
                      <p>
                        <b>CATATAN :</b>
                        <ul>
                          <li>Fitur ini di Khusus kan untuk Import Saldo Awal</li>
                          <li>Jika Berhasil, maka menu Import File Saldo Awal akan Hilang</li>
                          <li>Pastikan data sudah masuk dengan benar di Menu Transaksi Masuk</li>
                          <li>Keterangan lebih lanjut dapat dilihat dalam File Import Saldo Awal</li>
                          <li>Untuk mendownload Template File Import Saldo Awal <a href="../dist/uploads/ImportSaldoAwal.xls" class="btn btn-warning btn-xs">Klik Disini</a></li>
                        </ul>
                      </p><br>
                      <label class="col-sm-3 control-label">Import Saldo Awal</label>
                      <div class="col-sm-6">
                        <input type="file" id="fileimport" name="fileimport" style="display:none;" required>
                        <a id="selectbtn" class="btn btn-flat btn-success" style="position:absolute;right:16px;">Select File</a>
                        <input type="text" id="filename" class="form-control" placeholder="Pilih File .xls / .xlsx" readonly>
                      </div>
                    </div> 
                    <div class="box-footer">
                      <!-- <button type="Reset" class="btn btn-default">Reset</button> -->
                      <button type="submit" class="btn btn-info pull-right">Proses</button>
                    </div>
                  </div>
                </form>
            </section>
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
      $('#selectbtn').click(function () {
        $("#fileimport").trigger('click');
      });
      $("#fileimport").change(function(){
        $("#filename").attr('value', $(this).val().replace(/C:\\fakepath\\/i, ''));
      });
      $("li#file_import").addClass("");
    </script>
  </body>
</html>
