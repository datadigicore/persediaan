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
            Nama Rekening Barang Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li><i class="fa fa-link"></i> Lain - lain</li>
            <li class="active"><a href="#"><i class="fa fa-table"></i> Nama Rekening Barang</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data Nama Rekening Barang</h3>
                </div>  
                <form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="addbarang">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Kode Rekening</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdrekening" class="form-control" id="kdbarang" placeholder="Masukkan Kode Rekening Barang">
                        <input type="hidden" name="manage" value="addrekbarang">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Rekening</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmrekening" class="form-control" id="nmbarang" placeholder="Masukkan Nama Rekening Barang">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tabel Sub Kelompok Barang Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="4%">Kode Rekening</th>
                        <th width="16%">Nama Rekening</th>
                        <th width="1%">Aksi</th>
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
    <script src="../dist/js/jquery.mask.js" ></script>
    <script type="text/javascript">
      var table;
      function myTable() {
      table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadrekbar",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="row-fluid">'+
                                  '<button id="btnedit" class="col-xs-12 btn btn-edit btn-xs btn-flat"><i class="fa fa-edit"></i> Ubah Jenis</button>'+
                                  '<button id="btnhps" class="col-xs-12 btn btn-danger btn-xs btn-flat"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [3],"targets": 3 }
          ],
          "order": [[ 0, "desc" ]],
          "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
        });
      }
      $(function () {
        $(".treeview").addClass("active");
        $("li#rekbar").addClass("active");
        myTable();
        $(document).on("click", "#btnedt", function(){
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          id_row = row.data()[0];
          kdbarang_row = row.data()[1];
          urbarang_row  = row.data()[2];
          spesifikasi_row  = row.data()[3];
          satuan_row  = row.data()[4];
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
            $("#kdbarang"+id_row+"").val(kdbarang_row);
            $("#urbarang"+id_row+"").val(urbarang_row);
            $("#spesifikasi"+id_row+"").val(spesifikasi_row);
            $("#satuan"+id_row+"").val(satuan_row);
          }
        });
        $(document).on("click", "#btnedit", function(){
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          id_row = row.data()[0];
          kdbarang_row = row.data()[1];
          urbarang_row  = row.data()[2];
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
            $("#kdbarang"+id_row+"").val(kdbarang_row);
            $("#urbarang"+id_row+"").val(urbarang_row);
          }
        });
        $(document).on('click', '#btnhps', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          redirectTime = "1000";
          id_row = row.data()[0];
          id_barang = row.data()[1];
          ur_barang = row.data()[2];
          managedata = "delrekbarang";
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
                url : "../core/barang/prosesbarang",
                data: {manage:managedata,id:id_row,idbrg:id_barang,urbrg:ur_barang},
                success: function(data)
                {
                  $("#success-alert").alert();
                  $("#success-alert").fadeTo(500, 500).slideUp(500, function(){
                  $("#success-alert").alert('close');
                  });
                  setTimeout("$('#myModal').modal('hide');",redirectTime);
                  $("#example1").DataTable().destroy();
                  $("#example1 tbody").empty();
                  myTable();
                }
              });
              return false;
            }
          });
      });
       $.ajax({
          type: "post",
          url: '../core/barang/prosesbarang',
          data: {manage:'readbarang'},
          success: function (output) {     
            $('#kdbarang_no').html(output);
          }
       });
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="updbarang">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updrekbarang">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<td width="17.5%"><input style="width:95%" id="kdbarang'+d[0]+'" name="kd_perk" class="form-control" type="text" placeholder="Kode Barang"></td>'+
              '<td width="60%"><input style="width:97%" id="urbarang'+d[0]+'" name="nm_perk" class="form-control" type="text" placeholder="Uraian Barang"></td>'+
              '<td style="vertical-align:middle; width:12%;">'+
                '<div class="box-tools">'+
                  '<button id="btnrst" class="btn btn-flat btn-sm btn-warning btn-sm pull-right" type="reset"><i class="fa fa-refresh"></i> Reset</button>'+
                  '<button id="btnupd" class="btn btn-flat btn-sm btn-primary btn-sm pull-right"><i class="fa fa-upload"></i> Update</button>'+
                '</div>'
              '</td>'+
           '</tr>'+
        '</table>'+
        '</form></div>';  
      }
      $(document).on('submit', '#updjenis', function (e) {
        redirectTime = "1000";
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
            $("#success-alert").fadeTo(500, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
            });
            setTimeout("$('#myModal').modal('hide');",redirectTime);
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            myTable();
          }
        });
        return false;
      });

      $(document).on('submit', '#updbarang', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "1000";
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
            $("#success-alert").fadeTo(500, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
            });
            setTimeout("$('#myModal').modal('hide');",redirectTime);
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            myTable();
          }
        });
        return false;
      });
      $('#addbarang').submit(function(e){
        if($("#kdbarang").val()=="")
        {
          alert("Kode Barang Belum di Input");
          return false;
        }
        if($("#nmbarang").val()=="")
        {
          alert("Nama Barang Belum di Input");
          return false;
        }
        else{
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "1000";
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
            $("#success-alert").fadeTo(500, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
            });
            setTimeout("$('#myModal').modal('hide');",redirectTime);
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            myTable();
          }
        });
        return false;
        }
      });
    </script>
  </body>
</html>
