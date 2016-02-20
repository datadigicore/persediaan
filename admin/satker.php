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
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data Unit</h3>
                </div>  
                <form action="../core/satker/prosessatker" method="post" class="form-horizontal" id="addsatker">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Kode Bidang</label>
                      <div class="col-sm-9" id="col-kodesektor">
                        <select name="kdsektor" id="kdsektor" class="form-control select2">
                          <option selected="selected">-- Pilih Kode Bidang --</option>
                        </select>
                        <input type="hidden" name="manage" value="addsatker">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Unit</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdsatker" id="kdsatker" class="form-control" placeholder="Masukkan Kode Unit">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian Unit</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmsatker" id="nmsatker" class="form-control" placeholder="Masukkan Uraian Unit">
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
                    <h3 class="box-title">Tabel Data Unit</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="18%">Kode Bidang</th>
                        <th width="18%">Kode Unit</th>
                        <th>Uraian Unit</th>
                        <th width="12.5%">Aksi</th>
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
        $("li.satker").addClass("active2");
        $("li.satker>a").append('<i class="fa fa-angle-down pull-right" style="margin-top:3px;"></i>');
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/satker/prosessatker',
          data: {manage:'readsektor'},
          success: function (output) {     
            $('#kdsektor').html(output);
          }
        });
        var table = $("#example1").DataTable({
          "oLanguage": {
            "sInfoFiltered": ""
          },
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadsatker",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false},
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="row-fluid">'+
                                  '<button id="btnedt" class="col-xs-6 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                  '<button id="btnhps" class="col-xs-6 btn btn-danger btn-xs btn-flat pull-right"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [4],"targets": 4 }
          ],
          "order": [[ 1, "asc" ]]
        });
        $(document).on("click", "#btnedt", function(){
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          id_row = row.data()[0];
          kdsektor_row = row.data()[1];
          kdsatker_row  = row.data()[2];
          ursatker_row  = row.data()[3];
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
            $("#ursatker"+id_row+"").val(ursatker_row);
          }
        });
        $(document).on('click', '#btnhps', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        redirectTime = "2600";
        redirectURL = "satker";
        id_row = row.data()[0];
        id_satker = row.data()[1]+'.'+row.data()[2];
        nm_satker = row.data()[3];
        managedata = "delsatker";
        job=confirm("Anda yakin ingin menghapus data ini?\nJika dihapus maka akan menghapus seluruh Sub Divisi terkait dengan Unit");
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
              url : "../core/satker/prosessatker",
              data: {manage:managedata,id:id_row,idsatker:id_satker,nmsatker:nm_satker},
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
          '<form action="../core/satker/prosessatker" method="post" class="form-horizontal" id="updsatker">'+
          '<table width="100%">'+
             '<tr>'+
                '<input type="hidden" name="manage" value="updsatker">'+
                '<input type="hidden" name="id" value="'+d[0]+'">'+
                '<td width="18.5%"><input style="width:90%" id="kdsektor'+d[0]+'" name="updkdsektor" class="form-control" type="text" placeholder="Kode Bidang"></td>'+
                '<td width="18.5%"><input style="width:90%" id="kdsatker'+d[0]+'" name="updkdsatker" class="form-control" type="text" placeholder="Kode Unit"></td>'+
                '<td><input style="width:96%" id="ursatker'+d[0]+'" name="updursatker" class="form-control" type="text" placeholder="Uraian Unit"></td>'+
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
        $(document).on('submit', '#updsatker', function (e) {
          $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
          });
          $('#myModal').modal('show');
          e.preventDefault();
          redirectTime = "2600";
          redirectURL = "satker";
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
          if($(this).val()==''){
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            table = $("#example1").DataTable({
              "processing": false,
              "serverSide": true,
              "ajax": "../core/loadtable/loadsatker",
              "columnDefs":
              [
                {"targets": 0,
                 "visible": false},
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
              "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
              "order": [[ 1, "asc" ]]
            });
          }
          else{
            var kdsektor = $(this).val();
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            $.ajax({
              type: "post",
              url: '../core/satker/prosessatker',
              data: {manage:'readtable',kdsektor:kdsektor},
              success: function (output) {
                var dataoutput = JSON.parse(output);   
                table = $("#example1").DataTable({
                  data : dataoutput,
                  columns: [
                        { data: [0],
                          visible : false },
                        { data: [1] },
                        { data: [2] },
                        { data: [3] },
                        { data: [4] }
                    ]
                });
              }
            });
          }
        });
      });
      (function($,W,D){
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
          setupFormValidation: function()
          {
            $("#addsatker").validate({
              rules: {
                kdsektor: "required",
                kdsatker: {required  : true,
                           number    : true,
                           maxlength : 2,
                           minlength : 2
                          },
                nmsatker: "required"
              },
              messages: {
                  kdsektor: { required  : "Masukkan Kode Bidang" },
                  kdsatker: { required  : "Masukkan Kode Unit",
                              number    : "Masukkan Angka",
                              maxlength : "Maksimal 2 digit",
                              minlength : "Minimal 2 digit"},
                  nmsatker: { required  : "Masukkan Nama Unit" }
              },
              submitHandler: function(form) {
                $('#addsatker').submit(function(e){
                  $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                  });
                  $('#myModal').modal('show');
                  e.preventDefault();
                  redirectTime = "2600";
                  redirectURL = "satker";
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
