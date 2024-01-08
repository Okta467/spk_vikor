<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data User - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('sekretaris_desa/_partials/head') ?>
</head>

<body class="nav-md">
  <!--============================== CONTAINER ==============================-->
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('sekretaris_desa/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('sekretaris_desa/_partials/v_header');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== CONTENT ==============================-->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <ul class="breadcrumb">
                <li><i class="fa fa-home"></i> <a href="">Home</a></li>
                <li><a href="#">Data Users</a></li>
              </ul>
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
                  <h2>User Report <small>Activity report</small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown" style="visibility: hidden;">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content" style="display: block;">
            
                  <!-- PROFILE INFO -->
                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <img class="img-responsive avatar-view" src="<?= base_url("assets/images/picture.jpg") ?>" alt="Avatar" title="Change the avatar">
                      </div>
                    </div>
                    <h3><?= $user->nama_pemilik ?></h3>
                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-map-marker user-profile-icon"></i> Dusun: <?= $user->dusun ?? '(Tidak Ada)' ?>, RT: <?= $user->rt ?? '(Tidak Ada)' ?></li>
                      <li><i class="fa fa-briefcase user-profile-icon"></i> <?= ucfirst($user->hak_akses) ?></li>
                    </ul>
                  </div>
                  <!--// END PROFILE INFO -->
            
                  <!-- PANEL UBAH INFORMASI PROFILE -->
                  <div class="col-md-6 col-sm-9 col-xs-12 col-md-offset-1">
                    <div class="x_panel">
                      <div class="x_content" style="display: block;">
            
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                          <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
                            <li role="presentation" class=""><a href="#tab_content11" id="home-tabb" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false"><i class="fa fa-key"></i> Ubah Kata Sandi</a></li>
                            <li role="presentation" class="active"><a href="#tab_content22" role="tab" id="profile-tabb" data-toggle="tab" aria-controls="profile" aria-expanded="true"><i class="fa fa-user"></i> Ubah Detail Profile</a></li>
                          </ul>
                          <div id="myTabContent2" class="tab-content">
            
            
                            <!-- UBAH KATA SANDI -->
                            <div role="tabpanel" class="tab-pane fade" id="tab_content11" aria-labelledby="home-tab">
                              <form method="POST" class="form-horizontal form-label-left input_mask" action="<?= site_url('sekretaris_desa/profile/change_password') ?>">
            
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input type="password" name="xcurrent_password" autocomplete="current-password" class="form-control has-feedback-left" id="xcurrent_password" placeholder="Password Saat Ini">
                                  <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                </div>
            
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input type="password" name="xnew_password" autocomplete="new-password" class="form-control has-feedback-left" id="xnew_password" placeholder="Password Baru">
                                  <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                </div>
            
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input type="password" name="xnew_password2" autocomplete="new-password" class="form-control has-feedback-left" id="xnew_password2" placeholder="Ketik ulang password baru">
                                  <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                </div>
            
                                <div class="ln_solid"></div>
                                
                                <div class="form-group">
                                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
                                  </div>
                                </div>
            
                              </form>
                            </div>
                            <!--//END UBAH KATA SANDI -->
            
            
                            <!-- UBAH DETAIL PROFILE -->
                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content22" aria-labelledby="profile-tab">
                              <form method="POST" class="form-horizontal form-label-left input_mask" action="<?= site_url('sekretaris_desa/profile/change_profile_details') ?>">
            
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input type="text" name="xnama_pemilik" class="form-control has-feedback-left" id="xnama_pemilik" placeholder="Nama Pemilik">
                                  <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                                </div>
            
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                  <input type="password" name="xcurrent_password" autocomplete="current-password" class="form-control has-feedback-left" id="xcurrent_password" placeholder="Password Saat Ini">
                                  <span class="fa fa-key form-control-feedback left" aria-hidden="true"></span>
                                </div>
            
                                <div class="ln_solid"></div>
                                
                                <div class="form-group">
                                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="button" class="btn btn-primary">Cancel</button>
                                    <button class="btn btn-primary" type="reset">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                  </div>
                                </div>
            
                              </form>
                            </div>
                            <!--//UBAH DETAIL PROFILE -->
            
                          </div>
                        </div>
            
                      </div>
                    </div>
                  </div>
                  <!--//END PANEL UBAH INFORMASI PROFILE -->
            
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!--//END CONTENT -->

      <!--============================== FOOTER ==============================-->
      <?php
      $this->load->view('sekretaris_desa/_partials/v_footer');
      ?>
      <!--//END FOOTER -->

    </div>
  </div>
  <!--//END CONTAINER -->

  <?php $this->load->view('sekretaris_desa/_partials/script') ?>


  <!--============================== NOTIFY ==============================-->
  <?php
  $this->load->view('sekretaris_desa/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>