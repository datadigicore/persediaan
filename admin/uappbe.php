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
                <form action="../core/uappbe/prosesuappbe" method="post" class="form-horizontal" id="adduappbe">
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
                        <input type="text" name="kduappbe" id="kduappbe" class="form-control" placeholder="Masukkan Kode UAPPB-E1">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian UAPPB-E1</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmuappbe" id="nmuappbe" class="form-control" placeholder="Masukkan Uraian UAPPB-E1">
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
        $("li#uappbe").addClass("active");
        $.ajax({
          type: "post",
          url: '../core/uappbw/prosesuappbw',
          data: {manage:'readuapb'},
          success: function (output) {     
            $('#kduapb').html(output);
          }
        });
        var table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loaduappbe",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [3],"targets": 3 }
          ],
        });
        $(document).on("click", "#btnedt", function(){
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          kduapb_row = row.data()[0];
          kduappbe_row  = row.data()[1];
          uruappbe_row  = row.data()[2];
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
            $("#kduapb"+kduapb_row+kduappbe_row+"").val(kduapb_row);
            $("#kduappbe"+kduapb_row+kduappbe_row+"").val(kduappbe_row);
            $("#uruappbe"+kduapb_row+kduappbe_row+"").val(uruappbe_row);
          }
        });
        $(document).on('click', '#btnhps', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        redirectTime = "2600";
        redirectURL = "uappbe";
        kduapb_row = row.data()[0];
        kduappbe_row = row.data()[1];
        managedata = "deluappbe";
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
              url : "../core/uappbe/prosesuappbe",
              data: {manage:managedata,kduapb:kduapb_row,kduappbe:kduappbe_row},
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
          '<form action="../core/uappbe/prosesuappbe" method="post" class="form-horizontal" id="upduappbe">'+
          '<table width="100%">'+
             '<tr>'+
                '<input type="hidden" name="manage" value="upduappbe">'+
                '<td width="18.5%"><input style="width:90%" id="kduapb'+d[0]+d[1]+'" name="updkduapb" class="form-control" type="text" placeholder="Kode UAPB"></td>'+
                '<td width="18.5%"><input style="width:90%" id="kduappbe'+d[0]+d[1]+'" name="updkduappbe" class="form-control" type="text" placeholder="Kode UAPPB-E1"></td>'+
                '<td><input style="width:96%" id="uruappbe'+d[0]+d[1]+'" name="upduruappbe" class="form-control" type="text" placeholder="Uraian UAPPB-E1"></td>'+
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
        $(document).on('submit', '#upduappbe', function (e) {
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
        $('#kduapb').change(function(){
          if($(this).val()==''){
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            $("#example1").DataTable({
              "processing": false,
              "serverSide": true,
              "ajax": "../core/loadtable/loaduappbe",
              "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
            });
          }
          else{
            var kduapb = $(this).val();
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            $.ajax({
              type: "post",
              url: '../core/uappbe/prosesuappbe',
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
