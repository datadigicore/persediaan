<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue layout-boxed">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Unit Akuntansi Kuasa Pengguna Barang
            <small>Control Panel</small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Tabel UAKPB</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>
                <form action="../core/uakpb/prosesuakpb" method="post" class="form-horizontal" id="adduakpb">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="adduakpb">
                        <select name="kduapb" id="kduapb" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-E1</label>
                      <div class="col-sm-9">
					              <select name="kduappbe" id="kduappbe" class="form-control">
                          <option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPBW</label>
                      <div class="col-sm-9">
                        <select name="kduappbw" id="kduappbw" class="form-control">
                          <option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="kduakpb" class="form-control" id="kduakpb" placeholder="Masukkan Kode UAKPB">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="kduapkpb" class="form-control" id="kduapkpb" placeholder="Masukkan Kode UA">
                      </div>
                    </div>
					          <div class="form-group">
                      <label class="col-sm-2 control-label">Kode JK</label>
                      <div class="col-sm-9">
                        <select name="kdjk" id="kdjk" class="form-control">
                          <option value="">-- Pilih Kode Jenis Kantor --</option>
                          <option value="KD">KD  Kantor Daerah</option>
                          <option value="KP">KP  Kantor Pusat</option>
                          <option value="DK">DK  Dekonsentrasi</option>
                          <option value="TP">TP  Tugas Pembantuan</option>
                          <option value="UB">UB  Urusan Bersama</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian UAKPB</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmuakpb" class="form-control" id="nmuakpb" placeholder="Masukkan Uraian UAKPB">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form> 
              </div>
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Tabel Data UAKPB</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="10%">UAPB</th>
                        <th width="10%">UAPPBE1</th>
                        <th width="10%">UAPPBW</th>
                        <th width="10%">UAKPB</th>
                        <th width="10%">UAPKPB</th>
                        <th width="10%">JK</th>
                        <th>Uraian UAKPB</th>
                        <th width="9%">Aksi</th>
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
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(function () {
        $("li#uakpb").addClass("active");
        $.ajax({
          type: "post",
          url: '../core/uakpb/prosesuakpb',
          data: {manage:'readuapb'},
          success: function (output) {     
            $('#kduapb').html(output);
          }
        });
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loaduakpb",
          "columnDefs":
          [
            {"targets": 0 },
      			{"targets": 1 },
      			{"targets": 2 },
      			{"targets": 3 },
      			{"targets": 4 },
      			{"targets": 5 },
      			{"targets": 6 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [7],"targets": 7 }
          ],
        });
      });
      $('#kduapb').change(function(){
        if ($(this).val()=='') {
          $('#kduappbe').html('<option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>');
          $('#kduappbw').html('<option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>');
        }
        else {
          $('#kduappbw').html('<option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>');
          var kduapb = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/uakpb/prosesuakpb',
            data: {manage:'readuappbe',kduapb:kduapb},
            success: function (output) {
              $('#kduappbe').html(output);
            }
          });
        }
      });
      $('#kduappbe').change(function(){
        if ($(this).val()=='') {
          $('#kduappbw').html('<option value="">-- Pilih Kode UAPPB-E1 Terlebih Dahulu --</option>');
        }
        else {
          var kduapb = $('#kduapb').val();
          var kduappbe = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/uakpb/prosesuakpb',
            data: {manage:'readuappbw',kduapb:kduapb,kduappbe:kduappbe},
            success: function (output) {
              $('#kduappbw').html(output);
            }
          });
        }
      });
    </script>
  </body>
</html>
