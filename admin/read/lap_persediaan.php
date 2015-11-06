
<form action="../core/report/prosesreport" method="post" class="form-horizontal" id="addtransmsk">
  <input type="hidden" name="manage" value="lap_persediaan">  
  <div class="box-body">
    <label class="col-sm-3 control-label">Kode Satker</label>
    <div class="col-sm-8">
      <select name="satker" id="satker" class="form-control select2">
      </select>
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
  <div class="box-body radio">
      <div class="col-md-3"></div>
      <div class="col-md-8">
        <label class="col-sm-4 control-label"><input type="radio" name="jenis" id="tanggal" value="tanggal">S/d Tanggal</label>
        <label class="col-sm-4 control-label"><input type="radio" name="jenis" id="semester" value="semester">Semester</label>
        <label class="col-sm-4 control-label"><input type="radio" name="jenis" id="tahun" value="tahun" checked>Tahun </label>
      </div>
  </div>                                       
  <div class="box-body" id="akhir"  style="display: none;">
    <label class="col-sm-3 control-label">S/d Tanggal</label>
    <div class="col-sm-8">
      <input type="text" name="tgl_akhir" class="form-control" id="tgl_akhir" placeholder="">
    </div>
  </div> 
  <div class="box-body" id="bln"  style="display: none;">
    <label class="col-sm-3 control-label">Semester</label>
    <div class="col-sm-3">
      <select name="smt" id="smt" class="form-control">
        <option value="01-06">Semester 1</option>
        <option value="07-12">Semester 2</option>
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
        $("li#lap_sedia").addClass("active");
        $('#tgl_awal').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_akhir').datepicker({
          format: "dd-mm-yyyy"
        });             
        $("li#saldo_awal").addClass("active");

        $("input[id=tanggal]").click(function()
        {

            $("#bln").hide();
            // $("#awal").show();
            $("#akhir").show();
            $('#tgl_akhir').prop('required',true);
        });
        $("input[id=semester]").click(function()
        {
            $("#bln").show();
            // $("#awal").hide();
            $("#akhir").hide();
            $('#tgl_akhir').removeAttr('required');
        });
        $("input[id=tahun]").click(function()
        {
            $("#bln").hide();
            // $("#awal").hide();
            $("#akhir").hide();
            $('#tgl_akhir').removeAttr('required');
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
