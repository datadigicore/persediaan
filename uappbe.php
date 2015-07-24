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
            Unit Akuntansi Pembantu Pengguna Barang - Eselon 1
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel UAPPB-E1</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>  
                <form action="core/uappbe/prosesuappbe" method="post" class="form-horizontal" id="adduappbe">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <select name="kduapb" id="kduapb" class="form-control">
                        </select>
                        <input type="hidden" name="manage" value="adduappbe">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-E1</label>
                      <div class="col-sm-9">
                        <input type="text" name="kduappbe" class="form-control" placeholder="Masukkan Kode UAPPB-E1">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian UAPPB-E1</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmuappbe" class="form-control" placeholder="Masukkan Uraian UAPPB-E1">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabel Data UAPPB-E1</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="18%">Kode UAPB</th>
                        <th width="18%">Kode UAPPB-E1</th>
                        <th>Uraian UAPPB-E1</th>
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
      var table;
      $(function () {
        $("li#uappbe").addClass("active");
        $.ajax({
          type: "post",
          url: 'core/uappbe/prosesuappbe',
          data: {manage:'readuapb'},
          success: function (output) {     
            $('#kduapb').html(output);
          }
        });
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "core/loadtable/loaduappbe",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 }
          ],
        });
        $('#kduapb').change(function(){
          if($(this).val()==''){
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            $("#example1").DataTable({
              "processing": false,
              "serverSide": true,
              "ajax": "core/loadtable/loaduappbe",
              "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
              "columnDefs":
              [
                {"targets": 0 },
                {"targets": 1 },
                {"targets": 2 }
              ],
            });
          }
          else{
            var kduapb = $(this).val();
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            $.ajax({
              type: "post",
              url: 'core/uappbe/prosesuappbe',
              data: {manage:'readtable',kduapb:kduapb},
              success: function (output) {
                var dataoutput = JSON.parse(output);   
                $("#example1").DataTable({
                  "data" : dataoutput
                });
              }
            });
          }
        });
      });
      $('#adduappbe').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "uappbe";
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
