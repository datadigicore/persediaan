<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
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
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Identitas Pengelola</h3>
                </div>  
                <form action="../core/user/prosesuser" method="post" class="form-horizontal" id="adduser">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Username</label>
                      <div class="col-sm-9">
                        <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username" requiired>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password" required>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Re-type Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="konf_pass" class="form-control" id="konf_pass" placeholder="Konfirmasi Ulang Password" required>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tahun</label>
                      <div class="col-sm-9">
                        <select name="tahun" id="tahun" class="form-control select2">
                          <option selected="selected">-- Pilih Tahun --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer" style="padding:0;">
                  </div>
                <div class="box-header with-border">
                  <h3 class="box-title">Unit Satker Pengelola</h3>
                </div>  
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-9">
                        <select name="kdunitgudang" id="kdunitgudang" class="form-control select2">
                          <option value="">-- Pilih Kode Satker--</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Bidang</label>
                      <div class="col-sm-2">
                        <input type="text" name="kdsektor" class="form-control" id="kdsektor" placeholder="Kode Bidang" disabled>
                        <input type="hidden" name="manage" value="adduser">
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="ursektor" class="form-control" id="ursektor" placeholder="Uraian Kode Bidang" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Unit</label>
                      <div class="col-sm-2">
                        <input type="text" name="kdsatker" class="form-control" id="kdsatker" placeholder="Kode Unit" disabled>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="ursatker" class="form-control" id="ursatker" placeholder="Uraian Kode Unit" disabled>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Sub Unit</label>
                      <div class="col-sm-2">
                        <input type="text" name="kdunit" class="form-control" id="kdunit" placeholder="Kode Sub Unit" disabled>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="urunit" class="form-control" id="urunit" placeholder="Uraian Kode Sub Unit" disabled>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UPB</label>
                      <div class="col-sm-2">
                        <input type="text" name="kdgudang" class="form-control" id="kdgudang" placeholder="Kode UPB" disabled>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="urgudang" class="form-control" id="urgudang" placeholder="Uraian Kode UPB" disabled>
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
              <div class="box box-info">
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
                        <th width="10%">Tahun</th>
                        <th width="13%">Aksi</th>
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
        $.ajax({
          type: "post",
          url: '../core/konfig/proseskonfigurasi',
          data: {manage:'readthn'},
          success: function (output) {     
            $('#tahun').html(output);
          }
        });
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
            {"targets": 5 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="row-fluid">'+
                                  '<button id="btnedt" class="col-xs-6 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                  '<button id="btnhps" class="col-xs-6 btn btn-danger btn-xs btn-flat pull-right"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [6],"targets": 6 }
          ],
          "order": [[ 1, "asc" ]]
        });
      });
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        username_row = row.data()[1];
        email_row  = row.data()[2];
        kdsatker_row  = row.data()[3];
        nmsatker_row  = row.data()[4];
        $.ajax({
          type: "post",
          url: '../core/user/prosesuser',
          data: {manage:'readsatker'},
          success: function (output) {     
            $('#updkdunitgudang').html(output);
          }
        });
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
          $("#username"+id_row+"").val(username_row);
          $("#email"+id_row+"").val(email_row);
          $("#kdsatker"+id_row+"").val(kdsatker_row);
          $("#nmsatker"+id_row+"").val(nmsatker_row);
          $("#updkdunitgudang").select2({
             placeholder: "Ganti Kode Satker",
             allowClear: false
            });
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
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/user/prosesuser" method="post" class="form-horizontal" id="upduser">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="upduser">'+
              '<input type="hidden" name="user_id" value="'+d[0]+'">'+
              '<input type="hidden" id="kdsatker'+d[0]+'" name="kd_lama">'+
              '<td width="16.2%"><input style="width:90%" id="username'+d[0]+'" name="user_name" class="form-control" type="text" placeholder="Username"></td>'+
              '<td width="18.2%"><input style="width:90%" id="email'+d[0]+'" name="user_email" class="form-control" type="text" placeholder="Email"></td>'+
              '<td width="17.7%"><input type="checkbox" id="checkpass" style="margin-top:11px;margin-left:-5px;position:absolute;"><input style="width:90%" id="updpassword" name="user_pass" class="form-control" type="password" placeholder="Password" disabled></td>'+
              '<td width="24.2%"><input type="checkbox" id="checktrans" style="margin-top:11px;margin-left:-5px;position:absolute;z-index:1"><select name="kd_lokasi" id="updkdunitgudang" class="form-control select2" style="width:95%;" disabled><option value="">-- Pilih Kode Satker--</option></select></td>'+
              '<td style="vertical-align:middle; width:14%;">'+
                '<div class="row-fluid">'+
                  '<button id="btnrst" class="col-sm-6 btn btn-flat btn-warning btn-sm pull-left" type="reset"><i class="fa fa-refresh"></i> Reset</button>'+
                  '<button id="btnupd" class="col-sm-6 btn btn-flat btn-primary btn-sm pull-right"><i class="fa fa-upload"></i> Update</button>'+
                '</div>'
              '</td>'+
           '</tr>'+
        '</table>'+
        '</form></div>';
      }
      $(document).on('submit', '#upduser', function (e) {
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
            if (data == 'error') {
              $("#error-alert").alert();
              $("#error-alert").fadeTo(2000, 500).slideUp(500, function(){
              $("#error-alert").alert('close');
              });
              setTimeout("location.href = redirectURL;",redirectTime); 
            }
            else{
              $("#success-alert").alert();
              $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
              $("#success-alert").alert('close');
              });
              setTimeout("location.href = redirectURL;",redirectTime); 
            }
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
      $(document).on("change", "#checktrans", function(){
        var kdunitgudangcheck = document.getElementById("#updkdunitgudang");
        if(this.checked){
          document.getElementById("updkdunitgudang").removeAttribute("disabled");
        }
        else {
          document.getElementById("updkdunitgudang").setAttribute("disabled","disabled");
        }
      });
      $('#adduser').submit(function(e){
        var kode_satker = $("#kdunitgudang").val();
        var tahun = $("#tahun").val();
        var pass1 = $("#password").val();
        var pass2 = $("#konf_pass").val();



        if(kode_satker=="")
        {
          alert("Kode Unit Satker Pengelola Belum Dipilh");
          return false;
        }
        if(tahun=="")
        {
          alert("Tahun Belum Dipilh");
          return false;
        }
        if(pass1!==pass2)
        {
          alert("Konfirmasi Password tidak sama dengan Password");
          return false;
        }
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
