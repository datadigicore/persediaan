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
            Persediaan Masuk
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Masuk</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Temporary Import Masuk</h3><button type="submit" form="formSave" id="simpanImport" class="col-md-1 btn btn-primary pull-right"><i class="fa fa-save"></i> Simpan</button>
                </div>
                <form action="../core/transaksi/prosestransaksi" method="post" id="formSave">
                  <input type="hidden" name="manage" value="add_temp_item_trans_masuk">
                </form>
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal"  id="addtransmsk"  >
                  <input type="hidden" name="manage" value="tbh_transaksi_msk">
                  <input type="hidden" name="tahun_ang" id="tahun_ang" value='<?php echo $_SESSION['thn_ang']; ?>'>
                  <div class="box-body" style="padding-top:15px;">

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Keterangan</label>
                      <div class="col-sm-8">
                        <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Mis. Nama Pihak / Sumber pengirim barang" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Jenis Transaksi</label>
                      <div class="col-sm-3">
                        <input name="jenis_trans" id="jenis_trans" class="form-control" placeholder="Jenis Transaksi" disabled>
                      </div>
                      <label class="col-sm-2 control-label">Nomor Dokumen</label>
                      <div class="col-sm-3">
                        <input type="text" name="no_dok" class="form-control"  id="no_dok" placeholder="Masukkan No. SP / BASTP / dsb" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-3">
                        <input name="read_satker" id="read_satker" class="form-control" placeholder="Kode Satker" disabled>
                      </div>
                      <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                      <div class="col-sm-3">
                        <input type="text" name="tgl_dok" class="form-control" id="tgl_dok" placeholder="dd-mm-yyyy" disabled>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Ruang</label>
                      <div class="col-sm-3">
                        <input name="kd_ruang" id="kd_ruang" class="form-control" placeholder="Kode Ruang" disabled>
                      </div>
                      <label class="col-sm-2 control-label">Tanggal Pembukuan</label>
                      <div class="col-sm-3">
                        <input type="text" name="tgl_buku" class="form-control" id="tgl_buku" placeholder="dd-mm-yyyy" disabled>
                      </div>
                    </div>


                  </div>
                </form>
                <div class="box-footer">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Kode Barang</th>
                        <th>No Dokumen</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Kode Rekening</th>
                        <th>Nil. Non Persediaan</th>
                        <th>Ket. Non Persediaan</th>
                        <th>Pesan Error</th>
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
    <div class="modal fade" id="importModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="../core/import/prosesimport" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="manage" value="importTransMasuk">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color:white">×</span></button>
              <h4 class="modal-title">Import Transaksi Masuk</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input type="file" id="fileimport" name="fileimport" style="display:none;">
                <a id="selectbtn" class="col-sm-2 btn btn-flat btn-primary" style="position:absolute;right:16px;">Pilih File</a>
                <input type="text" id="filename" class="form-control" placeholder="Pilih File .xls / .xlsx" readonly>
              </div>
            </div>
            <div class="modal-footer">
              <a href="../dist/uploads/ImportSimsediaTransMasuk.xls" class="col-sm-4 pull-left btn btn-md btn-warning"><i class="fa fa-download"></i>&nbsp;&nbsp;&nbsp;Download Template</a>
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
      var table;
      var errormessage;
      $.ajax({
        type: "post",
        url: '../core/transaksi/prosestransaksi',
        data: {manage:'checkErrorMessage'},
        success: function (output) {
          errormessage = output;
        }
      });
      table = $("#example1").DataTable({
        "sorting": [[ 1, 'asc' ],[ 2  , 'asc' ]],
        "processing": false,
        "serverSide": true,
        "ajax": "../core/loadtable/temptransmsk",
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
          {"targets": 9 }
        ],
        "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
        "drawCallback": function ( settings ) {
          var api = this.api();
          if (api.ajax.json().recordsTotal == 0 || errormessage != 0) {
            $("#simpanImport").attr('disabled', 'disabled');
          }
        },
        "rowCallback": function( row, data, index ) {
          if (!data[2] && data[3] == 0) {
            $(row).html('<td>'+data[1]+'</td><td colspan="4" style="text-align:center">Transaksi Non Persediaan</td><td>'+data[6]+'</td><td>'+data[7]+'</td><td>'+data[8]+'</td><td></td>');
            $(row).css({"background-color": "#388E3C","color":"white"});
          }
          if (data[9]) {
            $(row).css({"background-color": "#B71C1C","color":"white"});
          }
        }
      });
    </script>
  </body>
</html>
