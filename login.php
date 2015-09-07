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
            <input type="text" name="username" class="form-control" placeholder="Username" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>          
          <div class="row">
            <div class="col-xs-8"> 
              <div class="form-group has-feedback">
                <input id="thn_ang" name="thn_ang" class="form-control"placeholder="Tahun Anggaran"/>
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
    <script type="text/javascript" src="dist/js/jquery.validate.min.js"></script>
    <script type="text/javascript">
      var thisyear = new Date().getFullYear();
      document.getElementById("thn_ang").value = thisyear;
      (function($,W,D){
        var JQUERY4U = {};
        JQUERY4U.UTIL = {
          setupFormValidation: function()
          {
            $("#login-form").validate({
              rules: {
                username: "required",
                password: "required",
                thn_ang: {
                  required: true,
                  number: true
                }
              },
              messages: {
                  name: { required: "Custom Message" }
              },
              errorPlacement: function (error, element) {
                $(element).css({border:"1px solid red"});
              },
              success: function (label, element) {
                $(element).css({border:"1px solid #ccc"});
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
              