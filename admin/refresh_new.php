<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <?php include("../config/dbconf.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/datepicker.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Refresh Mutasi Persediaan
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i></a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Status Refresh</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="10%">Kode UPB</th>
                        <th width="20%">Nama UPB</th>
                        <th width="15%">Kode Barang</th>
                        <th width="15%">Nama Barang</th>
                        <th>Tanggal Input Selisip</th>
                        <th>Tahun Aktif</th>
                        <th width="7%">Aksi</th>
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
      <?php include("include/success.php"); ?>
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script type="text/javascript">
      $("li#refresh").addClass("active");
      table = $("#example1").DataTable({
        "oLanguage": {
          "sInfoFiltered": ""
        },
        "processing": false,
        "serverSide": true,
        "ajax": "../core/loadtable/tableselisip",
        "columnDefs":
        [
          {"targets": 0,
           "visible": false },
          {"targets": 1 },
          {"targets": 2 },
          {"targets": 3 },
          {"targets": 4 },
          {"targets": 5 },
          {"targets": 6 },
          {"targets": 7 }
        ],
        "order": [[ 1, "asc" ]]
      });

            $(document).on('click', '#btnrefresh', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );
            redirectTime = "2600";
            redirectURL = "refresh_new";
            satker = row.data()[1];
            managedata = "refresh";


            job=confirm("Anda yakin ingin merefresh Transaksi?");
            if(job!=true)
            {
              return false;
            }
            else
            {
              $.ajax({
                type: "post",
                url : "../core/konfig/proseskonfigurasi",
                data: {manage:managedata,satker:satker},
                success: function(data)
                {

                  $("#example1").DataTable().destroy();
                  $("#example1 tbody").empty();
                  table = $("#example1").DataTable({
                    "oLanguage": {
                      "sInfoFiltered": ""
                    },
                    "processing": false,
                    "serverSide": true,
                    "ajax": "../core/loadtable/tableselisip",
                    "columnDefs":
                    [
                      {"targets": 0,
                       "visible": false },
                      {"targets": 1 },
                      {"targets": 2 },
                      {"targets": 3 },
                      {"targets": 4 },
                      {"targets": 5 },
                      {"targets": 6 },
                      {"targets": 7 }
                    ],
                    "order": [[ 1, "asc" ]]
                  });
                            }
              });

            return false;
            }
          
        

    });
    </script>
  </body>
</html>
