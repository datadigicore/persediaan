<?php
if (empty($_POST['id'])) {
  header('location:../login');
}
else {
?>
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
        <?php if ($_POST['manage']=="trans_masuk") { ?>
        <section class="content-header">
          <h1>
            Persediaan Masuk
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Masuk</a></li>
          </ol>
        </section>
        <?php } else if ($_POST['manage']=="trans_keluar") { ?>
        <section class="content-header">
          <h1>
            Persediaan Keluar
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Keluar</a></li>
          </ol>
        </section>
        <?php } else if ($_POST['manage']=="transfer") { ?>
        <section class="content-header">
          <h1>
            Transfer Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Keluar</a></li>
          </ol>
        </section>
        <?php } ?>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal"  id="addtransmsk" >
                  <div class="box-body" style="padding-top:15px;">
                    <div class="row">
                      <div class="col-sm-5">
<!--                         <div class="form-group">

                          <label class="col-sm-5 control-label">Jenis Transaksi</label>
                          <div class="col-sm-7">
                            <input type="text" id="disjenistrans" name="disjenistrans" class="form-control" value="<?php echo $_POST['jenistrans'] ?>" readonly>
                          </div>
                        </div> -->
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Tgl. Dokumen</label>
                          <div class="col-sm-7">
                            <input type="text" id="tgl_dok" name="tgl_dok" class="form-control" value="<?php echo $_POST['tanggaldok'] ?>" readonly>
                          </div>
                        </div><!--
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Tgl. Pembukuan</label>
                          <div class="col-sm-7">
                            <input type="text" id="tgl_buku" name="tgl_buku" class="form-control" value="<?php echo $_POST['tanggalbuku'] ?>" readonly>
                          </div>
                        </div> -->
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Satker Pengirim</label>
                          <div class="col-sm-7">
                            <textarea class="form-control" rows="2"   readonly><?php echo $_POST['nm_satker'] ?></textarea>
                          </div>
                        </div>
                        <!-- <div class="form-group">
                          <label class="col-sm-5 control-label">Total Transaksi</label>
                          <div class="col-sm-7">
                            <input type="text" id="distottrans" name="distottrans" class="form-control" readonly>
                          </div>
                        </div> -->
                      </div>
                      <?php if ($_POST['manage']=="trans_masuk") { ?>
                      <div class="col-sm-7">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">No. Dokumen</label>
                          <div class="col-sm-8">
                            <input type="text" name="no_dok_item" id="no_dok_item" class="form-control" style="width:100%;" readonly value="<?php echo $_POST['no_dok'];?>">
                            <input type="hidden" name="manage" value="tbh_transaksi_msk">
                            <input type="hidden" id="read_no_dok" name="read_no_dok">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Keterangan</label>
                          <div class="col-sm-8">
                            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="" readonly>
                          </div>
                        </div>

                        <div name="detil_transaksi" id="detil_transaksi">
                        </div>
                      </div>
                  <?php }
                      else if ($_POST['manage']=="trans_keluar") { ?>
                      <div class="col-sm-7">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">No. Dokumen</label>
                            <div class="col-sm-8">
                              <input type="text" name="no_dok_item" id="no_dok_item" class="form-control" style="width:100%;" readonly value="<?php echo $_POST['no_dok'];?>">
                              <input type="hidden" name="manage" value="tbh_transaksi_klr">
                            <input type="hidden" id="read_no_dok" name="read_no_dok">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-8">
                              <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="" readonly>
                            </div>
                          </div>
                  <?php }
                       else if ($_POST['manage']=="transfer") {
                      ?>
                      <div class="col-sm-7">
                          <div class="form-group">
                            <label class="col-sm-3 control-label">No. Dokumen</label>
                            <div class="col-sm-8">
                              <input type="text" name="no_dok_item" id="no_dok_item" class="form-control" style="width:100%;" readonly value="<?php echo $_POST['no_dok'];?>">
                              <input type="hidden" name="manage" value="tbh_transaksi_klr">
                            <input type="hidden" id="read_no_dok" name="read_no_dok">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-8">
                              <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Satker Penerima</label>
                            <div class="col-sm-8">
                              <textarea class="form-control" rows="2" readonly=""><?php echo $_POST['nm_satker_msk'] ?></textarea>
                            </div>
                          </div>
                        </div>
                    <?php } ?>
                    </div>
                  </div>
                    </div>
                </form>
              </div>
              <?php if ($_POST['manage']=="trans_masuk") { ?>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transaksi Masuk</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>No Dok</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Keterangan</th>
                        <th width="8%">Sisa</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <?php } ?>
              <?php if ($_POST['manage']=="trans_keluar") { ?>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transaksi Keluar</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>No Dokumen</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Keterangan</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <?php } ?>
              <?php if ($_POST['manage']=="transfer") { ?>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transfer Persediaanr</h3> 
                  <button id="confirmAll" class="btn btn-sm btn-success pull-right" style="margin-right: 12px;padding: 4px 25px">Transfer Item Terpilih</button> 
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>No Dokumen</th>
                        <th><input type="checkbox" id="selectAll" /> Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>Keterangan</th>
                        <th width="8%">Aksi</th>
                        <th> kd_lokasi </th>
                        <th> kd_lok_msk </th>
                        <th> kd_ruang_msk </th>
                        <th> nm_satker </th>
                        <th> nm_satker_msk </th>
                        <th> kd_brg </th>
                        <th> nm_brg </th>
                        <th> satuan </th>
                        <th> qty </th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <?php } ?>
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
    <script src="../dist/js/notify.js"></script>
    <?php if ($_POST['manage']=="trans_masuk") { ?>
    <script type="text/javascript">

    var table;
      $(function () {
        $("li#trans_masuk").addClass("active");
        table = $("#example1").DataTable({
          "aaSorting": [[ 0, 'desc' ]],
          "processing": false,
          "serverSide": true,
          "ajax":
          {
            'type': 'GET',
            'url': '../core/loadtable/loadtransmskitm',
            'data': {
               no_dok: '<?php echo $_POST["no_dok"]?>',
               kd_sat: '<?php echo $_POST["kd_satker"]?>'
            },
          },
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1,
             "visible": false  },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"targets": 6 },
            {"targets": 7 },
            {"targets": 8 },
            {"targets": 9 },
            {"targets": 10,
             "visible": true }

          ],
        });

      });
    </script>

