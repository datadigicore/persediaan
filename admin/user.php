<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue layout-boxed">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Tambah Pengelola Baru
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel User UAKPB</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data User UAKPB</h3>
                </div>  
                <form action="../core/user/prosesuser" method="post" class="form-horizontal" id="adduser">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">User Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Masukkan User Name">
                        <input type="hidden" name="manage" value="adduser">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="user_pass" class="form-control" id="user_pass" placeholder="Masukkan Password">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Konfirmasi Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="konf_pass" class="form-control" id="konf_pass" placeholder="Konfirmasi Pasword">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-9">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Masukkan Email">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer" style="padding:0;">
                  </div>
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data User UAKPB</h3>
                </div>  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAKPB</label>
                      <div class="col-sm-9">
                        <select name="kduakpb" id="kduakpb" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">User Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="user_name" class="form-control" id="user_name" placeholder="Masukkan User Name">
                        <input type="hidden" name="manage" value="adduser">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="user_pass" class="form-control" id="user_pass" placeholder="Masukkan Password">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Konfirmasi Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="konf_pass" class="form-control" id="konf_pass" placeholder="Konfirmasi Pasword">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-9">
                        <input type="text" name="email" class="form-control" id="email" placeholder="Masukkan Email">
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
                  <h3 class="box-title">Tabel Data Pengelola</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">Username</th>
                        <th>Email</th>
                        <th>Nama UAKPB</th>
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
        $("li#user").addClass("active");
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loaduser",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 }
          ],
        });
      });
        $.ajax({
          type: "post",
          url: '../core/uakpb/prosesuakpb',
          data: {manage:'readuakpb'},
          success: function (output) {     
            $('#kduakpb').html(output);
          }
        });
      $('#kduakpb').change(function(){
        if ($(this).val()=='') {
          $('#nmuapb').html('<select name="kduakpb" id="kduakpb"</select>');
        }
        else {
          var kduapb = $('#kduapb').val();
          var kduappbe = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/uakpb/prosesuakpb',
            data: {manage:'readuappbw',kduapb:kduapb,kduappbe:kduappbe},
            success: function (output) {
              $('#kduappbw').html(output);
            }
          });
        }
      });
      $('#adduser').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "user";
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
