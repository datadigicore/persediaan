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
        
        <section class="content-header">
          <h1>
            Persediaan Masuk
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-compress"></i> Transaksi Masuk - Non Persediaan</a></li>
          </ol>
        </section>
       
      
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Nilai Non Persediaan Untuk Nomor Dokumen <?php echo $_POST['satker'];?> </h3>
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
                          <label class="col-sm-5 control-label">No. Dokumen</label>
                          <div class="col-sm-7">
                            <input type="text" name="no_dok_item" id="no_dok_item" class="form-control" style="width:100%;" readonly value="<?php echo $_POST['satker'];?>">
                            <input type="hidden" name="manage" value="tbh_transaksi_msk">
                            <input type="hidden" id="read_no_dok" name="read_no_dok">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-5 control-label">Keterangan</label>
                          <div class="col-sm-7">
                            <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="" readonly>
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
                   
                      <div class="col-sm-7">
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Tgl. Dokumen</label>
                          <div class="col-sm-8">
                            <input type="text" id="tgl_dok" name="tgl_dok" class="form-control" readonly>
                          </div>
                        </div>                  
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Tgl. Pembukuan</label>
                          <div class="col-sm-8">
                            <input type="text" id="tgl_buku" name="tgl_buku" class="form-control" readonly>
                          </div>
                        </div>

                          <div class="form-group" id="pilihan_kode">
                          <label class="col-sm-3 control-label">Kode Rekening Belanja</label>
                          <div class="col-sm-8">
                            <select name="kode_rek" class="form-control select2" id="kode_rek" >
                            </select>
                          </div>
                        </div> 
                       
               
                      <div class="form-group" id="field_nilai_non_persediaan">
                        <label class="col-sm-3 control-label">Nilai <b>Non</b> Persediaan</label>
                        <div class="col-sm-8">
                          <input type="number" min="0" name="nilai_kontrak" class="form-control" id="nilai_kontrak"  placeholder="Masukkan Nilai Non Persediaan" >
                        </div> 
                      </div>
                      <div class="form-group" id="ket_non_persediaan">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-8">
                          <input type="text"  name="ket_non_persediaan" class="form-control" id="ket_non_persediaan"  placeholder="Masukkan Keterangan Non Persediaan" >
                        </div> 
                      </div>
                 
                        <div name="detil_transaksi" id="detil_transaksi">
                        </div>
                      </div>  

                      
                    </div>
                  </div> <!-- </div class="box-body">  -->
                  <?php if($_POST['jenistrans']!="Transfer ") { ?> 
                  <div class="box-footer">
                      <!-- <button type="reset" id="btn_resets" class="btn btn-default">Reset</button> -->
                      <button type="submit" class="btn btn-info pull-right">Submit</button>
                  <?php } ?>
                    </div>
                </form>
              </div>
              <?php if ($_POST['manage']=="trans_masuk") { ?>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transaksi Masuk - Non Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Kode Rekening</th>
                        <th >Nama Rekening</th>
                        <th>NNilai Non Persediaan</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
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
          "aaSorting": [[ 0, 'desc' ]], 
          "processing": false,
          "serverSide": true,
          "ajax":
          {
            'type': 'GET',
            'url': '../core/loadtable/load_nilai_kontrak',
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
          ],
        }); 

    }
      $(function () {
        $(".select2").select2();
        $("li#trans_masuk").addClass("active");
        $("li#saldo_awal").addClass("active");
        baca_tabel();
          
          $.ajax({
              type: "post",
              url: '../core/transaksi/prosestransaksi',
              data: {manage:'baca_rekening'},
              success: function (output) { 
                $('#kode_rek').html(output);
                $("#kode_rek").select2({
                placeholder: "-- Pilih Rekening --"
              });
            }
          });
        

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
            $('#keterangan').val(output.keterangan);
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
        var qty_rw = row.data()[5];
        var qty_rw2 = qty_rw.replace(",",".");
        qty_row = qty_rw2;
        var harga_satuan = row.data()[7];
        var harga_satuan2 = harga_satuan.replace(".","");
        harga_sat_row = parseFloat(harga_satuan2.replace(",","."));
        // alert(harga_sat_row);
        total_harga_row = row.data()[8];
        ket_row = row.data()[8];
        qty_akhir = row.data()[5]-row.data()[10];
        if(qty_akhir==0) qty_akhir=1;

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
          }
      });

        

      });
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="ubah_brg_masuk">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="ubah_transaksi_msk">'+
              '<input type="hidden" name="id" value="'+id_row+'">'+
              '<td width="14%"><input style="width:97%" id="kd_brg'+d[0]+'" name="jns_trans_baru" class="form-control" type="text" readonly></td>'+
              '<td width="11%"><input style="width:97%" id="nm_brg'+d[0]+'" name="kd_satker" class="form-control" type="text" readonly></td>'+
              '<td width="10%"><input style="width:97%" id="spesifikasi'+d[0]+'" name="nodok_baru" class="form-control" type="text" readonly></td>'+
              '<td width="8%"><input style="width:97%" step="any" id="qty'+d[0]+'" name="jumlah_baru" class="form-control" type="number" min="'+qty_akhir+'" required ></td>'+
              '<td width="13%"><input style="width:99%" id="total_harga'+d[0]+'" name="ket_baru" class="form-control" type="text" readonly ></td>'+
              '<td width="11%"><input style="width:98%" step="any" id="harga_sat'+d[0]+'" name="harga_baru" min="1" class="form-control" type="number" required ></td>'+
              
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
      $(document).on('submit', '#ubah_brg_masuk', function (e) {        
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
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              $('button:submit').attr("disabled", false); 
          }
        });
        return false;
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
                }
              });
            $.notify("Penghapusan Barang Berhasil","success");
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
             
              $('button:submit').attr("disabled", false); 
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
            $.notify("Data Berhasil Ditambahkan", "success");
            }
          });
          
          return false;
      
      });
    </script>
    <?php } ?>
  </body>
</html>
<?php }?>