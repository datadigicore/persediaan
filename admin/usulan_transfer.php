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
            Usulan Transfer Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-expand"></i> Usulan Transfer Persediaan</a></li>
          </ol>
        </section>
        <section class="content">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Usulan Transfer Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="18%">Satker Pengirim</th>
                        <th width="18%">Satker Penerima</th>
                        <th width="18%">Nomor Dok.</th>
                        <th>Tanggal Dokumen</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th width="5%">Status</th>
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
    <script src="../dist/js/jquery.mask.js" ></script>
    <script type="text/javascript">
    var table;

    function baca_tabel(){
      table = $("#example1").DataTable({
          "aaSorting": [[ 0, 'desc' ]], 
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/usulan_transfer",
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
            {"targets": 7 },
            {"targets": 8 },
            {"targets": 9 },
               

          ],
        });
    }
      $(function () {

        baca_tabel();

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
        $(document).on('click', '#btntmbh', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          manage = "trans_keluar";
          id_row = row.data()[0];
          jns_trans = row.data()[1];
          satker = row.data()[1];
          tgl_dok = row.data()[3];
          tgl_buku = row.data()[4];
          kd_satker = satker.substring(0,11);
          var $form=$(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action","transfer_item");
          var $input=$(document.createElement('input')).css({display:'none'}).attr('name','id').val(id_row);
          var $input2=$(document.createElement('input')).css({display:'none'}).attr('name','jenistrans').val("TRANSFER");
          var $input3=$(document.createElement('input')).css({display:'none'}).attr('name','tanggaldok').val(tgl_dok);
          var $input4=$(document.createElement('input')).css({display:'none'}).attr('name','tanggalbuku').val(tgl_buku);
          var $input5=$(document.createElement('input')).css({display:'none'}).attr('name','satker').val(satker);
          var $input6=$(document.createElement('input')).css({display:'none'}).attr('name','manage').val(manage);
          var $input7=$(document.createElement('input')).css({display:'none'}).attr('name','kd_satker').val(kd_satker);
          $form.append($input).append($input2).append($input3).append($input4).append($input5).append($input6).append($input7);
          $("body").append($form);
          $form.submit();
        });

      $(document).on('click', '#btnkonfirm', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          manage = "konfirmasi_transfer";
          id_row = row.data()[0];
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'konfirmasi_transfer',id:id_row},
          dataType: "json",
          success: function (output) {
            
          }
        });
        $("#example1").DataTable().destroy();
        $("#example1 tbody").empty();
        baca_tabel();   
      });
       
      });
 
       
    </script>
  </body>
</html>