<!-- ########################################################################## -->
    <?php } else if ($_POST['manage']=="trans_keluar") { ?>
<!-- ########################################################################## -->

    <script type="text/javascript">
     $("li#trans_keluar").addClass("active");
    table = $("#example1").DataTable({
          "aaSorting": [[ 0, 'desc' ]],
          "processing": false,
          "serverSide": true,
          "ajax":
          {
            'type': 'GET',
            'url': '../core/loadtable/loadtransklritm',
            'data': {
               no_dok:   '<?php echo $_POST["no_dok"]?>',
               kd_ruang: '<?php echo $_POST["kd_ruang"]?>',
               kd_sat: '<?php echo $_POST["kd_satker"]?>'
            },
          },
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1,
             "visible": false  },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"targets": 6 },
            {"targets": 7 },
            {"targets": 8 },
            {"targets": 9 }

          ],
        });
    </script>

<!-- ########################################################################## -->
    <?php } else if ($_POST['manage']=="transfer") { ?>
<!-- ########################################################################## -->

    <script type="text/javascript">

      $('#selectAll').on('click', function(){
   // Get all rows with search applied
         var rows = table.rows({ 'search': 'applied' }).nodes();
         // Check/uncheck checkboxes for all rows in the table
         $('input[type="checkbox"]', rows).prop('checked', this.checked);
      });
      $('#confirmAll').on('click', function(){
        var id = [];
            $.each($("input[name='id']:checked"), function(){            
                id.push($(this).val());
            });
        $("#selectAll").prop( "disabled", true );
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'konfirmasi_transfer',id:id},
          dataType: "json",
          success: function (output) {
            alert('Barang Telah Di Transfer ');
          }
        });
         
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            baca_tabel();
          $("#selectAll").prop( "disabled", false );

      });
    var table;
     $("li#trans_keluar").addClass("active");
     function baca_tabel(){
        table = $("#example1").DataTable({
            "ordering": false,
            "processing": false,
            "serverSide": true,
            "ajax":
            {
              'type': 'GET',
              'url': '../core/loadtable/load_item_transfer',
              'data': {
                 no_dok: '<?php echo $_POST["satker"]?>',
              },
            },
            "columnDefs":
            [
              {"targets": 0,
               "visible": false },
              {"targets": 1,
               "visible": false  },
              {"targets": 2 },
              {"targets": 3 },
              {"targets": 4 },
              {"targets": 5 },
              {"targets": 6 },
              {"targets": 7 },
              {"targets": 8 },
              {"targets": 9 },
              {"targets": 10 },
              {"targets": 11,
               "visible": false },
              {"targets": 12,
               "visible": false },
              {"targets": 13,
               "visible": false },
              {"targets": 14,
               "visible": false },
              {"targets": 15,
               "visible": false },
              {"targets": 16,
               "visible": false },
              {"targets": 17,
               "visible": false },
              {"targets": 18,
               "visible": false },
              {"targets": 19,
               "visible": false },
            ],
          });
        }
          baca_tabel();
          $(document).on('click', '#btnkonfirm', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          manage = "konfirmasi_transfer";
       var id = [];
          id_row = row.data()[0];
          id.push(id_row);
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'konfirmasi_transfer',id:id},
          dataType: "json",
          success: function (output) {
            alert('Barang Telah Di Transfer ');
          }
        });
        $("#example1").DataTable().destroy();
        $("#example1 tbody").empty();
        baca_tabel();
      });


        $(document).on('click', '#hapus_transfer', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          id = row.data()[0];
          kd_brg = row.data()[10];
          $.ajax({
            type: "post",
            url: '../core/transaksi/prosestransaksi',
            data: {manage:'hapus_transfer', id:id, kd_brg:kd_brg},
            dataType: "json",
            success: function (output) {
              alert(output);
            }
          });
          $("#example1").DataTable().destroy();
          $("#example1 tbody").empty();
          baca_tabel();
        });

    </script>
    <?php } ?>
  </body>
</html>
<?php }?>
