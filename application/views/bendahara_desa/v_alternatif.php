<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Alternatif - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('bendahara_desa/_partials/head') ?>
</head>

<body class="nav-md">
  <!--============================== CONTAINER ==============================-->
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('bendahara_desa/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('bendahara_desa/_partials/v_header');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== CONTENT ==============================-->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <ul class="breadcrumb">
                <li><i class="fa fa-home"></i> <a href="">Home</a></li>
                <li><a href="#">Data Alternatif</a></li>
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
                  <h2><i class="fa fa-user-md"></i> Data Alternatif</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Dusun</th>
                        <th>RT</th>
                        <th>KK Kepala Keluarga</th>
                        <th>NIK Kepala Keluarga</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Alamat</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($alternatifs->result() as $alternatif) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $alternatif->kode_alternatif ?></td>
                          <td><?= $alternatif->dusun ?></td>
                          <td><?= $alternatif->rt ?></td>
                          <td><?= $alternatif->kk_kepala_keluarga ?></td>
                          <td><?= $alternatif->nik_kepala_keluarga ?></td>
                          <td><?= $alternatif->nama_kepala_keluarga ?></td>
                          <td><?= $alternatif->alamat_alternatif ?></td>
                        </tr>

                      <?php endforeach; ?>

                    </tbody>
                  </table>

                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
      <!--//END CONTENT -->

      <!--============================== FOOTER ==============================-->
      <?php
      $this->load->view('bendahara_desa/_partials/v_footer');
      ?>
      <!--//END FOOTER -->

    </div>
  </div>
  <!--//END CONTAINER -->

  <?php $this->load->view('bendahara_desa/_partials/script') ?>

  <script>
    $(document).ready(function() {
      // Datatables initialise
      $('.datatables').DataTable({
        fixedHeader: true,
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });
    })
  </script>


  <!--============================== NOTIFY ==============================-->
  <?php
  $this->load->view('bendahara_desa/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>