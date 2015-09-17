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
            Persediaan Keluar
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-expand"></i> Transaksi Keluar</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Transaksi Keluar </h3>
                </div>
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs nav-justified">
                    <li class="active" id="li_tab_1"><a href="#tab_1" data-toggle="tab">Identitas Transaksi</a></li>
                    <li id="li_tab_2"><a href="#tab_2" data-toggle="tab">Item Transaksi</a></li>
                  </ul>
                </div>  
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="addtransmsk">
                  <div class="box-body" style="padding:0;">
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Jenis Transaksi</label>
                          <div class="col-sm-9">
                            <select name="jenis_trans" id="jenis_trans" class="form-control">
                              <option value="">Pilih Jenis Transaksi</option>
                              <option value="K01">Habis Pakai</option>
                              <option value="K02">Usang</option>
                              <option value="K03">Rusak</option>
                              <option value="K04">Transfer Keluar</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Nomor Dokumen</label>
                          <div class="col-sm-9">
                            <input type="text" name="no_dok" class="form-control" id="no_dok" placeholder="Masukkan No. Dokumen">
                            <input type="hidden" name="manage" value="tbh_transaksi_klr">  
                            <input type="hidden" name="tahun_ang" id="tahun_ang" value='<?php echo $_SESSION['thn_ang']; ?>'>  
                          </div>
                        </div>
                        <div class="form-group">                     
                        <label class="col-sm-2 control-label">Nomor Bukti</label>
                          <div class="col-sm-9">
                            <input type="text" name="no_bukti" class="form-control" id="no_bukti" placeholder="Masukkan Nomor BUkti">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                          <div class="col-sm-9">
                            <input type="text" name="tgl_dok" max="10" class="form-control" id="tgl_dok" placeholder="Masukkan Tanggal Dokumen" readonly>
                          </div>
                        </div>                    
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Tanggal Buku</label>
                          <div class="col-sm-9">
                            <input type="text" name="tgl_buku" max="10" class="form-control" id="tgl_buku" placeholder="Masukkan Tanggal Buku" readonly>
                          </div> 
                        </div>
                      </div>
                      <div class="tab-pane" id="tab_2"> 
                        <div class="row">
                        <div class="col-sm-5">    
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Jenis Transaksi</label>
                            <div class="col-sm-7">
                              <input type="text" id="disjenistrans" name="disjenistrans" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Tgl. Dokumen</label>
                            <div class="col-sm-7">
                              <input type="text" id="distgldok" name="distgldok" class="form-control" disabled>
                            </div>
                          </div>                  
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Tgl. Buku</label>
                            <div class="col-sm-7">
                              <input type="text" id="distglbuku" name="distglbuku" class="form-control" disabled>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Satker</label>
                            <div class="col-sm-7">
                              <input type="text" id="dissatker" name="dissatker" class="form-control" disabled>
                            </div>
                          </div>                  
                          <div class="form-group">
                            <label class="col-sm-5 control-label">Total Transaksi</label>
                            <div class="col-sm-7">
                              <input type="text" id="distottrans" name="distottrans" class="form-control" disabled>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-7">    
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-8">
                              <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Keterangan">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Kode Barang</label>
                            <div class="col-sm-8">
                              <select name="kd_brg" id="kd_brg" class="form-control">
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Jml dikeluarkan</label>
                            <div class="col-sm-8">
                              <input type="number" min="1" max name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah Keluar">
                            </div>
                          </div>                  
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Saldo Barang</label>
                            <div class="col-sm-8">
                              <input type="text" name="rph_sat" class="form-control" id="rph_sat" placeholder="Saldo Barang" readonly required>
                            </div>
                          </div>                  
                        </div>
                        </div>
                      </div>
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
                  <h3 class="box-title">Daftar Transaksi Keluar</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="10%">ID</th>
                        <th width="14%">Nomor Dokumen</th>
                        <th>Tanggal Buku</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
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
    <script type="text/javascript">
    var table;
      $(function () {
        $("li#trans_keluar").addClass("active");
        $('#tgl_dok').css('background-color' , '#FFFFFF');
        $('#tgl_buku').css('background-color' , '#FFFFFF');
        $('#rph_sat').css('background-color' , '#FFFFFF');
        $('#tgl_dok').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_buku').datepicker({
          format: "dd-mm-yyyy"
        });             
        $("li#saldo_awal").addClass("active");
        table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadtransklr",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  // '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [8],"targets": 8 }         

          ],
        });
      });
      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "trans_keluar";
      id_row = row.data()[0];
      managedata = "hapusTransKeluar";

      $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'cek_brg_keluar',id_row:id_row},
          dataType: "json",
          success: function (output)
          {
            if(output.st_op==1)
            {
              alert("Tidak Dapat Menghapus Barang yang sudah diopname !");
              return false;
            }
            else
            {

              job=confirm("Anda yakin ingin menghapus data ini?");
                if(job!=true){
                  return false;
                }
                else{
                  $('#myModal').modal({
                    backdrop: 'static',
                    keyboard: false
                  });
                  $('#myModal').modal('show');
                  $.ajax({
                    type: "post",
                    url : "../core/transaksi/prosestransaksi",
                    data: {manage:managedata,id:id_row},
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
          }
        });
      });
       $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readbrgmsk'},
          success: function (output) {     
            $('#kd_brg').html(output);
          }
       });
      // $('#kd_brg').change(function(){
      //   if ($(this).val()=='') {
      //     $('#detil_transaksi').html('<option value="">-- Belum Dicetak --</option>');
      //   }
      //   else {
      //     var kd_brg = $('#kd_brg').val(); 
      //     var no_dok = $('#no_dok').val(); 
      //     $.ajax({
      //     type: "post",
      //     url: '../core/transaksi/prosestransaksi',
      //     data: {manage:'baca_detil_trans',kd_brg:kd_brg,no_dok:no_dok},
      //     success: function (output) {     
      //       $('#detil_transaksi').html(output);
      //     }
      //  });
      //   }
      // });
      $('#kd_brg').change(function(){
        if ($(this).val()=='') {
          $('#rph_sat').val('');
        }
        else {
          var kd_brg = $('#kd_brg').val(); 
          $.ajax({
            type: "post",
            url: '../core/transaksi/prosestransaksi',
            data: {manage:'sisabarang',kd_brg:kd_brg},
            dataType: "json",
            success: function (output) {
            $('#rph_sat').val(output.sisa);

            document.getElementById("jml_msk").setAttribute("max",output.sisa)

            }
          });
        }
      });
      $('#addtransmsk').submit(function(e){
        var tahun_ang = document.getElementById("tahun_ang").value;
        var sisa = document.getElementById("rph_sat").value;
        var jumlah_input = document.getElementById("jml_msk").value;
        var tgl_dok = document.getElementById("tgl_dok").value;
        var tgl_buku = document.getElementById("tgl_buku").value;

      if(tgl_dok.substring(6,10)!=tahun_ang){
        alert("Tahun Dokumen Tidak Sesuai Dengan Tahun Anggaran");
        return false;
      }

      if(tgl_buku.substring(6,10)!=tahun_ang){
        alert("Tahun BUkti Tidak Sesuai Dengan Tahun Anggaran");
        return false;
      }
      
      if(parseInt(jumlah_input)>parseInt(sisa))
      {
        alert("Jumlah Keluar tidak boleh melebihi saldo barang "+jumlah_input+" "+sisa);
        
        return false;
      }




        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "trans_keluar";
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
      });
    </script>
  </body>
</html>
