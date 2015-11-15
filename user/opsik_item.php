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

        <section class="content-header">
          <h1>
            Stock Opname Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Keluar</a></li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Dokumen Transaksi </h3>
                </div>
                <form action="../core/opsik/prosesopsik" method="post" class="form-horizontal"  id="addtransmsk" >
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
<!--                         <div class="form-group">
                          <label class="col-sm-5 control-label">Total Transaksi</label>
                          <div class="col-sm-7">
                            <input type="text" id="distottrans" name="distottrans" class="form-control" readonly>
                          </div>
                        </div> -->
                      </div>

                      <div class="col-sm-7">  
                          <div class="form-group">
                            <label class="col-sm-3 control-label">No. Dokumen</label>
                            <div class="col-sm-8">
                              <input type="text" name="no_dok_item" id="no_dok_item" class="form-control" style="width:100%;" readonly value="<?php echo $_POST['satker'];?>">
                              <input type="hidden" name="manage" value="tbh_opname">
                            <input type="hidden" id="read_no_dok" name="read_no_dok">
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
                            <label class="col-sm-3 control-label">Jumlah Hasil Opname</label>
                            <div class="col-sm-4">
                              <input type="number" min="0"  name="jml_msk" class="form-control" id="jml_msk" placeholder="Masukkan Jumlah">
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
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Keterangan Atas Selisih</label>
                            <div class="col-sm-8">
                              <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Mis. Hilang / Usang / Rusak">
                            </div>
                          </div>                  
                        </div>   
                    </div>
                  </div> <!-- </div class="box-body">  -->
                  <div class="box-footer">
                      <button type="reset" id="btn_resets" class="btn btn-default">Reset</button>
                      <button type="submit" class="btn btn-info pull-right">Submit</button>
                    </div>
                </form>
              </div>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Stock Opname</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Kode Lokasi</th>
                        <th>Nama Satker</th>
                        <th>No Dok</th>
                        <th>Tgl Dokumen</th>
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
        $("#kd_brg").select2({
          placeholder: "-- Pilih Kode Item Barang --",
        });
        $("li#opname").addClass("active");
        $('#tgl_dok').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_buku').datepicker({
          format: "dd-mm-yyyy"
        });
        $('form').on('focus', 'input[type=number]', function (e) {
          $(this).on('mousewheel.disableScroll', function (e) {
            e.preventDefault()
          })
        })
        $('form').on('blur', 'input[type=number]', function (e) {
          $(this).off('mousewheel.disableScroll')
        });             
        $("li#saldo_awal").addClass("active");
        table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax":
          {
            'type': 'GET',
            'url': '../core/loadtable/loadopsikitm',
            'data': {
               no_dok: '<?php echo $_POST["satker"]?>',
            },
          },
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1,
             "visible": false },
            {"targets": 2,
             "visible": false },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"targets": 6 },
            {"targets": 7 },
            {"targets": 8 },
            {"targets": 9 },
            {"targets": 10 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                  '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [11],"targets": 11 },
          ],
        });
        // $('#example1 tbody').on('click', 'tr', function () {
        //     var data = table.row( this ).data();
        //     alert( 'You clicked on '+data[0]+'\'s row' );
        // } );
        $.ajax({
          type: "post",
          url: '../core/opsik/prosesopsik',
          data: {manage:'readidentopsik',idtrans:"<?php echo $_POST['satker']?>"},
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
      redirectURL = "opsik_item";
      id_row = row.data()[0];
      managedata = "hapusOpname";


            job=confirm("Anda yakin ingin mencabut status opname? ");
            if(job!=true)
            {
              return false;
            }
            else
            {

              $.ajax({
                type: "post",
                url : "../core/opsik/prosesopsik",
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
                        'url': '../core/loadtable/loadopsikitm',
                        'data': {
                           no_dok: '<?php echo $_POST["satker"]?>',
                        },
                      },
                      "columnDefs":
                      [
                        {"targets": 0,
                         "visible": false },
                        {"targets": 1,
                         "visible": false },
                        {"targets": 2,
                         "visible": false },
                        {"targets": 3 },
                        {"targets": 4 },
                        {"targets": 5 },
                        {"targets": 6 },
                        {"targets": 7 },
                        {"targets": 8 },
                        {"targets": 9 },
                        {"targets": 10 },
                        {"orderable": false,
                         "data": null,
                         "defaultContent":  '<div class="box-tools">'+
                                              '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                            '</div>',
                         "targets": [11],"targets": 11 },
                      ],
                    });
                }
              });
            return false;
            }
          
        
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
            data: {manage:'sisabarang',kd_brg:kd_brg, nodok:'<?php echo $_POST["satker"];?>'},
            dataType: "json",
            success: function (output) {
            $('#rph_sat').val(output.sisa);
            $('#satuan').val(output.satuan);

            

            }
          });
        }
      });
       $.ajax({
          type: "post",
          url: '../core/opsik/prosesopsik',
          data: {manage:'readbrg',kd_satker:"<?php echo($_POST['kd_satker']);?>"},
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
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              $("#kd_brg").select2("val", "");
              $("#jml_msk").val('');
              $("#satuan").val('');
              $("#keterangan").val('');
              $('button:submit').attr("disabled", false); 
              table = $("#example1").DataTable({
                "processing": false,
                "serverSide": true,
                "ajax":
                {
                  'type': 'GET',
                  'url': '../core/loadtable/loadopsikitm',
                  'data': {
                     no_dok: '<?php echo $_POST["satker"]?>',
                  },
                },
                "columnDefs":
                [
                  {"targets": 0,
                   "visible": false },
                  {"targets": 1,
                   "visible": false },
                  {"targets": 2,
                   "visible": false },
                  {"targets": 3 },
                  {"targets": 4 },
                  {"targets": 5 },
                  {"targets": 6 },
                  {"targets": 7 },
                  {"targets": 8 },
                  {"targets": 9 },
                  {"targets": 10 },
                  {"orderable": false,
                   "data": null,
                   "defaultContent":  '<div class="box-tools">'+
                                        '<button id="btnhps" class="btn btn-flat btn-danger btn-xs"><i class="fa fa-remove"></i> Hapus</button>'+
                                      '</div>',
                   "targets": [11],"targets": 11 },
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
