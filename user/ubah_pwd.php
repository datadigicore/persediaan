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
            Ubah Password Pengguna
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-check-square-o"></i>Unit Pengguna Barang</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">  
                <form action="../core/transaksi/validasi" method="post" class="form-horizontal" id="addtndatgn">
                  <div class="box-body">                  
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Password Lama</label>
                      <div class="col-sm-9">
                        <input type="password" name="old_password" class="form-control" id="old_password" required placeholder="Masukkan Passowrd Lama">
                        <input type="hidden" name="manage" value="ubah_pwd">
                        <input type="hidden" name="kd_lokasi" id="kd_lokasi" value="<?php echo($_SESSION['kd_lok']);?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Password Baru</label>
                      <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" id="password" pattern=".{4,8}" required placeholder="Masukkan Password Baru (4-8 Karakter)">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Konfirmasi Password Baru</label>
                      <div class="col-sm-9">
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" pattern=".{4,8}" required placeholder="Masukkan Kembali Password yang Baru (4-8 Karakter)">
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
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
    <script src="../dist/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script type="text/javascript">    
      $("li#ubah_pwd").addClass("active");
      $('#addtndatg').submit(function(e){
        var pass1 = $("#password").val();
        var pass2 = $("#confirm_password").val();
        if(pass1!==pass2)
        {
          alert("Konfirmasi Password tidak sama dengan Password");
          return false;
        }

     
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "index";
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
