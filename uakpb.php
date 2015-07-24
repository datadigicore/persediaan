<?php include("config/app.php"); ?>
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
            Unit Akuntansi Kuasa Pengguna Barang
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel UAKPB</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>
                <form action="core/uakpb" method="post" class="form-horizontal" id="adduakpb">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="adduakpb">
                        <select name="kduapb" id="kodeuapb" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-E1</label>
                      <div class="col-sm-9">
					              <select name="kduappbe" id="kodeuappbe" class="form-control">
                          <option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPBW</label>
                      <div class="col-sm-9">
                        <select name="kduappbw" id="kodeuappbw" class="form-control">
                          <option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodeuakpb" class="form-control" id="kodeuakpb" placeholder="Masukkan Uraian UAKPB">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodeuapkpb" class="form-control" id="kodeuapkpb" placeholder="Masukkan Kode UA">
                      </div>
                    </div>
					          <div class="form-group">
                      <label class="col-sm-2 control-label">Kode JK</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodeJK" class="form-control" id="kodeJK" placeholder="Masukkan Kode JK">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian UAKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="uraianuakpb" class="form-control" id="uraianuakpb" placeholder="Masukkan Uraian UAKPB">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form> 
              </div>
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tabel Data UAKPB</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="10%">UAPB</th>
                        <th width="10%">UAPPBE1</th>
                        <th width="10%">UAPPBW</th>
                        <th width="10%">UAKPB</th>
                        <th width="10%">UAPKPB</th>
                        <th width="10%">JK</th>
                        <th>Uraian UAKPB</th>
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
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("li#uakpb").addClass("active");
        $.ajax({
          type: "post",
          url: 'core/uakpb',
          data: {manage:'readuapb'},
          success: function (output) {     
            $('#kodeuapb').html(output);
          }
        });
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "core/loadtable/loaduakpb",
          "columnDefs":
          [
            {"targets": 0 },
      			{"targets": 1 },
      			{"targets": 2 },
      			{"targets": 3 },
      			{"targets": 4 },
      			{"targets": 5 },
      			{"targets": 6 }
          ],
        });
      });
      $('#kodeuapb').change(function(){
        if ($(this).val()=='') {
          $('#kodeuappbe').html('<option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>');
          $('#kodeuappbw').html('<option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>');
        }
        else {
          var kduapb = $(this).val();
          $.ajax({
            type: "post",
            url: 'core/uakpb',
            data: {manage:'readuappbe',kodeuapb:kduapb},
            success: function (output) {
              $('#kodeuappbe').html(output);
            }
          });
        }
      });
      $('#kodeuappbe').change(function(){
        if ($(this).val()=='') {
          $('#kodeuappbw').html('<option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>');
        }
        else {
          var kduapb = $('#kodeuapb').val();
          var kduappbe = $(this).val();
          $.ajax({
            type: "post",
            url: 'core/uakpb',
            data: {manage:'readuappbw',kodeuapb:kduapb,kodeuappbe:kduappbe},
            success: function (output) {
              $('#kodeuappbw').html(output);
            }
          });
        }
      });
    </script>
  </body>
</html>
