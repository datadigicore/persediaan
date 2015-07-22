<?php include("config/app.php"); ?>
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
            Daftar Kantor Wilayah
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><i class="fa fa-link"></i> Lain - lain</li>
            <li class="active"><a href="#"><i class="fa fa-table"></i> Kantor Wilayah</a></li>
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
                  <h3 class="box-title">Tabel Daftar Kantor Wilayah</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">BA</th>
                        <th width="14%">ES-1</th>
                        <th width="14%">Kode Kanwil</th>
                        <th>Uraian Kantor Wilayah</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>015</td>
                        <td>04</td>
                        <td>010</td>
                        <td>KANTOR WILAYAH DJP NANGROE ACEH DARUSSALAM</td>
                      </tr>
                      <tr>
                        <td>015</td>
                        <td>04</td>
                        <td>020</td>
                        <td>KANTOR WILAYAH DJP SUMATERA UTARA I</td>
                      </tr>
                      <tr>
                        <td>015</td>
                        <td>04</td>
                        <td>030</td>
                        <td>KANTOR WILAYAH DJP SUMATERA UTARA II</td>
                      </tr>
                      <tr>
                        <td>015</td>
                        <td>04</td>
                        <td>040</td>
                        <td>KANTOR WILAYAH DJP RIAU DAN KEPULAUAN RIAU</td>
                      </tr>
                      <tr>
                        <td>015</td>
                        <td>04</td>
                        <td>050</td>
                        <td>KANTOR WILAYAH DJP SUMATERA BARAT DAN JAMBI</td>
                      </tr>
                      <tr>
                        <td>015</td>
                        <td>04</td>
                        <td>060</td>
                        <td>KANTOR WILAYAH DJP SUMATERA SELATAN DAN KEPULAUAN BANGKA BELITUNG</td>
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
        $(".treeview").addClass("active");
        $("li#kanwil").addClass("active");
        $("#example1").DataTable();
      });
    </script>
  </body>
</html>
