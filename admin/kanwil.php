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
            Daftar Kantor Wilayah
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><i class="fa fa-link"></i> Lain - lain</li>
            <li class="active"><a href="#"><i class="fa fa-table"></i> Kantor Wilayah</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>  
                <form action="../core/kanwil/proseskanwil" method="post" class="form-horizontal" id="addkanwil">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="addkanwil">
                        <select name="kduapb" id="kduapb" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-E1</label>
                      <div class="col-sm-9">
                        <select name="kduappbe" id="kduapbbe" class="form-control">
                          <option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Kanwil</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdkanwil" class="form-control" id="kdkanwil" placeholder="Masukkan Kode Kanwil">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian Kanwil</label>
                      <div class="col-sm-9">
                        <input type="text" name="urkanwil" class="form-control" id="urkanwil" placeholder="Masukkan Uraian Kantor Wilayah">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>   
              </div>
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Tabel Daftar Kantor Wilayah</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">Kode UAPB</th>
                        <th width="18%">Kode UAPPB-E1</th>
                        <th width="14%">Kode Kanwil</th>
                        <th>Uraian Kantor Wilayah</th>
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
        $(".treeview").addClass("active");
        $("li#kanwil").addClass("active");
        table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadkanwil",
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
        kduappbe_row = row.data()[1];
        kdkanwil_row = row.data()[2];
        urkanwil_row  = row.data()[3];
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
          $("#kduapb"+kduapb_row+kduappbe_row+kdkanwil_row+"").val(kduapb_row);
          $("#kduappbe"+kduapb_row+kduappbe_row+kdkanwil_row+"").val(kduappbe_row);
          $("#kdkanwil"+kduapb_row+kduappbe_row+kdkanwil_row+"").val(kdkanwil_row);
          $("#urkanwil"+kduapb_row+kduappbe_row+kdkanwil_row+"").val(urkanwil_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "kanwil";
      kduapb_row = row.data()[0];
      kduappbe_row = row.data()[1];
      kdkanwil_row = row.data()[2];
      managedata = "delkanwil";
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
            url : "../core/kanwil/proseskanwil",
            data: {manage:managedata,kduapb:kduapb_row,kduappbe:kduappbe_row,kdkanwil:kdkanwil_row},
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
        '<form action="../core/kanwil/proseskanwil" method="post" class="form-horizontal" id="updkanwil">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updkanwil">'+
              '<input type="hidden" name="updiduapb" value="'+d[0]+'">'+
              '<input type="hidden" name="updiduappbe" value="'+d[1]+'">'+
              '<input type="hidden" name="updidkanwil" value="'+d[2]+'">'+
              '<td width="14%"><input style="width:90%" id="kduapb'+d[0]+d[1]+d[2]+'" name="updkduapb" class="form-control" type="text" placeholder="Kode UAPB"></td>'+
              '<td width="18.5%"><input style="width:92%" id="kduappbe'+d[0]+d[1]+d[2]+'" name="updkduappbe" class="form-control" type="text" placeholder="Kode UAPPB-E1"></td>'+
              '<td width="14%"><input style="width:90%" id="kdkanwil'+d[0]+d[1]+d[2]+'" name="updkdkanwil" class="form-control" type="text" placeholder="Kode Kanwil"></td>'+
              '<td><input style="width:96%" id="urkanwil'+d[0]+d[1]+d[2]+'" name="updurkanwil" class="form-control" type="text" placeholder="Uraian Kantor Wilayah"></td>'+
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
      $(document).on('submit', '#updkanwil', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "kanwil";
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
      $.ajax({
        type: "post",
        url: '../core/kanwil/proseskanwil',
        data: {manage:'readuapb'},
        success: function (output) {     
          $('#kduapb').html(output);
        }
      });
      $('#kduapb').change(function(){
        if ($(this).val()=='') {
          $('#kduapbbe').html('<option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>');
        }
        else {
          var kduapb = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/kanwil/proseskanwil',
            data: {manage:'readuappbe',kduapb:kduapb},
            success: function (output) {
              $('#kduapbbe').html(output);
            }
          });
        }
      });
      $('#addkanwil').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "kanwil";
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
