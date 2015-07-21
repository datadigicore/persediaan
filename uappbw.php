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
            Unit Akuntansi Pembantu Pengguna Barang - Wilayah
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel UAPPB-Wilayah</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>  
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <select id="kodeuapb" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-E1</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="kduapb" placeholder="Masukkan Kode UAPPB-E1">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian UAPPB-E1</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="uraianuapb" placeholder="Masukkan Uraian UAPPB-E1">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Tabel Data UAPPB-W</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">UAPB</th>
                        <th width="14%">UAPPB-E1</th>
                        <th width="14%">UAPPB-W</th>
                        <th>Uraian UAPPB-W</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>001</td>
                        <td>001</td>
                        <td>001</td>
                        <td>URAIAN PERSEDIAAN</td>
                      </tr>
                      <tr>
                        <td>002</td>
                        <td>002</td>
                        <td>002</td>
                        <td>URAIAN PERSEDIAAN</td>
                      </tr>
                      <tr>
                        <td>003</td>
                        <td>003</td>
                        <td>003</td>
                        <td>URAIAN PERSEDIAAN</td>
                      </tr>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
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
        $("#example1").DataTable();
      });
    </script>
  </body>
</html>
