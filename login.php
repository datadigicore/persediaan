<?php include("config/verify.php"); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SIMSEDIA Pekalongan</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="dist/img/icon2.png" type="image/x-icon">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
  </head>
  <header>
  	<div class="headernya">
  		<div class="login-logo">
        	<img src="dist/img/icon2.png" width="70px;">&nbsp;&nbsp; SIMSEDIA PEKALONGAN</a>
      	</div>
  	</div>
  </header>
  <body class="login-page">
    <div class="login-box">
      <div class="login-box-body">
        <p class="login-box-msg">Silahkan isi Username dan Password</p>
        <form action="config/authenticate" method="post" id="login-form">
          <div class="form-group has-feedback">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>          
          <div class="row">
            <div class="col-xs-8"> 
              <div class="form-group has-feedback">
                <select id="thn_ang" name="thn_ang" class="form-control select2">
                  <option selected="selected">-- Pilih Tahun Anggaran --</option>
                </select>
              </div>
            </div>
            <div class="col-xs-4" style="padding-left:0;">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <footer class="footernih">
    	<div class="footernya">
	  		<b>Copyright &copy; 2015</b> Team Gunadarma. All Rights Reserved.
	  	</div>
    </footer>
    <script type="text/javascript" src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="dist/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="dist/js/jquery-validate.bootstrap-tooltip.min.js"></script>
    <script src="plugins/select2/select2.full.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      if ($('#username').val() != null) {
        var keyword = $('#username').val();
        $.ajax({
          url: 'core/login/proseslogin',
          type: 'POST',
          data: {keyword:keyword,manage:'check_tahun'},
          success:function(data){
             $('#thn_ang').html(data);
          }
        });
      }
      function searchuser() {
        var keyword = $('#username').val();
        $.ajax({
          url: 'core/login/proseslogin',
          type: 'POST',
          data: {keyword:keyword,manage:'check_tahun'},
          success:function(data){
             $('#thn_ang').html(data);
          }
        });   
      }
      $(function () {
        $(".select2").select2();
      });
      (function($,W,D){
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
          setupFormValidation: function()
          {
            $("#login-form").validate({
              rules: {
                username: "required",
                password: "required",
                thn_ang: {required:true,
                          number : true}
              },
              messages: {
                  username: { required: "Masukkan Username" },
                  password: { required: "Masukkan Password" },
                  thn_ang : { required: "Masukkan Tahun Anggaran",
                              number : "Pilih Tahun Anggaran" }
              },
              submitHandler: function(form) {
                form.submit();
              }
            });
          }
        }
        $(D).ready(function($) {
            JQUERY4U.UTIL.setupFormValidation();
        });
      })(jQuery, window, document);
    </script>
  </body>
</html>
              