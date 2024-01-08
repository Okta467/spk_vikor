<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Sub Kriteria - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('kepala_dusun/_partials/head') ?>
</head>

<body class="nav-md">
  <!--============================== CONTAINER ==============================-->
  <div class="container body">
    <div class="main_container">

      <!--============================== SIDEBAR ==============================-->
      <?php
      $this->load->view('kepala_dusun/_partials/v_sidebar');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== HEADER ==============================-->
      <?php
      $this->load->view('kepala_dusun/_partials/v_header');
      ?>
      <!--//END SIDEBAR -->

      <!--============================== CONTENT ==============================-->
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <ul class="breadcrumb">
                <li><i class="fa fa-home"></i> <a href="">Home</a></li>
                <li><a href="#">Data Sub Kriteria</a></li>
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
                  <h2><i class="fa fa-pencil-square-o"></i> Data Sub Kriteria</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Kode Sub</th>
                        <th>Nama Sub</th>
                        <th>Skor Sub</th>
                        <th>Kode Kriteria</th>
                        <th>Nama Kriteria</th>
                        <th>Atribut Kriteria</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($sub_kriterias->result() as $sub_kriteria) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $sub_kriteria->kode_sub_kriteria ?></td>
                          <td><?= $sub_kriteria->nama_sub_kriteria ?></td>
                          <td><?= $sub_kriteria->skor_sub_kriteria ?></td>
                          <td><?= $sub_kriteria->kode_kriteria ?></td>
                          <td><?= $sub_kriteria->nama_kriteria ?></td>
                          <td>
                            <?php
                            if ($sub_kriteria->atribut_kriteria === 'benefit') :
                              echo '<span class="badge alert-success">' . strtoupper($sub_kriteria->atribut_kriteria) . '</span>';
                            elseif ($sub_kriteria->atribut_kriteria === 'cost') :
                              echo '<span class="badge alert-danger">' . strtoupper($sub_kriteria->atribut_kriteria) . '</span>';
                            endif;
                            ?>
                          </td>
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
      $this->load->view('kepala_dusun/_partials/v_footer');
      ?>
      <!--//END FOOTER -->

    </div>
  </div>
  <!--//END CONTAINER -->

  <?php $this->load->view('kepala_dusun/_partials/script') ?>

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
  $this->load->view('kepala_dusun/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>