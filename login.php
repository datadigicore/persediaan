<?php include("config/verify.php"); ?>
<!DOCTYPE html>
<html>
  <head>
    <?php include("include/loadcss.php"); ?>
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
          <div class="form-group has-feedback">
            <select id="thn_ang" name="thn_ang" class="form-control">
              <option value="">-- Pilih Tahun Anggaran --</option>
            </select>
          </div>
          <div class="row">
            <div class="col-xs-8"> 
            </div>
            <div class="col-xs-4">
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
      var start = 1990;
      var end = new Date().getFullYear();
      var options ="";
      for(var year = start ; year <= end; year++)
      {
          options += "<option>"+ year + "</option>";
      }
      document.getElementById("thn_ang").innerHTML = options;
    </script>
  </body>
</html>
              