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
            Satuan Kerja Perangkat Daerah
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel Ruang</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <?php include("include/navtab.php"); ?>
            <section class="col-lg-12 connectedSortable">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data Ruang</h3>
                </div>
                <form action="../core/ruang/prosesruang" method="post" class="form-horizontal" id="addruang">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Unit</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="addruang">
                        <select name="kdunit" id="kdunit" class="form-control select2">
                          <option value="">-- Pilih Kode Unit --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Gudang</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdgudang" class="form-control" id="kdgudang" placeholder="Masukkan Kode Gudang">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Ruang</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdruang" class="form-control" id="kdruang" placeholder="Masukkan Kode Ruang">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian Ruang</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmruang" class="form-control" id="nmruang" placeholder="Masukkan Uraian Ruang">
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
                  <h3 class="box-title">Tabel Data Ruang</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="14%">Kode Sektor</th>
                        <th width="14%">Kode Satker</th>
                        <th width="14%">Kode Unit</th>
                        <th width="14%">Kode Gudang</th>
                        <th width="8%">Ruang</th>
                        <th>Uraian ruang</th>
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
        $("li#skpd").addClass("active");
        $("li.ruang").addClass("active4");
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/ruang/prosesruang',
          data: {manage:'readunit'},
          success: function (output) {     
            $('#kdunit').html(output);
          }
        });
        table = $("#example1").DataTable({
          "oLanguage": {
            "sInfoFiltered": ""
          },
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadruang",
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
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [7],"targets": 7 }
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
      redirectURL = "ruang";
      id_row = row.data()[0];
      managedata = "delruang";
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
            url : "../core/ruang/prosesruang",
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
        '<form action="../core/ruang/prosesruang" method="post" class="form-horizontal" id="updruang">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updruang">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<td width="14.15%"><input style="width:90%" id="kdsektor'+d[0]+'" name="updkdsektor" class="form-control" type="text" placeholder="Kode Sektor"></td>'+
              '<td width="14.15%"><input style="width:90%" id="kdsatker'+d[0]+'" name="updkdsatker" class="form-control" type="text" placeholder="Kode Satker"></td>'+
              '<td width="14.2%"><input style="width:90%" id="kdunit'+d[0]+'" name="updkdunit" class="form-control" type="text" placeholder="Kode Unit"></td>'+
              '<td width="14.2%"><input style="width:90%" id="kdgudang'+d[0]+'" name="updkdgudang" class="form-control" type="text" placeholder="Kode Gudang"></td>'+
              '<td width="7.8%"><input style="width:90%" id="kdruang'+d[0]+'" name="updkdruang" class="form-control" type="text" placeholder="Ruang"></td>'+
              '<td><input style="width:97%" id="nmruang'+d[0]+'" name="updnmruang" class="form-control" type="text" placeholder="Uraian Ruang"></td>'+
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
      $(document).on('submit', '#updruang', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "ruang";
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
      $('#addruang').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "ruang";
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
