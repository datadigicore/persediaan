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
  <body class="skin-blue">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <?php if ($_POST['manage']=="trans_masuk") { ?>

        <?php } else if ($_POST['manage']=="trans_keluar") { ?>
        <section class="content-header">
          <h1>
            Transfer Persediaan
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
                  <h3 class="box-title">Tambah Dokumen Transfer </h3>
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
                            <input type="text" id="disjenistrans" name="disjenistrans" class="form-control" value="<?php echo $_POST['jenistrans'];?>" readonly>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Tgl. Dokumen</label>
                          <div class="col-sm-7">
                            <input type="text" id="tgl_dok" name="tgl_dok" class="form-control" readonly>
                          </div>
                        </div>                  
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Tgl. Pembukuan</label>
                          <div class="col-sm-7">
                            <input type="text" id="tgl_buku" name="tgl_buku" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Satker / Sub Bagian Penerima</label>
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
 
                      <?php }
                      else if ($_POST['manage']=="trans_keluar") { ?>
                      <div class="col-sm-7">  
                          <div class="form-group">
                            <label class="col-sm-3 control-label">No. Dokumen</label>
                            <div class="col-sm-8">
                              <input type="text" name="no_dok_item" id="no_dok_item" class="form-control" style="width:100%;" readonly value="<?php echo $_POST['satker'];?>">
                              <input type="hidden" name="manage" value="tbh_transfer">
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
                            <label class="col-sm-3 control-label">Kode / Nama Barang</label>
                            <div class="col-sm-8">
                              <select name="kd_brg" id="kd_brg" class="form-control">
                              </select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Jumlah Keluar</label>
                            <div class="col-sm-4">
                              <input type="number" min="0.01" max name="jml_msk" class="form-control" id="jml_msk" step="any" placeholder="Masukkan Jumlah">
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="satuan" id="satuan" class="form-control"  readonly>
                            </div> 
                          </div>                  
                          <div class="form-group">
                            <label class="col-sm-3 control-label">Sisa Barang</label>
                            <div class="col-sm-8">
                              <input type="text" name="rph_sat" class="form-control" id="rph_sat" placeholder="Saldo Barang" readonly >
                            </div>
                          </div>                  
                        </div>  
                      <?php } ?>
                      
                    </div>
                  </div> <!-- </div class="box-body">  -->
                  <div class="box-footer">
                      <!-- <button type="reset" id="btn_resets" class="btn btn-default">Reset</button> -->
                      <button type="submit" class="btn btn-info pull-right">Submit</button>
                    </div>
                </form>
              </div>
             
              <?php if ($_POST['manage']=="trans_keluar") { ?>
              <div class="box box-info">
                
                <div class="box-header with-border">
                  <h6 class="box-title">Periksa kebenaran data sebelum mengusulkan transfer. Transfer Barang tidak dapat dibatalkan / dihapus</h6>
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
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>  
                        <th>Keterangan</th>
                        <th width="8%">Aksi</th>
                        <th> kd_lokasi </th>
                        <th> kd_lok_msk </th>
                        <th> kd_ruang_msk </th>
                        <th> nm_satker </th>
                        <th> nm_satker_msk </th>
                        <th> kd_brg </th>
                        <th> nm_brg </th>
                        <th> satuan </th>
                        <th> qty </th>
    
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
    <script src="../dist/js/notify.js"></script>
    <?php if ($_POST['manage']=="trans_masuk") { ?>


<!-- ########################################################################## -->
    <?php } else if ($_POST['manage']=="trans_keluar") { ?>
<!-- ########################################################################## -->

    <script type="text/javascript">
    $('form').on('focus', 'input[type=number]', function (e) {
      $(this).on('mousewheel.disableScroll', function (e) {
        e.preventDefault()
      })
    })
    $('form').on('blur', 'input[type=number]', function (e) {
      $(this).off('mousewheel.disableScroll')
    });
    var table;
    function baca_tabel(){
      
      table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax":
          {
            'type': 'GET',
            'url': '../core/loadtable/load_item_transfer',
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
            {"targets": 9 },
            {"targets": 10 },
            {"targets": 11,
             "visible": false },
            {"targets": 12,
             "visible": false },
            {"targets": 13,
             "visible": false },
            {"targets": 14,
             "visible": false },
            {"targets": 15,
             "visible": false },
            {"targets": 16,
             "visible": false },
            {"targets": 17,
             "visible": false },
            {"targets": 18,
             "visible": false },
            {"targets": 19,
             "visible": false },
          ],
        });
    }
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
        baca_tabel();
        // $('#example1 tbody').on('click', 'tr', function () {
        //     var data = table.row( this ).data();
        //     alert( 'You clicked on '+data[0]+'\'s row' );
        // } );
        $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'read_detail_transfer',idtrans:"<?php echo $_POST['satker']?>"},
          dataType: "json",
          success: function (output) {
            $('#disnobukti').val(output.nobukti);
            $('#dissatker').val(output.satkertujuan);
            $('#tgl_dok').val(output.tgldok);
            $('#tgl_buku').val(output.tglbuku);
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

      $(document).on('click', '#btnusul', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          manage = "usulkan_transfer";
          id_row = row.data()[0];
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'usulkan_transfer',id:id_row},
          dataType: "json",
          success: function (output) {
            alert("Telah Diajukan");
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            baca_tabel();
          }
        });
          
        });

        $(document).on('click', '#btnbatal', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          manage = "batalkan_transfer";
          id_row = row.data()[0];
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'batalkan_transfer',id:id_row},
          dataType: "json",
          success: function (output) {
            alert("Telah Dibatalkan");
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            baca_tabel();
          }
        });
          
        });
      $(document).on('click', '#btnkonfirm', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          manage = "konfirmasi_transfer";
          id_row = row.data()[0];
          $.ajax({
          type: "post",
          url: '../core/transaksi/prosestransaksi',
          data: {manage:'konfirmasi_transfer',id:id_row},
          dataType: "json",
          success: function (output) {
            
          }
        });
        $("#example1").DataTable().destroy();
        $("#example1 tbody").empty();
        baca_tabel();   
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
                  baca_tabel();
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
          var no_dok = $('#no_dok').val();
          var tgl_dok = $("#tgl_dok").val();
           $.ajax({
            type: "post",
            url: '../core/transaksi/validasi',
            data: {manage:'cek_tutup_tahun',kd_lokasi:"<?php echo $_POST['kd_satker'];?>"},
            dataType: "json",
            success: function (output) {        
              if(output.st_amb=="1"){
                $.notify("Tidak Dapat Menambah Transaski Setelah Import Saldo Awal di Tahun Anggaran Setelahnya","error");
                $('button:submit').attr("disabled", true); 
                return false;
              }
            }
            }); 
          $.ajax({
            type: "post",
            url: '../core/transaksi/prosestransaksi',
            data: {manage:'sisabarang_trf',kd_brg:kd_brg, nodok:'<?php echo $_POST["satker"];?>'},
            dataType: "json",
            success: function (output) {
            $('#rph_sat').val(output.sisa);
            $('#satuan').val(output.satuan);

            document.getElementById("jml_msk").setAttribute("max",output.sisa);

            }
          });
          $.ajax({
            type: "post",
            url: '../core/transaksi/prosestransaksi',
            data: {manage:'cek_status_opname',kd_brg:kd_brg, tgl_dok:tgl_dok, kd_lokasi:'<?php echo $_POST["kd_satker"];?>'},
            dataType: "json",
            success: function (output) {
              if(output.st_op!==null) {
                alert(output.nm_brg+" "+output.spesifikasi+" Sudah Dilakukan Opname, Untuk mengeluarkan barang, Hapus Opname Terlebih Dahulu.");
                $("#kd_brg").select2("val", "");
                $("#jml_msk").val('');
                $("#satuan").val('');
                $("#rph_sat").val('');
                $("#keterangan").val('');
              }
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
            alert("Kode Persediaan Barang Belum Dipilh");
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
              baca_tabel();
            }
          });
          return false;
        }
        else{
          alert("Kode Persediaan Barang Belum Dipilih");
          return false;
        }       
      });
    </script>
    <?php } ?>
  </body>
</html>
<?php }?>