<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <?php include("../config/dbconf.php"); ?>
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
            Cetak Laporan
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i></a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Surat Penyaluran Barang </h3>
                </div>  
                <form action="../core/report/prosesreport" method="post" class="form-horizontal" id="addtransmsk" >
                   <input type="hidden" name="manage" value="surat_penyaluran_barang">  
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Kode Satker</label>
                      <div class="col-sm-4">
                        <select name="satker" id="satker" class="form-control select2">
                          <!-- <option>Pilih Kode</option> -->
                        </select>
                      </div>
                    </div> 
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Nomor Dokumen</label>
                      <div class="col-sm-4">
                        <select name="no_dok" id="no_dok" class="form-control select2" required="">
                        </select>
                      </div>
                    </div>               
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Format laporan</label>
                      <div class="col-sm-4">
                        <select name="format" id="format" class="form-control">
                          <!-- <option value="pdf">PDF</option> -->
                          <option value="excel">Excel</option>
                        </select>
                      </div>
                    </div> 
                    <div class="box-footer">
                      <!-- <button type="Reset" class="btn btn-default">Reset</button> -->
                      <button type="submit" class="btn btn-info pull-right">Submit</button>
                    </div>
                  </div>
                </form>
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
      $(".treeview").addClass("active");
      $(".select2").select2();
      $("#satker").select2("val", "");
      $("li#l_kartu_brg").addClass("active");
      var table;
      $(function () {
      // $("#bln").hide();
      // $("#awal").hide();
      // $("#akhir").hide();
     
      $('#tgl_awal').datepicker({
          format: "dd-mm-yyyy"
      });         
      $('#tgl_akhir').datepicker({
            format: "dd-mm-yyyy"
        });             
      $("li#surat_permintaan_barang").addClass("active");

        });



      $('#satker').change(function(){
        if ($(this).val()=='') {
          // $('#satuan').val('');
          
        }
        else {
         var kode_satker =  $('#satker').val(); 
         $.ajax({
            type: "post",
            url: '../core/report/prosesreport',
            data: {manage:'baca_nomor_dok',satker:kode_satker},
            success: function (output) {     
              $('#no_dok').html(output);
            }
         });
        }
      });
       $.ajax({
          type: "post",
          url: '../core/report/prosesreport',
          data: {manage:'baca_upb'},
          success: function (output) {     
            $('#satker').html(output);
          }
       });

    $('form').on('submit', function() {
      var D1 = document.getElementById("tgl_awal").value;
      var D2 = document.getElementById("tgl_akhir").value;

      if(document.getElementById("kd_brg").value=="")
      {
        alert("Barang Persediaan Belum Dipilih");
        return false;
      }      

      if(document.getElementById("satker").value=="")
      {
        alert("Kode Satker Belum Dipilih");
        return false;
      }

      if( (new Date(D1).getTime() > new Date(D2).getTime()))
      {
        alert("Tanggal Awal Tidak Boleh Lebih Besar dari Tanggal Akhir");
        return false;
      }
      else
      {
        return true;
      }
    });

    </script>
  </body>
</html>
