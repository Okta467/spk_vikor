<?php
$user_tmp = $this->m_auth->current_user();
$formatted_hak_akses = ucwords(preg_replace('/_+/', ' ', $user_tmp->hak_akses)); // replace all underscore with space
?>

<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="<?= site_url('admin') ?>" class="site_title"><i class="fa fa-paw"></i> <span><?= $this->config->config['sidebarTitle'] ?></span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <a href="<?= site_url('kasi_kesejahteraan_sosial/profile') ?>">
          <img src="<?= base_url("assets/images/img.jpg") ?>" alt="..." class="img-circle profile_img">
        </a>
      </div>
      <div class="profile_info">
        <span>Selamat datang,</span>
        <a href="<?= site_url('kasi_kesejahteraan_sosial/profile') ?>">
          <h2><?= $formatted_hak_akses ?></h2>
        </a>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <?php
          // pemberian class spesifik karena terdapat GET
          // (template tidak bisa membaca halaman saat ini untuk templating)
          $is_penilaian_alternatif_selected = $this->uri->segment(2) === 'penilaian_alternatif' ? 'class="current-page"' : '';
          $is_hasil_perhitungan_selected = $this->uri->segment(2) === 'hasil_perhitungan' ? 'class="current-page"' : '';
          ?>

          <li><a href="<?= site_url('admin') ?>"><i class="fa fa-home"></i> Dashboard </a></li>
          <li><a href="<?= site_url('kasi_kesejahteraan_sosial/alternatif') ?>"><i class="fa fa-user-md"></i> Data Alternatif </a></li>
          <li><a href="<?= site_url('kasi_kesejahteraan_sosial/kriteria') ?>"><i class="fa fa-pencil-square-o"></i> Data Kriteria </a></li>
          <li><a href="<?= site_url('kasi_kesejahteraan_sosial/Sub_Kriteria') ?>"><i class="fa fa-pencil-square-o"></i> Data Sub-Kriteria </a></li>
          <li <?= $is_penilaian_alternatif_selected ?>>
            <a href="<?= site_url('kasi_kesejahteraan_sosial/Penilaian_Alternatif/?tahun_penilaian=' . date('Y')) ?>"><i class="fa fa-bar-chart"></i> Data Nilai </a>
          </li>
          <li <?= $is_hasil_perhitungan_selected ?>>
            <a href="<?= site_url('kasi_kesejahteraan_sosial/Hasil_Perhitungan/?tahun_penilaian=' . date('Y')) ?>"><i class="fa fa-list-alt"></i> Data Hasil Perhitungan </a>
          </li>
          <li><a href="<?= site_url('kasi_kesejahteraan_sosial/dusun') ?>"><i class="fa fa-building-o"></i> Data Dusun </a></li>
          <li><a href="<?= site_url('kasi_kesejahteraan_sosial/rt') ?>"><i class="fa fa-road"></i> Data RT </a></li>
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen" id="toggle_fullscreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= site_url('auth/logout') ?>">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->

  </div>
</div>