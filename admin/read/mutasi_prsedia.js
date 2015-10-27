ajaxSatker();
$(function () {
    $('#tgl_awal').datepicker({
      format: "dd-mm-yyyy"
    });         
    $('#tgl_akhir').datepicker({
      format: "dd-mm-yyyy"
    });             
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