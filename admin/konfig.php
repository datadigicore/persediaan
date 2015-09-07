<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue layout-boxed">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Tambah Aktif
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-gear"></i> Tambah Aktif</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <?php include("include/tabkonfig.php"); ?>
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Tahun Aktif</h3>
                </div>  
                <form action="../core/konfig/proseskonfigurasi" method="post" class="form-horizontal" id="addkonfig">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tahun</label>
                      <div class="col-sm-9">
                        <input type="text" name="thnaktif" class="form-control" id="thnaktif" placeholder="Masukkan Tahun">
                        <input type="hidden" name="manage" value="addthnaktif">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Keterangan</label>
                      <div class="col-sm-9">
                        <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-9">
                        <label>
                          <input type="checkbox" name="status" class="minimal" value="1"/>
                        </label>
                        &nbsp;&nbsp;Sebagai Tahun Aktif
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
                        <th width="12%">Tahun</th>
                        <th width="64%">Keterangan</th>
                        <th>status</th>
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
    <script src="../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      var table;
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
      });
      $(function () {
        $("li#konfig").addClass("active");
        $("li.konfig").addClass("active");
        $("li.konfig>a").append('<i class="fa fa-angle-down pull-right" style="margin-top:3px;"></i>');
        $(".select2").select2();
        table = $("#example1").DataTable({
          "oLanguage": {
            "sInfoFiltered": ""
          },
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/tablethnaktif",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [4],"targets": 4 }
          ],
          "order": [[ 1, "asc" ]]
        });
      });
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        konfigname_row = row.data()[1];
        email_row  = row.data()[2];
        kdsatker_row  = row.data()[3];
        nmsatker_row  = row.data()[4];
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
          $("#konfigname"+id_row+"").val(konfigname_row);
          $("#email"+id_row+"").val(email_row);
          $("#kdsatker"+id_row+"").val(kdsatker_row);
          $("#nmsatker"+id_row+"").val(nmsatker_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "konfig";
      id_row = row.data()[0];
      managedata = "delkonfig";
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
            url : "../core/konfig/proseskonfigurasi",
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
            url: '../core/konfig/proseskonfig',
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
              if (kdunitgudang.length == 2) {
                $('#urgudangh').val(output.ursektor);
              }
              else if (kdunitgudang.length == 5) {
                $('#urgudangh').val(output.ursatker);
              }
              else if (kdunitgudang.length == 8) {
                $('#urgudangh').val(output.urunit);
              }
              else {
                $('#urgudangh').val(output.urgudang);
              }
            }
          });
        }
      });
      $(document).on('submit', '#updkonfig', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "konfig";
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
      $(document).on("change", "#checkpass", function(){
        var passwordcheck = document.getElementById("#updpassword");
        if(this.checked){
          document.getElementById("updpassword").removeAttribute("disabled");
        }
        else {
          document.getElementById("updpassword").setAttribute("disabled","disabled");
        }
      });
      $('#addkonfig').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "konfig";
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
