<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue layout-boxed">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Transaksi Keluar
            <small>Habis Pakai</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i>Detil Transaksi</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                   <a href="trans_klr" class="btn btn-primary  btn-s">1. Dokumen</a> 
                   <a href="brg_klr" class="btn btn-primary  btn-s">2. Barang</a> 
                </div>
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Barang</h3>
                </div>  
                <form action="../core/transaksi/prosestransklr" method="post" class="form-horizontal" id="addtransm">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nomor Dokumen</label>
                      <div class="col-sm-9">
                        <select name="no_dok" id="no_dok" class="form-control">
                        </select>
                        <input type="hidden" name="manage" value="tbhbrgmsk">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Barang</label>
                      <div class="col-sm-9">
                        <select name="kd_brg" id="kd_brg" class="form-control">
                        </select>
                      </div>
                    </div>
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Jumlah Keluar</label>
                      <div class="col-sm-9">
                        <input type="text" name="jml_msk" class="form-control" id="jml_msk" >
                      </div>
                    </div>                  
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Harga Beli Satuan</label>
                      <div class="col-sm-9">
                        <input type="text" name="rph_sat" class="form-control" id="rph_sat" disabled>
                      </div>
                    </div>                  

                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Saldo Masuk</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="10%">ID</th>
                        <th>Nomor Dokumen</th>
                        <th>Kode Barang</th>
                        <th>Jumah Barang</th>
                        <th>Harga Satuan</th>
                      </tr>
                    </thead>
                  </table>
                </div>
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
    <script type="text/javascript">
      $(function () {
        $("li#saldo_awal").addClass("active");
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadbrgmsk",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 }

          ],
        });
      });
       $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransklr',
          data: {manage:'readdok'},
          success: function (output) {     
            $('#no_dok').html(output);
          }
       });
       $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransklr',
          data: {manage:'readbrg'},
          success: function (output) {     
            $('#kd_brg').html(output);
          }
       });       

      $('#addtransmsk').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "saldo_msk";
        var formURL = $(this).attr("action");
        var addData = new FormData(this);
        $.ajax({
          type: "post",
          data: addData,
          url : formURL,
          contentType: false,
          cache: false,  
          processData: false,
          success: function(data)
          {
            $("#success-alert").alert();
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
            });
            setTimeout("location.href = redirectURL;",redirectTime); 
          }
        });
        return false;
      });
    </script>
  </body>
</html>
