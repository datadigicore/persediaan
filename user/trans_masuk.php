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
                  <h3 class="box-title">Tambah Dokumen Transaksi </h3>
                </div>
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Identitas Transaksi</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Item Transaksi</a></li>
                  </ul>
                </div>
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="addtransmsk">
                  <div class="box-body">
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Jenis Transaksi</label>
                          <div class="col-sm-9">
                            <select name="jenis_trans" id="jenis_trans" class="form-control">
                              <option value="">Pilih Jenis Transaksi</option>
                              <option value="M01">Saldo Awal</option>
                              <option value="M02">Pembelian</option>
                              <option value="M03">Transfer Masuk</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Nomor Dokumen</label>
                          <div class="col-sm-9">
                            <input type="text" name="no_dok" class="form-control"  id="no_dok" placeholder="Masukkan No. Dokumen">
                            <input type="hidden" name="manage" value="tbh_transaksi_msk">
                            <input type="hidden" name="tahun_ang" id="tahun_ang" value='<?php echo $_SESSION['thn_ang']; ?>'>    
                          </div>
                        </div>
                        <div class="form-group">                     
                        <label class="col-sm-2 control-label">Nomor Bukti</label>
                          <div class="col-sm-9">
                            <input type="text" name="no_bukti" class="form-control" id="no_bukti" placeholder="Masukkan Nomor Bukti">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                          <div class="col-sm-9">
                            <input type="text" name="tgl_dok" class="form-control" id="tgl_dok" placeholder="Masukkan Tanggal Dokumen" readonly>
                          </div>
                        </div>                    
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Tanggal Buku</label>
                          <div class="col-sm-9">
                            <input type="text" name="tgl_buku" class="form-control" id="tgl_buku" placeholder="Masukkan Tanggal Buku" readonly>
                          </div> 
                        </div>
                      </div>
                      <div class="tab-pane" id="tab_2">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Keterangan</label>
                          <div class="col-sm-9">
                            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Uraian / Keterangan">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Kode Barang</label>
                          <div class="col-sm-9">
                            <select name="kd_brg" id="kd_brg" class="form-control">
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Jumlah Masuk</label>
                          <div class="col-sm-9">
                            <input type="number" min="1" name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah Masuk">
                          </div>
                        </div>                  
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Harga Beli Satuan</label>
                          <div class="col-sm-9">
                            <input type="number" min="1" name="rph_sat" class="form-control" id="rph_sat" placeholder="Masukkan Harga ">
                          </div>
                        </div>                  
                        <div name="detil_transaksi" id="detil_transaksi">
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
                  <h3 class="box-title">Daftar Transaksi Masuk</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="5%">ID</th>
                        <th width="14%">No Dokumen</th>
                        <th >No Bukti</th>
                        <th>Tanggal Dokumen</th>
                        <th>Tanggal Buku</th>
                        <th>Nama Barang</th>
                        <th width="3%">Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th width="19%">Aksi</th>
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
        $('#tgl_dok').css('background-color' , '#FFFFFF');
        $('#tgl_buku').css('background-color' , '#FFFFFF');
        $("li#trans_masuk").addClass("active");
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
          "ajax": "../core/loadtable/loadtransmsk",
          "columnDefs":
          [
            {"targets": 0 },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"targets": 6 },
            {"targets": 7 },
            {"targets": 8 },                      
            {"targets": 9 },                      
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                // '<a href="edit_trans_masuk?id=a" class="btn btn-success btn-sm daterange pull-left" role="button"><i class="fa fa-edit"></i></a>'+
                                  '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [10],"targets": 10 },

          ],
        });
      });

      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        nd = row.data()[1];
        nbukti = row.data()[2];
        td = row.data()[3];
        tbuku = row.data()[4];
        nbrg = row.data()[5];
        qty = row.data()[6];
        hrg = row.data()[7];
        ket = row.data()[9];
      
      $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'cek_hapus',id_row:id_row},
          dataType: "json",
          success: function (output)
          {
            if(output.qty!=null)
            {
              alert("Tidak dapat mengkoreksi transaksi, barang sudah dikeluarkan pada tanggal "+output.tgl_dok+" sebanyak "+output.qty+" "+output.satuan);
              return false;
            }
          
            else
            {        
              document.location.href = 'edit_trans_masuk?kd='+id_row+'&nd='+nd+'&td='+td+'&ket='+ket+'&nbrg='+nbrg+'&qty='+qty+'&hrg='+hrg+'&nbukti='+nbukti+'&tbuku='+tbuku;
            }
          }
        });
      });

      $(document).on('click', '#btnhps', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      redirectTime = "2600";
      redirectURL = "trans_masuk";
      id_row = row.data()[0];
      managedata = "hapusTransMasuk";

      $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'cek_hapus',id_row:id_row},
          dataType: "json",
          success: function (output) {
            if(output.qty!=null) {
          alert("Tidak dapat menghapus, barang sudah dikeluarkan pada tanggal "+output.tgl_dok+" sebanyak "+output.qty+" "+output.satuan);
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
          data: {manage:'readbrg'},
          success: function (output) {     
            $('#kd_brg').html(output);
          }
       });
      $('#kd_brg').change(function(){
        if ($(this).val()=='') {
          
        }
        else {
          var kd_brg = $('#kd_brg').val(); 
          var no_dok = $('#no_dok').val(); 
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'baca_detil_trans',kd_brg:kd_brg,no_dok:no_dok},
          success: function (output) {     
            $('#detil_transaksi').html(output);
          }
       });
        }
      });



      $('#addtransmsk').submit(function(e){
        var jns_trans = document.getElementById("jenis_trans").value;
        var kd_brg = document.getElementById("kd_brg").value;
        var tahun_ang = document.getElementById("tahun_ang").value;
        var sisa = document.getElementById("rph_sat").value;
        var jumlah_input = document.getElementById("jml_msk").value;
        var tgl_dok = document.getElementById("tgl_dok").value;
        var tgl_buku = document.getElementById("tgl_buku").value;
        var tgl_terakhir = "";

        if(jns_trans=="")
         {
          alert("Jenis Transaksi Belum Dipilih")
          return false;
         }
        if(tgl_dok.substring(6,10)!=tahun_ang){
          alert("Tahun Dokumen Tidak Sesuai Dengan Tahun Anggaran");
          return false;
        }

        if(tgl_buku.substring(6,10)!=tahun_ang){
          alert("Tahun Bukti Tidak Sesuai Dengan Tahun Anggaran");
          return false;
        }
        


         if(kd_brg=="")
         {
          alert("Kode Barang Belum Dipilih")
          return false;
         } 

        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "trans_masuk";
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
