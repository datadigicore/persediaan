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
                  <h3 class="box-title">Identitas User</h3>
                </div>  
                <form action="../core/user/prosesuser" method="post" class="form-horizontal" id="adduser">
                  <div class="box-body">
                    <!-- <div class="form-group">
                      <label class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Masukkan Nama Lengkap">
                        <input type="hidden" name="manage" value="adduser">
                      </div>
                    </div> -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Username</label>
                      <div class="col-sm-9">
                        <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Re-type Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="konf_pass" class="form-control" id="konf_pass" placeholder="Konfirmasi Ulang Pasword">
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
                  <h3 class="box-title">Lokasi User</h3>
                </div>  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-9">
                        <select name="kdsatker" id="kdsatker" class="form-control select2">
                          <option value="">-- Pilih Kode Satker--</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">UAPB</label>
                      <div class="col-sm-2">
                        <input type="text" name="kduapb" class="form-control" id="kduapb" placeholder="Kode UAPB" disabled>
                        <input type="hidden" name="manage" value="adduser">
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="uruapb" class="form-control" id="uruapb" placeholder="Uraian Kode UAPB" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">UAPPB-E1</label>
                      <div class="col-sm-2">
                        <input type="text" name="kduappbe" class="form-control" id="kduappbe" placeholder="Kode UAPPB-E1" disabled>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="uruappbe" class="form-control" id="uruappbe" placeholder="Uraian Kode UAPPB-E1" disabled>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">UAPPB-W</label>
                      <div class="col-sm-2">
                        <input type="text" name="kduappbw" class="form-control" id="kduappbw" placeholder="Kode UAPPB-Wilayah" disabled>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="uruappbw" class="form-control" id="uruappbw" placeholder="Uraian Kode UAPPB-Wilayah" disabled>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode JK</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdjk" class="form-control" id="kdjk" placeholder="Kode Jenis Kewenangan" disabled>
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
                        <th>ID</th>
                        <th width="5%">ID</th>
                        <th width="16%">Username</th>
                        <th>Email</th>
                        <th width="20%">Kode Satker</th>
                        <th width="9%">Aksi</th>
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
        $(".select2").select2();
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loaduser",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [5],"targets": 5 }
          ],
          "order": [[ 1, "asc" ]]
        });
      });
      $.ajax({
        type: "post",
        url: '../core/user/prosesuser',
        data: {manage:'readsatker'},
        success: function (output) {     
          $('#kdsatker').html(output);
        }
      });
      $('#kdsatker').change(function(){
        if ($(this).val()=='') {
          alert("Kode Satker Null");
        }
        else {
          var kdsatker = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/user/prosesuser',
            data: {manage:'readdata',kdsatker:kdsatker},
            dataType: "json",
            success: function (output) {
            $('#kduapb').val(output.kduapb);
            $('#kduappbe').val(output.kduappbe);
            $('#kduappbw').val(output.kduappbw);
            $('#kdjk').val(output.kdjk);
            $('#uruapb' ).val(output.uruapb);
            $('#uruappbe').val(output.uruappbe);
            $('#uruappbw').val(output.uruappbw);
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
