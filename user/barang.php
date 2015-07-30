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
            Sub Kelompok Barang Persediaan
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><i class="fa fa-link"></i> Lain - lain</li>
            <li class="active"><a href="#"><i class="fa fa-table"></i> Sub Kelompok Barang</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>
				        <form action="core/barang/prosesbarang" method="post" class="form-horizontal" id="addbarang">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Sub-sub Kelompok Barang</label>
                      <div class="col-sm-9">
                        <select name="kdsskel" id="kdsskel" class="form-control">
                        </select>
						              <input type="hidden" name="manage" value="addbarang">                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="kdbarang" class="form-control" id="kodebarang" placeholder="Masukkan Kode Barang">
                      </div>
                    </div>                    
					<div class="form-group">
                      <label class="col-sm-2 control-label">Nama Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmbarang" class="form-control" id="namabarang" placeholder="Masukkan Nama Barang">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Satuan</label>
                      <div class="col-sm-9">
                        <input type="text" name="satuan" class="form-control" id="satuan" placeholder="Masukkan Satuan Barang">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>				
                <div class="box-header">
                  <h3 class="box-title">Tabel Barang Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">SSKel. Barang</th>
                        <th>Kode Barang</th>
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
    <script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $(".treeview").addClass("active");
        $("li#barang").addClass("active");
        $.ajax({
          type: "post",
          url: 'core/barang/prosesbarang',
          data: {manage:'readsskel'},
          success: function (output) {     
            $('#kdsskel').html(output);
          }
        });
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "core/loadtable/loadbarang",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
			      {"targets": 2 },
            {"targets": 3 }
          ],
        });
      });
    </script>
  </body>
</html>