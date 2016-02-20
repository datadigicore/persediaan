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
            Sub Kelompok Barang Persediaan
            <small>Tahun Anggaran <?php echo($_SESSION['thn_ang']);?></small>
          </h1>
          <ol class="breadcrumb">
            <li><i class="fa fa-link"></i> Lain - lain</li>
            <li class="active"><a href="#"><i class="fa fa-table"></i> Sub Kelompok Barang</a></li>
          </ol>
        </section>
        <section class="content">
          <div class="row">
            <section class="col-lg-12 connectedSortable">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tambah Data Sub Kelompok Barang</h3>
                </div>  
                <form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="addbarang">
                  <div class="box-body">
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Jenis Barang </label>
                      <div class="col-sm-5">
                        <select name="kdbarang_no" id="kdbarang_no" class="form-control select2" placeholder="Kode Barang">
                        </select>
                        <input type="hidden" name="manage" value="addsubbarang">
                      </div>
                      <!-- <div class="col-sm-2">
                        <label class="control-label">Kode Barang Persediaan </label>
                      </div>                      
                      <div class="col-sm-2">
                        <input type="text" name="kdbarang" class="form-control" id="kdbarang" placeholder="Kode Barang"  required>
                      </div> -->
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Nama Barang</label>
                      <div class="col-sm-9">
                        <input type="text" name="nmbarang" class="form-control" id="nmbarang" placeholder="Masukkan Nama Barang">
                      </div>
                    </div>
                    <div class="form-group" style="margin-top:15px;">
                      <label class="col-sm-2 control-label">Spesifikasi </label>
                      <div class="col-sm-9">
                        <input type="text" name="spesifikasi" class="form-control" id="spesifikasi" placeholder="Masukkan Spesifikasi : Mis. Warna, Ukuran, Tebal, dsb">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Satuan</label>
                      <div class="col-sm-9">
                        <select name="satuan" id="satuan" class="form-control select2">
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="box-footer">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                  </div>
                </form>
              </div>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Tabel Sub Kelompok Barang Persediaan</h3>
                </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th width="16%">Kode Barang</th>
                        <th width="16%">Jenis Barang</th>
                        <th>Uraian Barang</th>
                        <th>Spesifikasi</th>
                        <th width="16%">Satuan</th>
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
      <?php include("include/success.php"); ?>
    </div>
    <?php include("include/loadjs.php"); ?>
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../dist/js/jquery.mask.js" ></script>
    <script type="text/javascript">
      // function cek_kode() {
      
      //   var kdsskel = $('#kdbarang_no').val();
      //   var kodebarang = $('#kdbarang').val();

      //     $.ajax({
      //       url: '../core/barang/prosesbarang',
      //       type: 'POST',
      //       data: {kdsskel:kdsskel, kodebarang:kodebarang, manage:'cekkode'},
      //       dataType: "json",
      //       success:function(data){
      //         if(data.kd_brg!=null)
      //         {
      //           alert("Kode Barang "+kdsskel+"."+kodebarang+" sudah digunakan oleh barang "+data.nm_brg);
      //           $('#kodebarang').val('');
      //           return false;
      //         }
      //       }
      //     });
      // }
      $('#kdbarang').mask('999',{placeholder:"____"});
      var table;
      function myTable() {
      table = $("#example1").DataTable({
          "processing": false,
          "serverSide": true,
          "ajax": "../core/loadtable/loadsubkelbar",
          "columnDefs":
          [
            {"targets": 0,
             "visible": false },
            {"targets": 1 },
            {"targets": 2 },
            {"targets": 3 },
            {"targets": 4 },
            {"targets": 5 },
            {"orderable": false,
             "data": null,
             "defaultContent":  '<div class="row-fluid">'+
                                  // '<button id="btnedt" class="btn btn-success btn-xs btn-flat pull-left"><i class="fa fa-edit"></i> Edit</button>'+
                                  '<button id="btnalih" class="col-xs-12 btn btn-edit btn-xs btn-flat"><i class="fa fa-edit"></i> Ubah Jenis</button>'+
                                  '<button id="btnhps" class="col-xs-12 btn btn-danger btn-xs btn-flat"><i class="fa fa-remove"></i> Hapus</button>'+
                                '</div>',
             "targets": [6],"targets": 6 }
          ],
          "order": [[ 0, "desc" ]],
          "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>t<"row"<"col-sm-6"i><"col-sm-6"p>>',
        });
      }
      $(function () {
        $(".select2").select2();
         $("#kdbarang_no").select2({
           placeholder: "Pilih Jenis Barang Persediaan",
           allowClear: true
          });
        // $("#kdbarang_no").select2({
        //   placeholder: "-- Pilih Kode Item Barang --",
        //   ajax: {
        //     url: '../core/barang/prosesbarang',
        //     dataType: 'json',
        //     type: 'post',
        //     delay: 250,
        //     data: function (params) {
        //       return {
        //         manage:'readbarang',
        //         q: params.term, // search term
        //         page: params.page
        //       };
        //     },
        //     processResults: function (data, page) {
        //       return {
        //         results: data
        //       };
        //     },
        //     cache: true
        //   },
        //   escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        //   minimumInputLength: 1,
        // });

        $("#satuan").select2({
          placeholder: "-- Pilih Satuan Barang --",
          ajax: {
            url: '../core/barang/prosesbarang',
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: function (params) {
              return {
                manage:'readsatuan',
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
        $(".treeview").addClass("active");
        $("li#subkelbar").addClass("active");
        myTable();
        $(document).on("click", "#btnedt", function(){
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          id_row = row.data()[0];
          kdbarang_row = row.data()[1];
          urbarang_row  = row.data()[2];
          spesifikasi_row  = row.data()[3];
          satuan_row  = row.data()[4];
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
            $("#kdbarang"+id_row+"").val(kdbarang_row);
            $("#urbarang"+id_row+"").val(urbarang_row);
            $("#spesifikasi"+id_row+"").val(spesifikasi_row);
            $("#satuan"+id_row+"").val(satuan_row);
          }
        });

        $(document).on("click", "#btnalih", function(){
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          id_row = row.data()[0];
          kdbarang_row = row.data()[1];
          urbarang_row  = row.data()[2];
          spesifikasi_row  = row.data()[3];
          satuan_row  = row.data()[4];
          if ( row.child.isShown() ) {
            $('div.slider', row.child()).slideUp( function () {
              row.child.hide();
              tr.removeClass('shown');
            });
          }
          else {
            $.ajax({
                type: "post",
                url: '../core/barang/prosesbarang',
                data: {manage:'readbarang'},
                success: function (output) {     
                  $('#kdbaru').html(output);
                }
             });
            
            row.child( ubh_jns(row.data())).show();
            tr.addClass('shown');
            $('div.slider', row.child()).slideDown();
            $("#kdbarang"+id_row+"").val(kdbarang_row);
            $("#urbarang"+id_row+"").val(urbarang_row);
            $("#spesifikasi"+id_row+"").val(spesifikasi_row);
            $("#satuan"+id_row+"").val(satuan_row);
            $("#kdbaru").select2({
             placeholder: "Pilih Jenis Barang Persediaan",
             allowClear: false
            });
          }
        });
        $(document).on('click', '#btnhps', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          redirectTime = "1000";
          id_row = row.data()[0];
          id_barang = row.data()[1];
          ur_barang = row.data()[2];
          managedata = "delbarang";
          job=confirm("Anda yakin ingin menghapus data ini?");
            if(job!=true){
              return false;
            }
            else{
              $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
              });
              $('#myModal').modal('show');
              $.ajax({
                type: "post",
                url : "../core/barang/prosesbarang",
                data: {manage:managedata,id:id_row,idbrg:id_barang,urbrg:ur_barang},
                success: function(data)
                {
                  $("#success-alert").alert();
                  $("#success-alert").fadeTo(500, 500).slideUp(500, function(){
                  $("#success-alert").alert('close');
                  });
                  setTimeout("$('#myModal').modal('hide');",redirectTime);
                  $("#example1").DataTable().destroy();
                  $("#example1 tbody").empty();
                  myTable();
                }
              });
              return false;
            }
          });
      });
       $.ajax({
          type: "post",
          url: '../core/barang/prosesbarang',
          data: {manage:'readbarang'},
          success: function (output) {     
            $('#kdbarang_no').html(output);
          }
       });
      function format ( d ) {
        return '<div class="slider">'+
        '<form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="updbarang">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updsubbarang">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<td width="15.8%"><input style="width:95%" id="kdbarang'+d[0]+'" name="updkdbarang" class="form-control" type="text" placeholder="Kode Barang"></td>'+
              '<td width="44.2%"><input style="width:98.2%" id="urbarang'+d[0]+'" name="updurbarang" class="form-control" type="text" placeholder="Uraian Barang"></td>'+
              '<td><input style="width:94%" id="spesifikasi'+d[0]+'" name="updspesifikasi" class="form-control" type="text" placeholder="Spesifikasi"></td>'+
              '<td><input style="width:94%" id="satuan'+d[0]+'" name="updsatuan" class="form-control" type="text" placeholder="Satuan"></td>'+
              '<td style="vertical-align:middle; width:15%;">'+
                '<div class="box-tools">'+
                  '<button id="btnrst" class="btn btn-flat btn-sm btn-warning btn-sm pull-left" type="reset"><i class="fa fa-refresh"></i> Reset</button>'+
                  '<button id="btnupd" class="btn btn-flat btn-sm btn-primary btn-sm pull-right"><i class="fa fa-upload"></i> Update</button>'+
                '</div>'
              '</td>'+
           '</tr>'+
        '</table>'+
        '</form></div>';  
      }

      function ubh_jns ( d ) {
        return '<div class="slider">'+
        '<form action="../core/barang/prosesbarang" method="post" class="form-horizontal" id="updjenis">'+
        '<table width="100%">'+
           '<tr>'+
              '<input type="hidden" name="manage" value="updjenisbrg">'+
              '<input type="hidden" name="id" value="'+d[0]+'">'+
              '<input type="hidden" name="kodebarang" value="'+d[1]+'">'+
              '<input type="hidden" name="namabarang" value="'+d[3]+'">'+
              '<input type="hidden" name="spesifikasi" value="'+d[4]+'">'+
              '<input type="hidden" name="satuan" value="'+d[5]+'">'+

              '<td width="5%">Jenis Awal</td>'+
              '<td width="25.8%"><input style="width:94%" id="satuan'+d[2]+'" name=jns_lama"updsatuan" class="form-control" type="text" value="'+d[2]+'" readonly></td>'+
              '<td width="5%">Jenis Baru</td>'+
              '<td width="50%"><select style="width:100%" name="kdbaru" id="kdbaru" class="form-control select2" ></select></td>'+
              // '<td width="20.2%"><input style="width:98.2%" id="urbarang'+d[0]+'" name="updurbarang" class="form-control" type="text" placeholder="Uraian Barang"></td>'+
              // '<td><input style="width:94%" id="spesifikasi'+d[0]+'" name="updspesifikasi" class="form-control" type="text" placeholder="Spesifikasi"></td>'+
              // '<td><input style="width:94%" id="satuan'+d[0]+'" name="updsatuan" class="form-control" type="text" placeholder="Satuan"></td>'+
              '<td style="vertical-align:middle; width:15%;">'+
                '<div class="box-tools">'+
                  // '<button id="btnrst" class="btn btn-flat btn-sm btn-warning btn-sm pull-left" type="reset"><i class="fa fa-refresh"></i> Reset</button>'+
                  '<button id="btnupd" class="btn btn-flat btn-sm btn-primary btn-sm pull-right"><i class="fa fa-upload"></i> Update</button>'+
                '</div>'
              '</td>'+
           '</tr>'+
        '</table>'+
        '</form></div>';  
      }
      $(document).on('submit', '#updjenis', function (e) {
        // $('#myModal').modal({
        //   backdrop: 'static',
        //   keyboard: false
        // });
        // $('#myModal').modal('show');
        // e.preventDefault();
        redirectTime = "1000";
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
            $("#success-alert").fadeTo(500, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
            });
            setTimeout("$('#myModal').modal('hide');",redirectTime);
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            myTable();
          }
        });
        return false;
      });

      $(document).on('submit', '#updbarang', function (e) {
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "1000";
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
            $("#success-alert").fadeTo(500, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
            });
            setTimeout("$('#myModal').modal('hide');",redirectTime);
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            myTable();
          }
        });
        return false;
      });
      $('#addbarang').submit(function(e){
        if($("#kdbarang_no").val()=="")
        {
          alert("Kode Nomor Barang Belum di Pilih");
          return false;
        }
        if($("#kdbarang").val()=="")
        {
          alert("Kode Barang Belum di Input");
          return false;
        }
        if($("#nmbarang").val()=="")
        {
          alert("Nama Barang Belum di Input");
          return false;
        }
        if($("#satuan").val()=="")
        {
          alert("Satuan Barang Belum di Pilih");
          return false;
        }
        else{
        $('#myModal').modal({
          backdrop: 'static',
          keyboard: false
        });
        $('#myModal').modal('show');
        e.preventDefault();
        redirectTime = "1000";
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
            $("#success-alert").fadeTo(500, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
            });
            setTimeout("$('#myModal').modal('hide');",redirectTime);
            $("#example1").DataTable().destroy();
            $("#example1 tbody").empty();
            myTable();
          }
        });
        return false;
        }
      });
    </script>
  </body>
</html>
