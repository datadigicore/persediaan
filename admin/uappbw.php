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
                <form action="../core/uappbw/prosesuappbw" method="post" class="form-horizontal" id="adduappbw">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="adduappbw">
                        <select name="kduapb" id="kduapb" class="form-control select2">
                          <option value="">-- Pilih Kode UAPB --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-E1</label>
                      <div class="col-sm-9">
                        <select name="kduappbe" id="kodeuappbe" class="form-control select2">
                          <option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-W</label>
                      <div class="col-sm-9">
                        <select name="kduappbw" id="kodewil" class="form-control select2">
                          <option value="">-- Pilih Kode Wilayah --</option>
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
        $("li#uappbw").addClass("active");
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/uappbw/prosesuappbw',
          data: {manage:'readuapb'},
          success: function (output) {     
            $('#kduapb').html(output);
          }
        });
        $.ajax({
          type: "post",
          url: '../core/uappbw/prosesuappbw',
          data: {manage:'readwil'},
          success: function (output) {     
            $('#kodewil').html(output);
          }
        });
        table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loaduappbw",
          "columnDefs":
          [
            {"targets": 0 },
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
        });
      });
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        kduapb_row = row.data()[0];
        kduappbe_row  = row.data()[1];
        kduappbw_row  = row.data()[2];
        uruappbw_row  = row.data()[3];
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
          $("#kduapb"+kduapb_row+kduappbe_row+kduappbw_row+"").val(kduapb_row);
          $("#kduappbe"+kduapb_row+kduappbe_row+kduappbw_row+"").val(kduappbe_row);
          $("#kduappbw"+kduapb_row+kduappbe_row+kduappbw_row+"").val(kduappbw_row);
          $("#uruappbw"+kduapb_row+kduappbe_row+kduappbw_row+"").val(uruappbw_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "uappbw";
      kduapb_row = row.data()[0];
      kduappbe_row = row.data()[1];
      kduappbw_row = row.data()[2];
      managedata = "deluappbw";
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
            url : "../core/uappbw/prosesuappbw",
            data: {manage:managedata,kduapb:kduapb_row,kduappbe:kduappbe_row,kduappbw:kduappbw_row},
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
        '<form action="../core/uappbw/prosesuappbw" method="post" class="form-horizontal" id="upduappbw">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="upduappbw">'+
              '<input type="hidden" name="iduapb" value="'+d[0]+'">'+
              '<input type="hidden" name="iduappbe" value="'+d[1]+'">'+
              '<input type="hidden" name="iduappbw" value="'+d[2]+'">'+
              '<td width="14%"><input style="width:90%" id="kduapb'+d[0]+d[1]+d[2]+'" name="updkduapb" class="form-control" type="text" placeholder="Kode UAPB"></td>'+
              '<td width="14.2%"><input style="width:90%" id="kduappbe'+d[0]+d[1]+d[2]+'" name="updkduappbe" class="form-control" type="text" placeholder="Kode UAPPB-E1"></td>'+
              '<td width="14.2%"><input style="width:90%" id="kduappbw'+d[0]+d[1]+d[2]+'" name="updkduappbw" class="form-control" type="text" placeholder="Kode UAPPB-W"></td>'+
              '<td><input style="width:97%" id="uruappbw'+d[0]+d[1]+d[2]+'" name="upduruappbw" class="form-control" type="text" placeholder="Uraian UAPPB-W"></td>'+
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
      $(document).on('submit', '#upduappbw', function (e) {
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
      $('#kduapb').change(function(){
        if ($(this).val()=='') {
          $('#kodeuappbe').html('<option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>');
          $('#kodeuappbe').val("").trigger("change");
        }
        else {
          var kduapb = $(this).val();
          $('#kodeuappbe').html('<option value="">-- Pilih Kode UAPPB-E1 --</option>');
          $('#kodeuappbe').val("").trigger("change");
          $.ajax({
            type: "post",
            url: '../core/uappbw/prosesuappbw',
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
