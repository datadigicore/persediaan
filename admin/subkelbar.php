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
            Sub Kelompok Barang Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li><i class="fa fa-link"></i> Lain - lain</li>
            <li class="active"><a href="#"><i class="fa fa-table"></i> Sub Kelompok Barang</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data Sub Kelompok Barang</h3>
                </div>  
                <form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="addbarang">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Kode Barang </label>
                      <div class="col-sm-4">
                        <select name="kdbarang_item" id="kdbarang_item" class="form-control select2">
                          <option selected="selected">-- Pilih Kode Barang --</option>
                        </select>
                      </div>
                      <div class="col-sm-5">
                        <input type="text" name="kdbarang" class="form-control" id="kdbarang" placeholder="Masukkan Kode Barang">
                        <input type="hidden" name="manage" value="addbarang">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmbarang" class="form-control" id="nmbarang" placeholder="Masukkan Uraian Barang">
                      </div>
                    </div>
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Spesifikasi </label>
                      <div class="col-sm-9">
                        <input type="text" name="kdbarang" class="form-control" id="kdbarang" placeholder="Masukkan Kode Barang">
                        <input type="hidden" name="manage" value="addbarang">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Satuan</label>
                      <div class="col-sm-9">
                        <select name="satuan" id="satuan" class="form-control select2">
                          <option selected="selected">-- Pilih Satuan Barang --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Tabel Sub Kelompok Barang Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="16%">Kode Barang</th>
                        <th>Uraian Barang</th>
                        <th>Spesifikasi</th>
                        <th width="16%">Satuan</th>
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
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $(".select2").select2();
        $(".treeview").addClass("active");
        $("li#subkelbar").addClass("active");
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadsubkelbar",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-xs btn-flat pull-right"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [5],"targets": 5 }
          ],
        });
      });
      $.ajax({
        type: "post",
        url: '../core/barang/prosesbarang',
        data: {manage:'readsatuan'},
        success: function (output) {     
          $('#satuan').html(output);
        }
      });
      $.ajax({
        type: "post",
        url: '../core/barang/prosesbarang',
        data: {manage:'readbarang'},
        success: function (output) {     
          $('#kdbarang_item').html(output);
        }
      });
    </script>
  </body>
</html>
