<?php
if (empty($_POST['id'])) {
  header('location:../login');
}
else {
?>
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
        <?php if ($_POST['manage']=="trans_masuk") { ?>
        <section class="content-header">
          <h1>
            Persediaan Masuk
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Masuk</a></li>
          </ol>
        </section>
        <?php } else if ($_POST['manage']=="trans_keluar") { ?>
        <section class="content-header">
          <h1>
            Persediaan Keluar
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Keluar</a></li>
          </ol>
        </section>
        <?php } ?>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Dokumen Transaksi </h3>
                </div>
                <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal"  id="addtransmsk" >
                  <div class="box-body" style="padding-top:15px;">
                    <!-- <div class="row" style="padding-bottom:15px;">
                      <div class="col-sm-4">
                        <button id="btnviw" class="btn btn-flat btn-success btn-xs"><i class="fa fa-eye"></i> Lihat Item</button>
                        <button id="btnadd" class="btn btn-flat btn-info btn-xs"><i class="fa fa-plus"></i> Tambah Item</button>
                      </div>
                    </div> -->
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">

                          <label class="col-sm-5 control-label">Jenis Transaksi</label>
                          <div class="col-sm-7">
                            <input type="text" id="disjenistrans" name="disjenistrans" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Tgl. Dokumen</label>
                          <div class="col-sm-7">
                            <input type="text" id="tgl_dok" name="tgl_dok" class="form-control" readonly>
                          </div>
                        </div>                  
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Tgl. Buku</label>
                          <div class="col-sm-7">
                            <input type="text" id="tgl_buku" name="tgl_buku" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Satker</label>
                          <div class="col-sm-7">
                            <input type="text" id="dissatker" name="dissatker" class="form-control" readonly>
                          </div>
                        </div>                  
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Total Transaksi</label>
                          <div class="col-sm-7">
                            <input type="text" id="distottrans" name="distottrans" class="form-control" readonly>
                          </div>
                        </div>
                      </div>
                      <?php if ($_POST['manage']=="trans_masuk") { ?>
                      <div class="col-sm-7">
                        <div class="form-group">
                          <label class="col-sm-3 control-label">No. Dokumen</label>
                          <div class="col-sm-8">
                            <input type="text" name="no_dok_item" id="no_dok_item" class="form-control" style="width:100%;" readonly value="<?php echo $_POST['satker'];?>">
                            <input type="hidden" name="manage" value="tbh_transaksi_msk">
                            <input type="hidden" id="read_no_dok" name="read_no_dok">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Keterangan</label>
                          <div class="col-sm-8">
                            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="" readonly>
                          </div>
                        </div>  
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Kode Barang</label>
                          <div class="col-sm-8">
                            <select name="kd_brg" id="kd_brg" class="form-control select2">
                            </select>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Jumlah Masuk</label>
                          <div class="col-sm-4">
                            <input type="number" min="1" name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah">
                          </div>                             
                          <div class="col-sm-4">
                            <input type="text" name="satuan" id="satuan" class="form-control"  readonly>
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
                      <?php }
                      else if ($_POST['manage']=="trans_keluar") { ?>
                      <div class="col-sm-7">  
                          <div class="form-group">
                            <label class="col-sm-3 control-label">No. Dokumen</label>
                            <div class="col-sm-8">
                              <input type="text" name="no_dok_item" id="no_dok_item" class="form-control" style="width:100%;" readonly value="<?php echo $_POST['satker'];?>">
                              <input type="hidden" name="manage" value="tbh_transaksi_klr">
                            <input type="hidden" id="read_no_dok" name="read_no_dok">
                            </div>
                          </div>  
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-8">
                              <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="" readonly>
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
                            <div class="col-sm-4">
                              <input type="number" min="1" max name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah">
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="satuan" id="satuan" class="form-control"  readonly>
                            </div> 
                          </div>                  
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Saldo Barang</label>
                            <div class="col-sm-8">
                              <input type="text" name="rph_sat" class="form-control" id="rph_sat" placeholder="Saldo Barang" readonly >
                            </div>
                          </div>                  
                        </div>  
                      <?php } ?>
                      
                    </div>
                  </div> <!-- </div class="box-body">  -->
                  <div class="box-footer">
                      <button type="reset" id="btn_resets" class="btn btn-default">Reset</button>
                      <button type="submit" class="btn btn-info pull-right">Submit</button>
                    </div>
                </form>
              </div>
              <?php if ($_POST['manage']=="trans_masuk") { ?>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transaksi Masuk</h3>
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
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>  
                        <th>Keterangan</th>
                        <th width="8%">Aksi</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <?php } ?>              
              <?php if ($_POST['manage']=="trans_keluar") { ?>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transaksi Keluar/h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>No Dokumen</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>  
                        <th>Keterangan</th>
                        <th width="8%">Aksi</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <?php } ?>
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
    <?php if ($_POST['manage']=="trans_masuk") { ?>
    <script type="text/javascript">
    var table;
      $(function () {
        $(".select2").select2();
        $("#kd_brg").select2({
          placeholder: "-- Pilih Kode Item Barang --",
          ajax: {
            url: '../core/transaksi/prosestransaksi',
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: function (params) {
              return {
                manage:'readbrg',
                q: params.term, // search term
                page: params.page
              };
            },
            processResults: function (data, page) {
              return {
                results: data
              };
            },
            cache: true
          },
          escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
          minimumInputLength: 1,
        });
        $("li#trans_masuk").addClass("active");
            
        $("li#saldo_awal").addClass("active");
        table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax":
          {
            'type': 'GET',
            'url': '../core/loadtable/loadtransmskitm',
            'data': {
               no_dok: '<?php echo $_POST["satker"]?>',
            },
          },
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
            {"targets": 8 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                  '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                '</div>',
             "targets": [9],"targets": 9 },
          ],
        });
        // $('#example1 tbody').on('click', 'tr', function () {
        //     var data = table.row( this ).data();
        //     alert( 'You clicked on '+data[0]+'\'s row' );
        // } );
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readidenttrans',idtrans:"<?php echo $_POST['satker']?>"},
          dataType: "json",
          success: function (output) {
            $('#disnobukti').val(output.nobukti);
            $('#disjenistrans').val(output.jenistrans);
            $('#tgl_dok').val(output.tgldok);
            $('#tgl_buku').val(output.tglbuku);
            $('#dissatker').val(output.satker);
            $('#distottrans').val(output.total);
          }
        });
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readsatkerdoks',no_dok:"<?php echo($_SESSION['kd_lok']);?>"},
          success: function (output) {     
            $('#read_no_dok').val(output);
          }
        });
      });
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        kd_brg_row = row.data()[2];
        nm_brg_row = row.data()[3];
        spesifikasi_row = row.data()[4];
        qty_row = row.data()[5];
        harga_sat_row = row.data()[6];
        total_harga_row = row.data()[7];
        ket_row = row.data()[8];
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
          $("#kd_brg"+id_row +"").val(kd_brg_row);
          $("#nm_brg"+id_row +"").val(nm_brg_row);
          $("#spesifikasi"+id_row +"").val("Jumlah Baru");
          $("#qty"+id_row +"").val(qty_row);
          $("#harga_sat"+id_row +"").val(harga_sat_row);
          $("#total_harga"+id_row +"").val("Harga Sat.Baru (Rp.)");
          $("#keterangan"+id_row +"").val(ket_row);


        }
      });
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="upd_dok_masuk">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="ubah_brg_masuk">'+
              '<input type="hidden" name="id" value="'+id_row+'">'+
              '<td width="14%"><input style="width:97%" id="kd_brg'+d[0]+'" name="jns_trans_baru" class="form-control" type="text" readonly></td>'+
              '<td width="11%"><input style="width:97%" id="nm_brg'+d[0]+'" name="kd_satker" class="form-control" type="text" readonly></td>'+
              '<td width="10%"><input style="width:97%" id="spesifikasi'+d[0]+'" name="nodok_baru" class="form-control" type="text" readonly></td>'+
              '<td width="8%"><input style="width:97%" id="qty'+d[0]+'" name="tgl_dok_baru" class="form-control" type="number" ></td>'+
              '<td width="13%"><input style="width:99%" id="total_harga'+d[0]+'" name="ket_baru" class="form-control" type="text" readonly ></td>'+
              '<td width="11%"><input style="width:98%" id="harga_sat'+d[0]+'" name="tgl_buku_baru" class="form-control" type="number" ></td>'+
              
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
            date = output.tgl_dok.split("-");
            tanggal = date[2]+"/"+date[1]+"/"+date[0];
            alert("Tidak dapat menghapus, barang sudah dikeluarkan pada tanggal "+tanggal+" sebanyak "+Math.abs(output.qty)+" "+output.satuan);
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

              $.ajax({
                type: "post",
                url : "../core/transaksi/prosestransaksi",
                data: {manage:managedata,id:id_row},
                success: function(data)
                {
                    $("#kd_brg").select2("val", "");
                    $("#jml_msk").val('');
                    $("#satuan").val('');
                    $("#rph_sat").val('');
                    $("#example1").DataTable().destroy();
                    $("#example1 tbody").empty();
                    table = $("#example1").DataTable({
                      "processing": false,
                      "serverSide": true,
                      "ajax": {
                          'type': 'GET',
                          'url': '../core/loadtable/loadtransmskitm',
                          'data': {
                             no_dok: '<?php echo $_POST["satker"]?>',
                          },
                      },
                      "columnDefs":
                      [
                        {"targets": 0,
                         "visible": false },
                        {"targets": 1 },
                        {"targets": 2 },
                        {"targets": 3 },
                        {"targets": 4 },
                        {"targets": 5 },
                        {"targets": 6 },
                        {"targets": 7 },
                        {"targets": 8 },
                        {"orderable": false,
                         "data": null,
                         "defaultContent":  '<div class="box-tools">'+
                                              '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                            '</div>',
                         "targets": [9],"targets": 9 },
                      ],
                      "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
                    });
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
          $('#satuan').val('');
          
        }
        else {
          var kd_brg = $('#kd_brg').val(); 
          var no_dok = $('#no_dok').val(); 
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'baca_detil_trans',kd_brg:kd_brg,no_dok:no_dok},
          dataType: "json",
          success: function (output) {     
            $('#satuan').val(output.satuan);
          }
       });
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
        }
      }});
      $('#addtransmsk').submit(function(e){
        
        var kd_brg = $("#kd_brg").val();

        if(kd_brg!=""){
          if ($('#jml_msk').val() == "") {
            alert("Masukkan Jumlah");
            return false;
          };
          if ($('#rph_sat').val() == "") {
            alert("Masukkan Harga Beli Satuan");
            return false;
          };
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
              $("#kd_brg").select2("val", "");
              $("#jml_msk").val('');
              $("#satuan").val('');
              $("#rph_sat").val('');
              $("#keterangan").val('');
              $('button:submit').attr("disabled", false); 
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              table = $("#example1").DataTable({
                "processing": false,
                "serverSide": true,
                "ajax": {
                    'type': 'GET',
                    'url': '../core/loadtable/loadtransmskitm',
                    'data': {
                       no_dok: '<?php echo $_POST["satker"]?>',
                    },
                },
                "columnDefs":
                [
                  {"targets": 0,
                   "visible": false },
                  {"targets": 1 },
                  {"targets": 2 },
                  {"targets": 3 },
                  {"targets": 4 },
                  {"targets": 5 },
                  {"targets": 6 },
                  {"targets": 7 },
                  {"targets": 8 },
                  {"orderable": false,
                   "data": null,
                   "defaultContent":  '<div class="box-tools">'+
                                        '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                      '</div>',
                   "targets": [9],"targets": 9 },
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

<!-- ########################################################################## -->
    <?php } else if ($_POST['manage']=="trans_keluar") { ?>
<!-- ########################################################################## -->

    <script type="text/javascript">
    var table;
      $(function () {
        $(".select2").select2();
        $("#kd_brg").select2({
          placeholder: "-- Pilih Kode Item Barang --",
        });
        $("li#trans_keluar").addClass("active");
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
          "ajax":
          {
            'type': 'GET',
            'url': '../core/loadtable/loadtransklritm',
            'data': {
               no_dok: '<?php echo $_POST["satker"]?>',
            },
          },
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"targets": 6 },
            {"targets": 7 },
            {"targets": 8 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [9],"targets": 9 },
          ],
        });
        // $('#example1 tbody').on('click', 'tr', function () {
        //     var data = table.row( this ).data();
        //     alert( 'You clicked on '+data[0]+'\'s row' );
        // } );
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readidenttransklr',idtrans:"<?php echo $_POST['satker']?>"},
          dataType: "json",
          success: function (output) {
            $('#disnobukti').val(output.nobukti);
            $('#disjenistrans').val(output.jenistrans);
            $('#tgl_dok').val(output.tgldok);
            $('#tgl_buku').val(output.tglbuku);
            $('#dissatker').val(output.satker);
            $('#distottrans').val(output.total);
          }
        });
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readsatkerdoks',no_dok:"<?php echo($_SESSION['kd_lok']);?>"},
          success: function (output) {     
            $('#read_no_dok').val(output);
          }
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
        success: function (output) {
          if(output.st_op==1)
          {
            alert("Tidak Dapat Menghapus Barang yang sudah diopname !");
            return false;
          }
          // if(output.qty!=null)
          // {
          //   alert("Tidak dapat menghapus, barang sudah dikeluarkan pada tanggal "+output.tgl_dok+" sebanyak "+output.qty+" "+output.satuan);
          //   return false;
          // }
          else
          {
            job=confirm("Anda yakin ingin menghapus data ini?");
            if(job!=true)
            {
              return false;
            }
            else
            {
              $.ajax({
                type: "post",
                url : "../core/transaksi/prosestransaksi",
                data: {manage:managedata,id:id_row},
                success: function(data)
                {
                  $("#kd_brg").select2("val", "");
                  $("#jml_msk").val('');
                  $("#satuan").val('');
                  $("#rph_sat").val('');
                  $("#keterangan").val('');
                  $("#example1").DataTable().destroy();
                  $("#example1 tbody").empty();
                  table = $("#example1").DataTable({
                    "processing": false,
                    "serverSide": true,
                    "ajax":
                    {
                      'type': 'GET',
                      'url': '../core/loadtable/loadtransklritm',
                      'data': {
                         no_dok: '<?php echo $_POST["satker"]?>',
                      },
                    },
                    "columnDefs":
                    [
                      {"targets": 0,
                       "visible": false },
                      {"targets": 1 },
                      {"targets": 2 },
                      {"targets": 3 },
                      {"targets": 4 },
                      {"targets": 5 },
                      {"targets": 6 },
                      {"targets": 7 },
                      {"targets": 8 },
                      {"orderable": false,
                       "data": null,
                       "defaultContent":  '<div class="box-tools">'+
                                            '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                          '</div>',
                       "targets": [9],"targets": 9 },
                    ],
                  });
                }
              });

            return false;
            }
          }
        }
      });
    });
      $('#kd_brg').change(function(){
        if ($(this).val()=='') {
          $('#rph_sat').val(''); 
          $('#satuan').val('');
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
            $('#satuan').val(output.satuan);

            document.getElementById("jml_msk").setAttribute("max",output.sisa);

            }
          });
        }
      });
       $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'readbrgmsk',kd_satker:"<?php echo($_POST['kd_satker']);?>"},
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
          dataType: "json",
          success: function (output) {     
            $('#satuan').val(output.satuan);
          }
       });
        }
      });

      $('#addtransmsk').submit(function(e){
        
        var kd_brg = $("#kd_brg").val();

        if(kd_brg!=""){
          if ($('#jml_msk').val() == "") {
            alert("Masukkan Jumlah");
            return false;
          };
          if ($('#rph_sat').val() == "") {
            alert("Masukkan Harga Beli Satuan");
            return false;
          };
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
              $("#kd_brg").select2("val", "");
              $("#jml_msk").val('');
              $("#satuan").val('');
              $("#rph_sat").val('');
              $("#keterangan").val('');
              $('button:submit').attr("disabled", false);
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              table = $("#example1").DataTable({
                "processing": false,
                "serverSide": true,
                "ajax":
                {
                  'type': 'GET',
                  'url': '../core/loadtable/loadtransklritm',
                  'data': {
                     no_dok: '<?php echo $_POST["satker"]?>',
                  },
                },
                "columnDefs":
                [
                  {"targets": 0,
                   "visible": false },
                  {"targets": 1 },
                  {"targets": 2 },
                  {"targets": 3 },
                  {"targets": 4 },
                  {"targets": 5 },
                  {"targets": 6 },
                  {"targets": 7 },
                  {"targets": 8 },
                  {"orderable": false,
                   "data": null,
                   "defaultContent":  '<div class="box-tools">'+
                                        '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                      '</div>',
                   "targets": [9],"targets": 9 },
                ],
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
    <?php } ?>
  </body>
</html>
<?php }?>