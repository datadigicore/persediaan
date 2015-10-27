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