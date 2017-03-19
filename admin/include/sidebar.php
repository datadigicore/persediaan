      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <?php foreach ($_SESSION['menu'] as $key => $value) { ?>
            <li class="treeview">
            <a href="#">
                <i class="fa fa-list-alt"></i> <span><?php echo $value['nama_parent']; ?></span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php foreach ($value['list_menu'] as $key => $list) { ?>
                  <li id="<?php echo $list['nama_file']; ?>"><a href="<?php echo $list['nama_file']; ?>"><span><?php echo $list['nama_menu']; ?></span></a></li>
                <?php } ?>
                </ul>
              </li>
            <?php } ?>
          </ul>
        </section>
      </aside>
