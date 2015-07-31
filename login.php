<?php include("config/verify.php"); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Aplikasi Persediaan</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="dist/img/icon.png" type="image/x-icon">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]--> 
  </head>
  <header>
  	<div class="headernya">
  		<div class="login-logo">
        	<img src="dist/img/icon.png" width="70px;">&nbsp;&nbsp;<b>CPanel</b> Aplikasi Persediaan</a>
      	</div>
  	</div>
  </header>
  <body class="login-page">
    <div class="login-box">
      <div class="login-box-body">
        <p class="login-box-msg">Silahkan isi Username dan Password</p>
        <form action="config/authenticate" method="post">
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
                <select id="thn_ang" name="thn_ang" class="form-control">
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
    <?php include("include/loadjs.php"); ?>
    <script type="text/javascript">
      var start = new Date().getFullYear()-1;
      var end = new Date().getFullYear()+1;
      var options ="<option>-- Tahun Anggaran --</option>";
      for(var year = start ; year <= end; year++)
      {
        options += "<option>"+year+"</option>";
      }
      document.getElementById("thn_ang").innerHTML = options;
    </script>
  </body>
</html>
              