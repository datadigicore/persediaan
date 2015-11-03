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
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal"  id="addtransmsk" >
                  <div class="box-body" style="padding-top:15px;">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Jenis Transaksi</label>
                      <div class="col-sm-9">
                        <select name="jenis_trans" id="jenis_trans" class="form-control">
                          <option value="">Pilih Jenis Transaksi</option>
                          <option value="M01">Saldo Awal</option>
                          <option value="M02">Pembelian</option>
                          <option value="M03">Transfer Masuk</option>
                          <option value="M04">Hibah Masuk</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nomor Dokumen</label>
                      <div class="col-sm-2">
                        <select name="read_no_dok" id="read_no_dok" class="form-control">
                        </select>
                      </div>
                      <div class="col-sm-7">
                        <input type="text" name="no_dok" class="form-control"  id="no_dok" placeholder="Masukkan No. Dokumen">
                        <input type="hidden" name="manage" value="tbh_transaksi_msk">
                        <input type="hidden" name="tahun_ang" id="tahun_ang" value='<?php echo $_SESSION['thn_ang']; ?>'>
                        <input type="hidden" name="tahun_ang" id="tahun_ang" value='<?php echo $_SESSION['thn_ang']; ?>'>    
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Dokumen</label>
                      <div class="col-sm-9">
                        <input type="text" name="tgl_dok" class="form-control" id="tgl_dok" placeholder="Masukkan Tanggal Dokumen" onchange="masuk_tanggal()" readonly>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tanggal Buku</label>
                      <div class="col-sm-9">
                        <input type="text" name="tgl_buku" class="form-control" id="tgl_buku" placeholder="Masukkan Tanggal Buku" readonly>
                      </div> 
                    </div>                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Keterangan</label>
                      <div class="col-sm-9">
                        <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Masukkan Uraian / keterangan" >
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
                        <th width="14%">Jenis Transaksi</th>
                        <th width="18%">No Dokumen</th>
                        <th width="18%">No Bukti</th>
                        <th>Tanggal Dokumen</th>
                        <th>Tanggal Buku</th>
                        <th>Total Transaksi</th>
                        <th width="8.5%">Aksi</th>
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
      function masuk_tanggal() {
      
        var tgl_dok = $('#tgl_dok').val();
        $('#tgl_buku').val(tgl_dok);

         
      }

      var table;
      $(function () {
        $(".select2").select2();
        $('#tgl_dok').css('background-color' , '#FFFFFF');
        $('#tgl_buku').css('background-color' , '#FFFFFF');
        $("li#trans_masuk").addClass("active");
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
            {"targets": 6,
             "visible": false  },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btntmbh" class="btn btn-info btn-flat btn-xs pull-right"><i class="fa fa-plus"></i> Tambah</button>'+
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
        satker = row.data()[2];
        tgl_dok = row.data()[4];
        tgl_buku = row.data()[5];
        var $form=$(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action","trans_item_brg");
        var $input=$(document.createElement('input')).css({display:'none'}).attr('name','id').val(id_row);
        var $input2=$(document.createElement('input')).css({display:'none'}).attr('name','jenistrans').val(jns_trans);
        var $input3=$(document.createElement('input')).css({display:'none'}).attr('name','tanggaldok').val(tgl_dok);
        var $input4=$(document.createElement('input')).css({display:'none'}).attr('name','tanggalbuku').val(tgl_buku);
        var $input5=$(document.createElement('input')).css({display:'none'}).attr('name','satker').val(satker);
        var $input6=$(document.createElement('input')).css({display:'none'}).attr('name','manage').val(manage);
        $form.append($input).append($input2).append($input3).append($input4).append($input5).append($input6);
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
                alert("Saldo Awal Telah Dimasukkan");
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
                  {"targets": 6,
                   "visible": false  },
                  {"orderable": false,
                   "data": null,
                   "defaultContent":  '<div class="box-tools">'+
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
    </script>
  </body>
</html>
