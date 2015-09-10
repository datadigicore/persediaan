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
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel Unit</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <?php include("include/navtab.php"); ?>
            <section class="col-lg-12 connectedSortable">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data Unit</h3>
                </div>  
                <form action="../core/unit/prosesunit" method="post" class="form-horizontal" id="addunit">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="addunit">
                        <select name="kdsatker" id="kdsatker" class="form-control select2">
                          <option value="">-- Pilih Kode Satker --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Unit</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdunit" id="kdunit" class="form-control" placeholder="Masukkan Kode Unit">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian Unit</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmunit" class="form-control" id="nmunit" placeholder="Masukkan Uraian Satker">
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
                  <h3 class="box-title">Tabel Data Unit</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="14%">Kode Sektor</th>
                        <th width="14%">Kode Satker</th>
                        <th width="14%">Kode Unit</th>
                        <th>Uraian Unit</th>
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
        $("li.unit").addClass("active3");
        $("li.unit>a").append('<i class="fa fa-angle-right pull-right" style="margin-top:3px;"></i>');
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/unit/prosesunit',
          data: {manage:'readsatker'},
          success: function (output) {     
            $('#kdsatker').html(output);
          }
        });
        table = $("#example1").DataTable({
          "oLanguage": {
            "sInfoFiltered": ""
          },
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadunit",
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
        urunit_row  = row.data()[4];
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
          $("#urunit"+id_row+"").val(urunit_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "unit";
      id_row = row.data()[0];
      id_unit = row.data()[1]+'.'+row.data()[2]+'.'+row.data()[3];
      nm_unit = row.data()[4];
      managedata = "delunit";
      job=confirm("Anda yakin ingin menghapus data ini?\nJika dihapus maka akan menghapus seluruh sub divisi terkait dengan Unit");
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
            url : "../core/unit/prosesunit",
            data: {manage:managedata,id:id_row,idunit:id_unit,nmunit:nm_unit},
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
        '<form action="../core/unit/prosesunit" method="post" class="form-horizontal" id="updunit">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updunit">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<td width="14%"><input style="width:90%" id="kdsektor'+d[0]+'" name="updkdsektor" class="form-control" type="text" placeholder="Kode Sektor"></td>'+
              '<td width="14.2%"><input style="width:90%" id="kdsatker'+d[0]+'" name="updkdsatker" class="form-control" type="text" placeholder="Kode Satker"></td>'+
              '<td width="14.2%"><input style="width:90%" id="kdunit'+d[0]+'" name="updkdunit" class="form-control" type="text" placeholder="Kode Unit"></td>'+
              '<td><input style="width:97%" id="urunit'+d[0]+'" name="updurunit" class="form-control" type="text" placeholder="Uraian Unit"></td>'+
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
      $(document).on('submit', '#updunit', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "unit";
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
      $('#kdsektor').change(function(){
        if ($(this).val()=='') {
          $('#kodeuappbe').html('<option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>');
          $('#kodeuappbe').val("").trigger("change");
        }
        else {
          var kdsektor = $(this).val();
          $('#kodeuappbe').html('<option value="">-- Pilih Kode Satker --</option>');
          $('#kodeuappbe').val("").trigger("change");
          $.ajax({
            type: "post",
            url: '../core/unit/prosesunit',
            data: {manage:'readuappbe',kdsektor:kdsektor},
            success: function (output) {
              $('#kodeuappbe').html(output);
            }
          });
        }
      });
      (function($,W,D){
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
          setupFormValidation: function()
          {
            $("#addunit").validate({
              rules: {
                kdsatker : "required",
                kdunit   : {required  : true,
                            number    : true,
                            maxlength : 2,
                            minlength : 2
                           },
                nmunit   : "required"
              },
              messages: {
                  kdsatker: { required  : "Masukkan Kode Satker" },
                  kdunit  : { required  : "Masukkan Kode Unit",
                              number    : "Masukkan Angka",
                              maxlength : "Maksimal 2 digit",
                              minlength : "Minimal 2 digit"},
                  nmunit  : { required  : "Masukkan Nama Unit" }
              },
              submitHandler: function(form) {
                $('#addunit').submit(function(e){
                  $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                  });
                  $('#myModal').modal('show');
                  e.preventDefault();
                  redirectTime = "2600";
                  redirectURL = "unit";
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
              }
            });
          }
        }
        $(D).ready(function($) {
            JQUERY4U.UTIL.setupFormValidation();
        });
      })(jQuery, window, document);
    </script>
  </body>
</html>
