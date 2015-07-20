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
                  <h3 class="box-title">Tambah Data</h3>
                </div>  
                <div class="box-body">
                  
                </div>  
              </div>
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Tabel Data UAPB</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">Kode UAPB</th>
                        <th>Uraian UAPB</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>001</td>
                        <td>MAJELIS PERWAKILAN RAKYAT</td>
                      </tr>
                      <tr>
                        <td>002</td>
                        <td>DEWAN PERWAKILAN RAKYAT</td>
                      </tr>
                      <tr>
                        <td>003</td>
                        <td>BADAN PEMERIKSA KEUANGAN</td>
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
