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
            Persediaan Keluar
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Keluar</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transaksi Keluar</h3> <a href="#importModal" data-toggle="modal" class="btn btn-sm btn-success pull-right" style="margin-right: 12px;padding: 4px 25px">Import</a>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="18%">No Dokumen</th>
                        <th width="18%">Satker Pengirim</th>
                        <th width="18%">Satker Penerima</th>
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
    <style type="text/css">
      .modal {
        text-align: center;
        padding: 0!important;
      }
      .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
      }
      .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
      }
    </style>
    <div class="modal fade" id="importModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="../core/import/prosesimport" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="manage" value="importTransTransfer">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color:white">×</span></button>
              <h4 class="modal-title">Import Transaksi Transfer</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="file" id="fileimport" name="fileimport" style="display:none;">
                <a id="selectbtn" class="col-sm-2 btn btn-flat btn-primary" style="position:absolute;right:16px;">Pilih File</a>
                <input type="text" id="filename" class="form-control" placeholder="Pilih File .xls / .xlsx" readonly>
              </div>
            </div>
            <div class="modal-footer">
              <a href="../dist/uploads/Template_Import_Transfer.xls" class="col-sm-4 pull-left btn btn-md btn-warning"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Download Template</a>
              <button type="submit" class="col-sm-2 pull-right btn btn-flat btn-success">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="../dist/js/jquery.mask.js" ></script>
    <script type="text/javascript">
    $('#selectbtn').click(function () {
        $("#fileimport").trigger('click');
      });
      $("#fileimport").change(function(){
        $("#filename").attr('value', $(this).val().replace(/C:\\fakepath\\/i, ''));
      });
      $('#selectbtn-revisi').click(function () {
        $("#fileimport-revisi").trigger('click');
      });
      $("#fileimport-revisi").change(function(){
        $("#filename-revisi").attr('value', $(this).val().replace(/C:\\fakepath\\/i, ''));
      });
      function masuk_tanggal() {

        var tgl_dok = $('#tgl_dok').val();
        $('#tgl_buku').val(tgl_dok);


      }

      var table;
      $(function () {
        $(".select2").select2();
        $("li#transfer").addClass("active");
        $('#tgl_dok').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('#tgl_buku').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('#tgl_dok').datepicker({
          format: "dd-mm-yyyy"
        });
        $("li#transfer").addClass("active");
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
            {"targets": 6 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btntmbh" class="btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i>Lihat Barang</button>'+
                                '</div>',
             "targets": [7],"targets": 7 }         

          ],
        });
      });

      $(document).on('click', '#btntmbh', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        manage = "transfer";
        id_row = row.data()[0];
        jns_trans = row.data()[4];
        satker = row.data()[1];
        nm_satker = row.data()[2];
        nm_satker_msk = row.data()[3];
        tgl_dok = row.data()[4];
        tgl_buku = row.data()[7];
        kd_satker = satker.substring(0,11);

        var $form=$(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action","trans_item_brg");
        var $input=$(document.createElement('input')).css({display:'none'}).attr('name','id').val(id_row);
        var $input2=$(document.createElement('input')).css({display:'none'}).attr('name','jenistrans').val(jns_trans);
        var $input3=$(document.createElement('input')).css({display:'none'}).attr('name','tanggaldok').val(tgl_dok);
        var $input4=$(document.createElement('input')).css({display:'none'}).attr('name','tanggalbuku').val(tgl_buku);
        var $input5=$(document.createElement('input')).css({display:'none'}).attr('name','satker').val(satker);
        var $input6=$(document.createElement('input')).css({display:'none'}).attr('name','manage').val(manage);
        var $input7=$(document.createElement('input')).css({display:'none'}).attr('name','kd_satker').val(kd_satker);
        var $input8=$(document.createElement('input')).css({display:'none'}).attr('name','nm_satker_msk').val(nm_satker_msk);
        var $input9=$(document.createElement('input')).css({display:'none'}).attr('name','nm_satker').val(nm_satker);
        $form.append($input).append($input2).append($input3).append($input4).append($input5).append($input6).append($input7).append($input8).append($input9);
        $("body").append($form);
        $form.submit();
      });

    </script>
  </body>
</html>
