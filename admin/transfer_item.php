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
            Transfer Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-expand"></i> Transfer Persediaan</a></li>
          </ol>
        </section>
        <section class="content">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transaksi Keluar</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="18%">No Dokumen</th>
                        <th width="18%">Satker/Bid. tujuan</th>
                        <th>Tanggal Dokumen</th>
                        <th>Tanggal Pembukuan</th>
                        <th>Keterangan</th>
                        <th width="5%">Aksi</th>
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
          "ajax": "../core/loadtable/dok_transfer",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btntmbh" class="btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i>Lihat Barang</button>'+
                                '</div>',
             "targets": [6],"targets": 6 }         

          ],
        });
    }
      $(function () {

        baca_tabel();
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


       
      });
 
       
    </script>
  </body>
</html>
