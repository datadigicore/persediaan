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
            Konfigurasi SKPD
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-gear"></i> Export SKPD</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <?php include("include/tabkonfig.php"); ?>
            <section class="col-lg-12 connectedSortable">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Export Konfigurasi</h3>
                </div>  
                <form action="../core/konfig/proseskonfigurasi" method="post" class="form-horizontal" id="addkonfig">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-3 control-label">Export SKPD</label>
                      <div class="col-sm-3">
                        <input type="hidden" name="manage" value="exporttahun">
                        <select name="thnawal" id="thnawal" class="form-control select2">
                          <option selected="selected">-- Pilih Tahun Awal --</option>
                        </select>
                      </div>
                      <div class="col-sm-1 control-label" style="margin-left:-42px;">
                        <i class="fa fa-arrow-circle-right"></i>
                      </div>
                      <div class="col-sm-3">
                        <select name="thntujuan" id="thntujuan" class="form-control select2">
                          <option selected="selected">-- Pilih Tahun Tujuan --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right">Export</button>
                  </div>
                </form>                

                <form action="../core/konfig/proseskonfigurasi" method="post" class="form-horizontal" id="addkonfig2">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-3 control-label">Export User</label>
                      <div class="col-sm-3">
                        <input type="hidden" name="manage" value="exporttahun_user">
                        <select name="thnawal" id="thnawal2" class="form-control select2">
                          <option selected="selected">-- Pilih Tahun Awal --</option>
                        </select>
                      </div>
                      <div class="col-sm-1 control-label" style="margin-left:-42px;">
                        <i class="fa fa-arrow-circle-right"></i>
                      </div>
                      <div class="col-sm-3">
                        <select name="thntujuan" id="thntujuan2" class="form-control select2">
                          <option selected="selected">-- Pilih Tahun Tujuan --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right">Export</button>
                  </div>
                </form>
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
      $(function () {
        $("li#konfig").addClass("active");
        $("li.expkonfig").addClass("active2");
        $("li.expkonfig>a").append('<i class="fa fa-angle-down pull-right" style="margin-top:3px;"></i>');
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/konfig/proseskonfigurasi',
          data: {manage:'readthn'},
          success: function (output) {     
            $('#thnawal').html(output);
            $('#thntujuan').html(output);
            $('#thnawal2').html(output);
            $('#thntujuan2').html(output);
          }
        });
      });
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        konfigname_row = row.data()[1];
        email_row  = row.data()[2];
        kdsatker_row  = row.data()[3];
        nmsatker_row  = row.data()[4];
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
          $("#konfigname"+id_row+"").val(konfigname_row);
          $("#email"+id_row+"").val(email_row);
          $("#kdsatker"+id_row+"").val(kdsatker_row);
          $("#nmsatker"+id_row+"").val(nmsatker_row);
        }
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "konfig";
      id_row = row.data()[0];
      managedata = "delkonfig";
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
            url : "../core/konfig/proseskonfig",
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
      $('#addkonfig2').submit(function(e){
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
    </script>
  </body>
</html>
