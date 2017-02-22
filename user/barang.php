<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <?php include("include/header.php"); ?>
      <?php include("include/sidebar.php"); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Kelompok Barang Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li class="active"><a href="#"><i class="fa fa-table"></i> Barang Persediaan</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data</h3>
                </div>
				        <form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="addbarang">
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Unit Satker</label>
                      <div class="col-sm-9">
                        <select name="readsatker" id="readsatker" class="form-control">
                        </select>                
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" style="padding-top:2px;">Kode Sub-sub Kelompok Barang</label>
                      <div class="col-sm-9" style="padding-top:7px;">
                        <select name="kdsskel" id="kdsskel" class="form-control select2">
                          <option value="">-- Pilih Kode Sub-sub Kelompok Barang --</option>
                        </select>
						            <input type="hidden" name="manage" value="addbarang">                   
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Kode Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="kodebarang" class="form-control" id="kodebarang" placeholder="Pilih Kode Sub-sub Kelompok Barang terlebih dahulu" required readonly>
                      </div>
                    </div>                    
					         <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="namabarang" class="form-control" id="namabarang" placeholder="Masukkan Nama Barang" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Satuan</label>
                      <div class="col-sm-9">
                        <input type="text" name="satuan" class="form-control" id="satuan" placeholder="Masukkan Satuan Barang" required>
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
                  <h3 class="box-title">Daftar Barang Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="14%">ID</th>
                        <th width="18%">Kode Sub-Sub Kel.</th>
                        <th width="14%">Kode Barang</th>
                        <th>Nama Barang</th>
                        <th width="14%">Satuan</th>
                        <th width="12.5%">Aksi</th>
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
    </div>
    <?php include("include/loadjs.php"); ?>
    <?php include("include/success.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">

      function cek_kode() {
      
        var kdsskel = $('#kdsskel').val();
        var kodebarang = $('#kodebarang').val();
    
          $.ajax({
            url: '../core/barang/prosesbarang',
            type: 'POST',
            data: {kdsskel:kdsskel, kodebarang:kodebarang, manage:'cekkode'},
            dataType: "json",
            success:function(data){
              if(data.kd_brg!=null)
              {
                alert("Kode Barang "+kodebarang+" sudah digunakan oleh barang "+data.nm_brg);
                $('#kodebarang').val('');
                return false;
              }
            }
          });
      }
      $.ajax({
        type: "post",
        url: '../core/transaksi/prosestransaksi',
        data: {manage:'readsatkerdok',no_dok:"<?php echo($_SESSION['kd_lok']);?>"},
        success: function (output) {     
          $('#readsatker').html(output);
        }
      });
      $('#kdsskel').change(function(){
        if ($(this).val()=='') 
        {
          $('#kodebarang').prop('readonly', true);
          $('#kodebarang').prop('placeholder', 'Pilih Kode Sub-sub Kelompok Barang Terlebih Dahulu');

        }
        else 
        {
          $('#kodebarang').prop('readonly', false);
          $('#kodebarang').prop('placeholder', 'Masukan Kode Barang');
        }
      });
      $(function () {
        $("li#barang").addClass("");
        $(".select2").select2();
        $.ajax({
          type: "post",
          url: '../core/barang/prosesbarang',
          data: {manage:'readsskel'},
          success: function (output) {     
            $('#kdsskel').html(output);
          }
        });
        table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadbarang",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
			      {"targets": 3 },
            {"targets": 4 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="box-tools">'+
                                // '<a href="edit_trans_masuk?id=a" class="btn btn-success btn-sm daterange pull-left" role="button"><i class="fa fa-edit"></i></a>'+
                                  '<button id="btnedt" class="btn btn-success btn-flat btn-xs daterange pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                  '<button id="btnhps" class="btn btn-danger btn-flat btn-xs pull-right"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [5],"targets": 5 }
          ],
        });
      });
      $(document).on('click', '#btnedt', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        id_row = row.data()[0];
        sskel_row = row.data()[1];
        kdbrg_row = row.data()[2];
        nmbrg_row  = row.data()[3];
        satuan_row  = row.data()[4];

        $.ajax({
          type: "post",
          url: '../core/barang/prosesbarang',
          data: {manage:'cekbarang',sskel_row:sskel_row,kdbrg_row:kdbrg_row},
          dataType: "json",
          success: function (output)
          {
            if(output.kdbrg!=null)
            {
              alert("Tidak Dapat Mengedit Barang. Barang Sudah Digunakan di Data Transaksi Masuk !");
              return false;
            }
            else
            {
              if ( row.child.isShown() ) {
                $('div.slider', row.child()).slideUp( function () {
                  row.child.hide();
                  tr.removeClass('shown');
                });
              }
              else
              {
                row.child( format(row.data())).show();
                tr.addClass('shown');
                $('div.slider', row.child()).slideDown();
                $("#kode_sskel"+id_row +"").val(sskel_row);
                $("#kode_brg"+id_row +"").val(kdbrg_row);
                $("#nama_brg"+id_row +"").val(nmbrg_row);
                $("#satuan_brg"+id_row +"").val(satuan_row);
              }
            }
           }
          });
      });
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="updbarang">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updbarang">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<td width="16%"><input style="width:90%" id="kode_sskel'+d[0]+'" name="updkdsskel" class="form-control" type="text" placeholder="Kode SSkel" readonly></td>'+
              '<td width="13%"><input style="width:90%" id="kode_brg'+d[0]+'" name="updkdbrg" class="form-control" type="text" placeholder="Kode Barang" readonly></td>'+ 
              '<td width="49%"><input style="width:98%" id="nama_brg'+d[0]+'" name="updnmbrg" class="form-control" type="text" placeholder="Nama Barang" required></td>'+
              '<td width="17%"><input style="width:90%" id="satuan_brg'+d[0]+'" name="updsatbrg" class="form-control" type="text" placeholder="Satuan Barang" required></td>'+
              '<td style="vertical-align:middle; width:15%;">'+
                '<div class="box-tools">'+
                  // '<button id="btnrst" class="btn btn-warning btn-sm pull-left" type="reset"><i class="fa fa-refresh"></i> Reset</button>'+
                  '<button id="btnupd" class="btn btn-primary btn-sm pull-right"><i class="fa fa-upload"></i> Update</button>'+
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
      redirectURL = "barang";
      id_row = row.data()[0];
      sskel_row = row.data()[1];
      kdbrg_row = row.data()[2];
      nmbrg_row  = row.data()[3];
      satuan_row  = row.data()[4];
      managedata = "hapusbarang";
      
      $.ajax({
          type: "post",
          url: '../core/barang/prosesbarang',
          data: {manage:'cekbarang',sskel_row:sskel_row,kdbrg_row:kdbrg_row,nmbrg_row:nmbrg_row, satuan_row:satuan_row},
          dataType: "json",
          success: function (output)
          {
            
            if(output.kdbrg!=null)
            {
              alert("Tidak Dapat Mengedit Barang. Barang Sudah Digunakan di Data Transaksi Masuk !");
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
              $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
              });
              $('#myModal').modal('show');
              $.ajax({
                type: "post",
                url : "../core/barang/prosesbarang",
                data: {manage:managedata,id:id_row,sskel_row:sskel_row,kdbrg_row:kdbrg_row,nmbrg_row:nmbrg_row, satuan_row:satuan_row},
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

      $(document).on('submit', '#updbarang', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "barang";
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

      $('#addbarang').submit(function(e){
        if(document.getElementById("kdsskel").value=="")
        {
          alert("Kode Sub Sub Kelompok Barang Belum Dipilih");
          return false;
        }
        cek_kode();
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "2600";
        redirectURL = "barang";
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
