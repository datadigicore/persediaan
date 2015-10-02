<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/datepicker.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue layout-boxed">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Opname Fisik
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-retweet"></i> Opname Fisik</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah  Hasil Opname Fisik </h3>
                </div>  
                <form action="../core/opsik/prosesopsik" method="post" class="form-horizontal" id="addtransmsk">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nomor Dokumen</label>
                      <div class="col-sm-2">
                        <select name="read_no_dok" id="read_no_dok" class="form-control">
                        </select>
                      </div>
                      <div class="col-sm-7"> 
                        <input type="text" name="no_dok" class="form-control" id="no_dok" placeholder="Masukkan No. Dokumen" required>
                        <input type="hidden" name="manage" value="tbh_opname">  
                        <input type="hidden" name="jenis_trans" value="P01">  
                      </div>
                    </div>
<!--                     <div class="form-group">                     
                    <label class="col-sm-2 control-label">Nomor Bukti</label>
                      <div class="col-sm-9">
                        <input type="text" name="no_bukti" class="form-control" id="no_bukti" placeholder="Masukkan Nomor BUkti" required>
                      </div>
                    </div> -->
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                      <div class="col-sm-9">
                        <input type="text" name="tgl_dok" class="form-control" id="tgl_dok" placeholder="Masukkan Tanggal Dokumen" required>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Buku</label>
                      <div class="col-sm-9">
                        <input type="text" name="tgl_buku" class="form-control" id="tgl_buku" placeholder="Masukkan Tanggal Buku" required>
                      </div> 
                    </div>                   
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Keterangan</label>
                      <div class="col-sm-9">
                        <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Persediaan</label>
                      <div class="col-sm-9">
                        <select name="kd_brg" id="kd_brg" class="form-control">
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Jumlah</label>
                      <div class="col-sm-5">
                        <input type="number" min="0" name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah Hasil Opname" required>
                      </div>                      
                      <div class="col-sm-4">
                        <input type="text"  name="satuan" class="form-control" id="satuan" readonly>
                      </div>
                    </div>
                    <div name="detil_transaksi" id="detil_transaksi">
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="Reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-info pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Opname Fisik</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="10%">ID</th>
                        <th width="14%">No Dokumen</th>
                        <th>Tanggal</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th width="6%">Aksi</th>
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
    var table;
      $(function () {
        $("li#opname").addClass("active");
        $('#tgl_dok').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_dok').datepicker().on("changeDate", function(e) {
          $('#tgl_buku').val($(this).val());
          $(this).datepicker('hide');
        });
        $('#tgl_buku').datepicker({
          format: "dd-mm-yyyy"
        });
        $('#tgl_buku').datepicker().on("changeDate", function(e) {
          $(this).datepicker('hide');
        });             
        $("li#saldo_awal").addClass("active");
        table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadopsik",
          "columnDefs":
          [
            {"targets": 0,
             "visible":false  },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5,
             "visible":false },
            {"targets": 6 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [7],"targets": 7 }         

          ],
        });
      });
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readsatkerdok',no_dok:"<?php echo($_SESSION['kd_lok']);?>"},
          success: function (output) {     
            $('#read_no_dok').html(output);
          }
        });
       $.ajax({
          type: "post",
          url: '../core/opsik/prosesopsik',
          data: {manage:'readbrg'},
          success: function (output) {     
            $('#kd_brg').html(output);
          }
       });
      $('#kd_brg').change(function(){
        if ($(this).val()=='') {
          $('#satuan').val('');
        }
        else {
          var kd_brg = $('#kd_brg').val(); 
          var no_dok = $('#no_dok').val(); 
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'baca_detil_trans',kd_brg:kd_brg,no_dok:no_dok},
          dataType:"json",
          success: function (output) {     
            $('#satuan').val(output.satuan);
          }
       });
        }
      });

    $(document).on('click', '#btnhps', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          redirectTime = "2600";
          redirectURL = "opname";
          id = row.data()[0];
          managedata = "hapusOpname";
          
                
                job=confirm("Anda yakin ingin menghapus data ini?");
                if(job!=true)
                {
                  return false;
                }
                else
                {
                  $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                  });
                  $('#myModal').modal('show');
                  $.ajax({
                    type: "post",
                    url : "../core/opsik/prosesopsik",
                    data: {manage:managedata,id:id},
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
          });


      $('#addtransmsk').submit(function(e){
        var brg = document.getElementById("kd_brg").value;
        var jml = document.getElementById("jml_msk").value;
        if(brg=="")
        {
          alert("Kode Persediaan Belum Dipilih");
          return false;
        }
        job=confirm("Setelah memasukan opname, penghapusan transaksi masuk dan keluar tidak dapat dilakukan kembali.\n Data Opname tidak dapat diubah atau dihapus kembali.\n\nAnda Yakin Menambah Opname berikut ini?\nKode Persediaan : "+brg+"\nJumlah : "+jml);
        if(job!=true){
          return false;
        }
        else
        {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "opname";
        var formURL = $(this).attr("action");
        var addData = new FormData(this);
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
      });
    </script>
  </body>
</html>
