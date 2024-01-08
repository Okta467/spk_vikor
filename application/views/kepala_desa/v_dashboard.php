<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Dashboard - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('kepala_desa/_partials/head') ?>
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('kepala_desa/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('kepala_desa/_partials/v_header');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== CONTENT ==============================-->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Dashboard</h3>
            </div>
            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix"></div>
          
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Dashboard <small><?= ucfirst($hak_akses) ?></small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a></li>
                        <li><a href="#">Settings 2</a></li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <p><?= "Selamat datang, <strong>{$nama_pemilik}</strong>, sebagai <strong>{$hak_akses}</strong>." ?></p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!--//END CONTENT -->

      <!--============================== FOOTER ==============================-->
      <footer>
        <div class="pull-right">
          Copyright &copy; <?= date("Y") ?> by <a href="#">SPK Vikor APP</a>
        </div>
        <div class="clearfix"></div>
      </footer>
      <!--//END FOOTER -->

    </div>
  </div>

  <?php $this->load->view('kepala_desa/_partials/script') ?>

</body>

</html>