$(".select2").select2({
  placeholder: "Pilih Kode Satker",
  allowClear: true
});
$(function () {
    $('#tgl_awal').datepicker({
      format: "dd-mm-yyyy"
    });         
    $('#tgl_akhir').datepicker({
      format: "dd-mm-yyyy"
    });             
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
   $.ajax({
      type: "post",
      url: '../core/report/prosesreport',
      data: {manage:'baca_satker'},
      success: function (output) {     
        $('#satker').html(output);
      }
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