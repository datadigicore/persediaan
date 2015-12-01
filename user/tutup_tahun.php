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
            Import Saldo Awal
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i></a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                </div>  
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="addtransmsk" >
                   <input type="hidden" name="manage" value="tutup_tahun">  
                  <div class="box-body">
                      <p>
                        Import saldo awal dilakukan untuk menjumlahkan data-data persediaan tahun sebelumnya
                      
                        Setelah proses tutup tahun, data-data persediaan tahun sebelumnya tidak dapat dibuka lagi.
                     
                       Untuk melakukan proses tutup tahun, pilih kode satker yang akan dilakukan import saldo awal, kemudian klik proses.
                      </p>
                    </div>                   
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-8">
                        <select name="satker" id="satker" class="form-control">
                        </select>
                      </div>
                    </div> 
                    <div class="box-footer">
                      <!-- <button type="Reset" class="btn btn-default">Reset</button> -->
                      <button type="submit" class="btn btn-info pull-right">Proses</button>
                    </div>
                  </div>
                </form>
            </section>
          </div>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Hasil Import Saldo Awal</h3>
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
                        <th width="8%">Kode Satker</th>
           
                      </tr>
                    </thead>
                  </table>
                </div>
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

          table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/saldo_awal",
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
            {"targets": 8,
             "visible": false },
            {"targets": 9,
             "visible": true },
             {"targets": 10,
             "visible": true },

          ],
        });
      $(".treeview").addClass("active");
      $("li#tutup_tahun").addClass("active");
       $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readsatkerdok'},
          success: function (output) {     
            $('#satker').html(output);
          }
       });

    $('#addtransmsk').submit(function(e){

        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "tutup_tahun";
        var formURL = $(this).attr("action");
        var addData = new FormData(this);
        var kd_lokasi = $('#satker').val();
          $.ajax({
            type: "post",
            url: '../core/transaksi/validasi',
            data: {manage:'cek_opname_thn_lalu',kd_lokasi:kd_lokasi},
            dataType: "json",
            success: function (output) {
              if(output.st_op=="0"){
                alert("Sebelum Melakukan Import Saldo Awal, Lakukan Stock Opname untuk seluruh barang di tahun anggaran Sebelumnya!");
                return false;
              }
              else {
                $('#myModal').modal({
                  backdrop: 'static',
                  keyboard: false
                });
                $('#myModal').modal('show');
                $.ajax({
                  type: "post",
                  data: addData,
                  url : formURL,
                  contentType: false,
                  cache: false,  
                  processData: false,
                  success: function(data)
                  {
                    $("#success-alert").alert();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $("#success-alert").alert('close');
                    });
                    setTimeout("location.href = redirectURL;",redirectTime); 
                  }
                });
                return false;
              }
            }
          });

      });
    </script>
  </body>
</html>
