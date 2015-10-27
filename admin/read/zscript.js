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