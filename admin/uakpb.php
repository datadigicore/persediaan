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
                <form action="../core/uakpb/prosesuakpb" method="post" class="form-horizontal" id="adduakpb">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="adduakpb">
                        <select name="kduapb" id="kduapb" class="form-control select2">
                          <option value="">-- Pilih Kode UAPB --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-E1</label>
                      <div class="col-sm-9">
					              <select name="kduappbe" id="kduappbe" class="form-control select2">
                          <option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPBW</label>
                      <div class="col-sm-9">
                        <select name="kduappbw" id="kduappbw" class="form-control select2">
                          <option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="kduakpb" class="form-control" id="kduakpb" placeholder="Masukkan Kode UAKPB">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="kduapkpb" class="form-control" id="kduapkpb" placeholder="Masukkan Kode UAPKPB">
                      </div>
                    </div>
					          <div class="form-group">
                      <label class="col-sm-2 control-label">Kode JK</label>
                      <div class="col-sm-9">
                        <select name="kdjk" id="kdjk" class="form-control">
                          <option value="">-- Pilih Kode Jenis Kantor --</option>
                          <option value="KD">KD  Kantor Daerah</option>
                          <option value="KP">KP  Kantor Pusat</option>
                          <option value="DK">DK  Dekonsentrasi</option>
                          <option value="TP">TP  Tugas Pembantuan</option>
                          <option value="UB">UB  Urusan Bersama</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian UAKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmuakpb" class="form-control" id="nmuakpb" placeholder="Masukkan Uraian UAKPB">
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
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="10%">UAPB</th>
                        <th width="10%">UAPPBE1</th>
                        <th width="10%">UAPPBW</th>
                        <th width="10%">UAKPB</th>
                        <th width="10%">UAPKPB</th>
                        <th width="10%">JK</th>
                        <th>Uraian UAKPB</th>
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
        $("li#uakpb").addClass("active");
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/uakpb/prosesuakpb',
          data: {manage:'readuapb'},
          success: function (output) {     
            $('#kduapb').html(output);
          }
        });
        table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loaduakpb",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false},
            {"targets": 1 },
      			{"targets": 2 },
      			{"targets": 3 },
      			{"targets": 4 },
      			{"targets": 5 },
      			{"targets": 6 },
      			{"targets": 7 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [8],"targets": 8 }
          ],
          "order": [[ 1, "asc" ]]
        });
      });
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        kduapb_row = row.data()[1];
        kduappbe_row  = row.data()[2];
        kduappbw_row  = row.data()[3];
        kduakpb_row  = row.data()[4];
        kduapkpb_row  = row.data()[5];
        kdjk_row  = row.data()[6];
        uruakpb_row  = row.data()[7];
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
          $("#kduapb"+id_row+"").val(kduapb_row);
          $("#kduappbe"+id_row+"").val(kduappbe_row);
          $("#kduappbw"+id_row+"").val(kduappbw_row);
          $("#kduakpb"+id_row+"").val(kduakpb_row);
          $("#kduapkpb"+id_row+"").val(kduapkpb_row);
          $("#kdjk"+id_row+"").val(kdjk_row);
          $("#uruakpb"+id_row+"").val(uruakpb_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "uakpb";
      id_row = row.data()[0];
      managedata = "deluakpb";
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
            url : "../core/uakpb/prosesuakpb",
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
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/uakpb/prosesuakpb" method="post" class="form-horizontal" id="upduakpb">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="upduakpb">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<td width="9.8%"><input style="width:90%" id="kduapb'+d[0]+'" name="updkduapb" class="form-control" type="text" placeholder="UAPB"></td>'+
              '<td width="10.2%"><input style="width:90%" id="kduappbe'+d[0]+'" name="updkduappbe" class="form-control" type="text" placeholder="UAPPB-E1"></td>'+
              '<td width="10.2%"><input style="width:90%" id="kduappbw'+d[0]+'" name="updkduappbw" class="form-control" type="text" placeholder="UAPPB-W"></td>'+
              '<td width="10%"><input style="width:90%" id="kduakpb'+d[0]+'" name="updkduakpb" class="form-control" type="text" placeholder="UAKPB"></td>'+
              '<td width="10.2%"><input style="width:90%" id="kduapkpb'+d[0]+'" name="updkduapkpb" class="form-control" type="text" placeholder="UAPKPB"></td>'+
              '<td width="10.2%"><input style="width:90%" id="kdjk'+d[0]+'" name="updkdjk" class="form-control" type="text" placeholder="JK"></td>'+
              '<td><input style="width:97%" id="uruakpb'+d[0]+'" name="upduruakpb" class="form-control" type="text" placeholder="Uraian UAPPB-W"></td>'+
              '<td style="vertical-align:middle; width:15%;">'+
                '<div class="box-tools">'+
                  '<button id="btnrst" class="btn btn-warning btn-sm pull-left" type="reset"><i class="fa fa-refresh"></i> Reset</button>'+
                  '<button id="btnupd" class="btn btn-primary btn-sm pull-right"><i class="fa fa-upload"></i> Update</button>'+
                '</div>'
              '</td>'+
           '</tr>'+
        '</table>'+
        '</form></div>';
      }
      $(document).on('submit', '#upduakpb', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "uakpb";
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
      $('#kduapb').change(function(){
        if ($(this).val()=='') {
          $('#kduappbe').html('<option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>');
          $('#kduappbw').html('<option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>');
          $('#kduappbe').val("").trigger("change");
          $('#kduappbw').val("").trigger("change");
        }
        else {
          $('#kduappbe').html('<option value="">-- Pilih Kode UAPPB-E1 --</option>');
          $('#kduappbw').html('<option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>');
          $('#kduappbe').val("").trigger("change");
          $('#kduappbw').val("").trigger("change");
          var kduapb = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/uakpb/prosesuakpb',
            data: {manage:'readuappbe',kduapb:kduapb},
            success: function (output) {
              $('#kduappbe').html(output);
            }
          });
        }
      });
      $('#kduappbe').change(function(){
        if ($(this).val()=='') {
          $('#kduappbw').html('<option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>');
          $('#kduappbw').val("").trigger("change");
        }
        else {
          $('#kduappbw').html('<option value="">-- Pilih Kode UAPPB-Wilayah --</option>');
          $('#kduappbw').val("").trigger("change");
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
      $('#adduakpb').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "uakpb";
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
            // setTimeout("location.href = redirectURL;",redirectTime); 
          }
        });
        return false;
      });
    </script>
  </body>
</html>
