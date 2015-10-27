function loadScript(url, callback)
{
  var head = document.getElementsByTagName('head')[0];
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = url;
  script.onreadystatechange = callback;
  script.onload = callback;
  head.appendChild(script);
} 
var changeScript = function() {
};
function ajaxSatker(){
  $("#satker").select2({
  placeholder: "-- Pilih Kode Item Barang --",
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
};
function setActive(change){
if (change[0] == "Laporan Persediaan") {
  $("#lp").css({"border-left":"4px solid #00c0ef"});
  $("#rp").css({"border-left":""});
  $("#pp").css({"border-left":""});
  $("#mp").css({"border-left":""});
}
else if (change[0] == "Rincian Persediaan") {
  $("#lp").css({"border-left":""});
  $("#rp").css({"border-left":"4px solid #00c0ef"});
  $("#pp").css({"border-left":""});
  $("#mp").css({"border-left":""});
}
else if (change[0] == "Posisi Persediaan") {
  $("#lp").css({"border-left":""});
  $("#rp").css({"border-left":""});
  $("#pp").css({"border-left":"4px solid #00c0ef"});
  $("#mp").css({"border-left":""});
}
else {
  $("#lp").css({"border-left":""});
  $("#rp").css({"border-left":""});
  $("#pp").css({"border-left":""});
  $("#mp").css({"border-left":"4px solid #00c0ef"});
};
};