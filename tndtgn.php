<?php include("config/app.php"); ?>
<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue layout-boxed">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Unit Akuntansi Pengguna Barang
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel UAPB</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Penanggung Jawab UAKPB</h3>
                </div>  
                <form action="core/uapb" method="post" class="form-horizontal" id="adduapb">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodeuapb" class="form-control" id="kduapb" placeholder="">
                        <input type="hidden" name="manage" value="adduapb">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Jabatan</label>
                      <div class="col-sm-9">
                        <input type="text" name="uraianuapb" class="form-control" id="uraianuapb" placeholder="">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">NIP</label>
                      <div class="col-sm-9">
                        <input type="text" name="uraianuapb" class="form-control" id="uraianuapb" placeholder="">
                      </div>
                    </div>
                    <h4>Pengelola Barang Persediaan</h4>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodeuapb" class="form-control" id="kduapb" placeholder="">
                        <input type="hidden" name="manage" value="adduapb">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Jabatan</label>
                      <div class="col-sm-9">
                        <input type="text" name="uraianuapb" class="form-control" id="uraianuapb" placeholder="">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">NIP</label>
                      <div class="col-sm-9">
                        <input type="text" name="uraianuapb" class="form-control" id="uraianuapb" placeholder="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kota</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodeuapb" class="form-control" id="kduapb" placeholder="">
                        <input type="hidden" name="manage" value="adduapb">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Isi</label>
                      <div class="col-sm-9">
                        <input type="text" name="uraianuapb" class="form-control" id="uraianuapb" placeholder="">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Setuju</label>
                      <div class="col-sm-9">
                        <input type="text" name="uraianuapb" class="form-control" id="uraianuapb" placeholder="">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
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
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("li#uapb").addClass("active");
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "core/loadtable/loaduapb",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 }
          ],
        });
      });
      $('#adduapb').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "uapb";
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
