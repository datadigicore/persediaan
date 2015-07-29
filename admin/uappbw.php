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
            Unit Akuntansi Pembantu Pengguna Barang - Wilayah
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel UAPPB-Wilayah</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>  
                <form action="core/uappbw/prosesuappbw" method="post" class="form-horizontal" id="adduappbw">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="adduappbw">
                        <select name="kduapb" id="kduapb" class="form-control">
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
                      <label class="col-sm-2 control-label">Kode UAPPB-W</label>
                      <div class="col-sm-9">
                        <select name="kduappbw" id="kodewil" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian UAPPB-W</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmuappbw" class="form-control" id="nmuappbw" placeholder="Masukkan Uraian UAPPB-E1">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Tabel Data UAPPB-W</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">UAPB</th>
                        <th width="14%">UAPPB-E1</th>
                        <th width="14%">UAPPB-W</th>
                        <th>Uraian UAPPB-W</th>
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
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("li#uappbw").addClass("active");
        $.ajax({
          type: "post",
          url: 'core/uappbw/prosesuappbw',
          data: {manage:'readuapb'},
          success: function (output) {     
            $('#kduapb').html(output);
          }
        });
        $.ajax({
          type: "post",
          url: 'core/uappbw/prosesuappbw',
          data: {manage:'readwil'},
          success: function (output) {     
            $('#kodewil').html(output);
          }
        });
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "core/loadtable/loaduappbw",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 }
          ],
        });
      });
      $('#kduapb').change(function(){
        if ($(this).val()=='') {
          $('#kodeuappbe').html('<option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>');
        }
        else {
          var kduapb = $(this).val();
          $.ajax({
            type: "post",
            url: 'core/uappbw/prosesuappbw',
            data: {manage:'readuappbe',kduapb:kduapb},
            success: function (output) {
              $('#kodeuappbe').html(output);
            }
          });
        }
      });
      $('#adduappbw').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "uappbw";
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
