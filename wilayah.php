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
            Daftar Wilayah
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><i class="fa fa-link"></i> Lain - lain</li>
            <li class="active"><a href="#"><i class="fa fa-table"></i> Wilayah</a></li>
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
                  <h3 class="box-title">Tabel Daftar Wilayah</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">Kode Wilayah</th>
                        <th>Uraian Wilayah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>100</td>
                        <td>DKI JAKARTA</td>
                      </tr>
                      <tr>
                        <td>151</td>
                        <td>JAKARTA PUSAT</td>
                      </tr>
                      <tr>
                        <td>152</td>
                        <td>JAKARTA UTARA</td>
                      </tr>
                      <tr>
                        <td>153</td>
                        <td>JAKARTA BARAT</td>
                      </tr>
                      <tr>
                        <td>154</td>
                        <td>JAKARTA SELATAN</td>
                      </tr>
                      <tr>
                        <td>155</td>
                        <td>JAKARTA TIMUR</td>
                      </tr>
                      <tr>
                        <td>156</td>
                        <td>KEPULAUAN SERIBU</td>
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
