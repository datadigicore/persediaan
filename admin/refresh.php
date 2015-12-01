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
            Refresh Mutasi Persediaan
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
                 <!--  <h3 class="box-title"> Refresh Mutasi Persediaan</h3> -->
                 <h5>Refresh Berfungsi untuk menghitung ulang mutasi pengeluaran barang dengan metode FIFO yang disebabkan input persediaan masuk dengan tanggal penerimaan dibawah tanggal pengeluaran barang</h5>  
                </div>

                <form action="../core/konfig/proseskonfigurasi" method="post" class="form-horizontal" id="addtransmsk" >
                   <input type="hidden" name="manage" value="refresh">  
                  <div class="box-body">
                      <!-- <p>
                        Proses refresh dilakukan untuk menghitung ulang pengelaran barang dengan metode FIFO yang disebabkan 
                      </p>
                      <p>
                        Setelah proses tutup tahun, data-data persediaan tahun sebelumnya tidak dapat dibuka lagi.
                      </p>
                      <p>
                       Untuk melakukan proses tutup tahun, pilih kode satker yang akan dilakukan tutup tahun, kemudian klik proses.
                      </p> -->
                    </div>                   
                    <div class="box-body">
                      <label class="col-sm-2 control-label">Kode UPB</label>
                      <div class="col-sm-8">
                        <select name="satker" id="satker" class="form-control">
                        </select>
                      </div>
                    </div> 
                    <div class="box-footer">
                      <!-- <button type="Reset" class="btn btn-default">Reset</button> -->
                      <button type="submit" class="btn btn-info pull-right">Proses</button>
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
      $("li#refresh").addClass("active");
  $("#satker").select2({
  placeholder: "-- Masukkan Kode UPB--",
  ajax: {
    url: '../core/konfig/proseskonfigurasi',
    dataType: 'json',
    type: 'post',
    delay: 250,
    data: function (params) {
      return {
        manage:'baca_upb_admin',
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

    $('#addtransmsk').submit(function(e){
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "refresh";
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
      });
    </script>
  </body>
</html>
