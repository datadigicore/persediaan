      <aside class="main-sidebar">
        <section class="sidebar">
          <ul class="sidebar-menu">
            <li class="header">PENGELOLAAN</li>
            <li id="index"><a href="index"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <!-- <li id="barang"><a href="barang"><i class="fa fa-table"></i> <span>Barang Persediaan</span></a></li> -->
            <li id="status_laporan"><a href="status_laporan"><i class="fa fa-book"></i> <span>Status Laporan</span></a></li>
            <li id="tnda_tangan"><a href="tndtgn"><i class="fa fa-check-square-o"></i> <span>Penandatanganan</span></a></li>
            <li id="trans_masuk"><a href="trans_masuk"><i class="fa fa-compress"></i> <span>Transaksi Masuk</span></a></li>
            <li id="trans_keluar"><a href="trans_keluar"><i class="fa fa-expand"></i> <span>Transaksi Keluar</span></a></li>
            <li id="transfer"><a href="transfer"><i class="fa fa-exchange"></i> <span>Transfer Persediaan</span></a></li>
            <li id="opname"><a href="opname"><i class="fa fa-cubes"></i> <span> Stock Opname</span></a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-file-text-o"></i> <span>Laporan</span> <i class="fa fa-angle-left pull-right"></i></a>            
              <ul class="treeview-menu">
                <li id="l_buku_bph"><a href="l_buku_bph"><span>Buku Barang Pakai Habis</span></a></li>
                <li id="l_pp_bph"><a href="l_pp_bph"><span>Penerimaan & Pengeluaran</span></a></li>
                <li id="ba_opname"><a href="ba_opname"><span>Berita Acara Stock Opname</span></a></li>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i> <span>Saldo Persediaan</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="lap_sedia"><a href="lap_persediaan"><span>Laporan Persediaan</span></a></li>
                <li id="rincian_persediaan"><a href="rincian_persediaan"><span>Rincian Persediaan</span></a></li>
                <li id="neraca"><a href="neraca"><span>Posisi Persediaan</span></a></li>
              </ul>
            </li>


            <li class="treeview">
              <a href="#">
                <i class="fa fa-list-alt"></i> <span>Belanja Persediaan</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="rekap_rekening"><a href="rekap_rekening"><span>Rekap Persediaan Per Rekening</span></a></li>
                <li id="rekap_rekening2"><a href="rekap_rekening2"><span>Belanja Persediaan 2</span></a></li>
                <li id="rekap_per_dok"><a href="rekap_per_dok"><span>Rekap Persediaan Per Dokumen</span></a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-sign-in"></i> <span>Penerimaan Barang</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="l_terima_brg"><a href="l_terima_brg"><span>Buku Penerimaan Barang</span></a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-external-link"></i> <span>Pengeluaran Barang</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="l_keluar_brg">
                  <a href="l_keluar_brg"><span>Buku Pengeluaran Barang</span></a>
                </li>
                <li id="surat_permintaan_barang">
                  <a href="surat_permintaan_barang"><span>Surat Permintaan Barang</span></a>
                </li>
                <li id="surat_penyaluran_barang">
                  <a href="surat_penyaluran_barang"><span>Surat Penyaluran Barang</span></a>
                </li>
                <li id="bukti_pengambilan_barang">
                  <a href="bukti_pengambilan_barang"><span>Bukti Pengambilan Barang</span></a>
                </li>
              </ul>
            </li>
            
            
            <li class="treeview">
              <a href="#">
                <i class="fa fa-credit-card"></i> <span>Kartu Per Barang</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li id="l_kartu_brg"><a href="l_kartu_brg"><span>Kartu Barang</span></a></li>
                <li id="l_kartu_p_brg"><a href="l_kartu_p_brg"><span>Kartu Persediaan Barang</span></a></li>
              </ul>
            </li>
        
          </ul> 
        </section>
      </aside>
      <script src="../plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
      <script type="text/javascript">
        $.ajax({
          type: "post",
          url: '../core/import/prosesimport',
          data: {manage:'cekTransaksi'},
          success: function (output) {   
            $(output).insertAfter("#tnda_tangan");
          }
        });
      </script>
