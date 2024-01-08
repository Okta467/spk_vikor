<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Data Dusun - {$this->config->config["webTitle"]}" ?></title>

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
                <li><a href="#">Data Dusun</a></li>
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
                  <h2><i class="fa fa-building"></i> Data Dusun</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <table class="table table-striped table-bordered jambo_table datatables">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Daftar RT</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      $no = 1;
                      foreach ($dusuns->result() as $dusun) :
                      ?>

                        <tr>
                          <td><?= $no++ ?></td>
                          <td><?= $dusun->nama ?></td>
                          <td><?= $dusun->alamat ?></td>
                          <td>
                            <button class="btn btn-dark btn-sm toggle_modal_daftar_rt" data-dusun_id="<?= $dusun->id ?>">
                              <i class="fa fa-list"></i> Detail
                            </button>
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
      $this->load->view('sekretaris_desa/_partials/v_footer');
      ?>
      <!--//END FOOTER -->

    </div>
  </div>
  <!--//END CONTAINER -->

  <!--============================== MODAL DAFTAR RT ==============================-->
  <div class="modal fade" id="modal_daftar_rt" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2"><i class="fa fa-list"></i> Daftar RT</h4>
        </div>
        <div class="modal-body">

          <h4 id="modal_daftar_rt_title"></h4>

          <table class="table table-striped table-bordered jambo_table" id="modal_daftar_rt_table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nomor RT</th>
                <th>Alamat</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  <!--//END DAFTAR RT -->

  <?php $this->load->view('sekretaris_desa/_partials/script') ?>

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
            
      var datatableModalDaftarRt = $('#modal_daftar_rt_table').DataTable({
        fixedHeader: true,
        pageLength: 5,
        lengthMenu: [
          [3, 5, 10, 25, 50, 100],
          [3, 5, 10, 25, 50, 100],
        ]
      });


      $('.datatables').on('click', '.toggle_modal_daftar_rt', function () {
        const dusun_id = $(this).data('dusun_id');

        $.ajax({
          url: '<?= site_url('sekretaris_desa/dusun/get_all_rt') ?>',
          type: 'POST',
          data: {
            dusun_id
          },
          dataType: 'JSON',
          success: function(data) {
            $('#modal_daftar_rt_title').html(data.dusun);

            // add datatables row
            let i = 1;
            let rowsData = [];

            for (key in data) {
              rowsData.push([i++, data[key]['rt'], data[key]['alamat_rt']]);
            }

            datatableModalDaftarRt.clear().draw();
            datatableModalDaftarRt.rows.add(rowsData).draw();

            $('#modal_daftar_rt').modal('show');            
          }
        })
      });
    })
  </script>


  <!--============================== NOTIFY ==============================-->
  <?php
  $this->load->view('sekretaris_desa/_partials/notify');
  ?>
  <!--//END NOTIFY -->

</body>

</html>