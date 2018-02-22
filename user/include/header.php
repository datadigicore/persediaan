	  <?php include("../config/user.php");  ?>
    <header class="main-header">
        <a href="index" class="logo">
          <span class="logo-mini"><b>A</b>LT</span>
          <span class="logo-lg"><img src="../dist/img/icon2.png" width="29px;" style="margin-top:-2px;"> <b>SIMSEDIA</b></span>
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../dist/img/adminpic2.png" class="user-image" alt="User Image" />
                  <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="user-header">
                    <img src="../dist/img/adminpic2.png" class="img-circle" alt="User Image" />
                    <p>
                    <?php echo $_SESSION['username']; ?> - SIMSEDIA
                      <small><?php echo $_SESSION['kd_lok'].'<br>'.$_SESSION['nama_satker']." - ".$_SESSION['nm_ruang']; ?></small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="../user/ubah_pwd" class="btn btn-default btn-flat">Ubah Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="../logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header> 
