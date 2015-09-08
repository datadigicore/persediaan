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
            Kelompok Barang Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Barang Persediaan</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>
				        <form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="addbarang">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="padding-top:2px;">Kode Sub-sub Kelompok Barang</label>
                      <div class="col-sm-9" style="padding-top:7px;">
                        <select name="kdsskel" id="kdsskel" class="form-control select2">
                          <option value="">-- Pilih Kode Sub-sub Kelompok Barang --</option>
                        </select>
						            <input type="hidden" name="manage" value="addbarang">                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodebarang" class="form-control" id="kodebarang" placeholder="Masukkan Kode Barang" required>
                      </div>
                    </div>                    
					         <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="namabarang" class="form-control" id="namabarang" placeholder="Masukkan Nama Barang" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Satuan</label>
                      <div class="col-sm-9">
                        <input type="text" name="satuan" class="form-control" id="satuan" placeholder="Masukkan Satuan Barang" required>
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
                  <h3 class="box-title">Daftar Barang Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">SSKel. Barang</th>
                        <th width="14%">Kode Barang</th>
                        <th>Nama Barang</th>
                        <th width="14%">Satuan</th>
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
    </div>
    <?php include("include/loadjs.php"); ?>
    <?php include("include/success.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("li#barang").addClass("active");
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/barang/prosesbarang',
          data: {manage:'readsskel'},
          success: function (output) {     
            $('#kdsskel').html(output);
          }
        });
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadbarang",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
			      {"targets": 2 },
            {"targets": 3 }
          ],
        });
      });
      $('#addbarang').submit(function(e){
        if(document.getElementById("kdsskel").value=="")
        {
          alert("Kode Sub Sub Kelompok Barang Belum Dipilih");
          return false;
        }
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "barang";
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
