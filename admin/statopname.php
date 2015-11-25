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
            Konfigurasi SKPD
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-gear"></i> Konfigurasi SKPD</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <?php include("include/tabkonfig.php"); ?>
            <section class="col-lg-12 connectedSortable">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Tabel Status Opname</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="20%">Kode UPB</th>
                        <th width="48%">Nama UPB</th>
                        <th>Tahun Anggaran</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Keterangan</th>
                        <th width="7%">Aksi</th>
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
      function myTable() {
        table = $("#example1").DataTable({
          "oLanguage": {
            "sInfoFiltered": ""
          },
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/tablestatopname",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"targets": 6 },
            {"targets": 7 },
            {"targets": 8 },
            {"targets": 9 }
          ],
          "order": [[ 1, "asc" ]]
        });
      }
      $(function () {
        $("li#statopname").addClass("active");
        $("li.statopname").addClass("active3");
        $("li.statopname>a").append('<i class="fa fa-angle-down pull-right" style="margin-top:3px;"></i>');
        $(".select2").select2();
        myTable();
      });
      $(document).on('click', '#btnakt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        redirectTime = "2600";
        redirectURL = "konfig";
        id_row = row.data()[0];
        managedata = "setaktif";
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        $.ajax({
          type: "post",
          url : "../core/konfig/proseskonfigurasi",
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
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "opsik_item";
      id_row = row.data()[0];
      managedata = "hapusOpname";
            job=confirm("Anda yakin ingin mencabut status opname? ");
            if(job!=true)
            {
              return false;
            }
            else
            {
              $.ajax({
                type: "post",
                url : "../core/opsik/prosesopsik",
                data: {manage:managedata,id:id_row},
                success: function(data)
                {
                    $("#example1").DataTable().destroy();
                    $("#example1 tbody").empty();
                    table = $("#example1").DataTable({
                      "oLanguage": {
                        "sInfoFiltered": ""
                      },
                      "processing": false,
                      "serverSide": true,
                      "ajax": "../core/loadtable/tablestatopname",
                      "columnDefs":
                      [
                        {"targets": 0,
                         "visible": false },
                        {"targets": 1 },
                        {"targets": 2 },
                        {"targets": 3 },
                        {"targets": 4 },
                        {"targets": 5 },
                        {"targets": 6 },
                        {"targets": 7 },
                        {"targets": 8 },
                        {"targets": 9 },

                      ],
                      "order": [[ 1, "asc" ]]
                    });
                }
              });
            return false;
            }
          
        
      });
      $(document).on('submit', '#updkonfig', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "konfig";
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
            $("#addkonfig").validate({
              rules: {
                thnaktif: {required  : true,
                           number    : true,
                           maxlength : 4,
                           minlength : 4,
                           remote    : { url  : "../core/konfig/proseskonfigurasi",
                                         type : "post",
                                         data : {manage:"checkthnaktif"}
                                       }
                          }
              },
              messages: {
                  thnaktif: { required  : "Masukkan Tahun Anggaran",
                              number    : "Masukkan Angka",
                              maxlength : "Maksimal 4 digit",
                              minlength : "Minimal 4 digit",
                              remote    : "Tahun Anggaran telah terdaftar"}
              },
              submitHandler: function(form) {
                $('#addkonfig').submit(function(e){
                  $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                  });
                  $('#myModal').modal('show');
                  e.preventDefault();
                  redirectTime = "2600";
                  redirectURL = "konfig";
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
