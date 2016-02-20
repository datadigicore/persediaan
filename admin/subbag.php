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
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel UPB</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <?php include("include/navtab.php"); ?>
            <section class="col-lg-12 connectedSortable">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data Sub Bagian</h3>
                </div>
                <form action="../core/ruang/prosessubbag" method="post" class="form-horizontal" id="createsubbag">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Kode UPB</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="createsubbag">
                        <select name="kdupb" id="kdupb" class="form-control select2">
                          <option value="">-- Pilih Kode Sub Unit --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Sub Bagian</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdsubbag" class="form-control" id="kdsubbag" placeholder="Masukkan Kode Sub Bagian">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian Sub Bagian</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmsubbag" class="form-control" id="nmsubbag" placeholder="Masukkan Uraian Sub Bagian">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form> 
              </div>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tabel Data UPB</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="9.5%">Kode<br>Bidang</th>
                        <th width="9.5%">Kode<br>Unit</th>
                        <th width="9.5%">Kode<br>Sub Unit</th>
                        <th width="9.5%">Kode<br>UPB</th>
                        <th width="9.5%">Kode<br>Sub Bag</th>
                        <th width="10%">Kode<br>Satker</th>
                        <th>Uraian<br>Sub Bagian</th>
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
        $("li#skpd").addClass("active");
        $("li.ruang").addClass("active5");
        $("li.ruang>a").append('<i class="fa fa-angle-down pull-right" style="margin-top:3px;"></i>');
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/ruang/prosessubbag',
          data: {manage:'readupb'},
          success: function (output) {     
            $('#kdupb').html(output);
          }
        });
        table = $("#example1").DataTable({
          "oLanguage": {
            "sInfoFiltered": ""
          },
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadsubbag",
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
             "defaultContent":  '<div class="row-fluid">'+
                                  '<button id="btnedt" class="col-xs-6 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                  '<button id="btnhps" class="col-xs-6 btn btn-danger btn-xs btn-flat pull-right"><i class="fa fa-remove"></i> Hapus</button>'+
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
        kdsektor_row = row.data()[1];
        kdsatker_row  = row.data()[2];
        kdunit_row  = row.data()[3];
        kdgudang_row  = row.data()[4];
        kdsubbag_row  = row.data()[5];
        nmsubbag_row  = row.data()[7];
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
          $("#kdsubbag"+id_row+"").val(kdsubbag_row);
          $("#nmsubbag"+id_row+"").val(nmsubbag_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "subbag";
      id_row = row.data()[0];
      managedata = "deletesubbag";
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
            url : "../core/ruang/prosessubbag",
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
        '<form action="../core/ruang/prosessubbag" method="post" class="form-horizontal" id="updatesubbag">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updatesubbag">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<td width="9.6%"><input style="width:90%" id="kdsektor'+d[0]+'" name="updkdsektor" class="form-control" type="text" placeholder="Kode Sektor"></td>'+
              '<td width="9.6%"><input style="width:90%" id="kdsatker'+d[0]+'" name="updkdsatker" class="form-control" type="text" placeholder="Kode Satker"></td>'+
              '<td width="9.6%"><input style="width:90%" id="kdunit'+d[0]+'" name="updkdunit" class="form-control" type="text" placeholder="Kode Sub Unit"></td>'+
              '<td width="9.6%"><input style="width:90%" id="kdgudang'+d[0]+'" name="updkdgudang" class="form-control" type="text" placeholder="Kode UPB"></td>'+
              '<td width="9.6%"><input style="width:90%" id="kdsubbag'+d[0]+'" name="updkdsubbag" class="form-control" type="text" placeholder="Kode Sub Bag"></td>'+
              '<td><input style="width:97%" id="nmsubbag'+d[0]+'" name="updnmsubbag" class="form-control" type="text" placeholder="Uraian Sub Bag"></td>'+
              '<td style="vertical-align:middle; width:15%;">'+
                '<div class="box-tools">'+
                  '<button id="btnrst" class="col-xs-6 btn btn-flat btn-warning btn-sm pull-left" type="reset"><i class="fa fa-refresh"></i> Reset</button>'+
                  '<button id="btnupd" class="col-xs-6 btn btn-flat btn-primary btn-sm pull-right"><i class="fa fa-upload"></i> Update</button>'+
                '</div>'
              '</td>'+
           '</tr>'+
        '</table>'+
        '</form></div>';
      }
      $(document).on('submit', '#updatesubbag', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "subbag";
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
            // $("#success-alert").alert();
            // $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
            // $("#success-alert").alert('close');
            // });
            // setTimeout("location.href = redirectURL;",redirectTime); 
          }
        });
        return false;
      });
      (function($,W,D){
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
          setupFormValidation: function()
          {
            $("#createsubbag").validate({
              rules: {
                kdupb : "required",
                kdsubbag   : {required  : true,
                            number    : true
                           },
                nmsubbag   : "required"
              },
              messages: {
                  kdupb: { required  : "Masukkan Kode Satker" },
                  kdsubbag  : { required  : "Masukkan Kode Sub Bagian",
                              number    : "Masukkan Angka"},
                  nmsubbag  : { required  : "Masukkan Nama Sub Bagian" }
              },
              submitHandler: function(form) {
                $('#createsubbag').submit(function(e){
                  $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                  });
                  $('#myModal').modal('show');
                  e.preventDefault();
                  redirectTime = "2600";
                  redirectURL = "gudang";
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
