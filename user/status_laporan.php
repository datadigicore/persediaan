<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
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
            Status Laporan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Masuk</a></li>
          </ol>
        </section>
        <section class="content" >
          <div class="row">
            <section class="col-lg-12 connectedSortable">

              <div class="box box-info">

                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="1%">ID</th>
                        <th>Kode Lokasi</th>
                        <th>Satker</th>
                        <th>Nama Laporan</th>
                        <th>Tanggal Permintaan</th>
                        <th>Nama File</th>
                        <th width="10%">Status</th>
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
    <script src="../plugins/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../plugins/sweetalert/dist/sweetalert.css">
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="../dist/js/jquery.mask.js" ></script>
    <script type="text/javascript">
      var table;
      function baca_tabel(){
        table = $("#example1").DataTable({
              "aaSorting": [[ 0, 'desc' ]],
              "processing": false,
              "serverSide": true,
              "ajax": "../core/loadtable/status_laporan",
              "columnDefs":
              [
                {"targets": 0,
                   "visible": false },
                  {"targets": 1 },
                  {"targets": 2 },
                  {"targets": 3 },
                  {"targets": 4 },
                  {"targets": 5}

              ],
              "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
            });
      }
      baca_tabel();
      $(function () {
        $("li#status_laporan").addClass("active");

      });


      $(document).on('click', '#btntmbh', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        manage = "trans_masuk";
        id_row = row.data()[0];
        jns_trans = row.data()[2];
        satker = row.data()[3];
        tgl_dok = row.data()[5];
        tgl_buku = row.data()[6];
        dt_satker = satker.split('-');
        kd_satker = dt_satker[0];

        var $form=$(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action","trans_item_brg");
        var $input=$(document.createElement('input')).css({display:'none'}).attr('name','id').val(id_row);
        var $input2=$(document.createElement('input')).css({display:'none'}).attr('name','jenistrans').val(jns_trans);
        var $input3=$(document.createElement('input')).css({display:'none'}).attr('name','tanggaldok').val(tgl_dok);
        var $input4=$(document.createElement('input')).css({display:'none'}).attr('name','tanggalbuku').val(tgl_buku);
        var $input5=$(document.createElement('input')).css({display:'none'}).attr('name','satker').val(satker);
        var $input6=$(document.createElement('input')).css({display:'none'}).attr('name','manage').val(manage);
        var $input7=$(document.createElement('input')).css({display:'none'}).attr('name','kd_satker').val(kd_satker);
        $form.append($input).append($input2).append($input3).append($input4).append($input5).append($input6).append($input7);
        $("body").append($form);
        $form.submit();
      });

    </script>
  </body>
</html>
