      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <li class="header">PENGOLAHAN&nbsp;&nbsp;&nbsp;DATA</li>
            <li id="index"><a href="index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
<?php if(strpos($_SESSION['akses_menu'],"1")!==false ) { ?>
            <li id="skpd"><a href="sektor"><i class="fa fa-table"></i> <span>Tabel SKPD</span></a></li>
<?php } ?>
<?php if(strpos($_SESSION['akses_menu'],"2")!==false ) { ?>
            <li id="konfig"><a href="konfig"><i class="fa fa-gear"></i> <span>Konfigurasi SKPD</span></a></li>
<?php } ?>
<?php if(strpos($_SESSION['akses_menu'],"4")!==false ) { ?>
            <li id="usulan_transfer"><a href="usulan_transfer"><i class="fa  fa-arrows-h"></i> <span>Usulan Transfer</span></a></li>
<?php } ?>
<?php if(strpos($_SESSION['akses_menu'],"5")!==false ) { ?>
            <li id="refresh"><a href="refresh_new"><i class="fa  fa-refresh"></i> <span>Refresh</span></a></li>
<?php } ?>
<?php if(strpos($_SESSION['akses_menu'],"6")!==false ) { ?>
            <li id="user"><a href="user"><i class="fa fa-user"></i> <span>Tambah Pengelola</span></a></li>
<?php } ?>
<?php if(strpos($_SESSION['akses_menu'],"7")!==false ) { ?>
            <li id="laporan"><a href="report"><i class="fa fa-file-text-o"></i> <span>Laporan SKPD</span></a></li>
<?php } ?>
<?php if(strpos($_SESSION['akses_menu'],"9")!==false ) { ?>
            <li id="trans_masuk"><a href="trans_masuk"><i class="fa  fa-file-excel-o "></i> <span>Import Trans Masuk</span></a></li>
<?php } ?>
<?php if(strpos($_SESSION['akses_menu'],"10")!==false ) { ?>
            <li id="trans_keluar"><a href="trans_keluar"><i class="fa  fa-file-excel-o "></i> <span>Import Trans Keluar</span></a></li>
<?php } ?>

            <li class="treeview">
              <a href="#"><i class="fa fa-link"></i> <span>Lain-Lain</span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <li id="rekbar"><a href="rekbar">Tabel Nama Rekening Barang</a></li>
                <li id="subkelbar"><a href="subkelbar">Tabel Sub Kelompok Barang</a></li>
                <li id="koderek"><a href="koderek">Tabel Kode Rekening Akuntansi</a></li>
              </ul>
            </li>
          </ul>
        </section>
      </aside>
