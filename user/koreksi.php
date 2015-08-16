<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
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
            Koreksi Transaksi Persediaan
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i>Daftar Koreksi Transaksi Masuk</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Dokumen Koreksi</h3>
                </div>  
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="addtransmsk">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Transaksi Persediaan</label>
                      <div class="col-sm-8">
                        <select name="jenis_trans" id="jenis_trans" class="form-control">
                          <option value="">--Pilih Transaksi Persediaan--</option>
                          <option value="M99">Masuk</option>
                          <option value="K99">Keluar</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nomor Dokumen</label>
                      <div class="col-sm-8">
                        <input type="text" name="no_dok" class="form-control" id="no_dok" placeholder="Masukkan No. Dokumen">
                        <input type="hidden" name="manage" value="tbh_koreksi">  
                      </div>
                    </div>

                    <div class="form-group">                     
                    <label class="col-sm-2 control-label">Nomor Bukti</label>
                      <div class="col-sm-8">
                        <input type="text" name="no_bukti" class="form-control" id="no_bukti" placeholder="Masukkan Nomor BUkti">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                      <div class="col-sm-8">
                        <input type="text" name="tgl_dok" class="form-control" id="tgl_dok" placeholder="Masukkan Tanggal Dokumen">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Buku</label>
                      <div class="col-sm-8">
                        <input type="text" name="tgl_buku" class="form-control" id="tgl_buku" placeholder="Masukkan Tanggal Buku">
                      </div> 
                    </div>                   
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Keterangan</label>
                      <div class="col-sm-8">
                        <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Persediaan</label>
                      <div class="col-sm-8">
                        <select name="kd_brg" id="kd_brg" class="form-control">
                        </select>
                      </div>
                    </div>
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Jumlah</label>
                      <div class="col-sm-8">
                        <input type="text" name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah Masuk">
                      </div>
                    </div>                  
                  <div class="form-group">
                      <label class="col-sm-2 control-label">Harga Satuan</label>
                      <div class="col-sm-8">
                        <input type="text" name="rph_sat" class="form-control" id="rph_sat" placeholder="Masukkan Harga Satuan" readonly>
                      </div>
                    </div>                  
                  <div name="detil_transaksi" id="detil_transaksi">

                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Koreksi Transaksi Masuk</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="10%">ID</th>
                        <th width="14%">Nomor Dokumen</th>
                        <th>Tanggal Buku</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Keterangan</th>
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
    <script src="../dist/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("li#koreksi").addClass("active");
        $('#tgl_dok').datepicker({
          format: "yyyy/mm/dd"
        });         
        $('#tgl_buku').datepicker({
          format: "yyyy/mm/dd"
        });             
        $("li#saldo_awal").addClass("active");
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadtransmsk",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 }            

          ],
        });
      });
       $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readbrgmsk'},
          success: function (output) {     
            $('#kd_brg').html(output);
          }
       });
      $('#kd_brg').change(function(){
        if ($(this).val()=='') {
          $('#detil_transaksi').html('<option value="">-- Belum Dicetak --</option>');
        }
        else {
          var kd_brg = $('#kd_brg').val(); 
          var no_dok = $('#no_dok').val(); 
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'baca_detil_trans',kd_brg:kd_brg,no_dok:no_dok},
          success: function (output) {     
            $('#detil_transaksi').html(output);
          }
       });
        }
      });
      $('#jenis_trans').change(function(){
        if ($(this).val()=='M99') {
          document.getElementById("rph_sat").readOnly=false;
        }
        else {
          document.getElementById("rph_sat").readOnly=true;
          $('#rph_sat').val(' ');
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
        redirectURL = "koreksi";
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
