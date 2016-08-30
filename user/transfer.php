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
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Transfer Persediaan </h3>
                </div>
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="addtransmsk">
                  <div class="box-body" style="padding-top:15px;">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">SKPD</label>
                          <div class="col-sm-8">
                            <select name="read_no_dok" id="read_no_dok" class="form-control">
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Nomor Dokumen</label>
                          
                          <div class="col-sm-3">
                            <input type="text" name="no_dok" class="form-control" id="no_dok" placeholder="Masukkan No. Faktur / Bon / SP" required>
                            <input type="hidden" name="manage" value="tbh_transaksi_klr">  
                            <input type="hidden" name="tahun_ang" id="tahun_ang" value='<?php echo $_SESSION['thn_ang']; ?>'>  
                          </div>
                          <label class="col-sm-2 control-label">Unit Kerja Tujuan</label>
                          <div class="col-sm-3">
                            <select name="bidang_tujuan" id="bidang_tujuan" class="form-control">
                            </select>

                          </div>

                        </div>
                        <!-- <div class="form-group">                     
                        <label class="col-sm-2 control-label">Nomor Bukti</label>
                          <div class="col-sm-9">
                            <input type="text" name="no_bukti" class="form-control" id="no_bukti" placeholder="Masukkan Nomor Bukti">
                          </div>
                        </div> -->
                        <!-- <div class="form-group"> -->
                         <!--  <label class="col-sm-2 control-label">Kode Satker Tujuan</label>
                          <div class="col-sm-3">
                            <select name="satker_tujuan" id="satker_tujuan" class="form-control">
                            </select>

                          </div> -->

                          

                        <!-- </div> -->
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                          <div class="col-sm-3">
                            <input type="text" name="tgl_dok" max="10" class="form-control" id="tgl_dok" >
                          </div>
                          <label class="col-sm-2 control-label">Tanggal Pembukuan</label>
                          <div class="col-sm-3">
                            <input type="text" name="tgl_buku" max="10" class="form-control" id="tgl_buku" >
                          </div> 
                        </div>                                           
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Keterangan</label>
                          <div class="col-sm-8">
                            <input type="text" name="keterangan"  class="form-control" id="keterangan" placeholder="Masukkan Keterangan / Nama Pihak Penerima" >
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
      $(function () {
        $(".select2").select2();
        $("li#transfer").addClass("active");
        $('#tgl_dok').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
        $('#tgl_buku').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
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
                                  '<button id="btntmbh" class="btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah</button>'+
                                  '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                '</div>',
             "targets": [6],"targets": 6 }         

          ],
        });
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
        $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        jns_trans_row = row.data()[1];
        gab_row = row.data()[2];
        kdsatker_row = gab_row.substring(0,11);
        nodok_row = gab_row.substring(14,20);
        tgl_dok_row = row.data()[4];
        tgl_buku_row = row.data()[5];
        keterangan_row = row.data()[6];
          $.ajax({
            type: "post",
            url: '../core/transaksi/validasi',
            data: {manage:'cek_dok_keluar',kd_lokasi:kdsatker_row, no_dok:gab_row},
            dataType: "json",
            success: function (output) {
              if(output.st_op==1) {
                alert("Tidak Dapat Mengedit Dokumen karena terdapat barang yang telah diopname : "+output.nm_brg+" "+output.spesifikasi);
                return false;
              }
        if ( row.child.isShown() ) {
          $('div.slider', row.child()).slideUp( function () {
            row.child.hide();
            tr.removeClass('shown');
          });
        }
        else {
          row.child( format(row.data())).show();
          tr.addClass('shown');
          $('div.slider', row.child()).slideDown();
          $("#jns_trans"+id_row +"").val(jns_trans_row);
          $("#kd_satker"+id_row +"").val(kdsatker_row);
          $("#nodok_new").val(nodok_row);
          $("#tgl_dok_new").val(tgl_dok_row);
          $("#tgl_buku_new").val(tgl_buku_row);
          $("#keterangannew").val(keterangan_row);
          $('#tgl_dok_new').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
          $('#tgl_buku_new').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
          $('#tgl_dok_new').datepicker({
            format: "dd-mm-yyyy"
          });
          $('#tgl_buku_new').datepicker({
            format: "dd-mm-yyyy"
          }); 
        }
        }
          });
      });
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="upd_dok_keluar">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="ubah_dok_keluar">'+
              '<input type="hidden" name="no_dok_lama" value="'+d[2]+'">'+
              '<td width="7%"><input style="width:90%" id="jns_trans'+d[0]+'" name="jns_trans_baru" class="form-control" type="text" readonly></td>'+
              '<td width="11%"><input style="width:98%" id="kd_satker'+d[0]+'" name="kd_satker" class="form-control" type="text" readonly></td>'+
              '<td><input style="width:98%" id="nodok_new" name="nodok_baru" class="form-control" type="text" ></td>'+
              '<td><input style="width:98%" id="tgl_dok_new" name="tgl_dok_baru" class="form-control" type="text" ></td>'+
              '<td><input style="width:98%" id="tgl_buku_new" name="tgl_buku_baru" class="form-control" type="text" ></td>'+
              '<td><input style="width:98%" id="keterangannew" name="ket_baru" class="form-control" type="text" ></td>'+
              '<td style="vertical-align:middle; width:7%;">'+
                '<div class="box-tools">'+
                  // '<button id="btnrst" class="btn btn-warning btn-xs pull-left" type="reset"><i class="fa fa-refresh"></i> Reset</button>'+
                  '<button id="btnupd" class="btn btn-primary btn-xs pull-right"><i class="fa fa-upload"></i> Update</button>'+
                '</div>'
              '</td>'+
           '</tr>'+
        '</table>'+
        '</form></div>';
      }
      $(document).on('submit', '#upd_dok_keluar', function (e) {
        var tahun_ang = $("#tahun_ang").val();
        var tgl_dok_new = $("#tgl_dok_new").val();
        var tgl_buku_new = $("#tgl_buku_new").val();
        var nodok_new = $("#nodok_new").val();
          if(nodok_new==""){
            alert("Silahkan Isi Nomor Dokumen Yang Baru");
            return false;
          }          
          if(tgl_dok_new==""){
            alert("Silahkan Isi Tanggal Dokumen Yang Baru");
            return false;
          }          
          if(tgl_buku_new==""){
            alert("Silahkan Isi Tanggal Pembukuan Yang Baru");
            return false;
          }
          if(tgl_dok_new.substring(6,10)!=tahun_ang){
            alert("Tahun Dokumen Tidak Sesuai Dengan Tahun Anggaran");
            return false;
          }
          if(tgl_buku_new.substring(6,10)!=tahun_ang){
            alert("Tahun Bukti Tidak Sesuai Dengan Tahun Anggaran");
            return false;
          }
        $('button:submit').attr("disabled", true); 
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
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              $('button:submit').attr("disabled", false); 
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
                                  '<button id="btntmbh" class="btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah</button>'+
                                  '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                '</div>',
             "targets": [6],"targets": 6 }         
                ],
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
              });
          }
        });
        return false;
      });
        $('#no_dok_item').change(function(){
          var identtrans = $(this).val();
          $.ajax({
            type: "post",
            url: '../core/transaksi/prosestransaksi',
            data: {manage:'readidenttransklr',idtrans:identtrans},
            dataType: "json",
            success: function (output) {
              document.getElementById("jenis_trans").value = "";
              $('#disnobukti').val(output.nobukti);
              $('#disjenistrans').val(output.jenistrans);
              $('#distgldok').val(output.tgldok);
              $('#distglbuku').val(output.tglbuku);
              $('#dissatker').val(output.satker);
              $('#distottrans').val(output.total);
              $('#jml_msk').prop('required', true);
            }
          });
        });
        $('#jenis_trans').change(function(){
          $("#no_dok_item").select2().select2('val','');
          $('#disnobukti').val('');
          $('#disjenistrans').val('');
          $('#distgldok').val('');
          $('#distglbuku').val('');
          $('#dissatker').val('');
          $('#distottrans').val('');
          $('#jml_msk').prop('required', false);
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
          data: {manage:'readsatkerdok',no_dok:"<?php echo($_SESSION['kd_lok']);?>"},
          success: function (output) {     
            $('#read_no_dok').html(output);
          }
        });
        var skpd_asal = $("#satker_tujuan").val();
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'baca_bidang_skpd',satker_tujuan:skpd_asal},
          success: function (output) {

            $('#bidang_tujuan').html(output);
          }
        });
      
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readbidang'},
          success: function (output) {
            $(".select2").select2();   
            $('#bidang_tujuan').html(output);
            $("#bidang_tujuan").select2({
           placeholder: "-- Pilih Unit Kerja Tujuan --",
         });
          }

        //   type: "post",
        //   url: '../core/transaksi/prosestransaksi',
        //   data: {manage:'baca_semua_skpd',kd_lokasi:skpd_asal},
        //   success: function (output) { 
        //     $(".select2").select2();    
        //     $('#satker_tujuan').html(output);
        //     $('#satker_tujuan').val('');
        //     $("#satker_tujuan").select2({
        //   placeholder: "-- Pilih Kode Satker Tujuan --",
        // });
        //   }
        });
       $('#satker_tujuan').change(function(){
          var kdsatker_tujuan = "<?php echo $_SESSION['kd_lok']; ?> "; 
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readbidang',satker_tujuan:kdsatker_tujuan},
          success: function (output) {     
            $(".select2").select2();
            $('#bidang_tujuan').html(output);
            $("#bidang_tujuan").select2({
           placeholder: "-- Pilih Unit Kerja Tujuan --",
         });
          }
        });

      });
      $.ajax({
        type: "post",
        url: '../core/transaksi/prosestransaksi',
        data: {manage:'cek_tahun_aktif',thn_ang:"<?php echo($_SESSION['thn_ang']);?>"},
        dataType: "json",
        success: function (output) {
          var tahun = output.tahun;
          if(tahun!=="Aktif") {
            $('button:submit').attr("disabled", true); 
            $("#addtransmsk").css("display","none");
        }
      }});
      
      $('#addtransmsk').submit(function(e){
        var jns_trans = $("#jenis_trans").val();
        var tahun_ang = $("#tahun_ang").val();
        var sisa = $("#rph_sat").val();
        var jumlah_input = $("#jml_msk").val();
        var tgl_dok = $("#tgl_dok").val();
        var tgl_buku = $("#tgl_buku").val();
        var satkernodok = $("#read_no_dok").val();

        var disjenistrans = $("#distottrans").val();
        var distgldok = $("#distgldok").val();
        var distglbuku = $("#distglbuku").val();
        var dissatker = $("#dissatker").val();
        var distottrans = $("#distottrans").val();
        var no_dok_item = $("#no_dok_item").val();
        var no_dok = $("#no_dok").val();

        if (jns_trans != "") {
          if(tgl_dok.substring(6,10)!=tahun_ang){
            alert("Tahun Dokumen Tidak Sesuai Dengan Tahun Anggaran");
            return false;
          }

          if(tgl_buku.substring(6,10)!=tahun_ang){
            alert("Tahun BUkti Tidak Sesuai Dengan Tahun Anggaran");
            return false;
          }
          $('button:submit').attr("disabled", true); 
          e.preventDefault();
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
              $("#jenis_trans").val('');
              $("#no_dok").val('');
              $("#tgl_dok").val('');
              $("#tgl_buku").val('');
              $("#keterangan").val('');
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              $('button:submit').attr("disabled", false); 
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
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
                                  '<button id="btntmbh" class="btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah</button>'+
                                  '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                '</div>',
             "targets": [6],"targets": 6 }         
                ],
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
              });
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
