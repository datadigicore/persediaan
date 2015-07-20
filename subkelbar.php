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
                <div class="box-header">
                  <h3 class="box-title">Tabel Sub Kelompok Barang Persediaan</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">Kode Transaksi</th>
                        <th>Uraian Transaksi</th>
                        <th width="14%">Satuan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1010101001</td>
                        <td>ASPAL</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>1010101002</td>
                        <td>SEMEN</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>1010101003</td>
                        <td>KACA</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>1010101004</td>
                        <td>PASIR</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>1010101005</td>
                        <td>BATU</td>
                        <td></td>
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
