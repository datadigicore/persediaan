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
            Tambah Pengelola
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-user"></i> Tambah Pengelola</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Identitas Pengelola</h3>
                </div>  
                <form action="../core/user/prosesuser" method="post" class="form-horizontal" id="adduser">
                  <div class="box-body">
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
                  <h3 class="box-title">Unit Satker Pengelola</h3>
                </div>  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Unit Satker</label>
                      <div class="col-sm-9">
                        <select name="kdunitgudang" id="kdunitgudang" class="form-control select2">
                          <option value="">-- Pilih Kode Satker--</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Sektor</label>
                      <div class="col-sm-2">
                        <input type="text" name="kdsektor" class="form-control" id="kdsektor" placeholder="Kode Sektor" disabled>
                        <input type="hidden" name="manage" value="adduser">
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="ursektor" class="form-control" id="ursektor" placeholder="Uraian Kode Sektor" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-2">
                        <input type="text" name="kdsatker" class="form-control" id="kdsatker" placeholder="Kode Satker" disabled>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="ursatker" class="form-control" id="ursatker" placeholder="Uraian Kode Satker" disabled>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Unit</label>
                      <div class="col-sm-2">
                        <input type="text" name="kdunit" class="form-control" id="kdunit" placeholder="Kode Unit" disabled>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="urunit" class="form-control" id="urunit" placeholder="Uraian Kode Unit" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Gudang</label>
                      <div class="col-sm-2">
                        <input type="text" name="kdgudang" class="form-control" id="kdgudang" placeholder="Kode Gudang" disabled>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="urgudang" class="form-control" id="urgudang" placeholder="Uraian Kode Gudang" disabled>
                        <input type="hidden" name="urgudangh" class="form-control" id="urgudangh">
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
                  <h3 class="box-title">Tabel Data Pengelola</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="16%">Username</th>
                        <th>Email</th>
                        <th width="14%">Kode Satker</th>
                        <th width="26%">Nama Satker</th>
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
      var table;
      $(function () {
        $("li#user").addClass("active");
        $(".select2").select2();
        table = $("#example1").DataTable({
          "oLanguage": {
            "sInfoFiltered": ""
          },
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
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        kdsektor_row = row.data()[1];
        kdsatker_row  = row.data()[2];
        kdunit_row  = row.data()[3];
        kdgudang_row  = row.data()[4];
        kdruang_row  = row.data()[5];
        nmruang_row  = row.data()[6];
        if ( row.child.isShown() ) {
          $('div.slider', row.child()).slideUp( function () {
            row.child.hide();
            tr.removeClass('shown');
          });
        }
        else {
          row.child( format(row.data())).show();
          tr.addClass('shown');
          $('div.slider', row.child()).slideDown();
          $("#kdsektor"+id_row+"").val(kdsektor_row);
          $("#kdsatker"+id_row+"").val(kdsatker_row);
          $("#kdunit"+id_row+"").val(kdunit_row);
          $("#kdgudang"+id_row+"").val(kdgudang_row);
          $("#kdruang"+id_row+"").val(kdruang_row);
          $("#nmruang"+id_row+"").val(nmruang_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "user";
      id_row = row.data()[0];
      managedata = "deluser";
      job=confirm("Anda yakin ingin menghapus data ini?");
        if(job!=true){
          return false;
        }
        else{
          $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
          });
          $('#myModal').modal('show');
          $.ajax({
            type: "post",
            url : "../core/user/prosesuser",
            data: {manage:managedata,id:id_row},
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
        }
      });
      $.ajax({
        type: "post",
        url: '../core/user/prosesuser',
        data: {manage:'readsatker'},
        success: function (output) {     
          $('#kdunitgudang').html(output);
        }
      });
      $('#kdunitgudang').change(function(){
        if ($(this).val()=='') {
          $('#kdsektor').val('');
          $('#kdsatker').val('');
          $('#kdunit').val('');
          $('#ursektor' ).val('');
          $('#ursatker').val('');
          $('#urunit').val('');
        }
        else {
          var kdunitgudang = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/user/prosesuser',
            data: {manage:'readdata',kdunitgudang:kdunitgudang},
            dataType: "json",
            success: function (output) {
            $('#kdsektor').val(output.kdsektor);
            $('#kdsatker').val(output.kdsatker);
            $('#kdunit').val(output.kdunit);
            $('#kdgudang').val(output.kdgudang);
            $('#ursektor' ).val(output.ursektor);
            $('#ursatker').val(output.ursatker);
            $('#urunit').val(output.urunit);
            $('#urgudang').val(output.urgudang);
            $('#urgudangh').val(output.urgudang);
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
