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
                  <h3 class="box-title">Daftar Transaksi Masuk</h3> <a href="#importModal" data-toggle="modal" class="btn btn-sm btn-success pull-right" style="margin-right: 12px;padding: 4px 25px">Import</a>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th >ID</th>
                        <th >SKPD</th>
                        <th >Jenis Transaksi</th>
                        <th >Nomor Dokumen</th>
                        <th >Tanggal Dokumen</th>
                        <th >Tanggal Pembukuan</th>
                        <th >Keterangan</th>
                        <th >Aksi</th>
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
        $("li#trans_masuk").addClass("active");
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
          "ajax": "../core/loadtable/admin_masuk",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3,},
            {"targets": 4 },
            {"targets": 5 },
            {"targets": 6 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btntmbh" class="btn btn-info btn-flat btn-xs"><i class="fa fa-plus"></i> Lihat item</button>'+
                                  // '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                '</div>',
             "targets": [7],"targets": 7 },
          ],
        });
      });

      $(document).on('click', '#btntmbh', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        manage = "trans_masuk";
        id_row = row.data()[0];
        jns_trans = row.data()[1];
        satker = row.data()[3];
        tgl_dok = row.data()[4];
        tgl_buku = row.data()[5];
        kd_satker = satker.substring(0,11);

        var $form=$(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action","trans_item_brg");
        var $input=$(document.createElement('input')).css({display:'none'}).attr('name','id').val(id_row);
        var $input2=$(document.createElement('input')).css({display:'none'}).attr('name','jenistrans').val(jns_trans);
        var $input3=$(document.createElement('input')).css({display:'none'}).attr('name','tanggaldok').val(tgl_dok);
        var $input4=$(document.createElement('input')).css({display:'none'}).attr('name','tanggalbuku').val(tgl_buku);
        var $input5=$(document.createElement('input')).css({display:'none'}).attr('name','satker').val(satker);
        var $input6=$(document.createElement('input')).css({display:'none'}).attr('name','manage').val(manage);
        var $input7=$(document.createElement('input')).css({display:'none'}).attr('name','kd_satker').val(kd_satker);
        $form.append($input).append($input2).append($input3).append($input4).append($input5).append($input6).append($input7);
        $("body").append($form);
        $form.submit();
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

      $('#jenis_trans').change(function(){
        var jns_trans= $('#jenis_trans').val();
        var kd_lokasi = $('#read_no_dok').val();
        if (jns_trans=='M01') {
          $.ajax({
            type: "post",
            url: '../core/transaksi/prosestransaksi',
            data: {manage:'cek_saldo_awal',kd_lokasi:kd_lokasi},
            dataType: "json",
            success: function (output) {
              if(output.saldo!==null){
                alert("Saldo Awal Telah Dimasukkan / Import Saldo Awal telah dilakukan");
                $('#jenis_trans').val('');

          }



            }
          });
        }

      });
      $('#addtransmsk').submit(function(e){
        var jns_trans = $("#jenis_trans").val();
        var tahun_ang = $("#tahun_ang").val();
        var tgl_dok = $("#tgl_dok").val();
        var tgl_buku = $("#tgl_buku").val();
        var no_dok = $("#no_dok").val();

        if(jns_trans!=""){
          if(no_dok==""){
            alert("Silahkan Isi Nomor Dokumen");
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
          e.preventDefault();
          $('button:submit').attr("disabled", true);
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
              table = $("#example1").DataTable({
                "aaSorting": [[ 0, 'desc' ]],
                "processing": false,
                "serverSide": true,
                "ajax": "../core/loadtable/loadtransmsk",
                "columnDefs":
                [
                  {"targets": 0,
                   "visible": false },
                  {"targets": 1 },
                  {"targets": 2 },
                  {"targets": 3,
                   "visible": false },
                  {"targets": 4 },
                  {"targets": 5 },
                  {"targets": 6 },
                  {"orderable": false,
                   "data": null,
                   "defaultContent":  '<div class="box-tools">'+
                                        '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                        '<button id="btntmbh" class="btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah</button>'+
                                      '</div>',
                   "targets": [7],"targets": 7 },
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
            data: {manage:'cek_dok_masuk',kd_lokasi:kdsatker_row, no_dok:gab_row},
            dataType: "json",
            success: function (output) {
              if(output.st_op==1) {
                alert("Tidak Dapat Mengedit Dokumen karena terdapat barang yang telah diopname : "+output.nm_brg+" "+output.spesifikasi);
                return false;
              }
              else {
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
            }
          });


      });
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="upd_dok_masuk">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="ubah_dok_masuk">'+
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
      $(document).on('submit', '#upd_dok_masuk', function (e) {
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
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              $('button:submit').attr("disabled", false);
              table = $("#example1").DataTable({
                "aaSorting": [[ 0, 'desc' ]],
                "processing": false,
                "serverSide": true,
                "ajax": "../core/loadtable/loadtransmsk",
                "columnDefs":
                [
                  {"targets": 0,
                   "visible": false },
                  {"targets": 1 },
                  {"targets": 2 },
                  {"targets": 3,
                   "visible": false },
                  {"targets": 4 },
                  {"targets": 5 },
                  {"targets": 6 },
                  {"orderable": false,
                   "data": null,
                   "defaultContent":  '<div class="box-tools">'+

                                        '<button id="btntmbh" class="btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah</button>'+
                                        '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                      '</div>',
                   "targets": [7],"targets": 7 },
                ],
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
              });
          }
        });
        return false;
      });
    </script>
  </body>
</html>
