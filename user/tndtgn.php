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
            Identitas Pejabat SKPD
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-check-square-o"></i> Unit Pengguna Barang</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Atasan Langsung Penyimpan Barang</h3>
                </div>  
                <form action="../core/tandatgn/prosestndatgn" method="post" class="form-horizontal" id="addtndatgn">
                  <div class="box-body">
                     <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-9">
                        <select name="read_no_dok" id="read_no_dok" class="form-control">
                        </select>
                      </div>
                    </div>                   
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama">
                        <input type="hidden" name="manage" value="addtndatgn">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Jabatan</label>
                      <div class="col-sm-9">
                        <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="Masukkan Jabatan">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">NIP</label>
                      <div class="col-sm-9">
                        <input type="text" name="nip" class="form-control" id="nip" placeholder="Masukkan NIP">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer" style="padding:0;">
                  </div>
                <div class="box-header with-border">
                  <h3 class="box-title">Kepala Sub. Bagian Keuangan</h3>
                </div>
                <div class="form-group">
                      <label class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="nama-kasubkeu" class="form-control" id="nama-kasubkeu" placeholder="Masukkan Nama">
                      </div>
                </div>
                <div class="form-group">
                      <label class="col-sm-2 control-label">NIP</label>
                      <div class="col-sm-9">
                        <input type="text" name="nip-kasubkeu" class="form-control" id="nip-kasubkeu" placeholder="Masukkan NIP">
                      </div>
                    </div>
                <div class="box-header with-border">
                  <h3 class="box-title">Penyimpan Barang</h3>
                </div>  
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama</label>
                      <div class="col-sm-9">
                        <input type="text" name="nama2" class="form-control" id="nama2" placeholder="Masukkan Nama">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Jabatan</label>
                      <div class="col-sm-9">
                        <input type="text" name="jabatan2" class="form-control" id="jabatan2" placeholder="Masukkan Jabatan">
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">NIP</label>
                      <div class="col-sm-9">
                        <input type="text" name="nip2" class="form-control" id="nip2" placeholder="Masukkan NIP">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kota</label>
                      <div class="col-sm-9">
                        <input type="text" name="kota" class="form-control" id="kota" placeholder="Masukkan Kota">
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
      $("li#tnda_tangan").addClass("");
      $.ajax({
        type: "post",
        url: '../core/transaksi/prosestransaksi',
        data: {manage:'readsatkerdok',no_dok:"<?php echo($_SESSION['kd_lok']);?>"},
        success: function (output) {     
          $('#read_no_dok').html(output);
        }
      });


      $.ajax({
        type: "post",
        url: '../core/tandatgn/prosestndatgn',
        data: {manage:'baca_data_awal'},
        dataType: "json",
        success: function (output) {
          $('#nama').val(output.nama);
          $('#nip').val(output.nip);
          $('#jabatan').val(output.jabatan);            
          $('#nama-kasubkeu').val(output.namakasubkeu);
          $('#nip-kasubkeu').val(output.nipkasubkeu);
          $('#nama2').val(output.nama2);
          $('#nip2').val(output.nip2);
          $('#jabatan2').val(output.jabatan2);
          $('#kota').val(output.kota);
        }
      });

      $('#read_no_dok').change(function(){
          var kd_lok = $('#read_no_dok').val(); 
          $.ajax({
          type: "post",
          url: '../core/tandatgn/prosestndatgn',
          data: {manage:'baca_data_pj',kd_lok:kd_lok},
          dataType: "json",
          success: function (output) {     
            $('#nama').val(output.nama);
            $('#nip').val(output.nip);
            $('#jabatan').val(output.jabatan);            
            $('#nama2').val(output.nama2);
            $('#nip2').val(output.nip2);
            $('#jabatan2').val(output.jabatan2);
            $('#kota').val(output.kota);
          }
       });
        
      });



      $('#addtndatgn').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "tndtgn";
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
