$(".select2").select2();
$(function () {
        $('#tgl_awal').datepicker({
          format: "dd-mm-yyyy"
        });         
        $('#tgl_akhir').datepicker({
          format: "dd-mm-yyyy"
        });             
      });
      $.ajax({
          type: "post",
          url: '../core/report/prosesreport',
          data: {manage:'baca_satker_admin'},
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