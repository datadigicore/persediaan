<form action="../core/report/prosesreport" method="post" class="form-horizontal" id="addtransmsk">
   <input type="hidden" name="manage" value="neraca">
   <div class="box-body">
      <label class="col-sm-3 control-label">Kode Satker</label>
      <div class="col-sm-8">
        <select name="satker" id="satker" class="form-control select2">
        </select>
      </div>
  </div>  
  <div class="box-body">
    <label class="col-sm-3 control-label">S/d Tanggal</label>
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
        $("li#neraca").addClass("active");
        $('#tgl_awal').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_akhir').datepicker({
          format: "dd-mm-yyyy"
        });             
        $("li#mutasi_sedia").addClass("active");

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
        if(document.getElementById("satker").value=="")
        {
          alert("Kode Satker Belum Dipilih");
          return false;
        }
        else
        {
          return true;
        }
    });
</script>