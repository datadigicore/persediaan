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
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>  
                <form action="../core/kanwil" method="post" class="form-horizontal" id="addkanwil">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPB</label>
                      <div class="col-sm-9">
                        <input type="hidden" name="manage" value="addkanwil">
                        <select name="kduapb" id="kodeuapb" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode UAPPB-E1</label>
                      <div class="col-sm-9">
                        <select name="kduappbe" id="kodeuappbe" class="form-control">
                          <option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Kanwil</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodekanwil" class="form-control" id="kdkanwil" placeholder="Masukkan Kode Kanwil">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Uraian Kanwil</label>
                      <div class="col-sm-9">
                        <input type="text" name="uraiankanwil" class="form-control" id="uraiankanwil" placeholder="Masukkan Uraian Kantor Wilayah">
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>   
              </div>
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Tabel Daftar Kantor Wilayah</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">Kode UAPB</th>
                        <th width="18%">Kode UAPPB-E1</th>
                        <th width="14%">Kode Kanwil</th>
                        <th>Uraian Kantor Wilayah</th>
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
        $(".treeview").addClass("active");
        $("li#kanwil").addClass("active");
        $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadkanwil",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [4],"targets": 4 }
          ],
        });
      });
        $.ajax({
          type: "post",
          url: '../core/uappbe/prosesuappbe',
          data: {manage:'readuapb'},
          success: function (output) {     
            $('#kodeuapb').html(output);
          }
        });
      $('#kodeuapb').change(function(){
        if ($(this).val()=='') {
          $('#kodeuappbe').html('<option value="">-- Pilih Kode UAPB Terlebih Dahulu --</option>');
        }
        else {
          var kduapb = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/uappbw/prosesuappbw',
            data: {manage:'readuappbe',kodeuapb:kduapb},
            success: function (output) {
              $('#kodeuappbe').html(output);
            }
          });
        }
      });
    </script>
  </body>
</html>
