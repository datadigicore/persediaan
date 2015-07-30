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
            Persediaan Masuk
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i>Daftar Transaski Saldo Awal</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Transaksi Saldo Awal</h3>
                </div>  
                <form action="core/transaksi/prosestransmsk" method="post" class="form-horizontal" id="addtrfmsk">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nomor Dokumen</label>
                      <div class="col-sm-9">
                        <input type="text" name="no_dok" class="form-control" id="no_dok" placeholder="Seharsnya No. Dok Auto Generated">
                        <input type="hidden" name="manage" value="addtransmsk">
                      </div>
                    </div> 
                    <div class="form-group">                     
                    <label class="col-sm-2 control-label">Nomor Bukti</label>
                      <div class="col-sm-9">
                        <input type="text" name="no_bukti" class="form-control" id="no_bukti" placeholder="Masukkan Nomor BUkti">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                      <div class="col-sm-9">
                        <input type="text" name="tgl_dok" class="form-control" id="tgl_dok" placeholder="Masukkan Tanggal Dokumen">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Buku</label>
                      <div class="col-sm-9">
                        <input type="text" name="tgl_buku" class="form-control" id="tgl_buku" placeholder="Masukkan Tanggal Buku">
                      </div> 
                    </div>  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Organisasi Pengirim</label>
                      <div class="col-sm-9">
                        <select name="kduakpb" id="kduakpb" class="form-control">
                          <option value="">-- Pilih Kode UAKPB --</option>
                        </select>
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
                      <label class="col-sm-2 control-label">Jumlah Masuk</label>
                      <div class="col-sm-9">
                        <input type="text" name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah Masuk">
                      </div>
                    </div>                  
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Harga Beli Satuan</label>
                      <div class="col-sm-9">
                        <input type="text" name="rph_sat" class="form-control" id="rph_sat" placeholder="Masukkan Jumlah Masuk">
                      </div>
                    </div>                  
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Keterangan</label>
                      <div class="col-sm-9">
                        <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan">
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
                        <th width="14%">Kode UAPB</th>
                        <th>Uraian UAPB</th>
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
        $("li#trf_msk").addClass("active");
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loaduapb",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 }
          ],
        });
      });
       $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransmsk',
          data: {manage:'readbrg'},
          success: function (output) {     
            $('#kd_brg').html(output);
          }
       });       
       $.ajax({
          type: "post",
          url: '../core/uakpb/prosesuakpb',
          data: {manage:'readuakpb'},
          success: function (output) {     
            $('#kduakpb').html(output);
          }
       });
      $('#addtrfmsk').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "trf_msk";
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
