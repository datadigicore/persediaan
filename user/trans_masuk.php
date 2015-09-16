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
                    <li class="active" id="li_tab_1"><a href="#tab_1" data-toggle="tab">Identitas Transaksi</a></li>
                    <li id="li_tab_2"><a href="#tab_2" data-toggle="tab">Item Transaksi</a></li>
                  </ul>
                </div>
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal"  id="addtransmsk" >
                  <div class="box-body" style="padding:0;">
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
                        <label class="col-sm-2 control-label">Nomor Transaksi</label>
                          <div class="col-sm-9">
                            <input type="text" name="no_bukti" class="form-control" id="no_bukti" placeholder="Masukkan Nomor Transaksi">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                          <div class="col-sm-9">
                            <input type="text" name="tgl_dok" class="form-control" id="tgl_dok" placeholder="Masukkan Tanggal Dokumen">
                          </div>
                        </div>                    
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Tanggal Buku</label>
                          <div class="col-sm-9">
                            <input type="text" name="tgl_buku" class="form-control" id="tgl_buku" placeholder="Masukkan Tanggal Buku">
                          </div> 
                        </div>
                        <div class="box-footer">
                          <button type="Reset" class="btn btn-default">Reset</button>
                          <button type="submit" class="btn btn-info pull-right">Submit</button>
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
                            <label class="col-sm-3 control-label">No. Dokumen</label>
                            <div class="col-sm-8">
                              <select name="no_dok_item" id="no_dok_item" class="form-control select2" style="width:100%;">
                                <option selected="selected">-- Pilih Nomor Dokumen --</option>
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-8">
                              <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Uraian / Keterangan">
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
                            <label class="col-sm-3 control-label">Jumlah Masuk</label>
                            <div class="col-sm-8">
                              <input type="number" min="1" name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah Masuk">
                            </div>
                          </div>                  
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Harga Beli Satuan</label>
                            <div class="col-sm-8">
                              <input type="number" min="1" name="rph_sat" class="form-control" id="rph_sat" placeholder="Masukkan Harga ">
                            </div>
                          </div>                  
                          <div name="detil_transaksi" id="detil_transaksi">
                          </div>
                        </div>
                        </div>
                        <div class="box-footer">
                          <button type="Reset" class="btn btn-default">Reset</button>
                          <button type="submit" class="btn btn-info pull-right">Submit</button>
                        </div>
                      </div>
                    </div> <!-- <div class="tab-content"> -->
                  </div> <!-- </div class="box-body">  -->
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
                        <th width="14%">Jenis Transaksi</th>
                        <th width="18%">No Dokumen</th>
                        <th width="18%">No Bukti</th>
                        <th>Tanggal Dokumen</th>
                        <th>Tanggal Buku</th>
                        <!-- <th>Nama Barang</th>
                        <th width="3%">Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Keterangan</th> -->
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
      <?php include("include/success.php"); ?>
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script type="text/javascript">
    var table;
      $(function () {
        $(".select2").select2();
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
                                // '<a href="edit_trans_masuk?id=a" class="btn btn-success btn-sm daterange pull-left" role="button"><i class="fa fa-edit"></i></a>'+
                                  // '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                '</div>',
             "targets": [6],"targets": 6 },

          ],
        });
        // $('#example1 tbody').on('click', 'tr', function () {
        //     var data = table.row( this ).data();
        //     alert( 'You clicked on '+data[0]+'\'s row' );
        // } );
        $('#no_dok_item').change(function(){
        var identtrans = $(this).val();
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readidenttrans',idtrans:identtrans},
          dataType: "json",
          success: function (output) {
            // alert(output.jenistrans);
            // alert(output.tgldok);
            // alert(output.tglbuku);
            // alert(output.satker);
            $('#disjenistrans').val(output.jenistrans);
            $('#distgldok').val(output.tgldok);
            $('#distglbuku').val(output.tglbuku);
            $('#dissatker').val(output.satker);
            $('#distottrans').val(output.total);
          }
        });
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
          data: {manage:'cek_brg_masuk',id_row:id_row},
          dataType: "json",
          success: function (output) {
            if(output.st_op==1)
            {
              alert("Tidak Dapat Menghapus Barang yang sudah diopname !");
              return false;
            }
            if(output.qty!=null)
            {
              alert("Tidak dapat menghapus, barang sudah dikeluarkan pada tanggal "+output.tgl_dok+" sebanyak "+output.qty+" "+output.satuan);
              return false;
            }
            else
            {
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
          data: {manage:'cek_brg_masuk',id_row:id_row},
          dataType: "json",
          success: function (output) {
            if(output.st_op==1)
            {
              alert("Tidak Dapat Menghapus Barang yang sudah diopname !");
              return false;
            }
            if(output.qty!=null)
            {
              alert("Tidak dapat menghapus, barang sudah dikeluarkan pada tanggal "+output.tgl_dok+" sebanyak "+output.qty+" "+output.satuan);
              return false;
            }
            else
            {
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
          data: {manage:'readnodok',no_dok:"<?php echo($_SESSION['kd_lok']);?>"},
          success: function (output) {     
            $('#no_dok_item').html(output);
          }
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
        var jns_trans = $("#jenis_trans").val();
        var kd_brg = $("#kd_brg").val();
        var tahun_ang = $("#tahun_ang").val();
        var sisa = $("#rph_sat").val();
        var jumlah_input = $("#jml_msk").val();
        var tgl_dok = $("#tgl_dok").val();
        var tgl_buku = $("#tgl_buku").val();
        var tgl_terakhir = "";
        var disjenistrans = $("#distottrans").val();
        var distgldok = $("#distgldok").val();
        var distglbuku = $("#distglbuku").val();
        var dissatker = $("#dissatker").val();
        var distottrans = $("#distottrans").val();
        var no_dok_item = $("#no_dok_item").val();

        if(jns_trans!=""){
          // alert("Jenis Transaksi Dipilih");

          if(tgl_dok.substring(6,10)!=tahun_ang){
            alert("Tahun Dokumen Tidak Sesuai Dengan Tahun Anggaran");
            return false;
          }
          if(tgl_buku.substring(6,10)!=tahun_ang){
            alert("Tahun Bukti Tidak Sesuai Dengan Tahun Anggaran");
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
              setTimeout("$('#myModal').modal('hide');$('#tab_1').removeClass('active');$('#li_tab_1').removeClass('active');$('#tab_2').addClass('active');$('#li_tab_2').addClass('active');",redirectTime);
              $.ajax({
                type: "post",
                url: '../core/transaksi/prosestransaksi',
                data: {manage:'readnodok',no_dok:"<?php echo($_SESSION['kd_lok']);?>"},
                success: function (output) {     
                  $('#no_dok_item').html(output);
                }
              });
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              table = $("#example1").DataTable({
                "processing": false,
                "serverSide": true,
                "ajax": "../core/loadtable/loadtransmsk",
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
                                      // '<a href="edit_trans_masuk?id=a" class="btn btn-success btn-sm daterange pull-left" role="button"><i class="fa fa-edit"></i></a>'+
                                        // '<button id="btnedt" class="btn btn-success btn-sm daterange pull-left" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'+
                                        '<button id="btnhps" class="btn btn-danger btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Hapus"><i class="fa fa-remove"></i></button>'+
                                      '</div>',
                   "targets": [6],"targets": 6 },
                ],
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
              });
            }
          });
          return false;
        }
        else if (no_dok_item!="") {
          
          if(kd_brg==""){
            alert("Kode Persediaan Belum Dipilih")
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
        }
        else{
          alert("Harap Masukkan Data Terlebih Dahulu");
          return false;
        }       
      });
    </script>
  </body>
</html>
