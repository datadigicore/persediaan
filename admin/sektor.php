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
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel Bidang</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <?php include("include/navtab.php"); ?>
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data Bidang</h3>
                </div>  
                <form action="../core/sektor/prosessektor" method="post" class="form-horizontal" id="addsektor">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Kode Bidang </label>
                      <div class="col-sm-9">
                        <input type="text" name="kdsektor" class="form-control" id="kdsektor" placeholder="Masukkan Kode Bidang">
                        <input type="hidden" name="manage" value="addsektor">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian Bidang</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmsektor" class="form-control" id="nmsektor" placeholder="Masukkan Uraian Bidang">
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
                  <h3 class="box-title">Tabel Data Bidang</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="14%">Kode Bidang</th>
                        <th>Uraian Bidang</th>
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
        $("li.sektor").addClass("active1");
        $("li.sektor>a").append('<i class="fa fa-angle-down pull-right" style="margin-top:3px;"></i>');
        table = $("#example1").DataTable({
          "oLanguage": {
            "sInfoFiltered": ""
          },
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/tablesektor",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="row-fluid">'+
                                  '<button id="btnedt" class="col-xs-6 btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                  '<button id="btnhps" class="col-xs-6 btn btn-danger btn-xs btn-flat pull-right"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [3],"targets": 3 },
          ],
          "order": [[ 1, "asc" ]]
        });
      });
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        kdsektor_row = row.data()[1];
        ursektor_row  = row.data()[2];
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
          $("#kdsektor"+id_row +"").val(kdsektor_row);
          $("#ursektor"+id_row +"").val(ursektor_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "sektor";
      id_row = row.data()[0];
      id_sektor = row.data()[1];
      nm_sektor = row.data()[2];
      managedata = "delsektor";
      job=confirm("Anda yakin ingin menghapus data ini?\nJika dihapus maka akan menghapus seluruh Sub Divisi terkait dengan Bidang");
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
            url : "../core/sektor/prosessektor",
            data: {manage:managedata,id:id_row,idsektor:id_sektor,nmsektor:nm_sektor},
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
        '<form action="../core/sektor/prosessektor" method="post" class="form-horizontal" id="updsektor">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updsektor">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<td width="14%"><input style="width:90%" id="kdsektor'+d[0]+'" name="updkdsektor" class="form-control" type="text" placeholder="Kode Bidang"></td>'+
              '<td><input style="width:98%" id="ursektor'+d[0]+'" name="updursektor" class="form-control" type="text" placeholder="Uraian Bidang"></td>'+
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
      $(document).on('submit', '#updsektor', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "sektor";
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
      (function($,W,D){
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
          setupFormValidation: function()
          {
            $("#addsektor").validate({
              rules: {
                kdsektor: {required  : true,
                           number    : true,
                           maxlength : 2,
                           minlength : 2,
                           remote    : { url  : "../core/sektor/prosessektor",
                                         type : "post",
                                         data : {manage:"checkkdsektor"}
                                       }
                          },
                nmsektor: "required"
              },
              messages: {
                  kdsektor: { required  : "Masukkan Kode Bidang",
                              number    : "Masukkan Angka",
                              maxlength : "Maksimal 2 digit",
                              minlength : "Minimal 2 digit",
                              remote    : "Kode Bidang telah terdaftar"},
                  nmsektor: { required  : "Masukkan Nama Bidang" }
              },
              submitHandler: function(form) {
                $('#addsektor').submit(function(e){
                $('#myModal').modal({
                  backdrop: 'static',
                  keyboard: false
                });
                $('#myModal').modal('show');
                e.preventDefault();
                redirectTime = "2600";
                redirectURL = "sektor";
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
