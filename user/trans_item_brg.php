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
  <div class="container">                       
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                          <div class="modal-dialog">
                            
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Edit Detail Rekening </h4>
                              </div>
                              <form action="../core/transaksi/prosestransaksi" method="post" class="form-horizontal" id="submit_update_rek">
                              <div class="form-group">
                                <input type="hidden" name="update_rekening" >
                                <input type="hidden" name="id_edit" id="id_edit" >
                                <label class="col-sm-3 control-label">Kode Rekening </label>
                                <div class="col-sm-8">
                                 <input type="text"  name="detail_rek" class="form-control" id="detail_rek" readonly>
                                </div>
                              </div>
                              <div class="form-group" >
                                <label class="col-sm-3 control-label">Nilai <b>Non</b> Persediaan</label>
                                <div class="col-sm-8">
                                  <input type="number" min="0" name="edit_nilai_kontrak" class="form-control" id="edit_nilai_kontrak"  placeholder="Masukkan Nilai Non Persediaan" >
                                </div> 
                              </div>
                              <div class="form-group" >
                                  <label class="col-sm-3 control-label">Keterangan Nilai Non Persediaan</label>
                                  <div class="col-sm-8">
                                   <input type="text"  name="edit_ket_non_persediaan" class="form-control" id="edit_ket_non_persediaan"  placeholder="Masukkan Keterangan Non Persediaan" >
                                  </div> 
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-info" id="update_rek" data-dismiss="modal">Simpan Data</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                              </div>
                            </form>
                            </div>
                            
                          </div>
                        </div>
                      </div>
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
                        
                        <?php if($_POST['jenistrans']!="Transfer ") { ?> 
                        <div class="form-group" id="jns_masuk">
                        <label class="col-sm-3 control-label">Jenis Pemasukan</label>
                          <div class="col-sm-8">
                            <select name="jenis_pemasukan" id="jenis_pemasukan" class="form-control" required>
                            <option>Pilih Jenis Pemasukkan</option>
                              <option value="persediaan">Input Persediaan</option>
                              <option value="non_persediaan">Input Non Persediaan</option>
                            </select>
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
                        <label class="col-sm-3 control-label">Keterangan Nilai Non Persediaan</label>
                        <div class="col-sm-8">
                          <input type="text"  name="ket_non_persediaan" class="form-control" id="ket_non_persediaan"  placeholder="Masukkan Keterangan Non Persediaan" >
                        </div> 
                      </div>                          
                        <div class="form-group" id="field_kode_persediaan">

                          <label class="col-sm-3 control-label">Kode / Nama Barang</label> 
                          <div class="col-sm-8" id="lbr_kode_persediaan">
                            <select name="kd_brg" id="kd_brg" class="form-control select2">
                            </select>
                          </div>
                        </div>
                        <div class="form-group" id="field_jumlah_masuk" >
                          <label class="col-sm-3 control-label">Jumlah Masuk</label>
                          <div class="col-sm-4">
                            <input type="number" min="0,1" name="jml_msk" class="form-control" id="jml_msk" step="any" placeholder="Masukkan Jumlah">
                          </div>                             
                          <div class="col-sm-1" id="field_satuan">
                            <label class="control-label">Satuan</label>
                          </div> 
                          <div class="col-sm-3">
                            <!-- <input type="text" name="satuan" id="satuan" class="form-control"  readonly> -->
                            <select name="satuan" id="satuan" class="form-control select2">
                            </select>
                          </div>                            
                        </div>                  
                        <div class="form-group" id="field_harga_satuan">
                          <label class="col-sm-3 control-label">Harga Satuan Barang</label>
                          <div class="col-sm-8">
                            <input type="number" min="1" name="rph_sat" class="form-control" id="rph_sat" step="any" placeholder="Masukkan Harga ">
                          </div>
                        </div>
                        <div class="form-group" id="field_ket_brg">
                          <label class="col-sm-3 control-label">Keterangan Barang</label>
                          <div class="col-sm-8">
                            <input type="text" name="ket_brg" class="form-control" id="ket_brg" step="any" placeholder="Keterangan Barang Jika Diperlukan">
                          </div>
                        </div>
                        

                         <?php }  ?>                  
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
                  <h3 class="box-title">Daftar Transaksi Masuk</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>No Dok</th>
                        <th width="10%">Rekening</th>
                        <th>Nama Barang</th>
                        <th>Spesifikasi</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>  
                        <th>Keterangan</th>
                        <th width="8%">Sisa</th>
                        <th width="8%">Aksi</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Nilai Non Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Kode Rekening</th>
                        <th>Nama Rekening</th>
                        <th>Nilai Non Persediaan</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <?php } ?>              
              <?php if ($_POST['manage']=="trans_keluar") { ?>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Daftar Transaksi Keluar</h3>
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

    var jns_pemasukan;
    var table_rek;
    var table;
    $("li#trans_masuk").addClass("active");
    $("#field_satuan").hide();
    $("#field_pilihan_kode").hide();
    $("#field_harga_satuan").hide();
    $("#field_jumlah_masuk").hide();
    $("#field_kode_persediaan").hide();
    $("#field_nilai_non_persediaan").hide();
    $("#field_ket_brg").hide();
    $("#ket_non_persediaan").hide();
    $("#pilihan_kode").hide();
    $('form').on('focus', 'input[type=number]', function (e) {
      $(this).on('mousewheel.disableScroll', function (e) {
        e.preventDefault()
      })
    })
    $('form').on('blur', 'input[type=number]', function (e) {
      $(this).off('mousewheel.disableScroll')
    });
    
    function baca_rekening(){
      table_rek = $("#example2").DataTable({
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

    
    function list_kode_barang(){
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
          width:'resolve'
        });



    }
      $(function () {
        function list_kode_rekening() {
          $.ajax({
              type: "post",
              url: '../core/transaksi/prosestransaksi',
              data: {manage:'baca_rekening'},
              success: function (output) { 
                $('#kode_rek').html(output);
                $("#kode_rek").select2({
                placeholder: "-- Pilih Kode Rekening --",
                width:'resolve'
              });
            }
          });
        }
        // list_kode_barang();
            
        baca_rekening();
        table = $("#example1").DataTable({
          "aaSorting": [[ 0, 'desc' ]], 
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
            {"targets": 9 },
            {"targets": 10,
             "visible": true },
            {"targets": 11 },

          ],
        });
        // $('#example1 tbody').on('click', 'tr', function () {
        //     var data = table.row( this ).data();
        //     alert( 'You clicked on '+data[0]+'\'s row' );
        // } );
        function hapus_input(){
          if(jns_pemasukan=="persediaan") $("#kd_brg").select2("val", '');
          $("#kode_rek").select2("val", '');
          $("#jml_msk").val('');
          $("#satuan").val('');
          $("#rph_sat").val('');
          $("#ket_brg").val('');
        }
              var sumber_dana = "<?php echo $_POST['jenistrans']?>";
             
         $('#jenis_pemasukan').change(function(){
          jns_pemasukan = $("#jenis_pemasukan").val();
          // alert(jns_pemasukan);
          if(jns_pemasukan=="persediaan" && sumber_dana=="APBD"){
            $("#field_satuan").show();
            $("#pilihan_kode").show();
            $("#field_harga_satuan").show();
            $("#field_jumlah_masuk").show();
            $("#field_ket_brg").show();
            $("#field_kode_persediaan").show();
            $("#pilihan_kode").show();
            $("#field_nilai_non_persediaan").hide();
            $("#ket_non_persediaan").hide();
            $("#kode_rek").prop('required',true);
            $("#kd_brg").prop('required',true);
            $("#satuan").prop('required',true);
            $("#jml_msk").prop('required',true);
            $("#harga_sat").prop('required',true);
            list_kode_barang();

            $("#field_nilai_non_persediaan").prop('required',false);
            hapus_input();
          }
          else if(jns_pemasukan=="non_persediaan" && sumber_dana=="APBD"){
            $("#field_satuan").prop('required',false);
            $("#field_harga_satuan").prop('required',false);
            $("#field_jumlah_masuk").prop('required',false);
            $("#field_kode_persediaan").prop('required',false);
            $("#field_satuan").hide();
            $("#field_harga_satuan").hide();
            $("#field_jumlah_masuk").hide();
            $("#field_kode_persediaan").hide();
            $("#field_ket_brg").hide();
            $("#pilihan_kode").show();
            $("#field_nilai_non_persediaan").show();
            $("#ket_non_persediaan").show();
            $("#kode_rek").prop('required',true);
            $("#kd_brg").prop('required',false);
            $("#satuan").prop('required',false);
            $("#jml_msk").prop('required',false);
            $("#harga_sat").prop('required',false);
            list_kode_rekening();
            hapus_input();

          }
          else if(jns_pemasukan=="persediaan" && sumber_dana!="APBD"){
            $("#field_satuan").show();
            $("#pilihan_kode").hide();
            $("#field_harga_satuan").show();
            $("#field_jumlah_masuk").show();
            $("#field_kode_persediaan").show();
            $("#field_ket_brg").show();
            $("#field_nilai_non_persediaan").hide();
            $("#field_nilai_non_persediaan").prop('required',false);
            $("#kode_rek").prop('required',false);
            $("#kd_brg").prop('required',true);
            $("#satuan").prop('required',true);
            $("#jml_msk").prop('required',true);
            $("#harga_sat").prop('required',true);
            $("#ket_non_persediaan").hide();
            hapus_input();

          }
          else{
            $("#field_satuan").hide();
            $("#pilihan_kode").hide();
            $("#field_harga_satuan").hide();
            $("#field_jumlah_masuk").hide();
            $("#field_kode_persediaan").hide();
            $("#field_nilai_non_persediaan").hide();
            $("#ket_non_persediaans").hide();
            hapus_input();
          }
          });

  
        
        if(sumber_dana=="APBD"){
          list_kode_rekening();
        }
        else{
          $('#pilihan_kode').hide();
          $('#field_nilai_non_persediaan').hide();
          $('#jns_masuk').hide();
          $('#field_kode_persediaan').show();
          $('#field_jumlah_masuk').show();
          $('#field_harga_satuan').show();
          $('#field_satuan').show();
          $("#field_ket_brg").show();
          $('#jenis_pemasukan').hide();
          list_kode_barang();
        }
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
              table = $("#example1").DataTable({
                "aaSorting": [[ 0, 'desc' ]],
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
                  {"targets": 9 },
                  {"targets": 10,
                   "visible": true },
                  {"targets": 11 },
                ],
              });
          }
        });
        return false;
      });

      $(document).on('click', '#edit_rek', function () {
        // alert("Fitur sedang dikembangkan, coba beberapa hari lagi");
        var tr = $(this).closest('tr');
        var row = table_rek.row( tr );
        id = row.data()[0];
        kode_rek = row.data()[1];
        nama_rek = row.data()[2];
        nilai_kontrak = row.data()[3];
        ket_rek = row.data()[4];
         $("#myModal").modal();
         $("#id_edit").val(id);
         $("#detail_rek").val(+kode_rek+" : "+nama_rek);
         $("#edit_nilai_kontrak").val(nilai_kontrak);
         $("#edit_ket_non_persediaan").val(ket_rek);
      });
       $(document).on('click', '#update_rek', function (e) {
          case_menu       = "update_rekening" ;
          id_row          = $('#id_edit').val();
          nilai_baru      = $('#edit_nilai_kontrak').val();
          keterangan_baru = $('#edit_ket_non_persediaan').val();
          $.ajax({
                type: "post",
                url : "../core/transaksi/prosestransaksi",
                data: {manage:case_menu, id:id_row, nilai_baru:nilai_baru, keterangan_baru:keterangan_baru},
                success: function(data)
                {
                    $("#example2").DataTable().destroy();
                    $("#example2 tbody").empty();
                    baca_rekening();
                }
              });
       });  
      $(document).on('click', '#hapus_rek', function () {
        var tr = $(this).closest('tr');
        var row = table_rek.row( tr );
        redirectTime = "2600";
        redirectURL = "trans_masuk";
        id_row = row.data()[0];
        managedata = "hapusTransMasuk";
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
                    $("#example2").DataTable().destroy();
                    $("#example2 tbody").empty();
                    baca_rekening();
                }
              });
        }
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
                }
              });
            $.notify("Penghapusan Barang Berhasil","success");
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
                       {"targets": 10,
                        "visible": true },
                       {"targets": 11 },
                     ],
                     "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
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
          var tgl_dok = $("#tgl_dok").val();
          // $.ajax({
          //   type: "post",
          //   url: '../core/transaksi/prosestransaksi',
          //   data: {manage:'cek_status_opname',kd_brg:kd_brg, tgl_dok:tgl_dok, kd_lokasi:'<?php echo $_POST["kd_satker"];?>'},
          //   dataType: "json",
          //   success: function (output) {
          //     if(output.st_op!==null) {
          //       // alert(output.nm_brg+" "+output.spesifikasi+" Sudah Dilakukan Opname, Untuk menambahkan barang, Hapus Opname Terlebih Dahulu.");
          //        $.notify(output.nm_brg+" "+output.spesifikasi+" Sudah Dilakukan Opname, Untuk menambahkan barang, Hapus Opname Terlebih Dahulu.", "error");
          //       $("#kd_brg").select2("val", "");
          //       $("#jml_msk").val('');
          //       $("#satuan").val('');
          //       $("#rph_sat").val('');

          //     }
          //   }
          // });

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
          data: {manage:'baca_detil_trans',kd_brg:kd_brg,no_dok:no_dok},
          // dataType: "json",
          success: function (output) {     
            $('#satuan').html(output);
            $("#satuan").select2({
           placeholder: "Pilih Satuan Barang",
           allowClear: false
          });
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
        
      

          // if($('#kd_brg').select2('data')== "") {
          //   // alert("Kode Barang persediaan Belum Dipilih");
          //   $("#kd_brg").notify("Kode Persediaan Barang Belum Dipilih","error");
          //   return false;
          // }
          // if ($('#jml_msk').val() == "") {
          //   $("#jml_msk").notify("Masukkan Jumlah Barang yang Diterima","error");
          //   return false;
          // };
          // if ($('#satuan').val() == "") {
          //   // alert("Satuan Barang Belum Dipilih Atau Dimasukkan");
          //   $("#satuan").notify("Satuan Barang Belum Dimasukkan","error");
          //   return false;
          // };
          // if ($('#rph_sat').val() == "") {
          //   $("#rph_sat").notify("Masukkan Harga Beli / Perolehan Satuan","error");
          //   return false;
          // };
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
              if(jns_pemasukan=="persediaan") $("#kd_brg").select2("val", "");
              $("#jml_msk").val('');
              $("#satuan").val('');
              $("#rph_sat").val('');
              $("#keterangan").val('');
              $('button:submit').attr("disabled", false); 
              $("#example1").DataTable().destroy();
              $("#example1 tbody").empty();
              $("#example2").DataTable().destroy();
              $("#example2 tbody").empty();
              baca_rekening();
              table = $("#example1").DataTable({
                "aaSorting": [[ 0, 'desc' ]], 
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
                  {"targets": 10,
                   "visible": true },
                  {"targets": 11 },
                ],
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
              });
            $.notify("Data Berhasil Ditambahkan", "success");
            }
          });
          
          return false;
      
      });
    </script>

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
            data: {manage:'sisabarang',kd_brg:kd_brg, nodok:'<?php echo $_POST["satker"];?>'},
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
                ],
              });
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