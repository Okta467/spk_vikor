<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span><?= $this->config->config['sidebarTitle'] ?></span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="<?= base_url("assets/images/img.jpg") ?>" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Selamat datang,</span>
        <h2>Admin</h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <li><a href="<?= site_url('admin') ?>"><i class="fa fa-home"></i> Dashboard </a></li>
          <li><a href="<?= site_url('admin/alternatif') ?>"><i class="fa fa-user-md"></i> Data Alternatif </a></li>
          <li><a href="<?= site_url('admin/kriteria') ?>"><i class="fa fa-pencil-square-o"></i> Data Kriteria </a></li>
          <li><a href="<?= site_url('admin/sub_kriteria') ?>"><i class="fa fa-pencil-square-o"></i> Data Sub-Kriteria </a></li>
          <li><a href="<?= site_url('admin/penilaian_alternatif') ?>"><i class="fa fa-bar-chart"></i> Data Nilai </a></li>
          <li><a href="<?= site_url('admin/hasil_perhitungan') ?>"><i class="fa fa-list-alt"></i> Data Hasil Perhitungan </a></li>
          <li><a href="<?= site_url('admin/dusun') ?>"><i class="fa fa-building-o"></i> Data Dusun </a></li>
          <li><a href="<?= site_url('admin/rt') ?>"><i class="fa fa-road"></i> Data RT </a></li>
          <li><a href="<?= site_url('admin/user') ?>"><i class="fa fa-user"></i> Data Users </a></li>
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