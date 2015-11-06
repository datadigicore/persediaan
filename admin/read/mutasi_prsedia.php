<form action="../core/report/prosesreport" method="post" class="form-horizontal" id="addtransmsk">
  <input type="hidden" name="manage" value="mutasi">
  <div class="box-body">
    <label class="col-sm-3 control-label">Kode Satker</label>
    <div class="col-sm-8">
      <select name="satker" id="satker" class="form-control select2">
      </select>
    </div>
  </div>
  <div class="box-body" id="awal">
    <label class="col-sm-3 control-label">Tanggal Awal</label>
    <div class="col-sm-8">
      <input type="text" name="tgl_awal" class="form-control" id="tgl_awal" placeholder="" required>
    </div>
  </div>   
  <div class="box-body" id="akhir">
    <label class="col-sm-3 control-label">Tanggal Akhir</label>
    <div class="col-sm-8">
      <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="" required>
    </div>
  </div>
  <div class="box-body">
    <label class="col-sm-3 control-label">Format laporan</label>
    <div class="col-sm-8">
      <select name="format" id="format" class="form-control">
        <option value="pdf">PDF</option>
        <option value="excel">Excel</option>
      </select>
    </div>
  </div>  
  <div class="box-footer">
    <button type="submit" class="btn btn-info pull-right">Submit</button>
  </div> 
</form>
<script type="text/javascript">
    var table;
      $(function () {
        $(".treeview").addClass("active");
        $("li#mutasi_prsedia").addClass("active");
        $('#tgl_awal').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_akhir').datepicker({
          format: "dd-mm-yyyy"
        });             
      });

        $("#satker").select2({
          placeholder: "-- Masukkan Kode Satker --",
          ajax: {
            url: '../core/report/prosesreport',
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: function (params) {
              return {
                manage:'baca_satker_admin',
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

      $('form').on('submit', function() {
        var D1a = document.getElementById("tgl_awal").value;
        var D2a = document.getElementById("tgl_akhir").value;

        var arrD1 = D1a.split("-");
        var arrD2 = D2a.split("-");

        var D1b = [arrD1[2],arrD1[1],arrD1[0]];
        var D2b = [arrD2[2],arrD2[1],arrD2[0]];

        var D1 = D1b.join("/");
        var D2 = D2b.join("/");

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